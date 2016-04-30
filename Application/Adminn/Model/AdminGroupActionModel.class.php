<?php
namespace Adminn\Model;
use Think\Model;

class AdminGroupActionModel extends Model {

    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('group_id', 'require', '管理组id不能为空！', 1, 'regex', Model:: MODEL_BOTH ),
        // array('auth_access_id', 'require', '规则名称不能为空！', 1, 'regex', Model:: MODEL_BOTH ),
        // array('group_name,auth_access_id', 'checkAction', '规则id已经存在！', 1, 'callback', Model:: MODEL_INSERT   ),
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
}