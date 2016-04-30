<?php
namespace Common\Model;
use Think\Model;
/**
 * 奖励模型
 */
class CreditModel extends Model {
	/**
	 * 增加金币
	 * @param  number  $uid  用户uid
	 * @param number $type 积分类型 1签到 2发表帖子
	 * @param  integer $credit 积分
	 * @return Boolean        
	 */
	function inc_credit($uid,$type=1,$credit = 2){
		$data = array(
			'uid'=>$uid,
			'createtime'=>date('Ymd',time()),
			'type'=>$type,
			'credit'=>$credit,
			);
		$res = $this -> where(array('uid'=>$uid,'createtime'=>date('Ymd',time()),'type'=>$type)) -> setInc('credit',$credit);
			// trace('hello011111111111111111111','错误','ERR');
		if($res){
			// trace('hello1','错误','ERR');
			return $this -> inc_all_credit($uid,$type,$credit);
		}
			// trace('hello1','错误','ERR');
		//可能数据不存在，尝试插入数据
		$res = $this -> add($data);
		if($res){
			// return true;
			// trace('hello2','错误','ERR');
			return $this -> inc_all_credit($uid,$type,$credit);
		}
		return false;
	}
	/**
	 * 增加总积分
	 * @param  number $uid    
	 * @param  number $type   
	 * @param  number $credit 
	 * @return Boolean         
	 */
	function inc_all_credit($uid,$type,$credit){

		$res = M('user') -> where(array('id' => $uid)) -> setInc('credit',$credit);
		if($res){
			return true;
		}
		return false;
	}
	function hello(){
		echo 'helloooooo';
	}
}