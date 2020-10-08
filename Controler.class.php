<?php

/**
 * Class Controler
 * Gère les requêtes HTTP
 * 
 * @author Jonathan Martel
 * @version 1.0
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */
class Controler
{
	/**
	 * Traite la requête
	 * @return void
	 */
	public function gerer()
	{
		switch ($_GET['requete']) {
			case 'listeBouteille':
				$this->isAuth();
				$this->listeBouteille();
				break;
			case 'autocompleteBouteille':
				$this->isAuth();
				$this->autocompleteBouteille();
				break;
			case 'ajouterNouvelleBouteilleCellier':
				$this->isAuth();
				$this->ajouterNouvelleBouteilleCellier($_SESSION['utilisateur_id']);
				break;
			case 'ajouterBouteilleNonListee';
				$this->isAuth();
				$this->ajouterBouteilleNonListee($_SESSION['utilisateur_id']);
				break;
			case 'ajouterBouteilleCellier':
				$this->isAuth();
				$this->ajouterBouteilleCellier();
				break;
			case 'boireBouteilleCellier':
				$this->isAuth();
				$this->boireBouteilleCellier();
				break;
			case 'consulterQuantiteBouteilleCellier':
				$this->isAuth();
				$this->consulterQuantiteBouteilleCellier($_GET['id_bouteille'], $_GET['id_cellier']);
				break;
			case 'accueil':
				$this->isAuth();
				$this->accueil($_SESSION['utilisateur_id']);
				break;
			case 'nouveauUtilisateur':
				$this->nouveauUtilisateur();
				break;
			case 'getListeCelliers':
				$this->isAuth();
				$this->getListeCelliers($_SESSION['utilisateur_id']);
				break;
			case 'ajouterNouveauCellier':
				$this->isAuth();
				$body = json_decode(file_get_contents('php://input'));
				$this->ajouterNouveauCellier($_SESSION['utilisateur_id'], $body->nom_cellier);
				break;
			case 'actualiserCellier':
				$this->isAuth();
				$body = json_decode(file_get_contents('php://input'));
				$this->modifierCellier($body->nom_cellier, $body->id_cellier);
				break;
			case 'supprimerCellier':
				$this->isAuth();
				$body = json_decode(file_get_contents('php://input'));
				$this->supprimerCellier($body->id_cellier);
				break;
			case 'getInfosBouteille':
				$this->isAuth();
				$this->getInfosBouteille($_GET['id_bouteille'], $_GET['id_cellier']);
				break;
			case 'modifierBouteille':
				$this->isAuth();
				$body = json_decode(file_get_contents('php://input'));
				$this->modifierBouteilleInfos(
					$body->id_bouteille,
					$body->id_cellier,
					$body->date_achat,
					$body->garde_jusqua,
					$body->notes,
					$body->prix,
					$body->quantite,
					$body->millesime
				);
				break;
			case 'retirerBouteille':
				$this->isAuth();
				$body = json_decode(file_get_contents('php://input'));
				$this->retirerBouteille($body->id_bouteille, $body->id_cellier);
				break;
			case 'reinitialiserMdp':
				$this->reinitialiserMdp();
				break;
			case 'quitter':
				$this->quitter();
				break;
			case 'nouveauAdminUtilisateur':
				$this->isAuth();
				$this->nouveauAdminUtilisateur();
				break;
			case 'pageModificationUtilisateur':
				$this->isAuth();
				$this->getInfosUtilisateur($_GET['id']);
				break;
			case 'modificationUtilisateur':
				$this->isAuth();
				$body = json_decode(file_get_contents('php://input'));
				$this->modificationUtilisateur($body->id, $body->nom, $body->prenom, $body->identifiant, $body->activation, $body->id_type);
				break;
			case 'admin':
				$this->isAuth();
				if ($_SESSION['utilisateur_type'] == 1 || $_SESSION['utilisateur_type'] == 3) {
					$this->admin();
				} else {
					header('Location: index.php');
				}
				break;
			case 'getNombreNouveauUsagers':
				$this->isAuth();
				$this->getNombreNouveauUsagers();
				break;
			case 'getNombreNouveauUsagers':
				$this->isAuth();
				$this->getNombreNouveauUsagers();
				break;
			case 'getStatistiques':
				$this->isAuth();
				$this->getStatistiques(isset($_GET['intervalle']) ? $_GET['intervalle'] : '');
				break;
			default:
				$this->authentification();
				break;
		}
	}

