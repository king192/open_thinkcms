<?php
namespace Adminn\Controller;
/**
 * 后台管理组管理控制器
 */
class AdminGroupController extends BaseController {
	protected $auth = array();
    function _initialize() {
        parent::_initialize();
        $res = D('Auth')->order(array("sort"=>"ASC"))->select();
        if($res){
        	$this->auth = $res;
        }
    }
	/**
	 * 获取规则列表
	 * @return void 
	 */
	public function get_list(){
		if(intval($_POST['group_id'])>0){
			$this->edit_list();
		}else{
			$this->add_list();
		}
	}
	/**
	 * 仅仅获取规则列表--添加
	 */
	protected function add_list(){
		$menu = $this->auth;
		$info = array('group_name'=>'','remark'=>'','auth_id'=>array());
    	$menu = json_encode($menu);
		json_rtn(1,$menu,$info);
	}
	/**
	 * 获取规则列表及组信息和组权限--编辑
	 * @return [type] [description]
	 */ 
	protected function edit_list(){
		$group_id = intval($_POST['group_id']);
		$m_admin_group = D('AdminGroup');
		$m_admin_group_action = D('AdminGroupAction');
		$auth_access_id = $m_admin_group_action->where(array('group_id'=>$group_id))->getField('auth_access_id',true);
		// json_rtn(-999,$auth_access_id);
		$info = $m_admin_group->find($group_id);
		$info['auth_id'] = $auth_access_id?$auth_access_id:array();
		$menu = $this->auth;
				// trace($auth_access_id,'ddddddddd','ERR');
		foreach ($menu as $d => &$v) {
			if(in_array($v['id'],$auth_access_id)){
				// trace($v['id'],'tttttttttt','ERR');
				$v['checked'] = true;
			}
		}
    	$menu = json_encode($menu);
		json_rtn(1,$menu,$info);
	}
	/**
	 * 获取用户组
	 * @return void 
	 */
	public function get_group_list(){
		$m_admin_group = D('AdminGroup');
		$res = $m_admin_group->field('id,group_name,remark')->select();
		$this->assign('info',$res);
		// dump($res);
		$this->display();
	}

	/**
	 * 添加管理组路由
	 * @return [type] [description]
	 */
	public function group_post(){
		if(intval($_POST['group_id'])>0){
			$this->edit_group_post();
		}else{
			$this->add_group_post();
		}
	}
	/**
	 * 编辑管理组权限
	 * @return json 
	 */
	protected function edit_group_post(){
		// json_rtn(-99,$_POST);
		$m_admin_group = D('AdminGroup');
		$m_admin_group->startTrans();
		// if(!$m_admin_group->create()){
		// 	json_rtn(-1,$m_admin_group->getError());
		// }
		$data["group_name"] = $_POST['group_name'];
		$data["remark"] = $_POST['remark'];
		$data["uid"] = LOGIN_ADMIN;
		$data["ctime"] = time();
		$group_id = intval($_POST['group_id']);
		$res = $m_admin_group->where(array('id'=>$group_id))->save($data);
		trace($res,'组id','ERR');
		if(!$res){
			$m_admin_group_action->rollback();
			json_rtn(-2,'修改失败');
		}
		$auth_id_array = array();
		if(isset($_POST['auth_id'])){
			$auth_id_array = $_POST['auth_id'];
		}
		trace($auth_id_array,'datatattata','ERR');
		$m_admin_group_action = D('AdminGroupAction');
		//清空组下的规则
		$m_admin_group_action->where(array('group_id'=>$group_id))->delete();
		$data = array();
		if(count($auth_id_array)<=0){
			$m_admin_group->commit();
			json_rtn(1,'修改成功');
		}
		foreach ($auth_id_array as $k => $v) {
			$data[] = array('group_id'=>$group_id,'auth_access_id'=>$v);
		}
		// $_POST['group_id'] = $group_id;
		// json_rtn(-9,$group_id);
		if(!$m_admin_group_action->create()){
			$m_admin_group->rollback();
			json_rtn(-3,$m_admin_group_action->getError());
		}
		if($m_admin_group_action->addAll($data) === false){
			$m_admin_group->rollback();
			json_rtn(-4,'修改失败');
		}
		$m_admin_group->commit();
		json_rtn(2,'修改成功');
	}
	/**
	 * 添加管理组提交
	 * @return  json 
	 */
	protected function add_group_post(){
		// json_rtn(-99,$_POST);
		$m_admin_group = D('AdminGroup');
		$m_admin_group->startTrans();
		if(!$m_admin_group->create()){
			json_rtn(-1,$m_admin_group->getError());
		}
		$data["group_name"] = $_POST['group_name'];
		$data["remark"] = $_POST['remark'];
		$data["uid"] = LOGIN_ADMIN;
		$data["ctime"] = time();
		$group_id = $m_admin_group->add($data);
		if(!$group_id){
			json_rtn(-2,'添加失败');
		}
		$auth_id_array = array();
		if(isset($_POST['auth_id'])){
			$auth_id_array = $_POST['auth_id'];
		}
		$data = array();
		if(count($auth_id_array)<=0){
			$m_admin_group->commit();
			json_rtn(1,'添加成功');
		}
		foreach ($auth_id_array as $k => $v) {
			$data[] = array('group_id'=>$group_id,'auth_access_id'=>$v);
		}
		$_POST['group_id'] = $group_id;
		// json_rtn(-9,$group_id);
		$m_admin_group_action = D('AdminGroupAction');
		if(!$m_admin_group_action->create()){
			$m_admin_group->rollback();
			json_rtn(-3,$m_admin_group_action->getError());
		}
		if($m_admin_group_action->addAll($data) === false){
			$m_admin_group->rollback();
			json_rtn(-4,'添加失败');
		}
		$m_admin_group->commit();
		json_rtn(2,'添加成功');
	}
	/**
	 * 删除管理组
	 * @return json
	 */
	public function del_group(){
		$group_id = intval(I('post.group_id'));
		$m_admin_group = M('AdminGroup');
		$m_admin_group->startTrans();
		// trace($group_id,'group_id','ERR');
		$res = $m_admin_group->delete($group_id);//主键
		if(!$res){
			json_rtn(-1,'删除失败');
		}
		$m_admin_group_action = M('AdminGroupAction');
		$res = $m_admin_group_action->find($group_id);
		//如果存在则删除
		if($res){
			$res = $m_admin_group_action->where(array('group_id'=>$group_id))->delete();
			if(!$res){
				$m_admin_group->rollback();
				json_rtn(-2,'删除失败');
			}
		}
		$m_admin_group->commit();
		json_rtn(1,'删除成功');
	}
}