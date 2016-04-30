<?php
namespace UCenter\Model;
use Think\Model;

class NavItemModel extends Model{
	function get_item($pid){
		$res = $this->where(array('pid'=>$pid,'uid'=>0))->order('sort')->select();
		return $res;
	}
	function get_user_item($pid,$uid){
		$res = $this->where(array('pid'=>$pid,'uid'=>$uid))->order('sort')->select();
		return $res;
	}
	function hello(){
		return 'hhhhhhl';
	}
}