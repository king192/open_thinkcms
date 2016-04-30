<?php
namespace UCenter\Controller;
use Think\Controller;

class PostController extends UcPublicController{
	/**
	 * 发表帖子页面
	 * @return void 
	 */
	public function index(){
		$cate = D('Cate')->get_cate();
		$data = array(
			'cate'=>$cate,
			'title'=>'发表帖子',
			);
		$this->assign($data);
		$this -> display();
	}
	/**
	 * 发表帖子
	 * @return void
	 */
	public function posts(){
		if($_SERVER['REQUEST_METHOD']!=='POST'){
			exit;
		}
		$data = array(
			'title'=>trim(I('post.title')),
			'summary'=>trim(I('post.summary')),
			'content'=>trim(I('post.content')),
			'cate'=>trim(I('cate')),
			'status'=>1,
			);
		// json_rtn(-1,$data);
		$posts = D('Square/Posts');
		if(!$posts->create($data)){
			json_rtn(-1,$posts->getError());
		}
		if(!check_verify($_POST['verify'])){
			json_rtn(-1,'验证码不正确');
		}
		if(empty($data['summary'])){
			$data['summary'] = mb_substr($data['content'], 0,200,'utf-8');
		}
		$res = $posts->post($data);
		if(!$res){
			json_rtn(-1,'发表失败');
		}
		json_rtn(1,'发表成功');
	}
    /* 验证码，用于登录和注册 */
    public function verify(){
      $config =    array(
            'fontSize'    =>    14,    // 验证码字体大小
            'length'      =>    4,     // 验证码位数
            'useNoise'    =>    false, // 关闭验证码杂点
            'useCurve'    =>    false, // 关闭混淆曲线
            // 'bg'          =>  array(255, 255, 255),        // 关闭验证码背景颜色
        );
        $verify = new \Think\Verify($config);
        $verify->entry(1);
    }
    public function get_my_posts(){
    	$p = isset($_GET['p'])?intval($_GET['p']):1;
    	$limit = 8;
    	$m_posts = M('Posts');
    	$posts = $m_posts->where(array('uid'=>UID))->order('createtime')
    	->page($p,$limit)
    	->field('id,title,cate,createtime,summary,post_hits,post_like,comment_sum')
    	->select();
    	// trace(count($posts),'article!!!','DEBUG');
    	if(!$posts){
    		json_rtn(-1,'没有文章',array('info'=>'<span style="font-size:14px;font-weight:bold;">~^~木有数据~~~</span>','page'=>''));
    	}
    	$data = array(
    		'posts'=>$posts,
    		);
    	$this->assign($data);
    	$info = $this->fetch('Ajax/myposts');
    	$data = array(
    		'info'=>$info,
    		);
    	// 分页
    	// if(!isset($_GET['page'])){
	    	$total = $m_posts->where(array('uid'=>UID))->count('id');
	    	$c_page = new \Vendor\my\Page1($total,$limit);
	    	$page = $c_page->show();
	    	$data['page'] = $page;
	    // }
    	json_rtn(1,'获取成功',$data);
    }
}