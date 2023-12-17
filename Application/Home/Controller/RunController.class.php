<?php
namespace Home\Controller;

use Think\Controller;
//本程序来自：友信财富（qq:2370250999）
class RunController extends BaseController
{

	/*20180503 六合彩 add by gison*/
	public function lhc_kj()
    {
        $this->display();
    }

    public function ssc_kj()
    {
        $this->display();
    }

    public function bj28_kj()
    {
        $this->display();
    }
	public function bj282_kj()
    {
        $this->display();
    }

    public function jnd28_kj()
    {
        $this->display();
    }
	
	public function jnd282_kj()
    {
        $this->display();
    }
	
	public function jnd283_kj()
    {
        $this->display();
    }
    public function k3_kj()
    {
        $this->display();
    }

    public function kefu_wx()
    {
        $info = M('config')->order('id desc')->find();
        $this->assign('info', $info);
        $this->display();
    }

    public function index()
    {
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        $is_weixin = is_weixin();
        
        // 互动列表
        $article = M('hd');
        $count = $article->count();
        $page = new \Think\Page($count, 5);
        $show = $page->show();
        $list = $article->limit($page->firstRow . ',' . $page->listRows)
            ->order("addtime desc")
            ->select();
        
        $this->assign('show', $show);
        $this->assign('list', $list);
        $this->assign("auth", $auth);
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        if (C('index_page') == '1') {
            $this->display("index_1");
        } else {
            $this->display();
        }
    }
	
