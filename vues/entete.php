<!DOCTYPE html>
<html lang="fr">

<head>
	<title>Un petit verre de vino</title>
	<meta charset="utf-8">
	<meta http-equiv="cache-control" content="no-cache">
	<meta name="viewport" content="width=device-width, minimum-scale=0.5, initial-scale=1.0, user-scalable=yes">
	<link rel="stylesheet" href="css/normalize.css" type="text/css" media="screen">
	<link rel="stylesheet" href="css/base_h5bp.css" type="text/css" media="screen">
	<link rel="stylesheet" href="css/main.css" type="text/css" media="screen">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0/css/all.min.css" />
	<base href="<?php echo BASEURL; ?>">
	<!--<script src="./js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>-->
	<script src="js/main.js"></script>
</head>

<body>
	<nav class="navbar">
		<span class="navbar-toggle" id="js-navbar-toggle">
			<i class="fas fa-bars"></i>
		</span>
		<span class="welcome">Bienvenue <?php echo $_SESSION['utilisateur_prenom']; ?> <?php echo $_SESSION['utilisateur_nom']; ?></span>

		<ul class="main-nav" id="js-menu">
			<li><a href="index.php?requete=accueil"><img src="img/logo.png" alt="logo"></a></li>
			<li class="menu-item">
				<a href="index.php?requete=accueil">Accueil</a>
			</li>
			<?php if ($_SESSION['utilisateur_type'] == 2) { ?>
				<li class="menu-item">
					<a href="index.php?requete=getListeCelliers">Gestion des celliers</a>
				</li>
			<?php } ?>
			<?php if ($_SESSION['utilisateur_type'] == 1 || $_SESSION['utilisateur_type'] == 3) { ?>
				<li class="menu-item"><a href="#" class="deroulant"><i class="fas fa-chevron-down"></i>Gestion d'administration</a>
					<ul class="sous">
						<li><a href="index.php?requete=admin">Gestion des utilisateurs</a></li>
						<li><a href="index.php?requete=importationMenu">Importation des bouteilles</a></li>
					</ul>
				</li>
			<?php } ?>
			<?php if ($_SESSION['utilisateur_type'] == 1 || $_SESSION['utilisateur_type'] == 3) { ?>
				<li class="menu-item"><a href="#" class="deroulant"><i class="fas fa-chevron-down"></i>Statistiques</a>
					<ul class="sous">
						<li><a href="index.php?requete=getNombreNouveauUsagers">Utilisateurs</a></li>
						<li><a href="index.php?requete=getStatistiques">Bouteilles</a></li>
					</ul>
				</li>
			<?php } ?>
			<li class="menu-item">
				<a href="#">Votre compte</a>
			</li>
			<li class="menu-item">
				<a href="index.php?requete=quitter">
					<abbr title="Se deconnecter">
						<img src="img/logout-24.png" alt="Déconnexion">
					</abbr>
				</a>
			</li>
		</ul>
	</nav>
	<div class="col-2">
		<main class="content">