<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 : 命令执行 - bash终端的无字母命令执行_特殊扩展替换任意数字 --- 

题目已经拥有成熟脚本：https://github.com/ProbiusOfficial/bashFuck
你也可以使用在线生成：https://probiusofficial.github.io/bashFuck/
题目本身也提供一个/exp.php方便你使用

本关卡的考点为 $(()) + 取反 构造任意数字

echo $(()) -> 0
echo $((~$(()))) -> -1
echo $(($((~$(())))$((~$(()))))) -> -2

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
