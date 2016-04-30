<?php
// include('saeconfig.php');
// echo defined('local');
if(defined('local')){
	//本地环境
	$array = array(
		//'配置项'=>'配置值'
	    'DB_TYPE'               =>  'mysql',     // 数据库类型
	    'DB_HOST'               =>  'localhost', // 服务器地址
	    'DB_NAME'               =>  'app_thinkfortest',          // 数据库名
	    'DB_USER'               =>  'root',      // 用户名
	    'DB_PWD'                =>  'root',          // 密码
	    'DB_PORT'               =>  '3306',        // 端口
	    'DB_PREFIX'             =>  'app_',    // 数据库表前缀
	);
}else{
	//sae 环境,部署环境，以前是sae，查看入口文件包含的deploy.php，以下常量定义一下就ok
	$array = array(
		//'配置项'=>'配置值'
	    'DB_TYPE'               =>  'mysql',     // 数据库类型
	    'DB_HOST'               =>  SAE_MYSQL_HOST_M, // 服务器地址
	    'DB_NAME'               =>  'app_thinkfortest',          // 数据库名
	    'DB_USER'               =>  SAE_MYSQL_USER,      // 用户名
	    'DB_PWD'                =>  SAE_MYSQL_PASS,          // 密码
	    'DB_PORT'               =>  SAE_MYSQL_PORT,        // 端口
	    'DB_PREFIX'             =>  'app_',    // 数据库表前缀
	);
}
// $sae = array(SAE_MYSQL_HOST_M,SAE_MYSQL_USER,SAE_MYSQL_PASS,SAE_MYSQL_PORT);
// dump($sae);
// dump($array);
$array1 = array(

	'COOKIEMD5' => 'kdjfir985ujtg55',
	'MAIL_ADDRESS' => '13510507252@163.com',
	'MAIL_SENDER' => 'xhq',
	'MAIL_SMTP' => 'smtp.163.com',
	'MAIL_LOGINNAME'=> '13510507252@163.com',
	'MAIL_PASSWORD' => 'wsxhq850687192',
	'WEB_NAME' => '爱游思',
    'MODULE_ALLOW_LIST'     =>    array('Square','Adminn','User','UCenter','Mob','Work','Workm'),
	);

$array = array_merge($array,$array1);
return $array;