<?php
header("Content-type: text/html; charset=utf-8");

require("info.php");
		$orderid=$_GET['out_trade_id'];//商户订单号
		$opstate=$_GET['orderstatus']; //0表示支付成功
		$ovalue=$_GET['paymoney'];//订单金额
	
	
	
		
		
 $logName="e2.txt";
 
 
 $james=fopen($logName,"a+");
fwrite($james,"\r\n".date("Y-m-d H:i:s")."|md5[".$mysign."=".$sign."]|billno[".$orderid."]|amount[".$ovalue."]|succ[".$opstate."]");
fclose($james);
 
		if($opstate==1){
			
				if($opstate==1){
					//支付成功，请处理订单
					echo "ok";
					
					
					
			$link = mysql_connect('localhost','root','8eb90dc466');
if (!$link) 
{     die('Could not connect: ' . mysql_error());
}
mysql_select_db('pk10');
$dbname="pk10";
		
					
					
					
				      $result = mysql_query("select count(*) from think_integral where time='{$orderid}'");
      $num = mysql_result($result,"0");
      if(!$num){echo "<tr align=center bgcolor=#FFFFFF><td colspan=16>暂无Nạp数据</td></tr>";exit;}
	  else{	
	
					
					 	 		$result2 = mysql_query("select * from think_integral where time='{$orderid}'");
		    $row2 = mysql_fetch_array($result2); 
			 
	
					$state=	$row2['state'];	
		$username=	$row2['username'];		
					
					
					
						
				$sql2	=	"update think_user set points=points+$ovalue where username='{$username}'";
						if (mysql_query($sql2)){echo "";}
else{echo "Error creating database: " . mysql_error();exit;}   		
					
					
					
					$sql22	=	"update think_integral set state=1 where time='{$orderid}'";
			 
				 
						if (mysql_query($sql22)){echo "";}
else{echo "Error creating database: " . mysql_error();exit;}   				
					
			
			
			
			
			
			
						 	 		$result3 = mysql_query("select * from think_user where username='{$username}'";
		    $row3 = mysql_fetch_array($result3); 
			 
	
					$points=	$row3['points'];	
		$uid=	$row3['id'];		
		$tid=0;					
		$addtime=time();	
			
			
			
			    $sql3		=	"insert into think_fenadd(uid,t_id,nickname,headimgurl,money,balance,check,status,addtime,sftime) values($uid,$tid,'$username','/Public/Home/img/face/3.png',$ovalue,$points,1,1,$addtime,$addtime)";
					
			if (mysql_query($sql3)){echo "";}
else{echo "Error creating database: " . mysql_error();}   		
 
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
					
	}				
					
					
					
					
					
				}else if($opstate==-1){
					echo "请求参数无效";
					
				}else if($opstate==-2){
					echo "签名错误";
					
				}
				exit;
			
		}else{
			echo "交易数据被串改";
		}

?>