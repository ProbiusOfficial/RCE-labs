<?php 
include ("get_flag.php");
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 关卡 1 :  一句话木马和代码执行 --- 

「代码执行(Code Execution)」 在某个语言中，通过一些方式(通常为函数或者方法调用)执行该语言的任意代码的行为，如PHP中的`eval()`函数或Python中的`exec()`函数。

当漏洞入口点可以执行任意代码时，我们称其为代码执行漏洞 —— 这种漏洞包含了通过语言中对接系统命令的函数来执行系统命令的情况，比如 eval("system('cat /etc/passwd')";); 也被归为代码执行漏洞。

我们平时最常见的一句话木马就用的 eval() 函数，如下所示（一般情况下，为了接收更长的Payload，我们一般对可控参数使用POST传参）

try POST:
    a=echo "Hello,World!";
*/

eval($_POST['a']);

highlight_file(__FILE__);

?>
