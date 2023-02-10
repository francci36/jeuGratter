<?php
//require_once('config.php');
class Client
{
    public $nom;
    public $prenom;
    public $email;
    public $password;
    public $credit;
    public $id;
    // contructeur de notre class
    public function __construct($id ='',$args='')
    {
        global $db;
        if(!empty($id))
        {
            $req = $db->prepare('SELECT * FROM `table_client` WHERE client_id = :id');
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            if ($req->execute()) {
                // si la requette s'execute correctement
                if ($req->rowCount() == 1) {
                    // on retourne l'objet user
                    $obj = $req->fetch(PDO::FETCH_OBJ);
                    $this->id = $obj->client_id;
                    $this->prenom = $obj->client_prenom;
                    $this->nom = $obj->client_name;
                    $this->email = $obj->client_email;
                    $this->password = $obj->client_password;
                    $this->credit = $obj->client_credit;
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
            $this->prenom = $args['prenom'];
            $this->email = $args['email'];
            $this->password = self::generatePassword();
            $this->credit = $args['credit'];
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
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setCredit($credit)
    {
        $this->credit = $credit;
    }
    private function generatePassword()
    {
        $str = 'azertyuiopqsdfghjklmwxcvbn123456789AZERTYUIOPQSDFGHJKLMWXCVBN';
        // on transforme la chaine de caractère en tableau
        $tab = str_split($str);
        //on genere la longueur du mmot de passe
        $long = rand(12,16);
        // on fait une boucle sur la longueur du mdp
        $mdp = '';
        for($i=0;$i<$long;$i++)
        {
            // on ajoute les caractere au hasard avec array_rand
            $str_rand = array_rand($tab);
            $mdp.=$tab[$str_rand];
        }
        return $mdp;
    }
    public function getNom()
    {
        return $this->nom;
    }
    
    public function getPrenom()
    {
        return $this->prenom;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getCredit()
    {
        return $this->credit;
    }
    public function inscrire()
    {
        global $db;
        // on va vérifier si le client n'est pas déjà dans la bdd
        $req = $db->prepare('SELECT `client_id` FROM `table_client`WHERE client_email = :email');
        $req->bindParam(':email',$this->email,PDO::PARAM_INT);
        $req->execute();
        if($req->rowCount() ==0)
        {
            // on va pouvoir les inserer notre client dans la bdd
            $req2 = $db->prepare('INSERT INTO `table_client`SET
                                client_name = :nom,
                                client_prenom = :prenom,
                                client_email = :email,
                                client_password = :password,
                                client_credit = :credit
            ');
            $req2->bindValue(':nom',$this->nom,PDO::PARAM_STR);
            $req2->bindValue(':prenom',$this->prenom,PDO::PARAM_STR);
            $req2->bindValue(':email',$this->email,PDO::PARAM_STR);
            $req2->bindValue(':passwword',self::generatePassword($this->password),PDO::PARAM_STR);
            $req2->bindValue(':credit',$this->credit,PDO::PARAM_INT);
            if($req2->execute())
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
    public function editer()
    {
        global $db;
        $req = $db->prepare('SELECT `client_id` FROM `table_client`WHERE client_email = :email AND client_id != :id');
        $req->bindParam(':id',$this->id,PDO::PARAM_INT);
        $req->bindParam(':email',$this->email,PDO::PARAM_STR);
        $req->execute();
        //si on trouve pas d'email enregistré
        if($req->rowCount() == 0)
        {
            $req2 = $db->prepare('UPDATE `table_client`SET
                                client_nom = :nom,
                                client_prenom = :prenom,
                                client_email = : email,
                                client_credit = :credit
                                WHERE client_id = :id
            ');
            $req2->bindValue(':id',$this->id,PDO::PARAM_INT);
            $req2->bindValue(':nom',$this->nom,PDO::PARAM_STR);
            $req2->bindValue(':prenom',$this->prenom,PDO::PARAM_STR);
            $req2->bindValue(':email',$this->email,PDO::PARAM_STR);
            $req2->bindValue(':credit',$this->credit,PDO::PARAM_INT);
            if($req->rowCount() == 0)
            {
                return true;
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
    // fonction pour la connection
    public static function getConnexion($email='',$password='')
    {
        global $db;
        $req = null;
        // on verifie si le mail et le mot de passe sont renseigné
        if($email && $password)
        {
            $req = $db->prepare('SELECT client_id, client_password FROM `table_client` WHERE client_email = :email AND client_password = :password');
            $req->bindParam(':password', $password, PDO::PARAM_STR);
            $req->bindParam(':email', $email, PDO::PARAM_STR);
        }
        // on verifie avec les cookies
        elseif(!empty($_COOKIE['id']) && !empty($_COOKIE['password']))
        {
            $req = $db->prepare('SELECT client_id, client_password FROM `table_client` WHERE client_id = :id AND client_password = :password');
            $req->bindParam(':id', $_COOKIE['id'], PDO::PARAM_INT);
            $req->bindParam(':password', $_COOKIE['password'], PDO::PARAM_STR);
        }
        if(isset($req)  && $req->execute())
        {
            if($req->rowCount() == 1) 
            {
                $obj = $req->fetch(PDO::FETCH_OBJ);
                $_SESSION['connect'] = 1;
                setcookie('id', $obj->client_id, (time()+86400));
                setcookie('password', $obj->client_password, (time()+86400));
                return true;
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
    
   
}
?>