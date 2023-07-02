<?php 
    ob_start();
?>

<h2 class="title-edit-movies">MODIFIER UN FILM</h2><br>

<?php

if($detail = $movie->fetch()){

?>

    <form class='form-add-movie' action="" method="post">

        <div>
        <label for='titre'>TITRE :<br></label>
        <input class="input-add-movie" name='titre' value='<?= $detail["titre_film"] ?>'><br>
        </div>

        <div>
        <label for='synopsis'>SYNOPSIS :<br></label>
        <textarea class="input-add-movie synopsis" name='synopsis'><?= $detail["synopsis_film"] ?></textarea><br>
        </div>

        <div>
        <label for='date'>DATE DE SORTIE :<br></label>
        <input class="input-add-movie" name='date' value='<?= $detail["annee_film"] ?>'><br>
        </div>

        <div>
        <label for='duree'>DURÉE EN MINUTES :<br></label>
        <input class="input-add-movie" name='duree' value='<?= $detail["duree_film"] ?>'><br>
        </div>

        <div>
        <label for='realisateur'>RÉALISATEUR :<br></label>
        <?php
        if($real = $realisateurs2->fetch()){
        ?>
        <select class="input-add-movie" name='realisateur'><br>
        <option value='<?= $detail["id_realisateur"] ?>' selected><?= $real["nom"] ?> <?= $real["prenom"] ?></option>
        <?php 
        }
        while($real = $realisateurs->fetch()){
            $id_real = $real['id_realisateur'];
            echo "<option value='$id_real'>".$real['nom']." ".$real['prenom']."</option>";
        }
        ?> 
        </select><br>
        </div>

        <div>
        <label for='note'>NOTE :<br></label>
        <input class="input-add-movie" name='note' value='<?= $detail["note_film"] ?>'><br>
        </div>

        <input class='button edit' type="submit" value="MODIFIER" name="edit"><input class='button edit' type="submit" value="SUPPRIMER" name="delete">

    </form>

<?php

}

    $title = "Modifier un film";
    $content = ob_get_clean();
    require "views/template.php";

?>

