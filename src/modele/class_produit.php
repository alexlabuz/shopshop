<?php

class Produit{
    private $db;
    private $select;
    private $insert;
    private $selectById;
    private $update;
    private $delete;
    private $selectByType;
    private $selectLimit;
    private $selectCount;
    private $recherche;
    private $rechercheCount;

    public function __construct($db){
        $this->db = $db;
        
        $this->select = $this->db->prepare(
        "SELECT p.id AS id, designation, description, prix, idType, t.libelle AS libelleType, photo
        FROM produit p, type t WHERE p.idType = t.id ORDER BY p.designation");

        $this->insert = $this->db->prepare("INSERT INTO produit(designation, description, prix, idType, photo) 
        VALUES (:designation ,:description ,:prix ,:idType, :photo)");

        $this->selectById = $this->db->prepare("SELECT * FROM produit WHERE id = :id");

        $this->update = $this->db->prepare("UPDATE produit
        SET designation = :designation, description = :description, prix = :prix, idType = :idType, photo = :photo
        WHERE id = :id");

        $this->delete = $this->db->prepare("DELETE FROM produit WHERE id = :id");

        $this->selectByType = $this->db->prepare("SELECT * FROM produit WHERE idType = :idType");

        $this->selectLimit = $db->prepare(
            "SELECT id, designation, description, prix, idType
            FROM produit ORDER BY designation LIMIT :inf, :limite");

        $this->selectCount = $db->prepare("SELECT COUNT(*) AS nb FROM produit");

        $this->recherche = $db->prepare(
            "SELECT p.id AS id, designation, description, prix, photo, t.libelle AS type
            FROM produit p, type t
            WHERE p.idType = t.id
            AND (LOWER(p.designation) LIKE LOWER(:recherche)
            OR LOWER(p.description) LIKE LOWER(:recherche))
            ORDER BY designation
            LIMIT :inf, :limite");

        $this->rechercheCount = $db->prepare(
            "SELECT count(*) AS nb
            FROM produit
            WHERE (designation LIKE :recherche
            OR description LIKE :recherche)");
    }

    public function select(){
        $liste = $this->select->execute();
        if($this->select->errorCode() != 0){
            print_r($this->select->errorInfo());
        }

        return $this->select->fetchAll();
    }

    public function insert($designation ,$description ,$prix ,$idType, $photo){
        $r = true;
         $this->insert->execute(array(
        ':designation' => $designation,
         ':description' => $description ,
         ':prix' => $prix ,
         ':idType' => $idType,
         ':photo' => $photo
        ));
         
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

    public function update($id, $designation, $description, $prix, $photo, $idType){
        $r = true;
        $this->update->execute(array(
            ":designation" => $designation,
            ":description" => $description,
            ":prix" => $prix,
            ":idType" => $idType,
            ":photo" => $photo,
            ":id" => $id
        ));

        if($this->update->errorCode() != 0){
            print_r($this->update->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function delete($id){
        $r = true;
        $this->delete->execute(array(":id"=>$id));

        if($this->delete->errorCode() != 0){
            print_r($this->delete->errorInfo());
            $r = false;
        }

        return $r;
    }

    public function selectByType($idType){
        $this->selectByType->execute(array(":idType" => $idType));

        if($this->selectByType->errorCode() != 0){
            print_r($this->selectByType->errorInfo());
        }
    

        return $this->selectByType->fetch();
    }

    public function selectLimit($inf, $limite){
        $this->selectLimit->bindParam(":inf", $inf , PDO::PARAM_INT);
        $this->selectLimit->bindParam(":limite", $limite , PDO::PARAM_INT);
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

    public function recherche($recherche, $inf, $limite){
        $this->recherche->bindParam(":inf", $inf, PDO::PARAM_INT);
        $this->recherche->bindParam(":limite", $limite, PDO::PARAM_INT);
        $this->recherche->bindValue(":recherche", "%".$recherche."%", PDO::PARAM_STR);
        
        $this->recherche->execute();

        if($this->recherche->errorCode()!=0){
            print_r($this->recherche->errorInfo());
        }

        return $this->recherche->fetchAll();
    }

    public function rechercheCount($recherche){
        $this->rechercheCount->execute(array("recherche"=>"%".$recherche."%"));

        if($this->rechercheCount->errorCode()!=0){
            print_r($this->rechercheCount->errorInfo());
        }

        return $this->rechercheCount->fetch();
    }
}