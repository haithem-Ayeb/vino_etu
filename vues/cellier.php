<?php
$arr = json_decode(json_encode($data), true);
$arrayCelliers = json_decode($dataCellier, true);
$arrayId = [];
$arrayC = [];
$arrayP = [];
$arrayType = [];
$arrayUser = [];

foreach ($arr as $key => $cellier) {
    array_push($arrayId, $cellier['nom_cellier']);
    array_push($arrayP, $cellier['pays']);
    array_push($arrayType, $cellier['type']);
    array_push($arrayUser, $cellier['id_utilisateur']);
}
foreach ($arrayCelliers as $key => $tousCelliers) {
    array_push($arrayC, $tousCelliers['nom_cellier']);
}
$arrayP = array_unique($arrayP);
$arrayT = array_unique($arrayType);
$arrayC = array_unique($arrayC);

$id = null;
$p = null;
$t = null;
?>
<section class="cellier">
    <?php if ($_SESSION['utilisateur_type'] == 2) { ?>
        <div><a class="ajouter_bouteille" href="?requete=ajouterNouvelleBouteilleCellier">Ajouter une bouteille au cellier</a></div>
    <?php } ?>
    <nav>
        <ul>
            <li><label for="tri_cellier">Choisir un cellier</label>
                <select id="cellier" name="tri_cellier" class="tri_cellier">
                    <option selected value="-1"> -- selectionner une option -- </option>
                    <?php foreach ($arrayCelliers as $row) : ?>
                        <option value="<?php echo $row['id']; ?>" <?php if (isset($_GET['idCellier']) && $_GET['idCellier'] ==  $row['id']) echo "selected" ?>><?php echo $row['nom_cellier']; ?></option>  
                    <?php endforeach ?>
                </select>
            </li>
            <li>
                <label for="pays">Choisir un pays</label>
                <select name="pays" id="pays" class="tri_cellier">
                    <option selected value="-1"> -- selectionner une option -- </option>
                    <?php
                    foreach ($arrayP as $pays) {
                    ?>
                        <option value="<?php echo $pays; ?>" <?php if (isset($_GET['paysOption']) && $_GET['paysOption'] == $pays) echo "selected" ?>><?php echo $pays; ?></option> 
                    <?php } ?>
                </select>
            </li>
            <li><label for="tri_cellier">Choisir un type de vin</label>
                <select id="type" name="type" class="tri_cellier">
                    <option selected value="-1"> -- selectionner une option -- </option>
                    <?php
                    foreach ($arrayT as $type) {
                    ?>
                        <option value="<?php echo $type; ?>" <?php if (isset($_GET['typeOption']) && $_GET['typeOption'] == $type) echo "selected" ?>><?php echo $type; ?></option>  
                    <?php } ?>
                </select>
            </li>
        </ul>
    </nav>
    <?php
    foreach ($arr as $cle => $bouteille) { ?>
        <article class="bouteille" data-quantite="">
            <div class="img">
                <?php if ($bouteille['image'] == null) {
                    $bouteille['image'] == '..\img\bouteille.png'; ?>
                    <img src="img/bouteille.png">
                <?php } else { ?>
                    <img src="https:<?php echo $bouteille['image'] ?>">
                <?php } ?>

            </div>
            <ul class="infoBouteille">
                <li class="id_cellier">Numéro du cellier : <?php echo $bouteille['id_cellier'] ?></li>
                <li class="nom">Nom : <?php echo $bouteille['nom'] ?></li>
                <li class="quantite">Quantité : <?php echo $bouteille['quantite'] ?></li>
                <li class="pays">Pays : <?php echo $bouteille['pays'] ?></li>
                <li class="type">Type : <?php echo $bouteille['type'] ?></li>
                <li class="millesime">Millesime : <?php echo $bouteille['millesime'] ?></li>
                <li class="prix">Prix : <?php echo $bouteille['prix'] ?></li>
                <li class="date_achat">Date d'achat : <?php echo $bouteille['date_achat'] ?></li>
                <li><a href="<?php echo $bouteille['url_saq'] ?>" target="_blank">Voir SAQ</a></li>
            </ul>
            <?php if ($_SESSION['utilisateur_type'] == 2) { ?>
                <div class="options" data-id_bouteille="<?php echo $bouteille['id_bouteille'] ?>" data-id_cellier="<?php echo $bouteille['id_cellier'] ?>">
                    <button class="btnModifierBouteille" id='modifierBouteille' name="modifierBouteille">Modifier</button>
                    <button class='btnAjouter'>Ajouter</button>
                    <button class='btnBoire'>Boire</button>
                    <button class="btnRetirerBouteille" id='retirerBouteille' name="retirerBouteille">Retirer</button>
                </div>
            <?php  } else { ?>
                <div></div>
            <?php }
            ?>
        </article>
    <?php
    }
    ?>
    <div id="center_container">
        <div id="center">
            <div id="confirm_suppression">
                <p id='choix_suppression_bouteille'>Vous voulez supprimer cette bouteille?</p>
                <button id='confirmerSuppBouteille'>Oui</button>
                <button id='annulerSuppressionBouteille'>Non</button>
            </div>
            <span id="close_center">X</span>
        </div>
    </div>
</section>