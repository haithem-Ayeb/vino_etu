<div class="usager">
    <h4>Créez un nouveau usager</h4>
    <form id="nutilisateur" action="" method="post">
        <?php if (!empty($message)) : ?>
            <p class="success-msg">
                <i class="fa fa-check"><?php echo $message; ?></i></p>
        <?php endif; ?>
        <p>
            <span>Nom</span><input class="inputForm" name="nom" required>
            <span class="erreur"><?= isset($erreurs['nom']) ? $erreurs['nom'] : "" ?></span>
        </p>
        <p>
            <span>Prénom</span><input class="inputForm" name="prenom" required>
            <span class="erreur"> <?= isset($erreurs['prenom']) ? $erreurs['prenom'] : "" ?></span>
        </p>
        <p>
            <span>Identifiant</span> <input class="inputForm" name="identifiant" required>
            <span class="erreur"><?= isset($erreurs['identifiant']) ? $erreurs['identifiant'] : "" ?></span>
        </p>
        <p>
            <span>Mot de passe</span> <input class="inputForm" type="password" name="mdp" required>
            <span class="erreur"><?= isset($erreurs['mdp']) ? $erreurs['mdp'] : "" ?></span>
        </p>
        <p>
            <select name="type">
                <option value="">--Veuillez choisir une option--</option>
                <option value="administrateur">Administrateur</option>
                <option value="usager">Usager</option>
            </select>
        </p>
        <p> <button type="submit" class="creationButton" name="creer">Créez</button></p>
    </form>
</div>
