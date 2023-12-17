<?php
/**
 * Created by PhpStorm.
 * User: zhao
 * Date: 2019/3/19
 * Time: 15:08
 */

namespace Home\Controller;
use Think\Controller;

class CaipiaoshuomingController extends BaseController
{

    //北京28普通房
    public function bj28pt(){
        $where=array(
            'game'=>'北京28普通房'
        );
        $res =M('gametest')->where($where)->find();
        $this->assign($res);
        $this->display();
    }
    //北京28中级房
    public function bj28zj(){
        $where=array(
            'game'=>'北京28中级房'
        );
        $res =M('gametest')->where($where)->find();
        $this->assign($res);
        $this->display();
    }
    //北京28高级房
    public function bj28gj(){
        $where=array(
            'game'=>'北京28高级房'
        );
        $res =M('gametest')->where($where)->find();
        $this->assign($res);
        $this->display();
    }

    //加拿大28初级房
    public function jnd28pt(){
        $where=array(
            'game'=>'加拿大28初级房'
        );
        $res =M('gametest')->where($where)->find();
        $this->assign($res);
        $this->display();
    }

    //加拿大28中级房
    public function jnd28zj(){
        $where=array(
            'game'=>'加拿大28中级房'
        );
        $res =M('gametest')->where($where)->find();
        $this->assign($res);
        $this->display();
    }

    //加拿大28高级房
    public function jnd28gj(){
        $where=array(
            'game'=>'加拿大28高级房'
        );
        $res =M('gametest')->where($where)->find();
        $this->assign($res);
        $this->display();
    }
	    //加拿大28vip房
    public function jnd28vip(){
        $where=array(
            'game'=>'加拿大28高级房'
        );
        $res =M('gametest')->where($where)->find();
        $this->assign($res);
        $this->display();
    }
}