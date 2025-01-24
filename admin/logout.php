<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/include/functions.php";
session_start();
// On modifie la variable de session.
$_SESSION['is_logged'] = 'non';
// On détruit le variable de session.
session_destroy();
// On redirige vers la page de login.
redirect('login.php');
?>