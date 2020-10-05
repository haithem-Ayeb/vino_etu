/**
 * @file Script contenant les fonctions de base
 * @author Jonathan Martel (jmartel@cmaisonneuve.qc.ca)
 * @version 0.1
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 *
 */

//const BaseURL = "https://e1995654.webdev.cmaisonneuve.qc.ca/vino_etu/";
const BaseURL = document.baseURI;
//const BaseURL = window.location.href.substring(0, window.location.href.lastIndexOf("/") + 1);
//console.log(BaseURL);
window.addEventListener('load', function() {
    console.log("load");
    document.querySelectorAll(".btnBoire").forEach(function(element) {
        //console.log(element);
        element.addEventListener("click", function(evt) {
            let id_bouteille = evt.target.parentElement.dataset.id_bouteille;
            let id_cellier = evt.target.parentElement.dataset.id_cellier;
            let requete = new Request(BaseURL + "index.php?requete=boireBouteilleCellier", { method: 'POST', body: '{"id_bouteille": ' + id_bouteille + ', "id_cellier": ' + id_cellier + ' }' });
            console.log(requete);

            fetch(requete)
                .then(response => {
                    if (response.status === 200) {
                        return response.json();
                    } else {
                        throw new Error('Erreur');
                    }
                })
                .then(response => {
                    console.debug(response);
                    requete = new Request(BaseURL + "index.php?requete=consulterQuantiteBouteilleCellier&id_bouteille=" + id_bouteille + "&id_cellier=" + id_cellier, { method: 'GET' });
                    console.log(requete);
                    fetch(requete)
                        .then(response => {
                            if (response.status === 200) {
                                return response.json();
                            } else {
                                throw new Error('Erreur');
                            }
                        })
                        .then(response => {
                            console.debug(response);
                            let quantiteBoite = evt.target.parentElement.parentElement.getElementsByClassName('quantite')[0];
                            quantiteBoite.innerHTML = 'Quantité: ' + response.quantite;
                        }).catch(error => {
                            console.error(error);
                        });
                }).catch(error => {
                    console.error(error);
                });
        })

    });

    document.querySelectorAll(".btnAjouter").forEach(function(element) {
        //console.log(element);
        element.addEventListener("click", function(evt) {
            let id_bouteille = evt.target.parentElement.dataset.id_bouteille;
            let id_cellier = evt.target.parentElement.dataset.id_cellier;
            let requete = new Request(BaseURL + "index.php?requete=ajouterBouteilleCellier", { method: 'POST', body: '{"id_bouteille": ' + id_bouteille + ', "id_cellier": ' + id_cellier + ' }' });

            fetch(requete)
                .then(response => {
                    if (response.status === 200) {
                        return response.json();
                    } else {
                        throw new Error('Erreur');
                    }
                })
                .then(response => {
                    console.debug(response);
                    requete = new Request(BaseURL + "index.php?requete=consulterQuantiteBouteilleCellier&id_bouteille=" + id_bouteille + "&id_cellier=" + id_cellier, { method: 'GET' });
                    fetch(requete)
                        .then(response => {
                            if (response.status === 200) {
                                return response.json();
                            } else {
                                throw new Error('Erreur');
                            }
                        })
                        .then(response => {
                            console.debug(response);
                            let quantiteBoite = evt.target.parentElement.parentElement.getElementsByClassName('quantite')[0];
                            quantiteBoite.innerHTML = 'Quantité: ' + response.quantite;
                        }).catch(error => {
                            console.error(error);
                        });
                }).catch(error => {
                    console.error(error);
                });
        })
    });

    // la recherche d'une bouteille par son nom
    let inputNomBouteille = document.querySelector("[name='nom_bouteille']");
    //console.log(inputNomBouteille);
    let liste = document.querySelector('.listeAutoComplete');

    if (inputNomBouteille) {
        inputNomBouteille.addEventListener("keyup", function(evt) {
            console.log(evt);
            let nom = inputNomBouteille.value;
            liste.innerHTML = "";
            if (nom) {
                let requete = new Request(BaseURL + "index.php?requete=autocompleteBouteille", { method: 'POST', body: '{"nom": "' + nom + '"}' });
                fetch(requete)
                    .then(response => {
                        if (response.status === 200) {
                            return response.json();
                        } else {
                            throw new Error('Erreur');
                        }
                    })
                    .then(response => {
                        console.log(response);
                        response.forEach(function(element) {
                            liste.innerHTML += "<li data-id='" + element.id + "'>" + element.nom + "</li>";
                        })
                    }).catch(error => {
                        console.error(error);
                    });
            }

        });

        let bouteille = {
            cellier: document.getElementById('cellier'),
            nom: document.querySelector(".nom_bouteille"),
            millesime: document.querySelector("[name='millesime']"),
            quantite: document.querySelector("[name='quantite']"),
            date_achat: document.querySelector("[name='date_achat']"),
            prix: document.querySelector("[name='prix']"),
            garde_jusqua: document.querySelector("[name='garde_jusqua']"),
            notes: document.querySelector("[name='notes']"),
        };

        //choisir un nom d'une bouteile
        liste.addEventListener("click", function(evt) {
            //console.dir(evt.target)
            if (evt.target.tagName == "LI") {
                bouteille.nom.dataset.id = evt.target.dataset.id;
                bouteille.nom.innerHTML = evt.target.innerHTML;
                liste.innerHTML = "";
                inputNomBouteille.value = "";

            }
        });

        //Fonctionnalites pour ajouter une bouteille 
        let btnAjouter = document.querySelector("[name='ajouterBouteilleCellier']");
        document.getElementById('dateActuelle').valueAsDate = new Date();
        if (btnAjouter) {
            btnAjouter.addEventListener("click", function(evt) {

                let boite_alert = document.getElementById("center_container"),
                    fermer_boite = document.getElementById('close_center');
                boite_alert.style.display === "none";

                let choice = bouteille.cellier.selectedIndex;
                let idCellier = bouteille.cellier.options[choice].value;
                let isvalid = true;

                //Vérification du nom de la bouteille (ne peut être vide)
                if (!bouteille.nom.dataset.id) {
                    let erreurNomBouteille = document.getElementById('erreurNomB');
                    erreurNomBouteille.innerHTML = "Vous devez sélectionner le nom d'une bouteille";
                    isvalid = false;
                }

                //Vérification que le millésime est un nombre lorsqu'il est fourni 
                if (!Number.isInteger(+bouteille.millesime.value)) {
                    let erreurMillesime = document.getElementById('erreurMil');
                    erreurMillesime.innerHTML = 'Millesime non valide, la valeur doit être un nombre entier';
                    isvalid = false;
                }

                //Vérification que le montant est au moins égal à 1
                if (bouteille.quantite.value < 1) {
                    let erreurQuantite = document.getElementById('erreurQuant');
                    erreurQuantite.innerHTML = 'Le nombre de bouteilles doit être au moins égal à 1';
                    isvalid = false;
                }

                //Vérification que le prix est un numéro lorsqu'il est fourni 
                if (Number.isNaN(+bouteille.prix.value)) {
                    let erreurPrix = document.getElementById('erreurPrix');
                    erreurPrix.innerHTML = 'Prix non valide, la valeur doit être un nombre entier ou décimal';
                    isvalid = false;
                }

                if (isvalid) {
                    var param = {
                        "id_bouteille": bouteille.nom.dataset.id,
                        "id_cellier": idCellier,
                        "date_achat": bouteille.date_achat.value,
                        "garde_jusqua": Number(bouteille.garde_jusqua.value),
                        "notes": bouteille.notes.value,
                        "prix": Number(bouteille.prix.value),
                        "quantite": Number(bouteille.quantite.value),
                        "millesime": Number(bouteille.millesime.value),
                    };
                    let URLSansR = window.location.href.substring(0, window.location.href.lastIndexOf("/") + 1);
                    let requete = new Request(URLSansR + "index.php?requete=ajouterNouvelleBouteilleCellier", { method: 'POST', body: JSON.stringify(param) });
                    //la boite de dialogue personnalisé
                    let boite_alert = document.getElementById("center_container"),
                        fermer_boite = document.getElementById('close_center');
                    boite_alert.style.display === "none";
                    if (boite_alert.style.display === "none" || boite_alert.style.display === '') {

                        fetch(requete)
                            .then(response => {
                                if (response.status === 200) {
                                    return response.json();
                                } else {
                                    throw new Error('Erreur');
                                }
                            })
                            .then(response => {
                                console.log(response);
                                if (response == false) {
                                    boite_alert.style.display = "block";
                                    //Message lorsque la bouteille existe déjà dans le cellier 
                                    document.getElementById('messagePer').innerHTML = "Echec de l'ajout, Bouteille déjà dans le cellier.";
                                    fermer_boite.addEventListener('click', function(e) {
                                        location.reload();
                                    });
                                } else {
                                    boite_alert.style.display = "block";
                                    fermer_boite.addEventListener('click', function(e) {
                                        window.location = BaseURL + "index.php?requete=accueil";
                                    });
                                }
                            }).catch(error => {
                                console.error(error);
                            });
                    } else {
                        boite_alert.style.display = "none";
                    }

                }
            });
        }
    }

    let bouteille = {
        cellier: document.getElementById('cellier'),
        pays: document.getElementById("pays"),
        type: document.getElementById("type")
    };
    //selectionner un cellier
    let selectCellier = document.querySelectorAll(".tri_cellier");
    selectCellier.forEach(function(elem) {
        elem.addEventListener("change", function(e) {
            let choice = bouteille.cellier.selectedIndex; //selection cellier
            let idCellier = bouteille.cellier.options[choice].value; //valeur cellier choisi
            let paysChoisi = bouteille.pays.selectedIndex; //selection pays
            let paysOption = bouteille.pays.options[paysChoisi].value; //valeur pays choisi
            let typeChoisi = bouteille.type.selectedIndex; //type choisi
            let typeOption = bouteille.type.options[typeChoisi].value; //valeur type choisi
            //test des selects selectionnées pour les rediriger vers le bon resultat
            console.log('choice ', choice, ' paysChoisi ', paysChoisi, ' typeChoisi ', typeChoisi,
                ' idCellier ', idCellier, ' paysOption ', paysOption, ' typeOption ', typeOption)
            if (choice > 0 && paysChoisi > 0 && typeChoisi > 0) { //tous les param
                window.location = BaseURL + "index.php?requete=accueil&idCellier=" + idCellier + "&paysOption=" + paysOption + "&typeOption=" + typeOption;
            } else if (paysChoisi <= 0 && choice > 0 && typeChoisi > 0) { //le cellier + le type
                window.location = BaseURL + "index.php?requete=accueil&idCellier=" + idCellier + "&typeOption=" + typeOption;
            } else if (choice <= 0 && paysChoisi <= 0 && typeChoisi > 0) { //le type
                window.location = BaseURL + "index.php?requete=accueil&typeOption=" + typeOption;
            } else if (choice > 0 && paysChoisi <= 0 && typeChoisi <= 0) { //le cellier
                window.location = BaseURL + "index.php?requete=accueil&idCellier=" + idCellier;
            } else if (paysChoisi > 0 && typeChoisi <= 0 && choice <= 0) { //le pays
                window.location = BaseURL + "index.php?requete=accueil&paysOption=" + paysOption;
            } else if (paysChoisi > 0 && typeChoisi > 0 && choice <= 0) { //pays + type
                window.location = BaseURL + "index.php?requete=accueil&paysOption=" + paysOption + "&typeOption=" + typeOption;
            } else if (paysChoisi > 0 && typeChoisi <= 0 && choice > 0) { //pays + cellier
                window.location = BaseURL + "index.php?requete=accueil&paysOption=" + paysOption + "&idCellier=" + idCellier;
            } else if (paysChoisi <= 0 && typeChoisi <= 0 && choice <= 0) { //aucun parametres
                window.location = BaseURL + "index.php?requete=accueil";
            }

            let requete = new Request(BaseURL + "index.php?requete=");
            fetch(requete)
                .then(response => {
                    if (response.status === 200) {
                        console.log('resp', response);
                        return response.json().then((data) => console.log(data));
                    } else {
                        throw new Error('Erreur');
                    }
                }).catch(error => {
                    console.error(error);
                });
        });
    });
    //Fonctionnalités du boutton ajouter pour ajouter un nouveau cellier
    let inputAjouterCellier = document.querySelector("[name='nomCellier']");
    let buttonAjouterCellier = document.getElementById("buttonAjouterCellier");
    let URLSansR = window.location.href.substring(0, window.location.href.lastIndexOf("/") + 1);

    if (inputAjouterCellier) {
        buttonAjouterCellier.addEventListener("click", function(evt) {
            let boite_alert = document.getElementById("center_container"),
                fermer_boite = document.getElementById('close_center');
            boite_alert.style.display === "none";

            let isvalid = true;

            if (!inputAjouterCellier.value) {
                let erreurNomCellier = document.getElementById('erreurNouveauCellier');
                erreurNomCellier.innerHTML = "Vous devez saisir le nom du nouveau cellier";
                isvalid = false;
            }

            if (isvalid) {

                var param = {
                    "nom_cellier": inputAjouterCellier.value
                };
                let requete = new Request(URLSansR + "index.php?requete=ajouterNouveauCellier", { method: 'POST', body: JSON.stringify(param) });

                if (boite_alert.style.display === "none" || boite_alert.style.display === '') {
                    boite_alert.style.display = "block";

                    fetch(requete)
                        .then(response => {
                            if (response.status === 200) {
                                //Message confirmant la création d'un cellier 
                                document.getElementById('messagePer').innerHTML = "Cellier correctement créé";
                                fermer_boite.addEventListener('click', function(e) {
                                    location.reload();
                                });
                                return response.json();
                            } else {
                                throw new Error('Erreur');
                            }
                        })
                        .then(response => {
                            console.log(response);
                        }).catch(error => {
                            console.error(error);
                        });
                }
            }
        })
    }
    //Fonctionnalités pour modifier un cellier existant
    document.querySelectorAll("[name='modifierButton']").forEach(item => {
        item.addEventListener('click', event => {
            //la boite de dialogue personnalisé
            let boite_alert = document.getElementById("center_container"),
                fermer_boite = document.getElementById('close_center');
            boite_alert.style.display === "none";

            if(event.target.tagName == "BUTTON") {
                var row = event.target.parentElement.parentElement;
            } else {
                var row = event.target.parentElement.parentElement.parentElement;
            }

            let valeurNomCellier = row.getElementsByClassName('nomCellier')[0].innerHTML;

            row.getElementsByClassName('nomCellier')[0].innerHTML = '';

            var input = document.createElement("input");
            input.type = "text";
            input.value = valeurNomCellier;

            input.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {

                    event.preventDefault();

                    var param = {
                        "nom_cellier": event.target.value,
                        "id_cellier": parseInt(row.getElementsByClassName('idCellier')[0].innerHTML)
                    };

                    let requete = new Request(URLSansR + "index.php?requete=actualiserCellier", { method: 'POST', body: JSON.stringify(param) });

                    if (boite_alert.style.display === "none" || boite_alert.style.display === '') {
                        boite_alert.style.display = "block";
                        fetch(requete)
                            .then(response => {
                                if (response.status === 200) {
                                    fermer_boite.addEventListener('click', function(e) {
                                        location.reload();
                                    });
                                    return response.json();
                                } else {
                                    throw new Error('Erreur');
                                }
                            })
                            .then(response => {
                                console.log(response);
                            }).catch(error => {
                                console.error(error);
                            });
                    } else {
                        boite_alert.style.display = "none";
                    }

                    //alert(event.target.value); 
                }
            });

            row.getElementsByClassName('nomCellier')[0].appendChild(input);
        });
    });


    //Fonctionnalités pour supprimer un cellier existant
    document.querySelectorAll("[name='suprimmerButton']").forEach(item => {
        let boite_alert = document.getElementById("center_container_sup"),
            confirm_suppression = document.getElementById("confirm_suppression"),
            annulerSuppressionCellier = document.getElementById("annulerSuppressionCellier"),
            fermer_boite = document.getElementById('close_center_sup'),
            children_confirm_suppression = confirm_suppression.children;
        let supprimerBtnCellier = document.getElementById("confirmerSuppCellier");
        boite_alert.style.display === "none";
        item.addEventListener('click', event => {
            if (boite_alert.style.display === "none" || boite_alert.style.display === '') {
                boite_alert.style.display = "block";
                fermer_boite.addEventListener('click', function(e) {
                    location.reload();
                });
                if (annulerSuppressionCellier) {
                    annulerSuppressionCellier.addEventListener('click', function(e) {
                        location.reload();
                    });
                }
                //var choice = confirm('Êtes-vous sûr de vouloir supprimer ce cellier?');
                if (supprimerBtnCellier) {
                    supprimerBtnCellier.addEventListener('click', function(e) {
                        children_confirm_suppression[0].style.display = "none";
                        supprimerBtnCellier.style.display = "none";
                        annulerSuppressionCellier.style.display = "none";

                        if(event.target.tagName == "BUTTON") {
                            var row = event.target.parentElement.parentElement;
                        } else {
                            var row = event.target.parentElement.parentElement.parentElement;
                        }
                        
                        var param = {
                            "id_cellier": parseInt(row.getElementsByClassName('idCellier')[0].innerHTML)
                        };
                        let requete = new Request(URLSansR + "index.php?requete=supprimerCellier", { method: 'POST', body: JSON.stringify(param) });
                        fetch(requete)
                            .then(response => {
                                let p = document.createElement('p');
                                if (response.status === 200) {
                                    boite_alert.style.display = "block";
                                    p.innerHTML += "Suppression effectuée avec succcès";
                                    p.style.textAlign = "center";
                                    confirm_suppression.appendChild(p);
                                    return response.json();
                                } else {
                                    //Refuser d'effacer le cellier parce qu'il fermer_boite a des bouteilles dedans 
                                    document.getElementById('confirm_suppression').innerHTML = "Le cellier n'a pas pu être effacé. Vérifier la présence de bouteilles dans le cellier";
                                }
                            })
                            .then(response => {
                                console.log(response);
                            }).catch(error => {
                                console.error(error);
                            });
                    });
                }
            }
        });
    });

    //Modifier une bouteille dans le cellier
    document.querySelectorAll("[name='modifierBouteille']").forEach(item => {
        item.addEventListener('click', event => {
            let URLSansR = window.location.href.substring(0, window.location.href.lastIndexOf("/") + 1);
            let id_bouteille = event.target.parentElement.dataset.id_bouteille;
            let id_cellier = event.target.parentElement.dataset.id_cellier;
            window.location = URLSansR + "index.php?requete=getInfosBouteille&id_bouteille=" + id_bouteille + "&id_cellier=" + id_cellier;

        });
    });

    //validation  modification d une bouteille
    let modifier_bouteille = document.querySelectorAll("[name='modifier_bouteille']")[0];
    if (modifier_bouteille) {
        modifier_bouteille.addEventListener("click", function(e) {
            let row = e.target.parentElement.parentElement;
            let isvalid = true;
            let bouteille = {
                cellier: document.getElementById('cellier'),
                nom: document.querySelector(".nom_bouteille"),
                millesime: document.querySelector("[name='millesime']"),
                quantite: document.querySelector("[name='quantite']"),
                date_achat: document.querySelector("[name='date_achat']"),
                prix: document.querySelector("[name='prix']"),
                garde_jusqua: document.querySelector("[name='garde_jusqua']"),
                notes: document.querySelector("[name='notes']"),
            };
            if (!Number.isInteger(+bouteille.quantite.value)) {
                let erreurQuantite = document.getElementById('erreurQuan');
                erreurQuantite.innerHTML = 'Quantité non valide, la valeur doit être un nombre entier';
                isvalid = false;
            }
            let param = {
                "id_bouteille": parseInt(row.querySelectorAll("[name='bouteille_id']")[0].value),
                "id_cellier": parseInt(row.querySelectorAll("[name='id_cellier']")[0].value),
                "quantite": Number(row.querySelectorAll("[name='quantite']")[0].value),
                "date_achat": row.querySelectorAll("[name='date_achat']")[0].value,
                "millesime": Number(row.querySelectorAll("[name='millesime']")[0].value),
                "garde_jusqua": Number(row.querySelectorAll("[name='garde_jusqua']")[0].value),
                "notes": row.querySelectorAll("[name='notes']")[0].value,
                "prix": Number(row.querySelectorAll("[name='prix']")[0].value)
            };
            let requete = new Request(URLSansR + "index.php?requete=modifierBouteille", {
                method: 'POST',
                body: JSON.stringify(param)
            });
            //la boite de dialogue personnalisé
            let boite_alert = document.getElementById("center_container"),
                fermer_boite = document.getElementById('close_center');
            boite_alert.style.display === "none";
            if (boite_alert.style.display === "none" || boite_alert.style.display === '') {
                boite_alert.style.display = "block";
                fetch(requete)
                    .then(response => {
                        if (response.status === 200) {
                            fermer_boite.addEventListener('click', function(e) {
                                window.location = BaseURL + "index.php?requete=accueil";
                            });
                            return response.json();
                        } else {
                            throw new Error('Erreur');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } else {
                boite_alert.style.display = "none";
            }
        })
    }

    //retirer une bouteille d'un cellier
    document.querySelectorAll("[name='retirerBouteille']").forEach(item => {
        //la boite de dialogue personnalisé
        let boite_alert = document.getElementById("center_container"),
            confirm_suppression = document.getElementById("confirm_suppression"),
            annulerSuppressionBouteille = document.getElementById("annulerSuppressionBouteille"),
            confirm_suppression_bouteille = document.getElementById("confirm_suppression_bouteille"),
            fermer_boite = document.getElementById('close_center'),
            children_confirm_suppression = confirm_suppression.children;
        let supprimerBtnBouteille = document.getElementById("confirmerSuppBouteille");
        boite_alert.style.display === "none";
        item.addEventListener('click', event => {
            if (boite_alert.style.display === "none" || boite_alert.style.display === '') {
                boite_alert.style.display = "block";
                fermer_boite.addEventListener('click', function(e) {
                    location.reload();
                });
                if (annulerSuppressionBouteille) {
                    annulerSuppressionBouteille.addEventListener('click', function(e) {
                        window.location = BaseURL + "index.php?requete=accueil";
                    });
                }
                if (supprimerBtnBouteille) {
                    supprimerBtnBouteille.addEventListener('click', function(e) {
                        children_confirm_suppression[0].style.display = "none";
                        supprimerBtnBouteille.style.display = "none";
                        annulerSuppressionBouteille.style.display = "none";
                        var param = {
                            id_bouteille: event.target.parentElement.dataset.id_bouteille,
                            id_cellier: event.target.parentElement.dataset.id_cellier
                        };
                        
                        let requete = new Request(URLSansR + "index.php?requete=retirerBouteille", { method: 'POST', body: JSON.stringify(param) });
                        fetch(requete)
                            .then(response => {
                                let p = document.createElement('p');
                                if (response.status === 200) {
                                    boite_alert.style.display = "block";
                                    p.innerHTML += "Suppression effectuée avec succcès";
                                    p.style.textAlign = "center";
                                    confirm_suppression.appendChild(p);
                                    return response.json();
                                } else {
                                    p.innerHTML += "Suppression échouée";
                                    confirm_suppression.appendChild(p);
                                }
                            })
                            .then(response => {
                                console.log(response);
                            }).catch(error => {
                                console.error(error);
                            });
                    });
                }

            } else {
                boite_alert.style.display = "none";
            }
        });
    });


    /************************************************************** */
    /**-------------GESTION DES UTILISATEURS---------------------- */
    /************************************************************* */
    let btnSupprUtil = document.getElementsByName("supprimerUtil");
    let btnModifUtil = document.getElementsByName("modifierUtil");

    //suppression d'un utilisateur
    btnSupprUtil.forEach(elem => {
        elem.parentElement.addEventListener('click', function(e) {

            let id_util = e.target.parentElement.nextElementSibling.value;
            let requete = new Request(BaseURL + "index.php?requete=supprimerUtilisateur", { method: 'DELETE', body: '{"id_util": ' + id_util + ' }' });

            fetch(requete)
                .then(response => {
                    if (response.status === 200) {
                        location.reload();
                        alert('Suppression de l\'utilisateur est effectuée');
                        return response.json();
                    } else {
                        //Refus de suppression de l'utilisateur parce qu'il fermer_boite a des celliers qui lui sont associés
                        alert("L'utilsateur n'a pas pu être effacé. Vérifier la présence de celliers à son compte");
                    }
                })
                .then(response => {
                    console.debug(response);
                }).catch(error => {
                    console.error(error);
                });
        });
    });

    //Modification d'un utilisateur
    btnModifUtil.forEach(elem => {
        elem.parentElement.addEventListener('click', function(e) {
            console.log("modifier");
            let id_util = e.target.parentElement.nextElementSibling.value;
            console.log(id_util);
        });
    });
    //menu de navigation
    let mainNav = document.getElementById('js-menu');
    let navBarToggle = document.getElementById('js-navbar-toggle');

    navBarToggle.addEventListener('click', function() {
        mainNav.classList.toggle('active');
    });

     //sélection d'action effectuée (boire ou ajouter)
     let selectAction = document.querySelectorAll('input[name="actionBouteille"]');
     selectAction.forEach(function(elem) {
         elem.addEventListener("change", function(e) {

            var item = e.target.value;
            let tableBouteilles = document.getElementById("tableBouteilles");
            let trTableB = document.getElementsByClassName("bouteilleBuRow");
            let trTableA = document.getElementsByClassName("bouteilleAjouteeRow");

            if(item === "bouteilleT") {
                for (let i = 0; i < trTableA.length; i++) {
                    const element = trTableA[i];
                    element.style.display = ""; 
                }

                for (let i = 0; i < trTableB.length; i++) {
                    const element = trTableB[i];
                    element.style.display = ""; 
                }
                                   
            } else if(item === "bouteilleB") {
                for (let i = 0; i < trTableA.length; i++) {
                    const element = trTableA[i];
                    element.style.display = "none"; 
                }

                for (let i = 0; i < trTableB.length; i++) {
                    const element = trTableB[i];
                    element.style.display = ""; 
                }
                             
            } else if(item === "bouteilleA") {
                for (let i = 0; i < trTableA.length; i++) {
                    const element = trTableA[i];
                    element.style.display = ""; 
                }

                for (let i = 0; i < trTableB.length; i++) {
                    const element = trTableB[i];
                    element.style.display = "none"; 
                }
            }
          
         });
     });
});