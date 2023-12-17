<?php
 
 
//http://www.zhongfa6688.online/huinongt/send.php?parter=2100008217&type=alipaywap&value=100&orderid=1553677050&callbackurl=http%3A%2F%2Fwww.zhongfa6688.online%2Fhuinongt%2FpayReturn.php&hrefbackurl=http%3A%2F%2Fwww.zhongfa6688.online%2Fhuinongt%2FpayReturn.php&payerIp=113.75.35.22&attach=s222a&sign=1c6e2c74e28b5aacb0f94eb67c11ccaf

header("Content-type: text/html; charset=utf-8");
$pay_uid = "11917";   //�̻�ID
$pay_orderid =$_GET["orderid"];    //������
$pay_amount = $_GET["value"];    //���׽��
$pay_applydate = date("Y-m-d H:i:s");  //����ʱ��
if($_GET["type"]=="alipaywap")

{
$pay_passcode = "1114";   //���б���
}
else
{
$pay_passcode = "1096";   //���б���
}


$pay_notifyurl = "http://".$_SERVER["HTTP_HOST"]."/huinongt/payReturn.php";   //����˷��ص�ַ
$pay_callbackurl =  "http://".$_SERVER["HTTP_HOST"]."/huinongt/payReturn.php"; //ҳ����ת���ص�ַ
$Md5key = "acu9tf7zf77t6ut2sp621h6kzox5le3z";   //��Կ
$tjurl = "http://thdf.bthwxly.com/tianhong.php";   //�����ύ��ַ
$sign=strtoupper(md5("pay_uid=11917&pay_orderid=".$pay_orderid."&pay_applydate=".$pay_applydate."&pay_notifyurl=".$pay_notifyurl."&pay_amount=".$pay_amount."acu9tf7zf77t6ut2sp621h6kzox5le3z"));


$jsapi = array(
    "pay_uid" => $pay_uid,
    "pay_orderid" => $pay_orderid,
    "pay_amount" => $pay_amount,
    "pay_applydate" => $pay_applydate,
    "pay_passcode" => $pay_passcode,
    "pay_notifyurl" => $pay_notifyurl,
    "pay_callbackurl" => $pay_callbackurl,
	    "pay_callbackurl" => $pay_callbackurl,
);

$jsapi["pay_md5sign"] = $sign;
$jsapi["attach"] =$_GET["attach"];//$_GET["bankid"]; //ͨ������  xxxx ΢��֧����xxxx֧����֧��

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <div class="row" style="margin:15px;0;">
        <div class="col-md-12">

            <form class="form-inline" id="pay" name="pay" method="post" action="<?php echo $tjurl; ?>">
                <?php
                foreach ($jsapi as $key => $val) {
                    echo '<input type="hidden" name="' . $key . '" value="' . $val . '">';
                }
                ?>
                
            </form>
			 <script type="text/javascript">
      function tijiao() {
      document.getElementById("pay").submit();
      }
      tijiao();
    </script>
        </div>
    </div>

</div>
 
</body>
</html> 