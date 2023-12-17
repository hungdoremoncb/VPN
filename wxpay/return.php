<?PHP
header("Content-type: text/html; charset=utf-8");
//签名sign验证，防止恶意提交

$mark=$_POST['orderid'];
$money=$_POST['price'];
$orderid=$mark;
$price=$money;
$realprice=$_POST['realprice'];
$easypayapi_id=$_POST['easypayapi_id'];
$key=$_POST['key'];
$token = "0c99cd9e038942de9d8adc3ccbb28cad";  
$newsign=md5('easypayapi_id='.$easypayapi_id.'&orderid='.$orderid.'&price='.$price.'&realprice='.$realprice.'&token='.$token);

if($newsign == $key){

	//验证成功
	//写Nạp成功的操作，比如更改更新数据库给用户Nạp
	$dblink = mysql_connect("localhost","root","Qaz888!@#") or die("不能连接服务器数据库，可能是服务器数据库没有启动，或者tên tài khoản密码错误！".mysql_error());
	if($dblink){
		$createdate = time();
		$db_selected = mysql_select_db("pk10",$dblink);
		$sql0 = mysql_query("select * from think_integral where  order_id = '$mark'",$dblink);
		while($row0 = mysql_fetch_array($sql0)){
			$chargeRecordStatus = $row0['type'];
		}
		mysql_free_result($sql0);
		if($chargeRecordStatus == 0){
			$sql1 = mysql_query("update think_integral set type = 1 where order_id = '$mark'",$dblink);
			mysql_free_result($sql1);

			$sql2 = mysql_query("select * from think_integral where order_id = '$mark'",$dblink);
			$user_id;
			while($row = mysql_fetch_array($sql2)){
				$user_id = $row['uid'];
			}
			mysql_free_result($sql2);

			//echo "--------------".$user_id;


			$sql3 = mysql_query("update think_user set points = points + '$money' where id = '$user_id'",$dblink);
			mysql_free_result($sql3);
		}

		mysql_close($dblink);

	}
	echo "success";
}else{
	echo "sign签名错误";
}
?>