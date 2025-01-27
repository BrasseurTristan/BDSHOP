<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/include/functions.php";
if(isset($_POST['sent']) && $_POST['sent'] == 'ok') {

    foreach ($_POST as $key => $value) {
        setcookie($key,$value,time()+(24*60*60),"/");
    }
};
redirect('index.php')
?>