	// 六合彩
	public function lhc()
    {
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        
        // 10期结果
        $list = M('number')->where("game='lhc'")
            ->order("id DESC")
            ->limit(10)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
        
		
		$userinfo = session('user');
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		$map['time'] = array('egt',$today);
        $map['state'] = 1;
        $map['userid'] = $userinfo['id'];
		$order = M('order');
		$points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")
            ->where($map)
            ->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
		$this->assign('points_tj', $points_tj);
		
		
		$sebo = array(
			'01'=>'红波','02'=>'红波','07'=>'红波','08'=>'红波','12'=>'红波','13'=>'红波','18'=>'红波','19'=>'红波','23'=>'红波','24'=>'红波','29'=>'红波','30'=>'红波','34'=>'红波','35'=>'红波','40'=>'红波','45'=>'红波','46'=>'红波',
			'03'=>'蓝波','04'=>'蓝波','09'=>'蓝波','10'=>'蓝波','14'=>'蓝波','15'=>'蓝波','20'=>'蓝波','25'=>'蓝波','26'=>'蓝波','31'=>'蓝波','36'=>'蓝波','37'=>'蓝波','41'=>'蓝波','42'=>'蓝波','47'=>'蓝波','48'=>'蓝波',
			'05'=>'绿波','06'=>'绿波','11'=>'绿波','16'=>'绿波','17'=>'绿波','21'=>'绿波','22'=>'绿波','27'=>'绿波','28'=>'绿波','32'=>'绿波','33'=>'绿波','38'=>'绿波','39'=>'绿波','43'=>'绿波','44'=>'绿波','49'=>'绿波'
		);
		$shengxiao = array(
			1=>'猪', 13=>'猪', 25=>'猪', 37=>'猪', 49=>'猪', 
			12=>'鼠', 24=>'鼠', 36=>'鼠', 48=>'鼠', 
			11=>'牛', 23=>'牛', 35=>'牛', 47=>'牛', 
			10=>'虎', 22=>'虎', 34=>'虎', 46=>'虎', 
			9=>'兔', 21=>'兔', 33=>'兔', 45=>'兔',
			8=>'龙', 20=>'龙', 32=>'龙', 44=>'龙',
			7=>'蛇', 19=>'蛇', 31=>'蛇', 43=>'蛇',
			6=>'马', 18=>'马', 30=>'马', 42=>'马',
			5=>'羊', 17=>'羊', 29=>'羊', 41=>'羊',
			4=>'猴', 16=>'猴', 28=>'猴', 40=>'猴',
			3=>'鸡', 15=>'鸡', 27=>'鸡', 39=>'鸡',
			2=>'狗', 14=>'狗', 26=>'狗', 38=>'狗',
		);
		$ys['红波'] = 'red';
		$ys['蓝波'] = 'blue';
		$ys['绿波'] = 'green';
        foreach ($list as $key => $value) {
            $current_number =array();
			$sb =array();
            $number1 = explode(',', $value['awardnumbers']);
            foreach ($number1 as $k => $val) {
				$current_number[$k]=$val;
				$sb[$k]=$ys[$sebo[$val]];
			}
			$current_number['sebo']=$sb;
			$current_number['dx']=$value['tema_dx'];
			$current_number['ds']=$value['tema_ds'];
			$current_number['sx']=$shengxiao[$value['tema']];
			$current_number['periodnumber']=substr($value['periodnumber'],4,3);
            $kjlist[$key] = $current_number;
        }
        $this->assign('kjlist', $kjlist);
		
		// 聊天信息
        $msglist = M('message')->where("status=1 and game='lhc'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('msglist', $msglist);
		
		
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        if (C('index_page') == '1') {
            $this->display("lhc_1");
        } else {
            $this->display();
        }
    }

    public function pk10()
    {
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        
        // 10期结果
        $list = M('number')->where("game='pk10'")
            ->order("id DESC")
            ->limit(10)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
		
		
		$userinfo = session('user');
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		$map['time'] = array('egt',$today);
        $map['state'] = 1;
        $map['userid'] = $userinfo['id'];
		$order = M('order');
		$points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")
            ->where($map)
            ->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
		$this->assign('points_tj', $points_tj);
		
		foreach ($list as $key => $value) {
            $current_number = $value;
			
			$current_number[periodnumber] = substr($current_number[periodnumber],4);
            $number1 = explode(',', $current_number['awardnumbers']);
            
			
            $current_number[a] = $number1[0];
            $current_number[b] = $number1[1];
            $current_number[c] = $number1[2];
			$current_number[d] = $number1[3];
			$current_number[e] = $number1[4];
			$current_number[f] = $number1[5];
			$current_number[g] = $number1[6];
			$current_number[h] = $number1[7];
			$current_number[i] = $number1[8];
			$current_number[j] = $number1[9];
            
            $kjlist[$key] = $current_number;
        }
		$this->assign('kjlist', $kjlist);
		
		// 聊天信息
        $msglist = M('message')->where("status=1 and game='pk10'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('msglist', $msglist);
		
        
        
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        $this->assign('room', I('room'));
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        if (C('index_page') == '1') {
            $this->display("pk10_1");
        } else {
            $this->display();
        }
    }
	
	public function er75sc()
    {
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        
        // 10期结果
        $list = M('number')->where("game='er75sc'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
        
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        $this->display();
    }

    public function xyft()
    {
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        // 10期结果
        $list = M('number')->where("game='xyft'")
            ->order("id DESC")
            ->limit(10)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        // 判断赛车和飞艇的类型
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
		
		$userinfo = session('user');
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		$map['time'] = array('egt',$today);
        $map['state'] = 1;
        $map['userid'] = $userinfo['id'];
		$order = M('order');
		$points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")
            ->where($map)
            ->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
		$this->assign('points_tj', $points_tj);
		
		foreach ($list as $key => $value) {
            $current_number = $value;
			
			$current_number[periodnumber] = substr($current_number[periodnumber],6);
            $number1 = explode(',', $current_number['awardnumbers']);
            
			
            $current_number[a] = $number1[0];
            $current_number[b] = $number1[1];
            $current_number[c] = $number1[2];
			$current_number[d] = $number1[3];
			$current_number[e] = $number1[4];
			$current_number[f] = $number1[5];
			$current_number[g] = $number1[6];
			$current_number[h] = $number1[7];
			$current_number[i] = $number1[8];
			$current_number[j] = $number1[9];
            
            $kjlist[$key] = $current_number;
        }
		$this->assign('kjlist', $kjlist);
		
		// 聊天信息
        $msglist = M('message')->where("status=1 and game='xyft'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('msglist', $msglist);
        
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        if (C('index_page') == '1') {
            $this->display("xyft_1");
        } else {
            $this->display();
        }
    }

    public function ssc()
    {
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        // 10期结果
        $list = M('number')->where("game='ssc'")
            ->order("id DESC")
            ->limit(10)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        // 判断赛车和飞艇的类型
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
		
		$userinfo = session('user');
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		$map['time'] = array('egt',$today);
        $map['state'] = 1;
        $map['userid'] = $userinfo['id'];
		$order = M('order');
		$points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")
            ->where($map)
            ->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
		
		foreach ($list as $key => $value) {
            $current_number = $value;
			$current_number['periodnumber'] = substr($current_number['periodnumber'],5);
			
            $number1 = explode(',', $current_number['awardnumbers']);
            
			
            $current_number[a] = $number1[0];
            $current_number[b] = $number1[1];
            $current_number[c] = $number1[2];
			$current_number[d] = $number1[3];
			$current_number[e] = $number1[4];
            
            $kjlist[$key] = $current_number;
			
			
        }
		
		$this->assign('kjlist', $kjlist);
		
		// 聊天信息
        $msglist = M('message')->where("status=1 and game='ssc'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('msglist', $msglist);
        
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        $this->assign('points_tj', $points_tj);
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        if (C('index_page') == '1') {
            $this->display("ssc_1");
        } else {
            $this->display();
        }
    }

    public function bj28()
    {
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        // 10期结果
        $list = M('number')->where("game='bj28'")
            ->order("id DESC")
            ->limit(10)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        // 判断赛车和飞艇的类型
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
		
		
		$userinfo = session('user');
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		$map['time'] = array('egt',$today);
		
        $map['state'] = 1;
        $map['userid'] = $userinfo['id'];
		$order = M('order');
		$points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")
            ->where($map)
            ->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
		$this->assign('points_tj', $points_tj);
		
		
        foreach ($list as $key => $value) {
            $current_number = $value;
            $number1 = explode(',', $current_number['awardnumbers']);
            
            $numberOne = $number1[0];
            $numberTwo = $number1[1];
            $numberThree = $number1[2];
			
            $tema_number = $numberOne + $numberTwo + $numberThree;
            $current_number[numberOne] = $numberOne;
            $current_number[numberTwo] = $numberTwo;
            $current_number[numberThree] = $numberThree;
            
            if ($tema_number <= 13) {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '小双';
                } else {
                    $current_number['zuhe'] = '小单';
                }
            } else {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '大双';
                } else {
                    $current_number['zuhe'] = '大单';
                }
            }
            if ($numberOne > $numberTwo) {
                $current_number['zx'] = '庄';
            } elseif ($numberOne == $numberTwo) {
                $current_number['zx'] = '和';
            } else {
                $current_number['zx'] = '闲';
            }
            $current_number['q3'] = bj28_qzh(array(
                $numberOne,
                $numberTwo,
                $numberThree
            ));
            
            if ($tema_number >= 0 && $tema_number <= 5) {
                $current_number['jdx'] = '极小';
            } else 
                if ($tema_number >= 22 && $tema_number <= 27) {
                    $current_number['jdx'] = '极大';
                } else {
                    $current_number['jdx'] = '';
                }
            $kjlist[$key] = $current_number;
        }
        
        $this->assign('kjlist', $kjlist);
		
		// 聊天信息
        $msglist = M('message')->where("status=1 and game='bj28'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('msglist', $msglist);
		
        
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        if (C('index_page') == '1') {
            $this->display("bj28_1");
        } else {
            $this->display();
        }
    }
	// 房间2
	public function bj282()
    {
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        // 10期结果
        $list = M('number')->where("game='bj28'")
            ->order("id DESC")
            ->limit(10)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        // 判断赛车和飞艇的类型
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
		
		
		$userinfo = session('user');
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		$map['time'] = array('egt',$today);
        $map['state'] = 1;
        $map['userid'] = $userinfo['id'];
		$order = M('order');
		$points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")
            ->where($map)
            ->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
		$this->assign('points_tj', $points_tj);
		
		
        foreach ($list as $key => $value) {
            $current_number = $value;
            $number1 = explode(',', $current_number['awardnumbers']);
            
            $numberOne = $number1[0];
            $numberTwo = $number1[1];
            $numberThree = $number1[2];
			
            $tema_number = $numberOne + $numberTwo + $numberThree;
            $current_number[numberOne] = $numberOne;
            $current_number[numberTwo] = $numberTwo;
            $current_number[numberThree] = $numberThree;
            
            if ($tema_number <= 13) {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '小双';
                } else {
                    $current_number['zuhe'] = '小单';
                }
            } else {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '大双';
                } else {
                    $current_number['zuhe'] = '大单';
                }
            }
            if ($numberOne > $numberTwo) {
                $current_number['zx'] = '庄';
            } elseif ($numberOne == $numberTwo) {
                $current_number['zx'] = '和';
            } else {
                $current_number['zx'] = '闲';
            }
            $current_number['q3'] = bj28_qzh(array(
                $numberOne,
                $numberTwo,
                $numberThree
            ));
            
            if ($tema_number >= 0 && $tema_number <= 5) {
                $current_number['jdx'] = '极小';
            } else 
                if ($tema_number >= 22 && $tema_number <= 27) {
                    $current_number['jdx'] = '极大';
                } else {
                    $current_number['jdx'] = '';
                }
            $kjlist[$key] = $current_number;
        }
        
        $this->assign('kjlist', $kjlist);
		
		// 聊天信息
        $msglist = M('message')->where("status=1 and game='bj28'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('msglist', $msglist);
		
        
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        if (C('index_page') == '1') {
            $this->display("bj28_1");
        } else {
            $this->display();
        }
    }
	// 房间3
	public function bj283()
    {
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        // 10期结果
        $list = M('number')->where("game='bj28'")
            ->order("id DESC")
            ->limit(10)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        // 判断赛车和飞艇的类型
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
		
		
		$userinfo = session('user');
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		$map['time'] = array('egt',$today);
        $map['state'] = 1;
        $map['userid'] = $userinfo['id'];
		$order = M('order');
		$points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")
            ->where($map)
            ->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
		$this->assign('points_tj', $points_tj);
		
		
        foreach ($list as $key => $value) {
            $current_number = $value;
            $number1 = explode(',', $current_number['awardnumbers']);
            
            $numberOne = $number1[0];
            $numberTwo = $number1[1];
            $numberThree = $number1[2];
			
            $tema_number = $numberOne + $numberTwo + $numberThree;
            $current_number[numberOne] = $numberOne;
            $current_number[numberTwo] = $numberTwo;
            $current_number[numberThree] = $numberThree;
            
            if ($tema_number <= 13) {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '小双';
                } else {
                    $current_number['zuhe'] = '小单';
                }
            } else {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '大双';
                } else {
                    $current_number['zuhe'] = '大单';
                }
            }
            if ($numberOne > $numberTwo) {
                $current_number['zx'] = '庄';
            } elseif ($numberOne == $numberTwo) {
                $current_number['zx'] = '和';
            } else {
                $current_number['zx'] = '闲';
            }
            $current_number['q3'] = bj28_qzh(array(
                $numberOne,
                $numberTwo,
                $numberThree
            ));
            
            if ($tema_number >= 0 && $tema_number <= 5) {
                $current_number['jdx'] = '极小';
            } else 
                if ($tema_number >= 22 && $tema_number <= 27) {
                    $current_number['jdx'] = '极大';
                } else {
                    $current_number['jdx'] = '';
                }
            $kjlist[$key] = $current_number;
        }
        
        $this->assign('kjlist', $kjlist);
		
		// 聊天信息
        $msglist = M('message')->where("status=1 and game='bj28'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('msglist', $msglist);
		
        
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        if (C('index_page') == '1') {
            $this->display("bj28_1");
        } else {
            $this->display();
        }
    }
    public function jnd28()
    {
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        // 10期结果
        $list = M('number')->where("game='jnd28'")
            ->order("id DESC")
            ->limit(10)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        // 判断赛车和飞艇的类型
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
		
		$userinfo = session('user');
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		$map['time'] = array('egt',$today);
        $map['state'] = 1;
        $map['userid'] = $userinfo['id'];
		$order = M('order');
		$points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")
            ->where($map)
            ->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
		$this->assign('points_tj', $points_tj);
		
		
        foreach ($list as $key => $value) {
            $current_number = $value;
            $number1 = explode(',', $current_number['awardnumbers']);
            
            $numberOne = $number1[0];
            $numberTwo = $number1[1];
            $numberThree = $number1[2];
			
            $tema_number = $numberOne + $numberTwo + $numberThree;
            $current_number[numberOne] = $numberOne;
            $current_number[numberTwo] = $numberTwo;
            $current_number[numberThree] = $numberThree;
            
            if ($tema_number <= 13) {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '小双';
                } else {
                    $current_number['zuhe'] = '小单';
                }
            } else {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '大双';
                } else {
                    $current_number['zuhe'] = '大单';
                }
            }
            if ($numberOne > $numberTwo) {
                $current_number['zx'] = '庄';
            } elseif ($numberOne == $numberTwo) {
                $current_number['zx'] = '和';
            } else {
                $current_number['zx'] = '闲';
            }
            $current_number['q3'] = bj28_qzh(array(
                $numberOne,
                $numberTwo,
                $numberThree
            ));
            
            if ($tema_number >= 0 && $tema_number <= 5) {
                $current_number['jdx'] = '极小';
            } else 
                if ($tema_number >= 22 && $tema_number <= 27) {
                    $current_number['jdx'] = '极大';
                } else {
                    $current_number['jdx'] = '';
                }
            $kjlist[$key] = $current_number;
        }
        
        $this->assign('kjlist', $kjlist);
		
		// 聊天信息
        $msglist = M('message')->where("status=1 and game='jnd28'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('msglist', $msglist);
        
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        if (C('index_page') == '1') {
            $this->display("jnd28_1");
        } else {
            $this->display();
        }
    }
	//房间2
	public function jnd282()
    {
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        // 10期结果
        $list = M('number')->where("game='jnd28'")
            ->order("id DESC")
            ->limit(10)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        // 判断赛车和飞艇的类型
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
		
		$userinfo = session('user');
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		$map['time'] = array('egt',$today);
        $map['state'] = 1;
        $map['userid'] = $userinfo['id'];
		$order = M('order');
		$points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")
            ->where($map)
            ->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
		$this->assign('points_tj', $points_tj);
		
		
        foreach ($list as $key => $value) {
            $current_number = $value;
            $number1 = explode(',', $current_number['awardnumbers']);
            
            $numberOne = $number1[0];
            $numberTwo = $number1[1];
            $numberThree = $number1[2];
			
            $tema_number = $numberOne + $numberTwo + $numberThree;
            $current_number[numberOne] = $numberOne;
            $current_number[numberTwo] = $numberTwo;
            $current_number[numberThree] = $numberThree;
            
            if ($tema_number <= 13) {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '小双';
                } else {
                    $current_number['zuhe'] = '小单';
                }
            } else {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '大双';
                } else {
                    $current_number['zuhe'] = '大单';
                }
            }
            if ($numberOne > $numberTwo) {
                $current_number['zx'] = '庄';
            } elseif ($numberOne == $numberTwo) {
                $current_number['zx'] = '和';
            } else {
                $current_number['zx'] = '闲';
            }
            $current_number['q3'] = bj28_qzh(array(
                $numberOne,
                $numberTwo,
                $numberThree
            ));
            
            if ($tema_number >= 0 && $tema_number <= 5) {
                $current_number['jdx'] = '极小';
            } else 
                if ($tema_number >= 22 && $tema_number <= 27) {
                    $current_number['jdx'] = '极大';
                } else {
                    $current_number['jdx'] = '';
                }
            $kjlist[$key] = $current_number;
        }
        
