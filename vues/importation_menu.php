<div class="import_bouteille">
    <img class="imageNC" src="img/importBouteille.png" width="40px" height="40px" alt="Image Cellier">
    <h4>Importer les Bouteilles de vin</h4>
    <form method="POST" action="index.php?requete=importationBouteille">
        <label>Nombre de pages à importer: </label>
        <input name="page" id="page" type="number" max="100" min="1" value="1"><br><br>
        <label>Nombre de bouteille par page:</label>
        <select id="nombre" name="nombre">
            <option value="24">24 bouteilles</option>
            <option value="48">48 bouteilles</option>
            <option value="96">96 bouteilles</option>
        </select><br><br>
        <button name="importerBouteilleSAQ" class="importerBouteilleSAQ">Importer</button>
    </form>
</div>
<hr />