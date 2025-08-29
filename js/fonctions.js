/*
Librairies des fonctions spécifiques générales du projet
*/

//J'écoute les clics sur mes card et je lance ma fonction demanderFarine(ref)
document.addEventListener("click", function(event) {
    const card = event.target.closest(".card-farine");
    if (card && card.hasAttribute("data-ref-farine")) {
        const ref = card.getAttribute("data-ref-farine");
        demanderFarine(ref);
    }
});
//J'écoute le click sur mon bouton profil et je lance ma fonction demanderProfil();
const profil = document.getElementById("profil");
if(profil){
    profil.addEventListener("click", function(){
    demanderProfil();
    })
}

//Je charge mes ingredients et mes farines au chargement du DOM
document.addEventListener("DOMContentLoaded", function () {
    let modification = document.querySelector(".formulaire-recette[data-recette-id]");

    if (modification) {
        let id = modification.getAttribute('data-recette-id');
        recupererFarinesChoisies(id);
        recupererIngredientsChoisis(id);
    }
});

//Vérification pour la validation de l'enregistrement de la recette
let recetteForm = document.getElementById("form-recette");
if (recetteForm){
    recetteForm.addEventListener("submit", function(e){
        e.preventDefault(); //Empeche la page de se recharger

        //Récupération des valeurs à vérifier:
        let titre = document.querySelector('input[name="titre"]').value;
        let realisation = document.querySelector('input[name="realisation"]').value;
        let description =  document.querySelector('input[name="description"]').value;
        let difficulte = document.querySelector('select[name="difficulte"]').value;

        //Initialiser le tableau error à 0
        let errors = [];

        //Faire les vérifications:
        if(titre == "") errors.push({champs: "titre", message: "Merci de remplir le titre"});
        if(realisation == "") errors.push({champs: "realisation", message: "Merci de remplir le temps de préparation"});
        if(description == "") errors.push({champs: "description", message: "Merci de remplir la description de votre recette"});
        if(difficulte == "") errors.push({champs: "difficulte", message: "Merci de choisir une difficulté pour votre recette"});

        //Je réinitialise à vide toutes les box erreur avec une boucle sur le tableau
        document.querySelectorAll(".error-box").forEach(function(box){
            box.innerHTML = "";
        });

        //Je parcours le fichier errors et je met chaque erreur si présente dans la bonne box
        errors.forEach(function(error){
            let errorBox = document.getElementById(error.champs + "Error"); 
            //cette partie permet de créer une variable pour chacune de mes box error
            // sans répéter la fonction à chaque fois
            if(errorBox) {
                errorBox.innerHTML = error.message;
            } 
        });

        let section = document.querySelector(".formulaire-recette[data-recette-id]");
        let recette = section.getAttribute('data-recette-id');

        if (recette === "0") {
        alert("Veuillez choisir une farine et indiquer une quantité.");
        }

        //si aucune erreur et que la recette existe, j'envoie le formulaire
        if(errors.length === 0 && recette !== 0){
            recetteForm.submit();
        }
    })
}

function fermerPopUp(){
    //Role: Fermer la modal
    //Parametre: néant
    //Retour: néant

    // Liste des IDs des modales à fermer
    const idsModales = ["popup_farine", "formulaire_modification"];

    idsModales.forEach(function(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.innerHTML = "";           // Vider le contenu
            modal.style.display = "none";   // Masquer la modale
        }
    });

}


function demanderFarine(ref){
    //Role: demander à l'api le détail d'une farine et transmettre le retour à afficherFarine
    //Parametre:
    //  ref: la reférence de la farine
    //Retour: Neant

    //construire l'url à appeller (celle du controleur)
    let url = "afficher_farine_ajax.php?ref=" + ref;
    fetch(url)
        .then(function(response){
            return response.text();     //Le retour de la fonction est du texte brut pour le html
        })
        .then(afficherFarine);
}

function afficherFarine(fragment){
    //Role: afficher dans le cadre #popup_farine le contenu html reçu
    //Paramtres:
    //  fragment: code HTML à afficher
    //Retour: Néant

    //On remplace le contenu de la div #popup_farine par le fragment:
    document.getElementById("popup_farine").innerHTML = fragment;
    document.getElementById("popup_farine").style.display="flex";
}

function demanderProfil(){
    //Role: demander au serveur les information de l'utilisateur connecté
    //Parametre:
    //  Neant
    //Retour: Neant

    //construire l'url à appeller (celle du controleur)
    let url = "afficher_formulaire_modification_ajax.php" ;  
    fetch(url)
        .then(function(response){
            return response.text();     //Le retour de la fonction est du texte brut pour le html
        })
        .then(afficherProfil);
}

function afficherProfil(fragment){
    //Role: afficher dans le cadre #formulaire_modification le contenu html reçu
    //Paramtres:
    //  fragment: code HTML à afficher
    //Retour: Néant

    //On remplace le contenu de la div #formulaire_modification par le fragment:
    document.getElementById("formulaire_modification").innerHTML = fragment;
    document.getElementById("formulaire_modification").style.display="flex";
}

function recupererFarinesChoisies(id){
    //Role: récupérer les farines choisies de la recette
    //parametre: 
    //  id de la recette
    //Retour: Néant

    //construire l'url à appeller (celle du controleur)
    let url = "recuperer_farines_choisies_ajax.php?id=" + id ;  
    fetch(url)
        .then(function(response){
            return response.text();     //Le retour de la fonction est du texte brut pour le html
        })
        .then(afficherListFarines);
}

