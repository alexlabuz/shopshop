<?php

function inscrireControleur($twig, $db){
    $form = array();
    if(isset($_POST['btInscrire'])){

        $email = $_POST['email'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mdp = $_POST['mdp'];
        $mdp2 = $_POST['mdp2'];
        $role = $_POST['role'];

        $form['valide'] = true;
        $form['name'] = $nom;

        if($mdp != $mdp2){
            $form['valide'] = false;
            $form['message'] = "Les mots de passe sont différent";
        }else{
            $utilisateur = new Utilsateur($db);
            $exec = $utilisateur->insert($email, password_hash($mdp, PASSWORD_DEFAULT), $nom, $prenom, $role);

            if(!$exec){
                $form['valide'] = false;
                $form['message'] = 'Désoler, nous avons pas réussi à vous inscrire';
            }
        }

        $form['email'] = $email;
        $form['role'] = $role;

    }

    echo $twig->render("inscrire.html.twig", array("form" => $form));
}

function connectionControleur($twig, $db){
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


        $utilisateur = new Utilsateur($db);
        $unUtilisateur = $utilisateur->connect($email);

        if($unUtilisateur != null){
            if(!password_verify($mdp, $unUtilisateur['mdp'])){
                $form["valide"] = false;
                $form["message"] = "Login ou mot de passe incorrect";
            }else{
                header("location: index.php");
            }
        }else{
            $form["valide"] = false;
            $form["message"] = "Login ou mot de passe incorrect";
        }
    }

    echo $twig->render("connection.html.twig", array("form" => $form));
}

?>