<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 关卡 18 :  文件包含导致的RCE --- 

*/

function helloctf($code){
    $code = "include(".$code.");";
    eval($code);
}

isset($_POST['c']) ? helloctf($_POST['c']) : '';

highlight_file(__FILE__);

?>
