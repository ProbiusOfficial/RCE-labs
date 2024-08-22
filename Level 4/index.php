<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 : 命令执行 - SHELL 运算符 --- 

https://www.runoob.com/linux/linux-shell-basic-operators.html

SHELL 运算符 可以用于控制命令的执行流程，使得你能够根据条件执行不同的命令。

&&（逻辑与运算符）: 只有当第一个命令 cmd_1 执行成功（返回值为 0）时，才会执行第二个命令 cmd_2。例:  mkdir test && cd test

||（逻辑或运算符）: 只有当第一个命令 cmd_1 执行失败（返回值不为 0）时，才会执行第二个命令 cmd_2。例:  cd nonexistent_directory || echo "Directory not found"

&（后台运行符）: 将命令 cmd_1 放到后台执行，Shell 立即执行 cmd_2，两个命令并行执行。例:  sleep 10 & echo "This will run immediately."

;（命令分隔符）: 无论前一个命令 cmd_1 是否成功，都会执行下一个命令 cmd_2。例:  echo "Hello" ; echo "World"


try GET:
    ?ip=8.8.8.8
flag is /flag
*/

function hello_server($ip){
    system("ping -c 1 $ip");
}

isset($_GET['ip']) ? hello_server($_GET['ip']) : null;

highlight_file(__FILE__);


?>
