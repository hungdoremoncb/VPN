<?php
namespace Home\Controller;

use Think\Server;
header('content-type:text/html;charset=utf-8');
//本程序来自：友信财富（qq:2370250999）
class YuebaoController extends Server
{

    protected $socket = 'websocket://103.166.184.168:65525';

    /*
     * 添加定时器
     * 监控连接状态
     */
    public function onWorkerStart()
    {
        $typearr = array(
            1 => 'pk10'
        ); // 2 => 'xyft', 3 => 'cqssc'
        
        \Workerman\Lib\Timer::add(7, function () {
            
           // require_once dirname(__FILE__).'/ApiController.class.php';
            //$Api = new ApiController();
            //$Api->index();
			
			$this->fanshui();
            
            //file_put_contents('test.txt', time() . PHP_EOL);
        });
        
        // 重庆时时彩
        
        // 友信财富北京28采集
        
        // 友信财富北京28采集
        
        // 友信财富加拿大28采集
        
        // 是否自动反水
        //$this->fanshui();
    }

    /*
     * 客户端连接时
     *
     */
    public function fanshui()
    {
        \Workerman\Lib\Timer::add(1, function () {
            // 开启自动返水
           // if (C('is_auto_fs') == '1') {
			 
			  
//			 $xxres3333 = M('user')->query('update think_user set  treasure_day  = 1 ');
			 
			 
                if ( time() >= strtotime('23:58:00') && time() <= strtotime('23:58:05') ) 
				{
					echo 'yu e bao fan xian 。。 ';
					
					// 自动返水
					$userList = M('user')->where("status = 1 and treasure_capital != 0 and (treasure_day is null or   treasure_day=0 )")->select();
					$treasure_rate =  C('treasure_rate');
					if( !isset($treasure_rate)) {
						$treasure_rate = 0.05;
					}
					$treasure_rate = $treasure_rate *0.01;
					
					M('user')->where("status = 1    ")->save(array("treasure_day"=>1,"status"=>1));
					ECHO M('user')->getlastsql();
					
					//echo $treasure_rate.'   ';
					//var_dump($userList);
					//$userList = M('user')->where("status = 1 and treasure_capital != 0 ")->select();
						
						foreach ($userList as $a => $userinfo) {
							
							 $id =  $userinfo['id'];
							 $money = $userinfo['treasure_capital'] * $treasure_rate ;
							 
							// echo $money.'  ';
							 $treasure = M('treasure');
							 
							 /*
							$map2['userid'] = $id;
							$map2['status'] = "未领取";
							$map2['types'] = "利息";
							
							
							 
							$treasure_notget = $treasure->field("count(id) as count,sum(moneys) as sum_moneys ")
								->where($map2)
								->find();
								*/
								
								
							$add = array(
								'userid' => $id,
								'moneys' => $money,
								'times' => time(),
								'types' => '利息',
								'status' => '未领取',
								'treasure_rates'=> $money ,
								'treasure_capital'=> $userinfo['treasure_capital'],
								'details'=>'利息'.$money.'元',
								 
							);
							$res = M('treasure')->add($add);
							
							//M('user')->where("status = 1   and id = ".$id )->save(array("treasure_day"=>1,"status"=>1));
							
							//$res222 = M('user')->where("status = 1  and id = ".$id )->setInc('treasure_day', 1);
							
							
							M('user')->query('update think_user set  treasure_day  = 1 where status = 1  and id = '.$id);
							
						}
						
						//$res222 = M('user')->where("status = 1   " )->setInc('treasure_day', 1);
						
						//M('user')->where("status = 1 and treasure_capital != 0  ")->save(array("treasure_day"=>1,"status"=>1));
						M('user')->query('update think_user set  treasure_day  = 1 where status = 1 and treasure_capital != 0 ');
						
                }
				
				// 改为未领
				if ( time() >= strtotime('00:30:00') && time() <= strtotime('00:30:10') ) 
				{
					//M('user')->where("status = 1 and treasure_capital != 0 ")->save(array("treasure_day"=>0));
					
					M('user')->query('update think_user set  treasure_day = 0  ');
				}
				
          //  }
        });
    }

    public function onConnect($connection)
    {
        $connection->onWebSocketConnect = function ($connection, $http_header) {};
    }

    /**
     * onMessage
     *
     * @access public
     *         转发客户端消息
     * @param
     *            void
     * @param
     *            void
     * @return void
     */
    public function onMessage($connection, $data)
    {}

    /**
     * onClose
     * 关闭连接
     *
     * @access public
     * @param
     *            void
     * @return void
     */
    public function onClose($connection)
    {}
}
?>