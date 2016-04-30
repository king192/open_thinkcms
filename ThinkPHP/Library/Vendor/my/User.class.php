<?php
namespace Vendor\my;

class User {

    static public function passwd_encode($passwd){
    	return md5(base64_encode($passwd));

    }
}