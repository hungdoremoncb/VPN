<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<!--本程序来自：盛發财富（qq:2370250999） -->
<head lang="en">
    <meta charset="UTF-8">
    <meta content="target-densitydpi=320,width=750,user-scalable=no" name="viewport" />
    <meta content="no" name="apple-touch-fullscreen" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />

    <title> - Vinper </title>
    <link href="/Public/Home/statics/web/css/css.css" rel="stylesheet" type="text/css">
<link href="/Public/Home/statics/web/css/red.css" rel="stylesheet" type="text/css"><script src="/Public/Home/statics/web/js/jquery.1.8.2.min.js"></script><script src="/Public/Home/statics/web/js/style.js"></script>    <link href="/Public/Home/statics/web/css/swiper.min.css" rel="stylesheet" type="text/css">
    <!--<link href="/statics/web/css/css.css" rel="stylesheet" type="text/css">-->
    <!--<script src="/statics/web/js/jquery.1.8.2.min.js"></script>-->
    <!--<script type="text/javascript" src="/statics/web/js/yxMobileSlider.js"></script>-->
    <script type="text/javascript" src="/Public/Home/statics/web/js/swiper.jquery.min.js"></script>
    <!--<script src="/statics/web/js/style.js"></script>-->
    <script src="/Public/Home/statics/web/extend/layer/mobile/layer.js"></script>

    <style type="text/css">
        .header_wrap .headTop .xiazai {
            background-color: #5e97fe;
            position: absolute;
            right: 20px;
            width: 190px;
            height: 60px;
            overflow: hidden;
            top: 24px;
        }

        .headTop button {
            width: 190px;
            border-radius: 8px;
            float: right;
            height: 60px;
            font-size: 28px;
            margin-top: 10px;
            /* display: none; */
            line-height: 44px;
            position: absolute;
            top: -8px;
        }
        /*数字滚动插件的CSS可调整样式*/

        .mt-number-animate {
            font-family: '微软雅黑';
            line-height: 70px;
            height: 70px;
            /*设置数字显示高度*/
            ;
            font-size: 85px;
            /*设置数字大小*/
            overflow: hidden;
            display: inline-block;
            position: relative;
        }

        .mt-number-animate .mt-number-animate-dot {
            width: 15px;
            /*设置分割符宽度*/
            line-height: 40px;
            float: left;
            text-align: center;
        }

        .mt-number-animate .mt-number-animate-dom {
            width: 43px;
            /*设置单个数字宽度*/
            text-align: center;
            float: left;
            position: relative;
            top: -700px;
            border: 0;
        }

        .mt-number-animate .mt-number-animate-dom .mt-number-animate-span {
            width: 100%;
            float: left;
            background-color: #5e97fe;
            font-family: SimHei;
            /*font-size: 94px;*/
            /*text-align: left;*/
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header_wrap .headTop a {
            display: block;
            font-size: 30px;
        }

        .header_wrap .headTop .xiazai {
            background-color: #5e97fe;
            position: absolute;
            right: 20px;
        }
        .jiaobiao{position: absolute;top: 0;left: 0;}
		
		
		
		.zql{
    width: 100%;
     
    background-color: #5e97fe;
    font-family: SimHei;
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

.mt-number-animate-zql {
            font-family: '微软雅黑';
            line-height: 100px;
            height: 100px;
            /*设置数字显示高度*/
            ;
            font-size: 85px;
            /*设置数字大小*/
            overflow: hidden;
           
            position: relative;
        }

    </style>

</head>

<body>
<style>
A.applink:hover {border: 2px dotted #DCE6F4;padding:2px;background-color:#ffff00;color:green;text-decoration:none}
A.applink       {border: 2px dotted #DCE6F4;padding:2px;color:#2F5BFF;background:transparent;text-decoration:none}
A.info          {color:#2F5BFF;background:transparent;text-decoration:none}
A.info:hover    {color:green;background:transparent;text-decoration:underline}
</style>






    <div class="header_wrap">
        <div class="headTop" style="display:none;">
            <i class="head-close"></i>
            <div class="headCon">
                <div class="head-logo">
                    <img src="/Public/Home/statics/web/images/avatar.png" /> </div>
                <p>幸运是随时陪伴，走到哪玩到哪</p>
            </div>
          <!--   <div class="xiazai" style=" background-color: #5e97fe;
            position: absolute;
            right: 20px;
            width: 190px;
            height: 60px;
            overflow: hidden;
            top: 24px;">
                <a id="downIso" data-id="1" href="" class="btn" target="_self" style=" width: 190px;
                border-radius: 8px;
                float: right;
                height: 60px;
                font-size: 28px;
                margin-top: 10px;
                line-height: 44px;
                position: absolute;
                top: -8px;">
             <button class="bgCol">立即下载</button>
                </a>
                <a id="downAndroid" data-id="2" href="#" class="btn" target="_self" style=" width: 190px;
                border-radius: 8px;
                float: right;
                height: 60px;
                font-size: 28px;
                margin-top: 10px;
                /* display: none; */
                line-height: 44px;
                position: absolute;
                top: -8px;">
                <button class="bgCol">立即下载</button>
                </a>
            </div> -->

        </div>
        <script type="text/javascript">
            $("#downIso").click(function () {
                statisticsLinkCount($(this).attr("data-id"));
            });

            $("#downAndroid").click(function () {
                statisticsLinkCount($(this).attr("data-id"))
            });

            function statisticsLinkCount(type) {
                var data = {};
                data.type = type;
                $.ajax({
                    url: "?m=web&c=lobby&a=downloadNum",
                    type: 'POST',
                    data: data,
                    // async: false,
                    dataType: "json",
                    success: function (msg) {
                        console.log(msg);
                    }
                })
            }

            //判断访问终端
            var browser = {
                versions: function () {
                    var u = navigator.userAgent,
                        app = navigator.appVersion;
                    return {
                        trident: u.indexOf('Trident') > -1, //IE内核
                        presto: u.indexOf('Presto') > -1, //opera内核
                        webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
                        gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
                        mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
                        ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
                        android: u.indexOf('Android') > -1 || u.indexOf('Adr') > -1, //android终端
                        iPhone: u.indexOf('iPhone') > -1, //是否为iPhone或者QQHD浏览器
                        iPad: u.indexOf('iPad') > -1, //是否iPad
                        webApp: u.indexOf('Safari') == -1, //是否web应该程序，没有头部与底部
                        weixin: u.indexOf('MicroMessenger') > -1, //是否微信 （2015-01-22新增）
                        qq: u.match(/\sQQ/i) == " qq" //是否QQ
                    };
                }(),
                language: (navigator.browserLanguage || navigator.language).toLowerCase()
            }
            var dataNews = {}; //型号
            //判断是否IE内核
            if (browser.versions.android) {
                dataNews.app_type = 2;
            }
            //判断是否webKit内核
            if (browser.versions.ios) {
                dataNews.app_type = 1;
            }
            //判断是否移动端
            if (browser.versions.weixin || browser.versions.qq) {
                $(".mask").show();
                $(".mask").click(function () {
                    $(".mask").hide();
                });
                // return false;
            } else {
                $(".mask").hide();
            }
//            console.log(dataNews);
//            $("#downIso").hide();
//            $("#updateIso").hide();

            if (dataNews.app_type == 1) {
                $("#downIso").show();
                $("#downAndroid").hide();
            }
            if (dataNews.app_type == 2) {
                $("#downIso").hide();
                $("#updateAndroid").show();
            }
        </script>
        <header style="position: inherit; top: auto;">
            <h1></h1>
            <div class="headerRight">
                <ul>
                   <!--  <li class="icoNews" data-new="7" data-href="https://1ww-pc3333.com/?m=web&c=message&a=index&type=1&flag_m=1"></li> -->
                    <li class="icoAdd">
                        <a href="#"></a>
                    </li>
                </ul>
            </div>
            <div class="menu" style="display: none">
                <ul>
                    <li class="icoRecharge" data-href="<?php echo U('Home/user/datoupay2');?>">立即Nạp</li>
                    <li class="icoWithdraw" data-href="<?php echo U('Home/fen/xiapage');?>">我要提现</li>
                    <!-- <li class="icoRebate" data-href="https://1ww-pc3333.com/?m=web&c=app&a=rebate">天天返利</li> -->
                    <!--<li class="icoResult" data-href="https://1ww-pc3333.com/?m=web&c=openAward&a=openAwardRes">开盘结果</li>-->
                    <!--<li class="icoIntroduce" data-href="https://1ww-pc3333.com/?m=web&c=app&a=gameList">玩法介绍</li>-->
                    <!--<li class="icoTrend" data-href="https://1ww-pc3333.com/?m=web&c=openAward&a=trendChart">开盘走势</li>-->
                </ul>
            </div>
        </header>
        <!--红包浮动图标-->
        <div class="redPacket-ico vibrate" id="drag"></div>

    </div>

    <section style="padding-top:80px;">
        <div class="indexWarp">
            <!--<div class="horn"><p>公告：最新消息，来得及发圣诞节快乐福利送空间。</p></div>-->
            <div class="horn">
                <!--<span style="float: left;">公告：</span>-->
                <!-- <div id="maq" style="overflow: hidden;"> -->
                    <!-- <div class="widthGonggao"> -->
                        <!-- <div id=mtext class="gonggao" style=""> -->
                                                        <!-- <p>六合彩第093期特码:20兔(蓝)波</p> -->
                                                        <!-- <p>限时红包活动火热开启中</p> -->
                                                    <!-- </div> -->

                        <!-- <div id="m0" class="gonggao"></div> -->
						 
                    <!-- </div> -->
                <!-- </div> -->
                <!--<marquee>-->
                <!--<div class="gonggao">-->
                                <!--<p>六合彩第093期特码:20兔(蓝)波</p>-->
                                <!--<p>限时红包活动火热开启中</p>-->
                                <!--</div>-->
                <!--</marquee>-->
            </div>

<!--本程序来自：盛發财富（qq:2370250999） -->
            <!--轮播-->
            <div class="swiper">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" data-href="#">
                            <img src="/Public/Home/up_files/banner/b-1.jpg" alt="" />
                        </div>
                        <div class="swiper-slide" data-href="#">
                            <img src="/Public/Home/up_files/banner/b-2.jpg" alt="" />
                        </div>
 
                         <div class="swiper-slide" data-href="#">
                            <img src="/Public/Home/up_files/banner/b-3.jpg" alt="" />
                        </div>
						<div class="swiper-slide" data-href="#">
                            <img src="/Public/Home/up_files/banner/b-4.jpg" alt="" />
                        </div>
	
                    </div>

                </div>
                <!-- 如果需要分页器 -->
                <div class="swiper-pagination"></div>
            </div>


            <script type="text/javascript">
                var mySwiper = new Swiper('.swiper-container', {
                    direction: 'horizontal',
                    loop: true,
                    autoplay: 3000,
                    slidesPerView: "auto",
                    centeredSlides: true,
                    spaceBetween: 20,

                    // 如果需要分页器
                    pagination: '.swiper-pagination',
                })
            </script>

            <div class="statistics">
                <ul>
                    <li>
                        <i class="totalmoney"></i>
                        <span>Lợi Nhuận </span>
                        <em class="make_money">160369339</em></li>
                    <li>
                        <i class="person"></i>
                        <span>Đăng Ký </span>
                        <em class="reg_number">1166320</em>人</li>
                </ul>
                <div class="percent">

                    <div class="per_number">
                        <!--<em id="d1" class="numberRun">98</em>-->
						<span class="mt-number-animate-zql zql">99</span>%</div>
                    <span class="per_info">赚钱率</span>

                </div>
            </div>
			
			<!--
			 <div class="statistics">
                <ul>
					<li> <a href="playvideo.html">视频</a> </li>
				</ul>
			</div>
			-->

            <div class="index_lottery">
                <div class="index_lottery">
                <ul>
                    <li class="xy28" data-href="/Home/Run/fangjian/game/bj28.html" lottery_type="Vinper">
                        <a href="/Home/Run/bj28.html" class="explain">5分钟一期</a>
                        <img src="/Public/Home/up_files/index_lottery/jdjct.png" alt="Vinper" />
                         
                    </li>
					<li class="xy28" data-href="/Home/Run/fangjian1/game/jnd28.html" lottery_type="玖富聚宝投">
                        <a href="/Home/Run/rulejnd28.html" class="explain">3分半一期</a>
                        <img src="/Public/Home/up_files/index_lottery/jdjbt.png" alt="玖富聚宝投" />
                         
                    </li>
					
                  </ul>
            </div>
        </div>
    </section>

    <div class="popup" style="display: none">
        <div class="config">
            <h3>nhập mật khẩu</h3>
            <i class="configClose"></i>
            <div class="configInput">
                <input type="text" placeholder="" name="secret_pwd" autocomplete="off">
            </div>
            <div class="button" style="margin-top: 30px;">
                <button id="secretBtn">send</button>
            </div>

        </div>
    </div>
	<div id="mask" class="mask" onclick="hideMask()"  style="display: none">
		<img src="<?php if($kefu[kefu] != ''): ?>/Uploads/<?php echo ($kefu[kefu]); else: ?>/Public/Admin/img/no_img.jpg<?php endif; ?>" />
	</div>
    <textarea style="display:none" id="data_redpacket_info" class="data_redpacket_info">""</textarea>
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
        var flag = "";
        var money = "0.00";
        var lottery_type;

        //数字滚动动画
        (function ($) {
            $.fn.numberAnimate = function (setting) {
                var defaults = {
                    speed: 1000, //动画速度
                    num: "", //初始化值
                    iniAnimate: true, //是否要初始化动画效果
                    symbol: '', //默认的分割符号，千，万，千万
                    dot: 0 //保留几位小数点
                }
                //如果setting为空，就取default的值
                var setting = $.extend(defaults, setting);

                //如果对象有多个，提示出错
                if ($(this).length > 1) {
                    alert("just only one obj!");
                    return;
                }

                //如果未设置初始化值。提示出错
                if (setting.num == "") {
                    alert("must set a num!");
                    return;
                }
                var nHtml =
                    '<div class="mt-number-animate-dom" data-num="{num}">\
                            <span class="mt-number-animate-span">.</span>\
                            <span class="mt-number-animate-span">9</span>\
                            <span class="mt-number-animate-span">8</span>\
                            <span class="mt-number-animate-span">7</span>\
                            <span class="mt-number-animate-span">6</span>\
                            <span class="mt-number-animate-span">5</span>\
                            <span class="mt-number-animate-span">4</span>\
                            <span class="mt-number-animate-span">3</span>\
                            <span class="mt-number-animate-span">2</span>\
                            <span class="mt-number-animate-span">1</span>\
                            <span class="mt-number-animate-span">0</span>\
                          </div>';

                //数字处理
                var numToArr = function (num) {
                    num = parseFloat(num).toFixed(setting.dot);
                    if (typeof (num) == 'number') {
                        var arrStr = num.toString().split("");
                    } else {
                        var arrStr = num.split("");
                    }
                    console.log(arrStr);
                    return arrStr;
                }

                //设置DOM symbol:分割符号
                var setNumDom = function (arrStr) {
                    var shtml = '<div class="mt-number-animate">';
                    for (var i = 0, len = arrStr.length; i < len; i++) {
                        if (i != 0 && (len - i) % 3 == 0 && setting.symbol != "" && arrStr[i] != ".") {
                            shtml += '<div class="mt-number-animate-dot">' + setting.symbol + '</div>' +
                                nHtml.replace("{num}", arrStr[i]);
                        } else {
                            shtml += nHtml.replace("{num}", arrStr[i]);
                        }
                    }
                    shtml += '</div>';
                    return shtml;
                }
                
                //执行动画
                var runAnimate = function ($parent) {
                    $parent.find(".mt-number-animate-dom").each(function () {
                        var num = $(this).attr("data-num");
                        num = (num == "." ? 10 : num);
                        var spanHei = $(this).height() / 11; //11为元素个数
                        var thisTop = num * spanHei + "px";
                        if (thisTop != $(this).css("top")) {
                            if (setting.iniAnimate) {
                                //HTML5不支持
                                if (!window.applicationCache) {
                                    $(this).animate({
                                        top: thisTop
                                    }, setting.speed);
                                } else {
                                    $(this).css({
                                        'transform': 'translateY(' + thisTop + ')',
                                        '-ms-transform': 'translateY(' + thisTop + ')',
                                        /* IE 9 */
                                        '-moz-transform': 'translateY(' + thisTop + ')',
                                        /* Firefox */
                                        '-webkit-transform': 'translateY(' + thisTop + ')',
                                        /* Safari 和 Chrome */
                                        '-o-transform': 'translateY(' + thisTop + ')',
                                        '-ms-transition': setting.speed / 1000 + 's',
                                        '-moz-transition': setting.speed / 1000 + 's',
                                        '-webkit-transition': setting.speed / 1000 + 's',
                                        '-o-transition': setting.speed / 1000 + 's',
                                        'transition': setting.speed / 1000 + 's'
                                    });
                                }
                            } else {
                                setting.iniAnimate = true;
                                $(this).css({
                                    top: thisTop
                                });
                            }
                        }
                    });
                }

                //初始化
                var init = function ($parent) {
                    //初始化
                    $parent.html(setNumDom(numToArr(setting.num)));
                    runAnimate($parent);
                };

                //重置参数
                this.resetData = function (num) {
                    var newArr = numToArr(num);
                    var $dom = $(this).find(".mt-number-animate-dom");
                    if ($dom.length < newArr.length) {
                        $(this).html(setNumDom(numToArr(num)));
                    } else {
                        $dom.each(function (index, el) {
                            $(this).attr("data-num", newArr[index]);
                        });
                    }
                    runAnimate($(this));
                }
                //init
                init($(this));
                return this;
            }
        })(jQuery);

        $(function () {
            document.body.addEventListener('touchstart', function () {});

            //数字滚动动画
            var rate = Number("98");
            var numRun = $(".numberRun").numberAnimate({
                num: rate,
                speed: 2000
            });

            //红包
            var redpacketData = JSON.parse($("#data_redpacket_info").html());
            $(".redPacket-tit").html(redpacketData.redpacket_title);
            $(".head-icon").css("background", "url(" + redpacketData.redpacket_pic + ") no-repeat");

            //右侧红包图标点击
            $(".redPacket-ico").click(function () {
                $('.redPacket-mask').fadeIn(function () {
                    $(".redPacket-pop").addClass("scaleBlock");
                })
            })
            $(".redPacket-pop").find('.close-icon').on('click', function () {

                $(".redPacket-pop").removeClass("scaleBlock");
                $('.redPacket-mask').fadeOut();

            })
            //点击领取红包
            $(".open-icon").bind("click", function () {
                //                $('.redPacket-mask').fadeIn(function(){
                $(this).addClass("rotate");

                var timerOpen = setTimeout(function () {
                    //                        window.location.href = "https://1ww-pc3333.com/?m=index&c=user&a=login"
                    window.location.href = "?m=web&c=redpacket&a=redPacket&redpacket_id=" +
                        redpacketData.redpacket_id + "&returnRefresh=1";
                    $(".redPacket-pop").removeClass("scaleBlock");
                    $('.redPacket-mask').hide()
                }, 800)
                //                })
            })

            function getCookie(objName) { //获取指定名称的cookie的值
                var arrStr = document.cookie.split("; ");
                for (var i = 0; i < arrStr.length; i++) {
                    var temp = arrStr[i].split("=");
                    if (temp[0] == objName) return unescape(temp[1]);
                }
                return "";
            }
            //判断用户状态展示红包图标
            var isTourist = Number(getCookie('tourist'));
            if (redpacketData.can_user_join == 1 && redpacketData.redpacket_status == 1 && redpacketData.is_user_already_join ==
                0 && isTourist == 0) {
                $(".redPacket-ico").show();
                if (redpacketData.is_user_already_join == 0) {
                    $(".redPacket-ico").click();
                }
            }

            //玩法说明点击
            //            $(".explain").bind("click", function(){
            //                var msg = '这里是'+$(this).parent().attr('lottery_type')+'的玩法说明！';
            //                var alert ='<div class="popupAlert"><div class="config-alert"><div class="tit">提示</div> <p>'+msg+'</p><div class="btn"><button class="confirm">确定</button></div></div></div>';
            //                var p = $(alert).appendTo($('body'));
            //                p.find('.confirm').off().on('click', function () {
            //                    p.remove();
            //                });
            //                return false
            //            })

            //系统公告滚动消息
            var minWidth = $("#maq").width();
            var index = $(".gonggao p").length;
            var max_width = 0;
            $('#mtext p').each(function () {
                if ($(this).outerWidth() > minWidth) {
                    $(this).width($(this).outerWidth());
                } else {
                    $(this).width(minWidth);
                }
                max_width += $(this).outerWidth();
            })
            $(".gonggao").css({
                "width": max_width,
                "float": "left"
            });
            $(".widthGonggao").width(max_width * 2);
            var speed = 20;
			
			/*
            var MyMar = setInterval(Marquee, speed)
			
			
            m0.innerHTML = mtext.innerHTML

            function Marquee() {
                if (m0.offsetWidth - maq.scrollLeft <= 0)
                    maq.scrollLeft -= mtext.offsetWidth
                else {
                    maq.scrollLeft++
                }
            }
			*/

        });

        //cskh图标 移动
        var bodyWidth = $("body").width();
        var bodyHeight = $("body").height();
        var dragWidth = $("#drag").width();
        var move = false; //移动标记
        var seup = false;
        var _x, _y; //鼠标离控件左上角的相对位置

        var drag = document.getElementById("drag");

        drag.addEventListener("touchstart", function () {
            move = true;
            seup = true;
            _x = event.targetTouches[0].pageX - parseInt($("#drag").css("left"));
            _y = event.targetTouches[0].pageY - parseInt($("#drag").css("top"));
        })
        drag.addEventListener("touchmove", function () {
            if (event.targetTouches.length == 1) {
                event.preventDefault(); // 阻止浏览器默认事件，重要
                if (move) {
                    var x = event.targetTouches[0].pageX - _x; //控件左上角到屏幕左上角的相对位置
                    var y = event.targetTouches[0].pageY - _y;
                    $("#drag").css({
                        "top": y,
                        "left": x
                    });
                }
            }

        })
        drag.addEventListener("touchend", function () {
            if (seup) {
                var left = $("#drag").offset().left;
                var top = $("#drag").offset().top;
                if (top < 200) {
                    $("#drag").css({
                        "top": '200px'
                    });
                }
                // if(top > 44 || top > bodyHeight -102){
                if ((bodyWidth / 2) < left) {
                    $("#drag").css({
                        "left": bodyWidth - 82 + "px"
                    });
                } else {
                    $("#drag").css({
                        "left": "10px"
                    });
                }
                // }
                if (top > bodyHeight - 188) {
                    $("#drag").css({
                        "top": bodyHeight - 188
                    });
                }
            }
            move = false;
            seup = false;
        })
    </script>
    <nav>
    <ul>
        <li class="active" data-href="<?php echo U('Home/run/index');?>">Home</li>
        <li data-href="<?php echo U('Home/Fen/addpage');?>">Nạp</li>
       <li data-href="http://103.166.184.168/im.htm?xtid=131830">cskh</li>
        
        <!--             <li data-href="?m=web&c=user&a=login">cskh</li>
         -->
        
        <li data-href="<?php echo U('Home/User/index');?>">Tôi</li>

    </ul>
</nav><script type="text/javascript">
    $(function() {
        //获取当前选项
        $.ajax({
            url: '?m=api&c=app&a=customerType',
            type: 'post',
            success: function(res){
                res=JSON.parse(res)
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