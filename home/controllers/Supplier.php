<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Supplier extends CI_Controller {
  public function __construct(){
    parent::__construct();
  } 
  public function index($api_key = "",$api_secret = "",$format = "json"){
    // 供應商資料
    $check_valid = $this -> Tool_apikey -> api_check ($api_key,$api_secret);
    if (intval($check_valid["code"]) == 1){
      $supplierList = $this -> Tool_supplier -> getAllSupplierList();
      //echo "<pre>";print_r($supplierList);
      echo json_encode($supplierList); 
    } else {
      echo json_encode($check_valid);
    }
    //$this -> smarty -> view('test.tpl',$web_content);
  }
}
