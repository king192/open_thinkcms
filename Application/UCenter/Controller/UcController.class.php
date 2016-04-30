<?php
namespace UCenter\Controller;

class UcController extends UcPublicController{
	public function index(){
        // dump('test'.UID);
		$m_user = D('user');
		$userinfo = $m_user->get_user_info(UID,'username,email,phone');
		$this->assign('userinfo',$userinfo);
		// dump($userinfo);
		$this->assign('title','用户中心');
		$this->display();
	}
	//每日签到
	public function sign(){
		$uid = UID;
		$sign = D('Sign');
        $sign -> startTrans();
		$credit = 2;//一倍积分
		//是否连续签到
		$info = $sign -> info($uid);
        //
		if(!$info){
			$res = $sign -> addd($uid);
            if(!$res){
                $sign -> rollback();
                json_rtn(-1,'签到失败');
            }
			// $this->credit($uid,$credit);
            $res = D('Common/Credit') -> inc_credit(UID,1,$credit);
            // trace('////'.$res,'credittttttt','ERR');
            if(!$res){
                $sign -> rollback();
                json_rtn(-1,'签到失败');
            }
            $sign -> commit();
			$array = array('credit'=>$credit,'sign_num'=>0);//sign_num 前端+1
            $credit = $info['sign_num']+1;
            json_rtn(1,'签到成功,您已连续签到'.$credit.'天,本次签到获得'.$credit.'积分',$array);
		}
		// json_rtn(-999,$info,time()-$info['sign_tm']);
		$now_tm = date('Ymd',time());
		$last_tm = date('Ymd',$info['sign_tm']);
		if(($now_tm == $last_tm)){//连续签到1天内
			json_rtn(-1,'您今天已经签过了');
		}elseif(((int)str_replace('/','',$now_tm) - (int)str_replace('/','',$last_tm) > 2)){
			//签到时间已超过2天,即非连续签到
			$data = array('sign_num'=>1,'sign_tm'=>time());
			$info['sign_num'] = 0;//重置天数（前端显示）
		}else{
			//判断是否7天以上签到
			if($info['sign_num'] > 6){//$info['sign_num'] + 1 > 7 的简化，$info['sign_num']是前面的签到次数，+1是今天的
				//获得4倍金币
				$credit *= 4;
			}elseif($info['sign_num'] > 2){
				//是否3天以上,获得双倍金币
				$credit *= 2;
			}
			$data = array(
				'sign_num'	=> $info['sign_num'] + 1,
				'sign_tm'	=> time(),
				);
		}
		$res = $sign -> updata($uid,$data);
        if(!$res){
            $sign -> rollback();
            json_rtn(-1,'签到失败');
        }
		// $this->credit($uid,$credit);
        $res = D('Common/Credit') -> inc_credit(UID,1,$credit);
        // trace('////'.$res,'credittttttt','ERR');
        if(!$res){
            $sign -> rollback();
            json_rtn(-1,'签到失败');
        }
        $sign -> commit();
		$array = array('credit'=>$credit,'sign_num'=>$info['sign_num']);//sign_num前端+1处理
        $credit = $info['sign_num']+1;
		json_rtn(1,'签到成功,您已连续签到'.$credit.'天,本次签到获得'.$credit.'积分',$array);
	}
	public function profile(){
		// dump(get_user_info(UID));
		// dump(cookie('userAuth'));
		$this->assign('title','账户设置');
		$this->display();
	}
	public function get_base(){
		$this->assign('userinfo',get_user_info('username,email,phone'));
		$info = $this->fetch('Ajax/base');
        // $info = $this -> $userinfo;
		json_rtn(1,'ok',$info);
	}
    public function get_detail(){
        // $info = M('User')->where(array('id'=>UID))->field('id,username,sex,url,birthday,about,lastlgtm,lastip,login_times,credit')->find();
        // $data = array(
        //     'info',$info,
        //     );
        $info = get_user_info('id,username,sex,url,birthday,about,lastlgtm,lastip,login_times,credit');
        // dump($info);exit;
        $this->assign('info',$info);
        $data = $this->fetch('Ajax/detail');
        json_rtn(1,'ok',$data);
    }
    public function feedback(){
        $info = $this->fetch('Ajax/feedback');
        json_rtn(1,'ok',$info);
    }
    public function msg(){
        $info = $this->fetch('Ajax/msg');
        json_rtn(1,'ok',$info);
    }
	public function get_avatar(){
		$info = $this->fetch('Ajax/avatar');
		json_rtn(1,'ok',$info);
	}
	public function load_avatar(){
		$info = $this->fetch('Ajax/avatar_window');
		json_rtn(1,'ok',$info);
	}
    public function mod_passwd(){
        $info = $this->fetch('Ajax/passwd');
        json_rtn(1,'ok',$info);
    }

