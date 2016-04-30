<?php
namespace Square\Controller;
use Think\Controller;

class IndexController extends PublicController{
	public function index(){
		/*-------获取分页文章------------*/
		$w = array();
		$cate = array();
		if(isset($_GET['cate'])){
			$w['a.cate'] = intval($_GET['cate']);
			$cate = array('cate'=>$w['a.cate']);
		}
		$p = isset($_GET['p'])?intval($_GET['p']):1;
		$limit = 8;
		$m_posts = D('Posts');
		$posts = $m_posts->get_posts_list($p,$limit,$w);
		$total = $m_posts->where($cate)->count('id');
		$c_page = new \Vendor\my\Page1($total,$limit);
		$page = $c_page->show();
		/*-------获取分页文章end------------*/
		/*-------获取最新文章------------*/
		$new_posts = $m_posts->get_new_list();
		/*-------获取最新文章end------------*/
		/*-------获取最热文章--------------*/
		$hot_posts = $m_posts->get_hot_list();
		/*-------获取最热文章end------------*/
		/*-------获取文章分类---------------*/
		$cate = D('UCenter/Cate')->get_cate();
		/*-------获取文章分类end------------*/
		/*-------获取上周积分排行-----------*/

		$order_credit = S('order_credit');
		if(!$order_credit){
			$m_model = M();
			$order_credit = $m_model->query('select a.id,a.uid,b.username,sum(a.credit) as credit from app_credit as a inner join app_user as b on a.uid = b.id where month(a.createtime) = month(curdate()) and week(a.createtime) = week(curdate())-1 group by uid order by sum(a.credit) desc limit 8');
			S('order_credit',$order_credit,60*60*24*7);//缓存一周
		}
		/*-------获取上周积分排行end-----------*/
		// dump($posts);
		$data = array(
			'title'=>'首页',
			'page'=>$page,
			'posts'=>$posts,
			'new_posts'=>$new_posts,
			'hot_posts'=>$hot_posts,
			'cate'=>$cate,
			'order_credit'=>$order_credit,
			);
		$this->assign($data);
		$this->display();
	}

	public function get_single(){
		header('content-type:text/html;charset=utf-8');
		if(!isset($_GET['id'])){
			header('location:'.U('Square/Index/index'));
			exit;
		}
		/*----获取文章----*/
		$posts = D('Posts')->get_single(intval($_GET['id']));
		$data = array(
			'posts'=>$posts,
			);
		/*----获取文章end----*/
		$this->assign($data);
		// dump($posts);
		
		$this->display();
	}
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
    public function del_cate_cache(){
    	F("cate", NULL);
    }
}   