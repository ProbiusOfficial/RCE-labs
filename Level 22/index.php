<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 关卡 22 :  PHP 特性 - 取反绕过 --- 

*/

function hello_code($code){
    if(preg_match("/[A-Za-z0-9]+/", $code)){
        die("WAF!");
    }
    eval($code);
}

isset($_GET['code']) ? hello_code($_GET['code']) : null;

highlight_file(__FILE__);

?>
