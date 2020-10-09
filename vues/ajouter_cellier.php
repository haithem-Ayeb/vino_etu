<div class="gestionCel">
    <div class="contenuCel">
        <img class="imageNC" src="img/cellier.png" alt="Image Cellier">
        <h4>Ajouter un nouveau cellier</h4>
        <p><input class="" name="nomCellier" placeholder="Nom du nouveau Cellier"></p>
        <div>
            <span id="erreurNouveauCellier"></span>
        </div>
        <button type="button" id="buttonAjouterCellier" class="ajouterCellierButton">Ajouter</button>
    </div>
    <?php
    $arr = json_decode($data, true);
    ?>
    <p></p>
    <table>
        <thead>
            <tr>
                <th>Nom Cellier</th>
                <th>Nombre total de bouteilles</th>
                <th>Prix moyen des bouteilles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($arr as $cellier) : ?>
                <tr>
                    <td data-column="Id Cellier" class="idCellier" style="display:none;"><?php echo $cellier['id'] ?></td>
                    <td data-column="Nom Cellier" class="nomCellier"><?php echo $cellier['nom_cellier'] ?></td>
                    <td data-column="Total Bouteilles" class="boutCellier"><?php echo $cellier['totalBouteilles'] ?></td>
                    <td data-column="Prix Moyenne" class="boutCellier"><?php echo round($cellier['AvgPrix'], 2) ?></td>
                    <!-- echo number_format((float)$foo, 2, '.', '');  // Outputs -> 105.00 -->
                    <td data-column="Actions">
                        <button class="btn" name="modifierButton"><i class="fas fa-pencil-alt" title="Après avoir modifié, appuyez sur la touche Entrée pour sauvegarder"></i></button>
                        <?php
                        //quand il n'y a qu'un seul cellier, on ne peut pas l'effacer 
                        if (count($arr) !== 1) { ?>
                            <button class="btn" name="suprimmerButton"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div id="center_container">
        <div id="center">
            <div id="messagePer">Modification effectuée avec succès</div>
            <span id="close_center">X</span>
        </div>
    </div>
    <div id="center_container_sup">
        <div id="center_sup">
            <div id="confirm_suppression">
                <p id='choix_suppression_bouteille'>Vous êtes sûr de vouloir effacer le cellier ?</p>
                <button id='confirmerSuppCellier'>Oui</button>
                <button id='annulerSuppressionCellier'>Non</button>
            </div>
            <span id="close_center_sup">X</span>
        </div>
    </div>
</div>