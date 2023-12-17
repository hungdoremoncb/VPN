<?php
namespace Home\Controller;
use Think\Server;

header('content-type:text/html;charset=utf-8');
class Workermanjnd28_3Controller extends Server {

	protected $socket = 'websocket://103.166.184.168:9006';
	public $sec_period = 180;
	public $robot_ping = 2;
	public $robot_rate = 8;
	public $robot_rate_fen = 60;

	/*添加定时器
	 *监控连接状态
	 * */
	public function onWorkerStart(){
		// $auth = auth_check(C('auth_code'),C('siteurl'));
		// if (!$auth) {
		// 	echo "未授权或授权已过期";exit;
		// }

		$beginToday=strtotime('09:00:00');
		$endToday=strtotime("23:54:59");
        if (true){
            $caiji = M('caiji')->where("game='jnd28'")->limit(0,1)->order("id desc")->find();
        }else{
            $caiji = M('kongzhi')->where("game='jnd28'")->limit(0,1)->order("id desc")->find();
            $caiji['awardtime'] = date("Y-m-d H:i:s",$caiji['awardtime']);
        }
        $data =  jnd28_format($caiji);

		$time_interval = 1;
		$jnd28_3data = json_decode($data,true);
		$nexttime = $jnd28_3data['next']['delayTimeInterval']+strtotime($jnd28_3data['next']['awardTime']);
		if($nexttime-time()>C('jnd28_3_stop_time') && $nexttime-time()<$this->sec_period){
			F('jnd28_3_state',1);
		}else{
			F('jnd28_3_state',0);
		}
		if(!F('jnd28_3data')){
			F('jnd28_3data',$jnd28_3data);
		}
		if(!F('jnd28_3_is_send')){
			F('jnd28_3_is_send',1);
		}

		/*开奖*/
		\Workerman\Lib\Timer::add($time_interval, function(){

			$beginToday=strtotime('09:00:00');
			$endToday=strtotime("23:54:59");
			F('jnd28_3_game','jnd28_3');

			$jnd28_3data = F('jnd28_3data');
			$next_time = $jnd28_3data['next']['delayTimeInterval']+strtotime($jnd28_3data['next']['awardTime']);
			$awardtime = $jnd28_3data['current']['awardTime'];
			// var_dump($next_time-time());
			if($next_time-time()>C('jnd28_3_stop_time') && $next_time-time()<$this->sec_period){
				F('jnd28_3_state',1);
			}else{
				F('jnd28_3_state',0);
			}

			if($next_time-time()== 30+C('jnd28_3_stop_time')){
				$new_message = array(
					'type' => 'admin',
					'head_img_url'=>'/Public/main/img/kefu.jpg',
					'from_client_name' => 'GM管理员',
					'content'=>'Number:'.$jnd28_3data['next']['periodNumber'].'<br/>'.'--距离封盘还有30秒--',
					'time'=>date('H:i:s')
				);
				foreach ($this->worker->connections as $conn) {
					$conn -> send(json_encode($new_message));
				}
			}

			if($next_time-time()==C('jnd28_3_stop_time')){
				F('jnd28_3_state',0);
				$new_message = array(
					'type' => 'admin',
					'head_img_url'=>'/Public/main/img/kefu.jpg',
					'from_client_name' => 'GM管理员',
					'content'=>'Number:'.$jnd28_3data['next']['periodNumber'].'已封盘，请耐心等待结果',
					'time'=>date('H:i:s')
				);
				foreach ($this->worker->connections as $conn) {
					$conn -> send(json_encode($new_message));
				}
			}
			if($next_time-time()<$this->sec_period && $next_time-time()>100 && F('jnd28_3_is_send')==0){
				//结算
				//开奖结果
				$current_number = M('number')->where("game='jnd28'")->order('id DESC')->find();
				$number1 = explode(',', $current_number['awardnumbers']);
				$tema_number = $number1[0] + $number1[1] + $number1[2];
				if ($tema_number <= 13) {
					if ($tema_number%2 == 0) {
						$current_number['zuhe'] = '小双';
					} else {
						$current_number['zuhe'] = '小单';
					}
				} else {
					if ($tema_number%2 == 0) {
						$current_number['zuhe'] = '大双';
					} else {
						$current_number['zuhe'] = '大单';
					}
				}

				if ($tema_number == 0) {
					$current_number['jdx'] = '极小';
				} else if($tema_number == 27) {
					$current_number['jdx'] = '极大';
				}  else {
					$current_number['jdx'] = '';
				}

				//当前局所有竞猜
				$today_time = strtotime(date('Y-m-d',time()));
				$list = M('order')->where("number = {$current_number['periodnumber']} && time > '{$today_time}' && state = 1 && is_add = 0 && game='jnd28_3'")->order("time ASC")->select();
				if($list){
					for($i=0;$i<count($list);$i++){
						$id = $list[$i]['id'];
						$userid = $list[$i]['userid'];
						if($list[$i]['t_id'] and C('fenxiao_set') == 2){
                            $t_userinfo = M('user')->field('is_agent')->where("id = {$list[$i]['t_id']}")->find();
                            if ($t_userinfo['is_agent'] == '0' && C('is_user_agent') == '0') {

                            } else {
                                $t_userinfo = M('user')->field('is_agent')->where("id = {$list[$i]['t_id']}")->find();

                                if ($t_userinfo['is_agent'] == '0' && C('is_user_agent') == '0') {

                                } else {
                                    M('user')->where("id = {$list[$i]['t_id']}")->setInc('yong', $list[$i]['del_points']*C('fenxiao')*0.01);
                                    M('user')->where("id = {$list[$i]['t_id']}")->setInc('t_add', $list[$i]['del_points']*C('fenxiao')*0.01);
                                    $fx_data = array(
                                        'uid' => $userid,
                                        't_uid' => $list[$i]['t_id'],
                                        'orderid' => $id,
                                        'push_money' => $list[$i]['del_points'],
                                        'rate' => C('fenxiao')*0.01,
                                        'money' => $list[$i]['del_points']*C('fenxiao')*0.01,
                                        'time' => time()
                                    );
                                    M('push_money')->add($fx_data);
                                }
                            }
						}

						$set_add = M('order')->where("id={$id}")->setField(array('is_add'=>1));
						//分类
						switch($list[$i]['type']){

							//大小单双  大100  小100
                        case 1:
                            $start1 = substr($list[$i]['jincai'], 0,3);
                            $starts1 = substr($list[$i]['jincai'],3);
                            $num1 = 0;

                            if ($start1 == '大' || $start1 == '小') {
                                if ($start1 == $current_number['tema_dx']) {
                                    $num1 = 1;
                                }
                            } else {
                                if ($start1 == $current_number['tema_ds']) {
                                    $num1 = 1;
                                }
                            }

                            if($num1>0){
								// 	if ($current_number['tema'] == '13' || $current_number['tema'] == '14') {
								// 		$points1 = $num1*$starts1*C('jnd28_3_dxds_md');
								// 	} else {
                                $points1 = $num1*$starts1*C('jnd28_3_dxds');
								// 	}

                                $res1 = $this->add_points($id,$userid,$points1);
                                if($res1){
                                    $this->send_msg('pointsadd',$points1,$userid);
                                }
                            }
                            break;

							//组合  大单100  小100
                        case 2:
                            $start2 = substr($list[$i]['jincai'], 0,6);
                            $starts2 = substr($list[$i]['jincai'],6);
                            $num2 = 0;

                            if ($start2 == $current_number['zuhe']) {
                                $num2 = 1;
                            }

                            if($num2>0){
								// 	if ($current_number['tema'] == '13' || $current_number['tema'] == '14') {
								// 		$points2 = $num2*$starts2*C('jnd28_3_zuhe_md');
								// 	} else {
                                if ($start2 == '大单' || $start2 == '小双') {
                                    $points2 = $num2*$starts2*C('jnd28_3_zuhe_1');
                                } else {
                                    $points2 = $num2*$starts2*C('jnd28_3_zuhe_2');
                                }
								// 	}

                                $res2 = $this->add_points($id,$userid,$points2);
                                if($res2){
                                    $this->send_msg('pointsadd',$points2,$userid);
                                }
                            }
                            break;


							//极大小  极大100
                        case 3:
                            $start3 = substr($list[$i]['jincai'], 0,6);
                            $starts3 = substr($list[$i]['jincai'],6);
                            $num3 = 0;
                            if ($start3 == $current_number['jdx']) {
                                $num3 = 1;
                            }

                            if($num3>0){
                                $points3 = $num3*$starts3*C('jnd28_3_jdx');
                                $res3 = $this->add_points($id,$userid,$points3);
                                if($res3){
                                    $this->send_msg('pointsadd',$points3,$userid);
                                }
                            }
                            break;


							//庄闲和    庄100  和100
                        case 4:
                            $start4 = substr($list[$i]['jincai'], 0,3);
                            $starts4 = substr($list[$i]['jincai'],3);

                            $points4 = 0;

                            if ($start4 == '庄' || $start4 == '闲') {
                                if ($current_number['zx'] == '和') {
                                    $points4 = $starts4*1;
                                } else if($start4 == $current_number['zx']){
                                    $points4 = $starts4*C('jnd28_3_zx_1');
                                }
                            } else {
                                if($start4 == $current_number['zx']){
                                    $points4 = $starts4*C('jnd28_3_zx_2');
                                }
                            }
                            if ($points4) {
                                $res4 = $this->add_points($id,$userid,$points4);
                                if($res4){
                                    $this->send_msg('pointsadd',$points4,$userid);
                                }
                            }

                            break;


							//豹子对子顺子 100  白字100
                        case 5:
                            $start5 = substr($list[$i]['jincai'], 0,6);
                            $starts5 = substr($list[$i]['jincai'],6);
                            $num5 = 0;
                            if ($start5 == $current_number['q3']) {
                                $num5 = 1;
                            }

                            if($num5>0){
                                if ($start5 == '豹子') {
                                    $points5 = $num5*$starts5*C('jnd28_3_bds_1');
                                } else if($start5 == '顺子') {
                                    $points5 = $num5*$starts5*C('jnd28_3_bds_2');
                                } else if($start5 == '对子') {
                                    $points5 = $num5*$starts5*C('jnd28_3_bds_3');
                                } else if($start5 == '半顺') {
                                    $points5 = $num5*$starts5*C('jnd28_3_bds_4');
                                } else if($start5 == '杂六') {
                                    $points5 = $num5*$starts5*C('jnd28_3_bds_5');
                                }

                                $res5 = $this->add_points($id,$userid,$points5);
                                if($res5){
                                    $this->send_msg('pointsadd',$points5,$userid);
                                }
                            }
                            break;


							//特码数字 3点100
                        case 6:
                            $ex_info = explode('点', $list[$i]['jincai']);
                            if (count($ex_info) > 1) {
                                $start6 = $ex_info;
                            }

                            $ex_info = explode('.', $list[$i]['jincai']);
                            if (count($ex_info) > 1) {
                                $start6 = $ex_info;
                            }

                            $num6 = 0;
                            $tema_number = $this->getTemaNum( $current_number['tema'] );
                            if ($start6[0] == $tema_number ) {
                                $num6 = 1;
                            }

                            if($num6>0){
                                $points6 = $num6*$start6[1]*C('jnd28_3_tema_'.$tema_number);
                                $res6 = $this->add_points($id,$userid,$points6);
                                if($res6){
                                    $this->send_msg('pointsadd',$points6,$userid);
                                }
                            }
								break;
						}
					}
				}

				F('jnd28_3_is_send',1);
				//F('jnd28_3_state',0);

				sleep(10);
				$content = $current_number['periodnumber']."期结算已完毕！<br/>
							号码：".$current_number['awardnumbers'];
				$new_message = array(
					'delay' => '20',
					'type' => 'system',
					'head_img_url'=>'/Public/main/img/system.jpg',
					'from_client_name' => '客服',
					'content'=> $content,
					'time'=>date('H:i:s')
				);
				foreach ($this->worker->connections as $conn) {
					$conn -> send(json_encode($new_message));
				}
				$new_message = array(
					'delay'=>'0',
					'type' => 'admin',
					'head_img_url'=>'/Public/main/img/kefu.jpg',
					'from_client_name' => 'GM管理员',
					'content'=>'Number:'.$jnd28_3data['next']['periodNumber'].'开放，祝各位购买成功',
					'time'=>date('H:i:s')
				);

	            foreach ($this->worker->connections as $conn) {
					$conn -> send(json_encode($new_message));
				}
			}
			$this->add_message($new_message);/*添加信息*/
    	});



		//ping 统计人数
		\Workerman\Lib\Timer::add($time_interval, function(){
        	//ping客户端(获取房间内所有用户列表 )
            $clients_list = $this->worker->connections;
			$num = count($clients_list);
			$this->robot_ping--;
			if ($this->robot_ping == 0) {
				$this->robot_ping = mt_rand(2,10);
				$new_message = array(
					'type' => 'ping',
					'content' => $num,
					'time' => date('H:i:s')
				);
				foreach ($this->worker->connections as $conn) {
					$conn -> send(json_encode($new_message));
				}
			}

			switch (C('robot_rate')) {
				case '5':
					$robot_min = 3;
					$robot_max = 10;
					break;

				case '4':
					$robot_min = 8;
					$robot_max = 20;
					break;

				case '3':
					$robot_min = 15;
					$robot_max = 30;
					break;

				case '2':
					$robot_min = 25;
					$robot_max = 45;
					break;

				case '1':
					$robot_min = 40;
					$robot_max = 60;
					break;

				default:
					# code...
					break;
			}

			//机器人发送频率
			$this->robot_rate--;
			if ($this->robot_rate == 0) {
				$this->robot_rate = mt_rand($robot_min,$robot_max);
				if(C('robot')==1){

					$robot = $this->robot();
					$mess = $this->robot_message($robot[0]['zuhe']);
					$pk10_state = F('jnd28_3_state');
					$new_message = array(
						'type' => 'say',
						'head_img_url'=>'/Uploads'.$robot[0]['headimgurl'],
						'from_client_name' => $robot[0]['nickname'],
						'content'=>$mess[0]['content'],
						'time'=>date('H:i:s')
					);
					if($pk10_state==1){
						foreach ($this->worker->uidConnections as $con) {
							$con -> send(json_encode($new_message));
						}
						$this->add_message($new_message);
					}
				}
			}

			//机器人上下分频率
			if (F('jnd28_3_state') == 1 && C('is_robot_addfen') == '1') {
				$this->robot_rate_fen--;
				if ($this->robot_rate_fen == 0) {
					$this->robot_rate_fen = mt_rand(50,150);
					$robot = $this->robot();
					$robot_type = mt_rand(0,1);
					if ($robot_type == 0) {
						$content = "玩家「".$robot[0]['nickname']."」回分已受理，请确认";
					}else{
						$content  = "玩家「".$robot[0]['nickname']."」上分已受理，请注意查看点数";
					}
					$new_message = array(
						'uid'  => $connection->uid,
						'type' => 'addfen',
						'head_img_url'=>'/Public/main/img/kefu.jpg',
						'from_client_name' => 'GM管理员',
						'content'=> $content,
						'time'=>date('H:i:s')
					);
					foreach ($this->worker->uidConnections as $con) {
						$con -> send(json_encode($new_message));
					}
					$this->add_message($new_message);
				}
			}



    	});

		//系统公告
		\Workerman\Lib\Timer::add(300, function(){
			$new_message = array(
				'type' => 'system',
				'head_img_url'=>'/Public/main/img/system.jpg',
				'from_client_name' => '客服',
				'content'=>'由于各地网络情况不同，开奖画面可能卡住，请随时刷新,保障获取最新动态!',
				'time'=>date('H:i:s')
			);
			foreach ($this->worker->connections as $conn) {
				$conn -> send(json_encode($new_message));
			}

    	});

		//存每期结果
		\Workerman\Lib\Timer::add(5, function(){
            $caiji = M('caiji')->where("game='jnd28'")->limit(0,1)->order("id desc")->find();
            //$caiji['awardtime'] = date("Y-m-d H:i:s",$caiji['awardtime']);
            $data = json_decode(jnd28_format($caiji),true);

			if(F('periodNumber')!=$data['current']['periodNumber']){
				$today_time = date('Y-m-d',time()) . " 00:00:00";
				$res = M('number')->where("periodnumber = {$data['current']['periodNumber']} and game='jnd28'")->find();
				// var_dump($res);
				if(!$res){
					$map['awardnumbers'] = $data['current']['awardNumbers'];
					$map['awardtime'] = $data['current']['awardTime'];
					$map['time'] = strtotime($data['current']['awardTime']);
					$map['periodnumber'] = $data['current']['periodNumber'];
					$info = explode(',', $map['awardnumbers']);

					$map['number'] = serialize($info);

					$map['tema'] = $info[0]+$info[1]+$info[2] ;

					if($map['tema'] % 2 == 0){
						$map['tema_ds'] = '双';
					}
					else{
						$map['tema_ds'] = '单';
					}

					if($map['tema']>=14){
						$map['tema_dx'] = '大';
					}else{
						$map['tema_dx'] = '小';
					}

					if($info[0]>$info[1]){
						$map['zx'] = '庄';
					} else if($info[0] == $info[1]){
						$map['zx'] = '和';
					}else{
						$map['zx'] = '闲';
					}

					$map['q3'] = bj28_qzh(array($info[0],$info[1],$info[2]));

					$map['game'] = 'jnd28';
					$res1 = M('number')->add($map);
					if($res1){
						F('periodNumber',$data['current']['periodNumber']);
						F('jnd28_3data',$data);
						F('jnd28_3_is_send',0);
					}
				}else{
					F('periodNumber',$data['current']['periodNumber']);
					F('jnd28_3data',$data);
					F('jnd28_3_is_send',0);
				}
			}
    	});

	}

