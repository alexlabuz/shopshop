<?php

function typeControleur($twig, $db){
    $form = array();
    $types = new Type($db);
    $liste = $types->select();
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