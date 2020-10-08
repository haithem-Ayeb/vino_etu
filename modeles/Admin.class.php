<?php

/**
 * Class Admin
 * Cette classe possède les fonctions d'administration.
 *
 * @version 1.0
 * @update 2020-09-21
 */
class Admin extends Modele
{
    // La fonction ajoute un utilisateur admin/usager
    public function sqlAjouterAdmin($nom, $prenom, $iden, $mdp, $activation, $id_type)
    {
        $requete = "INSERT INTO vino__utilisateur (nom, prenom, identifiant,date_inscription, mdp, activation, id_type) VALUES ('$nom', '$prenom','$iden',NOW(), md5('$mdp'),'$activation', '$id_type')";

        if ($this->_db->query($requete)) {

            return true;
        }
    }

    // La fonction modifie un utilisateur
    public function sqlModificationUtilisateur($id, $nom, $prenom, $iden, $activation, $id_type)
    {
        $requete = "UPDATE vino__utilisateur SET nom = '$nom', prenom = '$prenom', identifiant = '$iden', activation = '$activation', id_type = '$id_type' WHERE id='$id'";

        if ($this->_db->query($requete)) {

            return true;
        }
    }

    // La fonction récupérer la liste des utilisateurs
    public function getListeUtilisateurs()
    {
        $requete = "SELECT v_c.id, nom, prenom, identifiant, v_c.activation, v_u_t.type FROM vino__utilisateur v_c JOIN vino__utilisateur_type v_u_t ON v_c.id_type = v_u_t.id WHERE v_c.id_type != 3";
        $res = $this->_db->query($requete);
      
        if ($res->num_rows) {
            while ($row = $res->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    // La fonction récupérer la liste des utilisateurs par id
    public function getUtilisateurById($id)
    {
        $requete = "SELECT * FROM vino__utilisateur WHERE id= " . $id;

        $res = $this->_db->query($requete);
        if ($res->num_rows) {
            while ($row = $res->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }

    //récuperer le nombre de nouvels usagers (par mois)
    public function getNombreNouveauUsagers()
    {
        $requete = "SELECT MONTH(date_inscription) 
        as MONTH ,YEAR(date_inscription) as year, count(id) as nombreUsers ,date_inscription
        FROM vino__utilisateur GROUP BY MONTH(date_inscription) ,YEAR(date_inscription) 
        ORDER BY date_inscription DESC";

        $res = $this->_db->query($requete);
        if ($res->num_rows) {
            while ($row = $res->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }
    // La fonction récupérer la liste des utilisateurs par id
    public function getListeUtilisateursById($id)
    {
        $requete = "SELECT * FROM vino__utilisateur AS  v_u WHERE v_u.id= ".$id;

        $res = $this->_db->query($requete);
        if ($res->num_rows) {
            while ($row = $res->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return $rows;
    }
}
