<?php
/* Smarty version 4.3.0, created on 2023-02-10 10:18:33
  from 'C:\Users\sousadossantos\Documents\jeuTickets\templates\login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63e619f9263a04_54839363',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3b9528e582ab55d499c04cac417a44a52d2f1665' => 
    array (
      0 => 'C:\\Users\\sousadossantos\\Documents\\jeuTickets\\templates\\login.tpl',
      1 => 1675941516,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
),false)) {
function content_63e619f9263a04_54839363 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->configLoad->_loadConfigFile($_smarty_tpl, "config.conf", null, 0);
?>

<?php $_smarty_tpl->_subTemplateRender("file:header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>'header'), 0, false);
?>
<section class="formulaire">

    <?php if ($_smarty_tpl->tpl_vars['message']->value) {?>
        <div class="erreur"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</div>
        
    <?php }?>
    <form name="connexion" method="post" action="action.php?e=connexion">
        <div class="form-group">
            <label for="login">
            <input type="email" name="login" id="login" placeholder="">
        </div>
            <div class="form-group">
            <label for="password">
        <input type="password" name="password" id="password" placeholder="">
        </div>
            <div class="form-group">
            <button type="submit" name="submit" class="submit">se connecter</button>
        </div>
    </form>
</section>
<?php $_smarty_tpl->_subTemplateRender("file:footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('title'=>'footer'), 0, false);
}
}
