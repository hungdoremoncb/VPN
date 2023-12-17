<?php

namespace Admin\Controller;
use Think\Controller;

class TreasureController extends BaseController{
	
	public function index(){
		 

		$userid = I('userid');
		
		 
		if($userid){
			if (is_numeric($userid)) {
				$map['userid'] = $userid;
			} else{
				$map['userid'] = $userid;
			}
			
			$member = M('user');
			$memberModel = $member->where($map)->find();
			
			
			$treasure = M('treasure');
			$count = $treasure->where($map)->count();
			$page = new \Think\Page($count,10);
			$show = $page->show();
			$list = $treasure->where($map)->limit($page->firstRow.','.$page->listRows)->order("id ASC")->select();
		}else{
			
			//$map['times'] = $userid;
			
			$start=mktime(0,0,0,date('m'),date('d')-29,date('Y'));
			$end=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
				
			$map['time'] = array(array('egt',$start),array('elt',$end),'and');
			
			$treasure = M('treasure');
			$count = $treasure->where($map)->count();
			$page = new \Think\Page($count,10);
			$show = $page->show();
			$list = $treasure->where($map)->limit($page->firstRow.','.$page->listRows)->order("id ASC")->select();
			
		}
		
		//$this->assign('memberModel',$memberModel);
		$this->assign('show',$show);
		$this->assign('userid',$userid);
		$this->assign('list',$list);
		$this->display();
	}
	
}
?>