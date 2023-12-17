<?php

namespace Home\Controller;

use Think\Controller;
use Think\Db;
use Think\Page;

class UserController extends BaseController
{

    public function api_jnd()
    {

        // 今日盈亏
        $user = session('user');
        $today = strtotime('today');
        $where = "userid={$user['id']} and state=1 and time > {$today}";
        $r = M('order')->field('sum(add_points) - sum(del_points) as total')->where($where)->find();
        $out['jryk'] = $r['total'];

        // 今日交易量
        $r = M('order')->field('SUM(ABS(add_points-del_points)) as total')->where("state=1 and time>{$today}")->find();
        $out['jrjyl'] = $r['total'];

        // 昨日交易量
        $yestoday = strtotime('-1 day', $today);
        $r = M('order')->field('SUM(ABS(add_points-del_points)) as total')->where("state=1 and time between {$yestoday} and {$today}")->find();
        $out['zrjyl'] = $r['total'];


        header('Content-Type:application/json;charset=utf-8');
        echo json_encode($out, 1);
        die;
    }

    //会员中心Home
    public function index()
    {
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (!$auth) {
            echo "未授权或授权已过期";
            exit;
        }

        $userid = session('user');

        $userinfo = M('user')->where("id = {$userid['id']}")->find();

        //下线总数
        $userinfo['t_account'] = M('user')->where("t_id = {$userid['id']}")->count() ?: 0;

        //今日盈亏
        $map = array();
        $beginToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $endToday = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;

        $map['time'] = array(array('egt', $beginToday), array('elt', $endToday), 'and');
        $map['state'] = 1;
        $map['userid'] = $userid['id'];

        // $yinkui = M('order')->field("sum(add_points) as sum_add,sum(del_points) as sum_del")->where($map)->find();
        $userinfo['ying'] = $yinkui['sum_add'] - $yinkui['sum_del'];

        // 改上面的沙雕盈亏
        $today = strtotime('today');
        $where = "userid={$userid['id']} and state=1 and time > {$today}";
        $r = M('order')->field('sum(add_points) - sum(del_points) as total')->where($where)->find();
        $userinfo['ying'] = $r['total'];


        //今日推广佣金
        $map_y['time'] = array(array('egt', $beginToday), array('elt', $endToday), 'and');
        $map_y['t_uid'] = $userid['id'];
        $yong = M('push_money')->where($map_y)->field("sum(money) as money")->find();

        $userinfo['yong_today'] = $yong['money'] ?: 0;
        $kefu = M('config')->where("id = 1")->find();

        $this->assign('kefu', $kefu);

        $is_weixin = is_weixin();
        $this->assign('is_weixin', $is_weixin);

        $this->assign("user", $userinfo);
        if (I('userid')) {
            $win_rate = C('win_rate') ;
            $fenadd = M('integral')->field('sum(points) as p,sum(send_balance) as sb,sum(hidden_balance) as hb')->where(['uid'=>$userinfo['id']])->find();
            $fenadd2 = M('fenadd')->field("sum(money) as sm,sum(send_balance) as sb")->where(['uid'=>$userinfo['id']])->find();
            $all_in = $fenadd2['sm'];
            //var_dump($all_in);
            $all_flow = $fenadd['p'] + $fenadd['sb'] + $fenadd['hb'] - abs($userinfo['edit_integral']);
            $else_amount = $all_flow-($all_in *($win_rate +1)) >= $userinfo['points'] ? $userinfo['points'] :  $all_flow-($all_in *($win_rate +1));
            $else_amount = $else_amount > 0 ? $else_amount : 0 ;
            //ar_dump($else_amount);exit;
            $userinfo['can_draw'] = $else_amount; $
            $data = [
                'kefu' => $kefu,
                'is_weixin' => $is_weixin,
                'user' => $userinfo,
            ];

            echo json_encode(['status' => 1, 'info' => '成功', 'data' => $data]);
            exit;
        }
        $this->display();
    }

    public function chu()
    {
        if (IS_POST) {

            $userid = session('user');
            $data = $_POST;
            $rumoney = $data['rumoney'];
            $typeid = $data['typeid'];
            $userid = session('user');
            $userinfo = M('user')->where("id = {$userid['id']}")->find();
            $user_yuetype = M('user_yuetype')->where("id = {$typeid}")->find();
            $map = [
                'money' => $rumoney,
                'status' => 1,
                'user_id' => $userid['id'],
                'type_id' => $typeid,
            ];
            $user_yuebao = M('user_yuebao')->where($map)->find();

            if (!$user_yuetype || $user_yuetype['status'] != 1) {
                $this->error('所选标准有误');
            }
            if (!$user_yuebao) {
                $this->error('未找到相关记录');
            }


            Db::startTrans();
            $moneys = M('user_yuebao')->where("id = {$user_yuebao['id']}")->find();
            if ($moneys['status'] == 1) {
                $res1 = M('user')->where("id = {$userid['id']}")->setInc('points', $rumoney);
                $res2 = M('user')->where("id = {$userid['id']}")->setDec('yuebao', $rumoney);
                $res3 = M('user_yuebao')->where("id = {$user_yuebao['id']}")->save(['status' => 3]);
                if ($res1 && $res2 && $res3) {
                    Db::commit();
                    $this->success('转让成功等待审核');
                } else {
                    Db::rollback();
                    $this->success('网络异常，请重试');
                }
            } else {
                Db::rollback();
                $this->success('此笔收益已处理无法操作');
            }


        }

    }

