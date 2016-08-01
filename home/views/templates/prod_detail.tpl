<{$store_header}>
<div class="content_wrap">
  <div class="breadcrumb">
    <h1></h1>
  </div>
  <section class="prod_bn slider">
    <div class="slider_bn">
      <img src="<{$prod_img_path}>prod_<{$search_list["prod_info"]["store_id"]}>_<{$search_list["prod_info"]["prod_id"]}>_s<{$prod_img_suffix}>" />
    </div>
  </section>
  <div class="prod_price">
    <h4>$<{$search_list["prod_info"]["default_sell_price"]|number_format}></h4>
    <h6>$<{$search_list["prod_info"]["default_marketing_price"]|number_format}></h6>
    <div class="clear"></div>
  </div>
  <div class="prod_content_title"><{$search_list["prod_info"]["prod_name"]}></div>
    <div class="prod_feature">
      <h4><{$prod_intro_text}></h4><br />
      <h5><{$search_list["prod_info"]["commerce_profile"]}></h5>
    </div>
    <div class="prod_info_wrap">
      <h3><{$prod_description_text}></h3>
      <div>
        <p><{$search_list["prod_info"]["prod_profile"]}></p> 
      </div>
      <h3><{$prod_model_shippng_text}></h3>
      <div class="specification">
        <h5><{$models_text}></h5>
        <{if !empty($search_list["prod_model"])}>
        <{foreach from=$search_list["prod_model"] key=k1 item=v1}>
        <h5><{$v1.models_names}></h5>
        <{/foreach}>
        <{/if}>
        <h5><{$shippng_text}></h5>
        <h5></h5>         
      </div>
      <!--
      <h3 class="orange"><{$you_will_like_text}></h3>
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
<{$footer}>
