<?php 
    ob_start();
?>

    <h2 class='title-list-genre'>LISTE DES GENRES</h2><br>

    <a href="index.php?action=addGenreToListGenres"><input class='button' type='submit' value='AJOUTER UN GENRE'></a><br>


    <table>
        <thead>
            <tr>
                <th>Libellé</th>
                <th></th>
                <th></th>
                <th>Liste des films de ce genre</th>
            </tr>    
        </thead>
            <tbody>
<?php 

    while($genre = $genres->fetch()){
        echo "<tr>
                <td>".$genre['nom_genre']."</td>
                <td><a href='index.php?action=editGenre&id_genre=".$genre['id_genre']."'>
                <input class='button' type='submit' value='MODIFIER'></a>
                </td>
                <td><form action='index.php?action=deleteGenre&id_genre=".$genre['id_genre']."' method='post'>
                <input class='button' type='submit' name='delete' value='SUPPRIMER'></form>
                </td>
                <td><a href='index.php?action=listMoviesByGenre&id_genre=".$genre['id_genre']."'>Clique pour afficher la liste</a></td>
              </tr>";
    }

?>
            </tbody>
    </table>


<?php

    $title = "Liste des genres";
    $content = ob_get_clean();
    require "views/template.php";

?>