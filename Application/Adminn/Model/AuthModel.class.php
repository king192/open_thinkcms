<?php
namespace Adminn\Model;
use Think\Model;

class AuthModel extends Model {

    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('name', 'require', '规则名称不能为空！', 1, 'regex', Model:: MODEL_BOTH ),
        array('module', 'require', '模块不能为空！', 1, 'regex', Model:: MODEL_BOTH ),
        array('controller', 'require', '控制器名称不能为空！', 1, 'regex', Model:: MODEL_BOTH ),
        array('action', 'require', '方法名称不能为空！', 1, 'regex', Model:: MODEL_BOTH ),
        array('module,controller,action', 'checkAction', '同样的记录已经存在！', 1, 'callback', Model:: MODEL_INSERT   ),
    	array('id,module,controller,action', 'checkActionUpdate', '同样的记录已经存在！', 1, 'callback', Model:: MODEL_UPDATE   ),
        array('parentid', 'checkParentid', '菜单只支持四级！', 1, 'callback', 1),
    );

       //验证action是否重复添加
    public function checkAction($data) {
        //检查是否重复添加
        $find = $this->where($data)->find();
        if ($find) {
            return false;
        }
        return true;
    }
    //验证action是否重复添加
    public function checkActionUpdate($data) {
    	//检查是否重复添加
    	$id=$data['id'];
    	unset($data['id']);
    	$find = $this->field('id')->where($data)->find();
    	if (isset($find['id']) && $find['id']!=$id) {
    		return false;
    	}
    	return true;
    }
        //验证菜单是否超出三级
    public function checkParentid($parentid) {
        $find = $this->where(array("id" => $parentid))->getField("parentid");
        if ($find) {
            $find2 = $this->where(array("id" => $find))->getField("parentid");
            if ($find2) {
                $find3 = $this->where(array("id" => $find2))->getField("parentid");
                if ($find3) {
                    return false;
                }
            }
        }
        return true;
    }
    /**
     * 获取全部规则
     * @return [type] [description]
     */
    public function getAll(){
    	return $this->select();
    }
    protected function _before_write(){

    }
}