<?php 


require_once "bdd/DAO.php";


class GenreController {
    

    public function listGenres(){

        $dao = new DAO();

        $sql = "SELECT g.id_genre, g.nom_genre FROM Genre g";

        $genres = $dao->executerRequete($sql);

        require "views/genre/listGenres.php";

    }

    public function listMoviesByGenre($genreId){

        $dao = new DAO();

        $sql = "SELECT fi.titre_film, fi.id_film, po.id_film, po.id_genre
                FROM Film fi, Genre ge, posseder po
                WHERE po.id_film = fi.id_film
                AND po.id_genre = ge.id_genre
                AND ge.id_genre = :genreId";

        $params = [
            ":genreId" => $genreId
        ];

        $query = $dao->executerRequete($sql, $params);

        require "views/genre/listMoviesByGenre.php";
    }

    public function addGenreToListGenres(){

        $dao = new DAO();


        if(isset($_POST['add'])){
        $sql = "INSERT INTO Genre (`id_genre`, `nom_genre`) VALUES (NULL, :nom)";

        $nom = $_POST['nom'];
        $nom = filter_var($nom, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $params = [
            ":nom" => $nom
        ];

        $genres = $dao->executerRequete($sql, $params);

        header('Location: http://localhost:8888/Cinema-PDO/index.php?action=listGenres');


        }
        
        require "views/genre/addGenre.php";

    }

    public function deleteGenre($genreId){

        $dao = new DAO();

        if(isset($_POST['delete'])){

            $sql = "DELETE FROM Genre WHERE id_genre = :genreId";

            $params = [
                ":genreId" => $genreId
            ];

            $query = $dao->executerRequete($sql, $params);

            header('Location: http://localhost:8888/Cinema-PDO/index.php?action=listGenres');

        }

        require "views/genre/listGenres.php";

    }

    public function editGenre($genreId){

        $dao = new DAO();

        $sql0 = "SELECT id_genre, nom_genre FROM Genre WHERE id_genre = :genreId";

        $params = [
            ":genreId" => $genreId
        ];

        $query0 = $dao->executerRequete($sql0, $params);

        if(isset($_POST['edit'])){

            $sql = "UPDATE Genre
                    SET nom_genre=:nomGenre
                    WHERE id_genre = :genreId";

            $nomGenre = $_POST['nomGenre'];
            $nomGenre = filter_var($nomGenre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $params = [
                ":nomGenre" => $nomGenre,
                ":genreId" => $genreId
            ];

            $query = $dao->executerRequete($sql, $params);

            header('Location: http://localhost:8888/Cinema-PDO/index.php?action=listGenres');

        }

        require "views/genre/editGenre.php";
    }


}

?>