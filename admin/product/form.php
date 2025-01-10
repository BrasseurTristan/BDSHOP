<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/protect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/connect.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/includes/functions.php";

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

    <form class="container border border-2 rounded py-5 px-2" action="process.php" method="POST" enctype="multipart/form-data">
    <div class="col d-flex justify-content-center mb-3">
        <h1>PAGE DE MODIFICATION</h1>    
    </div>
    <div class="mb-3">
        <label for="slug" class="form-label">SLUG</label>
        <input type="text" class="form-control" name="product_slug" id="slug" aria-describedby="Name">
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">NOM</label>
        <input type="text" class="form-control" name="product_name" id="name" aria-describedby="Name">
    </div>
    <div class="mb-3">
        <label for="author" class="form-label">AUTEUR</label>
        <input type="text" class="form-control" name="product_author" id="author">
    </div>
    <div class="mb-3">
        <label class="form-label" for="price">PRIX</label>
        <input type="number" class="form-control" name="product_price" id="price">
    </div>
    <input type="hidden" name="sent" value="ok">
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>


</body>
</html>