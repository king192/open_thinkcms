<?php
namespace Adminn\Controller;
use Vendor\my\Tree as Tree2;
// use Think\Controller;

class AuthController extends BaseController {
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
		$menu = $this->auth;
    	$menu = json_encode($menu);
    	$this -> assign('menu',$menu);
		$this -> display('Menu/get_menu');
	}
	/**
	 * 添加规则列表页
	 */
	public function add_auth(){
    	$tree = new Tree2();
    	$parentid = intval(I("get.parentid"));
    	// $result = $this->Menu->order(array("sort" => "ASC"))->select();
    	
   //  	$menu = $cate = array(
			// array('id'=>1,'name'=>'菜单管理','parentid'=>0,'sort'=>'1'),
			// array('id'=>2,'name'=>'后台菜单','parentid'=>1,'sort'=>'1'),
			// array('id'=>3,'name'=>'菜单列表','parentid'=>2,'sort'=>'2','module'=>'Adminn','controller'=>'Menu','action'=>'get_menu'),
			// array('id'=>4,'name'=>'添加菜单','parentid'=>2,'sort'=>'1','module'=>'Adminn','controller'=>'Menu','action'=>'add_menu'),
			// array('id'=>5,'name'=>'权限管理','parentid'=>0,'sort'=>'1'),
			// array('id'=>6,'name'=>'规则列表','parentid'=>5,'sort'=>'1'),
			// array('id'=>7,'name'=>'添加规则','parentid'=>5,'sort'=>'2'),
			// );
    	// $menu = array_merge($menu,$result);
    	foreach ($this->auth as $r) {
    		$r['selected'] = $r['id'] == $parentid ? 'selected' : '';
    		$array[] = $r;
    	}
    	$str = "<option value='\$id' \$selected>\$spacer \$name</option>";
    	$tree->init($array);
    	$select_categorys = $tree->get_tree(0, $str);
    	$this->assign("select_categorys", $select_categorys);
		$this -> display();
	}
	/**
	 * 添加规则列表
	 */
	public function add_auth_post(){
		$m_auth = D('Auth');
		if ($m_auth->create()) {
			if ($m_auth->add()!==false) {
				json_rtn(1,'添加成功');
			} else {
				json_rtn(-1,'添加失败');
			}
		} else {
			json_rtn(-2,$m_auth->getError());
		}
	}
	/**
	 * 删除
	 * @return [type] [description]
	 */
	public function del_post(){
		if($_SERVER['REQUEST_METHOD'] !== 'POST'){
			json_rtn(-1,'悟空，你又调皮了');
		}
        $id = intval(I("post.id"));
		$m_auth = D('Auth');
        $count = $m_auth->where(array("parentid" => $id))->count();
        if ($count > 0) {
            json_rtn(-2,"该菜单下还有子菜单，无法删除！");
        }
        if ($m_auth->delete($id)!==false) {
            json_rtn(1,"删除菜单成功！");
        } else {
            json_rtn(-3,"删除失败！");
        }
	}
	/**
	 * 编辑规则获取列表
	 * @return [type] [description]
	 */
	public function edit_get_post(){
        // import("Tree");
        $tree = new Tree2();
        $id = intval(I("post.id"));
        $rs = D('Auth')->where(array("id" => $id))->find();
        $result = D('Auth')->order(array("sort" => "ASC"))->select();
        foreach ($result as $r) {
        	$r['selected'] = $r['id'] == $rs['parentid'] ? 'selected' : '';
        	$array[] = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $tree->init($array);
        $select_categorys = $tree->get_tree(0, $str);
        $this->assign("data", $rs);
        $this->assign("select_categorys", $select_categorys);
        $info = $this->fetch('Ajax/menubody');
        json_rtn(1,$info);
	}
	/**
	 * 编辑规则提交
	 * @return [type] [description]
	 */
	public function edit_post(){
    	if (IS_POST) {
    		$m_auth = D('Auth');
    		if ($m_auth->create()) {
    			if ($m_auth->save() !== false) {
    				json_rtn(1,"更新成功！");
    			} else {
    				json_rtn(-1,"更新失败！");
    			}
    		} else {
    			json_rtn(-2,$m_auth->getError());
    		}
    	}
	}
}