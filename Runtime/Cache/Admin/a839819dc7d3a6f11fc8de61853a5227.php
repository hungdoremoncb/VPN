<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>后台 - 代理推广 - Vinper </title>
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
							<h5>代理推广</h5>
						</div>
						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-3">
									<form method="post" action="<?php echo U('Admin/Member/push');?>">
										<div class="input-group">
											<input type="text"  placeholder="请输入用户号或昵称" value="<?php echo ($nickname); ?>" name="nickname" class="input-sm form-control"> <span class="input-group-btn">
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
											<th>用户号</th>
											<th>代理分</th>
											<th>推广人数</th>
											<th>推广所得总佣金</th>
											<th>佣金余额</th>
											<th>推广二维码</th>
											<th>推广链接</th>
											<th>状态</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
												<!-- <td width="20"><input type="checkbox" class="i-checks" name="ids[]"></td> -->
												<td width="60"><img src="<?php echo ($vo["headimgurl"]); ?>"/></td>
												<td width="100"><?php echo ($vo["nickname"]); ?></td>
												<td width="100"><?php echo ($vo["username"]); ?></td>
												<td width="100"><font color="red"><?php echo ($vo["agent_fen"]); ?></font></td>
												<td width="100"><?php echo ($vo["t_account"]); ?></td>
												<td width="100"><?php echo ($vo["t_add"]); ?></td>
												<td width="100"><font color="red"><?php echo ($vo["yong"]); ?></font></td>
												<td width="100"><img src="<?php echo ($vo["qrcode"]); ?>"></td>
												<td width="100"><?php echo ($vo["url"]); ?></td>
												<td width="100" style="text-align: center;">
													<?php if($vo["status"] == 1): ?>正常<?php endif; ?>
													<?php if($vo["status"] == 0): ?>禁用<?php endif; ?>
												</td>
												<td width="200">
													<a href="/Admin/Member/pushxx/id/<?php echo ($vo["id"]); ?>" class="btn btn-primary">查看下线</a>
													<?php if($vo["t_id"] != 0): ?><a onclick="edit('<?php echo ($vo["t_id"]); ?>')" class="btn btn-success">查看上线</a>
														<?php else: ?>
														无上线<?php endif; ?>
													</if>
													<a href="/Admin/Member/set_tui/id/<?php echo ($vo["id"]); ?>" class="btn btn-info">设置二维码</a>
													<a onclick="integral('<?php echo ($vo["id"]); ?>')" class="btn btn-primary">上代理分</a>
													<a href="/Admin/Member/update_sx/id/<?php echo ($vo["id"]); ?>" class="btn btn-primary">修改上线</a>
													<a href="/Admin/Member/update_xx/id/<?php echo ($vo["id"]); ?>" class="btn btn-primary">修改下线</a>
													
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
			function integral(id){
				layer.open({
			      	type: 2,
			      	title: '上代理分',
			      	shadeClose: true,
			      	shade: false,
			     	maxmin: true, //开启最大化最小化按钮
			      	area: ['300px', '500px'],
			      	content: "/Admin/Integral/agent_index/id/" + id + ""
			    });
			}
			function under(id){
				layer.open({
			      	type: 2,
			      	title: '会员下分',
			      	shadeClose: true,
			      	shade: false,
			     	maxmin: true, //开启最大化最小化按钮
			      	area: ['300px', '500px'],
			      	content: "/Admin/Integral/under/id/" + id + ""
			    });
			}
				function edit(id){
				layer.open({
			      	type: 2,
			      	title: '编辑',
			      	shadeClose: true,
			      	shade: false,
			     	maxmin: true, //开启最大化最小化按钮
			      	area: ['600px', '500px'],
			      	content: "/Admin/Member/edit/id/" + id + ""
			    });
			}
			function disable(id){
				layer.confirm('确定要禁用吗？禁用后将不能登录。', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Member/disable/id/" + id + ""
				});
			}
			function endisable(id){
				layer.confirm('确定要启用吗？', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Member/endisable/id/" + id + ""
				});
			}
			function addxx(){
				layer.open({
			      	type: 2,
			      	title: '添加下线',
			      	shadeClose: true,
			      	shade: false,
			     	maxmin: true, //开启最大化最小化按钮
			      	area: ['300px', '300px'],
			      	content: "/Admin/Member/addxx_page/"
			    });
			}
		</script>
	</body>

	
</html>