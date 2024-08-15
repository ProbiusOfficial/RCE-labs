<?php 
include ("get_flag.php");
global $flag;

session_start(); // 开启 session
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 关卡 2 :  PHP代码执行函数 --- 

除开在一句话木马中最受欢迎用以直接执行PHP代码的 eval() 函数，PHP还有许多 回调函数 也可以直接或者间接的执行PHP代码。

在该关卡中，你将会从能够执行代码的PHP函数中抽取一个，你需要填充函数的内容来执行某些代码以获取flag（tip:flag存储在 $flag 中,当然你也可以尝试其他方法）。


*/
function hello_ctf($function, $content){
    global $flag;
    $code = $function . "(" . $content . ");";
    echo "Your Code: $code <br>";
    eval($code);
}

function get_fun(){

    $func_list = ['eval','assert','call_user_func','create_function','array_map','call_user_func_array','usort','array_filter','array_reduce','preg_replace'];

    if (!isset($_SESSION['random_func'])) {
        $_SESSION['random_func'] = $func_list[array_rand($func_list)];
    }
    
    $random_func = $_SESSION['random_func'];

    $url_fucn = preg_replace('/_/', '-', $_SESSION['random_func']);
    
    echo "获得新的函数: $random_func ，去 https://www.php.net/manual/zh/function.".$url_fucn.".php 查看函数详情。<br>";

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
