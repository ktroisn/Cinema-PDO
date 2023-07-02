<?php 
    ob_start();
?>


<h2 class='title-add-genre'>MODIFIER UN GENRE</h2><br>

<form class='form-add-movie' action="" method="post">

<div>
    <label for='nomGenre'>NOM DU  GENRE :<br></label>
<?php 
    while($info = $query0->fetch()){
        
        echo "<input class='input-add-movie' name='nomGenre' value='".$info['nom_genre']."'><br>";

    }
?>

</div>

<input class='button' type='submit' value='MODIFIER' name="edit">
</form>


<?php
    $title = "Modifier un genre";
    $content = ob_get_clean();
    require "views/template.php";

?>