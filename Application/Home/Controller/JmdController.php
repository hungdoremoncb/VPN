<?php
namespace Home\Controller;
use Think\Controller;
header('content-type:text/html;charset=utf-8');
class IndexController extends BaseController {

	
    public function index(){
    	if(C('is_open')==0){
    		$this->redirect('error');
    	}

    	$auth = auth_check(C('auth_code'),$_SERVER['HTTP_HOST']);
		if (!$auth) {
			echo "未授权或授权已过期";exit;
		}

    	$t_id = I('t');
		session('tid',$t_id);

		if (C('is_baidu')) {
			$this->display("baidu");
		} else {
			if (C('is_weixin') == '1' && is_weixin()) {
	    		$oauth = load_wechat('Oauth');
	    		if (C('mp_choose') == '1') {
	    			$host_url =  'http://'.C('siteurl').'/Home/Index/redirect_url';
		    		$redirect_uri = 'http://'.C('mp_host_url').'/Home/Index/auth_cb?host_url='.urlencode($host_url);
	    		} else {
	    			$redirect_uri =  'http://'.C('siteurl').'/Home/Index/redirect_url';
	    		}
	    		$result_index = $oauth->getOauthRedirect($redirect_uri, $state, 'snsapi_userinfo');
				
				header("location:" . $result_index);
	    	} else {
	    		$result_index = 'http://'.C('siteurl').'/Home/Run/index';
	    		header("location:" . $result_index);
	    	}
		}
	}

	public function auth_cb()
	{
		$oauth = load_wechat('Oauth');
		$result = session('result');
		if (!$result) {
			$result = $oauth->getOauthAccessToken();
			session('result',$result);
		}

		// $result['openid'] = "ospyFwRJLb2tMQeb5HxCzRsmAoks";
		//判断是否第一次登陆
		$wx = M('wx');
		$user = M('user');
		$res = $wx->where("openid = '{$result['openid']}'")->find();
		if($res){
			//是否过期
			if($res['expires_in']<time()){
				$wx->where("openid = '{$result['openid']}'")->setField('access_token',$result['access_token']);
			}
			//查找会员数据
			$info = $user->where("id = {$res['userid']}")->find();
			
			//是否禁用
			if($info['status']==0){
				$this->redirect('error');
			}
			
			//更新推广二维码
			$siteurl = $_SERVER['SERVER_NAME'];
			$url = 'http://'.$siteurl.'?t='.$info['id'];
			$img = qrcode($url);
			$user->where("id = {$res['userid']}")->setField('qrcode','/'.$img);

			$info['qrcode'] = '/'.$img;
			session('user',$info);
			
			$this->redirect('Home/Run/index');
		}else{
			if(C('is_open_reg')==0){
	    		$this->redirect('error');
	    	}
			$userinfo = session('userinfo');
    		if (!$userinfo) {
				$userinfo = $oauth->getOauthUserinfo($result['access_token'], $result['openid']);
				session('userinfo',$userinfo);
			}
			
			//是否推荐
			$t_id = session('tid');
			if($t_id){
				$data['t_id'] = $t_id;
			}
			//自动注册
			$data['nickname'] = $userinfo['nickname'];
			$headimgurl = substr($userinfo['headimgurl'], 0,-2);
			$data['headimgurl'] = $userinfo['headimgurl'];
			$data['country'] = $userinfo['country'];
			$data['province'] = $userinfo['province'];
			$data['sex'] = $userinfo['sex'];
			$data['user_agent'] = serialize(get__browser());
			$data['city'] = $userinfo['city'];
			$data['reg_ip'] = get_client_ip();
			$data['last_ip'] = get_client_ip();
			$data['reg_time'] = time();
			$data['last_time'] = time();
			$data['logins'] = 1;

			//绑定tên tài khoản
			$username = mt_rand(100000,999999);
			$user_find = M('user')->where("username={$username}")->find();
			if ($user_find) {
				$username = mt_rand(100000,999999);
			}
			$data['username'] = $username;

			$userid = $user->add($data);
			if($userid){
				//推荐码（二维码 ）
				$siteurl = $_SERVER['SERVER_NAME'];
				$url = 'http://'.$siteurl.'?t='.$userid;
				$img = qrcode($url);
				$user->where("id = $userid")->setField('qrcode','/'.$img);
				
				$data1['userid'] = $userid;
				$data1['openid'] = $result['openid'];
				$data1['access_token'] = $result['access_token'];
				$data1['expires_in'] = time()+$result['expires_in'];
				$res2 = $wx->add($data1);
				if($res2){
					$data['id'] = $userid;
					$data['qrcode'] = '/'.$img;
					session('user',$data);
					$this->redirect('Home/Run/index');
				}
			}
		}
		
	}
	//百度一下搜索
	public function baidu(){
		$value = I('baidu_value');
		if (C('baidu_value') != $value) {
			$url = 'https://www.baidu.com/s?wd='.$value;
    		header("location:" . $url);exit;
		} else {
			if (C('is_weixin') == '1' && is_weixin()) {
	    		$oauth = load_wechat('Oauth');
	    		if (C('mp_choose') == '1') {
	    			$host_url =  'http://'.C('siteurl').'/Home/Index/redirect_url';
		    		$redirect_uri = 'http://'.C('mp_host_url').'/Home/Index/auth_cb?host_url='.urlencode($host_url);
	    		} else {
	    			$redirect_uri =  'http://'.C('siteurl').'/Home/Index/redirect_url';
	    		}
				$result_index = $oauth->getOauthRedirect($redirect_uri, $state, 'snsapi_userinfo');
				header("location:" . $result_index);
	    	} else {
	    		$result_index = 'http://'.C('siteurl').'/Home/Run/index';
	    		header("location:" . $result_index);
	    	}
		}
	}