	/*
	 * 客户端连接时
	 *
	 * */
	public function onConnect($connection){
		$connection->onWebSocketConnect = function($connection , $http_header)
		{

		};
	}

	/**
	 * onMessage
	 * @access public
	 * 转发客户端消息
	 * @param  void
	 * @param  void
	 * @return void
	 */
	public function onMessage($connection, $data) {
		$user = session('user');

		// 客户端传递的是json数据
		$message_data = json_decode($data, true);
		if (!$message_data) {
			return;
		}

		// 1:表示执行登陆操作 2:表示执行说话操作 3:表示执行退出操作
		// 根据类型执行不同的业务
		switch($message_data['type']){
			// 客户端回应服务端的心跳
			case 'pong' :
				break;
			case 'login' :
				// 把昵称放到session中
				$client_name = htmlspecialchars($message_data['client_name']);

				/* 保存uid到connection的映射，这样可以方便的通过uid查找connection，
		        * 实现针对特定uid推送数据
		        */
				$connection->uid = $message_data['client_id'];
				$this->worker->uidConnections[$connection->uid] = $connection;

				//session($connection->uid,$client_name);

				$new_message = array(
					'type' => 'admin',
					'head_img_url'=>'/Public/main/img/kefu.jpg',
					'from_client_name' => 'GM管理员',
					'content' => C('welcome'),
					'time' => date('H:i:s')
				);
				$connection -> send(json_encode($new_message));
				break;
			case 'say' :
				$userid = $connection->uid;
				// $userinfo = M('user')->where("id = $userid")->find();
				// if ($userinfo['status'] == '0' || (time() > strtotime('06:00:00') && time() < strtotime("08:00:00"))) {
				// 	$time_message = array(
				// 		'uid'  => $connection->uid,
				// 		'type' => 'admin',
				// 		'head_img_url'=>'/Public/main/img/kefu.jpg',
				// 		'from_client_name' => 'GM管理员',
				// 		'content' => '当前时间不允许竞猜,详情请联系管理员',
				// 		'time' => date('H:i:s')
				// 	);
				// 	$connection -> send(json_encode($time_message));
				// 	return false;
				// }
				/*是否竞猜时间*/
				$jnd28_3_state = F('jnd28_3_state');
				if($jnd28_3_state == 0){
					$time_error_message = array(
						'uid'  => $connection->uid,
						'type' => 'say',
						'head_img_url'=>$message_data['headimgurl'],
						'from_client_name' => $message_data['client_name'],
						'content' => $message_data['content'],
						'time' => date('H:i:s')
					);
					$connection -> send(json_encode($time_error_message));
					$time_error_message['type'] = 'say_error';
					$this->add_message($time_error_message);/*添加信息*/

					$time_message = array(
						'uid'  => $connection->uid,
						'type' => 'admin',
						'head_img_url'=>'/Public/main/img/kefu.jpg',
						'from_client_name' => 'GM管理员',
						'content' => '「'.$message_data['content'].'」'.'非开盘时间，购买失败',
						'time' => date('H:i:s')
					);
					$connection -> send(json_encode($time_message));
					$time_message['type'] = 'error';
					$this->add_message($time_message);/*添加信息*/
				}else{
					$time = time();
					if ($time > strtotime("23:55:30")) {
						$content_msg =  "PC蛋蛋28最后一期已已封盘";
						$new_message = array(
							'uid'  => $connection->uid,
							'type' => 'admin',
							'head_img_url'=>'/Public/main/img/kefu.jpg',
							'from_client_name' => 'GM管理员',
							'content' => $content_msg,
							'time' => date('H:i:s')
						);
						$connection -> send(json_encode($new_message));
						$new_message['type'] = 'error';
						$this->add_message($new_message);/*添加信息*/
						break;
					}

					/*检测格式和金额*/
					$res = check_format_bj28($message_data['content'],C('jnd28_3qi_min_point'),C('jnd28_3qi_max_point'),C('jnd28_3_xz_open'),C('jnd28_3_xz_max'));
					if($res['error']==0 || $res['error']==2){
						$error_message = array(
							'uid'=>$connection->uid,
							'type' => 'say',
							'head_img_url'=> $message_data['headimgurl'],
							'from_client_name' => $message_data['client_name'],
							'content' => $message_data['content'],
							'time' => date('H:i:s')
						);
						$connection -> send(json_encode($error_message));
						$error_message['type'] = 'say_error';
						$this->add_message($error_message);/*添加信息*/

						if ($res['error'] == 0) {
							$content_msg =  '「'.$message_data['content'].'」'.'单笔数量最低'.C('jnd28_3qi_min_point').',购买失败';
						} else {
							$content_msg =  '「'.$message_data['content'].'」'.'单笔数量最高'.$res['xz_max'].',购买失败';
						}

						$new_message = array(
							'uid'  => $connection->uid,
							'type' => 'admin',
							'head_img_url'=>'/Public/main/img/kefu.jpg',
							'from_client_name' => 'GM管理员',
							'content' => $content_msg,
							'time' => date('H:i:s')
						);
						$connection -> send(json_encode($new_message));
						$new_message['type'] = 'error';
						$this->add_message($new_message);/*添加信息*/
					}else if($res['type']){
						/*查询积分*/
						$jifen = M('user')->where("id = $userid")->find();
						if($jifen['points']<$res['points']){
							$points_error = array(
								'uid'=>$connection->uid,
								'type' => 'say',
								'head_img_url'=> $message_data['headimgurl'],
								'from_client_name' => $message_data['client_name'],
								'content' => $message_data['content'],
								'time' => date('H:i:s')
							);
							$connection -> send(json_encode($points_error));
							$points_error['type'] = 'say_error';
							$this->add_message($points_error);/*添加信息*/

							$points_tips = array(
								'uid'  => $connection->uid,
								'type' => 'admin',
								'head_img_url'=>'/Public/main/img/kefu.jpg',
								'from_client_name' => 'GM管理员',
								'content' => '「'.$message_data['content'].'」'.'点数不足，竞猜失败',
								'time' => date('H:i:s')
							);
							$connection -> send(json_encode($points_tips));
							$points_tips['type'] = 'error';
							$this->add_message($points_tips);/*添加信息*/
						}else{
							$jnd28_3data = F('jnd28_3data');
							$user = M('user')->where("id = $userid")->find();
							//当前玩法是否超过设置金额
							$wf_points = M('order')->field("sum(del_points) as sum_del")->where("userid = {$userid} and type={$res['type']} and state=1  and number = {$jnd28_3data['next']['periodNumber']}")->find();

							$wf_max_points = 0;
							switch ($res['type']) {
								case '1':
									$wf_max_points = C('jnd28_3_xz_max')['dxds'];
									break;

								case '2':
									$wf_max_points = C('jnd28_3_xz_max')['zuhe'];
									break;

								case '3':
									$wf_max_points = C('jnd28_3_xz_max')['jdx'];
									break;

								case '4':
									$wf_max_points = C('jnd28_3_xz_max')['zx'];
									break;

								case '5':
									$wf_max_points = C('jnd28_3_xz_max')['bds'];
									break;

								case '6':
									$wf_max_points = C('jnd28_3_xz_max')['tema'];
									break;

								default:
									$wf_max_points = 0;
									break;
							}

								if ($res['points'] > $wf_max_points) {
								$points_tips = array(
									'uid'  => $connection->uid,
									'type' => 'admin',
									'head_img_url'=>'/Public/main/img/kefu.jpg',
									'from_client_name' => 'GM管理员',
									'content' => '「'.$message_data['content'].'」'.'当前玩法每期最高数量'.$wf_max_points.',您已超过，购买失败',
									'time' => date('H:i:s')
								);
								$connection -> send(json_encode($points_tips));
								$points_tips['type'] = 'error';
								$this->add_message($points_tips);/*添加信息*/
								break;
							}

							//查看已投注金额
							$user_points = M('order')->field("sum(del_points) as sum_del")->where("userid = {$userid} and state=1  and number = {$jnd28_3data['next']['periodNumber']}")->find();

							if ((intval($user_points['sum_del'])+$res['points']) > C('jnd28_3qi_max_point')) {
								$points_tips = array(
									'uid'  => $connection->uid,
									'type' => 'admin',
									'head_img_url'=>'/Public/main/img/kefu.jpg',
									'from_client_name' => 'GM管理员3',
									'content' => '「'.$message_data['content'].'」'.'每期最高点数'.C('jnd28_3qi_max_point').',您已超过，竞猜失败',
									'time' => date('H:i:s')
								);
								$connection -> send(json_encode($points_tips));
								$points_tips['type'] = 'error';
								$this->add_message($points_tips);/*添加信息*/
								break;
							}

							//判断时候低于进入房间最低点数
							if ($user['points'] < C('jnd28_3_usermin_point')) {
								$points_tips = array(
									'uid'  => $connection->uid,
									'type' => 'admin',
									'head_img_url'=>'/Public/main/img/kefu.jpg',
									'from_client_name' => 'GM管理员',
									'content' => '您的点数低于加拿大28初级房进入最低点数'.C('jnd28_3_usermin_point').',竞猜失败',
									'time' => date('H:i:s')
								);
								$connection -> send(json_encode($points_tips));
								$points_tips['type'] = 'error';
								$this->add_message($points_tips);/*添加信息*/
								break;
							}

							$map['userid'] = $userid;
							$map['type'] = $res['type'];
							$map['state'] = 1;
							$map['is_add'] = 0;
							$map['is_under'] = $user['is_under'];
							$map['time'] = time();
							$map['number'] = $jnd28_3data['next']['periodNumber'];
							$map['jincai'] = $message_data['content'];
							$map['del_points'] = $res['points'];
							$map['balance'] = $user['points']-$map['del_points'];
							$map['nickname'] = $message_data['client_name'];
							$map['username'] = $user['username'];
							$map['game'] = F('jnd28_3_game');
							$map['is_robot'] = $user['is_robot'];
							$map['t_id'] = $user['t_id'];

							$return = M('order')->add($map);


							if($return){
								/*减分*/
								$res_points = M('user')->where("id = $userid")->setDec('points',$map['del_points']);

								if($res_points){
									$points_del = array(
										'type' => 'points',
										'content' => $res['points'],
										'time' => date('H:i:s')
									);
									$connection -> send(json_encode($points_del));
								}
								//生成记录图片
								$jpg_str = $map['game']."  ".$map['number']."  ".date('Y-m-d H:i:s',$map['time'])."  ".$map['nickname']."  ".$map['username']."  ".$map['jincai']."  ".$map['del_points'];

								$jpgpath = create_jincaijpg($jpg_str);
								$res_jpg = M('order')->where("id={$return}")->save(array('jpgpath'=>$jpgpath));
								//记录用户日志
								$userlog = array(
									'username' => $user['username'],
									'nickname' => $user['nickname'],
									'type' => 1, //1 下注  2中奖 3上分  4下分  5登录系统
									'addtime' => time(),
									'content' => "用户[".$user['nickname']."]下注[".$map['game']."][".$message_data['content']."],竞猜成功，消耗".$res['points']."点，投后剩余".($user['points']-$map['del_points'])."点",
								);
								M('userlog')->add($userlog);

								$new_message2 = array(
									'uid'=>$connection->uid,
									'type' => 'say',
									'status' => $user['is_under'],
									'head_img_url'=> $message_data['headimgurl'],
									'from_client_name' => $message_data['client_name'],
									'content' => $message_data['content'],
									'time' => date('H:i:s')
								);
								if ($map['is_under']) {
									foreach ($this->worker->uidConnections as $con) {
										$con -> send(json_encode($new_message2));
									}
								}

								$add_return = $this->add_message($new_message2);/*添加信息*/
								if($add_return){
									/*成功通知*/
									$new_message1 = array(
										'uid'  => $connection->uid,
										'type' => 'admin',
										'head_img_url'=>'/Public/main/img/kefu.jpg',
										'from_client_name' => 'GM管理员',
										'content' => '「'.$message_data['content'].'」'.',购买成功',
										'time' => date('H:i:s')
									);
									$connection -> send(json_encode($new_message1));
									$new_message1['type'] = 'error';
									$this->add_message($new_message1);/*添加信息*/
								}
							}
						}
					}else{
						if (substr($message_data['content'],0,1) == '@') {
							$uid_info = explode('|',$message_data['content'])[0];
							$uid = substr($uid_info,1);
							$user = M('user')->where("id={$uid}")->find();
							if ($user) {
								$new_message6 = array(
									'uid'=>$user['id'],
									'type' => 'say',
									'status' => 1,
									'head_img_url'=> $message_data['headimgurl'],
									'from_client_name' => $message_data['client_name'],
									'content' => $message_data['content'],
									'time' => date('H:i:s')
								);
								// var_dump($new_message6);
								foreach ($this->worker->uidConnections as $con) {
									$con -> send(json_encode($new_message6));
								}
							}
						}

						if (C('is_say')) {
							$new_message2 = array(
								'uid'=>$connection->uid,
								'type' => 'say',
								'status' => 1,
								'head_img_url'=> $message_data['headimgurl'],
								'from_client_name' => $message_data['client_name'],
								'content' => $message_data['content'],
								'time' => date('H:i:s')
							);
							foreach ($this->worker->uidConnections as $con) {
								$con -> send(json_encode($new_message2));
							}
						} else {
							$format_error_message = array(
								'uid'  => $connection->uid,
								'type' => 'say',
								'head_img_url'=>$message_data['headimgurl'],
								'from_client_name' => $message_data['client_name'],
								'content' => $message_data['content'],
								'time' => date('H:i:s')
							);
							$connection -> send(json_encode($format_error_message));
							$format_error_message['type'] = 'say_error';
							$this->add_message($format_error_message);/*添加信息*/

							$new_message3 = array(
								'uid'  => $connection->uid,
								'type' => 'admin',
								'head_img_url'=>'/Public/main/img/kefu.jpg',
								'from_client_name' => 'GM管理员',
								'content' => '「'.$message_data['content'].'」'.'格式不正确,竞猜失败',
								'time' => date('H:i:s')
							);
							$connection -> send(json_encode($new_message3));
							$new_message3['type'] = 'error';
							$this->add_message($new_message3);/*添加信息*/
						}

					}
				}
				break;

			case 'robot':
				if(C('robot')==1){
					$mess = $this->robot_message();
					$robot = $this->robot();
					$jnd28_3_state = F('jnd28_3_state');
					$new_message = array(
						'type' => 'say',
						'head_img_url'=>'/Uploads'.$robot[0]['headimgurl'],
						'from_client_name' => $robot[0]['nickname'],
						'content'=>$mess[0]['content'],
						'time'=>date('H:i:s')
					);
					if($jnd28_3_state==1){
						foreach ($this->worker->uidConnections as $con) {
							$con -> send(json_encode($new_message));
						}
						$this->add_message($new_message);
					}
			}
				break;

			case 'fen':
				$robot = $this->robot();
				$robot_type = mt_rand(0,1);
				if ($robot_type == 0) {
					$content = "玩家「".$robot[0]['nickname']."」回分已受理，请确认";
				}else{
					$content  = "玩家「".$robot[0]['nickname']."」上分已受理，请注意查看点数";
				}
				$new_message = array(
					'uid'  => $connection->uid,
					'type' => 'addfen',
					'head_img_url'=>'/Public/main/img/kefu.jpg',
					'from_client_name' => 'GM管理员',
					'content'=> $content,
					'time'=>date('H:i:s')
				);
				foreach ($this->worker->uidConnections as $con) {
					$con -> send(json_encode($new_message));
				}
				$this->add_message($new_message);


				break;
		}
	}


