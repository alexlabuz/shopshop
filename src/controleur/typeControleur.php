<?php

function typeControleur($twig, $db){
    $form = array();
    $types = new Type($db);
    $form["valide"] = true;

    if(isset($_POST['btType'])){
        $libelle = $_POST["libelleType"];

        if(strlen($libelle) <= 0){
            $form["valide"] = false;
            $form["message"] = "Vous n'avez saisie aucun type";
        }else{
            $exec = $types->insert($_POST["libelleType"]);
            header("Location: index.php?page=type");

            if(!$exec){
                $form['valide'] = false;
                $form['message'] = 'Désoler, nous avons pas réussi à ajouter le type';
            }
        }
    }

    if(isset($_POST['btSupprimer'])){
        $cocher = $_POST['cocher'];
        $form["valide"] = true;
        $etat = true;

        // On vérifie si des article existe sous ce type
        $produit = new Produit($db);
        $existeArticle = false;
        foreach($cocher as $idType){
            $liste = $produit->selectByType($idType);
            if($liste != null){
                $existeArticle = true;
                $form["message"] = "Des articles existe déjà dans ce(s) rayon(s), suppression impossible";
            }
        }

        if(!$existeArticle){
            foreach($cocher as $id){
                $exec = $types->delete($id);
                if(!$exec){
                    $etat = false;
                }
            }

            header("Location:index.php?page=type&etat=". $etat);
            exit;
        }

    }

    if(isset($_GET["etat"])){
        $form['etat'] = $_GET['etat'];
    }

    $limite = 3;
    if(!isset($_GET["nopage"]) || empty($_GET["nopage"])){
        $nopage = 0;
        $inf = 0;
    }else{
        $nopage = $_GET["nopage"];
        $inf = $limite * $nopage;
    }

    $r = $types->selectCount();
    $nbArticle = $r["nb"];

    $liste = $types->selectLimit($inf, $limite);
    $form["nombrePage"] = ceil($nbArticle / $limite);
    $form["numeroPage"] = $nopage;
    echo $twig->render("type.html.twig", array("form" => $form, "liste" => $liste));    
}

function typeModifControleur($twig, $db){
    $form = array();
    $type = new Type($db);

    if(isset($_GET['id'])){
        $unType = $type->selectById($_GET['id']);

        if($unType != null){
            $form["type"] = $unType;
        }else{
            $form["message"] = "Type introuvable";
        }

    }else{
        if(isset($_POST["btModifier"])){
            $exec = $type->update($_POST['id'], $_POST['type']);
            if(!$exec){
                $form['valide'] = false;
                $form['message'] = "Echec de la modification";
            }else{
                $form['valide'] = true;
                $form['message'] = "Modification réussi";
            }
        }else{
            $form["message"] = "Type non précisé";
        }
    }

    echo $twig->render("type-modif.html.twig", array("form" => $form));    
}