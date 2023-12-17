<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="target-densitydpi=320,width=750,user-scalable=no" name="viewport" />
    <meta content="no" name="apple-touch-fullscreen" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />

    <title>cá nhân - Vinper </title>
    <!--<link href="/statics/web/css/css.css" rel="stylesheet" type="text/css">
    <script src="/statics/web/js/jquery.1.8.2.min.js"></script>
    <script src="/statics/web/js/style.js"></script>-->
    <link href="/Public/Home//statics/web/css/css.css" rel="stylesheet" type="text/css">
<link href="/Public/Home//statics/web/css/red.css" rel="stylesheet" type="text/css"><script src="/Public/Home//statics/web/js/jquery.1.8.2.min.js"></script><script src="/Public/Home//statics/web/js/style.js"></script>
    <!-- layer -->
    <script src="/Public/Home//statics/web/extend/layer/mobile/layer.js"></script>
    <!-- layer - end -->
</head>
<body>
<header class="head_my">
    <h1>cá nhân</h1>
    <div class="headerRight">
       <!--  <span class="set" data-href="https://1ww-pc3333.com/?m=web&c=user&a=setup">设置</span> -->
        <!--<ul>-->
            <!--<li class="icoNews" data-new="" data-href="https://1ww-pc3333.com/?m=web&c=message&a=index&type=1&flag_m=4"></li>-->
            <!--<li class="icoAdd"><a href="#"></a> </li>-->
        <!--</ul>-->

    </div>
</header>
<section>
    <div class="my">
       

        <div class="head">
            <div class="head_left" data-href="#">
                <div class="icon">
                    <img src="/Public/Home/img/face/1.png" />
                </div>
                            
                            </div>

            <div class="user_info">
                <span class="user_name"><?php echo ($user["nickname"]); ?></span>
				 <span class="left">Tôi元宝:<em class="myIntegral"><?php echo ($user["points"]); ?></em></span>
				 <span class="left">Tôi余额宝:<em class="myIntegral"><?php echo ($user["treasure_capital"]); ?></em></span>

            </div>

            <div class="head_right play" data-href="?m=web&c=user&a=honorDetails"></div>

                    </div>
				 <ul>
           
        </ul>
		 <!-- <ul> -->
            <!-- <li data-href="/Home/User/offline?id=<?php echo ($user["id"]); ?>'"><div><label class="icoWallet">推广佣金 <?php echo ((isset($user["yong"]) && ($user["yong"] !== ""))?($user["yong"]):"0"); ?> 元宝　下线 <?php echo ($user["t_account"]); ?> 人</label></div></li> -->
        <!-- </ul> -->
        
        <ul>
            <li data-href="<?php echo U('Home/Fen/addpage');?>"><div><label class="icoWallet">Nạp trực tuyến</label></div></li>
        </ul>
        <ul>
            <li data-href="<?php echo U('Home/Fen/xiapage');?>"><div><label class="icoAgent">快速提现</label></div></li> </ul>
        <!-- <ul>     <li data-href="<?php echo U('Home/Run/tui');?>?uid=<?php echo ($userinfo["id"]); ?>"><div><label class="icoShare">代理分享</label><span><img src="/Public/Home//statics/web/images/person_ercode_icon@2x.png" /></span></div></li> -->
        <!-- </ul> -->
        <ul>
            <li data-href="/Home/Run/record"><div><label class="icoRecord">投注记录</label></div></li>
                    </ul>
        <ul>
            <li data-href="/Home/User/fenxia"><div><label class="icoActivity">提现记录</label></div></li>
        </ul>
		
		 <ul>
            <li data-href="/Home/Run/treasure"><div><label class="icoYuEBao">Tôi余额宝</label></div></li>
        </ul>
		
		<ul> <li data-href="<?php echo U('Home/Index/logout');?>"><div><label class="icoShare">đăng xuất</label></div></li>
        </ul>
        
    </div>
</section>
<div class="popup" style="display:none"></div>
<div id="mask" class="mask" onclick="hideMask()"  style="display:none">
    <img src="<?php if($kefu[kefu] != ''): ?>/Uploads/<?php echo ($kefu[kefu]); else: ?>/Public/Admin/img/no_img.jpg<?php endif; ?>" />
</div>
<script type="text/javascript">
    function showMask(){
        $("#mask").css("height",$(document).height());
        $("#mask").css("width",$(document).width());
        $("#mask").show();
    }
    function hideMask(){
        $("#mask").hide();
    }
