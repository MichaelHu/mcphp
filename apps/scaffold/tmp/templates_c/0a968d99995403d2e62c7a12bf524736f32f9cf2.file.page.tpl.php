<?php /* Smarty version Smarty-3.0.7, created on 2013-06-05 14:40:55
         compiled from "/Users/hudamin/projects/git/mcphp/apps/scaffold//tpl/scaffold//index/page.tpl" */ ?>
<?php /*%%SmartyHeaderCode:189023529251aedd770a63c9-04316380%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0a968d99995403d2e62c7a12bf524736f32f9cf2' => 
    array (
      0 => '/Users/hudamin/projects/git/mcphp/apps/scaffold//tpl/scaffold//index/page.tpl',
      1 => 1370411956,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '189023529251aedd770a63c9-04316380',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>MCPHP -- a light-weight php framework</title>
</head>
<body>

<h2><?php echo $_smarty_tpl->getVariable('say')->value;?>
</h2>

<h3>1. common config:</h3>
<?php if (!empty($_smarty_tpl->getVariable('common_config',null,true,false)->value)){?>
<ul>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('common_config')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
    <li><b><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
: </b><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</li> 
<?php }} ?>
</ul>
<?php }?>

<h3>2. config: </h3>
<?php if (!empty($_smarty_tpl->getVariable('config',null,true,false)->value)){?>
<ul>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('config')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
    <li>
        <h3><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</h3>
        <ol>
    <?php  $_smarty_tpl->tpl_vars['item1'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['key1'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item1']->key => $_smarty_tpl->tpl_vars['item1']->value){
 $_smarty_tpl->tpl_vars['key1']->value = $_smarty_tpl->tpl_vars['item1']->key;
?>
    <li><b><?php echo $_smarty_tpl->tpl_vars['key1']->value;?>
: </b><?php echo $_smarty_tpl->tpl_vars['item1']->value;?>
</li> 
    <?php }} ?>
        </ol>
    </li>
<?php }} ?>
</ul>
<?php }?>

</body>
</html>


