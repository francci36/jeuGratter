
<?php 
ini_set('display_errors',true);
require_once('config.php');
require_once('core/Smarty.class.php');
require_once('core/class.client.php');

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
$tpl->assign('connected',false);
$tpl->assign('credit',null);
$tpl->display('login.tpl');
?>