<?php 


require_once "bdd/DAO.php";


class PersonController {
    

    public function listActors(){

        $dao = new DAO();

        $sql = "SELECT a.id_personne, a.id_acteur, p.id_personne, p.nom, p.prenom, p.img_personne FROM Acteur a, Personne p WHERE a.id_personne = p.id_personne";

        $actors = $dao->executerRequete($sql);

        require "views/actor/listActors.php";

    }

    public function listProducers(){

        $dao = new DAO();

        $sql = "SELECT pr.id_personne, pr.id_realisateur, p.id_personne, p.nom, p.prenom, p.img_personne FROM Realisateur pr, Personne p WHERE pr.id_personne = p.id_personne";

        $producers = $dao->executerRequete($sql);

        require "views/producer/listProducers.php";

    }

    public function addProducerForm(){

        $dao = new DAO();

        $sql = "SELECT pe.nom, pe.prenom, re.id_personne, ac.id_personne, pe.id_personne FROM Personne pe, Realisateur re, Acteur ac";

        $addPerson = $dao->executerRequete($sql);
        
        require "views/producer/addProducer.php";
    }

    public function addActeurForm(){

        $dao = new DAO();

        $sql = "SELECT pe.nom, pe.prenom, re.id_personne, ac.id_personne, pe.id_personne FROM Personne pe, Realisateur re, Acteur ac";

        $addPerson = $dao->executerRequete($sql);
        
        require "views/administration/addActor.php";
    }

    public function addCastingForm($filmId) {

        $dao = new DAO();

        $sqlRole = "SELECT ro.nom_role, ro.id_role FROM Role ro";

        $sqlActeur = "SELECT pe.prenom, pe.nom, ac.id_acteur FROM Personne pe, Acteur ac WHERE pe.id_personne = ac.id_personne";

        $sqlFilm = "SELECT id_film FROM Film WHERE id_film = :filmId";

        $params = array(":filmId" => $filmId);

        $selectRole = $dao->executerRequete($sqlRole);

        $selectActeur = $dao->executerRequete($sqlActeur);

        $selectIdFilm = $dao->executerRequete($sqlFilm, $params);

        require "views/administration/addCasting.php";
    }

    public function addCasting($filmId){
        
        $dao = new DAO();

    if(isset($_POST["add"])){


        $sql = "INSERT INTO jouer (`id_film`, `id_role`, `id_acteur`) VALUES (:fid, :rid, :aid)";


// Ajouter les filtres pour chaques type de données
            $id_role = $_POST['role'];
            $id_acteur = $_POST['acteur'];

            


        
        $params =[
            ":fid" => $filmId,
            ":rid" => $id_role,
            ":aid" => $id_acteur
        ];

        
        $query = $dao->executerRequete($sql, $params);

        header('Location: http://localhost:8888/Cinema-PDO/index.php?action=detailFilms&id='.$filmId.'');
    }
    
    require "views/administration/addCasting.php";
    
   

}

public function findActorDetailsById($actorId) {
    $dao = new DAO();


    // Avoir l'id_personne d'un acteur
    $sqlSelectIdPerson = "SELECT pe.id_personne, ac.id_acteur FROM Personne pe, Acteur ac WHERE ac.id_acteur = :actorId AND ac.id_personne = pe.id_personne";

    $params = [
        ":actorId" => $actorId  
      ];

    $selectIdPerson = $dao->executerRequete($sqlSelectIdPerson, $params);

    $sql = "SELECT pe.nom, pe.prenom, pe.img_personne, ac.id_acteur, ac.id_personne, pe.id_personne,
            pe.dateNaissance, pe.sexe, DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), dateNaissance)), '%Y') 
            + 0 AS age
            FROM Personne pe, Acteur ac 
            WHERE ac.id_acteur = :actorId 
            AND ac.id_personne = pe.id_personne";

    $params = [
        ":actorId" => $actorId  
      ];

    $selectActeur = $dao->executerRequete($sql, $params);

    $sqlFilmRole = "SELECT jo.id_role, jo.id_film, jo.id_acteur, ro.id_role, ro.nom_role,
                    fi.id_film, fi.titre_film
                         FROM jouer jo, Film fi, Role ro
                         WHERE jo.id_acteur = :actorId
                         AND jo.id_role = ro.id_role
                         AND jo.id_film = fi.id_film";

    $params = [
      ":actorId" => $actorId  
    ];

    $roleJouer = $dao->executerRequete($sqlFilmRole, $params);

    require "views/actor/detailActor.php";

}

public function deleteActor($personId){

    $dao = new DAO();

    if(isset($_POST["delete"])) {

        

        $sql = "DELETE FROM Personne WHERE id_personne = :pid";
        
        // Ajouter les filtres pour chaques type de donnée
        $params = [
            ":pid" => $personId
        ];
        

        $query = $dao->executerRequete($sql, $params);

        header('Location: http://localhost:8888/Cinema-PDO/index.php?action=listActors');
        
    }
    
    // select commun pour la page edit ? 
    

    
    require "views/actor/detailActor.php";

}