	private function accueil($id_utilisateur)
	{
		$bte = new Bouteille();

		if (empty($_GET['idCellier']) && empty($_GET['paysOption'])  && empty($_GET['typeOption'])) { //tous les param sont vide
			if ($_SESSION['utilisateur_type'] == 2) {
				$data = $bte->getListeBouteilleCellier($_GET['idCellier'] = '', $_GET['paysOption'] = '', $_GET['typeOption'] = '', $id_utilisateur);
			} else {
				$data = $bte->getListeBouteilleCellier();
			}
		} elseif (empty($_GET['idCellier']) && !empty($_GET['paysOption']) && !empty($_GET['typeOption'])) { //pays+type
			$data = $bte->getListeBouteilleCellier($_GET['idCellier'] = '', $_GET['paysOption'], $_GET['typeOption']);
		} elseif (!empty($_GET['idCellier']) && !empty($_GET['paysOption']) && empty($_GET['typeOption'])) { //pays+cellier
			$data = $bte->getListeBouteilleCellier($_GET['idCellier'], $_GET['paysOption'], $_GET['typeOption'] = '');
		} elseif (!empty($_GET['idCellier']) && empty($_GET['paysOption']) && empty($_GET['typeOption'])) { //cellier
			$data = $bte->getListeBouteilleCellier($_GET['idCellier'], $_GET['paysOption'] = '', $_GET['typeOption'] = '');
		} elseif (empty($_GET['idCellier']) && empty($_GET['paysOption']) && !empty($_GET['typeOption'])) { //type
			$data = $bte->getListeBouteilleCellier($_GET['idCellier'] = '', $_GET['paysOption'] = '', $_GET['typeOption']);
		} elseif (empty($_GET['idCellier']) && !empty($_GET['paysOption']) && empty($_GET['typeOption'])) { //pays
			$data = $bte->getListeBouteilleCellier($_GET['idCellier'] = '', $_GET['paysOption'], $_GET['typeOption'] = '');
		} elseif (!empty($_GET['idCellier']) && empty($_GET['paysOption']) && !empty($_GET['typeOption'])) { //cellier+type
			$data = $bte->getListeBouteilleCellier($_GET['idCellier'], $_GET['paysOption'] = '', $_GET['typeOption']);
		} elseif (!empty($_GET['idCellier']) && !empty($_GET['paysOption']) && !empty($_GET['typeOption'])) { //pays+cellier+type
			$data = $bte->getListeBouteilleCellier($_GET['idCellier'], $_GET['paysOption'], $_GET['typeOption']);
		}

		if ($_SESSION['utilisateur_type'] == 1 || $_SESSION['utilisateur_type'] == 3) {
			$listeCelliers = $bte->lireCelliers();
			$dataCellier = json_encode($listeCelliers);
		} elseif ($_SESSION['utilisateur_type'] == 2) {

			$listeCelliers =  $bte->lireCelliers($_SESSION['utilisateur_id']);
			$dataCellier = json_encode($listeCelliers);
		}
		include("vues/entete.php");
		include("vues/cellier.php");
		include("vues/pied.php");
	}

	private function listeBouteille()
	{
		$bte = new Bouteille();
		$cellier = $bte->getListeBouteilleCellier();
		return json_encode($cellier);
	}

	private function autocompleteBouteille()
	{
		$bte = new Bouteille();
		//var_dump(file_get_contents('php://input'));
		$body = json_decode(file_get_contents('php://input'));
		//var_dump($body);
		$listeBouteille = $bte->autocomplete($body->nom);

		echo json_encode($listeBouteille);
	}

	private function ajouterNouvelleBouteilleCellier($id_utilisateur)
	{
		$body = json_decode(file_get_contents('php://input'));
		$bte = new Bouteille();
		if (!empty($body)) {
			$resultat = $bte->ajouterBouteilleCellier($body);
			echo json_encode($resultat);
		} else {
			$data = $this->listeBouteille();
			$listeCelliers = $bte->lireCelliers($id_utilisateur);
			$dataCellier = json_encode($listeCelliers);
			$z = $bte->getListeTypeVin();
			include("vues/entete.php");
			include("vues/ajouter.php");
			include("vues/pied.php");
		}
	}


