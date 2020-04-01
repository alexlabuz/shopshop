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
            $utilisateur = new Utilisateur($db);
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


        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->connect($email);

        if($unUtilisateur != null){
            if(!password_verify($mdp, $unUtilisateur['mdp'])){
                $form["valide"] = false;
                $form["message"] = "Login ou mot de passe incorrect";
            }else{
                $_SESSION["login"] = $email;
                $_SESSION["prenom"] = $unUtilisateur['prenom'];
                $_SESSION['role'] = $unUtilisateur['idRole'];
                header("location: index.php");
            }
        }else{
            $form["valide"] = false;
            $form["message"] = "Login ou mot de passe incorrect";
        }
    }

    echo $twig->render("connection.html.twig", array("form" => $form));
}

function utilisateurModifControleur($twig, $db){
    $form = array();
    $utilisateur = new Utilisateur($db);
    
    if(isset($_GET['id'])){
        $unUtilisateur = $utilisateur->selectById($_GET['id']);

        if($unUtilisateur != null){
            $form["utilisateur"] = $unUtilisateur;
            $role = new Role($db);
            $liste = $role->select();
            $form['roles'] = $liste;
        }else{
            $form["message"] = "Utilisateur introuvable";
        }
    }else{
        if(isset($_POST["btModifier"])){
            $email = $_POST['email'];
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $role = $_POST["role"];
            $id = $_POST["id"];
            $mdp1 = $_POST["mdp1"];
            $mdp2 = $_POST["mdp2"];

            $exec = $utilisateur->update($id, $role, $nom, $prenom ,$email);
            if(!$exec){
                $form['valide'] = false;
                $form['message'] = "Echec de la modification";
            }else{
                $form['valide'] = true;
                $form['message'] = "Modification réussi";
            }

            if($mdp1 != null){
                if($mdp1 == $mdp2){
                    $exec = $utilisateur->updateMdp($id, password_hash($mdp1, PASSWORD_DEFAULT));
                    if(!$exec){
                        $form['valide'] = false;
                        $form['message'] = "Echec de la modification";
                    }
                }else{
                    $form['valide'] = false;
                    $form['message'] = "Les deux mots de passes ne corresponde pas";
                }
            }

        }else{
            $form["message"] = "Utilisateur non précisé";
        }
    }

    echo $twig->render("utilsateur-modif.html.twig", array("form" => $form));
}

function deconnexionControleur($twig, $db){
    session_unset();
    session_destroy();
    header("location: index.php");
}

?>