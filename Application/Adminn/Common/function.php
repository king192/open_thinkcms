<?php

//登陆
function set_admin_login($user){
    // $cookieTime = 60*60*24*365; 
    // $auth = $user;
    $auth = array(
        'id'=>$user['id'],
        'username'=>$user['username'],
        'avatar'=>$user['avatar']?$user['avatar']:"",
        'lastlgtm'=>$user['lastlgtm']?$user['lastlgtm']:"",
        );
    // session('userAuth', $auth);
    // session('userAuth_sign', data_auth_signa($auth));  
    session('adminAuth', $auth);
    session('adminAuth_sign', dataAuthSigna($auth));
}
//退出登陆
function set_admin_logout(){
    // session('PHPSESSID',null);
    session('adminAuth',null);
    session('adminAuth_sign',null);
}
/**
 * 检测管理员是否登陆
 * @return boolean 
 */
function is_admin_login(){
   // if ( strtolower(MODULE_NAME) == 'admin') {
   //     return is_loginadmin();
   // }
   $user = session('adminAuth');
   // dump($user);
   if (empty($user)) {
   	// echo 1;
       return false;
   } else {
   	// echo 2;
       return session('adminAuth_sign') == dataAuthSigna($user) ? $user['id'] : false;
   }

}

/**
 * 检测验证码
 * @param  integer $id 验证码ID
 * @return boolean     检测结果
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function check_admin_verify($code, $id = 2){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}
/**
 * 检查管理员是否有访问权限
 * @param  number $admin_id 管理员uid
 * @return Boolean           
 */
function check_access($admin_id){
//查找所在组,如果找不到返回false
//查找是否存在规则（id），如果不存在，返回true，
//在所在组中查找是否存在相应的规则id，如果存在返回true，否则返回false
    $group = M('AdminBelongGroup')->where(array('uid'=>$admin_id))->getField('group_id',true);
    if(!$group){
      return false;
    }
    $auth_w = array('module'=>MODULE_NAME,'controller'=>CONTROLLER_NAME,'action'=>ACTION_NAME);
    $auth_id = M('Auth')->where($auth_w)->getField('id');
    if(!$auth_id){
      return true;
    }
    $group_action = M('AdminGroupAction');
    foreach ($group as $k => $v) {
      if($group_action->where(array('group_id'=>$v,'auth_access_id'=>$auth_id))->getField('id')){
        return true;
      }
    }
    return false;
}

function get_session_info($name){
    $c = session('adminAuth');
    return $c[$name];
}