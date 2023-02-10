<?php
require_once('config.php');
require_once('core/class.client.php');
require_once('core/class.ticket.php');
require_once('core/Smarty.class.php');
$tickets = Ticket::liste();
// on verifie si le client est connecté
$verif_client = Client::getConnexion();
//si le client n'est connecté
if(!$verif_client)
{
    header('location:login.php');
    exit;
}
$client = new Client($_COOKIE['id']);
//on recupere la liste des tickets
$tickets = Ticket::liste();
$tpl = new Smarty;
$tpl->assign('connected',true);
$tpl->assign('credit',$client->getCredit());
$tpl->assign('ticket',$tickets);
$tpl->display('index.tpl');
?>