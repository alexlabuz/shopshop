<?php

class Utilisateur{
    private $db;
    private $insert; // 1
    private $connect;
    private $select;
    private $selectById;
    private $update;
    private $updateMdp;
    private $delete;

    public function __construct($db){
        $this->db = $db;

        $this->insert = $this->db->prepare("INSERT INTO utilisateur(email, mdp, nom, prenom, idRole)
        VALUES(:email, :mdp, :nom, :prenom, :roleUtilisateur)"); // 2

        $this->connect = $this->db->prepare("SELECT * FROM utilisateur WHERE email=:email");

        $this->select = $this->db->prepare(
        "SELECT u.id AS id ,email, idRole, nom, prenom, r.libelle AS libellerole
        FROM utilisateur u, role r
        WHERE u.idRole = r.id
        ORDER BY nom");

        $this->selectById = $this->db->prepare("SELECT * FROM utilisateur WHERE id = :id");

        $this->update = $this->db->prepare("UPDATE utilisateur 
        SET nom = :nom, prenom = :prenom, idRole = :role, email = :email
        WHERE id=:id");

        $this->updateMdp = $this->db->prepare("UPDATE utilisateur 
        SET mdp = :mdp
        WHERE id=:id");

        $this->delete = $db->prepare("DELETE FROM utilisateur WHERE id = :id");
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

    public function selectById($id){
        $this->selectById->execute(array(':id' => $id));

        if($this->selectById->errorCode() != 0){
            print_r($this->selectById->errorInfo());
        }

        return $this->selectById->fetch();
    }

    public function update($id, $role, $nom, $prenom, $email){
        $r = true;
        $this->update->execute(array(
            ":id"=>$id,
            ":role"=>$role,
            ":nom"=>$nom,
            ":prenom"=>$prenom,
            ":email"=>$email
        ));

        if($this->update->errorCode() != 0){
            print_r($this->update->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function updateMdp($id, $mdp){
        $r = true;
        $this->updateMdp->execute(array(":id" => $id, ":mdp" => $mdp));

        if($this->updateMdp->errorCode() != 0){
            print_r($this->updateMdp->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function delete($id){
        $r = true;

        $this->delete->execute(array(":id" => $id));
        if($this->delete->errorCode()!=0){
            print_r($this->delete->errorInfo());
            $r = false;
        }

        return $r;
    }

}

?>