<?php
require_once('class.ticket.php');
class Partie extends Ticket
{
    public $id;
    public $ticket;
    public $valeur;
    public $date;
    public $etat;

    public function __construct($id='')
    {
        global $db;
        $req = $db->prepare('SELECT * FROM `table_partie` WERE ticket_id = :id');
        $req->bindParam(':id',$id,PDO::PARAM_INT);
        $req->execute();
        if($req->rowCount() == 1)
        {
            return $req->fetch(PDO::FETCH_OBJ);
        }
        
    }
    public  function setId($id)
    {
        $this->id = $id;
    }
    public  function setTicket($ticket)
    {
        $this->id = $ticket;
    }
    public  function setValeur($valeur)
    {
        $this->id = $valeur;
    }
    public  function setDate($date)
    {
        $this->id = $date;
    }
    public  function setEtat($etat)
    {
        $this->id = $etat;
    }

    // les getter
    public function getTicket($ticket)
    {
        $this->id = $ticket;
    }
    public function getValeur($valeur)
    {
        $this->id = $valeur;
    }
    public function getDate($date)
    {
        $this->id = $date;
    }
    public function getEtat($etat)
    {
        $this->id = $etat;
    }
    public function regisPartie()
    {
        global $db;
        $req = $db->prepare('INSERT INTO `table_partie` SET 
                            partie_id = :id,
                            valeur_partie = :valeur,
                            partie_date = :CURDATE(),
                            partie_etat= :etat
        ');
        $req->bindValue(':partie_id',$this->id,PDO::PARAM_INT);
        $req->bindValue(':valeur_partie',$this->valeur,PDO::PARAM_INT);
        $req->bindValue(':partie_etat',$this->etat,PDO::PARAM_INT);
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
    public function update()
    {
        global $db;
        $req = $db->prepare('UPDATE `table_partie`SET
                            partie_id = :id,
                            valeur_partie = :valeur,
                            partie_date = :CURDATE(),
                            partie_etat= :etat
                            WHERE partie_id= :id
        
        ');
        $req->bindValue(':partie_id',$this->id,PDO::PARAM_INT);
        $req->bindValue(':valeur_partie',$this->valeur,PDO::PARAM_INT);
        $req->bindValue(':partie_etat',$this->etat,PDO::PARAM_INT);
        if($req->execute())
        
            return true;
            else
            return false;
        
     
        }
        public function deletePartie()
       {
        global $db;
        $req = $db->prepare('DELETE `table_partie`WHERE partie_id= :id');
        $req->bindValue(':id',$this->id,PDO::PARAM_INT);
        if($req->execute())
        return true;
        else
        return false;
       }
    
}


?>