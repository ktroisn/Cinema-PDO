<?php 
    ob_start();
?>

<h2 class="title-list-movies">LISTE DES FILMS</h2><br>

<a href="index.php?action=addMovieForm"><input class='button' type='submit' value='AJOUTER UN FILM'></a><br>
        
<?php 

while($movie = $movies->fetch()){
    echo "<table>
          <thead>
            <tr>
                <th class='titre-table-list' colspan='4'>" . $movie['titre_film'] . "</th>
            </tr>
            <tr>
                <th class='bord-right' colspan='1'>Couverture</th>
                <th  class='bord-right' colspan='1'>Durée en minutes</th>
                <th colspan='1'>Année de sortie</th>
                <th colspan='1' class='th-button'><a href='index.php?action=editMovie&id=" . $movie["id_film"] . "'><input class='edit-button' type='submit' value='MODIFIER'></a></th>
            </tr>
          </thead>";
    echo "<tbody>
    <tr>
        <td class='bord-right'><figure class='figure-img-list-movie'><img class='img-list-movie' src='./public/images/" . $movie["img_film"] . "' alt='Couverture d'un film'></figure></td>
        <td class='bord-right'>" . $movie["duree_film"] . " mins</td>
        <td>" . $movie["YEAR(f.annee_film)"] . "</td>
        <td class='td-button'><a href='index.php?action=detailFilms&id=" . $movie["id_film"] . "'><input class='detail-button' value='DÉTAIL DU FILM'></a></td>
    </tr>
    </tbody></table><br><br><hr><br><br>";
    
}

?>

<?php
    $title = "Liste des films";
    $content = ob_get_clean();
    require "views/template.php";

?>