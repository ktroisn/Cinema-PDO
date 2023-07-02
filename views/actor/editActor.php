<?php 
    ob_start();
?>


<h2 class="title-edit-actor">MODIFIER UN ACTEUR</h2><br>

<?php

if($info = $query->fetch()){

?>

<form class='form-add-movie' action="" method="post" enctype="multipart/form-data">

        <div>
        <label for='nom'>NOM :<br></label>
        <input class="input-add-movie" name='nom' value='<?= $info["nom"] ?>'><br>
        </div>

        <div>
        <label for='prenom'>PRENOM :<br></label>
        <input class="input-add-movie" name='prenom' value='<?= $info["prenom"] ?>'><br>
        </div>

        <div>
        <label for='sexe'>SEXE :<br></label>
        <select class="input-add-movie" name="sexe">
            <option selected><?= $info["sexe"] ?></option>
            <?php
            if($info["sexe"] == "Homme"){
                echo "
                    <option>Femme</option>
                    <option>Autre</option>";
            } elseif($info["sexe"] == "Femme") {
                echo "
                    <option>Homme</option>
                    <option>Autre</option>";
            } else {
                echo "
                    <option>Homme</option>
                    <option>Femme</option>";
            }
            ?>
    
        </select><br>
        </div>

        <div>
        <label for='img'>PHOTO :<br></label>
        <input class="input-add-movie" name='img' value='<?= $info["img_personne"] ?>'><br>
        </div>

        <div>
        <label for='dateNaissance'>DATE DE NAISSANCE :<br></label>
        <input class="input-add-movie" name='dateNaissance' value='<?= $info["dateNaissance"] ?>'><br>
        </div>

<input class='button edit' type="submit" value="MODIFIER" name="edit">

</form>


<?php

}

    $title = "Modifier un acteur";
    $content = ob_get_clean();
    require "views/template.php";

?>