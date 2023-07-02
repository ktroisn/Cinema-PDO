<?php 
    ob_start();
?>

<h2>Bienvenue sur la page d'accueil</h2>

<?php
    $title = "Page d'accueil";
    $content = ob_get_clean();
    require "views/template.php";
?>