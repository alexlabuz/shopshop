<?php

class Utilisateur{
    private $db;
    private $insert; // 1
    private $connect;
    private $select;

    public function __construct($db){
        $this->db = $db;

        $this->insert = $this->db->prepare("INSERT INTO utilisateur(email, mdp, nom, prenom, idRole)
        VALUES(:email, :mdp, :nom, :prenom, :roleUtilisateur)"); // 2

        $this->connect = $this->db->prepare("SELECT * FROM utilisateur WHERE email=:email");

        $this->select = $this->db->prepare(
        "SELECT r.id, email, idRole, nom, prenom, r.libelle AS libellerole
        FROM utilisateur u, role r
        WHERE u.idRole = r.id
        ORDER BY nom");
    }

    // Fonction qui ajoute un utilsateur dans la base de données
    public function insert($email, $mdp, $nom, $prenom, $role){
        $r = true;
        $this->insert->execute(array(':email' => $email, ':mdp' => $mdp, ':nom' => $nom, ':prenom' => $prenom, ':roleUtilisateur' => $role));
        
        if($this->insert->errorCode() != 0){
            print_r($this->insert->errorInfo());
            $r = false;
        }

        return $r;
    } // 3

    // Fonction regarde si un utilisateur existe dans la base de données
    public function connect($email){
        $this->connect->execute(array(':email'=>$email));

        if($this->connect->errorCode() != 0){
            print_r($this->connect->errorInfo());
        }
        return $this->connect->fetch();
    }

    // Fonction récupére la liste des utilisateur de la base de données
    public function select(){
        $liste = $this->select->execute();

        if($this->select->errorCode() != 0){
            print_r($this->select->errorInfo());
        }

        return $this->select->fetchAll();
    }

}

?>