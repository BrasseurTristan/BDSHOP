<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/include/functions.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/include/protect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/include/connect.php";


$title = 'Page de création';
// Initialisation des variables si l'utilisateur à cliquer sur le bouton 'Ajouter un livre'.
$product_id = 0;
$product_name = '';
$product_price = 0;
$product_author = '';
$product_stock = 0;
$product_category = 0;
$product_type_id = 0;
// var_dump($_GET);
// Si l'utilisateur clique sur le bouton 'Modifier' on vérifie que '$_GET['id']' existe et qu'il est supérieur à zéro.
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {

    $title = 'Page de modification';
    // Requête SQL qui va chercher toutes les informations concernant le produit dont la catégorie grâce à la jointure.
    $sql = 'SELECT * FROM table_product tp LEFT JOIN table_product_category tpc ON tp.product_id = tpc.product_category_product_id WHERE product_id = :id';

    $stmt = $db->prepare($sql);
    $stmt->execute([':id' => $_GET['id']]);
    if($row = $stmt -> fetch()){
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $product_author = $row['product_author'];
        $product_stock = $row['product_stock'];
        $product_type_id = $row['product_type_id'];
        $product_category = $row['product_category_category_id'];
    }
}
// Requête SQL qui va chercher toutes les informations concernant les types de produit.
    $sql_type = 'SELECT type_id AS id, type_name AS name FROM table_type';
    $stmt = $db->prepare($sql_type);
    $stmt->execute();
    $recordset_type = $stmt->fetchAll();

// Requête SQL qui va chercher toutes les informations concernant les catégories de produit.
$sql_cat = 'SELECT category_id AS id, category_name AS name FROM table_category';
$stmt = $db->prepare($sql_cat);
$stmt->execute();
$recordset_cat = $stmt->fetchAll();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de modification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="d-flex align-items-center justify-content-center vh-100">
<!-- On affiche dans les attributs 'value' de chaques champs du formulaires, le résultat de chaques variables par rapport aux champs associés  -->
    <form class="container border border-2 rounded py-5 px-2" action="process.php" method="POST" enctype="multipart/form-data">
        <div class="col d-flex justify-content-center mb-3">
            <h1><?= $title ?></h1>
        </div>
        <div class="mb-1">
            <label for="name" class="form-label">NOM</label>
            <input type="text" class="form-control" name="product_name" id="name" aria-describedby="Name" value="<?= hsc($product_name) ?>">
        </div>
        <div class="mb-1">
            <label class="form-label" for="image">IMAGE</label>
            <input type="file" class="form-control" name="product_image" id="image">
        </div>
        <div class="mb-1">
            <label for="author" class="form-label">AUTEUR</label>
            <input type="text" class="form-control" name="product_author" id="author" value="<?= hsc($product_author) ?>">
        </div>
        <div class="mb-1">
            <label class="form-label" for="stock">STOCK</label>
            <input type="number" class="form-control" name="product_stock" id="stock" value="<?= hsc($product_stock) ?>">
        </div>
        <div class="mb-1">
            <label class="form-label" for="price">PRIX</label>
            <input type="number" class="form-control" name="product_price" id="price" value="<?= hsc($product_price) ?>">
        </div>
        <div class="mb-1">
            <label class="form-label" for="category_id">CATÉGORIE</label>
            <select name="category_id" id="category_id" class="form-select">
                <option selected disabled>Choisir la catégorie du livre</option>
                <!-- Boucle 'foreach()' qui va afficher tous les types de livre. -->
                <?php foreach ($recordset_cat as $cat) {
                ?>
                <!-- Si la l'attribut 'value' est égale à la variable qui '$product_category' qui à pour valeur le résultat de la requête SQL pour le champ 'product_category_category_id'
                alors on sélectionne cette valeur par défaut grâce à l'attribut 'selected'. --> 
                    <option value="<?= hsc($cat['id']) ?>" <?=$cat['id'] == $product_category ?'selected':''?>><?= hsc($cat['name']) ?></option>
                <?php
                } 
                ?>
            </select>
        </div>
        <div class="mb-1">
            <label class="form-label" for="product_type_id">Type</label>
            <select name="product_type_id" id="type_id" class="form-select">
                <option selected disabled>Choisir le type du livre</option>
                <!-- Boucle 'foreach()' qui va afficher toutes les catégories de livre. -->
                <?php foreach ($recordset_type as $type) {
                ?>
                                <!-- Si la l'attribut 'value' est égale à la variable qui '$product_type_id' qui à pour valeur le résultat de la requête SQL pour le champ 'product_type_id'
                alors on sélectionne cette valeur par défaut grâce à l'attribut 'selected'. --> 
                    <option value="<?= hsc($type['id']) ?>" <?=$type['id'] == $product_type_id ?'selected':''?>> <?= hsc($type['name']) ?></option>
                <?php
                } 
                ?>
            </select>
        </div>
        <input type="hidden" name="sent" value="ok">
        <input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
        <!-- On associe à l'attribut 'value' l'identifiant du produit dans un 'input' caché qui va être utiliser dans la page de traitement. -->
        <input type="hidden" name="product_id" value="<?= hsc($product_id) ?>">
        <button type="submit" class="btn btn-primary mt-2">Ajouter</button>
        <a href="./index.php" class="btn btn-outline-dark mt-2">Retour</a>
    </form>

</body>

</html>