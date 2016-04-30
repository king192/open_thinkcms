<?php
namespace Sql\Api;

class Split{
	// public $partition = array(
							//'field'=>'uid',//int 类型
							// 'type'=>'id',
							// 'num'=>'4'  //每个表中的记录数
							// );
	public $partition;
	public $tableName = 'test';
	public function __construct(){

	}
	public function getTable($data) {
		$data = $this->partition;
		dump($this->partition['type']);
		$table = $this->getPartitionTableName($data);

		return $table;
	}
	public function getPartitionTableName($data=array()) {
		if(isset($this->partition['field'])) {
		dump($data,true,'d');
			$field = $this->partition['field'];
			switch($this->partition['type']) {
				case 'id':
					echo '1';
					//按照id范围
					$step = $this->partition['expr'];
					$seq = floor($field / $step)+1;
					break;

				case 'year':

					// 按照年份分表

					if(!is_numeric($field)) {

					$field = strtotime($field);

					}

					$seq = date('Y',$field)-$this->partition['expr']+1;

					break;

				case 'mod':

					// 按照id的模数分表

					$seq = ($field % $this->partition['num'])+1;

					break;

				case 'md5':

					// 按照md5的序列分表

					$seq = (ord(substr(md5($field),0,1)) % $this->partition['num'])+1;

					break;

				default :

					if(function_exists($this->partition['type'])) {

						// 支持指定函数哈希

						$fun = $this->partition['type'];

						$seq = (ord(substr($fun($field),0,1)) % $this->partition['num'])+1;

					}else{

					// 按照字段的首字母的值分表

					$seq = (ord($field{0}) % $this->partition['num'])+1;

					}

			}

			return $this->tableName.'_'.$seq;
		}
	}
}