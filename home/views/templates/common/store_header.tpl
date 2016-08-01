<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>mobile website</title>
    <{if !empty($css)}>
    <{foreach from=$css item=val}>
    <link rel="stylesheet" type="text/css" href="/css/<{$val}>">
    <{/foreach}>
    <{/if}>
    <{if !empty($js)}>
    <{foreach from=$js item=val}>
    <script type="text/javascript" src="/js/<{$val}>"></script>
    <{/foreach}>
    <{/if}>
    <{if !empty($js_thirdparty)}>
    <{foreach from=$js_thirdparty item=val}>
    <script type="text/javascript" src="<{$val}>"></script>
    <{/foreach}>
    <{/if}>
  </head>
  <body>
    <div class="main_wrap">
      <div class="gotop_icon">
        <a href="<{$void_url}>">
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
          <a href="<{$void_url}>">
            <img src="/images/search.png" width="25px" height="25px"/>
            <p><{$search_text}></p>
            <div class="clear"></div>
          </a>
        </div>
        <div class="search_wrap">
          <div class="search_bar">
            <input type="text" placeholder="<{$search_holder}>" id="search_value" />
            <div class="search_btn"><{$search_text}></div>
            <div class="clear"></div>
          </div>
        </div>
        <div class="clear"></div>
        <div class="hamburger_list_wrap">
          <!--<div class="hamburger_login_bar">
            <ul>
              <li class="login"><a href="<{$void_url}>"><{$login_text}></a></li>
              <li class="home"><a href="<{$void_url}>"><{$index_text}></a></li>
              <div class="clear"></div>
            </ul>
          </div>-->
          <div class="hamburger_type_item">
            <{if !empty($categoryList)}>
              <{foreach from=$categoryList key=k1 item=v1}>
            <h3>
              <{$v1[0]["category_name"]}>
            </h3>
                <{if !empty($v1)}>
            <div>
                  <{foreach from=$v1 key=k2 item=v2}>
              <p><a href="<{$category_url}><{$v2.category_sub_id}>"><{$v2.sub_category_name}></a></p>
                  <{/foreach}>
            </div>
                <{/if}>
              <{/foreach}>
            <{/if}>
          </div>
        </div>
        <div class="buy_dialog_wrap"></div>
      </div>
