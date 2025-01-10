<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/protect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/connect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/functions.php";

if(isset($_POST['sent']) && $_POST['sent'] == 'ok') {
    var_dump($_POST);
    $sql = "INSERT INTO table_product (product_name,product_slug,product_author,product_price) VALUES (:product_name,:product_slug,:product_author,:product_price)";
    $stmt = $db -> prepare($sql);
    $stmt -> bindValue(':product_name',$_POST['product_name']);
    $stmt -> bindValue(':product_slug',$_POST['product_slug']);
    $stmt -> bindValue(':product_author',$_POST['product_author']);
    $stmt -> bindValue(':product_price',$_POST['product_price']);
    $stmt -> execute();

    header("Location:index.php");
}

?>