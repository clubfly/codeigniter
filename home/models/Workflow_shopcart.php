<?php
class Workflow_shopcart extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this -> load -> helper('cookie');
    $cart_cookie_name = $this -> config -> item("cart_cookie_name");
    $cart_cookie_expire_day = $this -> config -> item("cart_cookie_expire_day");
    $cart_code = get_cookie($cart_cookie_name);
    if (empty($cart_code)){
      $prifix_name = $this -> config -> item("cart_md5_prefix");
      $cart_code = md5($prefix_name.date("YmdHis")."_init_cart");
      $name = $prifix_name."cart";
      $expire = 60*60*24*$cart_cookie_expire_day;
      $domain = $this -> config -> item("server_domain");
      $cookie = array(
                      'name'   => $name,
                      'value'  => $cart_code,
                      'expire' => $expire,
                      'domain' => $domain,
                      'path'   => '/',
                      'prefix' => '',
                      'secure' => 0,
                      'httponly' => 0
                     );
      set_cookie($cookie);
    } else {
      // can rebuild cooke if we want to do 
    }
  }
}
