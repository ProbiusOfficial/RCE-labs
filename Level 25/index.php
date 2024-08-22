<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 : PHP 特性 - 取反绕过 --- 

注*：推荐先完成 无参命令注入部分题目 后再来尝试这一题。

取反题目实际上就是无参命令执行的一个变种，我们可以通过取反的方式来绕过正则表达式的匹配规则，已经有成熟的脚本就不多做说明了。

脚本仓库:https://github.com/ProbiusOfficial/PHP-inversion
https://probiusofficial.github.io/PHP-inversion/
题目提供一个在线的页面脚本来辅助你完成该题目：/exp.html

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
