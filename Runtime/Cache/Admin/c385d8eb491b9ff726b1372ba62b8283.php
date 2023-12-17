<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<!--本程序来自：盛發财富（qq:2370250999） -->
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title> Vinper </title>
		<meta name="keywords" content="">
		<meta name="description" content="">

		<link rel="shortcut icon" href="favicon.ico">
		<link href="/Public/Admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
		<link href="/Public/Admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
		<link href="/Public/Admin/css/plugins/iCheck/custom.css" rel="stylesheet">
		<link href="/Public/Admin/css/animate.min.css" rel="stylesheet">
		<link href="/Public/Admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">

	</head>

	<body class="gray-bg">
		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row">
				<div class="col-sm-12">
					<div class="ibox float-e-margins">
						<div class="ibox-content">
							<form id="signform" method="post" action="<?php echo U('Admin/Admin/add');?>" class="form-horizontal">
									<div class="form-group">
										<label class="col-sm-2 control-label">登录tên tài khoản：</label>
										<div class="col-sm-6">
											<input type="text" id="username" name="username" value=""  class="form-control">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">角色名：</label>
										<div class="col-sm-6">
											<input type="text" id="role" name="role" value=""  class="form-control" >
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">密码</label>
										<div class="col-sm-6">
											<input type="text" id="password" name="password" value=""  class="form-control">
										</div>
									</div>
									
									<div class="hr-line-dashed"></div>
									<div class="form-group">
									<input type="hidden" name="id" value="<?php echo ($userinfo["id"]); ?>">
									<div class="col-sm-4 col-sm-offset-2">
										<button class="btn btn-primary" type="submit">确认</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
		<script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
		<script src="/Public/Admin/js/content.min.js?v=1.0.0"></script>
		<script src="/Public/Common/js/ajaxForm.js"></script>
		<script src="/Public/Common/layer/layer.js"></script>
		<script>
			$(function(){
				$('#signform').ajaxForm({
					beforeSubmit: checkForm,
					success: complete, 
					dataType: 'json'
				});
				function checkForm(){
					
				}
				function complete(data){
					if(data.status==1){
						$('.btn-primary').attr('disabled','disabled');
						layer.msg(data.info, function(index){
			 				layer.close(index);
							window.parent.location.href=data.url;
						});
					}else{
						layer.msg(data.info);
						return false;	
					}
				}
			});
		</script>
	</body>

</html>