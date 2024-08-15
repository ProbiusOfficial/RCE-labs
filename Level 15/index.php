<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 关卡 15 :  命令执行 - 环境变量注入 --- 

来源：P牛2022的文章【我是如何利用环境变量注入执行任意命令】https://www.leavesongs.com/PENETRATION/how-I-hack-bash-through-environment-injection.html

*/
foreach($_REQUEST['envs'] as $key => $val) {
    putenv("{$key}={$val}");
}

system('echo hello');

highlight_file(__FILE__);

?>
