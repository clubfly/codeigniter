<script src="/js/prod_models_v1.js"></script>
  <div class="buy_dialog_photo">
    <img src="<{$prod_img_path}>prod_<{$search_list["prod_info"]["store_id"]}>_<{$search_list["prod_info"]["prod_id"]}>_s<{$prod_img_suffix}>" />
  </div>
  <div class="buy_dialog_title">
    <h4><{$search_list["prod_info"]["prod_name"]}></h4>
  </div>
  <div class="buy_dialog_price">
    <h5><{$special_price_text}></h5>
    <h2>$<{$search_list["prod_info"]["default_sell_price"]|number_format}></h2>
    <div class="clear"></div>
  </div>  
  <div class="buy_form">
    <div class="buy_form_item">
      <input type="hidden" name="prod_id" value="<{$search_list["prod_info"]["prod_id"]}>" />
      <label for="prod_size"><{$models_text}></label>
      <{if !empty($search_list["prod_model"])}>
      <select name="prod_size" class="prod_choose">
        <{foreach from=$search_list["prod_model"] key=k1 item=v1}>
        <option value="<{$v1.sn}>"><{$v1.models_names}></option>
        <{/foreach}>
      </select>
      <{/if}>
    </div>
    <div class="buy_line"></div>
    <div class="buy_form_item">
      <label for="prod_choose"><{$qty_text}></label>
      <select name="prod_qty" class="prod_choose">
        <{for $value=1 to 20}>
        <option value="<{$value}>"><{$value}></option>
        <{/for}>
      </select>
    </div>
    <div class="buy_line"></div>
    <div class="buy_form_item">
      <label for="prod_transport"><{$shipping_text}></label>
      <select name="prod_transport" class="prod_choose">
        <option>宅配</option>
      </select>
    </div>
    <div class="buy_line"></div>
    <div class="buy_btn_wrap">
      <div class="continue_buy_btn"><a href="<{$void_url}>"><{$shop_again_text}></a></div>
      <div class="go_buy_btn"><a href="<{$void_url}>"><{$checkout_text}></a></div>
      <div class="clear"></div>
    </div>
  </div> 
