<?php
class Tool_apikey extends CI_Model{
  private $return_code = array(
                               "code" => "0",
                               "msg" => "",
                               "data" => array()
                              );
  public function __construct(){
    parent::__construct();
  }
  public function api_check($api_key = "",$api_secret = ""){
    $return_data = $this -> return_code;
    if (empty($api_key)){
      $return_data["msg"] = "金鑰不正確!";
      return $return_data;
    }
    if (empty($api_secret)){
      $return_data["msg"] = "密鑰不正確!";
      return $return_data;
    }
    $api_data = $this -> Database_supplier -> getSupplierApiKey (array(
                                                                       "api_key" => $api_key,
                                                                       "api_secret" => $api_secret                                                                               ));
    if(empty($api_data)){
      $return_data["msg"] = "請檢查您的金鑰與密鑰資料!";
      return $return_data;
    }
    $return_data["code"] = 1;
    return $return_data;
  }
}
?>
