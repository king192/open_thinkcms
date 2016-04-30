<?php


/**
 *
 * 返回json数据格式
 * @param unknown_type $code : 错误码
 * @param unknown_type $msg : 消息
 * @param unknown_type $data : 数据
 * @param unknown_type $rtn : 是否返回or 直接输出
 */
function json_rtn($code, $msg, $data=NULL, $rtn = 0) {
    if ($rtn) {
        return json_encode ( array ('rtn' => $code, 'msg' => $msg, 'data' => $data ) );
    } else {
        echo json_encode ( array ('rtn' => $code, 'msg' => $msg, 'data' => $data ) );
        exit ();
    }
}

function json_r($code, $msg, $data=NULL, $rtn = 0) {
    return json_encode ( array ('st' => $code, 'msg' => $msg, 'data' => $data ) );
}
// /******************************
//  * 聊天系统 表情图片转换成html
//  *****************************/
// function get_code_html($cont,$type=1){
//      $repla = array(
//         "[ems:1]","[ems:2]","[ems:3]","[ems:4]","[ems:5]",
//         "[ems:6]","[ems:7]","[ems:8]","[ems:9]","[ems:10]",
//         "[ems:11]","[ems:12]","[ems:13]","[ems:14]","[ems:15]",
//         "[ems:16]","[ems:hua]",
//     );
//     $repla_to = array();
//     foreach($repla as $k=>$v){
//         $str = explode(":", $v);
//         $str = str_replace("]", "", $str[1]);
//         $repla_to[$k] = "<img data='". $v ."' src='/Public/images/expression/". $str .".gif'>";
//     }
//     if($type == 2 && empty($cont)){
//         $cont = implode("", $repla_to);
//     }else{
//         $cont = str_replace($repla,$repla_to,$cont);
//     }
//     return $cont;
// }
/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function is_login(){
   // if ( strtolower(MODULE_NAME) == 'admin') {
   //     return is_loginadmin();
   // }
   $user = session('userAuth');
   if (empty($user)) {
       return false;
   } else {
       return session('userAuth_sign') == dataAuthSigna($user) ? $user['id'] : false;
   }

}
/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function is_mlogin(){
   // if ( strtolower(MODULE_NAME) == 'admin') {
   //     return is_loginadmin();
   // }
   $user = cookie('userAuth');
   if (empty($user)) {
       return false;
   } else {
       return cookie('userAuth_sign') == dataAuthSigna($user) ? $user['id'] : false;
   }

}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function dataAuthSigna($data) {
    //数据类型检测
    if(!is_array($data)){
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return md5($sign.C('COOKIEMD5'));
}

    /**
     * 生成用户的session数组
     * @param  integer $user 商户数组
     */
function get_session($user){
    /* 记录登录SESSION和COOKIES */
    $auth = array(
        'uid'            => $user['uid'],
        'useremail'      => $user['useremail'],
        'nick'           => $user['nick'],
        'logintm'        => $user['logintm'],
        'is_seller'      => $user['is_seller'],
        'cart_path'      => $user['cart_path'],
        'allow_login'    => $user['allow_login'],
    );
    session('userAuth', $auth);
    session('userAuth_sign', data_auth_signa($auth));  
}



    function url_request($url,$data = null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4");
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
/**
 * 检测验证码
 * @param  integer $id 验证码ID
 * @return boolean     检测结果
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function check_verify($code, $id = 1){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

/**
 * Cookie 设置、获取、删除
 * @param string $name cookie名称
 * @param mixed $value cookie值
 * @param mixed $option cookie参数
 * @return mixed
 */
function cookies($name='', $value='', $option=null) {
    // 默认设置
    $config = array(
        'prefix'    =>  C('COOKIE_PREFIX'), // cookie 名称前缀
        'expire'    =>  C('COOKIE_EXPIRE'), // cookie 保存时间
        'path'      =>  C('COOKIE_PATH'), // cookie 保存路径
        'domain'    =>  C('COOKIE_DOMAIN'), // cookie 有效域名
        'secure'    =>  C('COOKIE_SECURE'), //  cookie 启用安全传输
        'httponly'  =>  C('COOKIE_HTTPONLY'), // httponly设置
    );
    // 参数设置(会覆盖黙认设置)
    if (!is_null($option)) {
        if (is_numeric($option))
            $option = array('expire' => $option);
        elseif (is_string($option))
            parse_str($option, $option);
        $config     = array_merge($config, array_change_key_case($option));
    }
    if(!empty($config['httponly'])){
        ini_set("session.cookie_httponly", 1);
    }
    // 清除指定前缀的所有cookie
    if (is_null($name)) {
        if (empty($_COOKIE))
            return null;
        // 要删除的cookie前缀，不指定则删除config设置的指定前缀
        $prefix = empty($value) ? $config['prefix'] : $value;
        if (!empty($prefix)) {// 如果前缀为空字符串将不作处理直接返回
            foreach ($_COOKIE as $key => $val) {
                if (0 === stripos($key, $prefix)) {
                    setcookie($key, '', time() - 3600, $config['path'], $config['domain'],$config['secure'],$config['httponly']);
                    unset($_COOKIE[$key]);
                }
            }
        }
        return null;
    }elseif('' === $name){
        // 获取全部的cookie
        return $_COOKIE;
    }
    $name = $config['prefix'] . str_replace('.', '_', $name);
    if ('' === $value) {
        if(isset($_COOKIE[$name])){
            $value =    $_COOKIE[$name];
            if(0===strpos($value,'think:')){
                $value  =   substr($value,6);
                return array_map('urldecode',json_decode(MAGIC_QUOTES_GPC?stripslashes($value):$value,true));
            }else{
                return $value;
            }
        }else{
            return null;
        }
    } else {
        if (is_null($value)) {
            setcookie($name, '', time() - 3600, $config['path'], $config['domain'],$config['secure'],$config['httponly']);
            unset($_COOKIE[$name]); // 删除指定cookie
        } else {
            // 设置cookie
            if(is_array($value)){
                $value  = 'think:'.json_encode(array_map('urlencode',$value));
            }
            $expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
            setcookie($name, $value, $expire, $config['path'], $config['domain'],$config['secure'],$config['httponly']);
            $_COOKIE[$name] = $value;
        }
    }
    return null;
}
/**
 * Cookie 设置、获取、删除
 * @param string $name cookie名称
 * @param mixed $value cookie值
 * @param mixed $options cookie参数
 * @return mixed
 */
// function cookies($name, $value='', $option=null) {
//     // 默认设置
//     $config = array(
//         'prefix'    =>  C('COOKIE_PREFIX'), // cookie 名称前缀
//         'expire'    =>  C('COOKIE_EXPIRE'), // cookie 保存时间
//         'path'      =>  C('COOKIE_PATH'), // cookie 保存路径
//         'domain'    =>  C('COOKIE_DOMAIN'), // cookie 有效域名
//     );
//     // 参数设置(会覆盖黙认设置)
//     if (!is_null($option)) {
//         if (is_numeric($option))
//             $option = array('expire' => $option);
//         elseif (is_string($option))
//             parse_str($option, $option);
//         $config     = array_merge($config, array_change_key_case($option));
//     }
//     // 清除指定前缀的所有cookie
//     if (is_null($name)) {
//         if (empty($_COOKIE))
//             return;
//         // 要删除的cookie前缀，不指定则删除config设置的指定前缀
//         $prefix = empty($value) ? $config['prefix'] : $value;
//         if (!empty($prefix)) {// 如果前缀为空字符串将不作处理直接返回
//             foreach ($_COOKIE as $key => $val) {
//                 if (0 === stripos($key, $prefix)) {
//                     setcookie($key, '', time() - 3600, $config['path'], $config['domain']);
//                     unset($_COOKIE[$key]);
//                 }
//             }
//         }
//         return;
//     }
//     $name = $config['prefix'] . $name;
//     if ('' === $value) {
//         if(isset($_COOKIE[$name])){
//             $value =    $_COOKIE[$name];
//             if(0===strpos($value,'think:')){
//                 $value  =   substr($value,6);
//                 return array_map('urldecode',json_decode(MAGIC_QUOTES_GPC?stripslashes($value):$value,true));
//             }else{
//                 return $value;
//             }
//         }else{
//             return null;
//         }
//     } else {
//         if (is_null($value)) {
//             setcookie($name, '', time() - 3600, $config['path'], $config['domain']);
//             unset($_COOKIE[$name]); // 删除指定cookie
//         } else {
//             // 设置cookie
//             if(is_array($value)){
//                 $value  = 'think:'.json_encode(array_map('urlencode',$value));
//             }
//             $expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
//             setcookie($name, $value, $expire, $config['path'], $config['domain']);
//             $_COOKIE[$name] = $value;
//         }
//     }
// }

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 单位 秒
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_encrypt($data, $key = '', $expire = 0) {
    $key  = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
    $data = base64_encode($data);
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    $str = sprintf('%010d', $expire ? $expire + time():0);

    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
    }
    return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
}

/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key  加密密钥
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_decrypt($data, $key = ''){
    $key    = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
    $data   = str_replace(array('-','_'),array('+','/'),$data);
    $mod4   = strlen($data) % 4;
    if ($mod4) {
       $data .= substr('====', $mod4);
    }
    $data   = base64_decode($data);
    $expire = substr($data,0,10);
    $data   = substr($data,10);

    if($expire > 0 && $expire < time()) {
        return '';
    }
    $x      = 0;
    $len    = strlen($data);
    $l      = strlen($key);
    $char   = $str = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1))<ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }else{
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return base64_decode($str);
}

