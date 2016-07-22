<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WelcomeController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	//主页
	public function index()
	{
		$this->load->model('PostModel','pm');
		$data = $this->pm->lst();
		$this->load->model('TagModel','tm');
		$tag = $this->tm->search();
		$data['tags']['tags'] = $tag;
		// var_dump($data['data']->result());die;
		$this->load->model('CommentModel', 'cm');
		$comment = $this->cm->newCom();
		$commentNum = $this->cm->totalCom($data['data']);
		$data['num'] = $commentNum;
		$data['comments']['comment'] = $comment->result();
		// var_dump($data);die;
		$this->load->model('CategoryModel', 'ca');
		$data['categorys']['tree'] = $this->ca->categoryString();
		// var_dump($data['categorys']['tree']);die;
		$this->load->view('blog', $data);
	}

	//日志详情页面
	public function detail() {
		$this->load->model('PostModel', 'pm');
		$data = $this->pm->find($this->input->get('id'));
		// $data['tags'] = null;
		$this->load->model('TagModel','tm');
		$tag = $this->tm->search();
		$data['tag']['tags'] = $tag;
		// var_dump($data);die;
		$this->load->model('CommentModel', 'cm');
		$comments = $this->cm->newCom();
		$data['comments']['comment'] = $comments->result();
		$data['num'] = $this->cm->commentNum($this->input->get('id'));
		// var_dump($data);die;
		$this->load->view('detail', $data);
	}

	//会员注册
	public function register(){
		$this->load->library('form_validation');
		if ($this->form_validation->run('register') === FALSE) {
			$this->load->view('register');
		} else {
			$this->load->model('UserModel','um');
			$data = $this->um->create();
			if ($data) {
				$sessionData = array(
					'id' => $data['id'],
					'username' => $data['username'],
				);
				$this->session->set_userdata($sessionData);
				$this->session->set_tempdata($sessionData, NULL, 50000);
				echo '<p>测试注册成功，页面被宝宝带走了</p><hr /><button><a href="'.site_url('welcome').'">回主页吧</a></button>';
			}
		}
	}

	//会员登录
	public function login() {
		$this->load->library('form_validation');
		if ($this->form_validation->run('login') === FALSE) {
			// var_dump($this->input->post());die;
			$data['confError'] = null;
			$this->load->view('login', $data);
		} else {
			$this->load->model('UserModel', 'um');
			if ($this->um->chkLogin()) {
				redirect(site_url('Welcome'));
			} else {
				$data['confError'] = '密码错误';
				$this->load->view('login', $data);
			}
		}
	}

	//生成验证码
	public function getCaptcha() {
		$this->load->library('captcha');
		$code = $this->captcha->getCaptcha();
		$this->session->set_userdata('code',$code);
		$this->captcha->showImg();
	}

	//会员登出
	public function logout() {
		// var_dump($_SESSION);
		session_destroy();
		// var_dump($_SESSION);die;
		redirect(site_url('Welcome'));
	}

	//检查用户名是否存在
	public function checkUsername($username) {
		// var_dump($username);die;
		$this->load->model('UserModel','um');
		if ($this->um->findUsername($username)) {
			return TRUE;
		} else {
			$this->form_validation->set_message('checkUsername','用户名不存在');
			return FALSE;
		}
	}

	//检查验证码
	public function checkCode($code) {
		$code = strtolower($code);
		$codeConf = strtolower($this->session->userdata('code'));
		if ($codeConf != $code) {
			$this->form_validation->set_message('checkCode','验证码错误');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	//ajax获取全部日志
	public function ajaxGetAllPost() {
		$this->load->model('PostModel', 'pm');
		$data = $this->pm->getPost('ajaxGetAllPost');
		$this->load->model('CommentModel', 'cm');
		$commentNum = $this->cm->totalCom($data['data']);
		$data['num'] = $commentNum;
		$data['data'] = $data['data']->result();
		echo json_encode($data);
	}

	//ajax获取tag标签日志
	public function ajaxGetTagPost() {
		$this->load->model('TagModel', 'tm');
		$this->tm->addFrequency($this->input->get('PostSearch[id]'));
		$this->load->model('PostModel', 'pm');
		$data = $this->pm->getPost('ajaxGetTagPost');
		$this->load->model('CommentModel', 'cm');
		$commentNum = $this->cm->totalCom($data['data']);
		$data['num'] = $commentNum;
		$data['data'] = $data['data']->result();
		echo json_encode($data);
	}

	//ajax获取归类文档
	public function ajaxGetCatPost() {
		$this->load->model('PostModel', 'pm');
		$data = $this->pm->getPost('ajaxGetCatPost');
		$this->load->model('CommentModel', 'cm');
		$commentNum = $this->cm->totalCom($data['data']);
		$data['num'] = $commentNum;
		$data['data'] = $data['data']->result();
		echo json_encode($data);
	}

	//ajax提交评论
	public function ajaxPushComment() {
		$this->load->library('form_validation');
		if ($this->form_validation->run('comment') === FALSE) {
			echo "";
		} else {
			$this->load->model('CommentModel','cm');
			$data = $this->cm->create();
			$data['create_time'] = date('Y-m-d H:i:s', $data['create_time']);
			echo json_encode($data);
		}
	}

	//ajax提交回复
	public function ajaxPushReply()
	{
		$this->load->library('form_validation');
		if ($this->form_validation->run('reply') === false) {
			echo "";
		} else {
			$this->load->model('ReplyModel', 'rm');
			$data = $this->rm->create();
			$data['create_time'] = date('Y-m-d H:i:s', $data['create_time']);
			echo json_encode($data);
		}
	}

	//ajax获取评论
	public function ajaxGetComment() {
		$this->load->model('CommentModel', 'cm');
		$post_id = $this->input->get('post_id');
		$data = $this->cm->getComment($post_id, 'ajaxGetComment');
		echo json_encode($data);
	}

}
