<?php
namespace Square\Model;
use Think\Model;

class PostsModel extends Model{
    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('title', '6,40', '请输入6到40字的标题', 1, 'length', Model:: MODEL_INSERT ),
        array('cate', 'require', '请选择分类', 1, 'regex', Model:: MODEL_INSERT ),
        array('content', '15,3000', '文章内容应大于15字少于30000字', 1, 'length', Model:: MODEL_INSERT ),
        array('summary','15,100','摘要请输入15到100字',2,'length'),
        );
	/**
	 * 发表帖子
	 * @param  array  $data 
	 * @return Boolean       
	 */
	public function post($data=array()){
		$data['mtime'] = $data['createtime'] = time();
		$data['uid'] = UID;
		$res = $this -> add($data);
		if($res){
			return D('Common/Credit') -> inc_credit(UID,2);
		}
		return $res;
	}
	/**
	 * 获取文章列表
	 * @param  number $p     页码
	 * @param  number $limit 每页文章数目
	 * @param array $w 条件
	 * @return array        [description]
	 */
	function get_posts_list($p,$limit,$w=array()){
		// return $this->where(array('status'=>1,'istop'=>0))->field('id,cate,uid,createtime,summary,post_hits,post_like,recommended')->order('createtime')->limit($limit)->select();
		$w['a.status'] = 1;
		$w['a.istop'] = 0;
		$posts = $this->where($w)->alias('a')
		->page($p,$limit)->order('a.createtime desc')
		->join('__CATE__ b ON a.cate = b.id')
		->join('__USER__ c ON a.uid = c.id')
		->field('a.id,a.title,a.cate,a.uid,a.createtime,a.summary,a.post_hits,a.post_like,a.recommended,a.comment_sum,b.name,c.username')
		->select();
		return $posts;
	}
	/**
	 * 获取最新文章列表
	 * @param  number $limit 文章数目
	 * @return array        [description]
	 */
	public function get_new_list($limit=8){
		$posts = F('new_posts');
		if(!$posts){
			$posts = $this->where(array('status'=>1))->order('createtime desc')->limit($limit)->field('id,title')
			->select();
			F('new_posts',$posts);
		}
		return $posts;
	}
	/**
	 * 获取最热文章列表
	 * @param  number $limit 文章数目
	 * @return array        [description]
	 */
	public function get_hot_list($limit=8){
		$posts = S('hot_posts');
		if(!$posts){
			$posts = $this->where(array('status'=>1))->order('post_hits desc')->limit($limit)->field('id,title')
			->select();
			S('hot_posts',$posts,300);
		}
		return $posts;
	}
    /**
     * 后台有更新/编辑则删除缓存
     * @param type $data
     */
    public function _before_write(&$data) {
        parent::_before_write($data);
        F("new_posts", NULL);
    }

    //删除操作时删除缓存
    public function _after_delete($data, $options) {
        parent::_after_delete($data, $options);
        $this->_before_write($data);
    }

    public function get_single($id){
		$this->where(array('id'=>$id))->setInc('post_hits',1);//文章查看+1
		$w['a.status'] = 1;
		$w['a.id'] = $id;
		$posts = $this->where($w)->alias('a')
		->join('__CATE__ b ON a.cate = b.id')
		->join('__USER__ c ON a.uid = c.id')
		->field('a.id,a.title,a.cate,a.uid,a.createtime,a.summary,a.post_hits,a.post_like,a.recommended,a.content,a.comment_sum,b.name,c.username')
		->find();
		return $posts;
    }

}