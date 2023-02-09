<?php
    require_once('class.ticket.php');
    class Categorie extends Ticket
    {
        public $id;
        public $nom;
        public function __construct($id ='',$args='')
        {
            global $db;
            if(!empty($id))
            {
                $req = $db->prepare('SELECT * FROM `table_categorie` WHERE categorie_id = :id');
                $req->bindParam(':id', $id, PDO::PARAM_INT);
                if ($req->execute()) {
                    // si la requette s'execute correctement
                    if ($req->rowCount() == 1) {
                        // on retourne l'objet user
                        $obj = $req->fetch(PDO::FETCH_OBJ);
                        $this->id = $obj->categorie_id;
                        $this->nom = $obj->categorie_name;
                    } 
                    else 
                    {
                        return false;
                    }
                } 
                else 
                {
                    return false;
                }
            }
            elseif(!empty($args))
            {
                $this->nom = $args['nom'];
                $inscription = self::inscrire();
                if($inscription)
            {
                return true;
            }
            else
            {
                return false;
            }
            }
        }
            
        public function setNom($nom)
        {
            $this->nom = $nom;
        }
        public function getNom()
        {
            return $this->nom;
        }
        public function inscrire()
        {
            global $db;
            // on va vérifier si la categorie n'est pas déjà dans la bdd
            $req = $db->prepare('SELECT `categorie_id` FROM `table_categorie`WHERE categorie_name = :nom');
            $req->bindParam(':nom',$this->nom,PDO::PARAM_INT);
            $req->execute();
            if($req->rowCount() ==0)
            {
                // on va pouvoir les inserer notre client dans la bdd
                $req = $db->prepare('INSERT INTO `table_categorie`SET
                                    categorie_name = :nom               
                ');
                $req->bindValue(':nom',$this->nom,PDO::PARAM_STR);
                if($req->execute())
                {
                    $last_id =$db->lastInsertId();
                    return $last_id;
                }
                else
                {
                    return false;
                }
            }
        }
        
    }
   
?>