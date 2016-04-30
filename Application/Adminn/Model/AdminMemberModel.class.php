<?php
namespace Adminn\Model;
use Think\Model;

class AdminMemberModel extends Model {
	/**
	 * 添加管理员
	 * @param [type] $uid [description]
	 */
	function add_member($uid){
		return $this->add(array('uid'=>$uid,'ctime'=>time()));
	}
	/**
	 * 删除成员
	 * @param  number $uid 用户uid
	 * @return [type]      [description]
	 */
	function del_member($uid){
		return $this->where(array('uid'=>$uid))->delete();
	}
}