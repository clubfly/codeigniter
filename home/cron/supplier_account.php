<?php
set_time_limit(0);
define('DB_CONF','host=127.0.0.1 port=5432 dbname=d86 user=j_all password=epYTQ9ug');
define('DB_CONF2','host=127.0.0.1 port=5432 dbname=d86_v3 user=j_all password=epYTQ9ug');
class DB  {
  var $_dbConn = 0;
  var $_queryResource = 0;
  function DB($conf) {
    if (empty($conf)){
      $conf = DB_CONF;
    } else {
      $conf = DB_CONF2;
    }
    $dbconn = pg_connect($conf);
    $this->_dbConn = $dbconn;
  }
  function query($sql) {
    if (!$queryResource = pg_query($this->_dbConn,$sql)) {
      echo 'Query Error : '.PHP_EOL.$sql.PHP_EOL;
      return false;
    }
    $this->_queryResource = $queryResource;
    return $queryResource;
  }
  function fetch_one($sql) {
    $this->query($sql);
    if ($row = pg_fetch_assoc($this->_queryResource)) {
      return $this->TrimArray($row);
    } else {
      return false;
    }
  }
  function fetch_array($sql,$indexkey='') {
    $index = !empty($indexkey);
    $this->query($sql);
    $ret = array();
    while ($row = pg_fetch_assoc($this->_queryResource)) {
      if($index) $ret[trim($row[$indexkey])] = $row;
      else $ret[] = $row;
    }
    return $this->TrimArray($ret);
  }
  function execute($sql) {
    $this->query($sql);
    return pg_affected_rows($this->_queryResource);
  }
  function TrimArray($Input) {
    if (!is_array($Input)) return trim($Input); return array_map($this->TrimArray, $Input);
  }
  function lookup($field,$table,$condition) {
    $sql = "select {$field} from {$table} where {$condition} ";
    $result = $this->fetch_one($sql);
    if (!$result) {
      return false;
    } 
    if (count($result)>1) {
      return $result;
    } else {
      return current($result);
    }
  }
  function begin() {
    $this->query('BEGIN');
  }
  function rollback() {
    $this->query('ROLLBACK');
  }
  function commit() {
    $this->query('COMMIT');
  }
}
class import_supplier{
  private $db_v1 = null;
  private $db_v3 = null;
  private $city_mapping = array();
  private $state_mapping = array();
  public function __construct(){
    $this -> db_v1 = new DB(0);
    $this -> db_v3 = new DB(1);
    $this -> get_AddressMappingData();
  }
  public function get_AddressMappingData(){
    $sql = "select id,name from country_state";
    $rs = $this -> db_v1 -> fetch_array($sql);
    foreach ($rs as $key => $val){
      $this -> state_mapping[$val["id"]] = $val["name"];
    }
    $sql = "select id,name,postcode from country_city";
    $rs = $this -> db_v1 -> fetch_array($sql);
    foreach ($rs as $key => $val){
      $this -> city_mapping[$val["id"]]["city"] = $val["name"];
      $this -> city_mapping[$val["id"]]["postcode"] = $val["postcode"];
    }
  }
  public function get_V1_SupplerData($sn = 0,$limit = 1){
    $sql = "select * 
            from supplier  
            where supplier_id > '{$sn}' and 
                  supplier_id not in (1,2,64)
            order by supplier_id 
            limit {$limit} ";
    $rs = $this -> db_v1 -> fetch_array($sql);
    if (!empty($rs)){
      $this -> set_V3_Supplier_data($rs);
    }
  }
  private function set_V3_Supplier_data($data){
    if (!empty($data)){
      foreach ($data as $key => $val){
        $this -> set_V3_supplier_account($val);
      }
    }
  }
  private function set_V3_supplier($data){
    $supplier_id = intval($data["supplier_id"]);
    $supplier_no = intval($data["supplier_no"]);
    $supplier_name = trim($data["supplier_name"]);
    $enabled = intval($data["enabled"]);
    $ct = $data["ct"];
    $sql = "insert into supplier (supplier_id,supplier_no,supplier_name,enabled,ct)
                          values ('{$supplier_id}','{$supplier_no}','{$supplier_name}','{$enabled}','{$ct}')"; 
    $this -> db_v3 -> execute($sql);
  }
  private function set_V3_supplier_account($data){
    $supplier_id = intval($data["supplier_id"]);
    $account_type_id = 1;
    $account = trim($data["email"]);
    $ct = $data["ct"];
    $enabled = intval($data["enabled"]);
    $sql = "select name,passwd,is_default from supplier_users where email = '{$account}'";
    $rs = $this -> db_v1 -> fetch_one($sql);
    if (!empty($rs)){
      if (intval($rs["is_default"]) != 1){
        $account_type_id = 2;
      }
      $name = $rs["name"];
      $password = trim($rs["passwd"]);
      $sql = "insert into supplier_account (supplier_id,account_type_id,account,
                                            password,name,enabled,ct)
                                    values ('{$supplier_id}','{$account_type_id}','{$account}',
                                            '{$password}','{$name}','{$enabled}','{$ct}')";
      $this -> db_v3 -> execute($sql);
    }
  }
  private function set_V3_supplier_profile($data){
    $supplier_id = intval($data["supplier_id"]);
    $company_no = intval($data["supplier_no"]);
    $company_name = trim($data["supplier_name"]);
    $tel = trim($data["tel"]);
    $customer_service_email = trim($data["email_ac"]);
    $customer_service_skype_id = trim($data["skype_ac"]);
    $customer_service_line_id = trim($data["line_ac"]);
    $ct = $data["ct"];
    $sql = "insert into supplier_profile (supplier_id,company_no,company_name,tel,
                                          customer_service_email,customer_service_skype_id,customer_service_line_id,ct)
                                  values ('{$supplier_id}','{$company_no}','{$company_name}','{$tel}',
                                          '{$customer_service_email}','{$customer_service_skype_id}','{$customer_service_line_id}','{$ct}')";
    $this -> db_v3 -> execute($sql);
  }
  private function set_V3_supplier_platform_setting($data){
    $supplier_id = intval($data["supplier_id"]);
    $enabled = intval($data["enabled"]);
    $web_online_enabled = intval($data["enabled"]);
    $ct = $data["ct"];
    $sql = "insert into supplier_platform_setting (supplier_id,web_online_enabled,enabled,ct)
                                           values ('{$supplier_id}','{$web_online_enabled}','{$enabled}','{$ct}')";
    $this -> db_v3 -> execute($sql);
  }
  private function set_V3_supplier_delivery_setting($data){
    $supplier_id = intval($data["supplier_id"]);
    $sql = "select * 
            from admin_deliver_method 
            where enabled = 1 and 
                  disabled = 0";
    $rs = $this -> db_v3 -> fetch_array($sql);
    if (!empty($rs)){
      foreach ($rs as $key => $val){
        $sql = "insert into supplier_delivery_setting (supplier_id,deliver_method_id,supplier_account_id,enabled)
                                               values ('{$supplier_id}','{$val["deliver_method_id"]}','0','0')";
        $this -> db_v3 -> execute($sql);
        $sql = "select * 
                from admin_payment_method 
                where enabled = 1 and 
                      disabled = 0";
        $rs2 = $this -> db_v3 -> fetch_array($sql);
        if (!empty($rs2)){
          foreach ($rs2 as $kk => $vv){
            $sql = "insert into supplier_payment_setting (supplier_id,deliver_method_id,payment_method_id,supplier_account_id)
                                                  values ('{$supplier_id}','{$val["deliver_method_id"]}','{$vv["payment_method_id"]}','0')";
            $this -> db_v3 -> execute($sql);
          }
        }
      }
    }
    $sql = "select * from supplier_deliver_method where supplier_id = '{$supplier_id}'";
    $rs = $this -> db_v1 -> fetch_array($sql);
    if (!empty($rs)){
      foreach ($rs as $k => $v){
        switch (intval($v["deliver_method_id"])){
          case 10 :
            $deliver_method_id = 1;
          break;
          case 20 :
            $deliver_method_id = 2;
          break;
          case 21 :
            $deliver_method_id = 3;
          break;
        }
        $sql = "update supplier_delivery_setting
                set enabled = 1
                where supplier_id = '{$supplier_id}' and 
                      deliver_method_id = '{$deliver_method_id}'";
        $this -> db_v3 -> execute($sql);
      }
    }
    $sql = "select * from supplier_no_shipping where supplier_id = '{$supplier_id}'";
    $rs = $this -> db_v1 -> fetch_array($sql);
    if (!empty($rs)){
      foreach ($rs as $k => $v){
        $basic_shipping_fee = 0;
        switch (intval($v["deliver_method_id"])){
          case 10 :
            $deliver_method_id = 1;
          break;
          case 20 :
            $basic_shipping_fee = 50;
            $deliver_method_id = 2;
          break;
          case 21 :
            $basic_shipping_fee = 50;
            $deliver_method_id = 3;
          break;
        }
        $sql = "update supplier_delivery_setting
                set basic_shipping_fee = '{$basic_shipping_fee}',
                    none_shipping_fee_limit = '{$v["no_shipping_limit"]}'
                where supplier_id = '{$supplier_id}' and
                      deliver_method_id = '{$deliver_method_id}'";
        $this -> db_v3 -> execute($sql);
      }
    }
  }
  public function set_V3_supplier_warranty($data){
    $supplier_id = intval($data["supplier_id"]);
    $sql = "select description ,ct
            from prod_dim_tab 
            where supplier_id = '{$supplier_id}' and
                  prod_id = (select warranty_id from supplier_warranty where supplier_id = '{$supplier_id}')
            order by prod_id";
    $rs = $this -> db_v1 -> fetch_one($sql);
    if (!empty($rs)){
      $description = str_replace("'","\'",$rs["description"]);
      $sql = "insert into supplier_warranty (supplier_id,description,supplier_account_id,ct)
                                     values ('{$supplier_id}','{$description}','0','{$rs["ct"]}')";
      $this -> db_v3 -> execute($sql);
    }
  }
}
$supplier = new import_supplier;
$supplier -> get_V1_SupplerData($sn = 0,$limit = 10000);
?>