    public function ru()
    {
        if (IS_POST) {

            $userid = session('user');
            $data = $_POST;
            $rumoney = $data['rumoney'];
            $typeid = $data['typeid'];
            $userid = session('user');
            $userinfo = M('user')->where("id = {$userid['id']}")->find();
            $user_yuetype = M('user_yuetype')->where("id = {$typeid}")->find();
            if (!$user_yuetype || $user_yuetype['status'] != 1) {
                $this->error('所选标准有误');
            }
            if ($rumoney > $user_yuetype['max'] || $rumoney < $user_yuetype['min']) {
                $this->error('金额区间需为' . $user_yuetype['min'] . '~' . $user_yuetype['max']);
            }
            if ($rumoney > $userinfo['points']) {
                $this->error('金额超过总金额');
            }

            $days = $user_yuetype['day'];    // 天数
            $fee = round($days * $rumoney * ($user_yuetype['rate'] / 100) * (1 - $user_yuetype['fee'] / 100), 2);

            $rsy = round($fee / $days, 2);
            // $rsy = $rumoney * ($user_yuetype['rate'] / 100) - ($user_yuetype['fee']/100)

            $today = time();
            $insert = [
                'user_id' => $userid['id'],
                'money' => $rumoney,
                'type_id' => $typeid,
                'created_at' => $today,
                'time' => $today + $days * 86400,
                'fee' => $fee,
                'yjfee' => $data['fee'],
                'rsy' => $rsy,
                'days' => $days,
                'name' => $userinfo['username']
            ];
            Db::startTrans();
            $res = M('user_yuebao')->add($insert);
            if ($res) {
                $res1 = M('user')->where("id = {$userid['id']}")->setDec('points', $rumoney);
                $res2 = M('user')->where("id = {$userid['id']}")->setInc('yuebao', $rumoney);

            }
            if ($res1 && $res2) {
                Db::commit();
                $this->success('转让成功等待审核');
            } else {
                Db::rollback();
                $this->success('网络异常，请重试');
            }


        }

    }

    //余额宝
    public function yuebao()
    {
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (!$auth) {
            echo "未授权或授权已过期";
            exit;
        }
        $userid = session('user');
        $userinfo = M('user')->where("id = {$userid['id']}")->find();

        $user_yuetype = M('user_yuetype')->where("status = 1")->select();


        $userinfo['total'] = $userinfo['points'] + $userinfo['yuebao'];

        // 昨日收益
        $today = strtotime('today');
        $yestoday = strtotime('-1 day', $today);
        // 创建时间<今天0点， (过期时间无所谓，至少一天), 合计日收益
        $r = M('user_yuebao')
            ->field("sum(rsy) as total")
            ->where("status <> 3 and user_id={$userid['id']} and `created_at`< {$today}")
            ->find();

        $this->assign('zrsy', $r['total'] ? $r['total'] : '0.00');


        $this->assign('list', $user_yuetype);

        $this->assign("user", $userinfo);
        $this->display();
    }

    //余额宝
    public function yeblist()
    {
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (!$auth) {
            echo "未授权或授权已过期";
            exit;
        }
        $userid = session('user');


        $lists = M('user_yuebao')->where("user_id={$userid['id']}")->select();
        $this->assign('list', $lists);

        $this->assign("user", $userinfo);
        $this->display();
    }

    // 手动转出
    public function yeb_zc()
    {
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (!$auth) {
            echo "未授权或授权已过期";
            exit;
        }

        if (IS_POST) {
            $id = intval($_POST['id']);
            $r = M('user_yuebao')->where("id = {$id}")->find();
            if (!$r) {
                die('error');
            }

            $userid = session('user');
            if ($r['user_id'] != $userid['id']) {
                die('无权限');
            }
            if ($r['status'] != 1) {
                die("已转出");
            }

            $rumoney = $r['money'];

            Db::startTrans();

            if ($r['status'] == 1) {
                $res1 = M('user')->where("id = {$userid['id']}")->setInc('points', $rumoney);
                $res2 = M('user')->where("id = {$userid['id']}")->setDec('yuebao', $rumoney);
                $res3 = M('user_yuebao')->where("id = {$id}")->save(['status' => 3]);
                if ($res1 && $res2 && $res3) {
                    Db::commit();
                    die('OK');
                } else {
                    Db::rollback();
                    die('网络异常，请重试');
                }
            } else {
                Db::rollback();
                die('此笔收益已处理无法操作');
            }
        }
    }

    public function yeblist1()
    {

        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (!$auth) {
            echo "未授权或授权已过期";
            exit;
        }

        $userid = session('user');
        $lists = M('user_yuebao')
            ->where("user_id={$userid['id']}")
            ->select();
        var_dump($lists);
    }

    //走势
    public function zs1()
    {
        $auth = auth_check(C('auth_code'), $_SERVER['HTTP_HOST']);
        if (!$auth) {
            echo "未授权或授权已过期";
            exit;
        }

        $userid = session('user');
        $userinfo = M('user')->where("id = {$userid['id']}")->find();
        //下线总数
        $userinfo['t_account'] = M('user')->where("t_id = {$userid['id']}")->count() ?: 0;
        //今日盈亏
        $map = array();
        $beginToday = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $endToday = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;

        $map['time'] = array(array('egt', $beginToday), array('elt', $endToday), 'and');
        $map['state'] = 1;
        $map['userid'] = $userid['id'];

        $yinkui = M('order')->field("sum(add_points) as sum_add,sum(del_points) as sum_del")->where($map)->find();
        $userinfo['ying'] = $yinkui['sum_add'] - $yinkui['sum_del'];

        //今日推广佣金
        $map_y['time'] = array(array('egt', $beginToday), array('elt', $endToday), 'and');
        $map_y['t_uid'] = $userid['id'];
        $yong = M('push_money')->where($map_y)->field("sum(money) as money")->find();

        $userinfo['yong_today'] = $yong['money'] ?: 0;
        $kefu = M('config')->where("id = 1")->find();
        $this->assign('kefu', $kefu);

        $is_weixin = is_weixin();
        $this->assign('is_weixin', $is_weixin);

        $this->assign("user", $userinfo);
        $this->display();
    }


