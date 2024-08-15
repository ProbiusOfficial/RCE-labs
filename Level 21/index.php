<?php 
include ("get_flag.php");
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 关卡 21 :  PHP 特性 - 无参命令执行 --- 

*/

function hello_code($code){
    if(';' === preg_replace('/[^\W]+\((?R)?\)/', '', $code)){
        eval($code);
    }else{
        die("O.o");
    }
    
}

isset($_GET['code']) ? hello_code($_GET['code']) : null;

highlight_file(__FILE__);

?>
