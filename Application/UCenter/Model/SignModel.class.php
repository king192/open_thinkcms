<?php
namespace UCenter\Model;
use Think\Model;
class SignModel extends Model {
	//
	function info($uid){
		return $this->where(array('uid'=>$uid))->find();
	}
	//更新用户数据
	function updata($uid,$data){
		return $this->where(array('uid'=>$uid))->save($data);
	}
	//新增
	function addd($uid){
		$data = array(
			'uid'	=> $uid,
			'sign_tm'	=> time(),
			'sign_num'	=> 1,
			// 'status'	=> 1,
			);
		return $this->add($data);
	}
}