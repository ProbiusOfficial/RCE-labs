<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 关卡 24 :  PHP 特性 - 无字母数字的代码执行 --- 

参考和依据的文章：https://xz.aliyun.com/t/8107

*/

highlight_file(__FILE__);

isset($_POST['code']) ? $code = $_POST['code'] : $code = null;

if(preg_match("/[a-z0-9]/is", $code)){
    die("WAF!");
}else{
    echo "Your Payload's Length : ".strlen($code)."<br>";
    eval($code);
}

?>
