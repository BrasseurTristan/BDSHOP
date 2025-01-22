<?php

session_start();
// On modifie la variable de session.
$_SESSION['is_logged'] = 'non';
// On détruit le variable de session.
session_destroy();
// On redirige vers la page de login.
header('Location: login.php');
?>