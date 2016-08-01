<?php
/* Smarty version 3.1.29, created on 2016-07-30 11:24:13
  from "/opt/home/views/templates/prod_detail.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_579c1ddd5ad486_98151446',
  'file_dependency' => 
  array (
    '327f8117fe9a2b3720168d37525c4fa080b89ec9' => 
    array (
      0 => '/opt/home/views/templates/prod_detail.tpl',
      1 => 1469849038,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_579c1ddd5ad486_98151446 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['store_header']->value;?>

<div class="content_wrap">
  <div class="breadcrumb">
    <h1></h1>
  </div>
  <section class="prod_bn slider">
    <div class="slider_bn">
      <img src="<?php echo $_smarty_tpl->tpl_vars['prod_img_path']->value;?>
prod_<?php echo $_smarty_tpl->tpl_vars['search_list']->value["prod_info"]["store_id"];?>
_<?php echo $_smarty_tpl->tpl_vars['search_list']->value["prod_info"]["prod_id"];?>
_s<?php echo $_smarty_tpl->tpl_vars['prod_img_suffix']->value;?>
" />
    </div>
  </section>
  <div class="prod_price">
    <h4>$<?php echo number_format($_smarty_tpl->tpl_vars['search_list']->value["prod_info"]["default_sell_price"]);?>
</h4>
    <h6>$<?php echo number_format($_smarty_tpl->tpl_vars['search_list']->value["prod_info"]["default_marketing_price"]);?>
</h6>
    <div class="clear"></div>
  </div>
  <div class="prod_content_title"><?php echo $_smarty_tpl->tpl_vars['search_list']->value["prod_info"]["prod_name"];?>
</div>
    <div class="prod_feature">
      <h4><?php echo $_smarty_tpl->tpl_vars['prod_intro_text']->value;?>
</h4><br />
      <h5><?php echo $_smarty_tpl->tpl_vars['search_list']->value["prod_info"]["commerce_profile"];?>
</h5>
    </div>
    <div class="prod_info_wrap">
      <h3><?php echo $_smarty_tpl->tpl_vars['prod_description_text']->value;?>
</h3>
      <div>
        <p><?php echo $_smarty_tpl->tpl_vars['search_list']->value["prod_info"]["prod_profile"];?>
</p> 
      </div>
      <h3><?php echo $_smarty_tpl->tpl_vars['prod_model_shippng_text']->value;?>
</h3>
      <div class="specification">
        <h5><?php echo $_smarty_tpl->tpl_vars['models_text']->value;?>
</h5>
        <?php if (!empty($_smarty_tpl->tpl_vars['search_list']->value["prod_model"])) {?>
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
        <h5><?php echo $_smarty_tpl->tpl_vars['v1']->value['models_names'];?>
</h5>
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
        <?php }?>
        <h5><?php echo $_smarty_tpl->tpl_vars['shippng_text']->value;?>
</h5>
        <h5></h5>         
      </div>
      <!--
      <h3 class="orange"><?php echo $_smarty_tpl->tpl_vars['you_will_like_text']->value;?>
</h3>
      <div class="might_like_wrap">
        <div class="like_box">
          <a href="#">
            <div class="like_box_photo"><img src="images/bed.jpg" /></div>
            <div class="like_box_data">
              <div class="like_box_price_bar">
                <h4>翔仔居家</h4>
                <h2>$449</h2>
                <div class="clear"></div>
              </div>
              <h5>100%超細纖維 磨毛柔軟處理 超值雙人三件床包組</h5>
            </div>
          </a>
        </div>
        <div class="clear"></div>
      </div>
      -->
    </div>
  </div>
</div>
<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

<?php }
}
