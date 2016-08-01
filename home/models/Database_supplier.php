<?php
class Database_supplier extends CI_Model{
  private $fields = array();
  public function __construct(){
    parent::__construct();
  }
  public function getSupplierApiKey($data = array()){
    $this -> fields = array();
    $this -> fields = array(
                            "api_key" => $data["api_key"],
                            "api_secret" => $data["api_secret"]
                           );
    $sql = "select supplier_name,
                   api_key,
                   api_secret
            from supplier_api
            where api_key = ? and 
                  api_secret = ? and 
                  enabled = 1 and 
                  disabled = 0 ";
    return $this -> Tool_dbconnector -> queryData($sql,$this -> fields);
  }
  public function getSupplierList($data = array()){
    $this -> fields = array();
    $sql = "select supplier.supplier_id,
                   supplier.supplier_name,
                   supplier.line_ac,
                   supplier.skype_ac,
                   supplier.email_ac,
                   supplier_no_shipping.no_shipping_limit,
                   product_profile.prod_profile as warranty
            from supplier
            left join supplier_warranty on (supplier_warranty.supplier_id = supplier.supplier_id)
            left join product_profile on (supplier_warranty.warranty_id = product_profile.prod_id)
            left join supplier_no_shipping on (supplier_no_shipping.supplier_id = supplier.supplier_id)
            where supplier.enabled = 1 and 
                  supplier_no_shipping.deliver_method_id = 10
            order by supplier.supplier_id";
    return $this -> Tool_dbconnector -> queryData($sql,$this -> fields);
  }
}
?>
