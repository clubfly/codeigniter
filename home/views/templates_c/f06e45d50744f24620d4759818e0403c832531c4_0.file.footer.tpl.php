<?php
/* Smarty version 3.1.29, created on 2016-07-30 11:26:20
  from "/opt/home/views/templates/common/footer.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_579c1e5ca7aa36_06789494',
  'file_dependency' => 
  array (
    'f06e45d50744f24620d4759818e0403c832531c4' => 
    array (
      0 => '/opt/home/views/templates/common/footer.tpl',
      1 => 1469849168,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_579c1e5ca7aa36_06789494 ($_smarty_tpl) {
?>
      <div class="keep"></div>
      <footer>
        <?php if ($_smarty_tpl->tpl_vars['prod_id']->value > 0) {?>
        <div class="footer_menu_bar_wrap"> 
          <div class="menu_icon fbmsg">
            <a href="<?php echo $_smarty_tpl->tpl_vars['fbmsg_url']->value;?>
"><h6><?php echo $_smarty_tpl->tpl_vars['fbmsg_text']->value;?>
</h6></a>
          </div>
          <div class="menu_icon buy">
            <a href="<?php echo $_smarty_tpl->tpl_vars['cart_url']->value;?>
"><h6><?php echo $_smarty_tpl->tpl_vars['cart_text']->value;?>
</h6></a>
          </div>
          <div class="menu_icon3">
            <div class="buy_buy" id="<?php echo $_smarty_tpl->tpl_vars['prod_id']->value;?>
">
              <a href="<?php echo $_smarty_tpl->tpl_vars['void_url']->value;?>
"><h5><?php echo $_smarty_tpl->tpl_vars['buy_text']->value;?>
</h5></a>
            </div>
          </div>
        </div>
        <?php } else { ?>
        <div class="footer_menu_bar_wrap">
          <div class="menu_icon home">
            <a href="<?php echo $_smarty_tpl->tpl_vars['home_url']->value;?>
"><h6><?php echo $_smarty_tpl->tpl_vars['index_text']->value;?>
</h6></a>
          </div>
          <div class="menu_icon order">
            <a href="<?php echo $_smarty_tpl->tpl_vars['order_url']->value;?>
"><h6><?php echo $_smarty_tpl->tpl_vars['order_search_text']->value;?>
</h6></a>
          </div>
          <div class="menu_icon member">
            <a href="<?php echo $_smarty_tpl->tpl_vars['cart_url']->value;?>
"><h6><?php echo $_smarty_tpl->tpl_vars['cart_text']->value;?>
</h6></a>
          </div>
          <div class="menu_icon fbmsg">
            <a href="<?php echo $_smarty_tpl->tpl_vars['fbmsg_url']->value;?>
"><h6><?php echo $_smarty_tpl->tpl_vars['fbmsg_text']->value;?>
</h6></a>
          </div>
          <div class="menu_icon contact">
            <a href="<?php echo $_smarty_tpl->tpl_vars['contact_url']->value;?>
"><h6><?php echo $_smarty_tpl->tpl_vars['contact_text']->value;?>
</h6></a>
          </div>
        </div>
        <?php }?>
      </footer>
    </div>
  </body>
</html>
<?php }
}
