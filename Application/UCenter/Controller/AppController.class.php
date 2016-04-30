<?php
namespace UCenter\Controller;
use Think\Controller;

class AppController extends UcPublicController{
	public function index(){
		
		$this->display();
	}
	public function get_mark(){
		// {loop $row $m $n}
		$m_parent = D('NavParent');
		$m_item = D('NavItem');
		for($i=0;$i<3;$i++){
			$html = '<li class="P_connectedSortable P_connectedSortableCss" id="'.$i.'">';
		// {eval $col = DB::fetch_all("SELECT * FROM ".DB::table('nav_parent')." where ppid=".$n['id']." and uid=".$_G['uid']." ORDER BY sort DESC")}
		// {loop $col $d $t}
			// echo $m_parent->get_item();
			// dump($m_parent);
			$col = $m_parent->get_item($i);
			dump($col);
			foreach ($col as $k => $v) {
				# code...
				$r = $m_item->get_item($v['ppid']);
				dump($r);
				// $html .= $this->rander_before($v);
				// $html .= $this->rander1($r);
				// $html .= $this->rander_after();
			}
		}
		
		// {/loop}
	$html .= '</li>';

// {/loop}
	}
	protected function rander_before($t){
		// <div id="sortable_$t['id']" class="classSort">
		// 		<div class="edit head">	
		// 			<div class="classTitle">
		// 				<span id="share_$t['id']" class="delRecIcon" title="删除"></span>
		// 				<span id="edit_$t['id']" class="modRecIcon" title="编辑"></span>
		// 				<!-- <span id="rm_$t['id']" class="shareRecIcon" title="分享"></span> -->
		// 				<span id="attrState_$t['id']" {eval if($t['attrState'])echo 'class="downIcon" title="展开"';else echo 'class="upIcon" title="收起"'}></span>
		// 				<h3 clas  s="ui-state-header Drop">$t['title']</h3>
		// 			</div>
		// 		</div>
		// 		<div class="marksbox" id="marksbox_$t['id']" style="{eval if($t['attrState'])echo 'display:none';}">
		// 			<ul class="connectedSortable connectedSortableCss">
		// 				<li class="empty"></li>
	}
	protected function rander_after(){
		// 			</ul>
		// 			<span class="allBmBbtn iconBgImages add-form"></span>
		// 		</div>
		// </div>
	}
	protected function rander1(){
		// // {eval $list = DB::fetch_all("SELECT * FROM ".DB::table('nav_item')." where pid=".$t['id']." and uid=".$_G['uid']." ORDER BY sort")}
		// // {loop $list $k $v}
	 //  <li class="ui-state-list" id="a_$v['id']">
		// <div class="edit editBox">
		// 	<span id="share_$v['id']" class="delRecIcon" title="删除"></span>
		// 	<span id="edit_$v['id']" class="modRecIcon" title="编辑"></span>
		// 	<span id="rm_$v['id']" class="shareRecIcon" title="分享"></span>
		// 	<span id="ico_$v['id']" class="favIcon defaultIcon"></span>
		// 	<div class="bookmark">
		// 		<a href="$v['link']" title="$v['beiZhu']" target="_blank"><em class="link-word">$v['word']</em></a>
		// 	</div>
		// </div>
	 //  </li> 
		// // {/loop}
	}
}