function supprimerFarineChoisie(id){
    //Role: supprimer la farine choisie de la recette
    //parametre: 
    //  id de la farine choisie
    //Retour: Néant

    let section = document.querySelector(".formulaire-recette[data-recette-id]");
    let recette = section.getAttribute('data-recette-id');

    //construire l'url à appeller (celle du controleur)
    let url = "supprimer_farine_choisie_ajax.php?id=" + id + "&recette=" + recette;  
    fetch(url)
        .then(function(response){
            return response.text();     //Le retour de la fonction est du texte brut pour le html
        })
        .then(afficherListFarines);
}

function recupererIngredientsChoisis(id){
    //Role: récupérer les ingredients choisis de la recette
    //parametre: 
    //  id de la recette
    //Retour: Néant

    //construire l'url à appeller (celle du controleur)
    let url = "recuperer_ingredients_choisis_ajax.php?id=" + id ;  
    fetch(url)
        .then(function(response){
            return response.text();     //Le retour de la fonction est du texte brut pour le html
        })
        .then(afficherListIngredients);
}

function supprimerIngredientChoisi(id){
    //Role: supprimer l'ingredient choisi de la recette
    //parametre: 
    //  id de la farine choisie
    //Retour: Néant

    let section = document.querySelector(".formulaire-recette[data-recette-id]");
    let recette = section.getAttribute('data-recette-id');

    //construire l'url à appeller (celle du controleur)
    let url = "supprimer_ingredient_choisi_ajax.php?id=" + id + "&recette=" + recette;  
    fetch(url)
        .then(function(response){
            return response.text();     //Le retour de la fonction est du texte brut pour le html
        })
        .then(afficherListIngredients);
    }

function enregistrerFarineCreerRecette(){
    //Role: Créer une recette et enregistrer la farine:
    //Prametre:
    //  Néant
    //Retour: Neant
    let farine = document.querySelector('select[name="farine"]').value;
    let quantite = document.querySelector('input[name="quantite"]').value;
    let titre = document.querySelector('input[name="titre"]').value;

    if (farine === "0" || quantite === "") {
        alert("Veuillez choisir une farine et indiquer une quantité.");
        return;
    }

    //construire l'url à appeller (celle du controlleur)
    let url = "creer_recette.php?farine=" + farine + "&quantite=" + quantite + "&titre=" + titre;  //Voir si on met un + pour transmettre les infos de la farine
    fetch(url)
        .then(function(response){
            return response.json();     //Le retour de la fonction est un json
        })
        .then(data => {
            if (data.success) {
                // Met à jour l’attribut data-recette-id
                document.querySelector('.formulaire-recette')
                    .setAttribute('data-recette-id', data.idRecette);

                // Met à jour l'action du formulaire
                document.querySelector('#form-recette')
                    .setAttribute('action', 'enregistrer_recette.php?id=' + data.idRecette);

                // Met à jour la liste de farines
                document.querySelector('#list_farines').innerHTML = data.htmlFarinesChoisies;
            }
        })

} 


function enregistrerFarine(){
    //Role: Enregistrer dans la bdd la farine et ses info en lien avec la recette
    //Parametre:
    //  Neant
    //Retour: Neant
    let formFarine = document.getElementById("form-farine");
    let section = document.querySelector(".formulaire-recette[data-recette-id]");
    let id = section.getAttribute('data-recette-id');
    let farine = formFarine.querySelector('select[name="farine"]').value;
    let quantite = formFarine.querySelector('input[name="quantite"]').value;

    if (farine === "0" || quantite === "") {
        alert("Veuillez choisir une farine et indiquer une quantité.");
        return;
    }

    //construire l'url à appeller (celle du controleur)
    let url = "enregistrer_farine_ajax.php?id=" + id + "&farine=" + farine + "&quantite=" + quantite;  //Voir si on met un + pour transmettre les infos de la farine
    fetch(url)
        .then(function(response){
            return response.text();     //Le retour de la fonction est du texte brut pour le html
        })
        .then(afficherListFarines);
}

function afficherListFarines(fragment){
    //Role: afficher dans le cadre #list_farines le contenu html reçu
    //Paramtres:
    //  fragment: code HTML à afficher
    //Retour: Néant

    //On remplace le contenu de la div #list_farines par le fragment:
    document.getElementById("list_farines").innerHTML = fragment;
}

function enregistrerIngredient(){
    //Role: Enregistrer dans la bdd l'ingredient et ses info en lien avec la recette
    //Parametre:
    //  Neant
    //Retour: Neant
    let formIngredient = document.getElementById("form-ingredient");
    let section = document.querySelector(".formulaire-recette[data-recette-id]");
    let id = section.getAttribute('data-recette-id');
    let ingredient = formIngredient.querySelector('input[name="ingredient"]').value;
    let quantite = formIngredient.querySelector('input[name="quantite"]').value;
    let unite = formIngredient.querySelector('input[name="unite"]').value;

    if (ingredient === "" || quantite === "" || unite === "") {
        alert("Veuillez choisir un ingredient et indiquer une quantité et une unité.");
        return;
    }

    // Préparer les données à envoyer en POST
    let formData = new FormData();
    formData.append("ingredient", ingredient);
    formData.append("quantite", quantite);
    formData.append("unite", unite);


    //construire l'url à appeller (celle du controleur)
    let url = "enregistrer_ingredient_ajax.php?id=" + id;  
    fetch(url, {
        method: "POST",
        body: formData
    })
        .then(function(response){
            return response.text();     //Le retour de la fonction est du texte brut pour le html
        })
        .then(afficherListIngredients);
}

function afficherListIngredients(fragment){
    //Role: afficher dans le cadre #list_ingredients le contenu html reçu
    //Paramtres:
    //  fragment: code HTML à afficher
    //Retour: Néant

    //On remplace le contenu de la div #list_ingredients par le fragment:
    document.getElementById("list_ingredients").innerHTML = fragment;
}