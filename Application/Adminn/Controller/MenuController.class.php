<?php
namespace Adminn\Controller;
use Think\Controller;
use Vendor\my\Tree as Tree2;

class MenuController extends BaseController{
    protected $auth_rule_model;

    function _initialize() {
        parent::_initialize();
        // $this->auth_rule_model = D("Common/AuthRule");
    }

    public function get_menu(){
   //  	$menu = $cate = array(
			// array('id'=>1,'name'=>'菜单管理','parentid'=>0,'sort'=>'1'),
			// array('id'=>2,'name'=>'后台菜单','parentid'=>1,'sort'=>'1'),
			// array('id'=>3,'name'=>'菜单列表','parentid'=>2,'sort'=>'2','module'=>'Adminn','controller'=>'Menu','action'=>'get_menu'),
			// array('id'=>4,'name'=>'添加菜单','parentid'=>2,'sort'=>'1','module'=>'Adminn','controller'=>'Menu','action'=>'add_menu'),
			// array('id'=>5,'name'=>'权限管理','parentid'=>0,'sort'=>'1'),
			// array('id'=>6,'name'=>'规则列表','parentid'=>5,'sort'=>'1'),
			// array('id'=>7,'name'=>'添加规则','parentid'=>5,'sort'=>'2'),
			// );
		// $menu = $this->cate;
		$menu = $this->Menu->order(array("sort" => "ASC"))->select();
    	$menu = json_encode($menu);
    	$this -> assign('menu',$menu);
    	$this->display();
    }

	/**
	 * 新增菜单
	 */
	public function add_menu(){
    	// import("Tree");
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
    	foreach ($this->cate as $r) {
    		$r['selected'] = $r['id'] == $parentid ? 'selected' : '';
    		$array[] = $r;
    	}
    	$str = "<option value='\$id' \$selected>\$spacer \$name</option>";
    	$tree->init($array);
    	$select_categorys = $tree->get_tree(0, $str);
    	$this->assign("select_categorys", $select_categorys);
    	$this->display();
	}

    /**
     *  添加菜单
     */
    public function add_post() {
    	if (IS_POST) {
    		// json_rtn(-99,LOGIN_ADMIN);
    		$_POST['uid'] = LOGIN_ADMIN;
    		if ($this->Menu->create()) {
    			if ($this->Menu->add()!==false) {
    				json_rtn(1,'添加成功');
    			} else {
    				json_rtn(-1,'添加失败');
    			}
    		} else {
    			json_rtn(-2,$this->Menu->getError());
    		}
    	}
    }

	/**
	 * 删除菜单
	 * @return [type] [description]
	 */
	public function del_post(){
		if($_SERVER['REQUEST_METHOD'] !== 'POST'){
			json_rtn(-1,'悟空，你又调皮了');
		}
        $id = intval(I("post.id"));
        $count = $this->Menu->where(array("parentid" => $id))->count();
        if ($count > 0) {
            json_rtn(-2,"该菜单下还有子菜单，无法删除！");
        }
        if ($this->Menu->delete($id)!==false) {
            json_rtn(1,"删除菜单成功！");
        } else {
            json_rtn(-3,"删除失败！");
        }
	}
	/**
	 * 编辑菜单
	 * @return [type] [description]
	 */
	public function edit_menu(){
        // import("Tree");
        $tree = new Tree2();
        $id = intval(I("get.id"));
        $rs = $this->Menu->where(array("id" => $id))->find();
        $result = $this->Menu->order(array("sort" => "ASC"))->select();
        foreach ($result as $r) {
        	$r['selected'] = $r['id'] == $rs['parentid'] ? 'selected' : '';
        	$array[] = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";
        $tree->init($array);
        $select_categorys = $tree->get_tree(0, $str);
        $this->assign("data", $rs);
        $this->assign("select_categorys", $select_categorys);
        $this->display('add_menu');
	}
	/**
	 * 编辑菜单获取数据
	 * @return [type] [description]
	 */
	public function edit_get_post(){
        // import("Tree");
        $tree = new Tree2();
        $id = intval(I("post.id"));
        $rs = $this->Menu->where(array("id" => $id))->find();
        $result = $this->Menu->order(array("sort" => "ASC"))->select();
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
     *  编辑菜单更新数据
     */
    public function edit_post() {
    	if (IS_POST) {
    		if ($this->Menu->create()) {
    			if ($this->Menu->save() !== false) {
    				json_rtn(1,"更新成功！");
    			} else {
    				json_rtn(-1,"更新失败！");
    			}
    		} else {
    			json_rtn(-2,$this->Menu->getError());
    		}
    	}
    }

}