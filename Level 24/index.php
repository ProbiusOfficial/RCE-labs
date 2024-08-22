<?php 
include ("get_flag.php");
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 : PHP 特性 - 无参命令执行 --- 

根据正则表达式的匹配规则，可以看到我们只能输入A(),这样的形式，括号中无法携带参数，但支持多个函数嵌套A(B(C())),这种形式我们称其为无参命令执行。
无参命令执行的难度首先是在于无参本身，这需要你利用一些函数特性外带参数绕过限制 —— 这可以从一些获取外部值的函数实现：
getallheaders()
session_id()
...
其次是对嵌套参数的处理 —— 当然不局限于外带进来的参数，一些诸如 localeconv() 的函数可以获取内部存在的一些参数如当前目录下面的文件信息等:
getchwd() ：函数返回当前工作目录。
scandir() ：函数返回指定目录中的文件和目录的数组。
dirname() ：函数返回路径中的目录部分。
chdir() ：函数改变当前的目录。

通常我们获取到的很多情况下是数组，所以有时候比较依赖对数组的操作，比如：
- array_reverse()：数组反转
- pos()：输出数组第一个元素
- next()：指向数组的下一个元素，并输出
...

随后是一些文件读取显示的操作：
- show_source() - 对文件进行语法高亮显示。
- readfile() - 输出一个文件。
- highlight_file() - 对文件进行语法高亮显示。
- file_get_contents() - 把整个文件读入一个字符串中。
- readgzfile() - 可用于读取非 gzip 格式的文件

...你随时可以通过查阅PHP官方手册中函数相关的部分来找到上面类似的内容。
*/

function hello_code($code){
    if(';' === preg_replace('/[^\W]+\((?R)?\)/', '', $code)){
        eval($code);
    }else{
        die("O.o");
    }
    
}

isset($_GET['code']) ? hello_code($_GET['code']) : null;

highlight_file(__FILE__);

?>
