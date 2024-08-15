<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 关卡 9 :  命令执行 - bash终端的无字母命令执行_$'\xxx' ---

题目已经拥有成熟脚本：https://github.com/ProbiusOfficial/bashFuck
你也可以使用在线生成：https://probiusofficial.github.io/bashFuck/
题目本身也提供一个/exp.php方便你使用

从该关卡开始你会发现我们在Dockerfile中添加了一行改动：

RUN ln -sf /bin/bash /bin/sh

这是由于在PHP中，system是执行sh的，sh通常只是一个软连接，并不是真的有一个shell叫sh。在debian系操作系统中，sh指向dash；在centos系操作系统中，sh指向bash，我们用的底层镜像 php:7.3-fpm-alpine 默认指向的 /bin/busybox ，要验证这一点，你可以对 /bin/sh 使用 ls -l 命令查看，在这个容器中，你会得到下面的回显：
bash-5.1# ls -l /bin/sh
lrwxrwxrwx    1 root     root            12 Mar 16  2022 /bin/sh -> /bin/busybox

我们需要用到的特性只有bash才支持，请记住这一点，这也是我们手动修改指向的原因。

在这个关卡主要利用的是在终端中，$'\xxx'可以将八进制ascii码解析为字符，仅基于这个特性，我们可以将传入的命令的每一个字符转换为$'\xxx\xxx\xxx\xxx'的形式，但是注意，这种方式在没有空格的情况下无法执行带参数的命令。
比如"ls -l"也就是$'\154\163\40\55\154' 只能拆分为$'\154\163' 空格 $'\55\154'三部分。

bash-5.1# $'\154\163\40\55\154'
bash: ls -l: command not found

bash-5.1# $'\154\163' $'\55\154'
total 4
-rw-r--r--    1 www-data www-data       829 Aug 14 19:39 index.php

*/

function hello_shell($cmd){
    if(preg_match("/[A-Za-z\"%*+,-.\/:;=>?@[\]^`|]/", $cmd)){
        die("WAF!");
    }
    system($cmd);
}

isset($_GET['cmd']) ? hello_shell($_GET['cmd']) : null;

highlight_file(__FILE__);


?>
