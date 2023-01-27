<?php 
$DB_HOST = 'localhost';
$DB_USER ='root';
$DB_PASSWORD = '';
$DB_NAME = 'ticket_gratter';
// cree la fonction pour se connecter a la base de données
function pdo_connect()
{
    global $DB_HOST;
    global $DB_USER;
    global $DB_PASSWORD;
    global $DB_NAME;
    try{
        return new PDO('mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8',$DB_USER,$DB_PASSWORD);
    }catch (PDOException $exception) {
        exit('impossible de se connecter a la BDD');
    }
}
// on se connecte a la BDD
$db = pdo_connect();
?>