<?php

function getPage($db){

    $lesPages['accueil'] = "accueilControleur;0";
    $lesPages['contact'] = "contactControleur;0";
    $lesPages['connection'] = "connectionControleur;0";
    $lesPages['inscrire'] = "inscrireControleur;0";
    $lesPages['maintenance'] = "maintenanceControleur;0";
    $lesPages['produit'] = "produitControleur;0";
    $lesPages['liste'] = "listeControleur;0";
    $lesPages['deconnexion'] = "deconnexionControleur;0";
    $lesPages['utilisateur'] = "utilisateurControleur;1";
    $lesPages['type'] = "typeControleur;1";
    $lesPages['typeModif'] = "typeModifControleur;1";
    $lesPages['produit-admin'] = "listeProduitControleur;1";
    $lesPages['ajoutProduit'] = "ajoutProduit;1";
    $lesPages['utilisateurModif'] = "utilisateurModifControleur;1";
    $lesPages['produitModif'] = "produitModifControleur;1";
    $lesPages['recherche'] = "rechercheControleur;0";

    if($db != null){
        // Vérifie si page existe dans GET
        if(isset($_GET["page"])){
            $page = $_GET['page'];
        }
        else{
            $page = "accueil";
        }

        // Teste si la page dans GET n'existe pas
        if(!isset($lesPages[$page])){
            $contenu = $lesPages['accueil'];
        }

        // Vérifie si l'utilisateur à le dro
        $explode = explode(";", $lesPages[$page]);
        $role = $explode[1];

        if($role != 0){
            if(isset($_SESSION["login"])){
                if(isset($_SESSION["role"])){
                    if($role != $_SESSION["role"]){
                        $contenu = "accueilControleur";
                    }else{
                        $contenu = $explode[0];
                    }
                }else{
                    $contenu = "accueilControleur";
                }
            }else{
                $contenu = "accueilControleur";
            }
        }else{
            $contenu = $explode[0];
        }

    }else{
        $contenu = $lesPages["maintenance"];
    }

    return $contenu;
}