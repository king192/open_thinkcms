<?php
namespace UCenter\Model;
use Think\Model;

class CommentsModel extends Model {

    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('content', '6,500', '请输入6到500字的评论内容', 1, 'length', Model:: MODEL_INSERT ),
        // array('post_id', 'require', '要评论的文章id不存在', 1, 'regex', Model:: MODEL_INSERT ),
        );
    /**
     * 提交一条评论
     * @param  array  $data 
     * @return 	array       返回插入的数据id
     */
    public function send($data=array()){
    	$data['createtime'] = time();
    	$data['uid'] = UID;
    	$res = $this->add($data);
    	M('Posts')->where(array('id'=>$data['post_id']))->setInc('comment_sum',1);//文章评论数+1
    	if($data['parentid'] !== 0){
    		$this->where(array('id'=>$data['parentid']))->save(array('ischild'=>1));
    	}
    	return $res;
    	// return $this->where(array('id'=>$res))->find();
    }
    /**
     * 设置为已读
     * @param [type] $id [description]
     */
    function set_read($id){
        return $res = $this->where(array('id'=>$id,'uid'=>UID))->setField(array('is_read'=>1));
    }
    /**
     * 设置为未读
     * @param [type] $id [description]
     */
    function set_noread($id){
        return $res = $this->where(array('id'=>$id,'uid'=>UID))->setField(array('is_read'=>0));
    }
}