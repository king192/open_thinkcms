<?php
namespace UCenter\Model;
use Think\Model;

class NavParentModel extends Model{
	function get_item($ppid){
		$res = $this->where(array('ppid'=>$ppid,'uid'=>0))->order('sort desc')->select();
		return $res;
	}
	function get_user_item($ppid,$uid){
		$res = $this->where(array('ppid'=>$ppid,'uid'=>$uid))->order('sort desc')->select();
		return $res;
	}
	function hello(){
		return 'hhhhhhl';
	}
}