        $this->assign('kjlist', $kjlist);
		
		// 聊天信息
        $msglist = M('message')->where("status=1 and game='jnd28'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('msglist', $msglist);
        
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        if (C('index_page') == '1') {
            $this->display("jnd28_1");
        } else {
            $this->display();
        }
    }
	
	//房间3
	public function jnd283()
    {
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        // 10期结果
        $list = M('number')->where("game='jnd28'")
            ->order("id DESC")
            ->limit(10)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        // 判断赛车和飞艇的类型
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
		
		$userinfo = session('user');
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		$map['time'] = array('egt',$today);
        $map['state'] = 1;
        $map['userid'] = $userinfo['id'];
		$order = M('order');
		$points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")
            ->where($map)
            ->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
		$this->assign('points_tj', $points_tj);
		
		
        foreach ($list as $key => $value) {
            $current_number = $value;
            $number1 = explode(',', $current_number['awardnumbers']);
            
            $numberOne = $number1[0];
            $numberTwo = $number1[1];
            $numberThree = $number1[2];
			
            $tema_number = $numberOne + $numberTwo + $numberThree;
            $current_number[numberOne] = $numberOne;
            $current_number[numberTwo] = $numberTwo;
            $current_number[numberThree] = $numberThree;
            
            if ($tema_number <= 13) {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '小双';
                } else {
                    $current_number['zuhe'] = '小单';
                }
            } else {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '大双';
                } else {
                    $current_number['zuhe'] = '大单';
                }
            }
            if ($numberOne > $numberTwo) {
                $current_number['zx'] = '庄';
            } elseif ($numberOne == $numberTwo) {
                $current_number['zx'] = '和';
            } else {
                $current_number['zx'] = '闲';
            }
            $current_number['q3'] = bj28_qzh(array(
                $numberOne,
                $numberTwo,
                $numberThree
            ));
            
