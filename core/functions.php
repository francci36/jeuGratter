<?php
function verifAdmin($email='',$password='',$remember='')
{
    // on verifie si on est passé par post
    global $db;
    if(!empty($email) && !empty($password))
    {
        $verif = $db->prepare('SELECT * FROM `table_admin` WHERE admin_email = :email AND admin_password = :password');
        $verif->bindParam(':email',$email,PDO::PARAM_STR);
        $verif->bindParam(':password',sha1(md5($password)),PDO::PARAM_STR);

        }
        // si jamais on verifie les cookies
        else
        {
            $verif = $db->prepare('SELECT * FROM `table_admin` WHERE admin_id = :id AND admin_password = :password');
            $verif->bindparam(':id',$_COOKIE['id'],PDO::PARAM_STR);
            $verif->bindParam(':password',$_COOKIE['password'],PDO::PARAM_STR);
    
        }
        $verif->execute();
        // on verifie qu'un utilisateur est bien retourné
        if($verif->rowCount() == 1)
        {
            $admin = $verif->fetch(PDO::FETCH_OBJ);
            if($remember == 1)
            {
                $time = (time()+86400);
            }
            else
        {
            $time = (time()+3600);
        }
        setcookie('id',$admin->admin_id,$time);
        setcookie('password',$admin->admin_password,$time);
        $_SESSION['admin'] = 1;
        return true;
        }
        else
        {
            return false;
        }  
}
function generateToken()
{
    // chaine de caracthère pour le token
    $ch = 'azertyuiopqsdfghjklmwxcvbn0123456789AZERTYUIOPQSDFGHJKLMWXCVBN';
    // on transforme la chaine de caractere en tableau str_split()
    $ch = str_split($ch);
    // on definit une longueur
    $lg = rand(17,25);
    // on initialise le token
    $token = '';
    // on boucle la valeur de 1g
    for($i=0;$i<=$lg;$i++)
    {
        // on selectionne une clés du tableau entre 0 et le nome d'occurrence de $ ch
        $c = rand(0,count($ch)-1);
        // on retourne le caractère
        $token.=$ch[$c];
    }
    return $token;
}
/**
 * This file is part of the Smarty package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/**
 * Registers some helper/polyfill functions.
 */

 const SMARTY_HELPER_FUNCTIONS_LOADED = true;

 /**
  * Converts the first characters in $string to uppercase (A-Z) if it is an ASCII lowercase character (a-z).
  *
  * May not be required when running PHP8.2+: https://wiki.php.net/rfc/strtolower-ascii
  *
  * @param $string
  *
  * @return string
  */
 function smarty_ucfirst_ascii($string): string {
     return smarty_strtoupper_ascii(substr($string, 0, 1)) . substr($string, 1);
 }
 
 /**
  * Converts all uppercase ASCII characters (A-Z) in $string to lowercase (a-z).
  *
  * May not be required when running PHP8.2+: https://wiki.php.net/rfc/strtolower-ascii
  *
  * @param $string
  *
  * @return string
  */
 function smarty_strtolower_ascii($string): string {
     return strtr($string, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
 }
 
 /**
  * Converts all lowercase ASCII characters (a-z) in $string to uppercase (A-Z).
  *
  * May not be required when running PHP8.2+: https://wiki.php.net/rfc/strtolower-ascii
  *
  * @param $string
  *
  * @return string
  */
 function smarty_strtoupper_ascii($string): string {
     return strtr($string, 'abcdefghijklmnopqrstuvwxyz', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
 }
?>