    public function info()
    {
        // $time_offset=8*3600;
        $beginOfDay = strtotime("today");
        $endOfDay   = strtotime("tomorrow") - 1;
        // $beginOfDay -= $time_offset;
        // $endOfDay -= $time_offset;
        $userid = session('user');
        $userinfo = M('user')->where('id=' . $userid['id'])->find();
        unset($userinfo['user_agent']);
        $win_rate = C('win_rate') ;
        $fenadd2 = M('fenadd')->field("sum(money) as sm,sum(send_balance) as sb")->where(['uid'=>$userinfo['id']])->find();
        $all_in = $fenadd2['sm'] + $fenadd2['sb'];
        $sum_order = M('Order')->field('sum(del_points) as p, sum(add_points) as b')->where(['userid'=>$userinfo['id']])->find();

        $map = array();
        $map['time'] = array(array('egt', $beginOfDay), array('elt', $endOfDay), 'and');
        $map['userid'] = $userinfo['id'];
        $sum_today = M('Order')->field('sum(del_points) as p, sum(add_points) as b')->where($map)->find();
        $userinfo['invest_today'] = $sum_today['p']==null?0:$sum_today['p'];
        $userinfo['profit_today'] = $sum_today['b']==null?0:$sum_today['b'];
        $userinfo['invest_total'] = $sum_order['p']==null?0:$sum_order['p'];
        $userinfo['profit_total'] = $sum_order['b']==null?0:$sum_order['b'];

        $amount = $all_in * $win_rate;
        $fenxia = M('fenxia')->field('sum(money) as m')->where(['uid'=>$userinfo['id']])->find();
        $can_draw = $sum_order['p'] - $amount - abs($userinfo['edit_integral'])- $fenxia['m'];
        $can_draw = $can_draw > $userinfo['points'] ? $userinfo['points'] : $can_draw > 0 ? $can_draw :0;
        $fenxia_process = M('fenxia')->field('sum(money) as m')->where(['uid'=>$userinfo['id'], 'status'=>0])->find();
        $userinfo['points'] = $userinfo['points']-$fenxia_process['m'];
        $userinfo['points'] = $userinfo['points']>0?$userinfo['points']:0;
        $userinfo['points'] = floor($userinfo['points']*100)/100;
        $userinfo['code_number']=$userinfo['points'];

        $userinfo['can_draw'] = $can_draw;
        echo json_encode(['status' => 1, 'data' => $userinfo, 'info' => '成功']);
        exit;
    }

    public function zs_backend()
    {
        /*
        $auth = auth_check(C('auth_code'),$_SERVER['HTTP_HOST']);
        if (!$auth) {
            echo "未授权或授权已过期";exit;
        }*/
        if (IS_POST) {
            $limit = I('limit', 50);
            $type = I('type/d', 1);
            $game = '';
            if ($type == 1) {
                $game = "jnd28";
            } elseif ($type == 2) {
                $game = "bj28";
            }
            $rows = M('caiji')->where("game='$game'")->order('periodnumber desc')->limit($limit)->select();
            $out = [];
            $data = [];
            foreach ($rows as $r) {

                $n = explode(',', $r['awardnumbers']);
                $a = intval($n[0]);
                $b = intval($n[1]);
                $c = intval($n[2]);
                $t = $a + $b + $c;
                $n1 = $t;
                $n2 = 0;
                if ($t > 13) {
                    $n1 = 0;
                    $n2 = $t;
                }
                $n3 = $t < 14 ? '-1' : '1';
                $out = [$r['periodnumber'], '' . $n1, '' . $n2, '' . $n3, '0', '' . $t, '' . $t, '0', '0', '-'];

                $data[] = [$out[0], +$out[1], +$out[2], +$out[5], +$out[6], $t];
            }
            $out_arr = [];
            foreach ($data as $key => $value) {
                //$open = isset($data[$key- 1][1]) ? $data[$key- 1][1] :0;
                $date = $value[0];
                $number_sum = (int)$value[4];
//                $close = $open - $number_sum;
                $close = $open;
                $highest = $open;
                $low = $close - 6;
                $out_arr[] = ['data' => $date, 'number_sum' => $number_sum, 'open' => $value[1], 'close' => $value[2], 'high' => $value[3], 'low' => $value[4]];
            }
            echo json_encode(['data' => json_encode($out_arr, 1), 'status' => 1]);
            exit;
        }
        $rows = M('caiji')->where("game='jnd28'")->order('periodnumber desc')->limit(100)->select();
        $out = [];

        foreach ($rows as $r) {

            $n = explode(',', $r['awardnumbers']);
            $a = intval($n[0]);
            $b = intval($n[1]);
            $c = intval($n[2]);
            $t = $a + $b + $c;
            $n1 = $t;
            $n2 = 0;
            if ($t > 13) {
                $n1 = 0;
                $n2 = $t;
            }
            $n3 = $t < 14 ? '-1' : '1';
            $out[] = [$r['periodnumber'], '' . $n1, '' . $n2, '' . $n3, '0', '' . $t, '' . $t, '0', '0', '-'];
        }
        $this->assign("data1", json_encode($out, 1));
        $this->display();
    }

    public function zs()
    {
        /*
        $auth = auth_check(C('auth_code'),$_SERVER['HTTP_HOST']);
        if (!$auth) {
            echo "未授权或授权已过期";exit;
        }*/
        if (IS_POST) {
            $limit = I('limit', 50);
            $type = I('type/d', 1);
            $game = '';
            if ($type == 1) {
                $game = "jnd28";
            } elseif ($type == 2) {
                $game = "bj28";
            }
            $condition = [];
            $condition['game'] = $game;
            $list = M('number')->where($condition)->order('id desc')->limit($limit)->select();
            //$periodnumber_arr = array_column($cai_list,'periodnumber');
            $periodnumber_arr = [];
            $do_one = 0;
            $do_two = 0;
            $out_arr = [];
            foreach ($list as $value) {
                $arr = ['much_max' => 0, 'much_dump' => 0, 'less_dump' => 0, 'less_one' => 0, 'do_one' => 0, 'do_two' => 0, 'periodnumber' => $value['periodnumber'],'awardtime'=>$value['awardtime']];
                $current_number = $value;
                $number1 = explode(',', $current_number['awardnumbers']);

                $numberOne = $number1[0];
                $numberTwo = $number1[1];
                $numberThree = $number1[2];

                $tema_number = $numberOne + $numberTwo + $numberThree;

                $arr['less_dump'] = $number1[0];
                $arr['less_one'] = $number1[1];

                $arr['much_dump'] = $number1[2] + $number1[0];
                $arr['much_max'] = $number1[1] + $number1[2];
                $arr['do_one'] = $arr['less_one'] + $arr['much_max'];
                $arr['do_two'] = $arr['less_dump'] + $arr['much_dump'];
                $arr['all'] = $tema_number;
                $out_arr[] = $arr;
            }

            echo json_encode(['status' => 1, 'data' => $out_arr, 'msg' => '']);
            exit;
        }
        $rows = M('caiji')->where("game='jnd28'")->order('periodnumber desc')->limit(100)->select();
        $out = [];

        foreach ($rows as $r) {

            $n = explode(',', $r['awardnumbers']);
            $a = intval($n[0]);
            $b = intval($n[1]);
            $c = intval($n[2]);
            $t = $a + $b + $c;
            $n1 = $t;
            $n2 = 0;
            if ($t > 13) {
                $n1 = 0;
                $n2 = $t;
            }
            $n3 = $t < 14 ? '-1' : '1';
            $out[] = [$r['periodnumber'], '' . $n1, '' . $n2, '' . $n3, '0', '' . $t, '' . $t, '0', '0', '-'];
        }
        $this->assign("data1", json_encode($out, 1));
        $this->display();

    }


