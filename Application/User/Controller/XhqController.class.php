<?php
namespace User\Controller;
use Think\Controller;

class XhqController extends Controller {
	public function index(){
		dump(cookie('adminAuth'));
		exit('jkkkk');
	}
	public function cache(){
		S('flag','hello worlddd!!!',15);
		dump(S('flag'));
	}
	public function get_cache(){
		dump(S('flag'));
	}
}