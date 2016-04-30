<?php
namespace Adminn\Model;
use Think\Model;

class UserModel extends Model{    //自动验证
    // protected $_validate = array(
    //     //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
    //     array('name', 'require', '菜单名称不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
    //     array('app', 'require', '应用不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
    //     array('model', 'require', '模块名称不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
    //     array('action', 'require', '方法名称不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
    //     array('app,model,action', 'checkAction', '同样的记录已经存在！', 1, 'callback', CommonModel:: MODEL_INSERT   ),
    // 	array('id,app,model,action', 'checkActionUpdate', '同样的记录已经存在！', 1, 'callback', CommonModel:: MODEL_UPDATE   ),
    //     array('parentid', 'checkParentid', '菜单只支持四级！', 1, 'callback', 1),
    // );
    protected $_validate = array(
    		array('username','require','用户名不能为空！！！',0,'regex',Model::MODEL_BOTH),
            array('username','6,20','用户名长度需要在6到20位',0,'length',Model::MODEL_BOTH),
    		array('passwd','require','密码不能为空',0,'regex',Model::MODEL_INSERT),
            array('passwd','6,20','密码长度需要在6到20位',0,'length',Model::MODEL_BOTH),
            array('username','','用户名已经存在！',0,'unique',Model:: MODEL_BOTH ), // 验证user_login字段是否唯一
            array('email','email','邮箱格式不正确！',0,'',Model:: MODEL_BOTH ), // 
            array('email','','邮箱帐号已经存在！',0,'unique',Model:: MODEL_BOTH ), // 
            // array('value','require','ok',2),
    	);
	public function login($data=array()){
        //user表和admin_member表同时存在记录则为管理员
		$res = $this->where($data)->alias('a')
        ->join('__ADMIN_MEMBER__ b ON a.id = b.uid')
        ->field('a.id,a.username,a.avatar')
        ->find();
		if($res){
			// return json_r(1,'通过验证',$res,'',false);
			$new_tm = time();
			$this->where(array('id'=>$res['id']))->save(array('lastlgtm'=>$new_tm,'lastip'=>get_client_ip()));
			$res['lastlgtm'] = $new_tm;
			return $res;
		}else{
			json_rtn(-1,'用户名或密码不正确');
		}
	}
    /**
     * 后台添加用户
     * @param array $data [description]
     */
    public function add_user($data=array()){
        $data['regtm'] = time();
        $data['platform'] = 5;
        return $this->add($data);
    }
}