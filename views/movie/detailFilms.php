<?php
ob_start();
// demarre la temporisation de sortie
?>

    <h2 class='title-detail-movie'>
        DÉTAILS DU FILM
    </h2><br>

    <div class="container-detail">
        <?php
        
        while ($detail = $details->fetch()) {
                echo "
                    <figure class='figure-img-detail-movie'>
                        <img class='img-detail-movie' src='./public/images/" . $detail['img_film'] . "'>
                    </figure>
                    <div class='li-detail'>
                            <h3 class='title-movie'>" . $detail["titre_film"] ."</h3>
                            <ul>
                                <li class='li-detail-movie'><p class='info-title-detail-movie'>Année :</p><div class='info-text-border'><p class='info-text-detail'>" . $detail["YEAR(f.annee_film)"] ."</p></div></li>
                                <li class='li-detail-movie'><p class='info-title-detail-movie'>Durée :</p><div class='info-text-border'><p class='info-text-detail'>" . $detail["duree_film"] ." min</p></div></li>
                                <li class='li-detail-movie'><p class='info-title-detail-movie'>Réalisateur :</p><div class='info-text-border'><p class='info-text-detail'>" . $detail["nom"] ." " . $detail["prenom"] . "</p></div></li>
                                <li class='li-detail-movie'><p class='info-title-detail-movie'>Synopsis :</p><div class='info-text-border'><p class='info-text-detail'>" . $detail["synopsis_film"] ."</p></div></li>
                                <li class='li-detail-movie'><p class='info-title-detail-movie'>Genre(s) : <a href='index.php?action=addGenreByIdFilmForm&id=" . $detail["id_film"] . "'>
                                <input class='button detail-movie' type='submit' value='AJOUTER UN GENRE'></a></p><div class='info-text-border'>";

                                
        while($genre = $listGenres->fetch()) {
            if($selectPosseder = $id_posseder->fetch()){
                echo  "<div class='display-info-movie'><p class='info-text-detail'>" . $genre["nom_genre"] ."</p><a href='index.php?action=deleteGenreInDetailsMovie&id=".$selectPosseder['id_film']."&id_genre=".$selectPosseder['id_genre']."'>
                                                    <form action='index.php?action=deleteGenreInDetailsMovie&id=".$selectPosseder['id_film']."&id_genre=".$selectPosseder['id_genre']."' method='post'> 
                                                    <input class='button-delete-x' value='X' type='submit' name='delete'></form></a>
                    
                        </div>";
            }
        }


                echo "          </div></li><li class='li-detail-movie'><p class='info-title-detail-movie'>Acteur(s) : <a href='index.php?action=addCastingForm&id=" . $detail["id_film"] . "'>
                <input class='button detail-movie' type='submit' value='AJOUTER UN CASTING'></a></p><div class='info-text-border'>";


        while($acteur = $listActeurs->fetch()){
            if($selectId = $id_jouer->fetch()){
                echo  "<div class='display-info-movie'><p class='info-text-detail'><a href='index.php?action=detailActor&id=". $acteur['id_acteur'] . "&id_personne=". $acteur['id_personne'] ."'>" . $acteur["nom"] ." " . $acteur["prenom"] ."</a> incarne " . $acteur["nom_role"] ."</p>
                                <form action='index.php?action=deleteCasting&id=" . $selectId["id_film"] . "&id_role=" . $selectId["id_role"] . "&id_acteur=" . $selectId["id_acteur"] . "' method='post'>
                                <input class='button-delete-x' type='submit' value='X' name='delete'></form>
                                
                      </div>";
            }
                
            }

                echo "          </li>
                            </ul>
                    </div>";
        }
            
            
        ?>
    </div>


<?php
    $title = "Détails du film";
    $content = ob_get_clean();
    require "./views/template.php"
?>