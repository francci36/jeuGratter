<?php
// Si l'ID est vide !!!
if(empty($_GET['id']))
{
    header('location:index.php');
    exit;
}
require_once('config.php');
require_once('core/class.client.php');
require_once('core/class.ticket.php');
$verif_connect = Client::getConnexion();
// Si le client est connecté
if($verif_connect)
{
    $client = new Client($_COOKIE['id']);
    $ticket = new Ticket($_GET['id']);
    // On vérifie si le client a assez de crédit !!!
    if($client->getCredit() >= $ticket->getPrix())
    {
        // On met à jour le crédit du client
        $nouveau_credit = $client->getCredit()-$ticket->getPrix();
        // On met à jour le crédit
        $client->setCredit($nouveau_credit);
        // On update le client dans la BDD
        $client->editer();
    }
}
?>