<?php
ob_start();
// demarre la temporisation de sortie
?>

<h2 class="title-detail-actor">DETAIL DE L'ACTEUR</h2><br>
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
            <li class='li-detail-actor'>Les roles incarnés par ".$infos['nom']." ".$infos['prenom']." :</li>";
}

?>
<?php

    while($role = $roleJouer->fetch()){
        echo "<li class='li-detail-actor'>" . $role['nom_role'] . " dans <a href='index.php?action=detailFilms&id=" . $role['id_film'] . "'>" . $role['titre_film'] . "</a></li>";
    }

?>

</ul>
<div class='float-right'>
    <?php
        while($info = $selectIdPerson->fetch()){
        echo "<a href='index.php?action=deleteActor&id_personne=".$info['id_personne']."'>
                <form action='index.php?action=deleteActor&id_personne=".$info['id_personne']."' method='post'>
        
                <input class='button' value='SUPRRIMER' type='submit' name='delete'></a><br><br>
                </form>

                <a href='index.php?action=editActor&id_acteur=".$info['id_acteur']."&id_personne=".$info['id_personne']."'><input class='button' value='MODIFIER' type='submit'></a>";
    }
?>
<div>

</div>
<?php
    $title = "Détails acteur";
    $content = ob_get_clean();
    require "./views/template.php"
?>