    public function tkInfo()
    {
        $userid = session('user');
        $info = M('user')->where('id=' . $userid['id'])->find();

        $this->assign('info', $info);
        $this->display();
    }

    public function tkInfo2()
    {
        $userid = session('user');
        $info = M('user')->where('id=' . $userid['id'])->find();

        $this->assign('info', $info);
        $this->display();
    }

    public function tkInfoPost()
    {
        if (IS_POST) {
            $data = $_POST;
            $uid = $data['uid'];
            $db = M('user');
            //查询
            $info = $db->where('id=' . $uid)->find();
            //判断登陆密码是否正确

            //if(md5($data['tk_pwd'])!=$info['tk_password']){
            //	echo json_encode(['status'=>0,'info'=>'提款密码错误']);exit;
            //    $this->error('提款密码错误');
            ///}
            $userdata = array(
                'bank' => $data['bank'],
                'bank_name' => $data['bank_name'],
                'bank_user' => $data['bank_user']
            );
            //存入数据
            $res = $db->where('id=' . $uid)->save($userdata);
            if ($res) {
                echo json_encode(['status' => 1, 'info' => '成功']);
                exit;
                $this->success('保存成功');
            } else {
                echo json_encode(['status' => 0, 'info' => '失败']);
                exit;
                $this->error('保存失败');
            }
        }


    }


    //佣金转钱包
    public function yzqpage()
    {
        $this->display();
    }

    //佣金转钱包
    public function fzqpage()
    {
        $this->display();
    }

    public function uppwd()
    {
        $this->display();
    }


    /**
     * 转让post
     */
    public function transferPost()
    {
        if (IS_POST) {

            $userid = session('user');
            $data = $_POST;
            $zruserid = $data['userid'];//转给人
            $zrmoney = $data['money'];//转出金额
            $pass = $data['pass'];//提现密码
            $db = M('user');
            $msgdb = M('transaction');
            //操作被操作人
            $zruserwhere = array('id' => $zruserid);
            //操作session用户并记录
            $sessioninfowhere = array('id' => $userid['id']);
            $sessioninfo = $db->where($sessioninfowhere)->find();
            if (empty($pass)) {
                $this->error('提现密码不能为空');
            }
            if (md5($pass) != $sessioninfo['tk_password']) {
                $this->error('提现密码错误');
            }
            if ($zrmoney > $sessioninfo['points']) {
                $this->error('元宝不足,请Nạp后在操作');
            }

            if ($zruserid == $userid['id']) {
                $this->error('您是要转给自己？想多了');
            }

            $res = $db->where($zruserwhere)->find();
            if ($res == 0) {
                $this->error('ID错误,请重新核对用户ID');
            }

            //获取当前最新用户余额-转出金额=现在金额并更新用户金额
//            $zcusermoney=array(
//                'points'=>$sessioninfo['points']-$zrmoney
//            );
//            $zcdata=$db->where($sessioninfowhere)->setField($zcusermoney);
//           if($zcdata){
            //记录转出
            $msgdata = array(
                'userid' => $sessioninfo['id'],
                'username' => $sessioninfo['nickname'],
                'xymoney' => $sessioninfo['points'],
                'zcmoney' => $zrmoney,
                'zruserid' => $zruserid,
                'zrusername' => $res['nickname'],
                'zrmoney' => $zrmoney,
                'type' => 1,
                'time' => time(),
                'status' => 0
            );
            $msg = $msgdb->add($msgdata);
            //获取转入人当前余额+转入金额=现在金额并更新用户金额
            //  $zrusermoney=array(
            //       'points'=>$res['points']+$zrmoney
            //    );
            //   $zrdata=$db->where($zruserwhere)->setField($zrusermoney);
            //  if($zrdata){
            $mssgdata = array(
                'userid' => $sessioninfo['id'],
                'username' => $sessioninfo['nickname'],
                'xymoney' => $sessioninfo['points'],
                'zcmoney' => $zrmoney,
                'zruserid' => $zruserid,
                'zrusername' => $res['nickname'],
                'zrmoney' => $zrmoney,
                'type' => 2,
                'time' => time(),
                'status' => 0,
                'orderid' => $msg
            );
            $mssg = $msgdb->add($mssgdata);

            //  }
            $this->success('转让成功等待审核');
            //    }else{
            //       $this->error('转让失败');
            //    }
        }

    }


    /**
     * 转让记录
     */
    public function getlastzr()
    {
        $userid = session('user');
        $msgdb = M('transaction');

        $where = array(
            'userid' => $userid['id'],
            'type' => 1
        );
        $count = $msgdb->field("sum(zcmoney) as sum_points,count(id) as count")->where($where)->find();
        $page = new \Think\Page($count['count'], 10);
        $show = $page->show();
        $res = $msgdb->where($where)->limit($page->firstRow . ',' . $page->listRows)->order("id desc")->select();
        $this->assign('show', $show);
        $this->assign('list', $res);
        $this->display();
    }

