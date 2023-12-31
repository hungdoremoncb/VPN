<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>后台 - Home - Vinper </title>
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
		<div class="row">
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-success pull-right">今天</span>
                        <h5>平台输赢</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?php echo ($data["today_ying"]); ?></h1>
                        <div class="stat-percent font-bold text-success"> <i class="fa fa-bolt"></i>
                        </div>
                        <small>收入</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-info pull-right">最近一个月</span>
                        <h5>平台输赢</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?php echo ($data["all_ying"]); ?></h1>
                        <div class="stat-percent font-bold text-info"><i class="fa fa-level-up"></i>
                        </div>
                        <small>总收入</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-primary pull-right">今天</span>
                        <h5>新增用户</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?php echo ($data["today_user"]); ?></h1>
                        <div class="stat-percent font-bold text-navy"> <i class="fa fa-level-up"></i>
                        </div>
                        <small>新增</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-danger pull-right">最近一个月</span>
                        <h5>新增用户</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?php echo ($data["month_user"]); ?></h1>
                        <div class="stat-percent font-bold text-danger"><i class="fa fa-level-up"></i>
                        </div>
                        <small>新增</small>
                    </div>
                </div>
            </div>
        </div>
		
		
		
		<div class="row">
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-success pull-right">今天</span>
                        <h5>今天上分统计</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?php echo ($data["fenadd"]); ?></h1>
                        <div class="stat-percent font-bold text-success"> <i class="fa fa-bolt"></i>
                        </div>
                        <small>收入</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-info pull-right">今天</span>
                        <h5>今天下分统计</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?php echo ($data["fenxia"]); ?></h1>
                        <div class="stat-percent font-bold text-info"><i class="fa fa-level-up"></i>
                        </div>
                        <small>收入</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-primary pull-right">玩家人数</span>
                        <h5>真实玩家</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?php echo ($data["usernumber"]); ?></h1>
                        <div class="stat-percent font-bold text-navy"> <i class="fa fa-level-up"></i>
                        </div>
                        <small>总数</small>
                    </div>
                </div>
            </div>
            <!-- <div class="col-sm-3"> -->
                <!-- <div class="ibox float-e-margins"> -->
                    <!-- <div class="ibox-title"> -->
                        <!-- <span class="label label-danger pull-right">最近一个月</span> -->
                        <!-- <h5>新增用户</h5> -->
                    <!-- </div> -->
                    <!-- <div class="ibox-content"> -->
                        <!-- <h1 class="no-margins"><?php echo ($data["month_user"]); ?></h1> -->
                        <!-- <div class="stat-percent font-bold text-danger"><i class="fa fa-level-up"></i> -->
                        <!-- </div> -->
                        <!-- <small>新增</small> -->
                    <!-- </div> -->
                <!-- </div> -->
            <!-- </div> -->
        </div>
		
		
		
		<div class="row">
            <div class="col-sm-4">

                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>开发申明</h5>
                    </div>
                    <div class="ibox-content">
                        <p>
                        	 云水滴大数据有限公司开发，采用SG11加密请勿解密
                        	 <br>
                        	 请勿用于非法及商业用途 
                        	 <br> 
                        	 如产生法律纠纷，与开发者本人无关
                        	 <br>
   							您使用本源码起，将视为您已经接受本申明
                        </p>
                       
                    </div>
                </div>
                <!--<div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>联系信息</h5>

                    </div>
                    <div class="ibox-content">
                       <!--  <p><i class="fa fa-qq"></i> QQ：<a href="http://wpa.qq.com/msgrd?v=3&amp;uin=2580930233&amp;site=qq&amp;menu=yes" target="_blank">2580930233</a>
                        </p> -->
                  		<!--&nbsp;&nbsp;&nbsp;&nbsp;<font>授权时间至：</font>
						<?php if($auth["end_time"] < strtotime('2038-01-01')): ?><font class="end_time"><?php echo (date('Y-m-d',$auth["end_time"])); ?></font>
						<?php else: ?>
							永久<?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>更新日志</h5>
                    </div>
                    <div class="ibox-content no-padding">
                        <div class="panel-body">
                            <div class="panel-group" id="version">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#version" href="#v76">v7.7</a>
                                        </h5>
                                </div>
                                <div id="v76" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <ol>
                                            <li>新增代理后台管理功能</li>
                                            <li>新增赛车、飞艇、时时彩下注号码限制最高，如12/45/1000,可以限制每个号码最高为1000</li>
                                            <li>新增代理操作返水，代理设置返水比例</li>
                                            <li>新增可以换配置代理进行上下分</li>
                                            <li>新增可以配置自动返回，每天9点返水前一天的用户返水</li>
                                           
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#version" href="#v75">v7.5</a>
                                        </h5>
                                </div>
                                <div id="v75" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <ol>
                                            <li>增加盛發财富北京28彩种</li>
                                            <li>增加盛發财富加拿大28彩种</li>
                                            <li>增加后台可批量删除订单功能</li>
                                            <li>增加可配置客户是否可删除订单</li>
                                            <li>赛车、飞艇玩法规则优化：123/大/100规则改成123大100，如果是大100，则默认为1大100，还有和3.4.6/100规则由华为和341819/100规则</li>
                                            <li>优化细节</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>


                             <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#version" href="#v73">v7.3</a>
                                        </h5>
                                </div>
                                <div id="v73" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <ol>
                                            <li>增加取消功能</li>
                                            <li>增加代理结算功能，通过平台输赢点击进去</li>
                                            <li>各彩种的开盘记录走势更新</li>
                                            <li>修复前台代理推广功能</li>
                                            <li>增加盛發财富北京28基础版</li>
                                            <li>修复一些已知bug</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>


                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#version" href="#v72">v7.2</a>
                                        </h5>
                                </div>
                                <div id="v72" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <ol>
                                            <li>增加可以设置会员为假人功能，投注不算入记录</li>
                                            <li>进一步增强系统稳定性</li>
                                            <li>增加可以选择Home风格，两个风格任意选择</li>
                                            <li>修复一些小bug</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#version" href="#v71">v7.1</a>
                                        </h5>
                                </div>
                                <div id="v71" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ol>
                                            <li>增加控制选择彩种功能，可任何搭配彩种</li>
                                            <li>修复一些已知bug</li>
                                            <li>增加删除订单功能，订单删除，代理的佣金、记录都会去掉</li>
                                            <li>增加手动开盘，加入管理员日志</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#version" href="#v70">v7.0</a>
                                        </h5>
                                </div>
                                <div id="v70" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ol>
                                            <li>新增时时彩彩种</li>
                                            <li>赛车、飞艇彩种分离</li>
                                            <li>三合一玩法</li>
                                            <li>后台各需要项分离显示</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#version" href="#v60">v6.0</a>
                                        </h5>
                                </div>
                                <div id="v60" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ol>
                                            <li>冠亚和值倍率可以自由设置11为和或者小</li>
                                            <li>新增可以配置自由聊天功能</li>
                                            <li>新增采集到数据，cskh自动播报开盘数据</li>
                                            <li>新增不同的玩法，最高下注限制，可以每期玩家下注总额限制</li>
                                            <li>其他一些细节优化</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>


                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#version" href="#v59">v5.9</a>
                                        </h5>
                                </div>
                                <div id="v59" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ol>
                                            <li>新增手动添加开盘功能（偶尔采集出问题时，可用来手动开盘）</li>
                                            <li>新增修改会员上线功能</li>
                                            <li>新增开放窗口聊天功能</li>
                                            <li>新增上下分申请语音重复播报，可配置是否需要</li>
                                            <li>新增统计系统会员余分功能</li>
                                            <li>新增修改推广二维码图片功能</li>
                                            <li>新增查看上线功能</li>
                                            <li>新增推广统计中，统计每个推广的下线所有的总的上下分记录，下注记录，结算无任何障碍</li>
                                            <li>新增修改机器人下注频率（赛车飞艇配置中）</li>
                                            <li>其他一些优化项</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                              <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#version" href="#v58">v5.8</a>
                                        </h5>
                                </div>
                                <div id="v58" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ol>
                                            <li>新增微信用户直接绑定网页版用户，绑定后可以用网页版账户登录微信（被封后，只要用网页版登录，客户一样玩，东西都不变）</li>
                                            <li>后台管理员可以帮可以绑定网页账户，用于帮助客户直接通过网页登录微信账户</li>
                                            <li>
                                            前台开盘记录增加到最近20条，以及该界面优化</li>
                                            <li>后台机器人可以模拟上下分，增加真实性</li>
                                            <li>优化前台界面和进一步增加开盘稳定性</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#version" href="#v57">v5.7</a>
                                        </h5>
                                </div>
                                <div id="v57" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ol>
                                            <li>新增通过百度搜索进入，后台配置进入搜索值</li>
                                            <li>新增后台配置cskh欢迎语</li>
                                            <li>调慢机器人下注速度和频率</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#version" href="#v56">v5.6</a>
                                        </h5>
                                </div>
                                <div id="v56" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ol>
                                            <li>增加会员返水功能</li>
                                            <li>cá nhân中，可以将返水金额转为点数</li>
                                            <li>cá nhân更新代理查看会员的下注明细，以及增加对应的统计</li>
                                            <li>cá nhân更新代理查看会员的上下分明细，以及增加对应的统计</li>
                                            <li>前台开盘记录界面优化</li>
                                            <li>解决其他一些已知bug</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#version" href="#v44">v5.5</a>
                                        </h5>
                                </div>
                                <div id="v44" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ol>
                                            <li>cá nhân增加查看代理的下注记录和上分记录</li>
                                            <li>更换采集接口，更加稳定</li>
                                            <li>cá nhân控制是否显示推广二维码</li>
                                            <li>后台运行推广模块增加查看上级</li>
                                            <li>后台统计中可以点击tên tài khoản，直接查看用户下注记录</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#version" href="#v43">v5.4</a>
                                            </h5>
                                    </div>
                                    <div id="v43" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <ol>
                                                <li>增加后台支付宝、微信收款设置</li>
                                                <li>修复冠亚和11打和问题</li>
                                                <li>修复最后一期开盘后还能下注问题</li>
                                                <li>修复一些其他已知bug</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#version" href="#v42">v5.3</a>
                                            </h5>
                                    </div>
                                    <div id="v42" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <ol>
                                                <li>公众号版本和网页版本二合一</li>
                                                <li>优化cá nhân界面显示</li>
                                                <li>新增Đổi mật khẩu</li>
                                                <li>优化后台统计</li>
                                                <li>系统稳定性维护</li>
                                                <li>系统bug修复</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#version" href="#v41">v5.0</a>
                                            </h5>
                                    </div>
                                    <div id="v41" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <ol>
                                                <li>增加用户cá nhân</li>
                                                <li>优化后台输赢统计</li>
                                                <li>优化后台上下分统计</li>
                                                <li>整体界面优化</li>
                                                <li>更新网页版本赛车飞艇</li>
                                             	<li>系统稳定性维护</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#version" href="#v40">v4.5</a>
                                            </h5>
                                    </div>
                                    <div id="v40" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <ol>
                                                <li>用户界面下注记录统计</li>
                                                <li>整体界面优化</li>
                                                <li>上下分管理</li>
                                                <li>后台上下分声音提示</li>
                                                <li>系统稳定性维护</li>
                                               
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                                  <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#version" href="#v22">v4.1-以前</a>
                                            </h5>
                                    </div>
                                    <div id="v22" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <ol>
                                                <li>整体系统的研发</li>
                                                <li>系统逐步迭代</li>
                                                <li>完善的系统管理</li>
                                                <li>很好的用户体验</li>
                                                <li>系统的稳定性保证</li>
                                               
                                            </ol>
                                        </div>
                                    </div>
                                </div>

                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>系统说明</h5>
                    </div>
                    <div class="ibox-content">
                        <p>
                        	北京赛车幸运飞艇微信版完整版 <br>
