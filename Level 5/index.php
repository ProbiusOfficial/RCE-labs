<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 关卡 5 :  命令执行 - 终端特性_空字符忽略和通配符 --- 

在Shell中，单/双引号 "/' 可以用来定义一个空字符串或保护包含空格或特殊字符的字符串。
例如：echo "$"a 会输出 $a，而 echo $a 会输出变量a的值，当只有""则表示空字符串，Shell会忽略它。

*（星号）: 匹配零个或多个字符。例子: *.txt。
?（问号）: 匹配单个字符。例子: file?.txt。
[]（方括号）: 匹配方括号内的任意一个字符。例子: file[1-3].txt。
[^]（取反方括号）: 匹配不在方括号内的字符。例子: file[^a-c].txt。
{}（大括号）: 匹配大括号内的任意一个字符串。例子: file{1,2,3}.txt。

通过组合上述技巧，我们可以用于绕过CTF中一些简单的过滤：

system("c''at /e't'c/pass?d");
system("/???/?at /e't'c/pass?d");
system("/???/?at /e't'c/*ss*");
...


*/

function hello_shell($cmd){
    if(preg_match("/flag/", $cmd)){
        die("WAF!");
    }
    system($cmd);
}

isset($_GET['cmd']) ? hello_shell($_GET['cmd']) : null;

highlight_file(__FILE__);


?>
