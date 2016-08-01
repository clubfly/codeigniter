<?php
/* Smarty version 3.1.29, created on 2016-07-30 12:41:46
  from "/opt/home/views/templates/store_index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_579c300a5e8304_54789668',
  'file_dependency' => 
  array (
    '13d57182055276fd94a98f605f7c6e8da563558e' => 
    array (
      0 => '/opt/home/views/templates/store_index.tpl',
      1 => 1469853698,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_579c300a5e8304_54789668 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['store_header']->value;?>

<div class="content_wrap">
  <?php if (!empty($_smarty_tpl->tpl_vars['ad_block']->value[1])) {?>
  <section class="regular slider">
    <?php
$_from = $_smarty_tpl->tpl_vars['ad_block']->value[1];
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
    <div class="slider_bn">
      <?php if ($_smarty_tpl->tpl_vars['v1']->value['block_type'] == 0) {?>
      <a href="<?php echo $_smarty_tpl->tpl_vars['v1']->value['url'];?>
">
        <img src="<?php echo $_smarty_tpl->tpl_vars['commerce_path']->value;
echo $_smarty_tpl->tpl_vars['v1']->value['img_files'];?>
" />
      </a>
      <?php } else { ?>
      <a href="<?php echo $_smarty_tpl->tpl_vars['prod_url']->value;
echo $_smarty_tpl->tpl_vars['v1']->value['prod_id'];?>
">
        <img src="<?php echo $_smarty_tpl->tpl_vars['prod_img_path']->value;?>
prod_<?php echo $_smarty_tpl->tpl_vars['v1']->value['store_id'];?>
_<?php echo $_smarty_tpl->tpl_vars['v1']->value['prod_id'];?>
_s<?php echo $_smarty_tpl->tpl_vars['prod_img_suffix']->value;?>
" />
      </a>
      <?php }?>
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
  </section>
  <?php }?>
  <?php if (!empty($_smarty_tpl->tpl_vars['ad_block']->value[2])) {?>
  <div class="theme_btn_wrap">
    <?php
$_from = $_smarty_tpl->tpl_vars['ad_block']->value[2];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_v1_1_saved_item = isset($_smarty_tpl->tpl_vars['v1']) ? $_smarty_tpl->tpl_vars['v1'] : false;
$__foreach_v1_1_saved_key = isset($_smarty_tpl->tpl_vars['k1']) ? $_smarty_tpl->tpl_vars['k1'] : false;
$_smarty_tpl->tpl_vars['v1'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['k1'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['v1']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['k1']->value => $_smarty_tpl->tpl_vars['v1']->value) {
$_smarty_tpl->tpl_vars['v1']->_loop = true;
$__foreach_v1_1_saved_local_item = $_smarty_tpl->tpl_vars['v1'];
?>
    <div class="theme_btn">
      <?php if ($_smarty_tpl->tpl_vars['v1']->value['block_type'] == 0) {?>
      <a href="<?php echo $_smarty_tpl->tpl_vars['v1']->value['url'];?>
">
        <img src="<?php echo $_smarty_tpl->tpl_vars['commerce_path']->value;
echo $_smarty_tpl->tpl_vars['v1']->value['img_files'];?>
" />
      </a>
      <?php } else { ?>
      <a href="<?php echo $_smarty_tpl->tpl_vars['prod_url']->value;
echo $_smarty_tpl->tpl_vars['v1']->value['prod_id'];?>
">
        <img src="<?php echo $_smarty_tpl->tpl_vars['prod_img_path']->value;?>
prod_<?php echo $_smarty_tpl->tpl_vars['v1']->value['store_id'];?>
_<?php echo $_smarty_tpl->tpl_vars['v1']->value['prod_id'];?>
_s<?php echo $_smarty_tpl->tpl_vars['prod_img_suffix']->value;?>
" />
      </a>
      <?php }?>
    </div>
    <?php
$_smarty_tpl->tpl_vars['v1'] = $__foreach_v1_1_saved_local_item;
}
if ($__foreach_v1_1_saved_item) {
$_smarty_tpl->tpl_vars['v1'] = $__foreach_v1_1_saved_item;
}
if ($__foreach_v1_1_saved_key) {
$_smarty_tpl->tpl_vars['k1'] = $__foreach_v1_1_saved_key;
}
?>
    <div class="clear"></div>
  </div>
  <?php }?>
  <?php if (!empty($_smarty_tpl->tpl_vars['ad_block']->value[3])) {?>
  <div class="prod_title_wrap">
    <div class="prod_title">
      <h4><?php echo $_smarty_tpl->tpl_vars['ad_block']->value[3][0]["block_name"];?>
</h4>
    </div>
    <div class="prod_more"><a href="#"><h6>more></h6></a></div>
    <div class="clear"></div>
  </div>
  <div class="prod_block_wrap">
    <?php
$_from = $_smarty_tpl->tpl_vars['ad_block']->value[3];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_v1_2_saved_item = isset($_smarty_tpl->tpl_vars['v1']) ? $_smarty_tpl->tpl_vars['v1'] : false;
$__foreach_v1_2_saved_key = isset($_smarty_tpl->tpl_vars['k1']) ? $_smarty_tpl->tpl_vars['k1'] : false;
$_smarty_tpl->tpl_vars['v1'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['k1'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['v1']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['k1']->value => $_smarty_tpl->tpl_vars['v1']->value) {
$_smarty_tpl->tpl_vars['v1']->_loop = true;
$__foreach_v1_2_saved_local_item = $_smarty_tpl->tpl_vars['v1'];
?>
    <div class="prod_block">
      <a href="<?php echo $_smarty_tpl->tpl_vars['prod_url']->value;
echo $_smarty_tpl->tpl_vars['v1']->value['prod_id'];?>
">
        <div class="prod_photo">
          <img src="<?php echo $_smarty_tpl->tpl_vars['prod_img_path']->value;?>
prod_<?php echo $_smarty_tpl->tpl_vars['v1']->value['store_id'];?>
_<?php echo $_smarty_tpl->tpl_vars['v1']->value['prod_id'];?>
_s<?php echo $_smarty_tpl->tpl_vars['prod_img_suffix']->value;?>
" />
        </div>
        <h4><?php echo $_smarty_tpl->tpl_vars['v1']->value['prod_short_name'];?>
</h4>
        <h5>$<?php echo number_format($_smarty_tpl->tpl_vars['v1']->value['default_marketing_price']);?>
</h5>
      </a>
      <div class="prod_icon_bar">
        <h3>$<?php echo number_format($_smarty_tpl->tpl_vars['v1']->value['default_sell_price']);?>
</h3>
        <span class="buy_buy" id="<?php echo $_smarty_tpl->tpl_vars['v1']->value['prod_id'];?>
">
          <a href="<?php echo $_smarty_tpl->tpl_vars['void_url']->value;?>
"><img src="/images/shopping.png" width="30px" height="30px"/></a>
        </span>
        <span class="love">
          <!--<a href="<?php echo $_smarty_tpl->tpl_vars['void_url']->value;?>
"><img src="/images/love.png" width="25px" height="25px" /></a>-->
        </span>           
        <div class="clear"></div>   
      </div>
    </div>
    <?php
$_smarty_tpl->tpl_vars['v1'] = $__foreach_v1_2_saved_local_item;
}
if ($__foreach_v1_2_saved_item) {
$_smarty_tpl->tpl_vars['v1'] = $__foreach_v1_2_saved_item;
}
if ($__foreach_v1_2_saved_key) {
$_smarty_tpl->tpl_vars['k1'] = $__foreach_v1_2_saved_key;
}
?>
    <div class="clear"></div>
  </div>
  <?php }?>
  <?php if (!empty($_smarty_tpl->tpl_vars['ad_block']->value[4])) {?>
  <div class="prod_title_wrap">
    <div class="prod_title">
      <h4><?php echo $_smarty_tpl->tpl_vars['ad_block']->value[4][0]["block_name"];?>
</h4>
    </div>
    <div class="prod_more"><a href="#"><h6>more></h6></a></div>
    <div class="clear"></div>
  </div>
  <div class="prod_block_wrap">
    <?php
$_from = $_smarty_tpl->tpl_vars['ad_block']->value[4];
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
    <div class="prod_block">
      <a href="<?php echo $_smarty_tpl->tpl_vars['prod_url']->value;
echo $_smarty_tpl->tpl_vars['v1']->value['prod_id'];?>
">
        <div class="prod_photo">
          <img src="<?php echo $_smarty_tpl->tpl_vars['prod_img_path']->value;?>
prod_<?php echo $_smarty_tpl->tpl_vars['v1']->value['store_id'];?>
_<?php echo $_smarty_tpl->tpl_vars['v1']->value['prod_id'];?>
_s<?php echo $_smarty_tpl->tpl_vars['prod_img_suffix']->value;?>
" />
        </div>
        <h4><?php echo $_smarty_tpl->tpl_vars['v1']->value['prod_short_name'];?>
</h4>
        <h5>$<?php echo number_format($_smarty_tpl->tpl_vars['v1']->value['default_marketing_price']);?>
</h5>
      </a>
      <div class="prod_icon_bar">
        <h3>$<?php echo number_format($_smarty_tpl->tpl_vars['v1']->value['default_sell_price']);?>
</h3>
        <span class="buy_buy" id="<?php echo $_smarty_tpl->tpl_vars['v1']->value['prod_id'];?>
">
          <a href="<?php echo $_smarty_tpl->tpl_vars['void_url']->value;?>
"><img src="/images/shopping.png" width="30px" height="30px"/></a>
        </span>
        <span class="love">
          <!--<a href="<?php echo $_smarty_tpl->tpl_vars['void_url']->value;?>
"><img src="/images/love.png" width="25px" height="25px" /></a>-->
        </span>
        <div class="clear"></div>
      </div>
    </div>
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
    <div class="clear"></div>
  </div>
  <?php }?>
</div>
<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

<?php }
}
