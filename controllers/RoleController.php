<?php 



require_once "bdd/DAO.php";




    class RoleController {


        public function listRoles(){

            $dao = new DAO();
    
            $sql = "SELECT a.id_personne, a.id_acteur, j.id_acteur, p.id_personne, p.nom, p.prenom, j.id_role, r.id_role, r.nom_role,
                    j.id_film, f.id_film, f.titre_film
                    FROM Acteur a, Personne p, jouer j, Role r, Film f
                    WHERE a.id_acteur = j.id_acteur 
                    AND a.id_personne = p.id_personne
                    AND j.id_role = r.id_role
                    AND f.id_film = j.id_film";
    
            $roles = $dao->executerRequete($sql);
    
            require "views/role/listRoles.php";
    
        }


    }

?>