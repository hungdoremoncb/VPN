<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="/Public/Home/new/css/index.css" />
  <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js" type="text/javascript"></script>
    <style type="text/css">
    a { -webkit-tap-highlight-color:rgba(0,0,0,0);}
 </style>
<style>
.main{margin-top:25px;}
.offaccount {background: #ffefef;padding:2em 1em 0.6em;border-radius: 5px;/*overflow:auto;zoom:1;*/margin-bottom:1em; border: #faa solid 1px;height: 48em;}
.offaccount p{color: #333;line-height:2.3em;}
.offaccount p i{color: #FD947E;border-radius: 3px;border:#FD947E solid 1px;padding:1px 8px;float:right;line-height: 1.5em;font-size: .9em;height: 1.5em;}
.offaccount p input{border:none;background:none;}
.offpay h3{font-size:1.2em;line-height:1em;height:1em;margin:1.5em 0 .3em;border-left:#FD645E solid 4px;padding-left:.5em;font-weight: normal;}
.offform{line-height:1.8em}
.offform li span{color: #ff0000;margin-top: .4em;display: inline-block;font-size: 1.1em;}
.offform input{display:block;height:2.7em;line-height:2.7em;width: 98%; border:solid #c0c0c0 0.3px;color:#330000;border-radius: 3px;padding-left: 2%;font-size: 1.1em;}
.wxts p{margin: .5em 0;color: #aaa;line-height:1.2em;font-size: .9em;}

.title1{width: 12em;height: 2em;color: white;text-align: center;line-height: 2em;background: #FD645E;margin:0 auto;display: block;margin-top: -51em;border:none;outline: none;border-radius: 3px;}
@media screen and (min-width: 401px)  {/*苹果PLUS*/
	div.title1{margin-top: -50em;}
	
}


</style>
 </HEAD>
<script src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script>
<script>
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
    WeixinJSBridge.call('hideOptionMenu');
});
</script>

 <BODY>
  <header>
 	 <i class="ico02 back fl" onclick="history.go(-1)"></i>
	 <h1>游戏规则</h1>	
	 <i class="ico null"></i>	 
  </header>
  <div class="headblank"></div>
  <div class="main1 offpay" style='margin-bottom:40px;'>
	  <div class="offaccount">
		  <p><b>【玩法介绍】</b>：<br>
        开盘号码0-27。0-13为小，14-27为大<br>
		0-5为极小，22-27为极大<br>
        奇数为单，偶数为双，组合为大双/小单/大单/小双<br>
<b>【常规赔率】</b>：<br>
        大小单双<?php echo C('bj28_dxds');?>倍，单点极值<?php echo C('bj28_jdx');?>倍<br>
        大双/小单<?php echo C('bj28_zuhe_2');?>倍，大单/小双<?php echo C('bj28_zuhe_1');?>倍<br>
<b>【特殊赔率】</b>：<br>
        总注<?php echo C('bj28_dxds_1314zz');?>以下大小单双开13/14时赔1.5倍.组合保本<br>
        总注<?php echo C('bj28_dxds_1314zz2');?>以上大小单双开13/14时回本.组合保本。<br>
<b>【单点赔率】</b>：<br>
        12.15赔 <?php echo C('bj28_tema_12');?>倍    13.14赔 <?php echo C('bj28_tema_13');?>倍<br>
        10.17赔 <?php echo C('bj28_tema_10');?>倍    11.16赔 <?php echo C('bj28_tema_11');?>倍<br>
        08.19赔 <?php echo C('bj28_tema_8');?>倍    09.18赔 <?php echo C('bj28_tema_9');?>倍<br>
        06.21赔 <?php echo C('bj28_tema_6');?>倍    07.20赔 <?php echo C('bj28_tema_7');?>倍<br>
        04.23赔 <?php echo C('bj28_tema_4');?>倍    05.22赔 <?php echo C('bj28_tema_5');?>倍<br>
        02.25赔 <?php echo C('bj28_tema_2');?>倍    03.24赔 <?php echo C('bj28_tema_3');?>倍<br>
        00.27赔<?php echo C('bj28_tema_0');?>倍    01.26赔<?php echo C('bj28_tema_1');?>倍<br>
<b>【下注说明】</b>：<br>
		最低下注20元起		总注3万封顶<br>
		大小单双10000封顶	组合5000封顶<br>
		极大极小2000封顶	数字单点2000封顶<br>
</p>
		  <div class="title1">【<?php echo C('sitename');?>】</div>
	  </div>
</div>
 </BODY>
</HTML>