function send_email($address,$subject,$message){
    // import("Library/Pkg/Util/class.phpmailer.php");
    // import('Library/Org/Util/Test.class.php');
    import('Pkg.Util.Phpmailer');
    $mail=new \PHPMailer();
    // 设置PHPMailer使用SMTP服务器发送Email
    $mail->IsSMTP();
    $mail->IsHTML(true);
    // 设置邮件的字符编码，若不指定，则为'UTF-8'
    $mail->CharSet='UTF-8';
    // 添加收件人地址，可以多次使用来添加多个收件人
    $mail->AddAddress($address);
    // 设置邮件正文
    $mail->Body=$message;
    // 设置邮件头的From字段。
    $mail->From=C('MAIL_ADDRESS');
    // 设置发件人名字
    $mail->FromName=C('MAIL_SENDER');;
    // 设置邮件标题
    $mail->Subject=$subject;
    // 设置SMTP服务器。
    $mail->Host=C('MAIL_SMTP');
    // 设置为"需要验证"
    $mail->SMTPAuth=true;
    // 设置用户名和密码。
    $mail->Username=C('MAIL_LOGINNAME');
    $mail->Password=C('MAIL_PASSWORD');
    // 发送邮件。
    if(!$mail->Send()) {
        $mailerror=$mail->ErrorInfo;
        return array("error"=>1,"message"=>$mailerror);
    }else{
        return array("error"=>0);
    }
}

    function get_user_info($cols = "*"){
        return D('UCenter/User')->get_user_info(UID,$cols);
    }
    function get_cookie_info($name){
        $c = cookie('userAuth');
        if(!is_array($name)){
            return $c[$name];
        }else{
            foreach ($name as $k => $v) {
                $res[$v] = $c[$v];
            }
            return $res;
        }
    }

    function get_avatar(){
        $user = cookie('userAuth');

        // return 'hello';
        return $user['avatar']?$user['avatar']:'http://pic.dbw.cn/0/08/77/78/8777888_094777.jpg';
    }

    function get_parents($cols,$model){
        // $m_parent = $model?$model:D('NavParent');
        $m_parent =$model;
        $col = $m_parent->get_item($cols);
        return $col;
    }

    //刷新登陆cookie
    function re_set_login($array){
        $user = cookie('userAuth');
        set_logout();
        // exit;
        foreach ($array as $k => $v) {
            $user[$k] = $v;
        }
        // return $user;
        // json_rtn(333,$user);
        set_login($user);
    }
    /**
     * 登录
     * @param array  $user     用户信息
     * @param integer $remember 0非永久 1永久
     */
    function set_login($user,$remember = 0){
        $cookieTime = 60*60*24; 
        // $auth = $user;
        $auth = array(
            'id'=>$user['id'],
            'username'=>$user['username'],
            // str_replace(search, replace, subject)
            'avatar'=>$user['avatar']?str_replace('avatar/','avatar/thumb/',$user['avatar']):"",
            'lastlgtm'=>$user['lastlgtm']?$user['lastlgtm']:"",
            );
        $auth['avatar'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$auth['avatar'];
        // trace($auth,'userinfo','DEBUG');
        // session('userAuth', $auth);
        // session('userAuth_sign', data_auth_signa($auth));  
        if($remember){
            cookies('userAuth', $auth);
            cookies('userAuth_sign', dataAuthSigna($auth));
        }else{
            cookies('userAuth', $auth,$cookieTime);
            cookies('userAuth_sign', dataAuthSigna($auth),$cookieTime);
        }
    }
    //退出登陆
    function set_logout(){
        cookie('userAuth_sign',null);
        cookie('userAuth',null);
    }