<?php if (!defined('THINK_PATH')) exit();?><html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?php echo C('sitename');?>-下分记录 - Vinper </title>
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
			-moz-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
			-khtml-user-select: none;
			-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
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
		.alipay_choose,.bank_choose{display: none}
		/*.loginscreen{padding:40px 20px;}*/
		.header .ptitle{height:45px;line-height: 45px}
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
	<body>
		<div class="header">
		  <div class="all_w ">
		    <!--
			<div class="gofh"> <a href="javascript:history.back()"><img src="/Public/Home/img/jt_03.jpg"></a> </div>
			-->
			<div class="gofh"> <a href="javascript:history.back()"  style="border-right:none;"><img src="/Public/Home/new/css/ico/left.png" style="width: 20px;"></a> </div>
		    <div class="ptitle">
		      下分记录
		        <a href="/" class="backgame">返回游戏</a>
		    </div>
		  </div>
		</div>
		<div class=" text-center loginscreen  animated fadeInDown">
			<table class="table table-striped table-hover table-bordered" style="width:auto;overflow:auto;display:inline-block;">
				<thead>
					<tr>
						<th>ID</th>
						<th>tên tài khoản</th>
						<th>下分</th>
						<th>时间</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td width="60"><?php echo ($vo["id"]); ?></td>
							<td width="100"><?php echo ($vo["nickname"]); ?></td>
							<td width="100"><?php echo ($vo["points"]); ?></td>
							<td width="150"><?php echo (date("Y-m-d H:i:s",$vo["time"])); ?></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
		</div>
		<div class="pages">
				<?php echo ($show); ?>
			</div>
			<div>
				<span>总下分：<font color="red"><?php echo ($count['sum_points']); ?></font></span>&nbsp;
			
			</div>
	</body>

</html>