<?php
namespace UCenter\Controller;
/**
 * 资料修改控制器
 */
class Uc1Controller extends UcPublicController{
	/**
	 * 修改基本资料
	 */
	public function set_base(){
		
        // $info = $this->fetch('Ajax/myposts');
        $data = array(
        	'phone'=>I('post.phone'),
        	// 'email'=>'tttt',
        	);
        // json_rtn(1,$data['phone']);
        $m_user = D('User');
        if(!$m_user->create($data)){
        	json_rtn(-1,$m_user->getError());
        }
        $res = $m_user->update_user(UID,$data);
        if($res){
        	json_rtn(1,'修改成功');
        }
        json_rtn(-2,'修改失败');
	}
	/**
	 * 修改详细资料
	 */
	public function set_profile(){

		$data = array(
			'sex'=>intval($_POST['sex']),
			// 'birthday'=>$_POST['YYYY'].'-'.$_POST['MM'].'-'.$_POST['DD'],
			'url'=>I('post.url'),
			'about'=>I('post.about'),
			);
		$m_user = D('User');
		if(!$m_user->create($data)){
			json_rtn(-1,$m_user->getError());
		}
		if((intval($_POST['YYYY'] || intval($_POST['MM']) || intval($_POST['DD'])))){
			$data['birthday']=intval($_POST['YYYY']).'-'.intval($_POST['MM']).'-'.intval($_POST['DD']);
			// json_rtn(2,$data['birthday']);
			$res = \Vendor\my\Date::valid_date1($data['birthday']);
			if(!$res){
				json_rtn(-3,'日期格式不符');
			}
		}
		$res = $m_user->where(array('id'=>UID))->save($data);
		if(!$res){
			json_rtn(-2,'修改失败');
		}
		json_rtn(1,'修改成功');

	}
	public function set_passwd(){
		$data = array(
			'passwd'=>\Vendor\my\User::passwd_encode($_POST['passwd']),
			'new_passwd'=>$_POST['new_passwd'],
			'repasswd'=>$_POST['repasswd'],
			);
		$m_user = D('User');
		if(!$m_user->create($data)){
			json_rtn(-1,$m_user->getError());
		}
		if($_POST['passwd']===$_POST['new_passwd']){
			json_rtn(-3,'新密码不能与旧密码相同');
		}
		$res = $m_user->where(array('id'=>UID))->save(array('passwd'=>\Vendor\my\User::passwd_encode($data['new_passwd'])));
		if(!$res){
			json_rtn(-2,'密码修改失败');
		}
		json_rtn(1,'修改密码成功');

	}
	public function feedback(){
		$data = array(
			'title'=>trim(I('post.title')),
			'content'=>trim(I('post.content')),
			);
		$m_feedback = D('Feedback');
		if(!$m_feedback->create($data)){
			json_rtn(-1,$m_feedback->getError());
		}
		if(!check_verify($_POST['verify'])){
			json_rtn(-3,'验证码不正确');
		}
		$res = $m_feedback->feedback($data);
		if(!$res){
			json_rtn(-2,'提交失败');
		}
		json_rtn(1,'提交成功');
	}
}