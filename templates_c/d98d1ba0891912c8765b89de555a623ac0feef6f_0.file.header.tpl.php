<?php
/* Smarty version 4.3.0, created on 2023-02-10 13:31:46
  from 'C:\Users\sousadossantos\Documents\ticket\templates\header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.3.0',
  'unifunc' => 'content_63e64742850c13_32249041',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd98d1ba0891912c8765b89de555a623ac0feef6f' => 
    array (
      0 => 'C:\\Users\\sousadossantos\\Documents\\ticket\\templates\\header.tpl',
      1 => 1676035718,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_63e64742850c13_32249041 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
    <head>
        <title><?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'titrepage');?>
</title>
        <meta charset="utf-8">
        <meta name="description">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
    <header>
        <nav>
            <ul>
                <li><a href="<?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'urlaccueil');?>
"><?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'titreaccueil');?>
</a></li>
                <?php if ($_smarty_tpl->tpl_vars['connected']->value) {?>
                    <li><a href="<?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'url_categorie');?>
"><?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'titre_categorie');?>
</a></li>
                    <li><a href="<?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'url_profil');?>
"><?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'titre_profil');?>
</a></li>
                    <li><a href="<?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'url_deco');?>
"><?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'titre_deco');?>
</a></li>
                <?php } else { ?>
                    <li><a href="<?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'url_login');?>
"><?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'titre_login');?>
</a></li>
                <?php }?>  
            </ul>
        </nav>  
        <p>Crédit : <?php echo $_smarty_tpl->tpl_vars['credit']->value;?>
</p>            
    </header><?php }
}
