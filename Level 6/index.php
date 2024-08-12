<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 关卡 6 :  命令执行 - 终端特殊字符 --- 

在遇到空格被过滤的情况下，通常使用 %09 也就是TAB的URL编码来绕过，在终端环境下 空格 被视为一个命令分隔符，本质上由 $IFS 变量控制，而 $IFS 的默认值是空格、制表符和换行符，所以我们还可以通过直接键入 $IFS 来绕过空格过滤。


*/

function hello_shell($cmd){
    if(preg_match("/flag| /", $cmd)){
        die("WAF!");
    }
    system($cmd);
}

isset($_GET['cmd']) ? hello_shell($_GET['cmd']) : null;

highlight_file(__FILE__);


?>
