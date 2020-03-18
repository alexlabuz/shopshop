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