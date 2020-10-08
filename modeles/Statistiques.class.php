<?php
/**
 * Class Statistiques
 * Cette classe possède les fonctions de statistiques.
 * 
 * @author Chingiz Taghizade
 * @version 1.0
 * @update 2020-10-03
 */

class Statistiques extends Modele {
	
    
    // La fonction connaître le nombre d'usager dans la table vino__utilisateur
    
    public function sqlNombreUsager() {

    $requete = "SELECT count('id') FROM vino__utilisateur WHERE id_type=2";
             
    $res = $this->_db->query($requete);
    $rows = $res->fetch_assoc();
        
    return $rows;
   
}
        
    // La fonction connaître le nombre de cellier dans la table vino__cellier
    
    public function sqlNombreCellier() {

    $requete = "SELECT count('id') FROM vino__cellier";
             
    $res = $this->_db->query($requete);
    $rows = $res->fetch_assoc();
        
    return $rows;
   
}  
    
    // La fonction connaître le nombre de cellier par usager
    
    public function sqlNombreCellierParUsager() {

    $requete = "SELECT CONCAT(vino__utilisateur.nom,' ', vino__utilisateur.prenom) as usager,COUNT(vino__cellier.id) as nombre FROM vino__utilisateur 
    LEFT JOIN vino__cellier ON vino__utilisateur.id = vino__cellier.id_utilisateur WHERE vino__utilisateur.id_type=2
    GROUP BY vino__utilisateur.id";
             
    $res = $this->_db->query($requete);
    $rows = $res->fetch_all(MYSQLI_ASSOC);
        
    return $rows;
   
}     
    
    // La fonction connaître le nombre de bouteille par cellier
    
    public function sqlNombreBouteilleParCellier() {

    $requete = "SELECT vino__cellier.nom_cellier as nom, SUM(vino__cellier_bouteille.quantite) as nombre FROM vino__cellier_bouteille 
    LEFT JOIN vino__cellier ON vino__cellier_bouteille.id_cellier = vino__cellier.id
    GROUP BY vino__cellier_bouteille.id_cellier";
             
    $res = $this->_db->query($requete);
    $rows = $res->fetch_all(MYSQLI_ASSOC);
        
    return $rows;
   
} 
    
   // La fonction connaître le nombre de bouteille par usager
    
    public function sqlNombreBouteilleParUsager() {

    $requete = "SELECT CONCAT(vino__utilisateur.nom,' ', vino__utilisateur.prenom) as usager, SUM(vino__cellier_bouteille.quantite) as nombre FROM vino__cellier_bouteille 
    LEFT JOIN vino__cellier ON vino__cellier_bouteille.id_cellier = vino__cellier.id
    LEFT JOIN vino__utilisateur ON vino__utilisateur.id = vino__cellier.id_utilisateur WHERE vino__utilisateur.id_type=2
    GROUP BY vino__utilisateur.id";
             
    $res = $this->_db->query($requete);
    $rows = $res->fetch_all(MYSQLI_ASSOC);
        
    return $rows;
   
}     
    
    // La fonction connaître la valeur de bouteille par cellier
    
    public function sqlValeurBouteilleParCellier() {

    $requete = "SELECT vino__cellier.nom_cellier as nom, CONCAT(SUM(vino__cellier_bouteille.prix),' ','$') as valeur FROM vino__cellier_bouteille 
    LEFT JOIN vino__cellier ON vino__cellier_bouteille.id_cellier = vino__cellier.id
    GROUP BY vino__cellier_bouteille.id_cellier";
             
    $res = $this->_db->query($requete);
    $rows = $res->fetch_all(MYSQLI_ASSOC);
        
    return $rows;
   
} 
    
    // La fonction connaître la valeur de bouteille par usager
    
    public function sqlValeurBouteilleParUsager() {

    $requete = "SELECT CONCAT(vino__utilisateur.nom,' ', vino__utilisateur.prenom) as usager, CONCAT(SUM(vino__cellier_bouteille.prix),' ','$') as valeur FROM vino__cellier_bouteille 
    LEFT JOIN vino__cellier ON vino__cellier_bouteille.id_cellier = vino__cellier.id
    LEFT JOIN vino__utilisateur ON vino__utilisateur.id = vino__cellier.id_utilisateur WHERE vino__utilisateur.id_type=2
    GROUP BY vino__utilisateur.id";
             
    $res = $this->_db->query($requete);
    $rows = $res->fetch_all(MYSQLI_ASSOC);
        
    return $rows;
   
}    
    
    
   // La fonction connaître la valeur total des bouteilles dans la table vino__cellier_bouteille
    
    public function sqlValeurTotal() {

    $requete = "SELECT CONCAT(SUM(vino__cellier_bouteille.prix),' ','$') as valeur FROM vino__cellier_bouteille";
             
    $res = $this->_db->query($requete);
    $rows = $res->fetch_assoc();
        
    return $rows;
   
}
    

}

?>