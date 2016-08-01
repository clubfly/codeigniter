<?php
/* Smarty version 3.1.29, created on 2016-07-30 18:40:43
  from "/opt/home/views/templates/prod_models.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_579c842bd25488_08575934',
  'file_dependency' => 
  array (
    'e6f59b091ff656d0f64eb2254fef7dc80964fb68' => 
    array (
      0 => '/opt/home/views/templates/prod_models.tpl',
      1 => 1469854728,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_579c842bd25488_08575934 ($_smarty_tpl) {
echo '<script'; ?>
 src="/js/prod_models_v1.js"><?php echo '</script'; ?>
>
  <div class="buy_dialog_photo">
    <img src="<?php echo $_smarty_tpl->tpl_vars['prod_img_path']->value;?>
prod_<?php echo $_smarty_tpl->tpl_vars['search_list']->value["prod_info"]["store_id"];?>
_<?php echo $_smarty_tpl->tpl_vars['search_list']->value["prod_info"]["prod_id"];?>
_s<?php echo $_smarty_tpl->tpl_vars['prod_img_suffix']->value;?>
" />
  </div>
  <div class="buy_dialog_title">
    <h4><?php echo $_smarty_tpl->tpl_vars['search_list']->value["prod_info"]["prod_name"];?>
</h4>
  </div>
  <div class="buy_dialog_price">
    <h5><?php echo $_smarty_tpl->tpl_vars['special_price_text']->value;?>
</h5>
    <h2>$<?php echo number_format($_smarty_tpl->tpl_vars['search_list']->value["prod_info"]["default_sell_price"]);?>
</h2>
    <div class="clear"></div>
  </div>  
  <div class="buy_form">
    <div class="buy_form_item">
      <input type="hidden" name="prod_id" value="<?php echo $_smarty_tpl->tpl_vars['search_list']->value["prod_info"]["prod_id"];?>
" />
      <label for="prod_size"><?php echo $_smarty_tpl->tpl_vars['models_text']->value;?>
</label>
      <?php if (!empty($_smarty_tpl->tpl_vars['search_list']->value["prod_model"])) {?>
      <select name="prod_size" class="prod_choose">
        <?php
$_from = $_smarty_tpl->tpl_vars['search_list']->value["prod_model"];
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
        <option value="<?php echo $_smarty_tpl->tpl_vars['v1']->value['sn'];?>
"><?php echo $_smarty_tpl->tpl_vars['v1']->value['models_names'];?>
</option>
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
      </select>
      <?php }?>
    </div>
    <div class="buy_line"></div>
    <div class="buy_form_item">
      <label for="prod_choose"><?php echo $_smarty_tpl->tpl_vars['qty_text']->value;?>
</label>
      <select name="prod_qty" class="prod_choose">
        <?php
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['value']->step = 1;$_smarty_tpl->tpl_vars['value']->total = (int) ceil(($_smarty_tpl->tpl_vars['value']->step > 0 ? 20+1 - (1) : 1-(20)+1)/abs($_smarty_tpl->tpl_vars['value']->step));
if ($_smarty_tpl->tpl_vars['value']->total > 0) {
for ($_smarty_tpl->tpl_vars['value']->value = 1, $_smarty_tpl->tpl_vars['value']->iteration = 1;$_smarty_tpl->tpl_vars['value']->iteration <= $_smarty_tpl->tpl_vars['value']->total;$_smarty_tpl->tpl_vars['value']->value += $_smarty_tpl->tpl_vars['value']->step, $_smarty_tpl->tpl_vars['value']->iteration++) {
$_smarty_tpl->tpl_vars['value']->first = $_smarty_tpl->tpl_vars['value']->iteration == 1;$_smarty_tpl->tpl_vars['value']->last = $_smarty_tpl->tpl_vars['value']->iteration == $_smarty_tpl->tpl_vars['value']->total;?>
        <option value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</option>
        <?php }
}
?>

      </select>
    </div>
    <div class="buy_line"></div>
    <div class="buy_form_item">
      <label for="prod_transport"><?php echo $_smarty_tpl->tpl_vars['shipping_text']->value;?>
</label>
      <select name="prod_transport" class="prod_choose">
        <option>宅配</option>
      </select>
    </div>
    <div class="buy_line"></div>
    <div class="buy_btn_wrap">
      <div class="continue_buy_btn"><a href="<?php echo $_smarty_tpl->tpl_vars['void_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['shop_again_text']->value;?>
</a></div>
      <div class="go_buy_btn"><a href="<?php echo $_smarty_tpl->tpl_vars['void_url']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['checkout_text']->value;?>
</a></div>
      <div class="clear"></div>
    </div>
  </div> 
<?php }
}
