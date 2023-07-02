<?php 
    ob_start();
?>


<h2 class="title-add-actor">AJOUTER UN PRODUCTEUR</h2><br>

<form class='form-add-movie' action="index.php?action=addProducer" method="post" enctype="multipart/form-data">

<div>
<label for='nom'>NOM :<br></label>
<input class="input-add-movie" name='nom' placeholder='Entrer un nom...'><br>
</div>

<div>
<label for='prenom'>PRÉNOM :<br></label>
<input class="input-add-movie" name='prenom' placeholder='Entrer un prénom...'><br>
</div>

<div>
<label for="sexe">SEXE : </label><br>

<select class="input-add-movie" name="sexe">
    <option selected disabled>Sélectionner</option>
    <option>Homme</option>
    <option>Femme</option>
    <option>Autre</option>
    
</select><br>
</div>

<div>
<label for='dateNaissance'>DATE DE NAISSANCE :<br></label>
<input class="input-add-movie" name='dateNaissance' type='date'><br>
</div>

<div>
<label for='imageToUpload'>PHOTO :<br></label>
<input class="button-file" type="file" name="imageToUpload"><br>
</div>

<input class='button edit' type="submit" value="AJOUTER" name="add">

</form>


<?php
    $title = "Ajouter un réalisateur";
    $content = ob_get_clean();
    require "views/template.php";

?>