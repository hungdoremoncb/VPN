<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>后台 - 上下分管理 - Vinper </title>
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
							<h5>上下分管理</h5>
						</div>
						<div class="ibox-content">
						<div class="row">
								<form method="get" action="<?php echo U('Admin/Integral/lists');?>">
									<div class="col-sm-2">
										<input type="text" placeholder="开始时间" id="starttime" name="starttime" value='<?php echo ($start); ?>' class="form-control">
									</div>		
									<div class="col-sm-2">
										<input type="text"  placeholder="结束时间" id="endtime" name="endtime" value="<?php echo ($end); ?>" class="input-sm form-control"> 
									</div>
									<div class="col-sm-2">
									<input type="text"  placeholder="请输入用户号或昵称" name="nickname" value="<?php echo ($nickname); ?>" class="input-sm form-control"> <span class="input-group-btn">
									</div>
									<button type="submit" class="btn btn-sm btn-primary"> 搜索</button> 
                                	<button class="btn btn-sm btn-primary timesearch" time="today"> 今天</button>
                                	<button  class="btn btn-sm btn-primary timesearch" time="yestoday"> 昨天</button>
                                	<button class="btn btn-sm btn-primary timesearch" time="week"> 最近一周</button>
                                	<button class="btn btn-sm btn-primary timesearch" time="month"> 最近一月</button><br>
									(注只有Nạp trực tuyến时才有订单号,有订单号时显示下分,说明正在充或没有Nạp完成,上分代表Nạp完成.其他功能不影响)
								</form>
							</div>
							<div class="table-responsive">
								<table class="table table-striped table-hover table-bordered">
									<thead>
										<tr>
											<th>ID</th>
											<th>头像</th>
											<th>昵称</th>
											<th>用户号</th>
											<th>Nạp trực tuyến订单号</th>
											<th>上下分</th>
											<th>时间</th>
										</tr>
									</thead>
									<tbody>
										<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
												<td width="30"><?php echo ($vo["id"]); ?></td>
												<td width="40"><img style="width: 40px;" src="<?php echo ($vo["user"]["headimgurl"]); ?>"/></td>
												<td width="100"><?php echo ($vo["nickname"]); ?></td>
												<td width="100"><?php echo ($vo["username"]); ?></td>
												<td width="100"><?php echo ($vo["order_id"]); ?></td>
												<td width="100">
													<?php if($vo['type'] == 1): ?><span style="color: red;">上分&nbsp;&nbsp;<?php echo ($vo["points"]); ?></span>
														<?php else: ?>
														<span style="color: blue;">下分&nbsp;&nbsp;<?php echo ($vo["points"]); ?></span><?php endif; ?>
												</td>
												<td width="100"><?php echo (date("Y-m-d H:i:s",$vo["time"])); ?></td>
											</tr><?php endforeach; endif; else: echo "" ;endif; ?>
									</tbody>
								</table>
							</div>
							<div class="pages">
								<?php echo ($show); ?>
							</div>
							<div>
							<span>总上分<font color="red"><?php echo ($sum_data['add']); ?></font></span>&nbsp;
							<span>总下分<font color="red"><?php echo ($sum_data['xia']); ?></font></span>&nbsp;
							<span>平台输赢：<font color="red"><?php echo ($sum_data['add']-$sum_data['xia']); ?></font></span>&nbsp;
						</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
		<script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
		<script src="/Public/Admin/js/plugins/iCheck/icheck.min.js"></script>
		<script src="/Public/Admin/js/plugins/layer/laydate/laydate.js"></script>
		<script src="/Public/Common/layer/layer.js"></script>
		<script>
				laydate({
			  elem: '#starttime',
			  max: laydate.now(), //+1代表明天，+2代表后天，以此类推
			  	  istime: true,
			  format: 'YYYY-MM-DD hh:mm:ss', //日期格式
			});
			laydate({
			  elem: '#endtime',
			  max: laydate.now(), //+1代表明天，+2代表后天，以此类推
			  	  istime: true,
			  format: 'YYYY-MM-DD hh:mm:ss', //日期格式
			});
		</script>
		<script>
			$('.timesearch').click(function(e){
				e.stopPropagation();
				var time_value = $(this).attr('time');
				location.href = "<?php echo U('Admin/Integral/lists');?>?time="+time_value;
				return false;
			})
			$(document).ready(function() {
				$(".i-checks").iCheck({
					checkboxClass: "icheckbox_square-green",
					radioClass: "iradio_square-green",
				})
			});
		</script>
		
	</body>

	
</html>