    /**
     * 转进记录
     */
    public function getlastzj()
    {
        $userid = session('user');
        $msgdb = M('transaction');
        $where = array(
            'zruserid' => $userid['id'],
            'type' => 2
        );
        $count = $msgdb->field("sum(zcmoney) as sum_points,count(id) as count")->where($where)->find();
        $page = new \Think\Page($count['count'], 10);
        $show = $page->show();
        $res = $msgdb->where($where)->limit($page->firstRow . ',' . $page->listRows)->order("id desc")->select();
        $this->assign('show', $show);
        $this->assign('list', $res);
        $this->display();
    }


    //提款密码
    public function tkppwd()
    {
        $userid = session('user');
        if (C('is_weixin') == '1' && is_weixin()) {
            $data = array(
                'is_weixin' => 1
            );

            $this->assign('weixin', $data);
        } else {
            echo is_weixin();
        }
        $where = array(
            'id' => $userid['id'],

        );
        $res = M('user')->where($where)->find();
        $this->assign('info', $res);
        $this->display();
    }

    /**
     * 判断是web登录/微信登录
     * web登录输入登录密码,微信登录直接输入两次密码
     *
     */
    public function tkpwdpost()
    {
        if (IS_POST) {
            $data = $_POST;
            $id = $data['uid'];
            $res = M('user')->where('id=' . $id)->find();
            if (empty($res['tk_password'])) {
                if (C('is_weixin') == '1' && is_weixin()) {

                    //保存提现密码
                    $mess = array(
                        'tk_password' => md5($data['pwd'])
                    );
                    $pwds = M('user')->where('id=' . $id)->save($mess);
                    if ($pwds) {
                        echo json_encode(['status' => 1, 'info' => '提现密码设置成功', 'url' => U('/Home/Run/index')]);
                        exit;
                        $this->success('提现密码设置成功,', U('/Home/Run/index'), 1);
                    } else {
                        echo json_encode(['status' => 0, 'info' => '提现密码设置失败', 'url' => '']);
                        exit;
                        $this->error('提现密码设置失败');
                    }
                } else {

                    //输入的登录密码MD5加密
                    $pwd = md5($data['loginpwd']);
                    //if($pwd==$res['password']){
                    //判断输入的提现密码是否等于登录密码
//                        if($data['pwd']==$data['loginpwd']){
//                            $this->error('输入的提现密码不能与登录密码一致');
//                        }
                    //保存提现密码
                    $mess = array(
                        'tk_password' => md5($data['pwd'])
                    );
                    $pwds = M('user')->where('id=' . $id)->save($mess);
                    if ($pwds) {
                        echo json_encode(['status' => 1, 'info' => '提现密码设置成功', 'url' => U('/Home/Run/index')]);
                        exit;
                        $this->success('提现密码设置成功,', U('/Home/Run/index'), 1);
                    }
//                    }else{
//                        $this->error('登录密码输入错误');
//                    }

                }
            } else {
                //旧密码
                $pwd = md5($data['loginpwd']);
                if ($pwd == $res['tk_password']) {
                    //登录密码

                    $logpwd = md5($data['pwd']);
                    if ($logpwd == $res['password']) {
                        echo json_encode(['status' => 0, 'info' => '提现密码不能与登录密码一致', 'url' => '']);
                        exit;
                        $this->error('提现密码不能与登录密码一致');
                    }

                    $mess = array(
                        'tk_password' => md5($data['pwd'])
                    );
                    $pwds = M('user')->where('id=' . $id)->save($mess);
                    if ($pwds) {
                        echo json_encode(['status' => 1, 'info' => '提现密码设置成功', 'url' => U('/Home/Run/index')]);
                        exit;
                        $this->success('提现密码设置成功,', U('/Home/Run/index'), 1);
                    }

                } else {
                    echo json_encode(['status' => 0, 'info' => '旧的提现密码输入错误', 'url' => '']);
                    exit;
                    $this->error('旧的提现密码输入错误!');
                }

            }


        }

    }


    //Đổi mật khẩu
    public function dopwd()
    {
        $old_pwd = I('old_pwd');
        $pwd = I('pwd');
        $user = session('user');
        $userinfo = M('user')->where("id = {$user['id']}")->find();
        if ($userinfo['password'] != md5($old_pwd)) {
            echo json_encode(['info' => '旧密码不正确', 'status' => 0, 'url' => '']);
            exit;
            //$this->error("旧密码不正确");
        }

        $res = M('user')->where("id = {$user['id']}")->save(array('password' => md5($pwd)));

        if ($res) {
            echo json_encode(['info' => 'Đổi mật khẩu成功，跳转中~', 'status' => 1, 'url' => U('Home/User/index')]);
            exit;
            $this->success('Đổi mật khẩu成功，跳转中~', U('Home/User/index'), 1);
        } else {
            echo json_encode(['info' => 'Đổi mật khẩu失败', 'status' => 0, 'url' => '']);
            exit;
            $this->error('Không thể thay đổi mật khẩu');
        }

    }

    //佣金转钱包
    public function yzq()
    {
        $money = I('money');
        $uid = session('user');
        $user = M('user')->where("id = {$uid['id']}")->find();

        if (intval($user['yong']) < intval($money)) {
            echo json_encode(['info' => '佣金不足，请确认', 'status' => 0, 'url' => '']);
            exit;
            $this->error("佣金不足，请确认");
        }

        $User = M('user');
        $User->startTrans();
        $res1 = $User->where("id = {$uid['id']}")->setDec('yong', $money);
        $res2 = $User->where("id = {$uid['id']}")->setInc('points', $money);

        if ($res1 && $res2) {
            $User->commit();
            echo json_encode(['info' => '转入成功，跳转中~', 'status' => 1, 'url' => U('Home/User/index')]);
            exit;
            $this->success('转入成功，跳转中~', U('Home/User/index'), 1);
        } else {
            $User->rollback();
            echo json_encode(['info' => '转入失败，请重试', 'status' => 0, 'url' => '']);
            exit;
            $this->error('转入失败，请重试');
        }
    }

