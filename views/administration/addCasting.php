<?php 
    ob_start();
?>


<h2 class='title-add-casting'>AJOUTER UN CASTING</h2><br>

<form class='form-add-movie' action="index.php?action=addCasting" method="post">

<div>
<label for='role'>Role :<br></label>
<select class="input-add-movie" name='role'><br>
<option selected disabled>Sélectionner</option>
<?php 
while($info = $selectRole->fetch()){
    $id_role = $info['id_role'];
    $nom_role = $info['nom_role'];
    echo "<option value='$id_role'>".$info['nom_role']."</option>";
}
?> 
</select><br>
</div>


<div>
<label for='acteur'>Acteur :<br></label>
<select class="input-add-movie" name='acteur'><br>
<option selected disabled>Sélectionner</option>
<?php 
while($info = $selectActeur->fetch()){
    $id_acteur = $info['id_acteur'];
    echo "<option value='$id_acteur'>".$info['nom']." ".$info['prenom']."</option>";
}
?> 
</select><br>
</div>

<?php
while($info = $selectIdFilm->fetch()){
echo "<input class='button' formaction='index.php?action=addCasting&id=" . $info['id_film'] . "' type='submit' value='AJOUTER' name='add'>";
}
?>
</form>


<?php
    $title = "Ajouter un film";
    $content = ob_get_clean();
    require "views/template.php";

?>