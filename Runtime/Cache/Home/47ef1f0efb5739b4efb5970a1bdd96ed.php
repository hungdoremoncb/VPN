<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?php echo C('sitename');?>-Nạp申请 - Vinper </title>
		<meta name="format-detection" content="telephone=no,email=no"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
		<link href="/Public/Admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
		<link href="/Public/Admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
		<link href="/Public/Admin/css/animate.min.css" rel="stylesheet">
		<link href="/Public/Admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
		<link href="/Public/Home/css/page.css" rel="stylesheet">
	</head>
	<style type="text/css">
		body{
			overflow-y: scroll;
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
		img{max-width: 100%}
		.sk{width:70%;}
		.middle-box{padding-top:6px;}
		.zfbimg{display: none;}
		.ptitle{
			height: 45px;
			line-height: 45px;
		}
	</style>
	<body>
		<div class="header">
		  <div class="all_w ">
		    <!--
			<div class="gofh"> <a href="javascript:history.back()"><img src="/Public/Home/img/jt_03.jpg"></a> </div>
			-->
			<div class="gofh"> <a href="javascript:history.back()"  style="border-right:none;"><img src="/Public/Home/new/css/ico/left.png" style="width: 20px;"></a> </div>
			
		   <!--  <div class="ttwenz">
		      <h4>Nạp trực tuyến</h4>
		      <h5>微信安全Nạp</h5>

		    </div> -->
		     <div class="ptitle">
		      Nạp trực tuyến
		        <a href="<?php echo U('Home/Fen/xiapage');?>" class="backgame">下分</a>
		    </div>
		  </div>
		</div>
		<div class="middle-box text-center loginscreen  animated fadeInDown">
			<div>
				<div class="form-group">
					<label class="col-sm-2 control-label" style="width:30%;text-align: right;">Nạp类型</label>
					<div class="col-sm-6" style="width:60%;display: inline-block;">
						<select name="type" class="form-control type_choose">
							<option value="1">微信二维码Nạp</option>
							<option value="2">支付宝二维码Nạp</option>
						</select>
					</div>
				</div>
				<div class="wximg">
					<img class="sk" src="<?php if($pay[wx_paycode] != ''): ?>/Uploads/<?php echo ($pay["wx_paycode"]); else: ?>/Public/Admin/img/no_img.jpg<?php endif; ?>" >
				</div>
				<div class="zfbimg">
					<img class="sk" src="<?php if($pay[zfb_paycode] != ''): ?>/Uploads/<?php echo ($pay["zfb_paycode"]); else: ?>/Public/Admin/img/no_img.jpg<?php endif; ?>" >
				</div>
				<form class="m-t form-horizontal " role="form" method="post" action="<?php echo U('Home/Fen/add');?>" id="LoginForm">
				<div class="form-group">
					<label class="col-sm-2 control-label" style="width:30%;text-align: right;">昵称：</label>
					<div class="col-sm-6" style="width:60%;display: inline-block;text-align: left">
						<?php echo ($userinfo["nickname"]); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label" style="width:30%;text-align: right;">账户余额：</label>
					<div class="col-sm-6" style="width:60%;display: inline-block;text-align: left">
						<?php echo ($userinfo["points"]); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label" style="width:30%;text-align: right;">Nạp金额：</label>
					<div class="col-sm-6" style="width:60%;display: inline-block;">
						<input type="text" id="money" name="money" class="form-control" required  onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'0')}else{this.value=this.value.replace(/\D/g,'')}">
					</div>
				</div>
				<input type="hidden" name="id" value="<?php echo ($userinfo["id"]); ?>">
				<button type="submit" class="btn btn-success block full-width m-b">Nạp申请</button>
			</form>
			</div>
		</div>

		<script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
		<script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
		
		<script src="/Public/Common/js/ajaxForm.js"></script>
		<script src="/Public/layer/layer.js"></script>
		<script type="text/javascript">
			$('.type_choose').change(function(){
				var index = $(this).val();
				if (index == 1) {
					$('.wximg').show();
					$('.zfbimg').hide();
				} else if(index ==2){
					$('.wximg').hide();
					$('.zfbimg').show();
				}
			})

			$(function(){
				$('#LoginForm').ajaxForm({
					beforeSubmit: checkForm,
					success: complete, 
					dataType: 'json'
				});
				function checkForm(){
					
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