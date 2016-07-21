<?php $this->load->view('layout/topNav'); ?>

    <div class="container">
 		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<ol class="breadcrumb">
					  <li><a href="<?=site_url('welcome')?>">首页</a></li>
					  <li>文章列表</li>
					</ol>
				
					<div id="postList" class="list-view">			
					</div>

					<ul class="pagination">

					</ul>
				</div>																

				<div class="col-md-3">
					<?php $this->load->view('layout/tags', $tags); ?>						
					<?php $this->load->view('layout/comment', $comments); ?>
					<?php $this->load->view('layout/category', $categorys); ?>
				</div>
			</div>			
		</div>
	</div>
</div>


<?php $this->load->view('layout/foot'); ?>

<script type="text/javascript">

	//内容的缓存，每页内容的缓存:格式:[[页码,标示,'内容数据','翻页'],[3,'xxxx','xxxxx']]
	//缓存到客户端浏览器的内容
	var cache = [];
	//获取某一页缓存
	function getCache(page,name) {
		for (var i = 0; i < cache.length; i++) {
			if (cache[i][0] == page && cache[i][1] == name) {
				return cache[i];
			}
		}
		return false;
	}

	//ajax获取所有日志
	function ajaxGetAllPost(page) {
		// console.log(cache);
		var c = getCache(page,'post');
		// console.log(c);
		if (c !== false && c[1] == 'post') {
			$('#postList').html(c[2]);
			$('.pagination').html(c[3]);
			$(document.body).animate({'scrollTop':0},1000);
			return;
		}
		$.ajax({
			type : "GET",
			url : "<?=site_url('welcome/ajaxGetAllPost')?>?p="+page,
			dataType : "json",
			success : function(data){
				createPost(data,page,'post');
			}
		});
	}
	ajaxGetAllPost(1);

	//ajax获取tag标签日志
	function ajaxGetTagPost(page,tag,id){
		// console.log(cache);
		var c = getCache(page,tag);
		console.log(c);
		if (c !== false && c[1] == tag) {
			$('#postList').html(c[2]);
			$('.pagination').html(c[3]);
			$(document.body).animate({'scrollTop':0},1000);
			return;
		}		
		$.ajax({
			type : "GET",
			url : "<?=site_url('welcome/ajaxGetTagPost')?>?p="+page+"&PostSearch[tags]="+tag,
			dataType : "json",
			success : function(data){
				createPost(data,page,tag);
			}
		});
	}

	//ajax获取类别日志
	function ajaxGetCatPost(page,cat) {
		var c = getCache(page, cat);
		if (c !== false && c[1] == cat) {
			$('#postList').html(c[2]);
			$('.pagination').html(c[3]);
			$(document.body).animate({'scrollTop':0},1000);
			return;
		}		
		$.ajax({
			type : "GET",
			url : "<?=site_url('welcome/ajaxGetCatPost')?>?p="+page+"&PostSearch[cat_id]="+cat,
			dataType : "json",
			success : function(data){
				createPost(data,page,cat);
			}
		});	}

	//接收服务器返回后拼接字符串,并显示
	function createPost(data,page,mark){
		// console.log(data);
		var html ="";
		var name = mark;
		$(data.data).each(function(key,value){
			//拼标签
			var tagshtml = "";
			$(value.tags).each(function(key1,value1){
				tagshtml += '<span class="glyphicon glyphicon-tag" aria-hidden="true"></span><a href="">'+value1+'</a>';
			});
            html += '<div class="post-id" data-key="'+value.id+'"><div class="post"><div class="title"><h2><a href="/welcome/detail?id='+value.id+'">'+value.title+'</a></h2><div class="author"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> <em>'+value.create_time+'&nbsp;&nbsp;&nbsp;&nbsp;</em><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <em>'+value.username+'</em></div></div><br /><div class="content">'+value.content+'</div><br /><div class="nav">'+tagshtml+'<br/><a href="/welcome/detail?id='+value.id+'">评论 ('+data.num[value.id]+')</a> |最后修改于 '+value.update_time+'</div></div><hr /></div>'
		});
		//放到页面中覆盖原数据
		$("#postList").html(html);

		//根据总的页数，拼出翻页字符串
		var pageString = data.page;

		$('.pagination').html(pageString);

		//放到缓存中
		cache.push([page, mark, html, pageString]);
		$(document.body).animate({'scrollTop':0},1000);
	}
</script>