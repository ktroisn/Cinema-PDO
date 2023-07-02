<?php
ob_start();
// demarre la temporisation de sortie
?>

<h2 class="title-detail-actor">DETAIL DU RÉALISATEUR</h2><br>
<div class='display-detail-actor'>
<?php

while($infos = $selectActeur->fetch()){
    echo "<figure class='figure-img-actor-detail'>
            <img src='./public/images/" . $infos['img_personne'] . "' alt='Photo de l'acteur dans la page détail' class='img-actor-detail'>
          </figure>
          
          
          
          <ul class='ul-detail-actor'>
            <li class='li-detail-actor name-detail-actor'>".$infos['nom']." ".$infos['prenom']."</li>
            <li class='li-detail-actor'>Age : ".$infos['age']." ans</li>
            <li class='li-detail-actor'>Date de naissance : ".$infos['dateNaissance']."</li>
            <li class='li-detail-actor'>Sexe : ".$infos['sexe']."</li><br>
            <li class='li-detail-actor'>Les films réalisés par ".$infos['nom']." ".$infos['prenom']." :</li>";
}

?>
<?php

    while($produced = $filmProducted->fetch()){
        echo "<li class='li-detail-actor'><a href='index.php?action=detailFilms&id=" . $produced['id_film'] . "'>" . $produced['titre_film'] . "</a></li>";
    }

?>

</ul>
<div class='float-right'>
    <?php
        while($info = $selectIdPerson->fetch()){
        echo "<a href='index.php?action=deleteProducer&id_personne=".$info['id_personne']."'>
                <form action='index.php?action=deleteProducer&id_personne=".$info['id_personne']."' method='post'>
        
                <input class='button' value='SUPRRIMER' type='submit' name='delete'></a><br><br>
                </form>

                <a href='index.php?action=editProducer&id_realisateur=".$info['id_realisateur']."&id_personne=".$info['id_personne']."'><input class='button' value='MODIFIER' type='submit'></a>";
    }
?>
<div>

</div>
<?php
    $title = "Détails acteur";
    $content = ob_get_clean();
    require "./views/template.php"
?>