</script>
<script type="text/javascript">
	
    $(function(){
        var isShow_honor = Number(1); //0关 1开
        if(isShow_honor == 0){
            $(".head_right").hide();
            $(".integral").hide();
        }
    	var grade = Number(1);
        var firstScore = Number(0);
        var lastScore = Number(4999);
        var myScore = Number(0);
        var next_status = Number(0);
        var is_upgrade = Number(0);  //1:需要弹出恭喜升级框，0：不用处理

        //积分升级弹窗
        if(is_upgrade == 1){
            if(grade > 0){
               getHonorBox();
            }
        }
        //点击关闭积分升级弹窗
        $("body").on("click",".upgrade-close",function(){
            $(".popup").fadeOut(function(){
                giveNotice();
            });
        })

        //徽章动画效果
//        if(grade == 1){
            $(".play").css({'animation-name': 'myalter0'+grade,
                '-moz-animation-name': 'myalter0'+grade,
                '-webkit-animation-name': 'myalter0'+grade,
                '-o-animation-name': 'myalter0'+grade,
            });
//        }else if(grade == 2){
//            $(".play").css({'animation-name': 'myalter02',})
//        }

        //升级经验条
        if (next_status == 1) {
        	 var wid = myScore/myScore*500;
             $(".line").animate({width: wid}, 2000);
        } else {
        	var wid = myScore/lastScore*500;
            $(".line").animate({width: wid}, 2000);
        }

        //获取新消息
//        getMessage();
        //博饼活动
        var a = "";
        $("#bobing").click(function(e){
            console.log(a)
            e.preventDefault();
        })

        isActivity()
    })

    function isActivity(){
        $.ajax({
            url : "?m=api&c=turntable&a=fetch_activity_setting",
            type : 'POST',
            data : {},
            dataType:"json",
            success: function(data){
                if(data.status==0){
                    console.log(data);
                    if(Number(data.turntable_running) == 0){
                        $("#turntable").removeAttr("data-href");
                        $("#turntable div").append("<span>新活动暂未开启</span>");
//                        $("#turntable").click(function(){
//                            layer.open({
//                                content: '幸运大转盘活动已关闭',
//                                skin: 'msg',
//                                time: 2 //2秒后自动关闭
//                            });
//                        });
                    }
                    if(Number(data.bo_bing_info.state) == 0){
                        $("#bobing").removeAttr("data-href");
//                        $("#bobing").click(function(){
//                            layer.open({
//                                content: '中秋博饼活动已关闭',
//                                skin: 'msg',
//                                time: 2 //2秒后自动关闭
//                            });
//                        });
                    }
                    if(Number(data.christmas_info.state) == 0){
                        $("#christmas").removeAttr("data-href");
//                        $("#christmas").click(function(){
//                            layer.open({
//                                content: '双旦有礼活动已关闭',
//                                skin: 'msg',
//                                time: 2 //2秒后自动关闭
//                            });
//                        });
                    }
                }else{
                    layer.open({
                        content: data.ret_msg,
                        skin: 'msg',
                        time: 2 //2秒后自动关闭
                    });
                }
            }
        });

    }

    //获取荣誉机制状态
    function getHonorBox() {
        var data = {
            "token": 'e68eq5gb5g17m2teisbt2s3913'
        }
        $.ajax({
            url : "?m=web&c=user&a=getHonorBox",
            type : 'POST',
            data : data,
            dataType:"json",
            success: function(data){
            	if (data.code == 1) {
            		var html = '<div class="upgrade-pop"><div class="upgrade-shine_bg"></div><div class="upgrade-wrap"><div class="upgrade-con">'+
                    '<div class="upgrade-info"></div><div class="upgrade-badge"></div>'+
                    '<div class="upgrade-name"></div><div class="upgrade-close"></div></div></div></div>';
		            $(".popup").html(html);
		            $(".upgrade-badge").css("background", "url(/statics/web/images/honor/badge0"+data.grade+"@2x.png) no-repeat center center");
		            $(".upgrade-name").css("background", "url(/statics/web/images/honor/fame0"+data.grade+"@2x.png) no-repeat center center");
		            $(".popup").fadeIn();
            	}
            }
        });
    }

    function giveNotice () {
        var data = {
            "token": 'e68eq5gb5g17m2teisbt2s3913'
        }
        $.ajax({
            url : "?m=web&c=user&a=closeHonorBox",
            type : 'POST',
            data : data,
            dataType:"json",
            success: function(data){
            }
        });
    }
</script><nav>
    <ul>
        <li class="active" data-href="<?php echo U('Home/run/index');?>">Home</li>
        <li data-href="<?php echo U('Home/Fen/addpage');?>">Nạp</li>
       <li data-href="http://103.166.184.168/im.htm?xtid=131830">cskh</li>
        
       
        
        <li data-href="<?php echo U('Home/User/index');?>">Tôi</li>

    </ul>
</nav><script type="text/javascript">
    $(function() {
        //获取当前选项
        $.ajax({
            url: '?m=api&c=app&a=customerType',
            type: 'post',
            success: function(res){
                res=JSON.parse(res);
                $('#kefuUrl').attr('data-href',res.info[res.info.length-1].value)
            },
            error: function(err){
            }
        })
        var getUrlParam = function(e){
            var array = location.search.slice(1).split('&'), obj = {};
            for (var i = 0; i < array.length; i++){
                var key = array[i].split('=')[0],
                        val = array[i].split('=')[1];
                obj[key] = val;
            }
            return obj[e] || null;
        }
        var getParam = function(url,e){
            //console.log(url);
            var array = url.slice(1).split('&'), obj = {};
            for (var i = 0; i < array.length; i++){
                var key = array[i].split('=')[0],
                        val = array[i].split('=')[1];
                obj[key] = val;
            }
            return obj[e] || null;
        }

        var n_c = getUrlParam('c');
        var n_a = getUrlParam('a');
        var now_href = n_c+n_a;
        //var now_href = window.location.href;
       // console.log(now_href);
        $("nav ul li").each(function() {
            var href =  $(this).attr("data-href");
            var c = getParam(href,'c');
            var a = getParam(href,'a');
            var href = c+a;
            //console.log(href);
            if (now_href == href) {
                $("nav ul li").removeClass("active");
                $(this).addClass("active");
            }
        });
    })


</script>
</body>
</html>