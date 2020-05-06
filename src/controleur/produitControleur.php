<?php

function listeProduitControleur($twig, $db){
    $form = array();
    $produit = new Produit($db);
    
    $limite = 3;
    if(!isset($_GET['nopage'])){
        $nopage = 0;
        $inf = 0;
    }else{
        $nopage = $_GET["nopage"];
        $inf = $nopage * $limite;
    }
    $r = $produit->selectCount();
    $nb = $r['nb'];

    $liste = $produit->selectLimit($inf, $limite);
    $form["nbpages"] = ceil($nb/$limite);
    $form["nopage"] = $nopage;

    if(isset($_POST["btSupprimer"])){
        $cocher = $_POST["cocher"];
        $form['valide'] = true;
        $etat = true;

        foreach($cocher as $id){
            $exec = $produit->delete($id);
            if(!$exec){
                $etat = false;
            }
        }
        header("Location:index.php?page=produit-admin&etat=". $etat);
        exit;
    }

    if(isset($_GET['etat'])){
        $form["etat"] = $_GET["etat"];
    }

    echo $twig->render("produit-admin.html.twig", array("form" => $form,"liste" => $liste));
}

function ajoutProduit($twig, $db){
    $produit = new Produit($db);

    $type = new Type($db);
    $listeType = $type->select();

    $form['valid'] = true;

    if(isset($_POST['btValid'])){
        $photo = null;
        $designation = $_POST["designation"];
        $description = $_POST["description"];
        $prix = $_POST["prix"];
        $type = $_POST["type"];

        $upload = new Upload(array("png", "gif", "jpg", "jpeg"), "images", 2000000);
        $photo = $upload->enregistrer("photo");

        $exec = $produit->insert($designation, $description, $prix, $type, $photo["chemin"]);

        if(!$exec){
            $form['valid'] = false;
        }else{
            header("Location:index.php?page=produit-admin");
        }
    }

    echo $twig->render("ajouteProduit.html.twig", array("form" => $form, "listeType" => $listeType));    
}

function listeControleur($twig, $db){
    echo $twig->render("liste_article.html.twig", array());
}

function produitControleur($twig, $db){
    $form = array();

    if(isset($_GET["id"])){
        $produit = new Produit($db);
        $unProduit = $produit->selectById($_GET["id"]);

        if($unProduit != null){
            $form["produit"] = $unProduit;
            $type = new Type($db);
        }else{
            $form['valide'] = false;
            $form["message"] = "Produit introuvable";
        }
    }

    echo $twig->render("apercu-produit.html.twig", array("form" => $form));
}

function produitModifControleur($twig, $db){
    $form = array();
    $produit = new Produit($db);

    if(isset($_GET['id'])){    
    $unProduit = $produit->selectById($_GET['id']);

        if($unProduit != null){
            $form["produit"] = $unProduit;
            $type = new Type($db);
            $liste = $type->select();
            $form['types'] = $liste;
        }else{
            $form['valide'] = false;
            $form["message"] = "Produit introuvable";
        }

    }else{

        if(isset($_POST["btModifier"])){
            $photo = null;
            $id = $_POST["id"];
            $designation = $_POST["designation"];
            $description = $_POST["description"];
            $prix = $_POST["prix"];
            $idType = $_POST["type"];

            $upload = new Upload(array("png", "gif", "jpg", "jpeg"), "images", 2000000);
            $photo = $upload->enregistrer("photo");

            $exec = $produit->update($id, $designation, $description, $prix, $photo["chemin"] ,$idType);
            if(!$exec){
                $form['valide'] = false;
                $form['message'] = "Echec de la modification";
            }else{
                $form['valide'] = true;
                $form['message'] = "Modification réussi";
            }
        }elseif(isset($_POST["btEffaceImage"])){
            $id = $_POST["id"];
            $unProduit = $produit->selectById($id);

            unlink($unProduit["photo"]);
            $exec = $produit->update($id, $unProduit["designation"], $unProduit["description"], $unProduit["prix"], null ,$unProduit["idType"]);if(!$exec){
                $form['valide'] = false;
                $form['message'] = "Echec de la modification";
            }else{
                $form['valide'] = true;
                $form['message'] = "Modification réussi";
            }
        }else{
            $form['valide'] = false;
            $form["message"] = "Pas de produit précisé";
        }

    }

    echo $twig->render("produit-modif.html.twig", array("form" => $form));
}

?>