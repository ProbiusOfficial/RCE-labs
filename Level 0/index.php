<?php 
include ("get_flag.php");
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 : 代码执行&命令执行 --- 

欢迎来到 RCE-labs —— 命令/代码执行靶场的第一个关卡，在开始之前，容我稍微介绍下一些前置知识：

「任意代码执行(Arbitrary Code Execution,ACE)」 是指攻击者在目标计算机或目标进程中运行攻击者选择的任何命令或代码的能力，这是一个广泛的概念，它涵盖了任何类型的代码运行过程，不仅包括系统层面的脚本或程序，也包括应用程序内部的函数或方法调用。

在此基础上我们将通过网络触发任意代码执行的能力通常称为 远程代码执行 「远程代码执行(RCE,Remote Code Execution,RCE)」。

「命令执行(Command Execution)」 通常指的是在操作系统层面上执行预定义的指令或脚本。这些命令最终的指向通常是系统命令，如Windows中的CMD命令或Linux中的Shell命令，这在语言中可以体现为一些特定的函数或者方法调用，如PHP中的`shell_exec()`函数或Python中的`os.system()`函数。

「代码执行(Code Execution)」 同我们最开始说到的任意代码执行，在语言中可以体现为一些函数或者方法调用，如PHP中的`eval()`函数或Python中的`exec()`函数。

虽然在很多教学场景，命令执行 和 代码执行 经常被用同一个缩写 RCE (Remote Code/Command Execution) 来指代，但显而易见的是，代码执行是更为广泛的概念。

我们将以漏洞点函数为导向，先分别介绍代码执行和命令执行，随后一起介绍CTF或者实战中可能用到的一些trick。


*/

$code = "include('flag.php');echo 'This will get the flag by eval PHP code: '.\$flag;";

$bash = "echo 'This will get the flag by Linux bash command - cat /flag: ';cat /flag";

eval($code);

echo "<br>";

system($bash);

highlight_file(__FILE__);

?>
