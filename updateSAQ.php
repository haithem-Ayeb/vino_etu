<!DOCTYPE HTML>
<html>

<head>
	<meta charset="UTF-8" />
</head>

<body>
	<?php
	require("dataconf.php");
	require("config.php");
	$page = 1;
	$nombreProduit = 24; //48 ou 96	

	$saq = new SAQ();
	for ($i = 0; $i < 1; $i++)	//permet d'importer séquentiellement plusieurs pages.
	{
<<<<<<< HEAD
		echo "<h2>page " . ($page + $i) . "</h2>";
		$nombre = $saq->getProduits($nombreProduit, $page + $i);
		echo "importation : " . $nombre . "<br>";
=======
		echo "<h2>page ". ($page+$i)."</h2>";
		$nombre = $saq->getProduits($nombreProduit,$page+$i);
		echo "importation : ". $nombre. "<br>";
>>>>>>> 6828bd1bca6172a2656dbc7aaf8e98d7b2ebdf36
	}
	?>
</body>

</html>