<?php
namespace User\Model;
use Think\Model;

class UserModel extends Model{
	function useradd($data){
		$res = $this->where(array('username'=>$data['username']))->getField('id');
		if($res){
			json_rtn(-1,'用户名已存在');

		}
		$res = $this->where(array('email'=>$data['email']))->getField('id');
		if($res){
			json_rtn(-2,'邮箱已存在');
		}
		$res = $this->add($data);
		if($res){
			json_rtn(1,'注册成功');
		}
	}
	function userlogin($data){
		$res = $this->where($data)->find();
		if($res){
			// return json_r(1,'通过验证',$res,'',false);
			$new_tm = time();
			$this->where(array('id'=>$res['id']))->save(array('lastlgtm'=>$new_tm,'lastip'=>get_client_ip(),'login_times'=>$res['login_times']+1));
			// $this->where(array('id'=>$res['id']))->setInc('login_times',1);
			$res['lastlgtm'] = $new_tm;
			return $res;
		}else{
			json_rtn(0,'用户名或密码不正确');
		}
	}
	/**
	*@param $userid 用户唯一标识，用户名或邮箱
	*/
	function get_token($userid){
		//查找用户是否存在
		// json_rtn(-999,$userid);
		$user = $this->where($userid)->field('id,username,passwd,email')->find();
		// json_rtn(-111,$user);
		if(!$user){
			json_rtn(-1,'此用户不存在');
		}
		//更新获取时间
		$tm = time();
		$res = $this->where(array('id'=>$user['id']))->save(array('lastrettm'=>$tm));
		if(!$res){
			json_rtn(-2,'邮件发送失败');
		}
		//uid加密
		$enc_uid = think_encrypt($user['id'],'ju58t5t89tmbfki549fj4a2lbm5',60*60*24);
		return array('token'=>$tm.$user['username'].$user['passwd'],'uid'=>$enc_uid,'email'=>$user['email']);

	}
	//验证token值
	function verify_token($uid,$token){
		$uid = intval(think_decrypt($uid,'ju58t5t89tmbfki549fj4a2lbm5'));
		// dump($uid);
		$user = $this->where(array('id'=>$uid))->field('username,passwd,lastrettm')->find();
		// return $user['username'].$user['passwd'].$user['lastrettm'];
		if($token == $user['lastrettm'].$user['username'].$user['passwd']){
			return true;
		}else{
			return false;
		}
	}
	/**
	*@param $string 重置密码字符串
	*/
	function randompwd($uid,$string){
		$uid = intval(think_decrypt($uid,'ju58t5t89tmbfki549fj4a2lbm5'));
		$email = $this->where(array('id'=>think_decrypt($uid,'ju58t5t89tmbfki549fj4a2lbm5')))->getField('email');
		if(!$email){
			json_rtn(-1,'重置密码失败');
			// $this->error('重置密码失败');
		}
    	$$string = \Vendor\my\User::passwd_encode($string);//密码加密
		$res = $this->where(array('id'=>$uid))->save(array('passwd'=>$string));
		if($res){
			return $email;
		}else{
			json_rtn(-2,'重置密码失败');
			// $this->error('重置密码失败');
		}
	}
	function diy_resetpwd($uid,$newPasswd){
		$uid = intval(think_decrypt($uid,'ju58t5t89tmbfki549fj4a2lbm5'));
		// $email = $this->where(array('id'=>$uid))->getField('email');
		$res = $this->where(array('id'=>$uid))->save(array('passwd'=>passwd_encode($newPasswd)));
		if($res){
			json_rtn(1,'密码重置成功');
		}else{
			json_rtn(0,'重置密码失败');
		}
	}
}