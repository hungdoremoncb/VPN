<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>后台 - 下分申请 - Vinper </title>
		<meta name="keywords" content="">
		<meta name="description" content="">

		<link rel="shortcut icon" href="favicon.ico">
		<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link href="/Public/Admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
		<link href="/Public/Admin/css/plugins/iCheck/custom.css" rel="stylesheet">
		<link href="/Public/Admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">

	</head>
	<style>
		/*分页样式*/
		.pages a,.pages span {
		    display:inline-block;
		    padding:4px 7px;
		    margin:0 2px;
		    border:1px solid #D5D4D4;
		    -webkit-border-radius:1px;
		    -moz-border-radius:1px;
		    border-radius:1px;
		}
		.pages a,.pages li {
		    display:inline-block;
		    list-style: none;
		    text-decoration:none; color:#3399ff;
		}
		
		.pages a:hover{
		    border-color:#3399ff;
		}
		.pages span.current{
		    background:#3399ff;
		    color:#FFF;
		    font-weight:700;
		    border-color:#3399ff;
		}
		.pages{
			text-align: center;
		}
		/*分页样式*/
		
		.layui-layer{
			top:48px !important;
		}
	</style>
	<body class="gray-bg">
		<div class="wrapper wrapper-content animated fadeInRight">	
			<div class="row">
				<div class="col-sm-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>下分申请</h5>
						</div>
						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-3">
									<form method="post" action="<?php echo U('Admin/Fen/xialist');?>">
										<div class="input-group">
											<input type="text" placeholder="请输入昵称" name="nickname" value="<?php echo ($nickname); ?>" class="input-sm form-control"> <span class="input-group-btn">
	                                    	<button type="submit" class="btn btn-sm btn-primary"> 搜索</button> </span>
										</div>
									</form>
								</div>
							</div>
							<div class="" >
								<table class="table table-striped table-hover table-bordered" style="width:auto;overflow:auto;display:inline-block;">
									<thead>
										<tr>
											<!-- <th></th> -->
											<th>头像</th>
											<th>昵称</th>
											<th>下分金额</th>
											<th>余额</th>
											<th>提现方式</th>
											<th>帐号</th>
											<th>银行</th>
											<th>姓名</th>
											<th>申请时间</th>
											<th>下分时间</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
												<!-- <td width="20"><input type="checkbox" class="i-checks" name="ids[]"></td> -->
												<td width="60"><img src="<?php echo ($vo["headimgurl"]); ?>"/></td>
												<td width="100"><?php echo ($vo["nickname"]); ?></td>
												<td width="100"><?php echo ($vo["money"]); ?></td>
												<td width="100"><?php echo ($vo["balance"]); ?></td>
												<td width="100" style="text-align: center;">
													<?php if($vo['type'] == 1): ?>微信<?php endif; ?>
													<?php if($vo['type'] == 2): ?>支付宝<?php endif; ?>
													<?php if($vo['type'] == 3): ?>银行卡<?php endif; ?>
												</td>
												<td width="50" style="text-align: center;">
													<?php if($vo['type'] == 1): echo ($vo["wx_account"]); endif; ?>
													<?php if($vo['type'] == 2): echo ($vo["alipay_account"]); endif; ?>
													<?php if($vo['type'] == 3): echo ($vo["bank_account"]); ?><br><?php echo ($vo["bank_address"]); ?><br><?php echo ($vo["name"]); endif; ?>
												</td>
												<td width="100"><?php echo ($vo["back_address"]); ?></td>
												<td width="100"><?php echo ($vo["back_name"]); ?></td>
												
												<td width="150"><?php echo (date("Y-m-d H:i:s",$vo["addtime"])); ?></td>
												<td width="150"><?php if($vo["xftime"] != 0): echo (date("Y-m-d H:i:s",$vo["xftime"])); else: ?>--<?php endif; ?></td>
												<td>
													<?php if($vo["status"] == 0): ?><a onclick="under('<?php echo ($vo["uid"]); ?>','<?php echo ($vo["id"]); ?>')" class="btn btn-warning">下分</a>
														<a onclick="ignore('<?php echo ($vo["id"]); ?>')" class="btn btn-primary">忽略</a>
													<?php elseif($vo["status"] == 1): ?>
														<font color="red">已下分</font>
													<?php elseif($vo["status"] == 2): ?>
														<font color="red">已忽略</font><?php endif; ?>
												</td>
											</tr><?php endforeach; endif; else: echo "" ;endif; ?>
									</tbody>
								</table>
							</div>
							<div class="pages">
								<?php echo ($show); ?>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
		<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="/Public/Admin/js/plugins/iCheck/icheck.min.js"></script>
		<script src="/Public/Common/layer/layer.js"></script>
		<script>
			$(document).ready(function() {
				$(".i-checks").iCheck({
					checkboxClass: "icheckbox_square-green",
					radioClass: "iradio_square-green",
				})
			});
		</script>
		<script>
			function under(id,fid){
				layer.open({
			      	type: 2,
			      	title: '会员下分',
			      	shadeClose: true,
			      	shade: false,
			     	maxmin: true, //开启最大化最小化按钮
			      	area: ['300px', '500px'],
			      	content: "/Admin/Integral/under?id=" + id + "&type=2&fid="+fid
			    });
			}

			function ignore(id){
				layer.confirm('确定忽略吗？', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Fen/ignorexia/id/" + id + ""
				});
			}
		</script>
	</body>

	
</html>