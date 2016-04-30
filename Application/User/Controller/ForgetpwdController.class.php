<?php
namespace User\Controller;
use Think\Controller;

class ForgetpwdController extends Controller{
	public function index(){
		$this->assign('title','找回密码');
		$this->display();
	}
  protected function valid($uid=null,$token = null){
    $uid = empty($_GET['uid'])?$uid:$_GET['uid'];
    $token = empty($_GET['token'])?$token:$_GET['token'];
    $token = think_decrypt($token,'ju58t5t89tmbfki549fj4a2lbm5');
    if(!$token){
      json_rtn(-1,'重置链接已过期');
    }
    $m_user = D('user');
    $res = $m_user->verify_token($uid,$token);
    // json_rtn(888,$res,$token);
    if(!$res){
      // $this->error('');
      json_rtn(0,'无效的重置链接');
    }
  }
	//发送随机密码
	public function randompwd(){
    $this->valid();

    $String = new \Org\Util\String();
    $newpwd = $String->randString(8);
    $m_user = D('user');

    $res = $m_user->randompwd($_GET['uid'],$newpwd);
    if($res){
      $title = C('WEB_NAME')."重置密码";
      $content = $buseremail."尊敬的客户您好！您的密码为".$newpwd;
      if(send_email($res,$title,$content)){
          // json_rtn(1,'已成功重置密码，请登陆邮箱查看密码',$res);
        $this->success('已成功重置密码，请登陆邮箱查看密码');
      }else{
          // json_rtn(0,'密码重置链接发送失败','');
        $this->error('密码重置邮件发送失败');
      }
    }else{
      $this->error('密码重置失败');
    }
	}
  /**
   * 自定义密码重置--验证
   *
   */
  public function diypwd(){
    $this->valid();
    // echo 'ok';
    cookie('enc_uid',I('uid'));
    $this->display();
  }
  //自定义密码重置--改密
  public function diy_resetpwd(){
    $enc_uid = cookie('enc_uid');
    $this->valid($enc_uid,I('post.token'));
    $newpwd = $_POST['newpwd'];
    if(strlen($newpwd)<6 || strlen($newpwd)>20)
      json_rtn(-1,'请输入6到20位的密码');
    $m_user = D('user');
    $m_user -> diy_resetpwd($enc_uid,$newpwd);

    // json_rtn(1,intval($uid));
  }
	//发送密码重置链接,此处要对uid进行加密处理
	public function reset_link(){
    if(!check_verify($_POST['verify'])){
      json_rtn(-1,'验证码不正确');
    }
    $res = $this->get_token(I('userid'));
    $token = $res['token'];
    $token = think_encrypt($token,'ju58t5t89tmbfki549fj4a2lbm5',60*60*24);
    if($_POST['method']=='random'){
      $url = U('randompwd',array('uid'=>$res['uid'],'token'=>$token));
    }else{
      $url = U('diypwd',array('uid'=>$res['uid'],'token'=>$token));
    }
    $title = C('WEB_NAME')."重置密码链接";
    $content = $buseremail."尊敬的客户您好！请点击此链接进行密码重置：http://".$_SERVER['HTTP_HOST'].$url." ,请在24小时内完成密码重置，如果不是您本人所为请忽略，感谢您的关注!";
    if(send_email($res['email'],$title,$content)){
        json_rtn(1,'密码重置链接发送成功,请24小时内完成密码重置','');
    }else{
        json_rtn(0,'密码重置链接发送失败','');
    }
	}
  protected function get_token($userid) {
    if(strpos($userid,"@")>0){//邮箱
      $userid = array('email'=>$userid);
    }else{
      $userid = array('username'=>$userid);
    }
    return D('user')->get_token($userid);
  	
  }


    /**
      * @author 1434970057@qq.com
      */
     public function resetpwd(){
            $paramArr['buseremail'] = $buseremail = I('buseremail');
			$paramArr['token'] = I('token');
            // 商家登陆
            $url = C('UC_DOMAIN')."/index.php?m=home&c=Busman&a=do_resetpwd";
            $data = http_build_query($paramArr);
            $res = json_decode(do_post_request($url,$data),true);
			if($res['rtn']==-4||$res['rtn']==-5) {
				$this->error($res['msg'],U('Mob/Login/getToken'),5);
			}
      $webName = C('WEB_NAME');
            // 发送邮件激活码
            if ($res['rtn']>0) {
                $title = $webName."重置密码";
                $content = $buseremail."尊敬的客户您好！".$webName."随机生成8位密码：".$res['data'].",感谢您的关注!";
                if(sendMail($buseremail,$title,$content)){
					$this->success('发送密码成功',U('Mob/Login/loginBusman'),5);
                }else{
					$this->error($res['msg'],U('Mob/Login/getToken'),5);
                }
            }else{
				$this->error($res['msg'],U('Mob/Login/getToken'),5);
            }
     }

}