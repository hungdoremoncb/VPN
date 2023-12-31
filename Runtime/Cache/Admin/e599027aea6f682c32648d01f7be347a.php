<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>后台 - 赛车飞艇配置 - Vinper </title>
		<meta name="keywords" content="">
		<meta name="description" content="">

		<link rel="shortcut icon" href="favicon.ico">
		<link href="/Public/Admin/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
		<link href="/Public/Admin/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
		<link href="/Public/Admin/css/plugins/iCheck/custom.css" rel="stylesheet">
		<link href="/Public/Admin/css/animate.min.css" rel="stylesheet">
		<link href="/Public/Admin/css/style.min862f.css?v=4.1.0" rel="stylesheet">
	</head>

	<body class="gray-bg">
		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row">
				<div class="col-sm-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>赛车飞艇配置</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">
							<form id="signform" action="<?php echo U('Admin/Site/pk10');?>" method="post" class="form-horizontal">
								<div class="form-group">
									<label class="col-sm-3 control-label">cskh欢迎语</label>
									<div class="col-sm-6">
										<input type="text" name="welcome" value="<?php echo C('welcome');?>" placeholder="欢迎莅临，祝您竞猜愉快！本平台重金打造！玩法多样，超高赔率，等你来战！" class="form-control">
										<span>（修改后需要重启服务生效）</span>
									</div>

								</div>
								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<label class="col-sm-3 control-label">虚拟在线人数</label>
									<div class="col-sm-6">
										<input type="text" name="online" value="<?php echo C('online');?>" placeholder="输入虚拟人数" class="form-control">
									</div>
								</div>
								
								<div class="hr-line-dashed"></div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label">控制新加坡28今日输赢</label>
									<div class="col-sm-6">
										<input type="text" name="xjp28_today_ying1" value="<?php echo C('xjp28_today_ying1');?>" placeholder="输入亏损值(例如-1000)" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label"></label>
									<div class="col-sm-6">
										<input type="text" name="xjp28_today_ying2" value="<?php echo C('xjp28_today_ying2');?>" placeholder="输入盈利值(例如1000)" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">当前状态(每天00:00会自动关闭)</label>
									<div class="col-sm-6">
										<input type="radio" value="1" <?php if($is_ctrl_xjp28 == 1): ?>checked<?php endif; ?> class="i-checks" name="is_ctrl_xjp28">开启&nbsp;&nbsp;
										<input type="radio" value="0" <?php if($is_ctrl_xjp28 == 0): ?>checked<?php endif; ?> class="i-checks" name="is_ctrl_xjp28">关闭
									</div>
								</div>
								
								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<label class="col-sm-3 control-label">是否开启机器人</label>
									<div class="col-sm-6">
										<input type="radio" value="1" <?php if(C('robot') == 1): ?>checked<?php endif; ?> class="i-checks" name="robot">开启&nbsp;&nbsp;
										<input type="radio" value="0" <?php if(C('robot') == 0): ?>checked<?php endif; ?> class="i-checks" name="robot">关闭
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">机器人下注频率</label>
									<div class="col-sm-6">
										<select class="form-control" name="robot_rate">
											<option <?php if(C('robot_rate') == 1): ?>selected<?php endif; ?>  value="1" >1</option>
											<option <?php if(C('robot_rate') == 2): ?>selected<?php endif; ?>  value="2" >2</option>
											<option <?php if(C('robot_rate') == 3): ?>selected<?php endif; ?>  value="3" >3</option>
											<option <?php if(C('robot_rate') == 4): ?>selected<?php endif; ?>  value="4" >4</option>
											<option <?php if(C('robot_rate') == 5): ?>selected<?php endif; ?>  value="5" >5</option>
										</select>
										（数字越高，频率越快）
									</div>

								</div>
								
								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<label class="col-sm-3 control-label">是否开启自动到账</label>
									<div class="col-sm-6">
										<input type="radio" value="1" <?php if(C('quick_pay') == 1): ?>checked<?php endif; ?> class="i-checks" name="quick_pay">开启&nbsp;&nbsp;
										<input type="radio" value="0" <?php if(C('quick_pay') == 0): ?>checked<?php endif; ?> class="i-checks" name="quick_pay">关闭
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label">支付域名</label>
									<div class="col-sm-6">
										<input type="text" name="quick_pay_domain" value="<?php echo C('quick_pay_domain');?>" placeholder="" class="form-control">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label">支付appid</label>
									<div class="col-sm-6">
										<input type="text" name="quick_pay_appid" value="<?php echo C('quick_pay_appid');?>" placeholder="" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">是否开放聊天</label>
									<div class="col-sm-6">
										<select class="form-control" name="is_say">
											<option <?php if(C('is_say') == 1): ?>selected<?php endif; ?>  value="1" >是</option>
											<option <?php if(C('is_say') == 0): ?>selected<?php endif; ?>  value="0">否</option>
										</select>
										<span>（修改后需要重启服务生效）</span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">是否重复上下分语音</label>
									<div class="col-sm-6">
										<select class="form-control" name="is_repeat_voice">
											<option <?php if(C('is_repeat_voice') == 1): ?>selected<?php endif; ?>  value="1" >是</option>
											<option <?php if(C('is_repeat_voice') == 0): ?>selected<?php endif; ?>  value="0">否</option>
										</select>
										<span></span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">管理员是否能删除订单</label>
									<div class="col-sm-6">
										<select class="form-control" name="is_del_order">
											<option <?php if(C('is_del_order') == 1): ?>selected<?php endif; ?>  value="1" >是</option>
											<option <?php if(C('is_del_order') == 0): ?>selected<?php endif; ?>  value="0">否</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">玩家是否能取消订单</label>
									<div class="col-sm-6">
										<select class="form-control" name="is_cancel_order">
											<option <?php if(C('is_cancel_order') == 1): ?>selected<?php endif; ?>  value="1" >是</option>
											<option <?php if(C('is_cancel_order') == 0): ?>selected<?php endif; ?>  value="0">否</option>
										</select>
									</div>
								</div>


								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<label class="col-sm-3 control-label">北京赛车封盘时间</label>
									<div class="col-sm-6">
										<input type="text" name="pk10_stop_time" value="<?php echo C('pk10_stop_time');?>" placeholder="60" class="form-control">秒
										<span>（建议60秒，修改后需要重启服务生效）</span>
									</div>

								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">极速赛车封盘时间</label>
									<div class="col-sm-6">
										<input type="text" name="er75sc_stop_time" value="<?php echo C('er75sc_stop_time');?>" placeholder="20" class="form-control">秒
										<span>（建议20秒，修改后需要重启服务生效）</span>
									</div>

								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">幸运飞艇封盘时间</label>
									<div class="col-sm-6">
										<input type="text" name="ft_stop_time" value="<?php echo C('ft_stop_time');?>" placeholder="60" class="form-control">秒
										<span>（建议60秒，修改后需要重启服务生效）</span>
									</div>

								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">重庆时时彩封盘时间</label>
									<div class="col-sm-6">
										<input type="text" name="ssc_stop_time" value="<?php echo C('ssc_stop_time');?>" placeholder="60" class="form-control">秒
										<span>（建议60-70秒，修改后需要重启服务生效）</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">盛發财富北京28封盘时间</label>
									<div class="col-sm-6">
										<input type="text" name="bj28_stop_time" value="<?php echo C('bj28_stop_time');?>" placeholder="60" class="form-control">秒
										<span>（建议60秒，修改后需要重启服务生效）</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">盛發财富加拿大28封盘时间</label>
									<div class="col-sm-6">
										<input type="text" name="jnd28_stop_time" value="<?php echo C('jnd28_stop_time');?>" placeholder="60" class="form-control">秒
										<span>（建议40秒以上，修改后需要重启服务生效）</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">盛發财富新加坡28封盘时间</label>
									<div class="col-sm-6">
										<input type="text" name="xjp28_stop_time" value="<?php echo C('xjp28_stop_time');?>" placeholder="60" class="form-control">秒
										<span>（建议60秒，修改后需要重启服务生效）</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">快3封盘时间</label>
									<div class="col-sm-6">
										<input type="text" name="k3_stop_time" value="<?php echo C('k3_stop_time');?>" placeholder="60" class="form-control">秒
										<span>（建议60秒，修改后需要重启服务生效）</span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">六合彩封盘时间</label>
									<div class="col-sm-6">
										<input type="text" name="lhc_stop_time" value="<?php echo C('lhc_stop_time');?>" placeholder="0" class="form-control">分
										<span>（开盘前分钟，修改后需要重启服务生效）</span>
									</div>
								</div>

								<div class="hr-line-dashed"></div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label">是否开盘北京赛车</label>
									<div class="col-sm-6">
										<input type="radio" value="1" <?php if(C('is_open_pk10') == 1): ?>checked<?php endif; ?> class="i-checks" name="is_open_pk10">开启&nbsp;&nbsp;
										<input type="radio" value="0" <?php if(C('is_open_pk10') == 0): ?>checked<?php endif; ?> class="i-checks" name="is_open_pk10">关闭
										<br><br>
										开始时间：<input type="text" name="is_open_pk10_begin_time" value="<?php echo C('is_open_pk10_begin_time');?>" placeholder="09:00:00" class="form-control">
										结束时间：<input type="text" name="is_open_pk10_end_time" value="<?php echo C('is_open_pk10_end_time');?>" placeholder="23:59:59" class="form-control">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label">是否开盘幸运飞艇</label>
									<div class="col-sm-6">
										<input type="radio" value="1" <?php if(C('is_open_xyft') == 1): ?>checked<?php endif; ?> class="i-checks" name="is_open_xyft">开启&nbsp;&nbsp;
										<input type="radio" value="0" <?php if(C('is_open_xyft') == 0): ?>checked<?php endif; ?> class="i-checks" name="is_open_xyft">关闭
										<br><br>
										开始时间：<input type="text" name="is_open_xyft_begin_time" value="<?php echo C('is_open_xyft_begin_time');?>" placeholder="13:05:00" class="form-control">
										结束时间(第二天)：<input type="text" name="is_open_xyft_end_time" value="<?php echo C('is_open_xyft_end_time');?>" placeholder="04:05:00" class="form-control">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label">是否开盘北京28</label>
									<div class="col-sm-6">
										<input type="radio" value="1" <?php if(C('is_open_bj28') == 1): ?>checked<?php endif; ?> class="i-checks" name="is_open_bj28">开启&nbsp;&nbsp;
										<input type="radio" value="0" <?php if(C('is_open_bj28') == 0): ?>checked<?php endif; ?> class="i-checks" name="is_open_bj28">关闭
										<br><br>
										开始时间：<input type="text" name="is_open_bj28_begin_time" value="<?php echo C('is_open_bj28_begin_time');?>" placeholder="09:00:00" class="form-control">
										结束时间：<input type="text" name="is_open_bj28_end_time" value="<?php echo C('is_open_bj28_end_time');?>" placeholder="23:59:59" class="form-control">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label">是否开盘加拿大28</label>
									<div class="col-sm-6">
										<input type="radio" value="1" <?php if(C('is_open_jnd28') == 1): ?>checked<?php endif; ?> class="i-checks" name="is_open_jnd28">开启&nbsp;&nbsp;
										<input type="radio" value="0" <?php if(C('is_open_jnd28') == 0): ?>checked<?php endif; ?> class="i-checks" name="is_open_jnd28">关闭
										<br><br>
										开始时间：<input type="text" name="is_open_jnd28_begin_time" value="<?php echo C('is_open_jnd28_begin_time');?>" placeholder="21:00:00" class="form-control">
										结束时间(第二天)：<input type="text" name="is_open_jnd28_end_time" value="<?php echo C('is_open_jnd28_end_time');?>" placeholder="19:01:00" class="form-control">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label">是否开盘重庆时时彩</label>
									<div class="col-sm-6">
										<input type="radio" value="1" <?php if(C('is_open_ssc') == 1): ?>checked<?php endif; ?> class="i-checks" name="is_open_ssc">开启&nbsp;&nbsp;
										<input type="radio" value="0" <?php if(C('is_open_ssc') == 0): ?>checked<?php endif; ?> class="i-checks" name="is_open_ssc">关闭
										<br><br>
										开始时间：<input type="text" name="is_open_ssc_begin_time" value="<?php echo C('is_open_ssc_begin_time');?>" placeholder="10:00:00" class="form-control">
										结束时间(第二天)：<input type="text" name="is_open_ssc_end_time" value="<?php echo C('is_open_ssc_end_time');?>" placeholder="02:00:00" class="form-control">
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label">是否开盘六合彩</label>
									<div class="col-sm-6">
										<input type="radio" value="1" <?php if(C('is_open_lhc') == 1): ?>checked<?php endif; ?> class="i-checks" name="is_open_lhc">开启&nbsp;&nbsp;
										<input type="radio" value="0" <?php if(C('is_open_lhc') == 0): ?>checked<?php endif; ?> class="i-checks" name="is_open_lhc">关闭
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label">是否开盘新加坡28</label>
									<div class="col-sm-6">
										<input type="radio" value="1" <?php if(C('is_open_xjp28') == 1): ?>checked<?php endif; ?> class="i-checks" name="is_open_xjp28">开启&nbsp;&nbsp;
										<input type="radio" value="0" <?php if(C('is_open_xjp28') == 0): ?>checked<?php endif; ?> class="i-checks" name="is_open_xjp28">关闭
									</div>
								</div>
								
								
								<div class="form-group">
									<label class="col-sm-3 control-label">是否开中级房间</label>
									<div class="col-sm-6">
										<input type="radio" value="1" <?php if(C('is_open_room2') == 1): ?>checked<?php endif; ?> class="i-checks" name="is_open_room2">开启&nbsp;&nbsp;
										<input type="radio" value="0" <?php if(C('is_open_room2') == 0): ?>checked<?php endif; ?> class="i-checks" name="is_open_room2">关闭
										<br><br>
										最小金额：<input type="text" name="is_open_room2_price" value="<?php echo C('is_open_room2_price');?>" placeholder="" class="form-control">
										
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label">是否开高级房间</label>
									<div class="col-sm-6">
										<input type="radio" value="1" <?php if(C('is_open_room3') == 1): ?>checked<?php endif; ?> class="i-checks" name="is_open_room3">开启&nbsp;&nbsp;
										<input type="radio" value="0" <?php if(C('is_open_room3') == 0): ?>checked<?php endif; ?> class="i-checks" name="is_open_room3">关闭
										<br><br>
										最小金额：<input type="text" name="is_open_room3_price" value="<?php echo C('is_open_room3_price');?>" placeholder="" class="form-control">
										
									</div>
								</div>
								
								<!--<div class="form-group">
									<label class="col-sm-3 control-label">北京赛车采集设置</label>
									<div class="col-sm-6">
										<select class="form-control pk10_kj_select" name="pk10_kj_select">
											<option <?php if(C('pk10_kj_select') == 1): ?>selected<?php endif; ?>  value="1" >使用本系统自带采集开盘</option>
											<option <?php if(C('pk10_kj_select') == 2): ?>selected<?php endif; ?>  value="2">使用彩票控接口开盘</option>
										</select>
									</div>
								</div>
								<div class="form-group pk10_api"  <?php if(C('pk10_kj_select') == 1): ?>style='display:none'<?php endif; ?> >
									<label class="col-sm-3 control-label">彩票控北京赛车接口</label>
									<div class="col-sm-6">
										<input type="text" name="pk10_api" value="<?php echo C('pk10_api');?>" placeholder="http://api.kaijiangtong.com/lottery/?name=bjpks&format=json&uid=&token=79f6d380de334fed70722118b413e" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">幸运飞艇采集设置</label>
									<div class="col-sm-6">
										<select class="form-control xyft_kj_select" name="xyft_kj_select">
											<option <?php if(C('xyft_kj_select') == 1): ?>selected<?php endif; ?>  value="1" >使用本系统自带采集开盘</option>
											<option <?php if(C('xyft_kj_select') == 2): ?>selected<?php endif; ?>  value="2">使用彩票控接口开盘</option>
										</select>
									</div>
								</div>
								<div class="form-group xyft_api"  <?php if(C('xyft_kj_select') == 1): ?>style='display:none'<?php endif; ?> >
									<label class="col-sm-3 control-label">彩票空幸运飞艇接口</label>
									<div class="col-sm-6">
										<input type="text" name="xyft_api" value="<?php echo C('xyft_api');?>" placeholder="http://api.kaijiangtong.com/lottery/?name=bjpks&format=json&uid=&token=79f6d380de334fed70722118b413e" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">重庆时时彩采集设置</label>
									<div class="col-sm-6">
										<select class="form-control ssc_kj_select" name="ssc_kj_select">
											<option <?php if(C('ssc_kj_select') == 1): ?>selected<?php endif; ?>  value="1" >使用本系统自带采集开盘</option>
											<option <?php if(C('ssc_kj_select') == 2): ?>selected<?php endif; ?>  value="2">使用彩票控接口开盘</option>
										</select>
									</div>
								</div>
								<div class="form-group ssc_api"  <?php if(C('ssc_kj_select') == 1): ?>style='display:none'<?php endif; ?> >
									<label class="col-sm-3 control-label">彩票控重庆时时彩接口</label>
									<div class="col-sm-6">
										<input type="text" name="ssc_api" value="<?php echo C('ssc_api');?>" placeholder="http://api.kaijiangtong.com/lottery/?name=bjpks&format=json&uid=&token=79f6d380de334fed70722118b413e" class="form-control">
									</div>
								</div>


								<div class="form-group">
									<label class="col-sm-3 control-label">盛發财富北京28采集设置</label>
									<div class="col-sm-6">
										<select class="form-control bj28_kj_select" name="bj28_kj_select">
											<option <?php if(C('bj28_kj_select') == 1): ?>selected<?php endif; ?>  value="1" >使用本系统自带采集开盘</option>
											<option <?php if(C('bj28_kj_select') == 2): ?>selected<?php endif; ?>  value="2">使用彩票控接口开盘</option>
										</select>
									</div>
								</div>
								<div class="form-group bj28_api"  <?php if(C('bj28_kj_select') == 1): ?>style='display:none'<?php endif; ?> >
									<label class="col-sm-3 control-label">彩票控北京快乐8接口</label>
									<div class="col-sm-6">
										<input type="text" name="bj28_api" value="<?php echo C('bj28_api');?>" placeholder="http://api.kaijiangtong.com/lottery/?name=bjpks&format=json&uid=&token=79f6d380de334fed70722118b413e" class="form-control">
									</div>
								</div>


								<div class="form-group">
									<label class="col-sm-3 control-label">盛發财富北京28采集设置</label>
									<div class="col-sm-6">
										<select class="form-control jnd28_kj_select" name="jnd28_kj_select">
											<option <?php if(C('jnd28_kj_select') == 1): ?>selected<?php endif; ?>  value="1" >使用本系统自带采集开盘</option>
											<option <?php if(C('jnd28_kj_select') == 2): ?>selected<?php endif; ?>  value="2">使用彩票控接口开盘</option>
										</select>
									</div>
								</div>
								<div class="form-group jnd28_api"  <?php if(C('jnd28_kj_select') == 1): ?>style='display:none'<?php endif; ?> >
									<label class="col-sm-3 control-label">彩票控北京快乐8接口</label>
									<div class="col-sm-6">
										<input type="text" name="jnd28_api" value="<?php echo C('jnd28_api');?>" placeholder="http://api.kaijiangtong.com/lottery/?name=bjpks&format=json&uid=&token=79f6d380de334fed70722118b413e" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label">快3采集设置</label>
									<div class="col-sm-6">
										<select class="form-control k3_kj_select" name="k3_kj_select">
											<option <?php if(C('k3_kj_select') == 1): ?>selected<?php endif; ?>  value="1" >使用本系统自带采集开盘</option>
											<option <?php if(C('k3_kj_select') == 2): ?>selected<?php endif; ?>  value="2">使用彩票控接口开盘</option>
										</select>
									</div>
								</div>
								<div class="form-group k3_api"  <?php if(C('k3_kj_select') == 1): ?>style='display:none'<?php endif; ?> >
									<label class="col-sm-3 control-label">彩票控北京快乐8接口</label>
									<div class="col-sm-6">
										<input type="text" name="k3_api" value="<?php echo C('k3_api');?>" placeholder="http://api.kaijiangtong.com/lottery/?name=bjpks&format=json&uid=&token=79f6d380de334fed70722118b413e" class="form-control">
									</div>
								</div>-->

								<div class="hr-line-dashed"></div>
								<div class="form-group">
									<div class="col-sm-4 col-sm-offset-2">
										<button class="btn btn-primary" type="submit">保存信息</button>&nbsp;&nbsp;&nbsp;
										<a class="btn btn-danger" href="<?php echo U('Index/index');?>">取消</a>
									</div>
								</div>
								
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
		<script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
		<script src="/Public/Admin/js/content.min.js?v=1.0.0"></script>
		<script src="/Public/Common/js/ajaxForm.js"></script>
		<script src="/Public/Common/layer/layer.js"></script>
		<script src="/Public/Admin/js/plugins/iCheck/icheck.min.js"></script>
		<script>
			$('.pk10_kj_select').change(function(){
				if ($(this).val() == 2) {
					$('.pk10_api').show();
				}else {
					$('.pk10_api').hide();
				}
			})

			$('.xyft_kj_select').change(function(){
				if ($(this).val() == 2) {
					$('.xyft_api').show();
				}else {
					$('.xyft_api').hide();
				}
			})

			$('.ssc_kj_select').change(function(){
				if ($(this).val() == 2) {
					$('.ssc_api').show();
				}else {
					$('.ssc_api').hide();
				}
			})

			$('.bj28_kj_select').change(function(){
				if ($(this).val() == 2) {
					$('.bj28_api').show();
				}else {
					$('.bj28_api').hide();
				}
			})

			$('.jnd28_kj_select').change(function(){
				if ($(this).val() == 2) {
					$('.jnd28_api').show();
				}else {
					$('.jnd28_api').hide();
				}
			})

			$('.k3_kj_select').change(function(){
				if ($(this).val() == 2) {
					$('.k3_api').show();
				}else {
					$('.k3_api').hide();
				}
			})

			$(document).ready(function() {
				$(".i-checks").iCheck({
					checkboxClass: "icheckbox_square-green",
					radioClass: "iradio_square-green",
				})
			});
		</script>
		<script>
			$(function(){
				$('#signform').ajaxForm({
					success: complete, 
					dataType: 'json'
				});
				function complete(data){
					if(data.status==1){
						$('.btn-primary').attr('disabled','disabled');
						layer.msg(data.info, function(index){
			 				layer.close(index);
							window.location.href=data.url;
						});
					}else{
						layer.msg(data.info);
						return false;	
					}
				}
			});
		</script>
	</body>

</html>