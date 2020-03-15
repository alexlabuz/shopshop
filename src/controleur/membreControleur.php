<?php

function inscrireControleur($twig){
    $form = array();
    if(isset($_POST['btInscrire'])){

        $nom = $_POST['name'];
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];
        $mdp2 = $_POST['mdp2'];
        //$condition = $_POST['condition'];
        $role = $_POST['role'];

        $form['valide'] = true;
        $form['name'] = $nom;

        if($mdp != $mdp2){
            $form['valide'] = false;
            $form['message'] = "Les mots de passe sont différent";
        }

        $form['email'] = $email;
        $form['role'] = $role;

    }

    echo $twig->render("inscrire.html.twig", array("form" => $form));
}

function connectionControleur($twig){
    $form = array();

    if(isset($_POST["btConnecte"])){
        $email = $_POST["email"];
        $mdp = $_POST["mdp"];

        $resteConnecte = false;
        if(isset($_POST["resteConnecte"])){
            $resteConnecte = true;
        }
        
        $form["valide"] = true;
        $form["resteConnecte"] = $resteConnecte;
        $form["email"] = $email;
    }

    echo $twig->render("connection.html.twig", array("form" => $form));
}

?>