      <div class="keep"></div>
      <footer>
        <{if $prod_id > 0}>
        <div class="footer_menu_bar_wrap"> 
          <div class="menu_icon fbmsg">
            <a href="<{$fbmsg_url}>"><h6><{$fbmsg_text}></h6></a>
          </div>
          <div class="menu_icon buy">
            <a href="<{$cart_url}>"><h6><{$cart_text}></h6></a>
          </div>
          <div class="menu_icon3">
            <div class="buy_buy" id="<{$prod_id}>">
              <a href="<{$void_url}>"><h5><{$buy_text}></h5></a>
            </div>
          </div>
        </div>
        <{else}>
        <div class="footer_menu_bar_wrap">
          <div class="menu_icon home">
            <a href="<{$home_url}>"><h6><{$index_text}></h6></a>
          </div>
          <div class="menu_icon order">
            <a href="<{$order_url}>"><h6><{$order_search_text}></h6></a>
          </div>
          <div class="menu_icon member">
            <a href="<{$cart_url}>"><h6><{$cart_text}></h6></a>
          </div>
          <div class="menu_icon fbmsg">
            <a href="<{$fbmsg_url}>"><h6><{$fbmsg_text}></h6></a>
          </div>
          <div class="menu_icon contact">
            <a href="<{$contact_url}>"><h6><{$contact_text}></h6></a>
          </div>
        </div>
        <{/if}>
      </footer>
    </div>
  </body>
</html>
