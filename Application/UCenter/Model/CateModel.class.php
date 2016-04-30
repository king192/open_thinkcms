<?php
namespace UCenter\Model;
use Think\Model;

class CateModel extends Model{
        //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('name', '', '分类名已经存在', 0, 'unique', Model:: MODEL_INSERT ),
        // array('post_id', 'require', '要评论的文章id不存在', 1, 'regex', Model:: MODEL_INSERT ),
        );
	public function get_cate(){
		$cate = F('cate');
		if(!$cate){
			$cate = $this->where(array('status'=>1))->order('sort')->select();
			if(!$cate){
				return false;
			}
			F('cate',$cate);
		}
		return $cate;
	}
    /**
     * 后台有更新/编辑则删除缓存
     * @param type $data
     */
    public function _before_write(&$data) {
        parent::_before_write($data);
        F("cate", NULL);
    }

    //删除操作时删除缓存
    public function _after_delete($data, $options) {
        parent::_after_delete($data, $options);
        $this->_before_write($data);
    }
    /**
     * 添加一个分类
     * @param array $data [description]
     */
    public function add_cate($data = array()){
        $data['uid'] = UID;
        return $this->add($data);
    }
}