	public function robot_message($zuhe){
		$zuhe = $zuhe?$zuhe:1;
		$count = M('robot_message')->where("type=6 && zuhe = {$zuhe}")->count();
     	$rand = mt_rand(0,$count-1); //产生随机数。
     	$limit = $rand.','.'1';
    	$data = M('robot_message')->where("type=4 && zuhe = {$zuhe}")->limit($limit)->select();
		return $data;
	}

	public function robot($zuhe=null){
		$count = M('robot')->count();
     	$rand = mt_rand(0,$count-1); //产生随机数。
     	$limit = $rand.','.'1';
    	$data = M('robot')->limit($limit)->select();
		return $data;
	}

	/**
	 * onClose
	 * 关闭连接
	 * @access public
	 * @param  void
	 * @return void
	 */
	public function onClose($connection) {
		$user = session($connection->id);
		foreach ($this->worker->uidConnections as $con) {
			if (!empty($user)) {
				$new_message = array(
					'type' => 'logout',
					'from_client_name' => $user,
					'time' => date('H:i:s')
				);
				$con -> send(json_encode($new_message));
			}
		}

		if(isset($connection->uid)){
	        // 连接断开时删除映射
	        unset($this->worker->uidConnections[$connection->uid]);
    	}
	}


	/*存竞猜记录和信息*/
	protected function add_order($mew_message){
		$res = M('order')->add($mew_message);
		return $res;
	}
	protected function add_message($new_message){

		if (!empty($new_message)) {
			$new_message['game'] = 'jnd28_3';
			$res = M('message')->add($new_message);
			return $res;
		}
	}


