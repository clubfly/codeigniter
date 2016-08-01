<?php
/* Smarty version 3.1.29, created on 2016-07-29 16:47:51
  from "/opt/home/views/templates/prod_list.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_579b18378c1345_25113034',
  'file_dependency' => 
  array (
    '051c90981e3cbed22fcfbb3e6e6368c93072f980' => 
    array (
      0 => '/opt/home/views/templates/prod_list.tpl',
      1 => 1469777254,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_579b18378c1345_25113034 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['store_header']->value;?>

<div class="content_wrap">
  <div class="breadcrumb">
    <h1><?php echo $_smarty_tpl->tpl_vars['search_title']->value;?>
</h1>
  </div>
  <div class="prod_list_wrap">
    <?php if (!empty($_smarty_tpl->tpl_vars['search_list']->value)) {?>
    <?php
$_from = $_smarty_tpl->tpl_vars['search_list']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_v1_0_saved_item = isset($_smarty_tpl->tpl_vars['v1']) ? $_smarty_tpl->tpl_vars['v1'] : false;
$__foreach_v1_0_saved_key = isset($_smarty_tpl->tpl_vars['k1']) ? $_smarty_tpl->tpl_vars['k1'] : false;
$_smarty_tpl->tpl_vars['v1'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['k1'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['v1']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['k1']->value => $_smarty_tpl->tpl_vars['v1']->value) {
$_smarty_tpl->tpl_vars['v1']->_loop = true;
$__foreach_v1_0_saved_local_item = $_smarty_tpl->tpl_vars['v1'];
?>
    <div class="prod_list_box">
     <a href="<?php echo $_smarty_tpl->tpl_vars['prod_url']->value;
echo $_smarty_tpl->tpl_vars['v1']->value['prod_id'];?>
">
        <div class="list_photo">
          <img src="<?php echo $_smarty_tpl->tpl_vars['prod_img_path']->value;?>
prod_<?php echo $_smarty_tpl->tpl_vars['v1']->value['store_id'];?>
_<?php echo $_smarty_tpl->tpl_vars['v1']->value['prod_id'];?>
_s<?php echo $_smarty_tpl->tpl_vars['prod_img_suffix']->value;?>
" />
        </div>
        <div class="list_data">
          <h4><?php echo $_smarty_tpl->tpl_vars['v1']->value['prod_short_name'];?>
</h4>
          <h5></h5>
          <h6>$<?php echo number_format($_smarty_tpl->tpl_vars['v1']->value['default_marketing_price']);?>
</h6>
          <div class="clear"></div>
        </div>      
      </a>
      <div class="list_icon_bar">
        <h3>$<?php echo number_format($_smarty_tpl->tpl_vars['v1']->value['default_sell_price']);?>
</h3>
        <span>
          <!--<a href="#"><img src="/images/shopping.png" width="30px" height="30px"/></a>-->
        </span>
        <span class="love">
          <!--<a href="#"><img src="/images/love.png" width="25px" height="25px" /></a>-->
        </span> 
        <div class="clear"></div>
      </div>
    </div>
    <?php
$_smarty_tpl->tpl_vars['v1'] = $__foreach_v1_0_saved_local_item;
}
if ($__foreach_v1_0_saved_item) {
$_smarty_tpl->tpl_vars['v1'] = $__foreach_v1_0_saved_item;
}
if ($__foreach_v1_0_saved_key) {
$_smarty_tpl->tpl_vars['k1'] = $__foreach_v1_0_saved_key;
}
?>
    <?php } else { ?>
    <div class="error_msg"><?php echo $_smarty_tpl->tpl_vars['error_msg_text']->value;?>
</div>
    <?php }?>
    <div class="clear"></div>
  </div>
</div>
<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

<?php }
}