public function editActor($personId) {

    $dao = new DAO();

    $sql = "SELECT pe.id_personne, ac.id_acteur, pe.nom, pe.prenom, pe.sexe, pe.img_personne, pe.dateNaissance
    FROM Personne pe, Acteur ac 
    WHERE pe.id_personne = :personId";

    $params = [
        ":personId" => $personId
    ];

    $query = $dao->executerRequete($sql, $params);

    if(isset($_POST["edit"])) {

        $sql = "UPDATE Personne
                SET nom=:nom,prenom=:prenom,sexe=:sexe,img_personne=:img,dateNaissance=:dateNaissance
                WHERE id_personne=:pid";

        $nom=$_POST['nom'];
        $nom = filter_var($nom, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $prenom=$_POST['prenom'];
        $prenom = filter_var($prenom, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sexe=$_POST['sexe'];
        $sexe = filter_var($sexe, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $img=$_POST['img'];
        $img = filter_var($img, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dateNaissance=$_POST['dateNaissance'];
        $dateNaissance = filter_var($dateNaissance, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      
        $params = [
            ":nom" => $nom,
            ":prenom" => $prenom,
            ":sexe" => $sexe,
            ":img" => $img,
            ":dateNaissance" => $dateNaissance,
            ":pid" => $personId
        ];
        

        $query2 = $dao->executerRequete($sql, $params);

        header('Location: http://localhost:8888/Cinema-PDO/index.php?action=listActors');
        
    }

    require "views/actor/editActor.php";

}

public function findProducerDetailsById($producerId) {
    $dao = new DAO();


    // Avoir l'id_personne d'un producer
    $sqlSelectIdPerson = "SELECT pe.id_personne, re.id_realisateur FROM Personne pe, Realisateur re WHERE re.id_realisateur = :producerId AND re.id_personne = pe.id_personne";

    $params = [
        ":producerId" => $producerId  
      ];

    $selectIdPerson = $dao->executerRequete($sqlSelectIdPerson, $params);

    $sql = "SELECT pe.nom, pe.prenom, pe.img_personne, re.id_realisateur, re.id_personne, pe.id_personne,
            pe.dateNaissance, pe.sexe, DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), dateNaissance)), '%Y') 
            + 0 AS age
            FROM Personne pe, Realisateur re 
            WHERE re.id_realisateur = :producerId 
            AND re.id_personne = pe.id_personne";

    $params = [
        ":producerId" => $producerId  
      ];

    $selectActeur = $dao->executerRequete($sql, $params);

    $sqlFilmRole = "SELECT
                    fi.id_film, fi.titre_film
                         FROM Film fi
                         WHERE fi.id_realisateur = :producerId";

    $params = [
      ":producerId" => $producerId  
    ];

    $filmProducted = $dao->executerRequete($sqlFilmRole, $params);

    require "views/producer/detailProducer.php";

}

public function deleteProducer($personId){

    $dao = new DAO();

    if(isset($_POST["delete"])) {

        

        $sql = "DELETE FROM Personne WHERE id_personne = :pid";
        
        // Ajouter les filtres pour chaques type de donnée
        $params = [
            ":pid" => $personId
        ];
        

        $query = $dao->executerRequete($sql, $params);

        header('Location: http://localhost:8888/Cinema-PDO/index.php?action=listProducers');
        
    }
    
    // select commun pour la page edit ? 
    

    
    require "views/producer/detailProducer.php";

}

public function editProducer($personId) {

    $dao = new DAO();

    $sql = "SELECT pe.id_personne, re.id_realisateur, pe.nom, pe.prenom, pe.sexe, pe.img_personne, pe.dateNaissance
    FROM Personne pe, Realisateur re 
    WHERE pe.id_personne = :personId";

    $params = [
        ":personId" => $personId
    ];

    $query = $dao->executerRequete($sql, $params);

    if(isset($_POST["edit"])) {

        $sql = "UPDATE Personne
                SET nom=:nom,prenom=:prenom,sexe=:sexe,img_personne=:img,dateNaissance=:dateNaissance
                WHERE id_personne=:pid";

        $nom=$_POST['nom'];
        $nom = filter_var($nom, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $prenom=$_POST['prenom'];
        $prenom = filter_var($prenom, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sexe=$_POST['sexe'];
        $sexe = filter_var($sexe, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $img=$_POST['img'];
        $img = filter_var($img, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dateNaissance=$_POST['dateNaissance'];
        $dateNaissance = filter_var($dateNaissance, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      
        $params = [
            ":nom" => $nom,
            ":prenom" => $prenom,
            ":sexe" => $sexe,
            ":img" => $img,
            ":dateNaissance" => $dateNaissance,
            ":pid" => $personId
        ];
        

        $query2 = $dao->executerRequete($sql, $params);

        header('Location: http://localhost:8888/Cinema-PDO/index.php?action=listProducers');
        
    }

    require "views/producer/editProducer.php";

}

}

?>