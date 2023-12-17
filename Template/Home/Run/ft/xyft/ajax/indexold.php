<?php 
//echo file_get_contents('http://www.1391c.com/xyft/ajax?ajaxhandler=GetXyftAwardData');
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Shanghai");
    function getTimestamp($digits = false) {  
        $digits = $digits > 10 ? $digits : 10;  
        $digits = $digits - 10;
        if ((!$digits) || ($digits == 10))  
        {  
            return time();  
        }  
        else  
        {  
            return number_format(microtime(true),$digits,'','');  
        }  
    }  

$json = file_get_contents('');
$json = json_decode($json,1);
$aa = $json['open'][0]['opencode'];
$arr = explode(",",$aa);
$opencode.= (int)$arr[0].",";
$opencode.= (int)$arr[1].",";
$opencode.= (int)$arr[2].",";
$opencode.= (int)$arr[3].",";
$opencode.= (int)$arr[4].",";
$opencode.= (int)$arr[5].",";
$opencode.= (int)$arr[6].",";
$opencode.= (int)$arr[7].",";
$opencode.= (int)$arr[8].",";
$opencode.= (int)$arr[9];

$IntervalTimeMs=strtotime($json['next'][0]['opentime'])."000";
$IntervalTimeMs = $IntervalTimeMs - getTimestamp(13);
$periodNumber1 = (int)substr($json['open'][0]['expect'],8);
$periodNumber2 = (int)substr($json['next'][0]['expect'],8);
echo "
{
	\"time\":".getTimestamp(13).",
	\"current\":{
		\"periodNumber\":" . $periodNumber1 . ",
		\"awardTime\":\"" . $json['open'][0]['opentime'] . "\",
		\"awardNumbers\":\"". $opencode ."\"
	},\"next\":{
		\"periodNumber\":".$periodNumber2.",
		\"awardTime\":\"". $json['next'][0]['opentime'] ."\",
		\"awardTimeInterval\": ". $IntervalTimeMs  .",
		\"delayTimeInterval\":-6
	}
}

";
?>