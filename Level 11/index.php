<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 关卡 11 :  命令执行 - bash终端的无字母命令执行_真正的无字母 --- 

目前已有成熟脚本：https://github.com/ProbiusOfficial/bashFuck

扩展阅读：https://github.com/Bashfuscator/Bashfuscator

*/

function hello_shell($cmd){
    if(preg_match("/[A-Za-z0-9\"%*+,-.\/:;>?@[\]^`|]/", $cmd)){
        die("WAF!");
    }
    system($cmd);
}

isset($_GET['cmd']) ? hello_shell($_GET['cmd']) : null;

highlight_file(__FILE__);


?>
