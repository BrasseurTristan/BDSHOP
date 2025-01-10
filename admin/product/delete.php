<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/protect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/connect.php";

// On vérifie si '$_GET['id']' existe et si la valeur est numérique.
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    //Préparation de la requête SQL de suppression.
    $sql = 'DELETE FROM table_product WHERE product_id = :id';
    $stmt = $db->prepare($sql);
    //Suppression du produit par rapport à l'ID.
    $stmt->execute([':id'=>$_GET['id']]);
    // Redirection vers la page 'index.php'.
    header('Location:index.php');
}

?>