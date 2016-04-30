<?php
namespace UCenter\Controller;
use Think\Controller;

class EmptyController extends UcPublicController{
    public function _empty(){
    	header("HTTP/1.0 404 Not Found");
    	$this->display('Common@Public/404');
    }
}