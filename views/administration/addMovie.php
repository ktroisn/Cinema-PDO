<?php 
    ob_start();
?>


<h2 class="title-add-movies">AJOUTER UN FILM</h2><br>

<form class='form-add-movie' action="index.php?action=addMovie" method="post" enctype="multipart/form-data">

<div>
<label for='titre'>TITRE :<br></label>
<input class="input-add-movie" name='titre' placeholder='Entrer le titre ici...'><br>
</div>

<div>
<label for='synopsis'>SYNOPSIS :<br></label>
<textarea class="input-add-movie synopsis" name='synopsis' placeholder='Entrer le synopsis ici...'></textarea><br>
</div>

<div>
<label for='date'>DATE DE SORTIE :<br></label>
<input class="input-add-movie" name='date' type='date'><br>
</div>

<div>
<label for='duree'>DURÉE EN MINUTES :<br></label>
<input class="input-add-movie" name='duree' placeholder='Entrer la durée (ex : 103)'><br>
</div>

<div>
<label for='realisateur'>RÉALISATEUR :<br></label>
<select class="input-add-movie" name='realisateur'><br>
<option selected disabled>Sélectionner en cliquant</option>
<?php 
while($real = $realisateurs->fetch()){
    $id_real = $real['id_realisateur'];
    echo "<option value='$id_real'>".$real['nom']." ".$real['prenom']."</option>";
}
?> 
</select><br>
</div>

<div>
<label for='imageToUpload'>COUVERTURE :<br></label>
<input class="button-file" type="file" name="imageToUpload"><br>
</div>

<div>
<label for='note'>NOTE SUR 20 :<br></label>
<input class="input-add-movie" name='note' placeholder='Entrer la note du film (ex : 3)'><br>
</div>

<div>
<label for='nom'>Genre :<br></label>
<?php 

while($genre = $genres->fetch()){
    $id_genre = $genre['id_genre'];
    echo "<input type='checkbox' name='genre[]' id='nom' value='$id_genre'>
          <label for='nom'>".$genre['nom_genre']."</label><br>";
}
      
?>
</div>

<input class='button' type="submit" value="AJOUTER" name="add">

</form>


<?php
    $title = "Ajouter un film";
    $content = ob_get_clean();
    require "views/template.php";

?>