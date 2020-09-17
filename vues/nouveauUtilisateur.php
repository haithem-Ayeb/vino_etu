<div class="authentification">
    <div class="formA">
            <div class="formAuthentification" >
                <div class="titre">
                    <h1>Créez votre compte</h1>
                </div>
                <form id="nutilisateur" action="" method="post">
                <?php if(!empty($message)):?>
                <p><?php echo $message;?></p>
                <?php endif; ?>
                <p><input name="nom" placeholder="Nom" required> </p>
                <p><?= isset($erreurs['nom']) ? $erreurs['nom'] : "" ?></p>
                <p><input name="prenom" placeholder="Prénom" required></p>
                <p><?= isset($erreurs['prenom']) ? $erreurs['prenom'] : "" ?></p>
                <p><input name="identifiant" placeholder="Identifiant" required> </p>
                <p><?= isset($erreurs['identifiant']) ? $erreurs['identifiant'] : "" ?></p>
                <p><input type="password" name="mdp" placeholder="Mot de passe" required></p>
                <p><?= isset($erreurs['mdp']) ? $erreurs['mdp'] : "" ?></p>
                <p><input type="email" name="courriel" placeholder="Email" required> </p>
                <p><?= isset($erreurs['courriel']) ? $erreurs['courriel'] : "" ?></p>
                <p><input name="telephone" placeholder="Téléphone" required></p>
                <p><?= isset($erreurs['telephone']) ? $erreurs['telephone'] : "" ?></p>
    
    <div class="contentForm">
        <button type="submit" class="creationButton" name="creer">Créez</button>
        <p class="mdp"> Si vous avez déjà un compte <a href="index.php"> Identifiez-vous </a></p>
    </div>
    </form>       
    </div>
    </div>
</div>