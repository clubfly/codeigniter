<?php
class Workflow_favorite extends CI_Model{
  public function __construct(){
    parent::__construct();
    $this -> load -> helper('cookie');
    $favorite_cookie_name = $this -> config -> item("favorite_cookie_name");
    $favorite_cookie_expire_day = $this -> config -> item("favorite_cookie_expire_day");
    $favorite_code = get_cookie($favorite_cookie_name);
    if (empty($favorite_code)){
      $prifix_name = $this -> config -> item("cart_md5_prefix");
      $favorite_code = md5($prefix_name.date("YmdHis")."_init_favorite");
      $name = $prifix_name."_favorite";
      $expire = 60*60*24*$favorite_cookie_expire_day;
      $domain = $this -> config -> item("server_domain");
      $cookie = array(
                      'name'   => $name,
                      'value'  => $favorite_code,
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