	/*
	 * 竞猜成功  加分
	 * */
	public function add_points($order_id,$userid,$points){
		$res = M('user')->where("id = $userid")->setInc('points',$points);
		if($res){
			$res1 = M('order')->where("id = $order_id")->setField(array('is_add'=>'1','add_points'=>$points));
			//记录用户日志
			$user = M('user')->where("id=$userid")->find();
			$order = M('order')->where("id = $order_id")->find();
			$userlog = array(
				'username' => $user['username'],
				'nickname' => $user['nickname'],
				'type' => 2, //1 下注  2中奖 3上分  4下分  5登录系统
				'addtime' => time(),
				'content' => "用户[".$user['nickname']."][".$order['game']."][Number".$order['number']."][".$order['game']."]下注[".$order['jincai']."],竞猜中奖，奖金{$points}点，系统自动派奖后余额".($order['balance']+$points)."点",
			);
			M('userlog')->add($userlog);
		}
		if($res && $res1){
			return 1;
		}
	}

	/*竞猜成功通知
	 * */
	public function send_msg($type,$points,$userid){
		$message_points = array(
			'type' => $type,
			'points'=>	$points,
			'time'=>date('H:i:s')
		);
		if(isset($this->worker->uidConnections[$userid])){
	        $connection = $this->worker->uidConnections[$userid];
	        $connection->send(json_encode($message_points));
	    }
	}

    private function getTemaNum( $num ){
        if ($num == '0' || $num == '27') {
            return 0;
        } else if($num == '1' || $num == '26') {
            return 1;
        } else if($num == '2' || $num == '25') {
            return 2;
        } else if($num == '3' || $num == '24') {
            return 3;
        } else if($num == '4' || $num == '23') {
            return 4;
        } else if($num == '5' || $num == '22') {
            return 5;
        } else if($num == '6' || $num == '21') {
            return 6;
        } else if($num == '7' || $num == '20') {
            return 7;
        } else if($num == '8' || $num == '19') {
            return 8;
        } else if($num == '9' || $num == '18') {
            return 9;
        } else if($num == '10' || $num == '17') {
            return 10;
        } else if($num == '11' || $num == '16') {
            return 11;
        } else if($num == '12' || $num == '15') {
            return 12;
        } else if($num == '13' || $num == '14') {
            return 13;
        }
        return -1;
    }

}
?>
