<?php
namespace UCenter\Model;
use Think\Model;

class UserModel extends Model{
   protected $_validate = array(
     // array('verify','require','验证码必须！'), //默认情况下用正则进行验证
     // array('name','','帐号名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
     // array('value',array(1,2,3),'值的范围不正确！',2,'in'), // 当值不为空的时候判断是否在一个范围内
     array('new_passwd','6,20','请输入6到20位的密码',0,'length'), // 
     array('repasswd','new_passwd','确认密码不一致',0,'confirm'), // 验证确认密码是否和密码一致
     array('passwd','checkpwd','旧密码不正确',0,'callback'),
     // array('phone','checkPhone','电话号码格式不正确',0,'callback'),
     // array('phone','phone','电话号码格式不正确',0,'regex'),
     array('phone','chk_phone_exist','电话号码已存在',0,'callback'),
     // array('phone','','电话号码已存在',0,'unique',Model:: MODEL_INSERT),
     array('phone','integer','电话号码必须为数字',0,'regex'),
     array('phone','11','电话号码必须11位',0,'length'),
     array('url','url','URL格式不正确',2,'regex'),
     array('sex',array(1,2,0),'性别的范围不正确！',0,'in'), // 当值不为空的时候判断是否在一个范围内
     array('about','0,500','简介字数应少于500字',2,'length'),
   );
	function get_user_info($uid,$cols='*'){
		return $this->where(array('id'=>$uid))->field($cols)->find();
	}
	function update_user($uid,$data=array()){
		// $data = array();
		// trace($data,'dataaaa','DEBUG');
		return $this->where(array('id'=>$uid))->save($data);
	}
	function checkPhone($data){
		// trace($data,'phone','DEBUG');
		list($k,$v) = explode(':', $data);
		// implode(glue, pieces)
		// trace(explode(':', $data),'value','DEBUG');
		if(preg_match('/^(\d){11}$/', $v)){
			return true;
		}
		return false;
	}
	function chk_phone_exist($data){
		$v = explode(':', $data);
		// trace($v[0],'dddd','DEBUG');
		return !$this->where(array('phone'=>$v[0]))->getField('id');
	}
	function checkpwd($data){
		$v = explode(':', $data);
		// trace($data,'passwd','DEBUG');

		$decode_passwd = ($v[0]);
		$res = $this->where(array('id'=>UID,'passwd'=>$decode_passwd))->getField('id');
		if($res){
			//密码正确则通过验证
			return true;
		}
		return false;
	}
}