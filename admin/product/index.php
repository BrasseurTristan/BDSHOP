<?php
// require_once signifie qu'il as besoin du fichier 'protect.php', fichier qui va faire la vérification de l'existance de la variable de session $_SESSION et son contenu. 
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/protect.php";
// connect.php va nous permettre d'avoir accès à la base de données.
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/connect.php";
// On importe les fonctions que l'on a créer depuis le fichier functions.php 
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/functions.php";

// Page par défaut
$page = 1;
// Nombre d'enregistrements par page par défaut
$perPage = 50;

if (isset($_GET['p']) && is_numeric($_GET['p']) && $_GET['p'] > 0) {
    // Si valide, met à jour la valeur de $page
    $page = $_GET['p'];
}
// Prépare une requête SQL pour sélectionner tous les enregistrements de la table "table_product" en appliquant une limite de résultats et un décalage .
$sql = 'SELECT * FROM table_product LIMIT :limit OFFSET :offset';
$stmt = $db->prepare($sql);
$stmt->bindValue(":limit", $perPage, PDO::PARAM_INT);
// Calcule le décalage pour savoir combien de lignes doivent être ignorées dans le résultat.
$stmt->bindValue(":offset", ($page - 1) * $perPage, PDO::PARAM_INT);
$stmt->execute();
$recordset = $stmt->fetchAll();
// $sql = 'SELECT tp.product_id AS id, tp.product_name AS nom, tp.product_author AS auteur,tp.product_image AS image, tt.type_name AS type, tc.category_name AS categorie FROM table_product tp INNER JOIN table_type tt ON tp.product_type_id = tt.type_id INNER JOIN table_product_category tpc ON tp.product_id = tpc.product_category_product_id INNER JOIN table_category tc ON tc.category_id = tpc.product_category_category_id;';


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
    <div class="container text-center">
        <h1>Liste des bandes dessinées</h1>
        <a href="form.php" class="btn btn-primary btn-lg">Ajouter un livre</a>
        <a href="../logout.php" class="btn btn-warning btn-lg">Déconnexion</a>
    </div>
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
            // On utilise la boucle 'foreach' pour afficher la totalité de la variable '$recordset' qui contient un tableau associatif grâce au résultat de la requête SQL
            foreach ($recordset as $row) {
            ?>
                <tr>
                    <!-- On affiche dans chaque balise <td> les valeurs voulu en écrivant la clé correspondante du tableau associatif -->
                    <td><?= hsc($row['product_id']); ?></td>
                    <td><?= hsc($row['product_name']); ?></td>
                    <td><?= hsc($row['product_author']); ?></td>
                    <td><?= hsc($row['product_price']); ?>$</td>
                    <!-- Dans l'attribut 'href' des boutons on ajoute un paramètre dans l'URL qui à pour clé 'id' et pour valeur l'id du produit -->
                    <td class='text-center'>
                        <a class="btn btn-primary btn-sm" href="form.php?id=<?= htmlspecialchars($row['product_id']); ?>">Modifier</a>
                        <a class="btn btn-danger btn-sm" href="delete.php?id=<?= htmlspecialchars($row['product_id']); ?>">Supprimer</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php
    //Requête SQL pour avoir le nombre le livre dans la base de données
    $sql = "SELECT COUNT(product_id) AS total FROM table_product";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch();
    // On récupère le total des produits dans la variable '$row'. 
    $total = $row['total'];
    // On divise le nombre de page total par le nombre de livre que l'on veut afficher par page.
    // La fonction 'ceil()' permet d'arrondir à l'entier supérieur.
    $nbPage = ceil($total / $perPage);
    ?>
    <!-- Début de la pagination affichée sous forme de liste -->
    <ul class="pagination container">
        <!-- Bouton pour aller à la première page -->
        <li class="page-item <?= $page== 1 ?'disabled':''?>">
            <a class="page-link" href="index.php?p=1">&lt;&lt;</a>
        </li>
        <!-- Bouton pour aller à la page précédente-->
        <li class="page-item <?= ($page-1)== 0 ?'disabled':''?>">
            <a class="page-link" href="index.php?p=<?= ($page>=2)?$page-1:1; ?>">&lt;</a>
        </li>
        <?php
        // Boucle 'for' qui va générer le nombre de 'li' correspondant à chaque page.
        for ($i = 1; $i < $nbPage; $i++) {
        ?>
        <!-- Élément de liste pour chaque page -->
            <li class="page-item <?= $i == $page ? 'active' : ''; ?>">
                <!-- Lien vers la page correspondante -->
                <a class="page-link" href="index.php?p=<?= $i; ?>"><?= $i ?></a>
            </li>
        <?php
        }
        ?>
        <!-- Bouton pour aller à la page suivante -->
        <li class="page-item <?= ($page+1) >= $nbPage ?'disabled':''?>">
            <a class="page-link" href="index.php?p=<?= ($page<$nbPage)? ($page+1) : $nbPage; ?>">&gt;</a>
        </li>
        <!-- Bouton pour aller à la dernière page -->
        <li class="page-item <?= ($page+1) >= $nbPage ?'disabled':''?>">
            <a class="page-link" href="index.php?p=<?=($nbPage-1); ?>">&gt;&gt;</a>
        </li>
    </ul>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>