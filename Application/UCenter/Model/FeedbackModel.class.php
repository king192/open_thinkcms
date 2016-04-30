<?php
namespace UCenter\Model;
use Think\Model;

class FeedbackModel extends Model {

    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('title','1,100','标题不能为空，且不能多于100字',1,'length'),
        array('content', 'require', '评论内容不能为空', 1, 'regex', Model:: MODEL_INSERT ),
        // array('post_id', 'require', '要评论的文章id不存在', 1, 'regex', Model:: MODEL_INSERT ),
        );
    /**
     * 添加一条留言
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    function feedback($data=array()){
    	$data['uid'] = UID;
    	$data['createtime'] = time();
    	$res = $this->add($data);
    	return $res;
    }
    /**
     * 获取消息列表
     * @return [type] [description]
     */
    function get_list($data = array('p'=>1,'limit'=>3)){
    	$res = $this->alias('a')
    	->join('__USER__ b ON a.uid = b.id')
    	->field('a.id,a.uid,a.createtime,a.is_read,a.title,b.username')
    	->order('a.createtime desc')
    	->page($data['p'],$data['limit'])
    	->select();
    	return $res;
    }
    /**
     * 获取详情
     * @param  number $id 留言id
     * @return [type]     [description]
     */
    function get_detail($id){
    	//获取消息
    	//设置已读
    	$res = $this->where(array('id'=>$id))->find();
    	$this->where(array('id'=>$id))->setField(array('is_read'=>1));
    	return $res;
    }
    /**
     * 标记为重点
     * @param [type] $id [description]
     */
    function set_important($id){
    	return $this->where(array('id'=>$id))->setField(array('important'=>1));
    }
}