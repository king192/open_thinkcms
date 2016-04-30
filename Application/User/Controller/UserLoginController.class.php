<?php
namespace User\Controller;
use Think\Controller;

class UserLoginController extends Controller{
	public function _initialize(){
		if(is_mlogin()){
			// header("Content-type:text/html;charset=utf-8");
			if(ACTION_NAME != 'logout'){
				// $this->display('alreadyLogin');
				header('location:'.U('UCenter/Uc/profile'));
				exit('login');
			}
		}
		// dump(is_mlogin(),true,'ttt');
	}
	public function index(){
		$this->assign('title','登录');
		$this->display();
	}
	public function login(){
		//数据库取数据，如果一致通过 
		$username = I('username');
		// json_rtn(-1000,$username);
		$passwd = $_POST['passwd'];
		empty($username) && json_rtn(-1,'用户名或邮箱不能为空');
		empty($passwd) && json_rtn(-2,'密码不能为空');
		// json_rtn(-1,'kdjf');
		if(!check_verify(I('verify'))){
			json_rtn(-1,'验证码错误');
		}
		$passwd = $this->passwd_encode($passwd);
	    if(strpos($username,"@")>0){//邮箱登陆
	    	// json_rtn(-999,$username);
			$data = array('email'=>$username,'passwd'=>$passwd);
		}else{
	    	// json_rtn(-1000,$username);
			$data = array('username'=>$username,'passwd'=>$passwd);
		}

		// json_rtn(333,$data);
		$user = D('user');
		$res = $user->userlogin($data);
		// dump($res);exit;
		if($res){
			//设置session
			if(isset($_POST['remember'])){
				set_login($res,1);
			}else{
				set_login($res);
			}
			json_rtn(1,'登录成功',$res['username']);
		}else{

			json_rtn(0,$res['msg']);
		}
	}
    protected function passwd_encode($passwd){
    	return md5(base64_encode($passwd));

    }
    // protected function setLogin($user){
    	  
    // }
    public function logout(){
    	$this->setLogout();
    	header('location:'.U('index'));
    }
    protected function setLogout(){
    	cookies('userAuth', null);
        cookies('userAuth_sign', null);  
    }
}