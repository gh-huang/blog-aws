<?php $this->load->view('layout/topNav.php'); ?>

<div class="container">
    <ul class="breadcrumb">
    	<li><a href="<?=site_url('WelcomeController')?>">首页</a></li>
    	<li><a href="<?=site_url('UserController/userList')?>">用户管理</a></li>
		<li class="active">新增用户</li>
	</ul>        

	<div class="site-contact">
		<h2>新增用户</h2>
		<div class="row">
			<div class="col-lg-5">
				<form id="contact-form" action="<?=site_url('UserController/userCreate')?>" method="post">
					<div class="form-group field-contactform-name required">
						<label class="control-label" for="post-title">用户名</label>
						<input type="text" id="post-title" class="form-control" name="User[username]" maxlength="128" value="<?=set_value('User[username]')?>" />
						<?php $error = form_error('User[username]'); ?>
				        <span style="color:#F00;font-weight:bold;"><?=$error?></span>

						<div class="help-block"></div>
					</div>

					<div class="form-group field-contactform-name required">
						<label class="control-label" for="post-title">密  码</label>
						<input type="text" id="post-title" class="form-control" name="User[password]" maxlength="128" value="<?=set_value('User[password]')?>" />
						<?php $error = form_error('User[password]'); ?>
				        <span style="color:#F00;font-weight:bold;"><?=$error?></span>

						<div class="help-block"></div>
					</div>

					<div class="form-group field-contactform-name required">
						<label class="control-label" for="post-title">确认密码</label>
						<input type="text" id="post-title" class="form-control" name="User[passconf]" maxlength="128" value="<?=set_value('User[password]')?>" />
						<?php $error = form_error('User[passconf]'); ?>
				        <span style="color:#F00;font-weight:bold;"><?=$error?></span>

						<div class="help-block"></div>
					</div>

					<div class="form-group field-contactform-name required">
						<label class="control-label" for="post-title">邮  箱</label>
						<input type="text" id="post-title" class="form-control" name="User[email]" maxlength="128" value="<?=set_value('User[email]')?>" />
						<?php $error = form_error('User[email]'); ?>
				        <span style="color:#F00;font-weight:bold;"><?=$error?></span>

						<div class="help-block"></div>
					</div>				
	                <div class="form-group field-contactform-verifycode">
	                    <label class="control-label" for="contactform-verifycode">验证码:</label>
	                    <div class="row">
	                        <div class="col-lg-6"><input type="text" id="contactform-verifycode" class="form-control" name="User[code]">
	                        </div>
	                        <div class="col-lg-3"><img id="contactform-verifycode-image" src="<?=site_url('UserController/getCaptcha')?>" alt="" style="cursor: pointer" onclick="this.src='<?=site_url('UserController/getCaptcha')?>#'+Math.random()" />
	                        </div>
	                    </div>
	                    <p class="help-block help-block-error">
	                        <?php $error = form_error('User[code]'); ?>
	                        <span style="color: #F00;font-weight:bold;"><?=$error?></span>
	                    </p>
	                    <div class="help-block"></div>
	                </div>				
					
					<div class="form-group">
					    <button type="submit" class="btn btn-primary"> 修 改 </button>    
					</div>
				</form>
			</div>
		</div>
	</div>
</div>



</div>
<?php $this->load->view('layout/foot'); ?>