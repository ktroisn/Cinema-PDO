<?php

require_once "controllers/HomeController.php";
require_once "controllers/GenreController.php";
require_once "controllers/MovieController.php";
require_once "controllers/PersonController.php";
require_once "controllers/RoleController.php";
require_once "controllers/AdminController.php";

$homeCtrl = new HomeController();
$personCtrl = new PersonController();
$genreCtrl = new GenreController();
$movieCtrl = new MovieController();
$roleCtrl = new RoleController();
$adminCtrl = new AdminController();

if(isset($_GET['action'])) {
    
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $roleId = filter_input(INPUT_GET, "id_role", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $actorId = filter_input(INPUT_GET, "id_acteur", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $genreId = filter_input(INPUT_GET, "id_genre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $personId = filter_input(INPUT_GET, "id_personne", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    
    switch($_GET['action']){


        case "listMovie" : $movieCtrl->listMovie(); break;
        case "listActors" : $personCtrl->listActors(); break;
        case "detailActor" : $personCtrl->findActorDetailsById($id); break;
        case "deleteActor" : $personCtrl->deleteActor($personId); break;
        case "editActor" : $personCtrl->editActor($personId); break;
        case "listGenres" : $genreCtrl->listGenres(); break;
        case "listProducers" : $personCtrl->listProducers(); break;
        case "listRoles" : $roleCtrl->listRoles(); break;
        case "addProducerForm" : $personCtrl->addProducerForm(); break;
        case "addProducer" : $adminCtrl->addProducer(); break;
        case "detailProducer" : $personCtrl->findProducerDetailsById($id); break;
        case "deleteProducer" : $personCtrl->deleteProducer($personId); break;
        case "editProducer" : $personCtrl->editProducer($personId); break;
        case "addActeurForm" : $personCtrl->addActeurForm(); break;
        case "addActeur" : $adminCtrl->addActeur(); break;
        case "addMovieForm" : $movieCtrl->addMovieForm(); break ;
        case "addMovie" : $adminCtrl->addMovie($_POST); break;
        case "editMovie" : $adminCtrl->editMovie($id); break;
        case "detailFilms" : $movieCtrl->findFilmDetails($id); break;
        case "addCastingForm" : $personCtrl->addCastingForm($id); break;
        case "addCasting" : $personCtrl->addCasting($id); break;
        case "deleteCasting" : $movieCtrl->deleteCastingByIdFilmByIdActeurByIdRole($id, $roleId, $actorId); break;
        case "deleteGenreInDetailsMovie" : $movieCtrl->deleteGenreByIdFilmByIdGenre($id, $genreId); break;
        case "addGenreByIdFilmForm" : $movieCtrl->addGenreByIdFilmForm($id); break;
        case "addGenreByIdFilm" : $movieCtrl->addGenreByIdFilm($id); break;
        case "addGenreToListGenres" : $genreCtrl->addGenreToListGenres(); break;
        case "deleteGenre" : $genreCtrl->deleteGenre($genreId); break;
        case "editGenre" : $genreCtrl->editGenre($genreId); break;
        case "listMoviesByGenre" : $genreCtrl->listMoviesByGenre($genreId); break;
        default : case "Accueil" : $homeCtrl->homePage();
        
    }

} else {

    $homeCtrl->homePage();

}

?>