    //佣金转钱包
    public function fzq()
    {
        $money = I('money');
        $uid = session('user');
        $user = M('user')->where("id = {$uid['id']}")->find();

        if (intval($user['fanshui']) < intval($money)) {
            echo json_encode(['info' => '返水金额不足，请确认', 'status' => 0, 'url' => '']);
            exit;
            $this->error("返水金额不足，请确认");
        }

        $User = M('user');
        $User->startTrans();
        $res1 = $User->where("id = {$uid['id']}")->setDec('fanshui', $money);
        $res2 = $User->where("id = {$uid['id']}")->setInc('points', $money);

        if ($res1 && $res2) {
            $User->commit();
            echo json_encode(['转入成功，跳转中~', 'status' => 1, 'url' => U('Home/User/index')]);
            exit;
            $this->success('转入成功，跳转中~', U('Home/User/index'), 1);
        } else {
            $User->rollback();
            echo json_encode(['info' => '转入失败，请重试', 'status' => 0, 'url' => '']);
            exit;
            $this->error('转入失败，请重试');
        }
    }

    //Tôi下线
    public function offline()
    {
        $id = I('id');
        // $userinfo = session('user');
        $member = M('user');
        $count = $member->where("t_id = {$id}")->count();
        $page = new \Think\Page($count, 10);
        $show = $page->show();
        $list = $member->where("t_id = {$id}")->limit($page->firstRow . ',' . $page->listRows)->order("id ASC")->select();


        foreach ($list as $key => $value) {
            $yong = M('push_money')->where("id={$value['id']}")->field("SUM(money) as money")->find();
            $list[$key]['yong'] = $yong['money'] ?: 0;
        }

        //直属线下列表id
        $all_off = $member->field("id")->where("t_id = {$id}")->select();
        //三级下级列表id
        $ids = array();
        $ids2 = array();
        $ids3 = array();
        foreach ($all_off as $key => $value) {
            $ids[] = $value['id'];
            $all_off2 = $member->field("id")->where("t_id = {$value['id']}")->select();
            if (!empty($all_off2)) {
                foreach ($all_off2 as $key2 => $value2) {
                    $ids2[] = $value2['id'];
                    $all_off3 = $member->field("id")->where("t_id = {$value2['id']}")->select();
                    if (!empty($all_off3)) {
                        foreach ($all_off3 as $key3 => $value3) {
                            $ids3[] = $value3['id'];
                        }
                    }
                }
            }
        }
        $all_ids = array_merge($ids, $ids2, $ids3);
        $ids = implode(',', $ids);
        $all_ids = implode(',', $all_ids);

        $time = I('time');
        $start = strtotime(str_replace("+", " ", I('starttime')));
        $end = strtotime(str_replace("+", " ", I('endtime')));

        if ($time) {
            if ($time == 'today') {
                $start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                $end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
            } elseif ($time == 'yestoday') {
                $start = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
                $end = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
            } elseif ($time == 'week') {
                $start = mktime(0, 0, 0, date('m'), date('d') - 6, date('Y'));
                $end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
            } elseif ($time == 'month') {
                $start = mktime(0, 0, 0, date('m'), date('d') - 29, date('Y'));
                $end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
            }
        }
        $map = array();
        if ($start && $end) {
            $map['time'] = array(array('egt', $start), array('elt', $end), 'and');
        }

        //每个会员的流水
        foreach ($list as $key => $value) {

            $user_order = M("order")->field("sum(add_points) as sum_add,sum(del_points) as sum_del")->where("userid={$value['id']} and state=1")->where($map)->find();
            $list[$key]['add_points'] = $user_order['sum_add'];
            $list[$key]['del_points'] = $user_order['sum_del'];
            $list[$key]['ying'] = $user_order['sum_add'] - $user_order['sum_del'];
        }


        $list_new = $this->_arraysort($list, 'add_points');


        //所有下线上下分记录
        $add_fen = M('integral')->field("sum(points) as add_fen")->where("type = 1 and uid in (" . $ids . ")")->where($map)->find();

        $xia_fen = M('integral')->field("sum(points) as xia_fen")->where("type = 0 and uid in (" . $ids . ")")->where($map)->find();

        $integral['add_fen'] = $add_fen['add_fen'];
        $integral['xia_fen'] = $xia_fen['xia_fen'];

        //所有下线进项、出项流水
        $order = M("order")->field("sum(add_points) as sum_add,sum(del_points) as sum_del")->where("state=1 and userid in (" . $ids . ")")->where($map)->find();

        $order['ying'] = $order['sum_add'] - $order['sum_del'];

        //所得所佣金
        $yong = M('push_money')->field("sum(money) as sum_yong")->where("uid in (" . $ids . ")")->where($map)->find();

        //所有下三级下线的数据统计
        $add_fen_all = M('integral')->field("sum(points) as add_fen")->where("type = 1 and uid in (" . $all_ids . ")")->where($map)->find();

        $xia_fen_all = M('integral')->field("sum(points) as xia_fen")->where("type = 0 and uid in (" . $all_ids . ")")->where($map)->find();

        $integral_all['add_fen'] = $add_fen_all['add_fen'];
        $integral_all['xia_fen'] = $xia_fen_all['xia_fen'];

        //所有下线进项、出项流水
        $order_all = M("order")->field("sum(add_points) as sum_add,sum(del_points) as sum_del")->where("state=1 and userid in (" . $all_ids . ")")->where($map)->find();

        $order_all['ying'] = $order_all['sum_add'] - $order_all['sum_del'];

        //所得所佣金
        $yong_all = M('push_money')->field("sum(money) as sum_yong")->where("uid in (" . $all_ids . ")")->where($map)->find();

        $this->assign('id', $id);
        $this->assign('show', $show);
        $this->assign('list', $list_new);
        $this->assign('integral', $integral);
        $this->assign('order', $order);
        $this->assign('yong', $yong);
        $this->assign('integral_all', $integral_all);
        $this->assign('order_all', $order_all);
        $this->assign('yong_all', $yong_all);
        $this->assign('total_money', $total_money);
        $this->assign('start', $start ? date('Y-m-d H:i:s', $start) : '');
        $this->assign('end', $end ? date('Y-m-d H:i:s', $end) : '');
        $this->display();
    }


