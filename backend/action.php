<?php
require_once('../config.php');
ini_set('display_errors', true);
switch($_GET['e'])
{
    case 'login':

        if(!empty($_POST['email']) && !empty($_POST['password']))
        {
            $verif = verifAdmin($_POST['email'],$_POST['password'],$_POST['remember']);
            // si on a un utilisateur
            if($verif)
            {
                header('location:index.php');
                exit;
            }
            else
            {
                // si l'utilisateur n'est pas trouvé
                $message = 'login et / ou mot de passe incorrect';
            }
        }
        else
        {
            // si mail et mot de passe vide
            $message = 'veuillez renseigner un email et un mot de passe';
        }
        header('location:login.php?msg='.urlencode($message));

        break;

        case 'printuser';

            // on vérifie que l'idi de l'user est bien passé
            if(!empty($_GET['userid']))
            {
                $req = $db->prepare('SELECT * FROM `table_client` WHERE client_id = :id');
                $req->bindParam(':id',$_GET['userid'],PDO::PARAM_INT);
                $req->execute();
                // on verifie si on a bien un utilisateur de retourné
                if($req->rowCount()==1)
                {
                    $user= $req->fetch(PDO::FETCH_OBJ);
                    echo json_encode($user);
                }
            }

        break;

        case 'ajoutUser':
            if(!verifAdmin()) exit;
    
            if(!empty($_POST['email']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['password']) &&!empty($_POST['credit']))
            {
                $verif = $db->prepare('SELECT client_id FROM `table_client` WHERE client_email = :email');
                $verif->bindParam(':email',$_POST['email'],PDO::PARAM_STR);
                $verif->execute();
                // on verifie si la requette nouqs retourne aucaun résultatat
                if($verif->rowCount() == 0)
                {
                    // si pas d'user on va l'enresgistrer
                    $user_rec = $db->prepare('INSERT INTO `table_client` SET 
                    client_name = :nom,
                    client_prenom = :prenom,
                    client_email = :email,
                    client_password = :password,
                    client_credit = :credit
                    
                    ');
                    $user_rec->bindValue(':nom',$_POST['nom'],PDO::PARAM_STR);
                    $user_rec->bindValue(':prenom',$_POST['prenom'],PDO::PARAM_STR);
                    $user_rec->bindValue(':email',$_POST['email'],PDO::PARAM_STR);
                    $user_rec->bindValue(':password',sha1(md5($_POST['password'])),PDO::PARAM_STR);
                    $user_rec->bindValue(':credit',$_POST['credit'],PDO::PARAM_INT);
                    if($user_rec->execute())
                    {
                        $message = "utilisateur enregistré avec succès";
                    }
                    else
                    {
                        $_SESSION['form_utilisateur'] = serialize($_POST);
                        $message = "erreur lors de la création";
                    }
                }
                else
                {
                    $_SESSION['form_utilisateur'] = serialize($_POST);
                    $message = 'cette adresse email est déjà enregistré';
                }
                header('location:utilisateurs.php?message='.urlencode($message));
            }
            else
            {
                $_SESSION['form_utilisateur'] = serialize($_POST);
                $message = 'veuillez remplir tous les champs';
            }
            header('location:utilisateurs.php?message='.urlencode($message));
            exit;

            break;

            case 'editUser':
                if(!verifAdmin()) exit;

                // si on a bien un id qui est passé
                if(!empty($_GET['id']))
                {
                        if(!empty($_POST['email']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['credit']))
                        {
                        // on vérifie que l'email n'appartient pas à un autre utilisateur
                        $verif = $db->prepare('SELECT client_id FROM `table_client` WHERE client_email = :email AND client_id != :id');
                        $verif->bindParam(':email',$_POST['email'],PDO::PARAM_STR);
                        $verif->bindParam(':id',$_GET['id'],PDO::PARAM_INT);
                        $verif->execute();
                        // si jamais on a pas d'utilisateur avec cette adresse email
                        if($verif->rowCount() == 0)
                        {
                            $user_up = $db->prepare('UPDATE `table_client` SET
                                                            client_name = :nom,
                                                            client_prenom = :prenom,
                                                            client_email = :email,
                                                            client_credit = :credit
                                                            WHERE client_id = :id
                            
                            ');
                            $user_up->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
                            $user_up->bindValue(':nom',$_POST['nom'],PDO::PARAM_STR);
                            $user_up->bindValue(':prenom',$_POST['prenom'],PDO::PARAM_STR);
                            $user_up->bindValue(':email',$_POST['email'],PDO::PARAM_STR);
                            $user_up->bindValue(':credit',$_POST['credit'],PDO::PARAM_INT);
                            if($user_up->execute())
                            {
                                $message = 'utilisateur édité avec succès';
                            }
                            else
                            {
                                $_SESSION['form_utilisateur'] = serialize($_POST);
                                $message = 'impossible de modifier utilisateur';
                            }
                            // si le mot de passe a été modifié
                            if(!empty($_POST['password']))
                            {
                                $pass_up = $db->prepare('UPDATE `table_client` SET  client_password= :password WHERE client_id != :id');
                                $pass_up->bindParam(':id',$_GET['id'],PDO::PARAM_INT);
                                $pass_up->bindValue(':password',sha1(md5($_POST['password'])),PDO::PARAM_STR);
                                if($pass_up->execute())
                                {
                                    $message.= '<br/>Mot de passe modifié avec succès';
                                }
                                else
                                {
                                    $_SESSION['form_utilisateur'] = serialize($_POST);
                                    $message.= '<br/>erreur lors de l\'édition du mot de passe';
                                }
                            }
                            
                        }
                        else
                        {
                            $_SESSION['form_utilisateur'] = serialize($_POST);
                            $message.= 'email déjà enregistré';
                        }
                     }
                     else
                     {
                        $_SESSION['form_utilisateur'] = serialize($_POST);
                        $message.= 'vous devez remplir l\'ensemble des champs';

                     }
                }
                else
                {
                    $message = "tu n'as pas le droit d'être ici !!!";

                }
                header('location:utilisateurs.php?message='.urlencode($message));
                exit;
            
                break;
                case 'deluser':
                    if(!verifAdmin()) exit;
                    if(!empty($_GET['id']))
                    {
                        $del_user = $db->prepare('DELETE FROM `table_client` WHERE client_id = :id ');
                        $del_user->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
                        if($del_user->execute())
                        {
                            $message = 'utilisteur supprimé avec succès';
                        }
                        else
                        {
                            $message = 'erreur lors dela suppression de l\'utilisateur';
                        }
                    }
                    else
                    {
                        $message = "tu n'as rien à faire ici";
                    }
                    header('location:utilisateurs.php?message='.urlencode($message));
                    exit;

                    break;
                
                        case 'printcategorie':

                            if(!verifAdmin())exit;
                            if(!empty($_GET['id']))
                            {
                                $cat = $db->prepare('SELECT  * FROM `table_categorie` WHERE categorie_id = :id');
                                $cat->bindParam(':id',$_GET['id'],PDO::PARAM_INT);
                                $cat->execute();
                                // on vérie si une catégorie est retourné
                                if($cat->rowCount() == 1)
                                {
                                    $categorie = $cat->fetch(PDO::FETCH_OBJ);
                                    echo json_encode($categorie);
                                }
                            }

                            break;

                        case 'ajoutcategorie':

                            if(!verifAdmin())exit;
                            if(!empty($_POST['nom']))
                            {
                                $cat_add =$db->prepare('INSERT INTO `table_categorie` SET categorie_name = :nom');
                                $cat_add->bindValue(':nom',$_POST['nom'],PDO::PARAM_STR);
                                    if($cat_add->execute())
                                    {
                                        $message = 'catégorie ajoutée avec succès';
                                    }
                                    else
                                    {
                                        $_SESSION['form_categorie'] = serialize($_POST);
                                        $message = 'une erreur est survenu lors de l\'ajout';
                                    }  
                            }
                            else
                            {
                                $message = 'vous devez indiquer le nom de la categorie';
                            }
                            header('location:categories.php?message='.urlencode($message));
                            exit;
                            break;
                            

                        case 'editcategorie':
                            
                            if(!verifAdmin()) exit;
                            if(!empty($_GET['id']))
                            {
                            if(!empty($_POST['nom']))
                                {
                                    $cat_edit =$db->prepare('UPDATE `table_categorie` SET categorie_name = :nom WHERE categorie_id = :id');
                                    $cat_edit->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
                                    $cat_edit->bindValue(':nom',$_POST['nom'],PDO::PARAM_STR);
                                    if($cat_edit->execute())
                                    {
                                        $message = 'catégorie modifié avec succès';
                                    }
                                    else
                                    {
                                            $_SESSION['form_categorie'] = serialize($_POST);
                                            $message = 'une erreur est survenu lors de l\'edition';
                                    }
                                    
                                    
                                }
                                else
                                {
                                            $message = 'veuillez indiquer une categorie';
                                }
                               
                            }
                            else  
                            {
                                $message = "t'as rien à faire ici";
                            }
                                
                                header('location:categories.php?message='.urlencode($message));
                                exit;

                                break;

                        case 'delcategorie':

                            if(!verifAdmin())exit;
                            if(!empty($_GET['id']))
                            {
                                $cat_del = $db->prepare('DELETE FROM `table_categorie` WHERE categorie_id = :id ');
                                $cat_del->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
                                if($cat_del->execute())
                                {
                                    $message = 'categorie supprimé avec succès';
                                }
                                else
                                {
                                    $message = 'erreur de suppression';
                                }
                            }
                            else
                            {
                                $message = 'tu n\'as rien à faire ici';
                            }
                            
                            header('location:categories.php?message='.urlencode($message));

                            break;
                            exit;

                            case 'ajoutticket':

                                if(!verifAdmin())exit;
                                if(!empty($_POST['categorie']) && !empty($_POST['nom'])  && !empty($_POST['prix'])  && !empty($_POST['nombre']))
                                {
                                    $ticket_add = $db->prepare('INSERT INTO `table_ticket` SET
                                                                categorie_id = :id,
                                                                ticket_name = :nom,
                                                                prix_ticket = :prix,
                                                                nb_ticket = :nombre
                                                                ');
                                     $ticket_add->bindValue(':id',$_POST['categorie'],PDO::PARAM_INT);
                                    $ticket_add->bindValue(':nom',$_POST['nom'],PDO::PARAM_STR);
                                     $ticket_add->bindValue(':prix',$_POST['prix'],PDO::PARAM_INT);
                                     $ticket_add->bindValue(':nombre',$_POST['nombre'],PDO::PARAM_INT);
                                    if($ticket_add->execute())
                                    {
                                        $id_ticket = $db->lastInsertId();
                                        // on boucle les parties youpi
                                        $k = 0; // k c'est la clés
                                        foreach($_POST['number'] as $nb)
                                        {
                                            // on boucle sur la valeur  de number
                                            for($i=0;$i<=$_POST['number'][$k];$i++)
                                            {
                                               // echo $_POST['valeur_partie'][$k];
                                                $partie_add = $db->prepare('INSERT INTO `table_partie` SET
                                                partie_id = :id,
                                                valeur_partie = :valeur,
                                                partie_date = CURDATE(),
                                                partie_etat = "0"
                                                ');
                                                 $partie_add->bindValue(':id',$id_ticket,PDO::PARAM_INT);
                                                 $partie_add->bindValue(':valeur',$_POST['valeur'][$k],PDO::PARAM_INT);
                                                $partie_add->execute();
                                            }
                                            $k++;
                                        }
                                        $message = 'ticket ajouté avec succès';
                                    }
                                    else
                                    {
                                        $message = 'erreur avec le ticket';
                                        $_SESSION['form_ticket'] = serialize($_POST);
                                    }
                                                                
                                }
                                else
                                {
                                    
                                    $message = "vous devez saisir l'ensemble des champs";
                                    $_SESSION['form_ticket'] = serialize($_POST);
                                }
                                header('location:tickets.php?='.urlencode($message));


                                break;

                                exit;

                                case 'delticket':
                                    if(!verifAdmin()) exit;
                                    if(!empty($_GET['id']))
                                    {
                                        $del_partie = $db->prepare('DELETE FROM `table_partie` WHERE ticket_id = :id ');
                                        $del_partie->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
                                        $del_partie->execute();
                                        $del_ticket = $db->prepare('DELETE FROM `table_ticket` WHERE partie_id = :id ');
                                        $del_ticket->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
                                        if($del_ticket->execute())
                                        
                                        {
                                            $message = 'ticket supprimé avec succès';
                                        }
                                        else
                                        {
                                            $message = 'erreur lors dela suppression du ticket';
                                        }
                                    }
                                    else
                                    {
                                        $message = "tu n'as rien à faire ici";
                                    }
                                    header('location:tickets.php?message='.urlencode($message));
                                    exit;
                
                                    break;
}

        

?>