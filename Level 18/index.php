<?php 
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 : 文件包含导致的RCE --- 

allow_url_fopen = On
allow_url_include = On
默认全开的环境，可以尝试多种解法，若对此存有疑问，尝试去 github.com/ProbiusOfficial/PHPinclude-labs 了解更多文件包含的知识。

远程文件包含可用链接(<?php @eval($_POST['a']); ?>)：
https://raw.githubusercontent.com/ProbiusOfficial/PHPinclude-labs/main/RFI
https://gitee.com/Probius/PHPinclude-labs/raw/main/RFI

FilterChain的Payload生成器：
https://probiusofficial.github.io/PHP-FilterChain-Exploit/
/exp.php

注意：在本关卡中你传递的内容将以字符串的方式拼接在 include() 函数中,你需要区别这与 incluude($_GET['file']) 的区别。
*/

function helloctf($code){
    $code = "include(".$code.");";
    echo "Your includeCode : ".$code;
    eval($code);
}

isset($_POST['c']) ? helloctf($_POST['c']) : '';

highlight_file(__FILE__);

?>