	private function ajouterBouteilleNonListee($id_utilisateur)
	{
		$bte = new Bouteille();
		$body = json_decode(file_get_contents('php://input'));
		$data2 = $bte->ajoutBouteilleNonListee(
			$body->nom,
			$body->url_img,
			$body->pays,
			$body->description,
			$body->prix_saq,
			$body->format,
			$body->id_type,
			$id_utilisateur
		);
		//echo json_encode($data2,true);
		echo json_decode($data2, true);
	}


	private function boireBouteilleCellier()
	{
		$body = json_decode(file_get_contents('php://input'));

		$bte = new Bouteille();
		$resultat = $bte->modifierQuantiteBouteilleCellier($body->id_bouteille, -1, $body->id_cellier);
		$bte->aditionerStatsBouteille($body->id_bouteille, 1, 1);
		echo json_encode($resultat);
	}

	private function ajouterBouteilleCellier()
	{
		$body = json_decode(file_get_contents('php://input'));

		$bte = new Bouteille();
		$resultat = $bte->modifierQuantiteBouteilleCellier($body->id_bouteille, 1, $body->id_cellier);
		$bte->aditionerStatsBouteille($body->id_bouteille, 1, 2);
		echo json_encode($resultat);
	}

	private function consulterQuantiteBouteilleCellier($id_bouteille, $id_cellier)
	{
		$bte = new Bouteille();
		$resultat = $bte->getQuantiteById($id_bouteille, $id_cellier);
		echo json_encode($resultat);
	}

	// La fonction contrôle l'authentification 
	private function authentification()
	{
		$auth = new Authentication();

		if (isset($_POST['envoi'])) {
			$identifiant = trim($_POST['identifiant']);
			$mot_de_passe = trim($_POST['mdp']);
			$bte = new Bouteille();

			if (!empty($auth->sqlIdentificationUtilisateur($identifiant, $mot_de_passe))) {
				$rows = $auth->sqlVinoUtilisateur($identifiant);
				$type = $rows['id_type'];
				$id = $rows['id'];
				$nom = $rows['nom'];
				$prenom = $rows['prenom'];
				$activation = $rows['activation'];
				$_SESSION['utilisateur_identifiant'] = $identifiant;
				$_SESSION['utilisateur_id'] = $id;
				$_SESSION['utilisateur_type'] = $type;
				$_SESSION['utilisateur_nom'] = $nom;
				$_SESSION['utilisateur_prenom'] = $prenom;
				$celliers = $bte->lireCelliers($id);
				if ($activation == 1) {
					if ($type == 1 || $type == 3) {
						$this->accueil($id);
						exit;
					} elseif (empty($celliers)) {
						$this->ajouterNouvelleBouteilleCellier($id);
						exit;
					} elseif ($type == 2 && !empty($celliers)) {
						$this->accueil($id);
						exit;
					}
				} else {
					$erreur = "Accès bloqué.";
				}
			} else {
				$erreur = "Identifiant ou mot de passe incorrect.";
			}
		}

		include("vues/entete_basique.php");
		include("vues/authentification.php");
		include("vues/pied.php");
	}

	// La fonction ajoute un utilisateur
	private function nouveauUtilisateur()
	{
		$auth = new Authentication();

		if (count($_POST) !== 0) {

			$oUtilisateur = new Utilisateur($_POST['nom'], $_POST['prenom'], $_POST['identifiant'], $_POST['mdp']);
			$erreurs = $oUtilisateur->erreurs;

			if (count($erreurs) === 0) {

				$iden = trim($_POST['identifiant']);
				$rows = $auth->sqlVinoUtilisateur($iden);
				$tiden = $rows['identifiant'];

				if ($tiden == $iden) {
					$message = "identifiant existe dans le système";
					unset($_POST);
				} elseif ($tiden != $iden) {
					$auth->sqlAjouterUtilisateur($oUtilisateur->nom, $oUtilisateur->prenom, $oUtilisateur->identifiant, $oUtilisateur->mdp, 1, 2);
					$message = "Utilisateur ajouté";
					unset($_POST);
				} else {
					$message = "Utilisateur n'est pas ajouté";
					unset($_POST);
				}
			}
		} else {
			$erreurs = [];
			$oUtilisateur = new Utilisateur;
		}

		include("vues/entete_basique.php");
		include("vues/nouveauUtilisateur.php");
		include("vues/pied.php");
	}

