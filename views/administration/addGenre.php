<?php 
    ob_start();
?>


<h2 class='title-add-genre'>AJOUTER UN GENRE</h2><br>

<form class='form-add-movie' action="index.php?action=addGenreByIdFilm" method="post">

<div>

<label for='genre'>GENRE :<br></label>
<select class="input-add-movie" name='genre'><br>
<option selected disabled>Sélectionner</option>
<?php 
while($info = $selectGenre->fetch()){
    $id_genre = $info['id_genre'];
    $nom_genre = $info['nom_genre'];
    echo "<option value='$id_genre'>".$info['nom_genre']."</option>";
}
?> 
</select><br>
</div>

<?php
while($info = $selectIdFilm->fetch()){
echo "<input class='button' formaction='index.php?action=addGenreByIdFilm&id=" . $info['id_film'] . "' type='submit' value='AJOUTER' name='add'>";
}
?>
</form>


<?php
    $title = "Ajouter un film";
    $content = ob_get_clean();
    require "views/template.php";

?>