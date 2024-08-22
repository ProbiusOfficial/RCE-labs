<?php 
session_start(); 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 : 命令执行 - PHP命令执行函数 --- 

喵喵喵ww https://www.php.net/manual/zh/ref.exec.php

system() 函数用于在系统权限允许的情况下执行系统命令（Windows 和 Linux 系统均可执行）。eg：system('cat /etc/passwd');
exec() 函数可以执行系统命令，但不会直接输出结果，而是将结果保存到数组中。eg：exec('cat /etc/passwd', $result); print_r($result);
shell_exec() 函数执行系统命令，但返回一个字符串类型的变量来存储系统命令的执行结果。eg：echo shell_exec('cat /etc/passwd');
passthru() 函数执行系统命令并将执行结果输出到页面中，支持二进制数据。eg：passthru('cat /etc/passwd');
popen() 函数执行系统命令，但返回一个资源类型的变量，需要配合 fread() 函数读取结果。eg：$result = popen('cat /etc/passwd', 'r'); echo fread($result, 100);
反引号 用于执行系统命令，返回一个字符串类型的变量来存储命令的执行结果。eg：echo \cat /etc/passwd`;`

在该关卡中，你将会从能够执行系统命令的PHP函数中抽取一个，你需要填充函数的内容来执行某些系统命令以获取flag（tip:flag存储在 /flag 中,当然你也可以尝试其他方法）。


*/
function hello_ctf($function, $content){
    if($function == '``'){
        $code = '`'.$content.'`';
        echo "Your Code: $code <br>";
        eval("echo $code");
    }else
    {
        $code = $function . "(" . $content . ");";
        echo "Your Code: $code <br>";
        eval($code);
    } 
    
}

function get_fun(){

    $func_list = ['system', 'exec', 'shell_exec', 'passthru', 'popen','``'];

    if (!isset($_SESSION['random_func'])) {
        $_SESSION['random_func'] = $func_list[array_rand($func_list)];
    }
    
    $random_func = $_SESSION['random_func'];

    $url_fucn = preg_replace('/_/', '-', $_SESSION['random_func']);

    echo $random_func == '``' ? "获得隐藏运算符: 执行运算符 ，去 https://www.php.net/manual/zh/language.operators.execution.php 详情。<br>" : "获得新的函数: $random_func ，去 https://www.php.net/manual/zh/function.".$url_fucn.".php 查看函数详情。<br>";

    return $_SESSION['random_func'];
}

function start($act){

    $random_func = get_fun();
    
    if($act == "r"){ /* 通过发送GET ?action=r 的方式可以重置当前选中的函数 —— 或者你可以自己想办法可控它x */
        session_unset();
        session_destroy(); 
    }

    if ($act == "submit"){
        $user_content = $_POST['content']; 
        hello_ctf($random_func, $user_content);
    }
}

isset($_GET['action']) ? start($_GET['action']) : '';

highlight_file(__FILE__);

?>
