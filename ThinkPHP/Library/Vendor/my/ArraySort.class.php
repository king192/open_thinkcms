<?php
namespace Vendor\my;

class ArraySort {
	/**
	 * 去除二维数组中重复的一维数组
	 * @param  array $ar 二维数组
	 * @return array     [description]
	 */
	static function array_multi_unique($ar) {
	  $ar = array_map('serialize', $ar);//二维数组序列化后变一维数组
	  // dump($ar,true,'ar');
	  $ar = array_unique($ar);//然后把相同值去掉
	  return array_map('unserialize', $ar);//反序列化
	}
}