            if ($tema_number >= 0 && $tema_number <= 5) {
                $current_number['jdx'] = '极小';
            } else 
                if ($tema_number >= 22 && $tema_number <= 27) {
                    $current_number['jdx'] = '极大';
                } else {
                    $current_number['jdx'] = '';
                }
            $kjlist[$key] = $current_number;
        }
        
        $this->assign('kjlist', $kjlist);
		
		// 聊天信息
        $msglist = M('message')->where("status=1 and game='jnd28'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('msglist', $msglist);
        
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        if (C('index_page') == '1') {
            $this->display("jnd28_1");
        } else {
            $this->display();
        }
    }
	
	public function xjp28()
    {
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        // 10期结果
        $list = M('number')->where("game='xjp28'")
            ->order("id DESC")
            ->limit(10)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        // 判断赛车和飞艇的类型
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
		
		$userinfo = session('user');
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		$map['time'] = array('egt',$today);
        $map['state'] = 1;
        $map['userid'] = $userinfo['id'];
		$order = M('order');
		$points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")
            ->where($map)
            ->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
		$this->assign('points_tj', $points_tj);
		

        foreach ($list as $key => $value) {
            $current_number = $value;
			$current_number['periodnumber'] = $current_number['periodnumber'];
            $number1 = explode(',', $current_number['awardnumbers']);
            
            $numberOne = $number1[0];
            $numberTwo = $number1[1];
            $numberThree = $number1[2];
			
            $tema_number = $numberOne + $numberTwo + $numberThree;
            $current_number[numberOne] = $numberOne;
            $current_number[numberTwo] = $numberTwo;
            $current_number[numberThree] = $numberThree;
            
            if ($tema_number <= 13) {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '小双';
                } else {
                    $current_number['zuhe'] = '小单';
                }
            } else {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '大双';
                } else {
                    $current_number['zuhe'] = '大单';
                }
            }
            if ($numberOne > $numberTwo) {
                $current_number['zx'] = '庄';
            } elseif ($numberOne == $numberTwo) {
                $current_number['zx'] = '和';
            } else {
                $current_number['zx'] = '闲';
            }
            $current_number['q3'] = bj28_qzh(array(
                $numberOne,
                $numberTwo,
                $numberThree
            ));
            
            if ($tema_number >= 0 && $tema_number <= 5) {
                $current_number['jdx'] = '极小';
            } else 
                if ($tema_number >= 22 && $tema_number <= 27) {
                    $current_number['jdx'] = '极大';
                } else {
                    $current_number['jdx'] = '';
                }
            $kjlist[$key] = $current_number;
        }
        
        $this->assign('kjlist', $kjlist);
		
		// 聊天信息
        $msglist = M('message')->where("status=1 and game='xjp28' and room=1")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('msglist', $msglist);
        
		//下注设置
		$userres=M('user')->field('xzstatus')->find($userinfo['id']);
		$this->assign('xzstatus', $userres['xzstatus']);
		
		
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
       
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        if (C('index_page') == '1') {
            $this->display();
        } else {
            $this->display();
        }
    }
	// 房间2
	public function xjp282()
    {
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        // 10期结果
        $list = M('number')->where("game='xjp28'")
            ->order("id DESC")
            ->limit(10)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        // 判断赛车和飞艇的类型
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
		
		$userinfo = session('user');
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		$map['time'] = array('egt',$today);
        $map['state'] = 1;
        $map['userid'] = $userinfo['id'];
		$order = M('order');
		$points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")
            ->where($map)
            ->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
		$this->assign('points_tj', $points_tj);
		
		
        foreach ($list as $key => $value) {
            $current_number = $value;
			$current_number['periodnumber'] = $current_number['periodnumber'];
            $number1 = explode(',', $current_number['awardnumbers']);
            
            $numberOne = $number1[0];
            $numberTwo = $number1[1];
            $numberThree = $number1[2];
			
            $tema_number = $numberOne + $numberTwo + $numberThree;
            $current_number[numberOne] = $numberOne;
            $current_number[numberTwo] = $numberTwo;
            $current_number[numberThree] = $numberThree;
            
            if ($tema_number <= 13) {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '小双';
                } else {
                    $current_number['zuhe'] = '小单';
                }
            } else {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '大双';
                } else {
                    $current_number['zuhe'] = '大单';
                }
            }
            if ($numberOne > $numberTwo) {
                $current_number['zx'] = '庄';
            } elseif ($numberOne == $numberTwo) {
                $current_number['zx'] = '和';
            } else {
                $current_number['zx'] = '闲';
            }
            $current_number['q3'] = bj28_qzh(array(
                $numberOne,
                $numberTwo,
                $numberThree
            ));
            
            if ($tema_number >= 0 && $tema_number <= 5) {
                $current_number['jdx'] = '极小';
            } else 
                if ($tema_number >= 22 && $tema_number <= 27) {
                    $current_number['jdx'] = '极大';
                } else {
                    $current_number['jdx'] = '';
                }
            $kjlist[$key] = $current_number;
        }
        
        $this->assign('kjlist', $kjlist);
		
		// 聊天信息
        $msglist = M('message')->where("status=1 and game='xjp28' and room=2")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('msglist', $msglist);
        
		
		//下注设置
		$userres=M('user')->field('xzstatus')->find($userinfo['id']);
		$this->assign('xzstatus', $userres['xzstatus']);
		
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        if (C('index_page') == '1') {
            $this->display();
        } else {
            $this->display();
        }
    }
	// 房间3
	public function xjp283()
    {
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        // 10期结果
        $list = M('number')->where("game='xjp28'")
            ->order("id DESC")
            ->limit(10)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        // 判断赛车和飞艇的类型
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
		
		$userinfo = session('user');
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		$map['time'] = array('egt',$today);
        $map['state'] = 1;
        $map['userid'] = $userinfo['id'];
		$order = M('order');
		$points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")
            ->where($map)
            ->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
		$this->assign('points_tj', $points_tj);
		
		
        foreach ($list as $key => $value) {
            $current_number = $value;
			$current_number['periodnumber'] = $current_number['periodnumber'];
            $number1 = explode(',', $current_number['awardnumbers']);
            
            $numberOne = $number1[0];
            $numberTwo = $number1[1];
            $numberThree = $number1[2];
			
            $tema_number = $numberOne + $numberTwo + $numberThree;
            $current_number[numberOne] = $numberOne;
            $current_number[numberTwo] = $numberTwo;
            $current_number[numberThree] = $numberThree;
            
            if ($tema_number <= 13) {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '小双';
                } else {
                    $current_number['zuhe'] = '小单';
                }
            } else {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '大双';
                } else {
                    $current_number['zuhe'] = '大单';
                }
            }
            if ($numberOne > $numberTwo) {
                $current_number['zx'] = '庄';
            } elseif ($numberOne == $numberTwo) {
                $current_number['zx'] = '和';
            } else {
                $current_number['zx'] = '闲';
            }
            $current_number['q3'] = bj28_qzh(array(
                $numberOne,
                $numberTwo,
                $numberThree
            ));
            
            if ($tema_number >= 0 && $tema_number <= 5) {
                $current_number['jdx'] = '极小';
            } else 
                if ($tema_number >= 22 && $tema_number <= 27) {
                    $current_number['jdx'] = '极大';
                } else {
                    $current_number['jdx'] = '';
                }
            $kjlist[$key] = $current_number;
        }
        
        $this->assign('kjlist', $kjlist);
		
		// 聊天信息
        $msglist = M('message')->where("status=1 and game='xjp28' and room=3")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('msglist', $msglist);
        
		//下注设置
		$userres=M('user')->field('xzstatus')->find($userinfo['id']);
		$this->assign('xzstatus', $userres['xzstatus']);
		
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        if (C('index_page') == '1') {
            $this->display();
        } else {
            $this->display();
        }
    }
	public function baijiale()
    {
		session_start();
		

		//$platformCode=$_GET['game'];
		//$gameType=$_GET['gameType'];
		$username=$_SESSION['user']['username'];
		//var_dump($_SESSION['user']['username']);exit;
		$platformCode='AG';
		$gameType='13';
		//$username='test';
		if(!$username){
			echo "<script>alert('请先登录');history.go(-1)</script>";
			exit();
		}
		Vendor('ApiBi.Biapi', '' ,'.class.php');
		$api=new \Biapi();

		if($gameType){
			$url=$api->loginbi($platformCode,$username,$gameType);
		}else{
			$url=$api->loginbi($platformCode,$username);
		}
		
		$res=$api->balances('AG',$username);
		
		$this->assign("balance",$res);
		$this->assign('url', U('Home/Run/openurl').'?url='.urlencode($url));
		$this->display();
		//header('Location:'.U('Home/Run/openurl').'?url='.urlencode($url));
	}
	
	public function openurl()
    {
		$url=$_GET['url'];
		
		$is_weixin = is_weixin();
		if($is_weixin){
			$this->display();
		}else{
			header('Location:'.$url);
		}
		
		
	}

    public function k3()
    {
        if (C('is_open') == 0) {
            $this->redirect('error');
        }
        
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (! $auth) {
            echo "未授权或授权已过期";
            exit();
        }
        
        // 10期结果
        $list = M('number')->where("game='k3'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        
        // 创建SDK实例
        $script = &  load_wechat('Script');
        // 获取JsApi使用签名，通常这里只需要传 $ur l参数
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/Home/Run/index.html';
        $options = $script->getJsSign($url, $timestamp, $noncestr, $appid);
        
        // 判断赛车和飞艇的类型
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        
        $is_weixin = is_weixin();
        
        $this->assign('is_weixin', $is_weixin);
        $this->assign('kefu', $kefu);
        
        $this->assign('list', $list);
        $this->assign('type', $type);
        $this->assign('options', $options);
        $this->display();
    }

	/* 竞猜 六合彩 add by gison 20180504 */
    public function jincailhc()
    {
        // 聊天信息
        $list = M('message')->where("status=1 and game='lhc'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('list', $list);
        $this->display();
    }
	
    /* 竞猜 */
    public function jincaipk10()
    {
        // 聊天信息
        $list = M('message')->where("status=1 and game='pk10'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('list', $list);
        $this->display();
    }

	/* 竞猜 */
    public function jincaier75sc()
    {
        // 聊天信息
        $list = M('message')->where("status=1 and game='er75sc'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('list', $list);
        $this->display();
    }
	
    /* 竞猜 */
    public function jincaift()
    {
        // 聊天信息
        $list = M('message')->where("status=1 and game='xyft'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('list', $list);
        $this->display();
    }

    /* 竞猜 */
    public function jincaissc()
    {
        // 聊天信息
        $list = M('message')->where("status=1 and game='ssc'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('list', $list);
        $this->display();
    }

    /* 竞猜 */
    public function jincaibj28()
    {
        // 聊天信息
        $list = M('message')->where("status=1 and game='bj28'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('list', $list);
        $this->display();
    }

    /* 竞猜 */
    public function jincaijnd28()
    {
        // 聊天信息
        $list = M('message')->where("status=1 and game='jnd28'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('list', $list);
        $this->display();
    }

    public function jincaik3()
    {
        // 聊天信息
        $list = M('message')->where("status=1 and game='k3'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        $this->assign('list', $list);
        $this->display();
    }
    
	// 开盘记录 add by gison 20180503
    public function kjlhc()
    {
        // 20期结果
        $list = M('number')->where("game='lhc'")
            ->order("id DESC")
            ->limit(30)
            ->select();
        
        $this->assign('list', $list);
        $this->display();
    }
	
    // 开盘记录
    public function kjpk10()
    {
        // 20期结果
        $list = M('number')->where("game='pk10'")
            ->order("id DESC")
            ->limit(30)
            ->select();
        $this->assign('list', $list);
        $this->display();
    }
	
	// 开盘记录
    public function kjer75sc()
    {
        // 20期结果
        $list = M('number')->where("game='er75sc'")
            ->order("id DESC")
            ->limit(30)
            ->select();
        $this->assign('list', $list);
        $this->display();
    }
    
    // 开盘记录
    public function kjxyft()
    {
        // 20期结果
        $list = M('number')->where("game='xyft'")
            ->order("id DESC")
            ->limit(30)
            ->select();
        foreach ($list as $key => $value) {
            $number = substr($value['periodnumber'], 2);
            $list[$key]['periodnumber'] = $number;
        }
        $this->assign('list', $list);
        $this->display();
    }
    
    // 开盘记录
    public function kjssc()
    {
        // 20期结果
        $list = M('number')->where("game='ssc'")
            ->order("id DESC")
            ->limit(30)
            ->select();
        
        $this->assign('list', $list);
        $this->display();
    }
    
    // 开盘记录
    public function kjbj28()
    {
        // 20期结果
        $list = M('number')->where("game='bj28'")
            ->order("id DESC")
            ->limit(30)
            ->select();
        
        foreach ($list as $key => $value) {
            $current_number = $value;
            $number1 = explode(',', $current_number['awardnumbers']);
            
            $numberOne = $number1[0];
            $numberTwo = $number1[1];
            $numberThree = $number1[2];
			
            $tema_number = $numberOne + $numberTwo + $numberThree;
            $current_number[numberOne] = $numberOne;
            $current_number[numberTwo] = $numberTwo;
            $current_number[numberThree] = $numberThree;
            
            if ($tema_number <= 13) {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '小双';
                } else {
                    $current_number['zuhe'] = '小单';
                }
            } else {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '大双';
                } else {
                    $current_number['zuhe'] = '大单';
                }
            }
            if ($numberOne > $numberTwo) {
                $current_number['zx'] = '庄';
            } elseif ($numberOne == $numberTwo) {
                $current_number['zx'] = '和';
            } else {
                $current_number['zx'] = '闲';
            }
            $current_number['q3'] = bj28_qzh(array(
                $numberOne,
                $numberTwo,
                $numberThree
            ));
            
            if ($tema_number >= 0 && $tema_number <= 5) {
                $current_number['jdx'] = '极小';
            } else 
                if ($tema_number >= 22 && $tema_number <= 27) {
                    $current_number['jdx'] = '极大';
                } else {
                    $current_number['jdx'] = '';
                }
            $list[$key] = $current_number;
        }
        
        $this->assign('list', $list);
        $this->display();
    }
    
    // 开盘记录
    public function kjjnd28()
    {
        // 20期结果
        $list = M('number')->where("game='jnd28'")
            ->order("id DESC")
            ->limit(30)
            ->select();
        
        foreach ($list as $key => $value) {
            $current_number = $value;
            $number1 = explode(',', $current_number['awardnumbers']);
            
            $numberOne = $number1[0];
            $numberTwo = $number1[1];
            $numberThree = $number1[2];
			
            $tema_number = $numberOne + $numberTwo + $numberThree;
            $current_number[numberOne] = $numberOne;
            $current_number[numberTwo] = $numberTwo;
            $current_number[numberThree] = $numberThree;
            
            if ($tema_number <= 13) {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '小双';
                } else {
                    $current_number['zuhe'] = '小单';
                }
            } else {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '大双';
                } else {
                    $current_number['zuhe'] = '大单';
                }
            }
            if ($numberOne > $numberTwo) {
                $current_number['zx'] = '庄';
            } elseif ($numberOne == $numberTwo) {
                $current_number['zx'] = '和';
            } else {
                $current_number['zx'] = '闲';
            }
            $current_number['q3'] = bj28_qzh(array(
                $numberOne,
                $numberTwo,
                $numberThree
            ));
            if ($tema_number >= 0 && $tema_number <= 5) {
                $current_number['jdx'] = '极小';
            } else 
                if ($tema_number >= 22 && $tema_number <= 27) {
                    $current_number['jdx'] = '极大';
                } else {
                    $current_number['jdx'] = '';
                }
            $list[$key] = $current_number;
        }
        
        $this->assign('list', $list);
        $this->display();
    }

    public function kjk3()
    {
        // 20期结果
        $list = M('number')->where("game='jnd28'")
            ->order("id DESC")
            ->limit(30)
            ->select();
        
        foreach ($list as $key => $value) {
            $current_number = $value;
            $number1 = explode(',', $current_number['awardnumbers']);
            $tema_number = $number1[0] + $number1[1] + $number1[2];
            if ($tema_number <= 13) {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '小双';
                } else {
                    $current_number['zuhe'] = '小单';
                }
            } else {
                if ($tema_number % 2 == 0) {
                    $current_number['zuhe'] = '大双';
                } else {
                    $current_number['zuhe'] = '大单';
                }
            }
            
            if ($tema_number >= 0 && $tema_number <= 5) {
                $current_number['jdx'] = '极小';
            } else 
                if ($tema_number >= 22 && $tema_number <= 27) {
                    $current_number['jdx'] = '极大';
                } else {
                    $current_number['jdx'] = '';
                }
            $list[$key] = $current_number;
        }
        
        $this->assign('list', $list);
        $this->display();
    }

    /* cskh */
    public function kefu()
    {
        $kefu = M('config')->where('id=1')->order('id desc')->find();
        $this->assign('kefu', $kefu);
        $this->display();
    }
    
    // 推广二维码
    public function tui()
    {
        $uid = I('uid');
        $userinfo = M('user')->where("id={$uid}")->find();
        
        $this->assign('tui', $userinfo['qrcode']);
        $siteurl = $_SERVER['SERVER_NAME'];
        $url = 'http://' . $siteurl . '?t=' . $uid;
        $this->assign('url', $url);
        $this->display();
    }

    /* 记录 */
    public function record()
    {
        $t = I('t');
        
        $map = array();
        if ($t == 1) {
            $beginToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $endToday = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
        }
        if ($t == 2) {
            $beginToday = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
            $endToday = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
        }
        if ($t == 3) {
            $beginToday = mktime(0, 0, 0, date('m'), date('d') - 2, date('Y'));
            $endToday = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')) - 1;
        }
        if ($t == 4) {
            $beginToday = 0;
            $endToday = 0;
        }
        if ($beginToday and $endToday) {
            $map['time'] = array(
                array(
                    'egt',
                    $beginToday
                ),
                array(
                    'elt',
                    $endToday
                ),
                'and'
            );
        }
        $userinfo = session('user');
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		$map['time'] = array('egt',$today);
        $map['state'] = 1;
        $map['userid'] = $userinfo['id'];
        
        $order = M('order');
        $count = $order->where($map)->count();
        $points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")
            ->where($map)
            ->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
        $page = new \Think\Page($points_tj['count'], 6);
        $show = $page->show();
        $list = $order->field("*")
            ->where($map)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("id DESC")
            ->select();
        
        $number = array();
        for ($i = 0; $i < count($list); $i ++) {
            if (! in_array($list[$i]['number'], $number)) {
                $number[] = $list[$i]['number'];
            }
            for ($a = 0; $a < count($number); $a ++) {
                if ($list[$i]['number'] == $number[$a]) {
                    $list1[$a]['number'] = $number[$a];
                    $list1[$a]['game'] = $list[$i]['game'];
                    $list1[$a]['order'][] = $list[$i];
                }
            }
        }
        
        $pk10data = F('pk10data');
		$er75scdata = F('er75scdata');
        $xyftdata = F('xyftdata');
        $sscdata = F('sscdata');
        $bj28data = F('bj28data');
        $jnd28data = F('jnd28data');
        $k3data = F('k3data');
		$lhcdata = F('lhcdata');
        
        $this->assign('list1', $list1);
        $this->assign('state', F('state'));
        $this->assign('pk10number', $pk10data['next']['periodNumber']);
		$this->assign('er75scnumber', $er75scdata['next']['periodNumber']);
        $this->assign('xyftnumber', $xyftdata['next']['periodNumber']);
        $this->assign('sscnumber', $sscdata['next']['periodNumber']);
        $this->assign('bj28number', $bj28data['next']['periodNumber']);
        $this->assign('jnd28number', $jnd28data['next']['periodNumber']);
        $this->assign('k3number', $k3data['next']['periodNumber']);
		$this->assign('lhcdata', $lhcdata['next']['periodNumber']);
        $this->assign('list', $list);
        $this->assign('points_tj', $points_tj);
        $this->assign('show', $show);
        $this->assign('today', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
        $this->assign('t', $t);
        $this->display();
    }

	/* 规则 add by gison*/
    public function rulelhc()
    {
        if (C('index_page') == '1') {
            $this->display("rulelhc_1");
        } else {
            $this->display();
        }
    }
	
    /* 规则 */
    public function rulepk10()
    {
		if (C('index_page') == '1') {
            $this->display("rulepk10_1");
        } else {
            $this->display();
        }
    }

    /* 规则 */
    public function rulessc()
    {
        if (C('index_page') == '1') {
            $this->display("rulessc_1");
        } else {
            $this->display();
        }
    }

    /* 规则 */
    public function ruleft()
    {
        if (C('index_page') == '1') {
            $this->display("ruleft_1");
        } else {
            $this->display();
        }
    }

    /* 规则 */
    public function rulebj28()
    {
        if (C('index_page') == '1') {
            $this->display("rulebj28_1");
        } else {
            $this->display();
        }
    }

    /* 规则 */
    public function rulek3()
    {
        $this->display();
    }

    /* 规则 */
    public function rulejnd28()
    {
        if (C('index_page') == '1') {
            $this->display("rulejnd28_1");
        } else {
            $this->display();
        }
    }

    /* 查询分数 */
    public function check_points()
    {
        if (IS_POST) {
            if (IS_AJAX) {
                $id = I('id');
                if ($id) {
                    $userinfo = M('user')->where("id = $id")->find();
                    if ($userinfo) {
                        $userinfo['error'] = 0;
                    }
                }
                $this->ajaxReturn($userinfo);
            }
        }
    }
    
    // public function del_all(){
    // $state = F('state');
    // $userinfo = session('user');
    // $pkdata = F('pk10data');
    // if($state==1){
    // $number = I('number');
    // $list = M('order')->where("number = {$number} && userid = {$userinfo['id']}")->select();
    // for($i=0;$i<count($list);$i++){
    // if($list[$i]['number']==$pkdata['next']['periodNumber']){
    // $res[$i] = M('order')->where("id = {$list[$i]['id']}")->setField('state',0);
    // if($res[$i]){
    // M('user')->where("id = {$list[$i]['userid']}")->setInc('points',$list[$i]['del_points']);
    // }
    // }else{
    // $data['error']==0;
    // $data['msg']=='本期已封盘';
    // }
    // }
    // $data['error']==1;
    // }else{
    // $data['error']==0;
    // $data['msg']=='本期已封盘';
    // }
    // $this->ajaxReturn($data);
    // }
    public function del()
    {
		
		
        $id = I('id');
        $info = M('order')->where("id = $id")->find();
        if (! $info) {
            $data['error'] = 0;
            $data['msg'] = '未找到订单';
        } else {
			$game = $info['game'];
            $number = $info['number'];
			$awardnumbers = M('number')->where("periodnumber = '$number' and game = '$game'")->order('id desc')->find();
			
			$game_state = C($game.'_state');
			
			if ($awardnumbers['awardnumbers'] == '' && $game_state == '1') {
				$res = M('order')->where("id = $id")->setField('state', 0);
				if ($res) {
					$data['error'] = 0;
					// 加分
					M('user')->where("id = {$info['userid']}")->setInc('points', $info['del_points']);
				} else {
					$data['error'] = 1;
					$data['msg'] = '删除失败';
				}
			} else {
				$data['error'] = 1;
				$data['msg'] = '本期已封盘';
			}
        }
        $this->ajaxReturn($data);
        
        // $state = F('state');
        // $pkdata = F('pk10data');
        // if($state==1){
        // $id = I('id');
        // $info = M('order')->where("id = $id")->find();
        // if($info['number']==$pkdata['next']['periodNumber']){
        // $res = M('order')->where("id = $id")->setField('state',0);
        // if($res){
        // $data['error']==1;
        // //加分
        // M('user')->where("id = {$info['userid']}")->setInc('points',$info['del_points']);
        // }else{
        // $data['error']==0;
        // $data['msg']=='删除失败';
        // }
        // }else{
        // $data['error']==0;
        // $data['msg']=='本期已封盘';
        // }
        // }else{
        // $data['error']==0;
        // $data['msg']=='本期已封盘';
        // }
    }
	
	

    public function hd()
    {
        $id = I('id');
        $info = M('hd')->where("id = {$id}")->find();
        $this->assign("info", $info);
        $this->display();
    }

    public function kaijiang()
    {
        $type = I('type');
        // 20期结果
        $list = M('number')->where("game='{$type}'")
            ->order("id DESC")
            ->limit(20)
            ->select();
        
        $this->assign("list", $list);
        $this->display();
    }
	 public function fangjian($game)
	{
		$p3=rand(100,300);
		$p1=rand(100,300);
		$p2=rand(100,300);
		$kefu = M('config')->where('id=1')->order('id desc')->find();
		$this->assign('kefu',$kefu);
		$url='/home/run/'.$game;
		$this->assign('p1',$p1);
		$this->assign('p2',$p2);
		$this->assign('p3',$p3);
		$this->assign('url',$url);
		$this->display();
	}
	public function fangjian1($game)
	{
		$p3=rand(100,300);
		$p1=rand(100,300);
		$p2=rand(100,300);
		/*
		echo C('is_open_jnd28') ;
		echo '<br/>';
		echo time() ;
echo '<br/>';
echo 		strtotime(C('is_open_jnd28_begin_time'))-24*60*60 ;
echo '<br/>';
echo strtotime(C('is_open_jnd28_end_time'))+24*60*60;
		 
		die;
		*/
		$kefu = M('config')->where('id=1')->order('id desc')->find();
		$this->assign('kefu',$kefu);
		$url='/home/run/'.$game;
		$this->assign('p1',$p1);
		$this->assign('p2',$p2);
		$this->assign('p3',$p3);
		$this->assign('url',$url);
		$this->display();
	}
	public function fangjiancqssc($game)
	{
		$p3=rand(100,300);
		$p1=rand(100,300);
		$p2=rand(100,300);
		$kefu = M('config')->where('id=1')->order('id desc')->find();
		$this->assign('kefu',$kefu);
		$url='/home/run/'.$game;
		$this->assign('p1',$p1);
		$this->assign('p2',$p2);
		$this->assign('p3',$p3);
		$this->assign('url',$url);
		$this->display();
	}
	public function fangjianft($game)
	{
		$p3=rand(100,300);
		$p1=rand(100,300);
		$p2=rand(100,300);
		$kefu = M('config')->where('id=1')->order('id desc')->find();
		$this->assign('kefu',$kefu);
		$url='/home/run/'.$game;
		$this->assign('p1',$p1);
		$this->assign('p2',$p2);
		$this->assign('p3',$p3);
		$this->assign('url',$url);
		$this->display();
	}
	public function fangjianlh($game)
	{
		$p3=rand(100,300);
		$p1=rand(100,300);
		$p2=rand(100,300);
		$kefu = M('config')->where('id=1')->order('id desc')->find();
		$this->assign('kefu',$kefu);
		$url='/home/run/'.$game;
		$this->assign('p1',$p1);
		$this->assign('p2',$p2);
		$this->assign('p3',$p3);
		$this->assign('url',$url);
		$this->display();
	}
	public function fangjianpk10($game)
	{
		$p3=rand(100,300);
		$p1=rand(200,1000);
		$p2=rand(200,800);
		$kefu = M('config')->where('id=1')->order('id desc')->find();
		$this->assign('kefu',$kefu);
		$url='/home/run/'.$game;
		$this->assign('p1',$p1);
		$this->assign('p2',$p2);
		$this->assign('p3',$p3);
		$this->assign('url',$url);
		$this->display();
	}
	public function fangjianxjp28($game)
	{
		$p3=rand(100,300);
		$p1=rand(200,1000);
		$p2=rand(200,800);
		$kefu = M('config')->where('id=1')->order('id desc')->find();
		$this->assign('kefu',$kefu);
		$url='/home/run/'.$game;
		$this->assign('p1',$p1);
		$this->assign('p2',$p2);
		$this->assign('p3',$p3);
		$this->assign('url',$url);
		$this->display();
	}
	
	
	public function checkuser(){
		$userinfo = session('user');
		$userid=$userinfo['id'];
		$res=M('user')->field('points')->where(array('id'=>$userid))->find();
		echo $res['points'];	
	}
	
	
	/* 余额宝记录 */
    public function treasure()
    {
        $t = I('t');
        
        $map = array();
		/*
        if ($t == 1) {
            $beginToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            $endToday = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
        }
        if ($t == 2) {
            $beginToday = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
            $endToday = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
        }
        if ($t == 3) {
            $beginToday = mktime(0, 0, 0, date('m'), date('d') - 2, date('Y'));
            $endToday = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')) - 1;
        }
        if ($t == 4) {
            $beginToday = 0;
            $endToday = 0;
        }
        if ($beginToday and $endToday) {
            $map['time'] = array(
                array(
                    'egt',
                    $beginToday
                ),
                array(
                    'elt',
                    $endToday
                ),
                'and'
            );
        }
		*/
        $userinfo = session('user');
		$userinfo = M('user')->where("id = {$userinfo['id']}")->find();
		
		$today=strtotime(date('Y-m-d 00:00:00'));//当天		
		//$map['time'] = array('egt',$today);
        //$map['state'] = 1;
        $map['userid'] = $userinfo['id'];
		
		//$map['types'] = "利息";
        
        $treasure = M('treasure');
        $count = $treasure->where($map)->count();
        $treasure_tj = $treasure->field("count(id) as count,sum(moneys) as sum_moneys ")
            ->where($map)
            ->find();
		
		$map2['userid'] = $userinfo['id'];
		//$map2['status'] = "未领取";
		//$map2['types'] = "利息";
		
		
		$treasure_notget = $treasure->field("count(id) as count,sum(moneys) as sum_moneys ")
            ->where($map2)
            ->find();
			
		
		//var_dump($map);
		/*
		echo 'wweewwwwwwwwwwwwwwsdfadsfsadfasdfasdfdsafff';
		echo $treasure->getlastsql();
		echo '<br/>';
		*/
		
        $treasure_tj['ying'] = $treasure_tj['sum_moneys'];// - $treasure_tj['sum_del'];
        $page = new \Think\Page($treasure_tj['count'], 15);
        $show = $page->show();
        $list = $treasure->field("*")
            ->where($map)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order("id DESC")
            ->select();
			
		//echo $treasure->getlastsql();
		//echo '<br/>';
		
        /*
        $number = array();
        for ($i = 0; $i < count($list); $i ++) {
            if (! in_array($list[$i]['number'], $number)) {
                $number[] = $list[$i]['number'];
            }
            for ($a = 0; $a < count($number); $a ++) {
                if ($list[$i]['number'] == $number[$a]) {
                    $list1[$a]['number'] = $number[$a];
                    $list1[$a]['game'] = $list[$i]['game'];
                    $list1[$a]['order'][] = $list[$i];
                }
            }
        }
		*/
        
      
        $this->assign('userinfo', $userinfo);
        $this->assign('list', $list);
        $this->assign('treasure_tj', $treasure_tj);
		$this->assign('treasure_notget', $treasure_notget);
		
        $this->assign('show', $show);
        $this->assign('today', mktime(0, 0, 0, date('m'), date('d'), date('Y')));
        //$this->assign('t', $t);
        $this->display();
    }
	
	
	/* 余额宝记录 */
    public function inputtreasure()
    {
        $type = I('type');
		
		//$user = session('user');
		//$userinfo = M('user')->where("id = {$user['id']}")->find();
        
		
		$this->assign('pay',$pay);
		$this->display();
		
	}
	
	public function addtreasure(){
		 
		$id = I('id');
		$money = I('moneys');
		$userinfo = M('user')->where("id={$id}")->find();
		
		if($userinfo['points']  -  $money  < 0 ){
			$this->error('转入失败,金额不够');
			return;
		}
		
		$add = array(
			'userid' => $id,
			'moneys' => $money,
			'times' => time(),
			
			'types' => '转入',
			'status' => '转入',
			'treasure_rates'=> 0 ,
			'treasure_capital'=> $money,
			'details'=>'转入'.$money.'元',
			 
		);
		$res = M('treasure')->add($add);
		
		$userinfo = M('user')->where("id={$id}")->find();
		$userinfo_treasure_capital = $userinfo['treasure_capital']  + $money ;
		$userinfo_points = $userinfo['points']  -  $money ;
		
		//更新用户信息
		$res2 = M('user')->where("id={$id}")->save(array("treasure_capital"=>$userinfo_treasure_capital,"points"=>$userinfo_points));
		
		
		if ($res) {
			$message  = array(
				'time'=>date('H:i:s'),
				'type' => 1,
				'content'=>"转入成功"
			);
			$res = $this->send($message);
			$this->success('转入成功,跳转中~',U('Home/User/index'),1);
		} else {
			$this->error('转入失败');
			
			/*
			$message  = array(
					'time'=>date('H:i:s'),
					'type' => 1,
					'content'=>"转入失败"
				);
				
				$res3 = $this->send($message);
				*/
		}
	}
	
	 public function outputTreasure()
    {
        $type = I('type');
		
		//$user = session('user');
		//$userinfo = M('user')->where("id = {$user['id']}")->find();
        
		
		$this->assign('pay',$pay);
		$this->display();
	}
	
	
	public function subtreasure(){
		$id = I('id');
		$money = I('moneys');
		$userinfo = M('user')->where("id={$id}")->find();
		
		
		if($userinfo['treasure_capital']  -  $money  < 0 ){
			$this->error('转出失败,金额不够');
			return;
		}
		
		$add = array(
			'userid' => $id,
			'moneys' => $money,
			'times' => time(),
			
			'types' => '转出',
			'status' => '转出',
			'treasure_rates'=> 0 ,
			'treasure_capital'=> $money,
			'details'=>'转出'.$money.'元',
			 
		);
		$res = M('treasure')->add($add);
		
		$userinfo = M('user')->where("id={$id}")->find();
		$userinfo_treasure_capital = $userinfo['treasure_capital']  - $money ;
		$userinfo_points = $userinfo['points']  +  $money ;
		
		//更新用户信息
		$res2 = M('user')->where("id={$id}")->save(array("treasure_capital"=>$userinfo_treasure_capital,"points"=>$userinfo_points));
		
		
		if ($res) {
			$message  = array(
				'time'=>date('H:i:s'),
				'type' => 1,
				'content'=>"转出成功"
			);
			$res = $this->send($message);
			$this->success('转出成功,跳转中~',U('Home/User/index'),1);
		} else {
			$this->error('转出失败');
			
			/*
			$message  = array(
					'time'=>date('H:i:s'),
					'type' => 1,
					'content'=>"提取失败"
				);
				
				$res3 = $this->send($message);
				*/
				
		}
	}
	
	public function getTreasure()
    {
		$user = session('user');
		
		$id = $user['id'];
		$userinfo = M('user')->where("id = {$id}")->find();
		
		
		
		$map2['userid'] = $userinfo['id'];
		$map2['status'] = "未领取";
		$map2['types'] = "利息";
		
		$treasure = M('treasure');
		$treasure_notget = $treasure->field("count(id) as count,sum(moneys) as sum_moneys ")
            ->where($map2)
            ->find();
			
		if( isset($treasure_notget) && !empty($treasure_notget) ){
			
			$sum_moneys  =  $treasure_notget['sum_moneys'] ;
			
			
			//$userinfo = M('user')->where("id={$id}")->find();
			$userinfo_treasure_capital = $userinfo['treasure_capital']  + $sum_moneys ;
			$treasure_rates = $userinfo['treasure_rates']  +  $sum_moneys ;
			
			//更新用户余额宝收益
			$res = $treasure->where($map2)->save( array("status"=>"已领取") );
			
			//更新用户信息
			$res2 = M('user')->where("id={$id}")->save(array("treasure_rates"=>$treasure_rates,"treasure_capital"=>$userinfo_treasure_capital));
			
			if ($res2) {
				$message  = array(
					'time'=>date('H:i:s'),
					'type' => 1,
					'content'=>"提取成功"
				);
				$res3 = $this->send($message);
				$this->success('提取成功,跳转中~',U('Home/user/index'),1);
			} else {
				
				 
				$message  = array(
					'time'=>date('H:i:s'),
					'type' => 1,
					'content'=>"提取失败"
				);
				
				$res3 = $this->send($message);
				 
			 $this->display();
				 
			}
			
		}else{
		 
				$message  = array(
					'time'=>date('H:i:s'),
					'type' => 1,
					'content'=>"提取失败"
				);
				
				$res3 = $this->send($message);
				$this->display();
			
		}
        
		
	}
	
	
	protected function send($content){
		// 指明给谁推送，为空表示向所有在线用户推送
		$to_uid = "";
		// 推送的url地址，上线时改成自己的服务器地址
		$push_api_url = "http://localhost:12225/";
		$post_data = array(
		   "type" => "publish",
		   "content" => json_encode($content),
		   "to" => $to_uid, 
		);
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $push_api_url );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
		curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Expect:"));
		$return = curl_exec ( $ch );
		curl_close ( $ch );
		return $return;
	}
	
	
	
}

?>