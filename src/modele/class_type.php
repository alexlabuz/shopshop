<?php

class Type{
    private $db;
    private $select;
    private $insert;

    public function __construct($db){
        $this->db = $db;

        $this->select = $this->db->prepare("SELECT * FROM type ORDER BY libelle");

        $this->insert = $this->db->prepare("INSERT INTO type(libelle) VALUES (:libelle)");
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


}