<?php 
    ob_start();
?>


<h2 class='title-add-genre'>AJOUTER UN GENRE</h2><br>

<form class='form-add-movie' action="index.php?action=addGenreToListGenres" method="post">

<div>

<label for='nom'>NOM DU NOUVEAU GENRE :<br></label>
<input class="input-add-movie" name='nom' placeholder='Entre ici le nom du nouveau genre...'><br>

</div>

<input class='button' type='submit' value='AJOUTER' name='add'>
</form>


<?php
    $title = "Ajouter un film";
    $content = ob_get_clean();
    require "views/template.php";

?>