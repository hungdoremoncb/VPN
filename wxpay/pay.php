<?php
//?money=500&type=1&user_id=100&user_name=test01&nick_name=test01
//goodsnametest01istype2notify_urlhttp://103.166.184.168/gepay/return.phporderid190824432450460201price500token0c99cd9e038942de9d8adc3ccbb28caduidb482c83ad8f14b888f29
ini_set("display_errors", "off");
header("Content-type: text/html; charset=utf-8");
//require_once 'config.php';
$mark=date('ymdhis');
$money=$_REQUEST['money'];
$type=$_REQUEST['type'];
$user_id=$_REQUEST['user_id'];
$user_name=$_REQUEST['user_name'];
$nick_name=$_REQUEST['nick_name'];
$ip = $_SERVER["REMOTE_ADDR"];
$uid = "b482c83ad8f14b888f29"; 
$orderid = $mark;   
$price = number_format($money,2,'.',''); 
$notify_url = 'http://'.$_SERVER['SERVER_NAME'].'/wxpay/return.php';
$token = "0c99cd9e038942de9d8adc3ccbb28cad";  
$key='';
$tjurl = "http://hz.qpifu.com:9088/pay/payapi/creatOrder";  
$goodsname=$user_name;
$istype = $type;   
$native = array(
    "uid" => $uid,
    "orderid" => $orderid,
    "price" => $price,
    "notify_url" => $notify_url,
    "goodsname" => $goodsname,
	"istype" => $istype,
    "token" => $token
);

$key = strtolower(md5('goodsname='.$goodsname.'&istype='.$istype.'&notify_url='.$notify_url.'&orderid='.$orderid.'&price='.$price.'&token='.$token.'&uid='.$uid));
$native["key"] = $key;
$result=curlPost($tjurl,$native);//print_r($result);
$result=json_decode($result,true);
if($result['code']=='1'){
	 //header("Location:".$result['qrcode']);//跳转支付
	 $dblink = mysql_connect("localhost","root","Qaz888!@#") or die("不能连接服务器数据库，可能是服务器数据库没有启动，或者tên tài khoản密码错误！".mysql_error());
		if($dblink){
			//echo "111111111111111";
			$createdate = time();
			$db_selected = mysql_select_db("pk10",$dblink);
			mysql_query("set names 'utf8'");
			$sql0 = "insert into think_integral (uid,time,points,type,ip,nickname,username,balance,order_id) values ($user_id,'$createdate','$money','0','$ip','$nick_name','$user_name','$money','$mark')";

			$sql = mysql_query($sql0,$dblink);

			mysql_free_result($sql);
			mysql_close($dblink);
		}
	   if ($istype==1){
		   $qRcodeURL=urlencode($result['qrcode']);
			include("content.html");
		   }else{
		header("Location:".$result['qrcode']);//跳转支付
	   }
}else{
	print_r($result['msg']);
}

function curlPost($url = '', $postData = '', $options = array())
{
	if (is_array($postData)) {
		$postData = http_build_query($postData);
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
	if (!empty($options)) {
		curl_setopt_array($ch, $options);
	}
	
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
?>
