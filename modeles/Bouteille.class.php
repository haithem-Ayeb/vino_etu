<?php

/**
 * Class Bouteille
 * Cette classe possède les fonctions de gestion des bouteilles dans le cellier et des bouteilles dans le catalogue complet.
 * 
 * @author Jonathan Martel
 * @version 1.0
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */
class Bouteille extends Modele
{
	const TABLE = 'vino__bouteille';

	public function getListeBouteille()
	{

		$rows = array();
		$res = $this->_db->query('Select * from ' . self::TABLE);
		if ($res->num_rows) {
			while ($row = $res->fetch_assoc()) {
				$rows[] = $row;
			}
		}

		return $rows;
	}

	public function getListeBouteilleCellier($id_cellier='',$pays='',$type =''/*,$quantite ='',$millesime=''*/)
	{

		$rows = array();
		$requete = 'SELECT 
		v_c_b.id_cellier,v_c_b.id_bouteille,v_c_b.date_achat,
		v_c_b.garde_jusqua,v_c_b.notes,v_c_b.prix,v_c_b.quantite,v_c_b.millesime,
		v_b.nom,v_b_t.type,v_b.url_saq,v_b.image,
		v_c.nom_cellier,v_c_b.quantite,v_b.pays
		FROM vino__cellier_bouteille AS v_c_b 
        INNER JOIN vino__cellier v_c ON v_c.id = v_c_b.id_cellier 
        INNER JOIN vino__bouteille v_b ON v_b.id = v_c_b.id_bouteille 
		INNER JOIN vino__bouteille_type v_b_t ON v_b_t.id = v_b.id_type
		INNER JOIN vino__utilisateur v_u ON v_u.id = v_c.id_utilisateur
		
		';
	if(!empty($id_cellier)){ 
	$requete.=" WHERE v_c_b.id_cellier ='".$id_cellier."'";
	}
	if(!empty($type)){ 
		$requete.=" AND v_b_t.type ='".$type."'";
	}
	if(!empty($quantite)){ 
		
		$requete.=" AND v_c_b.quantite ='".$quantite."'";
		
	}
	if(!empty($pays)){ 
		$requete.=" AND v_b.pays ='".$pays."'";
	}
	if(!empty($millesime)){ 
		$requete.=" AND v_b.millesime ='".$millesime."'";
	}
		if (($res = $this->_db->query($requete)) ==	 true) {
			if ($res->num_rows) {
				while ($row = $res->fetch_assoc()) {
					$row['nom'] = trim(utf8_encode($row['nom']));
					$rows[] = $row;
				}
			}
		} else {
			throw new Exception("Erreur de requête sur la base de donnée", 1);
			//$this->_db->error;
		}
		return $rows;
	}
	/**
	 * Cette méthode récupère la liste des noms des celliers
	 * de l'utilisateur connecté 
	 * 
	 */
	public function lireCelliers(){
		$rows = array();
		$res = $this->_db->query('Select * from vino__cellier');
		if ($res->num_rows) {
			while ($row = $res->fetch_assoc()) {
				$rows[] = $row;
			}
		}

		return $rows;
	}

	/**
	 * Cette méthode permet de retourner les résultats de recherche pour la fonction d'autocomplete de l'ajout des bouteilles dans le cellier
	 * 
	 * @param string $nom La chaine de caractère à rechercher
	 * @param integer $nb_resultat Le nombre de résultat maximal à retourner.
	 * 
	 * @throws Exception Erreur de requête sur la base de données 
	 * 
	 * @return array id et nom de la bouteille trouvée dans le catalogue
	 */

	public function autocomplete($nom, $nb_resultat = 10)
	{

		$rows = array();
		$nom = $this->_db->real_escape_string($nom);
		$nom = preg_replace("/\*/", "%", $nom);

		//echo $nom;
		$requete = 'SELECT id, nom FROM vino__bouteille where LOWER(nom) like LOWER("%' . $nom . '%") LIMIT 0,' . $nb_resultat;
		//var_dump($requete);
		if (($res = $this->_db->query($requete)) ==	 true) {
			if ($res->num_rows) {
				while ($row = $res->fetch_assoc()) {
					$row['nom'] = trim(utf8_encode($row['nom']));
					$rows[] = $row;
				}
			}
		} else {
			throw new Exception("Erreur de requête sur la base de données", 1);
		}


		//var_dump($rows);
		return $rows;
	}


	/**
	 * Cette méthode ajoute une ou des bouteilles au cellier
	 * 
	 * @param Array $data Tableau des données représentants la bouteille.
	 * 
	 * @return Boolean Succès ou échec de l'ajout.
	 */
	public function ajouterBouteilleCellier($data)
	{
		//TODO : Valider les données.
		//var_dump($data);	

		$requete = "INSERT INTO vino__cellier_bouteille(id_bouteille, id_cellier,date_achat,garde_jusqua,notes,prix,quantite,millesime) VALUES (" .
			"'" . $data->id_bouteille . "'," .
			"'" . $data->id_cellier . "'," .
			"'" . $data->date_achat . "'," .
			"'" . $data->garde_jusqua . "'," .
			"'" . $data->notes . "'," .
			"'" . $data->prix . "'," .
			"'" . $data->quantite . "'," .
			"'" . $data->millesime . "')";

		$res = $this->_db->query($requete);

		return $res;
	}


	/**
	 * Cette méthode change la quantité d'une bouteille en particulier dans le cellier
	 * 
	 * @param int $id id de la bouteille
	 * @param int $nombre Nombre de bouteille a ajouter ou retirer
	 * 
	 * @return Boolean Succès ou échec de l'ajout.
	 */
	public function modifierQuantiteBouteilleCellier($id_bouteille, $nombre, $id_cellier)
	{
		//TODO : Valider les données.
		$requete = "UPDATE vino__cellier_bouteille SET quantite = GREATEST(quantite + " . $nombre . ", 0) WHERE id_bouteille = " . $id_bouteille . " AND id_cellier = " . $id_cellier;
		//echo $requete;
		$res = $this->_db->query($requete);

		return $res;
	}

	//Fonction pour consulter la quantite des bouteilles by id 	
	public function getQuantiteById($id_bouteille, $id_cellier)
	{
		$requete = "SELECT quantite FROM vino__cellier_bouteille WHERE id_bouteille = " . $id_bouteille . " AND id_cellier = " . $id_cellier;
		$res = $this->_db->query($requete);
		$row = $res->fetch_assoc();
		return $row;
	}

	//Fonction pour récuperer la liste des celliers
	public function getListeCelliers()
	{
		$rows = array();
		$requete = 'SELECT * FROM vino__cellier AS v_c';

		if (($res = $this->_db->query($requete)) ==	 true) {
			if ($res->num_rows) {
				while ($row = $res->fetch_assoc()) {
					$row['nom_cellier'] = trim(utf8_encode($row['nom_cellier']));
					$rows[] = $row;
				}
			}
		} else {
			throw new Exception("Erreur de requête sur la base de donnée", 1);
			//$this->_db->error;
		}
		return $rows;
	}


	//Fonction pour ajouter un nouveau cellier
	public function ajouterCellier($id_utilisateur, $nom_cellier) {
		$requete = "INSERT INTO vino__cellier (id_utilisateur, nom_cellier) VALUES (" . $id_utilisateur . "," . "'" . $nom_cellier . "')";
		$res = $this->_db->query($requete);
		return $res; 
	}
}
