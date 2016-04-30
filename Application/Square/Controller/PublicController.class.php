<?php
namespace Square\Controller;
use Think\Controller;

class PublicController extends Controller {
	public function _initialize(){
		define('UID', is_mlogin());
		// dump(UID);
		// dump(cookie('userAuth'));
		$user = cookie('userAuth');
		$real_user = get_user_info('lastlgtm');
		// dump($user['lastlgtm']);
		// dump();
		if($user['lastlgtm'] != $real_user['lastlgtm']){
			set_logout();
			// echo 'tm no';
			exit('您的账户已在其他地方登陆，请重新登录');

		}

	}
}