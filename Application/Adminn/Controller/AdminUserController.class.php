<?php
namespace Adminn\Controller;
/**
 * 后台管理员管理控制器
 */
class AdminUserController extends BaseController {
	/**
	 * 管理员列表页
	 * @return [type] [description]
	 */
	public function get_user_list(){
		$m_user = D('User');
		$res = $m_user->alias('a')
		->join('__ADMIN_MEMBER__ b ON a.id = b.uid')
		->join('LEFT JOIN __ADMIN_BELONG_GROUP__ c ON b.uid = c.uid')
		->join('LEFT JOIN __ADMIN_GROUP__ d ON c.group_id = d.id')
		->field('a.id,a.username,b.is_allowed,d.group_name')->select();
		// dump($res);
		// //用户所在组
		// $group = M('AdminBelongGroup')->alias('a')
		// ->join('__ADMIN_GROUP__ b ON a.group_id = b.id')
		// ->field('a.uid,b.group_name')->select();
		// // trace(json_encode($group),'group','DEBUG');
		$this->assign('info',$res);
		$this->display();
	}
	/**
	 * 获取管理员列表
	 * @return void 
	 */
	public function get_list(){
		if(intval($_POST['uid'])>0){
			$this->edit_list();
		}else{
			$this->add_list();
		}
	}
	/**
	 * 仅仅获取管理组列表--添加
	 */
	protected function add_list(){
		$m_admin_group = D('AdminGroup');
		//获取管理组
		$res = $m_admin_group->field('id,group_name')->select();
		$str = <<<EOF
<div class="control-group">
<label class="control-label">管理组</label>
<div class="controls">
EOF;
		foreach ($res as $k => $v) {
			$str .= '<label><input name="group" type="checkbox" value="'.$v['id'].'" /><span class="lbl"> '.$v["group_name"].'</span></label>';
		}
		$str .= '</div></div>';
		$info = array('username'=>'','passwd'=>'','email'=>array());
    	// $menu = json_encode($menu);
		json_rtn(1,$str,$info);
	}
	/**
	 * 获取管理组列表及及所在组--编辑
	 * @return json [description]
	 */ 
	protected function edit_list(){
		// json_rtn(1,'ok','t');
		$uid = intval(I('post.uid'));
		//用户信息
		$info = M('User')->where(array('id'=>$uid))->field('username,email')->find();
		//获取所在组
		$group = M('AdminBelongGroup')->where(array('uid'=>$uid))->getField('group_id',true);//getField第二个参数为true获取uid的全部值并返回一维数组，数字为limit
		trace(json_encode($group),'grouppp','ERR');
		// exit;
		$m_admin_group = D('AdminGroup');
		//获取管理组
		$res = $m_admin_group->field('id,group_name')->select();
		$str = <<<EOF
<div class="control-group">
<label class="control-label">管理组</label>
<div class="controls">
EOF;
		foreach ($res as $k => $v) {
			if(in_array($v['id'], $group)){
				$str .= '<label><input name="group" type="checkbox" value="'.$v['id'].'" checked /><span class="lbl"> '.$v["group_name"].'</span></label>';
			}else{
				$str .= '<label><input name="group" type="checkbox" value="'.$v['id'].'" /><span class="lbl"> '.$v["group_name"].'</span></label>';
			}
		}
		$str .= '</div></div>';
		$info['passwd'] = '为空则不修改';
    	// $menu = json_encode($menu);
		json_rtn(1,$str,$info);
	}
	/**
	 * 添加编辑管理员路由
	 */
	public function admin_post(){
		if(intval($_POST['uid'])>0){
			$this->edit_admin_post();
		}else{
			$this->add_admin_post();
		}
	}
	/**
	 * 编辑管理员
	 * @return [type] [description]
	 */
	protected function edit_admin_post(){
		// $_POST['value'] = 'value';
		// trace($_POST['passwd'],'tttttttttttttttttttt','DEBUG');

		// $data = array(
		// 	'username'=>I('post.username'),
		// 	'email'=>I('post.email'),
		// 	);
			$data = array();
		if(empty($_POST['passwd'])){
			//unset跳过验证
			unset($_POST['passwd']);
		}else{
			$data['passwd'] = $passwd = \Vendor\my\User::passwd_encode($_POST['passwd']);
		}
		if(empty($_POST['username'])){
			unset($_POST['username']);
		}else{
			$data['username'] = I('post.username');
		}
		if(empty($_POST['email'])){
			unset($_POST['email']);
		}else{
			$data['email'] = I('post.email');
		}
		$_POST['username'] = 'admin124';
		trace(json_encode($data),'data','DEBUG');
		$m_user = D('User');
		$m_user->startTrans();
		//添加用户
		if(!$m_user->create()){
			json_rtn(-4,$m_user->getError());
		}
		if(count($data)>0){
			$uid = $m_user->where(array('id'=>intval($_POST['uid'])))->save($data);
			if(!$uid){
				json_rtn(-1,'更新失败');
			}
		}
		//删除所在组
		$m_admin_belong_group = D('AdminBelongGroup');
		$m_admin_belong_group->where(array('uid'=>intval($_POST['uid'])))->delete();
		$group_id_array = I('post.group');
		$data = array();
		foreach ($group_id_array as $k => $v) {
			$data[] = array('uid'=>intval($_POST['uid']),'group_id'=>$v);
		}
		if(count($data)<=0){
			$m_user->commit();
			json_rtn(3,'更新成功');
		}
		$res = $m_admin_belong_group->addAll($data);
		if(!$res){
			$m_user->rollback();
			json_rtn(-3,'更新失败');
		}
		$m_user->commit();
		json_rtn(2,'更新成功');
	}
	/**
	 * 添加管理员
	 */
	protected function add_admin_post(){
		$passwd = \Vendor\my\User::passwd_encode($_POST['passwd']);
		$data = array(
			'username'=>I('post.username'),
			'passwd'=>$passwd,
			'email'=>I('post.email'),
			);
		$m_user = D('User');
		$m_user->startTrans();
		//添加用户
		if(!$m_user->create()){
			json_rtn(-4,$m_user->getError());
		}
		$uid = $m_user->add($data);
		if(!$uid){
			json_rtn(-1,'添加失败');
		}
		//把用户加入管理员成员表
		$res = D('AdminMember')->add_member($uid);
		if(!$res){
			$m_user->rollback();
			json_rtn(-2,'添加失败');
		}
		//添加用户所属管理组
		if(!isset($_POST['group'])){
			$m_user->commit();
			json_rtn(1,'添加成功');
		}
		$group_id_array = I('post.group');
		$data = array();
		foreach ($group_id_array as $k => $v) {
			$data[] = array('uid'=>$uid,'group_id'=>$v);
		}
		$res = D('AdminBelongGroup')->addAll($data);
		if(!$res){
			$m_user->rollback();
			json_rtn(-3,'添加失败');
		}
		$m_user->commit();
		json_rtn(2,'添加成功');

	}


