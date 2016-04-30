<?php
namespace Square\Controller;
// use Think\Controller;
/**
 * 评论控制器,不需登陆
 */
class CommentsController extends PublicController{
	/**
	 * 根据文章id获取评论列表
	 * @return [type] [description]
	 */
	
	public function get_comments_list(){
		$p = isset($_POST['p'])?intval($_POST['p']):1;
		$limit = 3;
		$comments = M('Comments')->where(array('a.post_id'=>intval($_POST['post_id']),'parentid'=>0))->alias('a')
		->join('__USER__ b ON a.uid = b.id')
		->order('a.createtime desc')
		->field('a.*,b.username,b.avatar')
		->page($p,$limit)->select();
		// trace(json_encode($comments),'comments','DEBUG');
		json_rtn(1,'评论获取成功',$comments);
	}
	/**
	 * 根据评论id获取子评论
	 * @return [type] [description]
	 */
	public function get_by_id(){
		$p = isset($_POST['p'])?intval($_POST['p']):1;
		$limit = isset($_POST['limit'])?intval($_POST['limit']):3;
		$comments = M('Comments')->where(array('a.parentid'=>intval($_POST['parentid'])))->alias('a')
		->join('__USER__ b ON a.uid = b.id')
		->order('a.createtime desc')
		->field('a.*,b.username,b.avatar')
		->page($p,$limit)->select();
		json_rtn(1,'评论获取成功',$comments);
	}
}