    private function _arraysort($arr, $field)
    {
        $field_arr = array();
        foreach ($arr as $key => $value) {
            $field_arr[$key] = $value[$field];
        }

        if (!empty($field_arr) && !empty($arr)) {
            array_multisort($field_arr, SORT_DESC, $arr);
        }
        return $arr;
    }

    //Tôi下线下注记录
    public function offxz()
    {
        $time = I('time');
        $map = array();

        $map['state'] = 1;
        $time = I('time');
        $start = strtotime(I('starttime'));
        $end = strtotime(I('endtime'));

        if ($time) {
            if ($time == 'today') {
                $start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                $end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
            } elseif ($time == 'yestoday') {
                $start = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
                $end = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
            } elseif ($time == 'week') {
                $start = mktime(0, 0, 0, date('m'), date('d') - 6, date('Y'));
                $end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
            } elseif ($time == 'month') {
                $start = mktime(0, 0, 0, date('m'), date('d') - 29, date('Y'));
                $end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
            }
        }

        if ($start && $end) {
            $map['time'] = array(array('egt', $start), array('elt', $end), 'and');
        }

        $id = I('id');
        $map['is_under'] = 1;
        $map['userid'] = $id;
        $order = M('order');
        // $integral = M('integral');
        $count = $order->where($map)->count();
        $page = new \Think\Page($count, 10);
        $show = $page->show();
        $list = array();
        $tj = $order->field("sum(add_points) as sum_add,sum(del_points) as sum_del")->where($map)->find();
        $list = $order->where($map)->limit($page->firstRow . ',' . $page->listRows)->order("id DESC")->select();

        $this->assign('list', $list);
        $this->assign('time', $time);
        $this->assign('id', $id);
        $this->assign('show', $show);
        $this->assign('tj', $tj);
        $this->assign('start', $start ? date('Y-m-d', $start) : '');
        $this->assign('end', $end ? date('Y-m-d', $end) : '');
        $this->display();
    }

    //Tôi下线Nạp记录
    public function offcz()
    {
        $id = I('id');
        $map['uid'] = $id;

        $integral = M('integral');
        $time = I('time');
        $map = array();
        $map['uid'] = $id;
        $start = strtotime(I('starttime'));
        $end = strtotime(I('endtime'));

        if ($time) {
            if ($time == 'today') {
                $start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
                $end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
            } elseif ($time == 'yestoday') {
                $start = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
                $end = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
            } elseif ($time == 'week') {
                $start = mktime(0, 0, 0, date('m'), date('d') - 6, date('Y'));
                $end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
            } elseif ($time == 'month') {
                $start = mktime(0, 0, 0, date('m'), date('d') - 29, date('Y'));
                $end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
            }
        }

        if ($start && $end) {
            $map['time'] = array(array('egt', $start), array('elt', $end), 'and');
        }


        $sum_data = array(
            'add' => 0,
            'xia' => 0,
        );


        $count = $integral->where($map)->count();
        $page = new \Think\Page($count, 10);
        $show = $page->show();
        $sum_add = $integral->field("sum(points) as sum_add")->where("type = 1")->where($map)->find();
        $sum_data['add'] = $sum_add['sum_add'];
        $sum_xia = $integral->field("sum(points) as sum_add")->where("type = 0")->where($map)->find();
        $sum_data['xia'] = $sum_xia['sum_add'];
        $list = $integral->where($map)->limit($page->firstRow . ',' . $page->listRows)->order("id DESC")->select();

        for ($i = 0; $i < count($list); $i++) {
            $list[$i]['user'] = M('user')->where("id = {$list[$i]['uid']}")->find();
        }

        $startline = $start ? date('Y-m-d', $start) : '';
        $endline = $start ? date('Y-m-d', $end) : '';

        $this->assign('nickname', $nickname);
        $this->assign('start', $startline);
        $this->assign('end', $endline);
        $this->assign('list', $list);
        $this->assign('id', $id);
        $this->assign('show', $show);
        $this->assign('sum_data', $sum_data);
        $this->assign('time', $time);
        $this->display();
    }

    //Nạp记录
    public function fenadd()
    {
        $uid = I('userid');

        $type = I('type', 1);
        $member = M('fenxia');
        $status_key='status';
        if ($type == 1) {
            $member = M('fenadd');
            $status_key='check';
        }        $start_time = strtotime(I('start_time')) ?: 0;
        $end_time = strtotime(I('end_time')) ?: time();
        $condition = " addtime >= $start_time and addtime <= $end_time and uid = {$uid}";
        //if ($type >= 0 ){
        //   $condition .= " and type = {$type}";
        //}
        $count = $member->field("count(id) as count")->where($condition)->find();

        $page = new \Think\Page($count['count'], 10);
        $show = $page->show();
        $list = $member->where($condition)->limit($page->firstRow . ',' . $page->listRows)->order("id desc")->select();
        if ($type == 2) {
            //	var_dump($member->where($condition)->limit($page->firstRow.','.$page->listRows)->order("id desc")->buildSql());exit;
        }
        //var_dump($list);exit;
        foreach ($list as &$val) {
            if ($val[$status_key] == 1) {
                $val['status_name'] = '已通过';
            } elseif ($val[$status_key] == 2) {
                $val['status_name'] = '已忽略';
            } else {
                $val['status_name'] = '待审核';
            }
        }
        if (I('userid')) {
            echo json_encode(['status' => 1, 'info' => '', 'data' => ['count' => $count, 'list' => $list]]);
            exit;
        }
        $this->assign('show', $show);
        $this->assign('count', $count);
        $this->assign('list', $list);
        $this->display();
    }

