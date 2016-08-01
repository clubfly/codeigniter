<?php
/* Smarty version 3.1.29, created on 2016-07-30 11:55:30
  from "/opt/home/views/templates/common/store_header.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_579c253296b125_44908248',
  'file_dependency' => 
  array (
    'b805ea2a76b6d4613c00e4eee278c394e7a0895e' => 
    array (
      0 => '/opt/home/views/templates/common/store_header.tpl',
      1 => 1469850370,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_579c253296b125_44908248 ($_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>mobile website</title>
    <?php if (!empty($_smarty_tpl->tpl_vars['css']->value)) {?>
    <?php
$_from = $_smarty_tpl->tpl_vars['css']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_val_0_saved_item = isset($_smarty_tpl->tpl_vars['val']) ? $_smarty_tpl->tpl_vars['val'] : false;
$_smarty_tpl->tpl_vars['val'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['val']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
$__foreach_val_0_saved_local_item = $_smarty_tpl->tpl_vars['val'];
?>
    <link rel="stylesheet" type="text/css" href="/css/<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
">
    <?php
$_smarty_tpl->tpl_vars['val'] = $__foreach_val_0_saved_local_item;
}
if ($__foreach_val_0_saved_item) {
$_smarty_tpl->tpl_vars['val'] = $__foreach_val_0_saved_item;
}
?>
    <?php }?>
    <?php if (!empty($_smarty_tpl->tpl_vars['js']->value)) {?>
    <?php
$_from = $_smarty_tpl->tpl_vars['js']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_val_1_saved_item = isset($_smarty_tpl->tpl_vars['val']) ? $_smarty_tpl->tpl_vars['val'] : false;
$_smarty_tpl->tpl_vars['val'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['val']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
$__foreach_val_1_saved_local_item = $_smarty_tpl->tpl_vars['val'];
?>
    <?php echo '<script'; ?>
 type="text/javascript" src="/js/<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
"><?php echo '</script'; ?>
>
    <?php
$_smarty_tpl->tpl_vars['val'] = $__foreach_val_1_saved_local_item;
}
if ($__foreach_val_1_saved_item) {
$_smarty_tpl->tpl_vars['val'] = $__foreach_val_1_saved_item;
}
?>
    <?php }?>
    <?php if (!empty($_smarty_tpl->tpl_vars['js_thirdparty']->value)) {?>
    <?php
$_from = $_smarty_tpl->tpl_vars['js_thirdparty']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_val_2_saved_item = isset($_smarty_tpl->tpl_vars['val']) ? $_smarty_tpl->tpl_vars['val'] : false;
$_smarty_tpl->tpl_vars['val'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['val']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
$__foreach_val_2_saved_local_item = $_smarty_tpl->tpl_vars['val'];
?>
    <?php echo '<script'; ?>
 type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
"><?php echo '</script'; ?>
>
    <?php
$_smarty_tpl->tpl_vars['val'] = $__foreach_val_2_saved_local_item;
}
if ($__foreach_val_2_saved_item) {
$_smarty_tpl->tpl_vars['val'] = $__foreach_val_2_saved_item;
}
?>
    <?php }?>
  </head>
  <body>
    <div class="main_wrap">
      <div class="gotop_icon">
        <a href="<?php echo $_smarty_tpl->tpl_vars['void_url']->value;?>
">
          <img src="/images/gotop.png" width="40" height="40" />
        </a>
      </div>
      <div class="header_wrap">   
        <div class="hamburger_icon">
          <span class="icon_bar"></span>
          <span class="icon_bar"></span>       
          <span class="icon_bar"></span>
        </div>
        <div class="header_mid">
          <div class="header_logo">
            NEWART
          </div>
        </div>
        <div class="search_icon">
          <a href="<?php echo $_smarty_tpl->tpl_vars['void_url']->value;?>
">
            <img src="/images/search.png" width="25px" height="25px"/>
            <p><?php echo $_smarty_tpl->tpl_vars['search_text']->value;?>
</p>
            <div class="clear"></div>
          </a>
        </div>
        <div class="search_wrap">
          <div class="search_bar">
            <input type="text" placeholder="<?php echo $_smarty_tpl->tpl_vars['search_holder']->value;?>
" id="search_value" />
            <div class="search_btn"><?php echo $_smarty_tpl->tpl_vars['search_text']->value;?>
</div>
            <div class="clear"></div>
          </div>
        </div>
        <div class="clear"></div>
        <div class="hamburger_list_wrap">
          <!--<div class="hamburger_login_bar">
            <ul>
              <li class="login"><a href="<?php echo $_smarty_tpl->tpl_vars['void_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['login_text']->value;?>
</a></li>
              <li class="home"><a href="<?php echo $_smarty_tpl->tpl_vars['void_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['index_text']->value;?>
</a></li>
              <div class="clear"></div>
            </ul>
          </div>-->
          <div class="hamburger_type_item">
            <?php if (!empty($_smarty_tpl->tpl_vars['categoryList']->value)) {?>
              <?php
$_from = $_smarty_tpl->tpl_vars['categoryList']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_v1_3_saved_item = isset($_smarty_tpl->tpl_vars['v1']) ? $_smarty_tpl->tpl_vars['v1'] : false;
$__foreach_v1_3_saved_key = isset($_smarty_tpl->tpl_vars['k1']) ? $_smarty_tpl->tpl_vars['k1'] : false;
$_smarty_tpl->tpl_vars['v1'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['k1'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['v1']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['k1']->value => $_smarty_tpl->tpl_vars['v1']->value) {
$_smarty_tpl->tpl_vars['v1']->_loop = true;
$__foreach_v1_3_saved_local_item = $_smarty_tpl->tpl_vars['v1'];
?>
            <h3>
              <?php echo $_smarty_tpl->tpl_vars['v1']->value[0]["category_name"];?>

            </h3>
                <?php if (!empty($_smarty_tpl->tpl_vars['v1']->value)) {?>
            <div>
                  <?php
$_from = $_smarty_tpl->tpl_vars['v1']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_v2_4_saved_item = isset($_smarty_tpl->tpl_vars['v2']) ? $_smarty_tpl->tpl_vars['v2'] : false;
$__foreach_v2_4_saved_key = isset($_smarty_tpl->tpl_vars['k2']) ? $_smarty_tpl->tpl_vars['k2'] : false;
$_smarty_tpl->tpl_vars['v2'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['k2'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['v2']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['k2']->value => $_smarty_tpl->tpl_vars['v2']->value) {
$_smarty_tpl->tpl_vars['v2']->_loop = true;
$__foreach_v2_4_saved_local_item = $_smarty_tpl->tpl_vars['v2'];
?>
              <p><a href="<?php echo $_smarty_tpl->tpl_vars['category_url']->value;
echo $_smarty_tpl->tpl_vars['v2']->value['category_sub_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v2']->value['sub_category_name'];?>
</a></p>
                  <?php
$_smarty_tpl->tpl_vars['v2'] = $__foreach_v2_4_saved_local_item;
}
if ($__foreach_v2_4_saved_item) {
$_smarty_tpl->tpl_vars['v2'] = $__foreach_v2_4_saved_item;
}
if ($__foreach_v2_4_saved_key) {
$_smarty_tpl->tpl_vars['k2'] = $__foreach_v2_4_saved_key;
}
?>
            </div>
                <?php }?>
              <?php
$_smarty_tpl->tpl_vars['v1'] = $__foreach_v1_3_saved_local_item;
}
if ($__foreach_v1_3_saved_item) {
$_smarty_tpl->tpl_vars['v1'] = $__foreach_v1_3_saved_item;
}
if ($__foreach_v1_3_saved_key) {
$_smarty_tpl->tpl_vars['k1'] = $__foreach_v1_3_saved_key;
}
?>
            <?php }?>
          </div>
        </div>
        <div class="buy_dialog_wrap"></div>
      </div>
<?php }
}
