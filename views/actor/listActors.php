<?php 
    ob_start();
?>

<h2 class='title-list-actors'>LISTE DES ACTEURS</h2><br>

<a href="index.php?action=addActeurForm">
    <input class='button' type='submit' value='AJOUTER UN ACTEUR'></a><br>
<div class='container-cards'>
<?php 

while($actor = $actors->fetch()){
    echo "<div class='card'>
            <a class='card-detail-link' href='index.php?action=detailActor&id=" . $actor['id_acteur'] . "&id_personne=" . $actor['id_personne'] . "'>
                <figure class='figure-img-actor-list'>
                    <img src='./public/images/" . $actor["img_personne"] . "' alt='Photo d'acteur' class='img-actor-list'>
                </figure>
                    <p class='name-actor-list-actor'>" . $actor["nom"] . " " . $actor["prenom"] . "</p>
            </a>
          </div>";
}

?>
</div>
<?php

    $title = "Liste des acteurs";
    $content = ob_get_clean();
    require "views/template.php";

?>