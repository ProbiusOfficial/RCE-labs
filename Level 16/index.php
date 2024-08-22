<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 : 文件写入导致的RCE --- 

https://www.php.net/manual/zh/function.file-put-contents.php

参考可以写入的内容：
<?php @eval($_POST['a']); ?>

*/

function helloctf($code){
    $code = "file_put_contents(".$code.");";
    eval($code);
}

isset($_GET['c']) ? helloctf($_GET['c']) : '';

highlight_file(__FILE__);

?>
