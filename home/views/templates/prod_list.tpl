<{$store_header}>
<div class="content_wrap">
  <div class="breadcrumb">
    <h1><{$search_title}></h1>
  </div>
  <div class="prod_list_wrap">
    <{if !empty($search_list)}>
    <{foreach from=$search_list key=k1 item=v1}>
    <div class="prod_list_box">
     <a href="<{$prod_url}><{$v1.prod_id}>">
        <div class="list_photo">
          <img src="<{$prod_img_path}>prod_<{$v1.store_id}>_<{$v1.prod_id}>_s<{$prod_img_suffix}>" />
        </div>
        <div class="list_data">
          <h4><{$v1.prod_short_name}></h4>
          <h5></h5>
          <h6>$<{$v1.default_marketing_price|number_format}></h6>
          <div class="clear"></div>
        </div>      
      </a>
      <div class="list_icon_bar">
        <h3>$<{$v1.default_sell_price|number_format}></h3>
        <span>
          <!--<a href="#"><img src="/images/shopping.png" width="30px" height="30px"/></a>-->
        </span>
        <span class="love">
          <!--<a href="#"><img src="/images/love.png" width="25px" height="25px" /></a>-->
        </span> 
        <div class="clear"></div>
      </div>
    </div>
    <{/foreach}>
    <{else}>
    <div class="error_msg"><{$error_msg_text}></div>
    <{/if}>
    <div class="clear"></div>
  </div>
</div>
<{$footer}>
