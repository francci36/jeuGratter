<?php
// si l'id est vide!!!
if(!empty($_GET['id']))
{
    header('location:index.php');
    exit;
}
require_once('config.php');
require_once('core/class.client.php');
require_once('core/class.ticket.php');
$verif_client = Client::getConnexion();
// si le client est connecté
if($verif_connect)
{
    $client = new Client($_COOKIE['id']);
    $ticket = new Ticket($_GET['id']);
    // on verifie si le client a assez de credit
    if($client->getCredit() >= $ticket->getPrix())
    {
        $nouveau_credit = $client->getCredit()-$ticket->getPrix();
        // on met à jour le credit
        $client->setCredit($nouveau_credit);
        // on update le client dans la bdd
        $client->editer();
    }
}

