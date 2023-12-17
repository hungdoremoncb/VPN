<?php

namespace Home\Controller;
use Think\Controller;

header('content-type:text/html;charset=utf-8');
class GetController extends Controller{

	//add by gison 20180503
	public function getLhc(){
		$caiji = M('caiji')->where("game='lhc'")->limit(0,1)->order("id desc")->find();
		if (C('index_page') == '1') {
            $format = json_decode(lhc_format($caiji),true);
        } else {
            $format = json_decode(lhc_format2($caiji),true);
        }
		echo json_encode($format);
	}

	public function getPk10(){
		$caiji = M('caiji')->where("game='pk10'")->limit(0,1)->order("id desc")->find();
		$format = json_decode(pk10_format($caiji),true);
		// if (strtotime($format['current']['awardTime']) > strtotime("23:56:00")) {
		// 	$time = strtotime($format['next']['awardTime']) + 9*60*60-300;
		// 	$format['next']['awardTime'] = date('Y-m-d H:i:s',$time);
		// }
		echo json_encode($format);
	}
	
	public function getEr75sc(){
		$caiji = M('caiji')->where("game='er75sc'")->limit(0,1)->order("id desc")->find();
		$format = json_decode(er75sc_format($caiji),true);
		// if (strtotime($format['current']['awardTime']) > strtotime("23:56:00")) {
		// 	$time = strtotime($format['next']['awardTime']) + 9*60*60-300;
		// 	$format['next']['awardTime'] = date('Y-m-d H:i:s',$time);
		// }
		echo json_encode($format);
	}
	
	public function getXyft(){
		$caiji = M('caiji')->where("game='xyft'")->limit(0,1)->order("id desc")->find();
		$format = json_decode(xyft_format($caiji),true);
		echo json_encode($format);
	}

	public function getSsc(){
		$number = M('number')->where("game='ssc'")->limit(0,1)->order("id desc")->find();
		$caiji = M('caiji')->where("game='ssc'")->limit(0,1)->order("id desc")->find();

		$time = time();
		if ($time > strtotime("07:30:00") && $time < strtotime("00:30:00")) {
			$n_awardTime = strtotime($number["awardtime"]) + 1190;
		} else {
			$n_awardTime = strtotime($number["awardtime"]) + 1190;
		}

		$json_data =  array(
		    "preDrawCode" => explode(',',$number['awardnumbers']),
		    "drawTime" =>  $number['awardtime'],
		    "preDrawIssue" =>  $number['periodnumber'],
			"drawIssue"=>$caiji['next_term'],
		    "sumNum" =>  $number['tema'],
		    "sumBigSmall" =>  $number['tema_dx'],
		    "dragonTiger" =>   $number['lh'],
		    "sumSingleDouble" =>   $number['tema_ds'],
		    "status" =>  0,
		    "id" =>  "#numBig",
		    'counttime' =>  abs($n_awardTime - time()),
		);
		
		echo json_encode($json_data);
	}

	public function getBj28(){
		$number = M('number')->where("game='bj28'")->limit(0,1)->order("id desc")->find();
		$n_awardTime = strtotime($number["awardtime"]) + 300;
		
		$endtime=$n_awardTime - time();
		if($endtime<0){
			$endtime=0;
		}
		
		$json_data =  array(
		    "preDrawCode" => explode(',',$number['awardnumbers']),
		    "drawIssue"=>$number['periodnumber']+1,
		    "drawTime" =>  date('Y-m-d H:i:s',$n_awardTime),
		    "preDrawIssue" =>  $number['periodnumber'],
		    "sumNum" =>  $number['tema'],
		    "sumBigSmall" =>  $number['tema_dx'],
		    "time" => $endtime,
		);
		echo json_encode($json_data);
	}

	public function getJnd28(){
		$number = M('number')->where("game='jnd28'")->limit(0,1)->order("id desc")->find();
		//$n_awardTime = strtotime($number["awardtime"]) + 210;
		if (strtotime($number["awardtime"]) > strtotime("19:00:00") && strtotime($number["awardtime"]) < strtotime("21:00:00")) {
			$time = strtotime($number["awardtime"]) + 2*60*60;
			$n_awardTime = strtotime(date('Y-m-d H:i:s',$time));
		} else {
			$n_awardTime = strtotime($number["awardtime"]) + 210;
		}
		
		$endtime=$n_awardTime - time();
		if($endtime<0){
			$endtime=0;
		}
		
		$json_data =  array(
		    "preDrawCode" => explode(',',$number['awardnumbers']),
		    "drawIssue"=>$number['periodnumber']+1,
		    "drawTime" =>  date('Y-m-d H:i:s',$n_awardTime),
		    "preDrawIssue" =>  $number['periodnumber'],
		    "sumNum" =>  $number['tema'],
		    "sumBigSmall" =>  $number['tema_dx'],
		    "time" => $endtime,
		);
		echo json_encode($json_data);
	}
	
