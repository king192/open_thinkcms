<?php
namespace User\Controller;
use Think\Controller;

class UserRegisterController extends Controller{
	public function index(){
		$this->assign('title','用户注册');
		$this->display();
	}
	//普通注册
	public function register(){
		if($_GET){
			exit('invalid');
		}
		$username = I('username');
		$passwd = $_POST['passwd'];
		$email = I('email');
		$phone = I('phone');
		// $data = I('data');
		// $t = I('username');
		$res = $this->valid($username,$passwd,$email,$phone);
		$res && json_rtn(-1,$res);
		!isset($_POST['protocol']) && json_rtn(-3,'请同意我们的协议');
		if(!check_verify($_POST['verify'])){
			json_rtn(-1,'验证码不正确');
		}
		// $res || json_rtn($res,'');
		$passwd = \Vendor\my\User::passwd_encode($passwd);
		$phone = I('phone');
		$data = array(
			'username'=>$username,
			'passwd'=>$passwd,
			'email'=>$email,
			'phone'=>$phone,
			'regtm'=>time(),
			);
		// json_rtn(999,$data);
		$user = D('user');
		$res = $user->useradd($data);
		if($res['rtn']>0){
			json_rtn(1,$res['msg']);
		}else{
			json_rtn(0,$res['msg']);
		}
	}
	//微信注册
	public function wx_register(){

	}
	protected function valid($a,$b,$c,$d){
		if(empty($a)){
			return '用户名不能为空';//
		}

		if(preg_match('/(admin)/', strtolower($a)) || preg_match('/(管理员)/', $a)){
			return '用户名不能含有admin或管理员';
		}
		if(empty($b)){
			return '密码不能为空';
		}
		if(empty($c)){
			return '邮箱不能为空';
		}
		if(!preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $c)){
			return '邮箱格式不正确';
		}
		if(strlen($a)<6||strlen($a)>20){
			return '请输入6到20位的用户名';
		}
		if(strlen($b)<6||strlen($b)>20){
			return '请输入6到20位的密码';
		}
		if(!preg_match('/^\d{11}$/', $d)){
			return '请输入11位数字电话号码';
		}
		return false;
	}


    /* 验证码，用于登录和注册 */
    public function verify(){
      $config =    array(
            'fontSize'    =>    32,    // 验证码字体大小
            'length'      =>    4,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
            'useCurve'    =>    false, // 关闭混淆曲线
            // 'bg'          =>  array(255, 255, 255),        // 关闭验证码背景颜色
        );
        $verify = new \Think\Verify($config);
        $verify->entry(1);
    }
}