<?php

function accueilControleur($twig){
    echo $twig->render("accueil.html.twig", array());
}

function rechercheControleur($twig, $db){
    $form = array();
    $liste = null;
    
    if(isset($_POST["recherche"])){
        header("Location:index.php?page=recherche&recherche=".$_POST["recherche"]);
    }

    if(isset($_GET["recherche"]) && strlen($_GET["recherche"]) > 0){
        $recherche = $_GET["recherche"];
        $produit = new Produit($db);

        $limite = 3;
        $inf = 0;
        $nopage = 0;
        if(isset($_GET["nopage"])){
            $nopage = $_GET["nopage"];
            $inf = $nopage * $limite;
        }

        $r = $produit->rechercheCount($recherche);
        $nb = $r["nb"];

        $form["saisie"] = $recherche;

        $liste = $produit->recherche($recherche, $inf, $limite);
        $form["nbpage"] = ceil($nb/$limite);
        $form["nopage"] = $nopage;
    }
     
    echo $twig->render("recherche.html.twig", array("form"=>$form, "recherche"=>$liste));
}

function contactControleur($twig){
    echo $twig->render("contact.html.twig", array());
}

function maintenanceControleur($twig){
    echo $twig->render("maintenance.html.twig", array());
}

?>