<?php 
    ob_start();
?>

<h2 class='title-list-producer'>LISTE DES PRODUCTEURS</h2><br>

<a href="index.php?action=addProducerForm"><input class='button' type='submit' value='AJOUTER UN REALISATEUR'></a><br>
<div class='container-cards'>
<?php 

while($producer = $producers->fetch()){
    echo "<div class='card'>
            <a class='card-detail-link' href='index.php?action=detailProducer&id=" . $producer['id_realisateur'] . "&id_personne=" . $producer['id_personne'] . "'>
                <figure class='figure-img-actor-list'>
                    <img src='./public/images/" . $producer["img_personne"] . "' alt='Photo d'acteur' class='img-actor-list'>
                </figure>
                    <p class='name-actor-list-actor'>" . $producer["nom"] . " " . $producer["prenom"] . "</p>
            </a>
          </div>";
}

?>
</div>

<?php

    $title = "Liste des producteurs";
    $content = ob_get_clean();
    require "views/template.php";

?>