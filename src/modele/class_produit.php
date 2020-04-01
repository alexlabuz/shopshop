<?php

class Produit{
    private $db;
    private $select;
    private $insert;
    private $selectById;
    private $update;

    public function __construct($db){
        $this->db = $db;
        
        $this->select = $this->db->prepare(
        "SELECT p.id AS id, designation, description, prix, idType, t.libelle AS libelleType 
        FROM produit p, type t WHERE p.idType = t.id ORDER BY p.designation");

        $this->insert = $this->db->prepare("INSERT INTO produit(designation, description, prix, idType) 
        VALUES (:designation ,:description ,:prix ,:idType)");

        $this->selectById = $this->db->prepare("SELECT * FROM produit WHERE id = :id");

        $this->update = $this->db->prepare("UPDATE produit
        SET designation = :designation, description = :description, prix = :prix, idType = :idType 
        WHERE id = :id");
    }

    public function select()
    {
        $liste = $this->select->execute();
        if($this->select->errorCode() != 0){
            print_r($this->select->errorInfo());
        }

        return $this->select->fetchAll();
    }

    public function insert($designation ,$description ,$prix ,$idType){
        $r = true;
         $this->insert->execute(array(':designation' => $designation, ':description' => $description ,':prix' => $prix ,':idType' => $idType));
         
        if($this->insert->errorCode() != 0){
            print_r($this->insert->errorInfo());
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

    public function update($id, $designation, $description, $prix, $idType){
        $r = true;
        $this->update->execute(array(
            ":designation" => $designation,
            ":description" => $description,
            ":prix" => $prix,
            ":idType" => $idType,
            ":id" => $id
        ));

        if($this->update->errorCode() != 0){
            print_r($this->update->errorInfo());
            $r = false;
        }

        return $r;
    }

}