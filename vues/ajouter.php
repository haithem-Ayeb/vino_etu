<div class="choixAjoutBouteille ">
    <h4>Choisir le type d'ajout d'une bouteille</h4>
    <label class="checkbox checkbox--block">
        <input type="radio" name="radio" class="" data-show-more data-target="showmoretarget2" value="1" id="radio1"><span></span>bouteille listée
    </label>
    <label class="checkbox checkbox--block">
        <input type="radio" name="radio" class="" value="2" id="radio2"> <span></span> bouteille non listée
    </label>
</div>
<hr />
<div class="nouvelleBouteille" vertical layout>
    <h4>Ajouter une nouvelle bouteille au cellier </h4>
    <div class="recherche_nom_bouteille">Rechercher par nom de bouteille: <input type="text" name="nom_bouteille" placeholder="saisir le début du nom">
        <ul class="listeAutoComplete"></ul>
    </div>
    <?php
    //Transformer le résultat de Json en array 
    $arrayCelliers = json_decode($dataCellier, true); ?>
    <div class="ajoutBouteille">
        <p>Nom: <span id="nomB" data-id_bouteille="" class="nom_bouteille"></span>
            <div>
                <span id="erreurNomB"></span>
            </div>
        </p>
        <p>Cellier<select id="cellier">
                <?php foreach ($arrayCelliers as $cellier) { ?>
                    <option value="<?php echo $cellier['id']; ?>"><?php echo $cellier['nom_cellier']; ?></option>
                <?php } ?>
            </select></p>
        <p>Millesime <input name="millesime"></p><span id="erreurMil"></span>
        <p>Quantite <input name="quantite" value="1" type="number" min="1"></p><span id="erreurQuant"></span>
        <p>Date achat <input name="date_achat" type="date" id="dateActuelle"></p>
        <p>Prix <input name="prix"></p><span id="erreurPrix"></span>
        <p>Garde <input name="garde_jusqua"></p>
        <p>Notes <input name="notes"></p>
        <p><button name="ajouterBouteilleCellier" class="ajouterBouteilleCellier">Ajouter</button></p>
    </div>
    <div id="center_container">
        <div id="center">
            <div id="messagePer">Ajout effectuée avec succès</div>
            <span id="close_center">X</span>
        </div>
    </div>
</div>
<div class="nouvelleBouteilleNonlistee" vertical layout>
    <?php
    $arr = json_decode(json_encode($z), true);
    $t = null;
    if (isset($_GET['idType']) && !empty($_GET['idType'])) {
        $t = trim($_GET['idType']);
    }
    ?>
    <h4>Ajouter une nouvelle bouteille non listée</h4>
    <div class="ajoutBouteille">
        <p>Nom <input type="text" name="nom_bouteille_non_listee"></p><span id="erreurNom"></span>
        <p><input name="image" type="hidden" value="img/bouteille.png"></p>
        <p>Pays * <input name="pays" type="text" required></p><span id="erreurPays"></span>
        <p>Description <input name="description" type="text" id="description"></p><span id="erreurDescription"></span>
        <p>Prix <input name="prix_saq" type="number" id='prix_saq'></p><span id="erreurPrix"></span>
        <p>Format <input name="format" type="text" id='format'></p><span id="erreurFormat"></span>
        <p>Type de vin<select id="type" name="type" class="type">
                <option selected value="-1" disabled> -- selectionner une option -- </option>
                <?php foreach ($arr as $type) { ?>
                    <option value="<?php echo $type['id']; ?>" <?php echo $t === $type['id'] ? "selected" : "" ?>><?php echo $type['type']; ?></option>
                <?php } ?>
            </select>
        </p>
        <p><button name="ajouterBouteilleNonListee" class="ajouterBouteilleNonListee">Ajouter</button></p>
    </div>
    <div id="center_container2">
        <div id="center2">
            <div id="messagePer2"></div>
            <span id="close_center2">X</span>
        </div>
    </div>
</div>