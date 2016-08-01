<{$store_header}>
<div class="content_wrap">
  <{if !empty($ad_block[1])}>
  <section class="regular slider">
    <{foreach from=$ad_block[1] key=k1 item=v1}>
    <div class="slider_bn">
      <{if $v1.block_type == 0}>
      <a href="<{$v1.url}>">
        <img src="<{$commerce_path}><{$v1.img_files}>" />
      </a>
      <{else}>
      <a href="<{$prod_url}><{$v1.prod_id}>">
        <img src="<{$prod_img_path}>prod_<{$v1.store_id}>_<{$v1.prod_id}>_s<{$prod_img_suffix}>" />
      </a>
      <{/if}>
    </div>
    <{/foreach}>
  </section>
  <{/if}>
  <{if !empty($ad_block[2])}>
  <div class="theme_btn_wrap">
    <{foreach from=$ad_block[2] key=k1 item=v1}>
    <div class="theme_btn">
      <{if $v1.block_type == 0}>
      <a href="<{$v1.url}>">
        <img src="<{$commerce_path}><{$v1.img_files}>" />
      </a>
      <{else}>
      <a href="<{$prod_url}><{$v1.prod_id}>">
        <img src="<{$prod_img_path}>prod_<{$v1.store_id}>_<{$v1.prod_id}>_s<{$prod_img_suffix}>" />
      </a>
      <{/if}>
    </div>
    <{/foreach}>
    <div class="clear"></div>
  </div>
  <{/if}>
  <{if !empty($ad_block[3])}>
  <div class="prod_title_wrap">
    <div class="prod_title">
      <h4><{$ad_block[3][0]["block_name"]}></h4>
    </div>
    <div class="prod_more"><a href="#"><h6>more></h6></a></div>
    <div class="clear"></div>
  </div>
  <div class="prod_block_wrap">
    <{foreach from=$ad_block[3] key=k1 item=v1}>
    <div class="prod_block">
      <a href="<{$prod_url}><{$v1.prod_id}>">
        <div class="prod_photo">
          <img src="<{$prod_img_path}>prod_<{$v1.store_id}>_<{$v1.prod_id}>_s<{$prod_img_suffix}>" />
        </div>
        <h4><{$v1.prod_short_name}></h4>
        <h5>$<{$v1.default_marketing_price|number_format}></h5>
      </a>
      <div class="prod_icon_bar">
        <h3>$<{$v1.default_sell_price|number_format}></h3>
        <span class="buy_buy" id="<{$v1.prod_id}>">
          <a href="<{$void_url}>"><img src="/images/shopping.png" width="30px" height="30px"/></a>
        </span>
        <span class="love">
          <!--<a href="<{$void_url}>"><img src="/images/love.png" width="25px" height="25px" /></a>-->
        </span>           
        <div class="clear"></div>   
      </div>
    </div>
    <{/foreach}>
    <div class="clear"></div>
  </div>
  <{/if}>
  <{if !empty($ad_block[4])}>
  <div class="prod_title_wrap">
    <div class="prod_title">
      <h4><{$ad_block[4][0]["block_name"]}></h4>
    </div>
    <div class="prod_more"><a href="#"><h6>more></h6></a></div>
    <div class="clear"></div>
  </div>
  <div class="prod_block_wrap">
    <{foreach from=$ad_block[4] key=k1 item=v1}>
    <div class="prod_block">
      <a href="<{$prod_url}><{$v1.prod_id}>">
        <div class="prod_photo">
          <img src="<{$prod_img_path}>prod_<{$v1.store_id}>_<{$v1.prod_id}>_s<{$prod_img_suffix}>" />
        </div>
        <h4><{$v1.prod_short_name}></h4>
        <h5>$<{$v1.default_marketing_price|number_format}></h5>
      </a>
      <div class="prod_icon_bar">
        <h3>$<{$v1.default_sell_price|number_format}></h3>
        <span class="buy_buy" id="<{$v1.prod_id}>">
          <a href="<{$void_url}>"><img src="/images/shopping.png" width="30px" height="30px"/></a>
        </span>
        <span class="love">
          <!--<a href="<{$void_url}>"><img src="/images/love.png" width="25px" height="25px" /></a>-->
        </span>
        <div class="clear"></div>
      </div>
    </div>
    <{/foreach}>
    <div class="clear"></div>
  </div>
  <{/if}>
</div>
<{$footer}>
