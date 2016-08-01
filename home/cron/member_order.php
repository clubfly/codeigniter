<?php
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
  public function TrimArray($Input) {
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
class import_member{
  private $db_v1 = null;
  private $db_v3 = null;
  private $city_mapping = array();
  private $state_mapping = array();
  public function __construct(){
    $this -> db_v1 = new DB(0);
    $this -> db_v3 = new DB(1);
  }
  public function get_V1_MemberOrderData($sn = 0,$limit = 1){
    $sql = "select * from orders where order_id > '{$sn}' order by order_id limit {$limit} ";
    $order_list = $this -> db_v1 -> fetch_array($sql);
    if (!empty($order_list)){
      foreach ($order_list as $ka => $va){
        $payment_method = 0;
        $deliver_method = 0;
        switch(intval($va["payment_method"])){
          case 10 : //johopay
            $payment_method = 1;
          break;
          case 20 : //atm
            $payment_method = 3;
          break;
          case 30 : //credit card
            $payment_method = 2;
          break;
          case 40 : // paied when you get
            $payment_method = 4;
          break;
        }
        switch(intval($va["deliver_method"])){
          case 10 : // 宅配
            $deliver_method = 1;
          break;
          case 11 : // 宅配 paied when you get
          break;
          case 20 : // 7-11
            $deliver_method = 2;
          break;
          case 21 : // 7-11 paied when you get
            $deliver_method = 3;
          break;
        }
        $order_id = intval($va["order_id"]);
        $member_id = intval($va["member_id"]);
        $store_id = intval($va["store_id"]);
        $shopping_cart_code = $va["uuid"];
        $member_cancel = 0;
        if (empty($va["cancel_time"]) || $va["cancel_time"] == ""){
          $member_cancel = 1;
        }
        // member_order
        $original_total = intval($va["currency_total"]);
        $paied_total = intval($va["paied"]);
        $ct = $va["ct"];
        $sql = "insert into member_order (order_id,member_id,store_id,
                                          payment_method_id,deliver_method_id,shopping_cart_code,
                                          member_cancel,original_total,paied_total,ct)
                                  values ('{$order_id}','{$member_id}','{$store_id}',
                                          '{$payment_method}','{$deliver_method}','{$shopping_cart_code}',
                                          '{$member_cancel}','{$original_total}','{$paied_total}','{$ct}')";
        //$this -> db_v3 -> execute($sql);
        if (!empty($va["cancel_time"])){
          $sql = "update member_order 
                  set member_cancel_time = '{$va["cancel_time"]}',
                      member_cancel_reason_id = '{$va["cancel_reason_id"]}'
                  where order_id = '{$order_id}'";
          //$this -> db_v3 -> execute($sql);
        }
        if (intval($va["paied"]) > 0){
          $sql = "update member_order
                  set transaction_status_id = '1',
                      transaction_time = '{$va["paied_time"]}'
                  where order_id = '{$order_id}'";
          //$this -> db_v3 -> execute($sql);
        }
        // member_address
        $address_type = 0;
        $invoice_need = 0;
        $to_name = $va["to_name"];
        $to_mobile = $va["to_mobile"];
        $replace_list = array("&", "<", ">", "!", "@", "#", "?", "$", "%", "^","'","\"","+","=",";",":");
        $cust_memo = str_replace($replace_list,"",strip_tags(trim($va["cust_memo"])));
        $buyer_name = $va["buyer_name"];
        $buyer_mobile = $va["buyer_mobile"];
        $buyer_mail = $va["buyer_mail"];
        if ($deliver_method > 10){ // 7-11
          $address_type = 1;
          $storeid = intval($va["up711_storeid"]);
          $storename = $va["up711_storename"];
          $servicetype = intval($va["up711_servicetype"]);
          $tempvar = $va["up711_tempvar"];
          $shipping_address = strip_tags($va["up711_address"]);
          $sql = "insert into member_order_address (order_id,member_id,address_type,
                                                    to_name,to_mobile,invoice_need,
                                                    storeid,storename,servicetype,
                                                    tempvar,shipping_address,cust_memo,
                                                    buyer_name,buyer_mobile,buyer_mail)
                                            values ('{$order_id}','{$member_id}','{$address_type}',
                                                    '{$to_name}','{$to_mobile}','{$invoice_need}',
                                                    '{$storeid}','{$storename}','{$servicetype}',
                                                    '{$tempvar}','{$shipping_address}','{$cust_memo}',
                                                    '{$buyer_name}','{$buyer_mobile}','{$buyer_mail}')";
        } else {
          $postcode = $va["postal_code"];
          $state_id = $va["state_id"];
          $city_id = $va["city_id"];
          $shipping_address = strip_tags($va["address"]);
          $receive_preffer = intval($va["deliver_time_interval"]); 
          $sql = "insert into member_order_address (order_id,member_id,address_type,
                                                    to_name,to_mobile,invoice_need,
                                                    postcode,state_id,city_id,
                                                    shipping_address,receive_preffer,cust_memo,
                                                    buyer_name,buyer_mobile,buyer_mail)
                                            values ('{$order_id}','{$member_id}','{$address_type}',
                                                    '{$to_name}','{$to_mobile}','{$invoice_need}',
                                                    '{$postcode}','{$state_id}','{$city_id}',
                                                    '{$shipping_address}','{$receive_preffer}','{$cust_memo}',
                                                    '{$buyer_name}','{$buyer_mobile}','{$buyer_mail}')";
        }
        $this -> db_v3 -> execute($sql);
        if (!empty($va["invoice_title_no"])){
          $invoice_title = $va["invoice_paper_title"];
          $invoice_title_no = $va["invoice_paper_no"];
          $invoice_address = $va["invoice_send_address"];
          $sql = "update member_order_address
                  set invoice_need = '1',
                      invoice_title = '{$invoice_title}',
                      invoice_title_no = '{$invoice_title_no}',
                      invoice_address = '{$invoice_address}'
                  where order_id = '{$order_id}'";
          $this -> db_v3 -> execute($sql);
        }
      }
    }
  }
  public function get_V1_MemberOrderDetailData(){
    $sql = "select * from order_items order by order_id ,supplier_id,type";
    $order_detail_list = $this -> db_v1 -> fetch_array($sql);
    if (!empty($order_detail_list)){
      foreach ($order_detail_list as $ka => $va){
        $order_id = $va["order_id"];
        $member_id = 0;
        $store_id = $va["store_id"];
        $supplier_id = $va["supplier_id"];
        $prod_id = $va["prod_id"];
        if (intval($va["type"]) == 10){
          $replace_list = array("&", "<", ">", "!", "@", "#", "?", "$", "%", "^","'","\"","+","=",";",":");
          $prod_name = str_replace($replace_list,"",strip_tags($va["prod_name"]."-".$va["prod_name_dim"]));
        } else {
          $prod_name = trim($va["prod_name"]);
          $prod_id = 0;
        }
        $qty = $va["quantity"];
        $unit_price = $va["unit_price"];
        $total = ($va["quantity"]*$va["unit_price"]);
        $with_tax = 1;
        $ct = $va["ct"];
        $sql = "insert into member_order_detail (order_id,member_id,store_id,
                                                 supplier_id,prod_id,prod_name,
                                                 qty,unit_price,total,with_tax,
                                                 ct)
                                         values ('{$order_id}','{$member_id}','{$store_id}',
                                                 '{$supplier_id}','{$prod_id}','{$prod_name}',
                                                 '{$qty}','{$unit_price}','{$total}','{$with_tax}',
                                                 '{$ct}')";
        //$this -> db_v3 -> execute($sql);
        if (intval($va["canceled"]) == 1){
          $sql = "update member_order_detail
                  set canceled_mark = 1 
                  where order_id = '{$order_id}'";
          //$this -> db_v3 -> execute($sql);
          if (!empty($va["cancel_day"])){
            $sql = "update member_order_detail
                  set canceled_mark_time = '{$va["cancel_day"]}'
                  where order_id = '{$order_id}'";
            //$this -> db_v3 -> execute($sql);
          }
        }
      }
    }
    $sql = "select prod_id from supplier_prod where with_tax = 0 ";
    $none_tax_list = $this -> db_v3 -> fetch_array($sql);
    if (!empty($none_tax_list)){
      foreach ($none_tax_list as $kb => $vb){
        $sql = "update member_order_detail
                set with_tax = '0'
                where prod_id = '{$vb["prod_id"]}' ";
        $this -> db_v3 -> execute($sql);
      }
    }
    $sql = "update member_order_detail
                set with_tax = '1'
                where prod_id = '0' ";
    $this -> db_v3 -> execute($sql);
    $sql = "select order_id,member_id from member_order";
    $order_list = $this -> db_v3 -> fetch_array($sql);
    if (!empty($order_list)){
      foreach ($order_list as $kc => $vc){
        $sql = "update member_order_detail
                set member_id = '{$vc["member_id"]}'
                where order_id = '{$vc["order_id"]}' ";
        $this -> db_v3 -> execute($sql);
      }
    }
  }
}
$member = new import_member; 
$member -> get_V1_MemberOrderData($sn = 0,$limit = 30000);
//$member -> get_V1_MemberOrderDetailData();
?>
