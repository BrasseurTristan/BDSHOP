<?php
// Permet de travailler avec la variable de session $_SESSION
session_start();
// On vérifie que la clé 'is_logged' de la variable $_SESSION contient 'oui'
if (!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] != 'oui'){
    // si la vérification n'est pas valide, on renvoie vers la page de login
    redirect('/admin/login.php');
}
// Si la clé 'token' de la variable $_SESSION n'existe pas , on la créé.
if (empty($_SESSION['token']) ){
    // Il faudrait idéalement ajouter un élément unique à concaténé avec la date.
    $_SESSION['token'] = md5(date('YmdHisu'));
}   

// On vérifie que le $_POST['token'] et qu'il est égale à la clé 'token' de la variable $_SESSION
if(isset($_POST['token']) && $_POST['token'] != $_SESSION['token']){
    redirect('/admin/login.php');
}
// On vérifie que le $_GET['token'] et qu'il est égale à la clé 'token' de la variable $_SESSION
if(isset($_GET['token']) && $_GET['token'] != $_SESSION['token']){
    redirect('/admin/login.php');
}