<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
<!--本程序来自：盛發财富（qq:2370250999） -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>Vinper </title>
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
							<h5>管理员管理</h5>
						</div>
						<div class="ibox-content">
	                        <a onclick="add('<?php echo ($vo["id"]); ?>')" class="btn btn-sm btn-success">添加管理员</a>
							<div class="" >
								<table class="table table-striped table-hover table-bordered" style="width:auto;overflow:auto;display:inline-block;">
									<thead>
										<tr>
											<th>登录tên tài khoản</th>
											<th>角色</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
												
												<td width="100"><?php echo ($vo["username"]); ?></td>
												<td width="100"><?php echo ($vo["role"]); ?></td>
												
												<td width="350">
													<?php if($vo["status"] == 1): ?><a onclick="disable('<?php echo ($vo["id"]); ?>')" class="btn btn-danger">禁用</a>
														<?php else: ?>
														<a onclick="endisable('<?php echo ($vo["id"]); ?>')" class="btn btn-primary">启用</a><?php endif; ?>
													<a onclick="edit('<?php echo ($vo["id"]); ?>')" class="btn btn-warning">编辑</a>
													
													<a onclick="del('<?php echo ($vo["id"]); ?>')" class="btn btn-danger">删除</a>
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
			      	title: '会员上分',
			      	shadeClose: true,
			      	shade: false,
			     	maxmin: true, //开启最大化最小化按钮
			      	area: ['300px', '500px'],
			      	content: "/Admin/Integral/index/id/" + id + ""
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
			      	content: "/Admin/Admin/edit/id/" + id + ""
			    });
			}

			function add(id){
				layer.open({
			      	type: 2,
			      	title: '编辑',
			      	shadeClose: true,
			      	shade: false,
			     	maxmin: true, //开启最大化最小化按钮
			      	area: ['600px', '500px'],
			      	content: "/Admin/Admin/add"
			    });
			}
			function disable(id){
				layer.confirm('确定要禁用吗？禁用后将不能登录。', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Admin/disable/id/" + id + ""
				});
			}
			function endisable(id){
				layer.confirm('确定要启用吗？', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Admin/endisable/id/" + id + ""
				});
			}
			function del(id){
				layer.confirm('确定要删除吗？', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Admin/del/id/" + id + ""
				});
			}
		</script>
	</body>

	
</html>