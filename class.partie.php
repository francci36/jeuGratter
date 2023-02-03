<?php
    require_once('class.ticket.php');
    class Partie extends Ticket
    {
        public $id;
        public $ticket;
        public $valeur;
        public $date;
        public $etat;

        private function genererDate()
        {
            $date = date('Y-m-d');
            return $date;
        }

        public function __construct($id='')
        {
            global $db;
            if($id)
            {
                $req = $db->prepare('SELECT * FROM `Table_Partie` WHERE Partie_ID = :id');
                $req->bindParam(':id',$id,PDO::PARAM_INT);
                $req->execute();
                if($req->rowCount() ==1)
                {
                    return $req->fetch(PDO::FETCH_OBJ);
                }
            }
        }

        public function setTicket()
        {
            $this->ticket = $this->getTicketID();
        }
        public function setValeur($valeur)
        {
            $this->valeur = $valeur;
        }
        public function setDate()
        {
            $this->date = $this->genererDate();
        }
        public function setEtat($etat)
        {
            $this->etat = $etat;
        }   

        public function register()
        {
            global $db;
            $req = $db->prepare('   INSERT INTO `Table_Partie` SET
                                    Partie_ID           = :id,
                                    Partie_Ticket_ID    = :ticketid,
                                    Partie_Valeur       = :valeur,
                                    Partie_Date         = CURDATE(),
                                    Partie-Etat         = :etat
                                ');
            $req->bindValue(':id',$this->id,PDO::PARAM_INT);
            $req->bindValue(':ticketid',$this->ticket,PDO::PARAM_INT);
            $req->bindValue(':valeur',$this->valeur,PDO::PARAM_INT);
            $req->bindValue(':etat',$this->etat,PDO::PARAM_STR);
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
        // Les GETTER
        public function getId()
        {
            return $this->id;
        }
        public function getTicket()
        {
            return $this->ticket;
        }
        public function getValeur()
        {
            return $this->valeur;
        }
        public function getDate()
        {
            return $this->date;
        }
        public function getEtat()
        {
            return $this->etat;
        }
        // Méthode pour modifier la partie en BDD
        public function updatePartie()
        {
            global $db;

            $req = $db->prepare('   UPDATE `Table_Partie` SET
                                    Partie_Ticket_ID    = :ticketid,
                                    Partie_Valeur       = :valeur,
                                    Partie_Etat         = :etat,
                                    WHERE Partie_ID     = :id
                                ');
            $req->bindValue(':ticketid',$this->ticket,PDO::PARAM_INT);
            $req->bindValue(':valeur',$this->valeur,PDO::PARAM_INT);
            $req->bindValue(':etat',$this->etat,PDO::PARAM_STR);
            $req->bindValue(':id',$this->id,PDO::PARAM_INT);
            if($req->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        // méthode pour update la date
        public function updateDate()
        {
            global $db;
            $req = $db->prepare('   UPDATE `Table_Partie` SET
                                    Partie_Date    = CURDATE()
                                    WHERE Partie_ID     = :id
                                ');
            $req->bindValue(':id',$this->date,PDO::PARAM_INT);
            if($req->execute())
            {
                return true;
            }
            else
            {
                return false;
            }

        }
        // Méthode pour supprimer une partie
        public function deletePartie()
        {
            global $db;
            $req = $db->prepare('DELETE FROM `Table_Partie` WHERE Partie_ID = :id');
            $req->bindValue(':id',$this->id,PDO::PARAM_INT);
            if($req->execute())
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
?>