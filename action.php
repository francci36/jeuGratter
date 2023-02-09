<?php
require_once('config.php');
require_once('core/class.client.php');
switch($_GET['e'])
{
    case 'connexion':
        if(!empty($_POST['login']) && !empty($_POST['password']))
        {
            $verif_connect = Client::getConnexion($_POST['login'],$_POST['password']);
            // si verif nous retourne un client
            if($verif_connect)
            {
                header('location:index.php');
                exit;
            }
            else
            {
                //on redirige sur la page index
                $message = 'login et /ou mot de passe incorrect';
                header('location:login.php?message='.urlencode($message));
                exit;
            }
        }
        else
        {
            $message = 'veuillez renseigner un login et un mot de passe';
            header('location:login.php?message='.urlencode($message));
            exit;
        }
    break;

    case 'inscription':

        if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) )
        {
            $client = new Client('',array('nom' => $_POST['nom'],'prenom' => $_POST['prenom'],'email' => $_POST['email'],'credit' => 200));
            if($client)
            {
                // on envoie un mail au client
                mail($client->email,'inscription','voici vos identifiants: email:'.$client->email.'mot de passe:'.$client->password);
                $connect = $client->getConnexion($client->email,$client->password);
                if($connect)
                {
                    header(('location:index.php'));
                    exit;
                }
                else
                {
                    $message = "login et/ ou mot de passe incorrect";
                    header('location:login.php?message='.urlencode($message));
                    exit;
                }
            }
            else
            {
                $message = "impossible de créér le client";
            }
        }
        else
        {
            // on va renvoyer les informations du formulaire en sesssion
            $_SESSION['inscription'] = serialize($_POST);
            if(empty($_POST['nom'])) $message = "veuillez renseigner votre nom";
            elseif(empty($_POST['prenom'])) $message = "veuillez renseigner votre prenom";
            elseif(empty($_POST['email'])) $message = "veuillez renseigner votre email";
            header('location:inscription.php?message='.urlencode($message));
        }

        break;
}
