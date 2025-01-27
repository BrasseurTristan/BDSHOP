<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/include/functions.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/include/protect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/include/connect.php";

if(!isset($_POST['token'])){
    redirect('/admin/login.php');
}

// On vérifie si le $_POST['sent'] existe et si le contenu est égal à 'ok'
if(isset($_POST['sent']) && $_POST['sent'] == 'ok') {

    // Permet de récuperer le prochain ID qui va être insérer dans la base de données. 
    // Pas la meilleure façon de faire!
    $sql = "SELECT AUTO_INCREMENT AS id FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'table_product' AND TABLE_SCHEMA = 'bdshop';";
    $stmt = $db -> prepare($sql);
    $stmt -> execute();
    $next_id_in_db = $stmt -> fetch();
    //Cela permet de concatener l'id avec 'BD0' et l'envoyer en tant que slug.
    
    $slug = 'BD0'.$next_id_in_db['id'];
    // On vérifie si le $_POST['product_id'] est égal à '0'. Si oui cela veux dire que l'utilisateur veux ajouter une nouveau livre.
    if($_POST['product_id'] == 0){
        // Requête pour insérer le produit dans la table 'table-product'.
        $sql = "INSERT INTO table_product (product_name,product_slug,product_author,product_stock,product_price,product_status,product_type_id) VALUES (:product_name,:product_slug,:product_author,:product_stock,:product_price,:product_status,:product_type_id)";
        $stmt = $db -> prepare($sql);
        $stmt -> bindValue(':product_name',$_POST['product_name']);
        $stmt -> bindValue(':product_slug',$slug);
        $stmt -> bindValue(':product_author',$_POST['product_author']);
        $stmt -> bindValue(':product_stock',$_POST['product_stock']);
        $stmt -> bindValue(':product_price',$_POST['product_price']);
        $stmt -> bindValue(':product_status',1);
        $stmt -> bindValue(':product_type_id',$_POST['product_type_id']);
        $stmt -> execute();
    // Requête pour insérer la catégorie associer au produit dans la table associative 'table_product_category'.
        $last_id = $db->lastInsertId();
        $sql = 'INSERT INTO `table_product_category` (`product_category_product_id`, `product_category_category_id`) VALUES (:last_id, :category_id)';
        $stmt = $db -> prepare($sql);
        $stmt -> bindValue(':last_id',$last_id);
        $stmt -> bindValue(':category_id',$_POST['category_id']);
        $stmt -> execute();
    
    }else { // Si  $_POST['product_id'] est égal à un id cela veux dire que l'utilisateur modifie un livre.
         // Requête pour modifier le produit dans la table 'table-product'.
        $sql = 'UPDATE table_product SET 
        product_name = :product_name, 
        product_slug = :product_slug, 
        product_author = :product_author, 
        product_stock = :product_stock, 
        product_price = :product_price, 
        product_status = :product_status, 
        product_type_id = :product_type_id 
        WHERE product_id = :product_id';
        $stmt = $db -> prepare($sql);
        $stmt -> bindValue(':product_name',$_POST['product_name']);
        $stmt -> bindValue(':product_slug',$slug);
        $stmt -> bindValue(':product_author',$_POST['product_author']);
        $stmt -> bindValue(':product_stock',$_POST['product_stock']);
        $stmt -> bindValue(':product_price',$_POST['product_price']);
        $stmt -> bindValue(':product_status',1);
        $stmt -> bindValue(':product_type_id',$_POST['product_type_id']);
        $stmt -> bindValue(':product_id',$_POST['product_id']);
        $stmt -> execute();
        // Requête pour modifier la catégorie associer au produit dans la table associative 'table_product_category'.
        $sql = 'UPDATE `table_product_category` SET `product_category_product_id`=:product_category_product_id,`product_category_category_id`= :product_category_category_id WHERE product_category_product_id = :product_category_product_id';
        $stmt = $db -> prepare($sql);
        $stmt -> bindValue(':product_category_product_id',$_POST['product_id']);
        $stmt -> bindValue(':product_category_category_id',$_POST['category_id']);
        $stmt -> execute();

    }


    if(isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0){

        $id = $_POST['product_id'] > 0 ? $_POST['product_id'] : $last_id;

        if($_POST['product_id'] > 0){
            $sql = 'SELECT product_image FROM table_product WHERE product_id = :id';
            $stmt = $db->prepare($sql);
            $stmt -> bindValue(':id',$id);
            $stmt -> execute();
            if($row = $stmt->fetch()){
                if($row['product_image'] != '' && !is_null($row['product_image'])){
                    if(file_exists($_SERVER['DOCUMENT_ROOT'].'/upload/'.$row['product_image'])){
                        unlink($_SERVER['DOCUMENT_ROOT'].'/upload/'.$row['product_image']);
                    }
                }
            }
        }
        // Fonction qui s'assure que c'est fichier téléchargé par POST. si le fichier est valide, il est déplacé jusqu'au dossier 'upload'.
        move_uploaded_file($_FILES['product_image']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].'/upload/'.$_FILES['product_image']['name']);
        $sql = 'UPDATE table_product SET product_image = :product_image WHERE product_id = :product_id';
        $stmt = $db->prepare($sql);
        $stmt -> bindValue(':product_image',$_FILES['product_image']['name']);
        $stmt -> bindValue(':product_id',$id);
        $stmt -> execute();
    }
}

redirect('index.php');
