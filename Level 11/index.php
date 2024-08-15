<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 关卡 11 :  命令执行 - bash终端的无字母命令执行_零溢事件 --- 

题目已经拥有成熟脚本：https://github.com/ProbiusOfficial/bashFuck
你也可以使用在线生成：https://probiusofficial.github.io/bashFuck/
题目本身也提供一个/exp.php方便你使用

本关卡的考点为终端中支持 $((2#binary)) 解析二进制数据 + 我们用 ${##} 来替换 1 

*/

function hello_shell($cmd){
    if(preg_match("/[A-Za-z1-9\"%*+,-.\/:;=>?@[\]^`|]/", $cmd)){
        die("WAF!");
    }
    system($cmd);
}

isset($_POST['cmd']) ? hello_shell($_POST['cmd']) : null;

highlight_file(__FILE__);


?>
