<?php

class Type{
    private $db;
    private $select;
    private $insert;
    private $selectById;
    private $update;
    private $delete;
    private $selectLimit;
    private $selectCount;

    public function __construct($db){
        $this->db = $db;

        $this->select = $this->db->prepare("SELECT * FROM type ORDER BY libelle");

        $this->insert = $this->db->prepare("INSERT INTO type(libelle) VALUES (:libelle)");

        $this->selectById = $this->db->prepare("SELECT * FROM type WHERE id = :id");

        $this->update = $this->db->prepare("UPDATE type SET libelle = :libelle WHERE id = :id");

        $this->delete = $this->db->prepare("DELETE FROM type WHERE id = :id");

        $this->selectLimit = $this->db->prepare("SELECT * FROM type ORDER BY libelle LIMIT :inf, :limite");

        $this->selectCount = $this->db->prepare("SELECT COUNT(*) AS nb FROM type");
    }

    // Récupére tout les type de la base de données
    public function select(){
        $liste = $this->select->execute();

        if($this->select->errorCode() != 0){
            print_r($this->select->errorInfo());
        }

        return $this->select->fetchAll();
    }

    public function insert($libelle){
        $r = true;

        $this->insert->execute(array(':libelle' => $libelle));

        if($this->insert->errorCode() != 0){
            print_r($this->insert->erroInfo());
            $r = false;
        }

        return $r;
    }

    public function selectById($id){
        $this->selectById->execute(array(":id" => $id));

        if($this->selectById->errorCode() != 0){
            print_r($this->selectById->errorInfo());
        }
        
        return $this->selectById->fetch();
    }

    public function update($id, $libelle){
        $r = true;
        $this->update->execute(array(":libelle" => $libelle, ":id" => $id));

        if($this->update->errorCode() != 0){
            print_r($this->update->errorInfo());
            $r = false;
        }

        return $r;
    }
    
    public function delete($id){
        $r = true;
        $this->delete->execute(array(":id" => $id));

        if($this->delete->errorCode() != 0){
            print_r($this->delete->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function selectLimit($inf, $limite){
        $this->selectLimit->bindParam(":inf", $inf, PDO::PARAM_INT);
        $this->selectLimit->bindParam(":limite", $limite, PDO::PARAM_INT);
        $this->selectLimit->execute();

        if($this->selectLimit->errorCode() != 0){
            print_r($this->selectLimit->errorInfo());
        }

        return $this->selectLimit->fetchAll();
    }

    public function selectCount(){
        $this->selectCount->execute();

        if($this->selectCount->errorCode() != 0){
            print_r($this->selectCount->errorInfo());
        }

        return $this->selectCount->fetch();
    }

}