	// La fonction pour redirection vers la page index.php pour la saisie de l'identifiant et du mot de passe  
	private function isAuth()
	{
		if (!$_SESSION['utilisateur_identifiant']) {

			header('Location: index.php');
		}
	}

	// La fonction pour déconnecter
	private function quitter()
	{
		session_start();
		unset($_SESSION['identifiant_utilisateur']);
		unset($_SESSION['utilisateur_id']);
		unset($_SESSION['utilisateur_type']);
		session_unset();
		session_destroy();
		header('Location: index.php');
	}

	// La fonction réinitialise le mot de passe d'utilisateur
	private function reinitialiserMdp()
	{
		$auth = new Authentication();

		if (isset($_POST['reinitialise']) && isset($_POST['identifiant'])) {

			$iden = trim($_POST['identifiant']);

			$rows = $auth->sqlVinoUtilisateur($iden);
			$tiden = $rows['identifiant'];

			if ($tiden == $iden) {
				$longueur = 8;
				$caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
				$mdp = substr(str_shuffle($caracteres), 0, $longueur);

				if ($auth->sqlReinitialiserMdp($iden, $mdp) === true) {
					$message = "Le mot de passe a été réinitialisé.Votre nouveau mot de passe: <br />" . $mdp;
					unset($_POST);
				} else {
					$message = "Il ya de probleme avec mot de passe";
					unset($_POST);
				}
			} else {
				$message = "L'utilisateur avec cet identifiant n'existe pas dans le système";
				unset($_POST);
			}
		}
		include("vues/entete_basique.php");
		include("vues/reinitialiserMdp.php");
		include("vues/pied.php");
	}
	// La fonction redirige l'utilisateur vers la page gestion d'administration    
	private function admin()
	{
		$admin = new Admin();
		$data = $admin->getListeUtilisateurs();
		$data = json_encode($data);

		include("vues/entete.php");
		include("vues/admin.php");
		include("vues/pied.php");
	}

	// La fonction ajoute un utilisateur
	private function nouveauAdminUtilisateur()
	{
		$admin = new Admin();
		$util =  new Authentication();

		if (count($_POST) !== 0) {
			if ($_POST['type'] == 'administrateur') {

				$type = 1;
			} else $type = 2;

			$oUtilisateur = new Utilisateur($_POST['nom'], $_POST['prenom'], $_POST['identifiant'], $_POST['mdp']);
			$erreurs = $oUtilisateur->erreurs;

			if (count($erreurs) === 0) {

				$iden = trim($_POST['identifiant']);
				$rows = $util->sqlVinoUtilisateur($iden);
				$tiden = $rows['identifiant'];

				if ($tiden == $iden) {
					$message = "L'utilisateur avec cet identifiant déjà existe dans le système";
					unset($_POST);
				} elseif ($tiden != $iden) {
					$admin->sqlAjouterAdmin($oUtilisateur->nom, $oUtilisateur->prenom, $oUtilisateur->identifiant, $oUtilisateur->mdp, 1, $type);
					$message = "L'utilisateur bien ajouté";
					unset($_POST);
				} else {
					$message = "L'utilisateur n'est pas ajouté";
					unset($_POST);
				}
			}
		} else {
			$erreurs = [];
			$oUtilisateur = new Utilisateur;
		}

		include("vues/entete.php");
		include("vues/adminUtilisateur.php");
		include("vues/pied.php");
	}

	// Récupération des informations à changer
	private function getInfosUtilisateur($id_util)
	{
		$admin = new Admin();
		$data = $admin->getUtilisateurById($id_util);
		$data = json_encode($data);
		//var_dump($data); 
		include("vues/entete.php");
		include("vues/modifier_utilisateur.php");
		include("vues/pied.php");
	}

	// La fonction modifie un utilisateur
	private function modificationUtilisateur($id, $nom, $prenom, $identifiant, $activation, $id_type)
	{
		$admin = new Admin();
		$data = $admin->sqlModificationUtilisateur($id, $nom, $prenom, $identifiant, $activation, $id_type);

		return $data;

		include("vues/entete.php");
		include("vues/pied.php");
	}

