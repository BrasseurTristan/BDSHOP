<?php
// Fonction qui permet de ne rien afficher si le résultat de la variable est null
function hsc($value){
    if(is_null($value)){
        return "";
    }else {
        return htmlspecialchars($value);
    }
}

// Même fonction mais écrite avec une ternaire
// function hsc($value){
//     return is_null($value)?'': htmlspecialchars($value);
// }

// Fonction qui permet de faire la redirection + exit().
function redirect($url){
    header("Location:".$url);
    exit();
}
?>