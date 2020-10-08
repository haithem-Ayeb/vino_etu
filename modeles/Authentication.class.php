<?php

/**
 * Class Authentication
 * Cette classe possède les fonctions d'authentication.
 * 
 * @author Chingiz Taghizade
 * @version 1.0
 * @update 2020-09-11
 */
class Authentication extends Modele
{
    // La fonction contrôle l'authentification de l'utilisateur dans la table vino__utilisateur

    public function sqlIdentificationUtilisateur($identifiant, $mot_de_passe)
    {
        $requete = "SELECT * FROM vino__utilisateur WHERE identifiant='$identifiant' AND mdp = md5('$mot_de_passe') ";

        $res = $this->_db->query($requete);
        $rows = $res->fetch_assoc();

        return $rows;
    }

    //La fonction retourne la table vino__utilisateur comme un tableau  
    public function sqlVinoUtilisateur($identifiant)
    {
        $requete = "SELECT * FROM vino__utilisateur WHERE identifiant='$identifiant'";

        $res = $this->_db->query($requete);
        $rows = $res->fetch_assoc();

        return $rows;
    }

    // La fonction ajoute un utilisateur
    public function sqlAjouterUtilisateur($nom, $prenom, $iden, $mdp, $activation, $id_type)
    {
        $requete = "INSERT INTO vino__utilisateur (nom, prenom, identifiant, mdp, activation, id_type) VALUES ('$nom', '$prenom','$iden', md5('$mdp'), '$activation', '$id_type')";
        $this->_db->query($requete);

        return true;
    }

    // La fonction réinitialise le mot de passe d'utilisateur
    public function sqlReinitialiserMdp($identifiant, $mdp)
    {
        $requete = "UPDATE vino__utilisateur SET mdp = md5('$mdp') WHERE identifiant='$identifiant'";
        $this->_db->query($requete);

        return true;
    }
}
