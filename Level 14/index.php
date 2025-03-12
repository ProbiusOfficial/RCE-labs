<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 : 命令执行 - 长度限制_7字符RCE --- 


*/

if(isset($_GET[1]) && strlen($_GET[1]) < 8){
    echo strlen($_GET[1]);
    echo '<hr/>';
    echo shell_exec($_GET[1]);
}else{
    exit('too long');
}

highlight_file(__FILE__);


?>
