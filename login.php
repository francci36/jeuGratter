
<?php 
ini_set('display_errors',true);
require_once('config.php');
require('core/Smarty.class.php');
require('core/class.client.php');

$verif_connect = Client::getConnexion();

if($verif_connect)
{
    header('location:index.php');
    exit;
}

$tpl = new Smarty;
$tpl->debugging = true;

$message = null;

if(!empty($_GET['message']))
{
    $message = strip_tags($_GET['message']);
}

$tpl->assign('message',$message);
$tpl->display('login.tpl');
?>