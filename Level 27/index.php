<?php

require 'vendor/autoload.php';
use Smarty\Smarty;
$smarty = new Smarty();

if (isset($_GET['page']) && gettype($_GET['page']) === 'string') {
    $file_path = "file://" . getcwd() . "/pages/" . $_GET['page'];
    $smarty->display($file_path);
} else {
    header('Location: /?page=home');
};
?>
