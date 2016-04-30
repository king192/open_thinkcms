<?php
namespace Adminn\Controller;
/**
 * 后台普通用户管理控制器
 */
class UserListController extends BaseController {
	/**
	 * 获取用户列表
	 * @return [type] [description]
	 */
	// public function get_user_list(){
	public function get_user_list(){
		$p = isset($_GET['p'])?intval($_GET['p']):1;
		$limit = 3;
		$m_user = M('user');
		$res = $m_user->field('id,username,lastlgtm,isdisabled,email,login_times,credit')
		->page($p,$limit)->select();
		$count = $m_user->count('id');
		$page = new \Vendor\my\Page($count,$limit);
		$data = array(
			'info'=>$res,
			'page'=>$page->show(),
			);
		// $this->assign('page',$page->show());
		// $this->assign('info',$res);
		$this->assign($data);
		$this->display();
	}
	public function get_list(){
		json_rtn(1,'ok');
	}


}