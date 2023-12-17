<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>后台 - 机器人管理 - Vinper </title>
		<meta name="keywords" content="">
		<meta name="description" content="">

		<link rel="shortcut icon" href="favicon.ico">
		<link href="/Public/Admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
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
	</style>
	<body class="gray-bg">
		<div class="wrapper wrapper-content animated fadeInRight">	
			<div class="row">
				<div class="col-sm-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>机器人管理</h5>
						</div>
						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-4">
									<form method="post" action="<?php echo U('Admin/Robot/index');?>">
										<div class="input-group">
											<input type="text" placeholder="请输入昵称" name="nickname" class="input-sm form-control"> 
											<span class="input-group-btn">
	                                    	<button type="submit" class="btn btn-sm btn-primary"> 搜索</button> </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                                    	<a class="input-group-btn" href="<?php echo U('Admin/Robot/add');?>"><span class="btn btn-sm btn-success">添加机器人</span></a>
										</div>
									</form>
								</div>
							</div>
							<div class="table-responsive">
								<table class="table table-striped table-hover table-bordered">
									<thead>
										<tr>
											<th></th>
											<th>头像</th>
											<th>昵称</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
												<td width="20"><input type="checkbox" class="i-checks" name="ids[]"></td>
												<td width="40"><img style="width: 40px;" src="/Uploads<?php echo ($vo["headimgurl"]); ?>"/></td>
												<td width="200"><?php echo ($vo["nickname"]); ?></td>
												<td>
													<a href="/Admin/Robot/integral/id/<?php echo ($vo["id"]); ?>" class="btn btn-primary">上分</a>
													<a href="/Admin/Robot/under/id/<?php echo ($vo["id"]); ?>" class="btn btn-warning">下分</a>
													<a href="/Admin/Robot/edit/id/<?php echo ($vo["id"]); ?>" class="btn btn-primary">编辑</a>
													<a onclick="del(<?php echo ($vo["id"]); ?>)" class="btn btn-warning">删除</a>
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
		<script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
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
			function del(id){
				layer.confirm('确定要删除吗？', {
				  	btn: ['确定','取消'] //按钮
				}, function(){
				  	window.location.href="/Admin/Robot/del/id/" + id + ""
				});
			}
		</script>
	</body>

	
</html>