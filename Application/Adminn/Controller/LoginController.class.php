<?php
namespace Adminn\Controller;
use Think\Controller;

class LoginController extends Controller {
	public function _initialize(){
		if(ACTION_NAME !== 'logout'){
			if(is_admin_login()){
				header('location:'.U('Admin/index'));
				exit('login allready!');
			}
		}
	}
	public function index(){
    	$this->assign('title','爱游思后台管理');
		$this->display();
	}
	public function login(){
		if(!check_admin_verify(I('verify'))){
			json_rtn(-1,'验证码错误');
		}
		//数据库取数据，如果一致通过 
		$username = I('username');
		// json_rtn(-1000,$username);
		$passwd = $_POST['passwd'];
		// empty($username) && json_rtn(-1,'用户名不能为空');
		// empty($passwd) && json_rtn(-2,'密码不能为空');
		$passwd = \Vendor\my\User::passwd_encode($passwd);
		$data = array('username'=>$username,'passwd'=>$passwd);

		// json_rtn(333,$data);
		$user = D('user');
// if (!$user->create()){ // 登录验证数据
//      // 验证没有通过 输出错误提示信息
//      json_rtn(-1,$user->getError());
// }
		$res = $user->login($data);
		// dump($res);exit;
		if($res){
			//设置session
			set_admin_login($res);
			json_rtn(1,'登录成功',$res['username']);
		}else{

			json_rtn(0,'用户名或密码不正确！！！');
		}
	}

    /* 验证码，用于登录和注册 */
    public function verify(){
      $config =    array(
            'fontSize'    =>    16,    // 验证码字体大小
            'length'      =>    7,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
            'useCurve'    =>    false, // 关闭混淆曲线
            // 'bg'          =>  array(255, 255, 255),        // 关闭验证码背景颜色
        );
        $verify = new \Think\Verify($config);
        $verify->entry(2);
    }
    public function logout(){
    	set_admin_logout();
    	header('location:'.U('Adminn/Login/index'));
    }
}