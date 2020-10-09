<?php

if ($_SESSION['utilisateur_type'] == 1 || $_SESSION['utilisateur_type'] == 3) {

	if (isset($_POST['page'])) {
		$page = $_POST['page'];
	} else {
		$page = 1;
	}

	if (isset($_POST['nombre'])) {
		$nombreProduit = $_POST['nombre']; //24, 48 ou 96	 
	} else {
		$nombreProduit = 24;
	}

	$saq = new SAQ();
?>
	<div class="bouteillesImportees" vertical layout>
		<h3>Bouteilles importées à partir du Site SAQ</h3><br>
		<?php
		for ($i = 0; $i < $page; $i++)	//permet d'importer séquentiellement plusieurs pages.
		{
		?>
			<h4>
				<p>Importation des bouteilles de la page <?php echo ($i + 1); ?></p>
			</h4>
			<?php
			$nombre = $saq->getProduits($nombreProduit, $i);
			?>
			<p>Bouteilles importées: <?php echo $nombre; ?></p>
		<?php
		}
		?>
	</div>
<?php
} else {
	header('Location: index.php');
}
