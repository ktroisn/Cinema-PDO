<?php 
    ob_start();
?>

<h2>Liste des roles jouer</h2>

<?php 

while($role = $roles->fetch()){
    echo $role["nom"]," ";
    echo $role["prenom"]," incarne ";
    echo $role["nom_role"]," dans ";
    echo $role["titre_film"],"<br>";
}

?>

<?php

    $title = "Liste des roles joeur";
    $content = ob_get_clean();
    require "views/template.php";

?>