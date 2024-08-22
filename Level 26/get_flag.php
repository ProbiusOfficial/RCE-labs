<?php
$file_path = "/flag";
if (file_exists($file_path)) {
    $flag = file_get_contents($file_path);
}
else{
    $flag = "HelloCTF{Default_Flag}";
}

$flag_php = "<?php \$flag = \"$flag\"; ?>";


file_put_contents("flag.php", $flag_php);

// 根目录下默认存有flag但不建议心存侥幸ww



?>