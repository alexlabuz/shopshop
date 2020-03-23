<?php

class Produit{
    private $db;
    private $select;
    private $insert;

    public function __construct($db){
        $this->db = $db;
        
        $this->select = $this->db->prepare("SELECT p.id, t.id, 
        designation, description, prix, t.libelle AS libelleType 
        FROM produit p, type t WHERE p.idType = t.id ORDER BY p.designation");

        $this->insert = $this->db->prepare("INSERT INTO produit(designation, description, prix, idType) 
        VALUES (:designation ,:description ,:prix ,:idType)");

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


}