	//Fonction pour supprimer un cellier
	/*private function supprimerUtilisateur($id_util)
	{
		$admin = new Admin();

		if ($id_util != $_SESSION['utilisateur_id']) {
			$data = $admin->supprimerUtilisateur($id_util);
			if (!$data) {
				http_response_code(417);
			}
		}
	}*/
	//Fonction pour récupérer la liste des celliers 
	private function getListeCelliers($id_utilisateur)
	{
		$bte = new Bouteille();
		$data = $bte->lireCelliers($id_utilisateur);
		$data = json_encode($data);
		if ($_SESSION['utilisateur_type'] == 1) {
			$this->accueil($id_utilisateur);
			exit;
		} else {
			$data = $bte->lireCelliers($id_utilisateur);
			$data = json_encode($data);
		}

		include("vues/entete.php");
		include("vues/ajouter_cellier.php");
		include("vues/pied.php");
	}

	//Fonction pour ajouter un nouveau cellier 
	private function ajouterNouveauCellier($id_utilisateur, $nom_cellier)
	{
		$bte = new Bouteille();
		$data = $bte->ajouterCellier($id_utilisateur, $nom_cellier);
		return $data;
	}

	//Fonction pour modifier un cellier 
	private function modifierCellier($nom_cellier, $id_cellier)
	{
		$bte = new Bouteille();
		$data = $bte->modifierCellier($nom_cellier, $id_cellier);
		return $data;
	}

	//Fonction pour supprimer un cellier
	private function supprimerCellier($id_cellier)
	{
		$bte = new Bouteille();
		$data = $bte->supprimerCellier($id_cellier);
		if (!$data) {
			http_response_code(417);
		}
	}

	//infos bouteille par id bouteille et id cellier
	private function getInfosBouteille($id_bouteille, $id_cellier)
	{
		$bte = new Bouteille();

		if (!empty($body)) {
			$resultat = $bte->lireBouteille($id_bouteille, $id_cellier);
			echo json_encode($resultat);
		} else {
			$data = $bte->lireBouteille($id_bouteille, $id_cellier);
			//$tousCelliers = $bte->lireCelliers();
			//$dataCellier = json_encode($tousCelliers);
			include("vues/entete.php");
			include("vues/modifier_bouteille.php");
			include("vues/pied.php");
		}
	}

	//modification d une bouteille
	private function modifierBouteilleInfos($id_bouteille, $id_cellier, $date_achat, $garde_jusqua, $notes, $prix, $quantite, $millesime)
	{
		//checker si l'utilisateur à le droit de modifier
		$bte = new Bouteille();
		$body = json_decode(file_get_contents('php://input'));
		$data = $bte->modifierBouteille($id_bouteille, $id_cellier, $date_achat, $garde_jusqua, $notes, $prix, $quantite, $millesime);

		return $data;
	}

	//supprimer une bouteille d'un cellier
	private function retirerBouteille($id_bouteille, $id_cellier)
	{
		//checker si l'utilisateur à le droit de modifier
		$bte = new Bouteille();
		$dataRetirerBouteille = $bte->retirerBouteille($id_bouteille, $id_cellier);
		if (!$dataRetirerBouteille) {
			http_response_code(417);
		}
	}

	//statistiques des usagers
	// fonction qui renvoie le nombre de nouveaux usagers
	private function getNombreNouveauUsagers()
	{
		$admin = new Admin();
		$data = $admin->getNombreNouveauUsagers();
		$data = json_encode($data);
		$stat = new Statistiques();
		$celUsager = $stat->sqlNombreCellierParUsager();
		$nbUsager = $stat->sqlNombreUsager();
		$nbCellier = $stat->sqlNombreCellier();

		include("vues/entete.php");
		include("vues/statistiques_utilisateurs.php");
		include("vues/pied.php");
	}

	//Statistiques des nombre d'usager, nombre de cellier,  nombre de cellier par usager,  nombre de bouteille par cellier et par usager
	private function getStatistiques($intervalle)
	{

		$stat = new Statistiques();
		$btlCellier = $stat->sqlNombreBouteilleParCellier();
		$btlUsager = $stat->sqlNombreBouteilleParUsager();
		$btlCellierVal = $stat->sqlValeurBouteilleParCellier();
		$btlUsagerVal = $stat->sqlValeurBouteilleParUsager();
		$btlVal = $stat->sqlValeurTotal();


		$bte = new Bouteille();
		$dataBouteilles = $bte->getNombreBouteilles($intervalle);
		$dataBouteilles = json_encode($dataBouteilles);


		include("vues/entete.php");
		include("vues/statistiques.php");
		include("vues/pied.php");
	}
}