1、公众号版本和网页版本二合一，配置微信参数，通过微信进入可以自动登录注册，网页或者QQ同样一直能运行<br>
2、公众号版本用户自动注册登录，网页版本突破微信封域名，封号限制，自己注册登录<br>
3、赛车飞艇自动切换，赛车9点到24点，飞艇0点到4点自动切换。<br>
4、自动下注，结算<br>
5、完整的用户cá nhân管理 <br>
6、上下分控制，后台声音提示上下分申请，操作上下分管理<br>
7、自带采集器，稳定采集全国开盘数据，同时可选择配置彩票控接口开盘，更快速<br>
8、代理推广，用户推广，迅速推广出去<br>
9、自带机器人，活跃网站气氛<br>
10、自带键盘，方便下注输入<br>
11、前台上下分管理，后台实时声音通知上下分，<br>
12、后台完全的输赢统计、上下分统计 <br>
13、完善的后台管理功能，系统设置，后台上下分等<br>
14、同时后台支持手机端操作，体验好<br>
                        </p>
                    </div>
                </div>-->
            </div>
        </div>
		<script src="/Public/Admin/js/jquery.min.js?v=2.1.4"></script>
		<script src="/Public/Admin/js/bootstrap.min.js?v=3.3.6"></script>
		<script src="/Public/Admin/js/content.min.js?v=1.0.0"></script>
		<script src="/Public/Common/js/ajaxForm.js"></script>
		<script src="/Public/Common/layer/layer.js"></script>
		<script>
			$(function(){
				$('#signform').ajaxForm({
					beforeSubmit: checkForm,
					success: complete, 
					dataType: 'json'
				});
				function checkForm(){
					if( '' == $.trim($('#gonggao').val())){
						layer.alert('输入公告内容', {icon: 5}, function(index){
			 			layer.close(index);
						$('#gonggao').focus(); 
						});
						return false;
					}
				}
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