<?php 

require_once "bdd/DAO.php";

class AdminController {

   
    public function addMovie($array){

        $dao = new DAO();

        
        if(isset($_POST["add"])){


            $sql = "INSERT INTO Film (`id_film`, `annee_film`, `duree_film`, `titre_film`, `synopsis_film`, `note_film`, `img_film`, `id_realisateur`) 
                    VALUES (NULL, :date, :duree, :titre, :synopsis, :note, :imageToUpload, :realisateur);";


// Ajouter les filtres pour chaques type de données


                $date=$_POST['date'];
                $date = filter_var($date, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $duree=$_POST['duree'];
                $duree = filter_var($duree, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $titre=$_POST['titre'];
                $titre = filter_var($titre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $synopsis=$_POST['synopsis'];
                $synopsis = filter_var($synopsis, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $note=$_POST['note'];
                $note = filter_var($note, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                // a securiser avec un filtre, voir pour limiter les extensions
                $imageToUpload=$_FILES["imageToUpload"]["name"];
                
                $real=$_POST['realisateur'];
                $real = filter_var($real, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                


            
            $params =[
                ":titre" => $titre,
                ":realisateur" => $real,
                ":date" => $date,
                ":duree" => $duree,
                ":synopsis" => $synopsis,
                ":note" => $note,
                ":imageToUpload" => $imageToUpload
            ];

            
            $query = $dao->executerRequete($sql, $params);

            $lastInsertId = $dao->getBDD()->lastInsertId();

            $sqlGenre = "INSERT INTO posseder (`id_film`, `id_genre`) VALUES(:fid, :gid)";

            $genres = filter_var_array($array['genre']);

            foreach($genres as $genreActuel){
            $ajoutGenre = $dao->executerRequete($sqlGenre, [":gid" => $genreActuel, ":fid" => $lastInsertId]);
            } 

            if(isset($_FILES["imageToUpload"]["error"])){ 
                if($_FILES["imageToUpload"]["error"] > 0){ 
                echo "Error: " . $_FILES["imageToUpload"]["error"] . "<br>"; 
                } else{ 
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png"); 
                $filename = $_FILES["imageToUpload"]["name"]; 
                $filetype = $_FILES["imageToUpload"]["type"]; 
                $filesize = $_FILES["imageToUpload"]["size"]; 
                
                // Verify file extension 
                $ext = pathinfo($filename, PATHINFO_EXTENSION); 
                if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format."); 
                
                // Verify file size - 5MB maximum 
                $maxsize = 5 * 1024 * 1024; 
                if($filesize > $maxsize) die("Error: File size is larger than the allowed limit."); 
                
                // Verify MYME type of the file 
                if(in_array($filetype, $allowed)){ 
                // Check whether file exists before uploading it 
                if(file_exists("./public/images/" . $_FILES["imageToUpload"]["name"])){ 
                echo $_FILES["imageToUpload"]["name"] . " is already exists."; 
                } else{ 
                move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], "./public/images/" . $_FILES["imageToUpload"]["name"]); 
                echo "Your file was uploaded successfully."; 
                } 
                } 
                else
                { 
                echo "Error: There was a problem uploading your file - please try again."; 
                } 
                } 
                
                } else{ 
                echo "Error: Invalid parameters - please contact your server administrator."; 
                } 

            header('Location: http://localhost:8888/Cinema-PDO/index.php?action=listMovie');
        
        }
        
        require "views/administration/addMovie.php";
        
       

    }


    public function editMovie($filmId){

        $dao = new DAO();

        
        if(isset($_POST["edit"])){

            // update
            
            $sql = "UPDATE Film SET annee_film=:date,duree_film=:duree,titre_film=:titre,synopsis_film=:synopsis,note_film=:note,id_realisateur=:realisateur WHERE id_film=:fid";
            

            // Ajouter les filtres pour chaques type de données
                $date=$_POST['date'];
                $date = filter_var($date, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $duree=$_POST['duree'];
                $duree = filter_var($duree, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $titre=$_POST['titre'];
                $titre = filter_var($titre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $synopsis=$_POST['synopsis'];
                $synopsis = filter_var($synopsis, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $note=$_POST['note'];
                $note = filter_var($note, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $real=$_POST['realisateur'];
                $real = filter_var($real, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $params =[
                ":date" => $date,
                ":duree" => $duree,
                ":titre" => $titre,
                ":synopsis" => $synopsis,
                ":note" => $note,
                ":realisateur" => $real,
                ":fid" => $filmId
            ];

            $query = $dao->executerRequete($sql, $params);

            header('Location: http://localhost:8888/Cinema-PDO/index.php?action=listMovie');

        } elseif(isset($_POST["delete"])) {

            $filmId = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

            $sql = 'DELETE FROM Film WHERE id_film = :fid';
            
            // Ajouter les filtres pour chaques type de donnée
            $params = [
                ":fid" => $filmId
            ];
            

            $query = $dao->executerRequete($sql, $params);

            header('Location: http://localhost:8888/Cinema-PDO/index.php?action=listMovie');

        }

        // select commun pour la page edit ? 
    
        $sql = "SELECT f.id_film, f.id_realisateur, f.titre_film, f.annee_film, f.duree_film, f.synopsis_film, f.note_film, f.img_film
            FROM Film f
            WHERE f.id_film = :filmId";

        $sql2 = "SELECT pe.nom, pe.prenom, re.id_realisateur
        FROM Personne pe, Realisateur re, Film fi
        WHERE re.id_personne = pe.id_personne
        AND fi.id_realisateur != re.id_realisateur
        AND fi.id_film = :filmId";

        $sql3 = "SELECT fi.id_realisateur, re.id_realisateur, pe.nom, pe.prenom, fi.id_film, re.id_personne, pe.id_personne
        FROM Film fi, Realisateur re, Personne pe
        WHERE re.id_realisateur = fi.id_realisateur
        AND pe.id_personne = re.id_personne
        AND fi.id_film = :filmId";
            
        $params = array(':filmId' => $filmId);
        $movie = $dao->executerRequete($sql, $params);
        $realisateurs = $dao->executerRequete($sql2, $params);
        $realisateurs2 = $dao->executerRequete($sql3, $params);

        require "views/administration/editMovie.php";

    }



    public function addActeur(){
        
            $dao = new DAO();

        if(isset($_POST["add"])){


            $sql = "INSERT INTO Personne (`id_personne`, `nom`, `prenom`, `sexe`, `img_personne`, `dateNaissance`) VALUES (NULL, :nom, :prenom, :sexe, :imageToUpload, :dateNaissance);
                    SET @last_id_in_Personne = LAST_INSERT_ID();
                    INSERT INTO Acteur (`id_acteur`, `id_personne`) VALUES (NULL, @last_id_in_Personne);";


// Ajouter les filtres pour chaques type de données


                $nom=$_POST['nom'];
                $nom = filter_var($nom, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $prenom=$_POST['prenom'];
                $prenom = filter_var($prenom, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $sexe=$_POST['sexe'];
                $sexe = filter_var($sexe, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $imageToUpload=$_FILES["imageToUpload"]["name"];

                $dateNaissance=$_POST['dateNaissance'];
                $dateNaissance = filter_var($dateNaissance, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                


            
            $params =[
                ":nom" => $nom,
                ":prenom" => $prenom,
                ":sexe" => $sexe,
                ":dateNaissance" => $dateNaissance,
                ":imageToUpload" => $imageToUpload
            ];

            
            $query = $dao->executerRequete($sql, $params);

            if(isset($_FILES["imageToUpload"]["error"])){ 
                if($_FILES["imageToUpload"]["error"] > 0){ 
                echo "Error: " . $_FILES["imageToUpload"]["error"] . "<br>"; 
                } else{ 
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png"); 
                $filename = $_FILES["imageToUpload"]["name"]; 
                $filetype = $_FILES["imageToUpload"]["type"]; 
                $filesize = $_FILES["imageToUpload"]["size"]; 
                
                // Verify file extension 
                $ext = pathinfo($filename, PATHINFO_EXTENSION); 
                if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format."); 
                
                // Verify file size - 5MB maximum 
                $maxsize = 5 * 1024 * 1024; 
                if($filesize > $maxsize) die("Error: File size is larger than the allowed limit."); 
                
                // Verify MYME type of the file 
                if(in_array($filetype, $allowed)){ 
                // Check whether file exists before uploading it 
                if(file_exists("./public/images/" . $_FILES["imageToUpload"]["name"])){ 
                echo $_FILES["imageToUpload"]["name"] . " is already exists."; 
                } else{ 
                move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], "./public/images/" . $_FILES["imageToUpload"]["name"]); 
                echo "Your file was uploaded successfully."; 
                } 
                } 
                else
                { 
                echo "Error: There was a problem uploading your file - please try again."; 
                } 
                } 
                
                } else{ 
                echo "Error: Invalid parameters - please contact your server administrator."; 
                } 

            header('Location: http://localhost:8888/Cinema-PDO/index.php?action=listActors');
        
        }
        
        require "views/administration/addActor.php";
        
       

    }

    public function addProducer(){
        
        $dao = new DAO();

    if(isset($_POST["add"])){


        $sql = "INSERT INTO Personne (`id_personne`, `nom`, `prenom`, `sexe`, `img_personne`, `dateNaissance`) VALUES (NULL, :nom, :prenom, :sexe, :imageToUpload, :dateNaissance);
                SET @last_id_in_Personne = LAST_INSERT_ID();
                INSERT INTO Realisateur (`id_realisateur`, `id_personne`) VALUES (NULL, @last_id_in_Personne);";


// Ajouter les filtres pour chaques type de données


            $nom=$_POST['nom'];
            $nom = filter_var($nom, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom=$_POST['prenom'];
            $prenom = filter_var($prenom, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $sexe=$_POST['sexe'];
            $sexe = filter_var($sexe, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $imageToUpload=$_FILES["imageToUpload"]["name"];

            $dateNaissance=$_POST['dateNaissance'];
            $dateNaissance = filter_var($dateNaissance, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            


        
        $params =[
            ":nom" => $nom,
            ":prenom" => $prenom,
            ":sexe" => $sexe,
            ":dateNaissance" => $dateNaissance,
            ":imageToUpload" => $imageToUpload
        ];

        
        $query = $dao->executerRequete($sql, $params);

        if(isset($_FILES["imageToUpload"]["error"])){ 
            if($_FILES["imageToUpload"]["error"] > 0){ 
            echo "Error: " . $_FILES["imageToUpload"]["error"] . "<br>"; 
            } else{ 
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png"); 
            $filename = $_FILES["imageToUpload"]["name"]; 
            $filetype = $_FILES["imageToUpload"]["type"]; 
            $filesize = $_FILES["imageToUpload"]["size"]; 
            
            // Verify file extension 
            $ext = pathinfo($filename, PATHINFO_EXTENSION); 
            if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format."); 
            
            // Verify file size - 5MB maximum 
            $maxsize = 5 * 1024 * 1024; 
            if($filesize > $maxsize) die("Error: File size is larger than the allowed limit."); 
            
            // Verify MYME type of the file 
            if(in_array($filetype, $allowed)){ 
            // Check whether file exists before uploading it 
            if(file_exists("./public/images/" . $_FILES["imageToUpload"]["name"])){ 
            echo $_FILES["imageToUpload"]["name"] . " is already exists."; 
            } else{ 
            move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], "./public/images/" . $_FILES["imageToUpload"]["name"]); 
            echo "Your file was uploaded successfully."; 
            } 
            } 
            else
            { 
            echo "Error: There was a problem uploading your file - please try again."; 
            } 
            } 
            
            } else{ 
            echo "Error: Invalid parameters - please contact your server administrator."; 
            } 

        header('Location: http://localhost:8888/Cinema-PDO/index.php?action=listProducers');
    
    }
    
    require "views/producer/addProducer.php";
    
   

}

    
}

?>