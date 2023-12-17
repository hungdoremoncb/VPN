<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html id="iframe">
	<head>
		<meta charset="UTF-8">
		
		<title><?php echo C('sitename');?> - Vinper </title>
		
		<meta name="renderer" content="webkit">
		<meta name="format-detection" content="telephone=no,email=no"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
		<meta name="telephone=no"  content="format-detection">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no" />
		
		<META HTTP-EQUIV="Pragma" CONTENT="no-cache"> 
		<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache"> 
		<META HTTP-EQUIV="Expires" CONTENT="0">
		
		<link rel="stylesheet" type="text/css" href="/Public/Home/css/lib.css"/>
		<link rel="stylesheet" type="text/css" href="/Public/Home/css/public.css"/>
		<link rel="stylesheet" type="text/css" href="/Public/Home/css/page.css"/>
		
		<link href="/Public/Admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
		<link href="/Public/Admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
		<link href="/Public/Admin/css/animate.min.css" rel="stylesheet">
		<link href="/Public/Admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
		<link href="/Public/Home/css/page.css" rel="stylesheet">
		
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
		    text-decoration:none; color:#15AF11;
		}
		
		.pages a:hover{
		    border-color:#15AF11;
		}
		.pages span.current{
		    background:#15AF11;
		    color:#FFF;
		    font-weight:700;
		    border-color:#15AF11;
		}
		.pages{
			margin-top: 8px;
			text-align: center;
		}
		.ptitle{
			height: 45px;
			line-height: 45px;
		}
		/* .tj{color:#c7baba;} */
		/*分页样式*/
	</style>
	<body>
		<div class="header">
		  <div class="all_w ">
		    <div class="gofh"> <a href="javascript:history.back()" style="border-right:none;"><img src="/Public/Home/new/css/ico/left.png"style="width: 20px;"></a> </div>
		     <div class="ptitle">
		      余额宝记录
		    </div>
		  </div>
		</div>
		<div class="record">
			<div class="record-top">
				<p class="intro">
					<span>元宝:<i><?php echo ($userinfo["points"]); ?></i></span>
					<span>余额宝:<i><?php echo ($userinfo["treasure_capital"]); ?></i></span>
					<span>已收益:<i><?php echo ($userinfo["treasure_rates"]); ?></i></span>
					<span>待领:<i><?php echo ($treasure_notget["sum_moneys"]); ?></i></span>
					
				</p>
			</div>
			<div style=" display:inline !important; border-bottom:1px solid #000000; ">
				<table>
					<tr>
						<td style="width:10%;">
						</td>
						<td style="width:30%;">
							<button type="submit" class="btn btn-success block full-width m-b" style="width:60px !important;display:flex !important; ">
								<a href="<?php echo U('Home/Run/inputTreasure');?>?type=转入" style="color:#ffffff;">转入</a>
							 </button>
						</td>
						<td style="width:30%;">
							<button type="submit" class="btn btn-success block full-width m-b" style="width:60px !important;display:flex !important; ">
								<a href="<?php echo U('Home/Run/outputTreasure');?>?type=转出"  style="color:#ffffff;">转出</a>
							 </button>
						
						</td>
						<td  >
							<button type="submit" class="btn btn-success block full-width m-b" style="width:60px !important;display:flex !important; ">
							
								<a href="<?php echo U('Home/Run/getTreasure');?>?t=1" style="color:#ffffff;">领取</a>
							
							 </button>
						
						</td>
					</tr>
				</table>
				 
			</div>
			
			<div class="record-content" style="   border-top:1px solid #000000; padding-top:10px;">
				<?php if(empty($list)): ?><p class="record-no" style="border:none !important;"><span  style="background-color:#1c8;border:none !important;">
						 无余额宝资料
					</span></p>
					<?php else: ?>
					 
						<table>
							<thead>
								<tr>
									<!--<th>类型</th>
									<th>发生金额</th>-->
									<th>本金</th>
									<th>利息</th>
									<th>时间</th>
									<th>状态</th>
									<th>详情</th>
								</tr>	
							</thead>
							<tbody>
								<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
										 
										<!--<td><?php echo ($vo["types"]); ?></td>
										<td><?php echo ($vo["moneys"]); ?></td>-->
										<td><?php echo ($vo["treasure_capital"]); ?></td>
										<td><?php echo ($vo["treasure_rates"]); ?></td>
										<td><?php echo (date("Y-m-d H:i:s",$vo["times"])); ?></td>
										<td><?php echo ($vo["status"]); ?></td>
										<td><?php echo ($vo["details"]); ?></td>
												
									</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							</tbody>
						</table><?php endif; ?>
			</div>
			 
			<div class="pages">
				<?php echo ($show); ?>
			</div>
		</div>
		
		
		<script src='//cdn.bootcss.com/jquery/1.11.3/jquery.js'></script>
		<script src="/Public/layer/layer.js"></script>
		<script>
			function del(id){
				layer.open({
				    content: '您确定要取消吗？'
				    ,btn: ['确认', '取消']
				    ,yes: function(index){
				      	layer.close(index);
				      	$.ajax({
	                       	url: "<?php echo U('Home/Run/del');?>",
	                       	type: "post",
	                       	data:{'id':id},
	                       	dataType:'json',
	                       	error:function(){
	                       		parent.layer.open({content: '服务器开小差了~',skin: 'msg',time: 2});
		                    },
	                       	success:function(res){
	                       		location.href=location.href;
	                       	}
	                   	});
				    }
				});
			}
			// function del_all(number){
			// 	layer.open({
			// 	    content: '您确定要取消吗？'
			// 	    ,btn: ['确认', '取消']
			// 	    ,yes: function(index){
			// 	      	layer.close(index);
			// 	      	$.ajax({
	  //                      	url: "<?php echo U('Home/Run/del_all');?>",
	  //                      	type: "post",
	  //                      	data:{'number':number},
	  //                      	dataType:'json',
	  //                      	error:function(){
	  //                      		parent.layer.open({content: '服务器开小差了~',skin: 'msg',time: 2});
		 //                    },
	  //                      	success:function(res){
	  //                      		location.href=location.href;
	  //                      	}
	  //                  	});
			// 	    }
			// 	});
			// }
		</script>
		
		
		
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
		
	</body>
</html>