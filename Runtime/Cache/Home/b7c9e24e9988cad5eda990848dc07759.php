<?php if (!defined('THINK_PATH')) exit();?><html>

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?php echo C('sitename');?> - Vinper </title>
		<meta name="format-detection" content="telephone=no,email=no"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
		<link href="/Public/Admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
		<link href="/Public/Admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">

		<link href="/Public/Admin/css/animate.min.css" rel="stylesheet">
		<link href="/Public/Admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
	</head>
	<style type="text/css">
		body,
		canvas,
		div {
			-moz-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
			-khtml-user-select: none;
			-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
		}
		body{
			background-color: #f3f3f4;
			background-size:cover;
			padding: 0 10px;
		}
		.facesj{
			display: inline-block;
			background-color: #1fa1dc;
			width: 60px;
		    height: 32px;
		    line-height: 32px;
		    border-radius: 3px;
		    text-align: center;
		    font-size: 14px;
		    margin-top:6px;
		    border: 1px solid #1fa1dc;
		    color: #FFF;
		    margin-left:10px;
		}
		h3{
			color: rgba(210, 188, 37, 0.73);
			font-size:20px;
			font-weight: bold;
		}
	</style>
	<body>
	
		<div class="middle-box text-center loginscreen  animated fadeInDown">
			<div>
			

			<div class="headPortrait">
            <img src="/Public/Home//up_files/room/avatar.png" style="width: 40%;"/>
        </div>
			<div class="loginBanner">
        
				<div>
					<h1 style="height:60px"></h1>
				</div>
				<h3>Đăng ký tài khoản</h3>
				<form class="m-t" role="form" method="post" action="<?php echo U('Home/Index/register');?>" id="LoginForm">
				<div class="form-group">
					<input type="text" id="username" name="username" class="form-control" placeholder="tên tài khoản" required style="border-radius: 42px;">
				</div>
				<div class="form-group">
					<input type="password" id="password" name="password" class="form-control" placeholder="Mật khẩu" required style="border-radius: 42px;">
				</div>
				<div class="form-group">
					<input type="password" id="repassword" name="" class="form-control" placeholder="nhập Lại Mật Khẩu" required style="border-radius: 42px;">
				</div>
				<div class="form-group">
					<input type="text" id="qq" name="qq" class="form-control" placeholder="QQ" required style="border-radius: 42px;">
				</div>
				<div class="form-group" style="text-align:left">
					<strong>avatar:</strong>
					<img width="50px" class="img_head" src="/Public/Home/img/face/3.png">
					<input type="hidden" class="input_head" name="headimgurl" value="/Public/Home/img/face/3.png">
					<a class="facesj">随机切换</a>
				</div>
				<button type="submit" class="btn btn-success block full-width m-b" style="width: 100%;height: 36px;display: block;background: #5e97fe;font-size: 20px;color: #fff;border-radius: 42px;">注 册</button>
				<button class="return-login" onclick="javascript :history.go(-1);" style="width: 100%;height: 36px;display: block;background: #5e97fe;font-size: 20px;color: #fff;border-radius: 42px;">返回登录</button>
			</form>
			</div>
		</div>

		<script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
		<script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
		
		<script src="/Public/Common/js/ajaxForm.js"></script>
		<script src="/Public/layer/layer.js"></script>
		<script type="text/javascript">
			$('.facesj').click(function(){
				$num = Math.round(Math.random()*23+1);
				$('.img_head').attr('src','/Public/Home/img/face/'+$num+'.png');
				$('.input_head').val('/Public/Home/img/face/'+$num+'.png');
			})

			$(function(){
				$('#LoginForm').ajaxForm({
					beforeSubmit: checkForm,
					success: complete, 
					dataType: 'json'
				});
				function CheckStr(str){
		            var myReg = "[@/'\"#!$%&^*]+";
		            var reg = new RegExp(myReg);
		            if(reg.test(str)){
		            	return true; 
	            	} else {
	            		 return false; 
	            	}
		        }
				
				function CheckStrLength(str){
					if(str.length >= 5 && str.length <=16){
						return false;
					}else{
						return true;
					}
		        }
				
				function checkForm(){
					if( '' == $.trim($('#username').val())){
						layer.alert('tên tài khoản不能为空', {icon: 5}, function(index){
			 			layer.close(index);
						$('#username').focus(); 
						});
						return false;
					}
					if(CheckStrLength($('#username').val())){
						layer.alert('tên tài khoản必须5-16个字符', {icon: 5}, function(index){
			 			layer.close(index);
						$('#username').focus(); 
						});
						return false;
					}
					console.log(CheckStr($('#username').val()));
					if (CheckStr($('#username').val())) {
						layer.alert('tên tài khoản不能有特殊字符', {icon: 5}, function(index){
			 			layer.close(index);
						$('#username').focus(); 
						});
						return false;
					}

					if ($('#password').val().length < 6) {
						layer.alert('密码长度不能低于6位', {icon: 5}, function(index){
			 			layer.close(index);
						$('#password').focus(); 
						});
						return false;
					}

					if( '' == $.trim($('#password').val())){
						layer.alert('密码不能为空', {icon: 5}, function(index){
			 			layer.close(index);
						$('#password').focus(); 
						});
						return false;
					}

					if ($('#password').val() != $('#repassword').val()) {
						layer.alert('两次输入的密码不一致', {icon: 5}, function(index){
			 			layer.close(index);
						$('#password').focus(); 
						});
						return false;
					}
				}
				function complete(data){
					if(data.status==1){
						$('.btn').attr('disabled','disabled');
						layer.msg(data.info, function(index){
			 				layer.close(index);
							window.location.href=data.url;
						});
					}else{
						layer.msg(data.info);
						$('#password').val('').focus();
						return false;	
					}
				}
			});
		</script>
		</script>
	</body>

</html>