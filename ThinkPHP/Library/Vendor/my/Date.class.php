<?php
namespace Vendor\my;

class Date {
	/**
	 * 获取两个日期相差几天
	 * @author xhq <1434970057@qq.com>
	 * @param  string $date1 如：2007-2-5
	 * @param  string $date2 如：2007-2-5
	 * @return number        
	 */
	public function get_between_day($date1,$date2){
		return (strtotime($date1)-strtotime($date2))/60/60/24;
	}
	/**
	 * 验证日期是否符合格式
	 * @author xhq <1293812979@qq.com>
	 * @param  string $date [description]
	 * @return Boolean       
	 */
	static public function valid_date($date){
		if(!preg_match('/^(\d){4}-(\d){2}-(\d){2}$/', $date)){
			return false;
		}
		if(date('Y-m-d',strtotime($date)) == $date){
			return true;
		}
		return false;
		// echo preg_match('/^(\w){4}-(\w){1,2}-(\w){1,2}$/', $date);
	}
	/**
	 * 验证日期是否符合格式
	 * @author xhq <1293812979@qq.com>
	 * @param  string $date [description]
	 * @return Boolean       
	 */
	static public function valid_date1($date){
		if(!preg_match('/^(\d){4}-(\d){1,2}-(\d){1,2}$/', $date)){
			return false;
		}
		$date1 = explode('-', date('Y-m-d',strtotime($date)));
		// dump($date1);
		$date2 = explode('-', $date);
		// dump($date2);
		if($date1['0'] == $date2['0'] && $date1['1'] == $date2['1'] && $date1['2'] == $date2['2']) {
			return true;
		}
		return false;
	}
}