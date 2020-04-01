<?php

class Type{
    private $db;
    private $select;
    private $insert;
    private $selectById;
    private $update;

    public function __construct($db){
        $this->db = $db;

        $this->select = $this->db->prepare("SELECT * FROM type ORDER BY libelle");

        $this->insert = $this->db->prepare("INSERT INTO type(libelle) VALUES (:libelle)");

        $this->selectById = $this->db->prepare("SELECT * FROM type WHERE id = :id");

        $this->update = $this->db->prepare("UPDATE type SET libelle = :libelle WHERE id = :id");
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

}