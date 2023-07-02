<?php 
    ob_start();
?>

    <h2 class='title-list-genre'>LISTE DES FILMS</h2><br>


    <?php 

        while($info = $query->fetch()){
            echo "".$info['titre_film']."<br>";
        }

    ?>
    

<?php

    $title = "Liste des genres";
    $content = ob_get_clean();
    require "views/template.php";

?>