<?php

function listeProduitControleur($twig, $db){

    $type = new Produit($db);
    $liste = $type->select();

    echo $twig->render("produit-admin.html.twig", array("liste" => $liste));
}

function ajoutProduit($twig, $db){
    $produit = new Produit($db);

    $type = new Type($db);
    $listeType = $type->select();

    $form['valid'] = true;

    if(isset($_POST['btValid'])){
        $designation = $_POST["designation"];
        $description = $_POST["description"];
        $prix = $_POST["prix"];
        $type = $_POST["type"];

        $exec = $produit->insert($designation, $description, $prix, $type);


        if(!$exec){
            $form['valid'] = false;
        }else{
            header("Location:index.php?page=produit-admin");
        }
    }

    echo $twig->render("ajouteProduit.html.twig", array("form" => $form, "listeType" => $listeType));    
}

function listeControleur($twig){
    echo $twig->render("liste_article.html.twig", array());
}

function produitControleur($twig){
    echo $twig->render("apercu-produit.html.twig", array());
}

?>