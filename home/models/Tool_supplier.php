<?php
class Tool_supplier extends CI_Model{
  private $return_code = array(
                               "code" => "0",
                               "msg" => "",
                               "data" => array()
                              );
  public function __construct(){
    parent::__construct();
  }
  public function getAllSupplierList(){
    $return_data = $this -> return_code;
    $supplierList = $this -> Database_supplier -> getSupplierList();
    $return_data["msg"] = "資料異常";
    if (!empty($supplierList)){
      $return_data["code"] = 1;
      $return_data["msg"] = "";
      $return_data["data"] = $supplierList;
    }
    return $return_data;
  }
}
?>
