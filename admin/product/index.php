<?php
// require_once signifie qu'il as besoin du fichier 'protect.php', fichier qui va faire la vérification de l'existance de la variable de session $_SESSION et son contenu. 
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/protect.php";
// connect.php va nous permettre d'avoir accès à la base de données.
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/connect.php";
// On importe les fonctions que l'on a créer depuis le fichier functions.php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/functions.php";

$sql = 'SELECT * FROM table_product LIMIT 25';
// $sql = 'SELECT tp.product_id AS id, tp.product_name AS Nom, tp.product_author AS auteur,tp.product_image AS image, tt.type_name AS type, tc.category_name AS categorie FROM table_product tp INNER JOIN table_type tt ON tp.product_type_id = tt.type_id INNER JOIN table_product_category tpc ON tp.product_id = tpc.product_category_product_id INNER JOIN table_category tc ON tc.category_id = tpc.product_category_category_id;';
$stmt = $db->prepare($sql);
$stmt->execute();
$recordset = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des BDs</title>
</head>
<body>
    <table class="table container table-hover table-responsive ">
        <caption> Liste des produits </caption>
        <thead class="bg-primary">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">NOM</th>
                <th scope="col">AUTEUR</th>
                <th scope="col">PRIX</th>
                <th scope="col">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // On utilise la boucle 'foreach' pour afficher la totalité de la variable '$recordset' qui contient un tableau associatif avec le résultat de la requête SQL
            foreach ($recordset as $row) {
            ?>
            <tr>
            <!-- On affiche dans chaque balise <td> les valeurs voulu en écrivant la clé correspondante du tableau associatif -->
                <td><?=hsc($row['product_id']);?></td>
                <td><?=hsc($row['product_image']);?></td>
                <td><?=hsc($row['product_name']);?></td>
                <td><?=hsc($row['product_author']);?></td>
                <td><?=hsc($row['product_price']);?>$</td>
                <!-- Dans l'attribut 'href' des boutons on ajoute un paramètre dans l'URL qui à pour clé 'id' et pour valeur l'id du produit -->
                <td>
                <a class="btn btn-primary btn-sm" href="form.php?id=<?= htmlspecialchars($row['product_id']); ?>">Modifier</a>
                <a class="btn btn-danger btn-sm" href="delete.php?id=<?= htmlspecialchars($row['product_id']); ?>">Supprimer</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>


<!-- SELECT tp.product_id AS id, tp.product_name AS Nom, tp.product_author AS auteur,tp.product_image AS image, tt.type_name AS type, tc.category_name AS categorie FROM table_product tp INNER JOIN table_type tt ON tp.product_type_id = tt.type_id INNER JOIN table_product_category tpc ON tp.product_id = tpc.product_category_product_id INNER JOIN table_category tc ON tc.category_id = tpc.product_category_category_id; -->