<?php
require('db-inc.php');
class ticket{
    public $id;
    public $categorie;
    public $nom;
    public $prix;
    public $nombre;
    
    public function __construct($id='')
    {
        global $db;
        $req = $db->prepare('SELECT * FROM `table_ticket` WERE ticket_id = :id');
        $req->bindParam(':id',$id,PDO::PARAM_INT);
        $req->execute();
        if($req->rowCount() == 1)
        {
            //return $req->fetch(PDO::FETCH_OBJ);
            $this->id = $id;
            $obj = $req->fetch(PDO::FETCH_OBJ);
            $this->id = $obj->ticket_id;
            $this->categorie = $obj->categorie_id;
            $this->nom = $obj->ticket_nom;
            $this->prix = $obj->ticket_prix;
            $this->nombre = $obj->ticket_nombre;
        }

    }
    public function getCategorie()
    {
        
    }
    public function getId()
        {
            return $this->id;
        }
        public function getNom()
        {
            return $this->nom;
        }
        public function getPrix()
        {
            return $this->prix;
        }
        public function getNombre()
        {
            return $this->nombre;
        }
    public  function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }
    public  function setnom($nom)
    {
        $this->nom= $nom;
    }
    public  function setprix($prix)
    {
        $this->prix = $prix;
    }
    public  function setnombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function register()
    {
        global $db;
        $req = $db->prepare('INSERT INTO `table_ticket` SET 
                            categorie_id = :categorie,
                            ticket_name = :nom,
                            prix_ticket = :prix,
                            nb_ticket= :nombre
        ');
        $req->bindValue(':categorie',$this->categorie,PDO::PARAM_INT);
        $req->bindValue(':nom',$this->nom,PDO::PARAM_STR);
        $req->bindValue(':prix',$this->prix,PDO::PARAM_INT);
        $req->bindValue(':nombre',$this->nombre,PDO::PARAM_INT);
        if($req->execute())
        {
            $id = $db->lastInsertId();
            return $id;
        }
        else
        {
            return false;
        }
    }
    // //methode pour modifier le ticket
    public function updatePartie()
    {
        global $db;
        $req = $db->prepare('UPDATE `table_ticket`SET
                            categorie_id = :categorie,
                            ticket_name = :nom,
                            prix_ticket = :prix,
                            nb_ticket= :nombre
                            WHERE categorie_id= :id
        
        ');
        $req->bindValue(':categorie',$this->categorie,PDO::PARAM_INT);
        $req->bindValue(':nom',$this->nom,PDO::PARAM_STR);
        $req->bindValue(':prix',$this->prix,PDO::PARAM_STR);
        $req->bindValue(':nombre',$this->nombre,PDO::PARAM_INT);
        $req->bindValue(':id',$this->id,PDO::PARAM_INT);
        if($req->execute())
        
            return true;
            else
            return false;
        
     
        }
       //methode pour supprrimer le ticket
       public function delete()
       {
        global $db;
        $req = $db->prepare('DELETE `table_ticket`WHERE ticket_id= :id');
        $req->bindValue(':id',$this->id,PDO::PARAM_INT);
        if($req->execute())
        return true;
        else
        return false;
       }
    
}