    public function upload_avatar() {
        // if(defined('local')){
        if(true){
            //本地环境
    	   $this->local_up_avatar();
        }else{
            //sae环境
            $this->sae_up_avatar();
        }
    }
    protected function sae_up_avatar(){
                    // $st =   new \SaeStorage();
                    // $domain = $st->getDomainCapacity('public');
                    // json_rtn(333,$domain);

        $base_info = $_POST['base_img'];
        $base64Len = $_POST['base64Len'];

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base_info, $result)) {
            $type = $result[2];
            $rand = rand(100, 999);
            $pics = date("YmdHis") . $rand . "." . $type;
            //add by yangyong 2015-5-21 10:02:42 控制图片格式 start
            if (!in_array(strtolower($type), array('gif', 'jpg', 'png', 'jpeg','bmp'))) {
                json_rtn(-12, '不支持' . $type . '的图片格式');
            }
            //add by yangyong 2015-5-21 10:02:42 控制图片格式 end
            $path = SAE_TMP_PATH;
            $pic_path = $path . $pics;
            if (file_put_contents($pic_path, base64_decode(str_replace($result[1], '', $base_info)))) {
        //          $image = new \Think\Image();
        // $image->open($pic_path);
        // $image->crop($targ_w, $targ_h,$x,$y);
        // $image->save($pic_path);

                // json_rtn(-999,'头像上传成功',$pic_path);
                // $img = new imageApi(); //实例化
//              $img->thumb($pic_path, C('GOODSIMG_MAX_W'), C('GOODSIMG_MAX_H'));

                //
                // json_rtn(111,array($pic_path,$targ_w,$targ_h,$x,$y));
                $targ_w = intval(I('post.w'));
                $targ_h = intval(I('post.h'));
                $x = I('post.x');
                $y = I('post.y');
                $res = $this->_img_crop($pic_path,$targ_w,$targ_h,$x,$y);
                // json_rtn(888,$res);
                // json_rtn(333,$pic_path,'');
                // $file['fig'] = up_img_to_remote($pic_path);
                if($res){
                //fwrite(fopen('/tmp/22222222','w'), var_export($result,true)) ;
                /*if(is_busmLogin() == 4) {
                    fwrite(fopen('/tmp/kkkkkkkk','w'), var_export($_POST,true)) ;
                }*/
                    // $pic_path = 'http://'.$_SERVER['HTTP_HOST'].'/'.$pic_path;
                    $filename = 'avatar/'.time().$type;
                    $st =   new \SaeStorage();
                    // $st = new \Org\Util\String();
                    // $domain = $st->getDomainCapacity('public');
                    // json_rtn(333,$st);
                    if(!$st->upload('public',$filename,$pic_path)){
                        json_rtn(-999,'upload fail');
                    }
                    $return_path = 'http://thinkfortest-public.stor.sinaapp.com/'.$filename;
                    $res = $this->save_path($return_path);
                    if($res){
                        re_set_login(array('avatar'=>$pic_path));
                        json_rtn(1, date("YmdHis") . $rand, $return_path) ;
                    }else{
                        json_rtn(-3,'头像保存失败');
                    }
                } else {
                    json_rtn(-1, '上传图片失败') ;
                }
            } else {
                //fwrite(fopen('/tmp/22222222','w'), var_export($_POST,true)) ;
                json_rtn(-2, '上传图片失败') ;
            }
        }
        // json_rtn(124,$st,SAE_TMP_PATH);

    }
    protected function local_up_avatar($up_pathimg='avatar'){
        // json_rtn(-999,$_POST['base_img']);
        // json_rtn(999,I(''));
        $targ_w = intval(I('post.w'));
        $targ_h = intval(I('post.h'));
        $x = I('post.x');
        $y = I('post.y');
        // $local_path = I('post.local_path');
        // $UpArr['fig'] = $this -> _img_crop($local_path,$targ_w,$targ_h,$x,$y);
        // if( !$UpArr['fig']){
        //     msgCookie(0,'图片上传失败');
        // }
        // 图片路径 按时间
        // json_rtn(666,$x,'');
        // $upY = date('Y');
        // $upM = date('m');
        // $upD = date('d');
        //上传路径
        $path = "Uploads/" . $up_pathimg . "/" . date('Y/m/d',time());
        if (!file_exists($path)) {
            @mkdir($path, 0777, true);
        }
        $thumb_path = "Uploads/" . $up_pathimg . "/thumb/" . date('Y/m/d',time());
        if (!file_exists($thumb_path)) {
            @mkdir($thumb_path, 0777, true);
        }

        //调试用户
        /*if(is_busmLogin() == 4) {
            fwrite(fopen('/tmp/oooo','w'), var_export($_POST,true)) ;
        }*/

        //接收base64编码数据
        $base_info = $_POST['base_img'];
        // $base64Len = $_POST['base64Len'];

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base_info, $result)) {
            $type = $result[2];
            $rand = rand(100, 999);
            $pics = date("YmdHis") . $rand . "." . $type;
            //add by yangyong 2015-5-21 10:02:42 控制图片格式 start
            if (!in_array(strtolower($type), array('gif', 'jpg', 'png', 'jpeg','bmp'))) {
                json_rtn(-12, '不支持' . $type . '的图片格式');
            }
            //add by yangyong 2015-5-21 10:02:42 控制图片格式 end
            $pic_path = $path . $pics;
            $thumb_path = $thumb_path.$pics;
            if (file_put_contents($pic_path, base64_decode(str_replace($result[1], '', $base_info)))) {
        //          $image = new \Think\Image();
        // $image->open($pic_path);
        // $image->crop($targ_w, $targ_h,$x,$y);
        // $image->save($pic_path);

                // json_rtn(-999,'头像上传成功',$pic_path);
                // $img = new imageApi(); //实例化
//              $img->thumb($pic_path, C('GOODSIMG_MAX_W'), C('GOODSIMG_MAX_H'));
// trace($pic_path,'test1','DEBUG');
                //
                // json_rtn(111,array($pic_path,$targ_w,$targ_h,$x,$y));
                $res = $this->_img_crop($pic_path,$targ_w,$targ_h,$x,$y,$thumb_path);
                // json_rtn(888,$res);
                // json_rtn(333,$pic_path,'');
                // $file['fig'] = up_img_to_remote($pic_path);
                if($res){
                //fwrite(fopen('/tmp/22222222','w'), var_export($result,true)) ;
                /*if(is_busmLogin() == 4) {
                    fwrite(fopen('/tmp/kkkkkkkk','w'), var_export($_POST,true)) ;
                }*/
                    $res = $this->save_path($pic_path);
                    if($res){
                        re_set_login(array('avatar'=>$pic_path));
                        $pic_path = 'http://'.$_SERVER['HTTP_HOST'].'/'.$pic_path;
                        json_rtn(1, date("YmdHis") . $rand, $pic_path) ;
                    }else{
                        json_rtn(-3,'头像保存失败');
                    }
                } else {
                    json_rtn(-1, '上传图片失败') ;
                }
            } else {
                //fwrite(fopen('/tmp/22222222','w'), var_export($_POST,true)) ;
                json_rtn(-2, '上传图片失败') ;
            }
        }
    }
    protected function _img_crop($path,$targ_w,$targ_h,$x,$y,$thumb_path){
        //图片处理
        // $path = str_replace('http://'.$_SERVER['HTTP_HOST'].'/', '', $path);
        $image = new \Think\Image();
        $image->open($path);
        $image->crop($targ_w, $targ_h,$x,$y)->save($path);
        // $image->save($path);
        // $image->open($path);
// trace($path,'test2','DEBUG');
        $image->thumb(80, 80,\Think\Image::IMAGE_THUMB_CENTER)->save($thumb_path);
        // $image->save($path);
// trace($thumb_path,'test3','DEBUG');
        return true;

        //上传至远程
        // return up_img_to_remote($path);
    }
    protected function save_path($path){
        return D('user')->update_user(UID,array('avatar'=>$path));
    }
    public function get_sign(){
        $info = $this->fetch('Ajax/sign');
        json_rtn(1,'ok',array('info'=>$info,'page'=>''));
    }
}