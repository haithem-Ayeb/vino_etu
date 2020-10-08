<?php

/**
 * Class Utilisateur
 * Cette classe de l'entité nouveau utilisateur. 
 * @author Chingiz Taghizade
 * @version 1.0
 * @update 2020-09-15
 */
class Utilisateur
{
    private $nom  = null;
    private $prenom  = null;
    private $identifiant = null;
    private $mdp  = null;
  
    private $erreurs = array();

    // Constructeur de la classe 
    public function __construct($nom  = null, $prenom = null, $identifiant  = null, $mdp  = null)
    {
        $this->setNom($nom);
        $this->setPrenom($prenom);
        $this->setIdentifiant($identifiant);
        $this->setMdp($mdp);
    }

    // Accesseur magique d'une propriété de l'objet return <type de la propriété>    
    public function __get($prop)
    {
        return $this->$prop;
    }

    // Getter nom 
    public function getNom()
    {
        return $this->nom;
    }

    // Getter prenom 
    public function getPrenom()
    {
        return $this->prenom;
    }

    // Getter identifiant 
    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    // Getter mdp 
    public function getMdp()
    {
        return $this->mdp;
    }

    // Setter nom @return this 
    public function setNom($nom = null)
    {
        unset($this->erreurs['nom']);
        $nom = trim($nom);
        $regExp = '/^([a-zA-ZàâéèêôùûçÀÂÉÈÔÙÛÇ0-9]{2,25})$/';
      
        if ($nom !== null && preg_match($regExp, $nom)) {

            $this->nom = ucwords(strtolower($nom));
        } else {
            $this->erreurs['nom'] = "Le nom doit comprendre entre 2 et 25 caractères alphabétiques";
        }
        return $this;
    }

    // Setter prenom @return this 
    public function setPrenom($prenom = null)
    {
        unset($this->erreurs['prenom']);
        $prenom = trim($prenom);
        $regExp = '/^([a-zA-ZàâéèêôùûçÀÂÉÈÔÙÛÇ0-9]{2,25})$/';

        if ($prenom !== null && preg_match($regExp, $prenom)) {
            $this->prenom = ucwords(strtolower($prenom));
        } else {
            $this->erreurs['prenom'] = "Le prenom doit comprendre entre 2 et 25 caractères alphabétiques";
        }
        return $this;
    }

    // Setter identifiant @return this 
    public function setIdentifiant($identifiant = null)
    {
        unset($this->erreurs['identifiant']);
        $identifiant = trim($identifiant);
        $regExp = '/^[a-z][a-z0-9_-]{3,16}$/';
        if ($identifiant !== null && preg_match($regExp, $identifiant)) {
            $this->identifiant = $identifiant;
        } else {
            $this->erreurs['identifiant'] = "L'identifiant doit comprendre entre 3 et 16 caractères";
        }
        return $this;
    }

    // Setter mdp @return this 
    public function setMdp($mdp = null)
    {
        unset($this->erreurs['mdp']);
        $mdp = trim($mdp);
        $regExp = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/';
        if ($mdp !== null && preg_match($regExp, $mdp)) {
            $this->mdp = $mdp;
        } else {
            $this->erreurs['mdp'] = "Utilisez 8 caractères ou plus pour votre mot de passe";
        }
        return $this;
    }
}