	//登录
	public function login()
	{
		if(IS_POST){
			if(!IS_AJAX){
				$this->success('提交方式不正确！');
			}else{
				$username = I('username');
				$password = md5(I('password'));
				$res = M('user')->where("username = '{$username}'  && password = '{$password}'")->find();
				if($res){
					session('user',$res);
					$map['last_ip'] = get_client_ip();
					$map['last_time'] = time();
					M('user')->where("id = {$res['id']}")->save($map);

					//是否禁用
					if($res['status']==0){
						$this->redirect('error');
					}
					
					//更新推广二维码
					$siteurl = $_SERVER['SERVER_NAME'];
					$url = 'http://'.$siteurl.'?t='.$res['id'];
					$img = qrcode($url);
					M('user')->where("id = {$res['id']}")->setField('qrcode','/'.$img);
					$this->success('登录成功,跳转中~',U('/Home/Run/index'),1);
				}else{
					$this->error('tên tài khoản或密码错误');
				}
			}
		} else {
			$this->display();
		}
	}

	//注册
	public function register(){
		if(IS_POST){
			if(!IS_AJAX){
				$this->error('提交方式不正确！');
			}else{
				$username = trim(I('username'));
				if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $username)>0){
					$this->error('不支持中文tên tài khoản');
				}else if(strlen($username) < 5 || strlen($username) > 16){
					$this->error('tên tài khoản必须5-16个字符');
				}else{
					$password = md5(I('password'));
					$res = M('user')->where("username = '{$username}'")->find();

					if(!$res){
						$reg_data = array(
							'nickname' => $username,
							'username' => $username,
							'password' => $password,
							'headimgurl' => I('headimgurl'),
							'reg_time' => time(),
							'reg_ip' => get_client_ip(),
						);
						//是否推荐
						$t_id = session('tid');
						if($t_id){
							$reg_data['t_id'] = $t_id;
						}
						$reg_id = M('user')->add($reg_data);
						if ($reg_id) {
							//更新推广二维码
							$siteurl = $_SERVER['SERVER_NAME'];
							$url = 'http://'.$siteurl.'?t='.$reg_id;
							$img = qrcode($url);
							M('user')->where("id = $reg_id")->setField('qrcode','/'.$img);

							$user = M('user')->where("id={$reg_id}")->find();
							session('user',$user);

							$this->success('注册成功,跳转中~',U('/Home/Run/index'),1);
						} else {
							$this->error('注册失败，请重试');
						}
						
					}else{
						$this->error('tên tài khoản已存在，请重新输入');
					}
				}
			}
		} else {
			$this->display();
		}

	}

	//退出
	public function logout(){
		session(null);
		$this->redirect('/Home/Run/index');
	}
	
	public function redirect_url(){
		$oauth = load_wechat('Oauth');
		$result = session('result');
		if (!$result) {
			$result = $oauth->getOauthAccessToken();
			session('result',$result);
		}

		// $result['openid'] = "ospyFwRJLb2tMQeb5HxCzRsmAoks";
		//判断是否第一次登陆
		$wx = M('wx');
		$user = M('user');
		$res = $wx->where("openid = '{$result['openid']}'")->find();
		if($res){
			//是否过期
			if($res['expires_in']<time()){
				$wx->where("openid = '{$result['openid']}'")->setField('access_token',$result['access_token']);
			}
			//查找会员数据
			$info = $user->where("id = {$res['userid']}")->find();
			
			//是否禁用
			if($info['status']==0){
				$this->redirect('error');
			}
			
			//更新推广二维码
			$siteurl = $_SERVER['SERVER_NAME'];
			$url = 'http://'.$siteurl.'?t='.$info['id'];
			$img = qrcode($url);
			$user->where("id = {$res['userid']}")->setField('qrcode','/'.$img);

			$info['qrcode'] = '/'.$img;
			session('user',$info);
			
			$this->redirect('Home/Run/index');
		}else{
			if(C('is_open_reg')==0){
	    		$this->redirect('error');
	    	}
			$userinfo = session('userinfo');
    		if (!$userinfo) {
				$userinfo = $oauth->getOauthUserinfo($result['access_token'], $result['openid']);
				session('userinfo',$userinfo);
			}
			
			//是否推荐
			$t_id = session('tid');
			if($t_id){
				$data['t_id'] = $t_id;
			}
			//自动注册
			$data['nickname'] = $userinfo['nickname'];
			$headimgurl = substr($userinfo['headimgurl'], 0,-2);
			$data['headimgurl'] = $headimgurl.'/46';
			$data['country'] = $userinfo['country'];
			$data['province'] = $userinfo['province'];
			$data['sex'] = $userinfo['sex'];
			$data['user_agent'] = serialize(get__browser());
			$data['city'] = $userinfo['city'];
			$data['reg_ip'] = get_client_ip();
			$data['last_ip'] = get_client_ip();
			$data['reg_time'] = time();
			$data['last_time'] = time();
			$data['logins'] = 1;

			//绑定tên tài khoản
			$username = mt_rand(100000,999999);
			$user_find = M('user')->where("username={$username}")->find();
			if ($user_find) {
				$username = mt_rand(100000,999999);
			}
			$data['username'] = $username;

			$userid = $user->add($data);
			if($userid){
				//推荐码（二维码 ）
				$siteurl = $_SERVER['SERVER_NAME'];
				$url = 'http://'.$siteurl.'?t='.$userid;
				$img = qrcode($url);
				$user->where("id = $userid")->setField('qrcode','/'.$img);
				
				$data1['userid'] = $userid;
				$data1['openid'] = $result['openid'];
				$data1['access_token'] = $result['access_token'];
				$data1['expires_in'] = time()+$result['expires_in'];
				$res2 = $wx->add($data1);
				if($res2){
					$data['id'] = $userid;
					$data['qrcode'] = '/'.$img;
					session('user',$data);
					$this->redirect('Home/Run/index');
				}
			}
		}
	}	
	
	public function bind()
	{
		$id = I('id');
		$user = M('user')->where("id={$id}")->find();
		if (!$user['username']) {
			$username = mt_rand(100000,999999);
			$user_find = M('user')->where("username={$username}")->find();
			if ($user_find) {
				$username = mt_rand(100000,999999);
			}
			$user['username'] = $username;
		}

		$this->assign("user",$user);
		$this->display();

	}

	public function bind_action(){
		$data = I();
		$data['password'] = md5(I('password'));
		$res = M('user')->where("id={$data['id']}")->save($data);
		if ($res) {
			$this->success("绑定成功");
		} else {
			$this->error("绑定失败");
		}
	}
}
