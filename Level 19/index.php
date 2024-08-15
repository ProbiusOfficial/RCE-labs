<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 关卡 19 :  HP 特性 - 动态调用 --- 

*/

isset($_GET['a'])&&isset($_GET['b']) ? $_GET['a']($_GET['b']) : null;

highlight_file(__FILE__);

?>
