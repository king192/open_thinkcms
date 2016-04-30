<?php
function passwd_encode($passwd){
	return md5(base64_encode($passwd));

}