<?php
namespace Square\Controller;
use Think\Controller;

class EmptyController extends PublicController{
    public function _empty(){
    	header("HTTP/1.0 404 Not Found");
    	$this->display('Common@Public/404');
    }

}