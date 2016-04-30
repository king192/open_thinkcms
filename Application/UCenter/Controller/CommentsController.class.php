<?php
namespace UCenter\Controller;
// use Think\Controller;
/**
 * 评论控制器,需要登录权限
 */
class CommentsController extends UcPublicController{
	/**
	 * 提交一条评论
	 * @return [type] [description]
	 */
	public function send(){
		if(!isset($_POST['post_id'])){
			json_rtn(-4,'文章id必须');
		}
		$data = array(
			'post_id'=>intval($_POST['post_id']),
			'content'=>trim(I('post.content')),
			);
		$m_comment = D('Comments');
		if(!$m_comment->create($data)){
			json_rtn(-1,$m_comment->getError());
		}

		if(!check_verify($_POST['verify'])){
			json_rtn(-3,'验证码不正确');
		}
		$data['parentid'] = intval($_POST['parentid']);
		$data['to_uid'] = intval($_POST['to_uid']);
		$res = $m_comment->send($data);
		if($res){
			//返回评论信息
			$res = $m_comment->where(array('a.id'=>$res))->alias('a')
			->join('__USER__ b ON a.uid = b.id')
			->field('a.*,b.username')
			->select();
			json_rtn(1,'评论成功',$res);
		}
		json_rtn(-2,'评论失败');
	}
	/**
	 * 获取我的评论历史（首次评论或回复他人）
	 * @return [type] [description]
	 */
	public function get_list(){
		// header('content-type:text/html;charset=utf-8');
		$p = isset($_GET['p'])?intval($_GET['p']):1;
		$limit = 8;
		$m_comment = M('Comments');
		$res = $m_comment->where(array('a.uid'=>UID))->alias('a')
		->join('LEFT JOIN __COMMENTS__ b ON a.parentid = b.id')
		->join('LEFT JOIN __POSTS__ c ON a.post_id = c.id')
		->join('LEFT JOIN __USER__ d ON b.uid = d.id')
		->field('a.*,b.uid as replaytouid,b.content as replaytocontent,c.title as post_title,d.username')
		->page($p,$limit)
		->select();
		// dump($res);
		// exit;
		if(!$res){
			json_rtn(-1,'没有评论',array('info'=>'<span style="font-size:14px;font-weight:bold;">~^~木有数据~~~</span>','page'=>''));
		}
    	$data = array(
    		'comments'=>$res,
    		);
    	$this->assign($data);
    	$info = $this->fetch('Ajax/mycomments');

    	$total = $m_comment->where(array('uid'=>UID))->count('id');
    	$c_page = new \Vendor\my\Page1($total,$limit);
    	$page = $c_page->show();
    	$data = array(
    		'info'=>$info,
    		'page'=>$page,
    		);
		// dump($res);
		json_rtn(1,'获取数据成功',$data);
	}
	/**
	 * 回复我的，reply to me
	 * @return json [description]
	 */
	public function get_callme_list(){
		// header('content-type:text/html;charset=utf-8');
		$p = isset($_GET['p'])?intval($_GET['p']):1;
		$limit = 8;
		$m_comment = M('Comments');
		$res = $m_comment->where(array('a.to_uid'=>UID))->alias('a')
		->join('LEFT JOIN __COMMENTS__ b ON a.parentid = b.id')
		->join('LEFT JOIN __POSTS__ c ON a.post_id = c.id')
		->join('LEFT JOIN __USER__ d ON a.uid = d.id')
		->field('a.*,b.uid as myid,b.content as mycontent,c.title as post_title,d.username')
		//username 是别人的用户名
		->page($p,$limit)
		->select();
		// dump($res);exit;
		// exit;
		if(!$res){
			json_rtn(-1,'没有评论',array('info'=>'<span style="font-size:14px;font-weight:bold;">~^~木有数据~~~</span>','page'=>''));
		}
		//设为已读
		foreach ($res as $k => $v) {
			$id_array[] = $v['id'];
		}
		$map['id'] = array('in',$id_array);
		$m_comment->where($map)->setField(array('is_read'=>1));
		//设为已读end
    	$data = array(
    		'comments'=>$res,
    		);
    	$this->assign($data);
    	$info = $this->fetch('Ajax/callme');

    	$total = $m_comment->where(array('to_uid'=>UID))->count('id');
    	$c_page = new \Vendor\my\Page1($total,$limit);
    	$page = $c_page->show();
    	$data = array(
    		'info'=>$info,
    		'page'=>$page,
    		);
		// dump($res);
		json_rtn(1,'获取数据成功',$data);

	}
	/**
	 * 回复我的，reply to me
	 * @return json [description]
	 */
	public function get_callme_noread_list(){
		header('content-type:text/html;charset=utf-8');
		$p = isset($_GET['p'])?intval($_GET['p']):1;
		$limit = 8;
		$m_comment = M('Comments');
		$res = $m_comment->where(array('a.to_uid'=>UID,'a.is_read'=>0))->alias('a')
		->join('LEFT JOIN __COMMENTS__ b ON a.parentid = b.id')
		->join('LEFT JOIN __POSTS__ c ON a.post_id = c.id')
		->join('LEFT JOIN __USER__ d ON a.uid = d.id')
		->field('a.*,b.uid as myid,b.content as mycontent,c.title as post_title,d.username')
		//username 是别人的用户名
		->page($p,$limit)
		->select();
		// dump($id_array);exit;
		// exit;
		if(!$res){
			json_rtn(-1,'没有评论',array('info'=>'<span style="font-size:14px;font-weight:bold;">~^~木有数据~~~</span>','page'=>''));
		}
		//设为已读
		foreach ($res as $k => $v) {
			$id_array[] = $v['id'];
		}
		$map['id'] = array('in',$id_array);
		$m_comment->where($map)->setField(array('is_read'=>1));
		//设为已读end
    	$data = array(
    		'comments'=>$res,
    		);
    	$this->assign($data);
    	$info = $this->fetch('Ajax/callme');

    	$total = $m_comment->where(array('to_uid'=>UID,'is_read'=>0))->count('id');
    	$c_page = new \Vendor\my\Page1($total,$limit);
    	$page = $c_page->show();
    	$data = array(
    		'info'=>$info,
    		'page'=>$page,
    		);
		// dump($data);exit;
		json_rtn(1,'获取数据成功',$data);

	}
	public function set_read(){
		$id = intval($_POST['id']);
		$res = D('Comments')->set_read($id);
		if(!$res){
			json_rtn(-1,'设置失败');
		}
		json_rtn(1,'设置成功');
	}

}