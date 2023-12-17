<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="target-densitydpi=320,width=750,user-scalable=no" name="viewport" />
    <meta content="no" name="apple-touch-fullscreen" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
<!--本程序来自：盛發财富（qq:2370250999 -->
    <title>登录 - Vinper </title>
    <!--<link href="/statics/web/css/css.css?v=1" rel="stylesheet" type="text/css">-->
    <!--<script src="/statics/web/js/jquery.1.8.2.min.js"></script>-->
   	<!--<script src="/statics/web/js/style.js"></script>-->
    <link href="/Public/Home/statics/web/css/css.css" rel="stylesheet" type="text/css">
	<link href="/Public/Home/statics/web/css/red.css" rel="stylesheet" type="text/css">
	<script src="/statics/web/js/jquery-1.9.1.min.js"></script>
	<script src="/statics/web/js/style.js"></script> 
	<!-- Validform -->
    <link rel="stylesheet" href="/Public/Home//statics/web/extend/Validform_v5.3.2/css/style.css" type="text/css" media="all" />
    <script type="text/javascript" src="/Public/Home/statics/web/extend/Validform_v5.3.2/js/Validform_v5.3.2_min.js"></script>
    <!-- Validform - end -->

    <!-- layer -->
    <!-- <link rel="stylesheet" href="/statics/web/extend/layui/css/layui.css">
    <script src="/statics/web/extend/layui/layui.js"></script> -->
    <script src="/Public/Home//statics/web/extend/layer/mobile/layer.js"></script>
    <!-- layer - end -->
    <!-- 新增css -->
    <link href="/Public/Home//statics/web/css/s_min.css" rel="stylesheet" type="text/css">
    <!-- 新增css - end -->
    <style type="text/css">
    	.Validform_checktip {
    		display: none;
		    margin-left: 8px;
		    line-height: 20px;
		    height: 40px; 
		    overflow: hidden;
		    color: #999;
		    font-size: 26px; 
		}
    </style>
</head>
<body class="login">
    <!--<header class="loginHeader">-->
        <!--<h1>登录</h1>-->
        <!--<em class="guanbing" data-href="https://1ww-pc3333.com/?m=web&c=lobby&a=index"></em>-->
    <!--</header>-->

<section class="login-bg">
    <em class="guanbing" data-href="#"></em>
    <div class="loginBanner">
        <div class="headPortrait">
            <img src="/Public/Home/up_files/room/avatar.png" />
        </div>
    </div>
    <div class="loginWarp">
        <form class="login" method="post" action="<?php echo U('Home/Index/login');?>" id="LoginForm">
        <ul>
            <li>
                <label class="user" for="user">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Vui lòng nhập tên người dùng" required>
                </label>
                <p class="Validform_checktip" id="m-user"></p>
            </li>
            <li>
                <label class="pas ico_pas" for="pas">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Xin vui lòng nhập mật khẩu" required>
                </label>
                <em class="see"></em>
                <p class="Validform_checktip" id="m-pas"></p>
            </li>
            <li ><button type="submit" class="btn btn-success block full-width m-b">Đăng nhập</button></li>
			<li ><button class="goReg" data-href="/Home/Index/register" type="button"><i class="reg"></i>Đăng ký ngay</button></li>
           <!--  <li class="butC clearfix"><button id="tourist" type="button"><i class="tour"></i>游客试玩</button><button class="goReg" data-href="/Home/Index/register" type="button"><i class="reg"></i>Đăng ký ngay</button></li> -->
        </ul>
            <input type="hidden" name="flag" id="flag" value="3"/>
            <input type="hidden" name="type" id="type" value="1"/>
            <input type="hidden" name="rember" value="2">
        </form>
        <!--<p class="regWarp"><a href="https://1ww-pc3333.com/?m=web&c=user&a=register">注册</a><a href="https://1ww-pc3333.com/?m=web&c=app&a=customService&type=1">忘记密码</a></p>-->
        <p class="regWarp">
          <!--   <a href="/Public/Home/http://chat56.live800.com/live800/chatClient/chatbox.jsp?companyID=835821&configID=125193&jid=9599163510">忘记密码？</a> -->
           
        </p>
    </div>
     <div class="otherwise" >
       <!--  <h2><span>cskh联系方式</span></h2> -->
<!--         <ul>
            <li class="weixin"><img src="/Public/Home//statics/web/images/ico-wx.png"></li>
            <li class="qq"><img src="/Public/Home//statics/web/images/ico-wb.png"></li>
            <li data-href="http://chat56.live800.com/live800/chatClient/chatbox.jsp?companyID=835821&configID=125193&jid=9599163510"><img src="/Public/Home/statics/web/images/ico-qq.png"></li>
        </ul> -->
    </div> 
</section>
		
		<script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
		
		<script src="/Public/Common/js/ajaxForm.js"></script>
		<script src="/Public/layer/layer.js"></script>
		<script type="text/javascript">

			$(function(){
				$('#LoginForm').ajaxForm({
					beforeSubmit: checkForm,
					success: complete, 
					dataType: 'json'
				});
				function checkForm(){
					if( '' == $.trim($('#username').val())){
						layer.alert('tên tài khoản不能为空', {icon: 5}, function(index){
			 			layer.close(index);
						$('#username').focus(); 
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
				}
				function complete(data){
					if(data.status==1){
						$('.btn').attr('disabled','disabled');
						//window.location.href=data.url;
						layer.msg("登录成功", function(index){
			 				layer.close(index);
							window.location.href=data.url;
						});
						
					}else{
						layer.msg("登录失败");
						$('#password').val('').focus();
						return false;	
					}
				}
			});
		</script>
		
</body>
</html>