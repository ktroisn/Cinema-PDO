<?php 

require_once "bdd/DAO.php";

class MovieController {

    // findAll, findAllMovies
    public function listMovie(){

        $dao = new DAO();

        $sql = "SELECT f.id_film, f.titre_film, YEAR(f.annee_film), f.duree_film, f.img_film FROM Film f";

        $movies = $dao->executerRequete($sql);

        require "views/movie/listMovie.php";


    }

    // findOneById, findOne, findOneMovieById, findOneMovie
    public function findFilmDetails($filmId) {
        $dao = new DAO();

        $sqlSelectIdJouer = "SELECT id_role, id_film, id_acteur FROM jouer WHERE id_film = :filmId";

        $params = [
          ":filmId" => $filmId  
        ];

        $id_jouer = $dao->executerRequete($sqlSelectIdJouer, $params);

        $sqlSelectIdPosseder = "SELECT id_genre, id_film FROM posseder WHERE id_film = :filmId";

        $params = [
          ":filmId" => $filmId  
        ];

        $id_posseder = $dao->executerRequete($sqlSelectIdPosseder, $params);

        $sqlActeur = "SELECT pe.nom, pe.prenom, ro.nom_role, pe.id_personne, ac.id_acteur
        FROM Personne pe
        INNER JOIN Acteur ac ON pe.id_personne = ac.id_personne
        INNER JOIN jouer jo ON ac.id_acteur = jo.id_acteur
        INNER JOIN Film fi ON jo.id_film = fi.id_film
        INNER JOIN Role ro ON jo.id_role = ro.id_role
        WHERE fi.id_film = :filmId";

        $params = array(':filmId' => $filmId);

        $listActeurs = $dao->executerRequete($sqlActeur, $params);

        $sqlGenre = "SELECT ge.nom_genre
        FROM Genre ge
        INNER JOIN posseder po ON ge.id_genre = po.id_genre
        INNER JOIN Film fi ON po.id_film = fi.id_film
        WHERE fi.id_film = :filmId;";

        $params = array(':filmId' => $filmId);

        $listGenres = $dao->executerRequete($sqlGenre, $params);

        $sql = "SELECT f.id_film, f.id_realisateur, f.titre_film, YEAR(f.annee_film), pe.nom, pe.prenom, f.duree_film, f.img_film, f.synopsis_film
        FROM Film f
        INNER JOIN Realisateur re ON f.id_realisateur = re.id_realisateur
        INNER JOIN Personne pe ON re.id_personne = pe.id_personne
        WHERE f.id_film = :filmId;";
        
        $params = array(':filmId' => $filmId);
        $details = $dao->executerRequete($sql, $params);

    
        require "views/movie/detailFilms.php";

    }

    public function deleteCastingByIdFilmByIdActeurByIdRole($filmId, $roleId, $actorId){

        $dao = new DAO();

        if(isset($_POST["delete"])){

            $sqlDelete = "DELETE FROM jouer WHERE id_film = :filmId AND id_role = :roleId AND id_acteur = :actorId";

            $params = [
                ":filmId" => $filmId,
                ":roleId" => $roleId,
                ":actorId" => $actorId
            ];

            $delete = $dao->executerRequete($sqlDelete, $params);

            header('Location: http://localhost:8888/Cinema-PDO/index.php?action=detailFilms&id='.$filmId.'');
        }
    
        require "views/movie/detailFilms.php";
    }

    public function deleteGenreByIdFilmByIdGenre($filmId, $genreId){

        $dao = new DAO();

        if(isset($_POST["delete"])){

            $sqlDelete = "DELETE FROM posseder WHERE id_film = :filmId AND id_genre = :genreId";

            $params = [
                ":filmId" => $filmId,
                ":genreId" => $genreId
            ];

            $delete = $dao->executerRequete($sqlDelete, $params);

            header('Location: http://localhost:8888/Cinema-PDO/index.php?action=detailFilms&id='.$filmId.'');
        }
    
        require "views/movie/detailFilms.php";
    }


     public function addMovieForm(){
        $dao = new DAO();

        $sql = "SELECT id_genre, nom_genre FROM genre";

        $sql2 = "SELECT pe.nom, pe.prenom, re.id_realisateur
                 FROM Personne pe, Realisateur re
                 WHERE re.id_personne = pe.id_personne";
        
        $genres = $dao->executerRequete($sql);

        $realisateurs = $dao->executerRequete($sql2);

       require "views/administration/addMovie.php";

    }

    public function addGenreByIdFilmForm($filmId) {

        $dao = new DAO();

        $sqlGenre = "SELECT ge.nom_genre, ge.id_genre FROM Genre ge";

        $sqlPosseder = "SELECT id_genre, id_film FROM posseder";

        $sqlFilm = "SELECT id_film FROM Film WHERE id_film = :filmId";

        $params = array(":filmId" => $filmId);

        $selectGenre = $dao->executerRequete($sqlGenre);

        $selectPosseder = $dao->executerRequete($sqlPosseder);

        $selectIdFilm = $dao->executerRequete($sqlFilm, $params);

        require "views/administration/addGenre.php";
    }

    public function addGenreByIdFilm($filmId){
        
        $dao = new DAO();

    if(isset($_POST["add"])){


        $sql = "INSERT INTO posseder (`id_film`, `id_genre`) VALUES (:fid, :genre)";


// Ajouter les filtres pour chaques type de données
            $id_genre = $_POST['genre'];

            


        
        $params =[
            ":fid" => $filmId,
            ":genre" => $id_genre
        ];

        
        $query = $dao->executerRequete($sql, $params);

        header('Location: http://localhost:8888/Cinema-PDO/index.php?action=detailFilms&id='.$filmId.'');
    }
    
    require "views/administration/addGenre.php";
    
   

}

}

?>