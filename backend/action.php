<?php
require_once('../config.php');
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
}
?>