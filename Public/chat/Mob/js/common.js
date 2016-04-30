
/******************************
 * 聊天系统 表情图片转换成html
 *****************************/
function get_code_html($cont,$type){
    var $type = $type || 1;
     $repla = Array(
        "[ems:1]","[ems:2]","[ems:3]","[ems:4]","[ems:5]",
        "[ems:6]","[ems:7]","[ems:8]","[ems:9]","[ems:10]",
        "[ems:11]","[ems:12]","[ems:13]","[ems:14]","[ems:15]",
        "[ems:16]","[ems:hua]"
    );
    $repla_to = Array();
    var len = $repla.length;
    var i = 0;
    for(i;i<len;i++){
        var j = i + 1;
        $repla_to[i] = "<img src='/Public/images/expression/"+j+".gif'>";
    }
    if($type == 2 && empty($cont)){
        $cont = implode("", $repla_to);
    }else{
        $cont = preg_replace($repla,$repla_to,$cont);
    }
    return $cont;
}

function preg_replace(search, replace, str, regswitch) {
    var regswitch = !regswitch ? 'ig' : regswitch;
    var len = search.length;
    console.log('len',len);
    for(var i = 0; i < len; i++) {
        re = new RegExp(search[i], regswitch);
        str = str.replace(re, typeof replace == 'string' ? replace : (replace[i] ? replace[i] : replace[0]));
    }
    return str;
}

// function htmlspecialchars(str) {
//     return preg_replace(['&', '<', '>', '"'], ['&amp;', '&lt;', '&gt;', '&quot;'], str);
// }