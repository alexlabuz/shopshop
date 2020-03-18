<?php

class Utilsateur{
    private $db;
    private $insert; // 1
    private $connect;

    public function __construct($db){
        $this->db = $db;

        $this->insert = $this->db->prepare("INSERT INTO utilisateur(email, mdp, nom, prenom, idRole)
        VALUES(:email, :mdp, :nom, :prenom, :roleUtilisateur)"); // 2

        $this->connect = $this->db->prepare("SELECT * FROM utilisateur WHERE email=:email");
    }

    // Fonction qui ajoute un utilsateur dans la base de données
    public function insert($email, $mdp, $nom, $prenom, $role){
        $r = true;
        $this->insert->execute(array(':email' => $email, ':mdp' => $mdp, ':nom' => $nom, ':prenom' => $prenom, ':roleUtilisateur' => $role));
        
        if($this->insert->errorCode() != 0){
            //print_r($this->insert->errorInfo());
            $r = false;
        }

        return $r;
    } // 3

    public function connect($email){
        $this->connect->execute(array(':email'=>$email));

        if($this->connect->errorCode() != 0){
            print_r($this->connect->errorInfo());
        }
        return $this->connect->fetch();
    }

}

?>