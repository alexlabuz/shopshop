<?php

function getPage($db){

    $lesPages['accueil'] = "accueilControleur";
    $lesPages['contact'] = "contactControleur";
    $lesPages['connection'] = "connectionControleur";
    $lesPages['inscrire'] = "inscrireControleur";
    $lesPages['produit'] = "produitControleur";
    $lesPages['liste'] = "listeControleur";
    $lesPages['maintenance'] = "maintenanceControleur";
    $lesPages['deconnexion'] = "deconnexionControleur";
    $lesPages['utilisateur'] = "utilisateurControleur";
    $lesPages['type'] = "typeControleur";
    $lesPages['typeModif'] = "typeModifControleur";
    $lesPages['produit-admin'] = "listeProduitControleur";
    $lesPages['ajoutProduit'] = "ajoutProduit";
    $lesPages['utilisateurModif'] = "utilisateurModifControleur";
    $lesPages['produitModif'] = "produitModifControleur";
    $lesPages['recherche'] = "rechercheControleur";

    if($db != null){
        if(isset($_GET["page"])){
            $page = $_GET['page'];
        }
        else{
            $page = "accueil";
        }

        if(isset($lesPages[$page])){
            $contenu = $lesPages[$page];
        }
        else{
            $contenu = $lesPages['accueil'];
        }
    }else{
        $contenu = $lesPages["maintenance"];
    }

    return $contenu;
}