    //提现记录
    public function fenxia()
    {
        $uid = session('user')['id'];
        $member = M('integral');
        $count = $member->field("sum(points) as sum_points,count(id) as count")->where("type = {$type}  and uid = {$uid}")->find();
        $page = new \Think\Page($count['count'], 10);
        $show = $page->show();
        $type = I('type', 0);
        $list = $member->where("type = {$type} and uid = {$uid}")->limit($page->firstRow . ',' . $page->listRows)->order("id desc")->select();
        if (I('userid')) {
            echo json_encode(['status' => 1, 'info' => '', 'data' => ['count' => $count, 'list' => $list]]);
            exit;
        }
        $this->assign('show', $show);
        $this->assign('list', $list);
        $this->assign('count', $count);
        $this->display();
    }

    public function xiazhu()
    {
        $t = I('t');
        $state = I('state'); // 默认1
        $pkdata = F('pk10data');
        $type = I('type');
        $is_add = I('is_add', -1);
        $map = array();

        $beginToday = strtotime(I('start_time')) ?: 0;
        $endToday = strtotime(I('end_time')) ?: 0;

        if (false) {
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
        }
        if ($is_add >= 0) {
            //$map['is_add'] = $is_add;
        }
        if ($beginToday and $endToday) {
            $map['time'] = array(array('egt', $beginToday), array('elt', $endToday), 'and');
        }
        $userinfo = session('user');
        if ($state >= 0) {
            // $map['state'] = $state;
        }
        $map['userid'] = $userinfo['id'];
        if ($type) {
            //$map['type'] = $type;
        }
        if ($type == 1) {
            $map['game'] = ['like', 'bj28%'];
        } elseif ($type == 2) {
            $map['game'] = ['like', 'jnd28%'];
        }

        $whereRaw = '1=1';
        if ($state == 0) {//全部

        } elseif ($state == 1) {//投资成功
            $map['state'] = 1;
            $map['is_add'] = 1;
            $whereRaw = ' add_points > del_points';
        } elseif ($state == 2) {// 投资失败
            $map['state'] = 1;
            $map['is_add'] = 1;
            $whereRaw = ' add_points < del_points';
        } elseif ($state == 3) {// 待收益
            $map['is_add'] = 0;
            $map['state'] = 1;
        } elseif ($state == 4) {// 已撤资
            $map['state'] = 1;
            $map['is_add'] = 1;
        } elseif ($state == 5) {
            $map['is_add'] = 1;
        }

        $order = M('order');
        $count = $order->where($map)->count();
        $points_tj = $order->field("count(id) as count,sum(add_points) as sum_add,sum(del_points) as sum_del")->where($map)->find();
        $points_tj['ying'] = $points_tj['sum_add'] - $points_tj['sum_del'];
        $page = new \Think\Page($points_tj['count'], 50);
        $show = $page->show();
        $list = $order->field("*")->where($whereRaw)->where($map)->limit($page->firstRow . ',' . $page->listRows)->order("id DESC")->select();
        // foreach ($list as &$val) {

        // }
        //var_dump($list);exit;
        $number = array();
        $tema_txt = array("0, 27", "1, 26", "2, 25", "3, 24", "4, 23", "5, 22", "6, 21", "7, 20", "8, 19", "9, 18", "10, 17", "11, 16", "12, 15", "13, 14");
        for ($i = 0; $i < count($list); $i++) {

            if (!in_array($list[$i]['number'], $number)) {
                $number[] = $list[$i]['number'];
            }
            for ($a = 0; $a < count($number); $a++) {
                if ($list[$i]['number'] == $number[$a]) {
                    $list1[$a]['number'] = $number[$a];
                    $list1[$a]['order'][] = $list[$i];
                }
            }
            if ( $list[$i]['type']=='6' ) {
                $idx = explode('点', $list[$i]['jincai'])[0];
                $list[$i]['jincai']=$tema_txt[$idx];
            } // End If
        }
        $mktime = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        //print_r($list1);
        if (I('userid')) {
            echo json_encode(['status' => 1, 'info' => '', 'data' => [
                'list1' => $list1,
                'list' => $list,
                'status' => F('state'),
                'number' => $pkdata['next']['periodNumber'],
                'points_tj' => $points_tj,
                'show' => '',
                'today' => $mktime,
                't' => $t
            ]]);
            exit;
        }
        $this->assign('list1', $list1);
        $this->assign('state', F('state'));
        $this->assign('number', $pkdata['next']['periodNumber']);
        $this->assign('list', $list);
        $this->assign('points_tj', $points_tj);
        $this->assign('show', $show);
        $this->assign('today', $mktime);
        $this->assign('t', $t);
        $this->display();
    }

    //图片上传
    public function avatarUpload()
    {
        $uid = session('user')['id'];
        $config = array(
            'maxSize' => 3145728,
            'rootPath' => './Uploads/member/',
            'savePath' => '',
            'saveName' => array('uniqid', ''),
            'exts' => array('jpg', 'gif', 'png', 'jpeg'),
            'autoSub' => true,
            'subName' => array('date', 'Ymd'),
        );
        $upload = new \Think\Upload($config);// 实例化上传类

        // 上传文件
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功

            $data = M('user')->where('id=' . $uid)->save(array('headimgurl' => '/Uploads/member/' . $info['file']['savepath'] . $info['file']['savename']));
            if ($data) {
                $this->success('上传成功！');
            }

        }


    }

    public function update_robot(){
        set_time_limit(0);
        $list = M('order')->select();
        foreach($list as $val){
            $name_arr = ['Sam','james','Ciel','hugo','park','peter','judy','jack','jim','faker','juily','jue','thaks','Mei','mark','mike','may','Pater','jalier','fulish','jelly','jain'];
            $number = rand(0,1223);
            $name = $name_arr[rand(0,count($name_arr)-1)];
            if($number){
                $name .= $number;
            }
            $res =M('order')->where(['id'=>$val['id']])->save(['nickname'=>$name,'username'=>$name]);
            var_dump($res);
        }
    }
}

?>