	/*-----------------------------------------------------*/
	/**
	 * 我的资料
	 * @return [type] [description]
	 */
	public function myself(){
		$userinfo = M('User')->where(array('a.id'=>LOGIN_ADMIN))->alias('a')
		->join('__ADMIN_MEMBER__ b ON a.id = b.uid')
		// ->join('LEFT JOIN __ADMIN_BELONG_GROUP__ c ON a.id = c.uid')
		->field('a.id,a.username,a.lastlgtm,a.credit,b.lastlgtm as admin_lg_tm')->find();
		$m_admin_belong_group = M('AdminBelongGroup');
		// $m_admin_belong_group->where(array('uid'=>LOGIN_ADMIN))->find(); 
		$group_name = $m_admin_belong_group->where(array('a.uid'=>LOGIN_ADMIN))->alias('a')
		->join('__ADMIN_GROUP__ b ON a.group_id = b.id')
		->field('b.group_name')
		->select();
		// dump($group_name);
		// exit;
// serialize(value)
		$data = array(
			'userinfo'=>$userinfo,
			'group_name'=>$group_name,
			);
		$this->assign($data);
		// dump($this->userinfo);
		$this->display();
	}
	/**
	 * 获取登录管理员的权限
	 * @return json [description]
	 */
	public function get_authority(){
		header('content-type:text/html;charset=utf-8');
		$m_admin_belong_group = M('AdminBelongGroup');
		$group = $m_admin_belong_group->where(array('a.uid'=>LOGIN_ADMIN))->alias('a')
		->join('LEFT JOIN __ADMIN_GROUP_ACTION__ b ON a.group_id = b.group_id')
		->field('b.auth_access_id')
		->select();
		// ->getField('b.auth_access_id',true);
		$group = \Vendor\my\ArraySort::array_multi_unique($group);//我的权限，二维数组
		foreach ($group as $k => $v) {
			$my_group[] = $v['auth_access_id'];
		}
		// dump($my_group);
		$auth_access_id = D('Auth')->getAll();
		if(!$auth_access_id){
			json_rtn(-1,'获取失败');
		}
		// dump($auth_access_id);
		foreach ($auth_access_id as $k => &$v) {
			if(in_array($v['id'], $my_group)){
				$my_auth[] = $v;
			}
		}
		json_rtn(1,'获取成功',$my_auth);
		// dump($my_auth);
		// dump($auth_access_id,true,'ddddd');
	}
}