	public function getXjp28(){
		$number = M('number')->where("game='xjp28'")->limit(0,1)->order("id desc")->find();
		$n_awardTime = strtotime($number["awardtime"]) + 180;
		
		$endtime=$n_awardTime - time();
		if($endtime<0){
			$endtime=0;
		}
		
		$json_data =  array(
		    "preDrawCode" => explode(',',$number['awardnumbers']),
		    "drawIssue"=>$number['periodnumber']+1,
		    "drawTime" =>  date('Y-m-d H:i:s',$n_awardTime),
		    "preDrawIssue" =>  $number['periodnumber'],
		    "sumNum" =>  $number['tema'],
		    "sumBigSmall" =>  $number['tema_dx'],
		    "time" => $endtime,
		);
		echo json_encode($json_data);
	}

	public function getK3(){
		$number = M('number')->where("game='k3'")->limit(0,1)->order("id desc")->find();
		$n_awardTime = strtotime($number["awardtime"]) + 600;

		$json_data =  array(
		    "preDrawCode" => explode(',',$number['awardnumbers']),
		    "drawIssue"=>$number['periodnumber']+1,
		    "drawTime" =>  date('Y-m-d H:i:s',$n_awardTime),
		    "preDrawIssue" =>  $number['periodnumber'],
		    "sumNum" =>  $number['tema'],
		    "sumBigSmall" =>  $number['tema_dx'],
		    "time" => abs($n_awardTime - time()),
		);
		echo json_encode($json_data);
	}


	public function apiSsc(){
		$caiji = M('caiji')->where("game='ssc'")->limit(0,1)->order("id desc")->find();
		echo json_encode($caiji);
	}

	public function apiXyft(){
		$caiji = M('caiji')->where("game='xyft'")->limit(0,1)->order("id desc")->find();

		$periodNumber = $caiji['periodnumber'];
		$awardTime = $caiji['awardtime'];
		$awardNumbers = $caiji['awardnumbers'];

		if (strtotime($awardTime) > strtotime("04:03:00") && strtotime($awardTime) < strtotime("13:03:00")) {
			$time = strtotime($awardTime) + 9*60*60-300;
			$n_awardTime = date('Y-m-d H:i:s',$time);
		}else{
			$n_awardTime = strtotime($awardTime) + 300;
		}

	
		$format = array(
			'time' =>  time(),
			'current' => array(
				'periodNumber' => $periodNumber,
				'awardTime' => $awardTime,
				'awardNumbers' => $awardNumbers
			),
			'next' => array(
				'periodNumber' => $periodNumber+1,
				'awardTime' => date('Y-m-d H:i:s',$n_awardTime),
				'awardTimeInterval' => abs($n_awardTime - time())*1000,
				'delayTimeInterval' => $n_awardTime - time() > 0 ? 0 : time() - $n_awardTime
			),
			'game' => "xyft"
		);

		if (strtotime($format['current']['awardTime']) > strtotime("03:56:00")) {
			$time = strtotime($format['next']['awardTime']) + 9*60*60-300;
			$format['next']['awardTime'] = date('Y-m-d H:i:s',$time);
		}
		echo json_encode($format);
	}
	
	
	public function CodeXjp28(){
		
		$qihao=I('qihao')+1;
		$where['periodnumber']=array('eq',$qihao);
		$where['game']=array('eq','xjp28');
		$number = M('caiji')->where($where)->find();
		//var_dump($number);
		if($number){
			$status=1;
		}else{
			$status=2;
		}
		//$status=1;
		//echo json_encode(array('status'=>$status));
		$this->ajaxReturn(array('status'=>$status));
	}
	public function CodeJnd28(){
		
		$qihao=I('qihao')+1;
		$where['periodnumber']=array('eq',$qihao);
		$where['game']=array('eq','jnd28');
		$number = M('caiji')->where($where)->find();
		//var_dump($number);
		if($number){
			$status=1;
		}else{
			$status=2;
		}
		//$status=1;
		//echo json_encode(array('status'=>$status));
		$this->ajaxReturn(array('status'=>$status));
	}
	public function CodeBj28(){
		
		$qihao=I('qihao')+1;
		$where['periodnumber']=array('eq',$qihao);
		$where['game']=array('eq','bj28');
		$number = M('caiji')->where($where)->find();
		//var_dump($number);
		if($number){
			$status=1;
		}else{
			$status=2;
		}
		//$status=1;
		//echo json_encode(array('status'=>$status));
		$this->ajaxReturn(array('status'=>$status));
	}
	
}

?>