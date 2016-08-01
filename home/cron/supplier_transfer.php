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
        //$this -> set_V3_supplier($val);
        //$this -> set_V3_supplier_account($val);
        //$this -> set_V3_supplier_profile($val);
        //$this -> set_V3_supplier_platform_setting($val);
        //$this -> set_V3_supplier_delivery_setting($val);// with supplier_payment_setting
        //$this -> set_V3_supplier_prod($val);
        //$this -> set_V3_supplier_warranty($val);
        //$this -> set_V3_supplier_prod_profile($val);
        //$this -> set_V3_supplier_prod_fee_setting($val);
        //$this -> set_V3_supplier_supplier_prod_category_setting($val);
      }
      //$this -> set_category();
      $this -> set_prod_category();
      //$this -> setProdsupplier_prod_shipping_setting();
      //$this -> setProdImages();
    }
  }
  private function setProdImages(){
    echo date("Y-m-d H:i:s")." - start \n";
    $img_path = "/var/www/supplier/uploads/supplier/";
    $sql = "select supplier_id
            from supplier
            order by supplier_id";
    $supplier_list = $this -> db_v3 -> fetch_array($sql);
    foreach ($supplier_list as $ka => $va){
      if (!is_dir($img_path.$va["supplier_id"])){
        mkdir($img_path.$va["supplier_id"],0755);
      }
    }
    $sql = "select supplier_id,prod_id 
            from supplier_prod 
            order by supplier_id";
    $prod_list = $this -> db_v3 -> fetch_array($sql);
    foreach ($prod_list as $kb => $vb){
      $prod_id = intval($vb["prod_id"]);
      $supplier_id = intval($vb["supplier_id"]);
      $img_json = file_get_contents('https://supplier.johomy.com.tw/api/prod_img.php?'.http_build_query(array(
                          'prod_id'=>$prod_id,
                          'pdids'=>"",
                          'lang'=>"ZH_TW",
                  )));
      $images_list = json_decode($img_json,true);
      print_r($images_list);
      if (!empty($images_list)){
        foreach ($images_list as $kc => $vc){
          $url = $vc["o"];
          $file_name = "prod_".$prod_id."_".($kc+1).".jpg";
          $save_path = $img_path.$supplier_id."/".$file_name;
          if (!file_exists($save_path)){
            $contents = file_get_contents($url);
            file_put_contents($save_path,$contents);
          }
          $image_types_id = 0;
          if (intval($kc) == 0){
            $image_types_id = 1;
          }
          $sql = "select prod_id ,old_img 
                  from supplier_prod_images 
                  where prod_id = '{$prod_id}' and 
                        file_name = '{$file_name}'";
          $get_data = $this -> db_v3 -> fetch_array($sql);
          if (empty($get_data)){
            $old_img = $url;
            $sql = "insert into supplier_prod_images (prod_id,supplier_id,image_types_id,file_name,old_img)
                                              values ('{$prod_id}','{$supplier_id}','{$image_types_id}','{$file_name}','{$url}')";
            $this -> db_v3 -> execute($sql);
          }
          if (empty($get_data["old_img"])){
            $sql = "update supplier_prod_images
                    set old_img = '{$url}' 
                    where prod_id = '{$prod_id}' and 
                          file_name = '{$file_name}'";
            $this -> db_v3 -> execute($sql);
          }
        }
      }
    }
    echo date("Y-m-d H:i:s")." - end \n";
  }
  private function setProdShippingFee(){
    $sql = "select prod_id,
                   supplier_id,
                   shipping_price 
            from prod_dim_union 
            where shipping_price > 0 
            group by prod_id,supplier_id,shipping_price 
            order by prod_id";
    $prod_shipping = $this -> db_v1 -> fetch_array($sql);
    foreach ($prod_shipping as $ka => $va){
      $sql = "select * 
              from supplier_prod_shipping_setting
              where prod_id = '{$va["prod_id"]}' and 
                    deliver_method_id = 1";
      $prod = $this -> db_v3 -> fetch_array($sql);
      if (!empty($prod)){
        $sql = "update supplier_prod_shipping_setting
                set fee = '{$va["shipping_price"]}'
                where prod_id = '{$va["prod_id"]}' and 
                      deliver_method_id = 1";
      } else {
        $sql = "insert into supplier_prod_shipping_setting (supplier_id,prod_id,deliver_method_id,fee,supplier_account_id)
                                                    values ('{$va["supplier_id"]}','{$va["prod_id"]}','1','{$va["shipping_price"]}','0')";
      }
      $this -> db_v3 -> execute($sql);
    }
    $sql = "select prod_id
            from prod_dim_union
            where shipping_price = 0
            group by prod_id
            order by prod_id";
    $prod_shipping2 = $this -> db_v1 -> fetch_array($sql);
    foreach ($prod_shipping2 as $ka => $va){
      $sql = "update supplier_prod 
              set no_shipping_fee = 1 
              where prod_id = '{$va["prod_id"]}'";
      $this -> db_v3 -> execute($sql); 
    }
  }
  private function setProdsupplier_prod_shipping_setting(){
      //$this -> set_category($data);
      //$this -> set_prod_category();
      $sql = "select prod_deliver_method.prod_id ,
                     prod_deliver_method.deliver_method_id,
                     prod.supplier_id
              from prod_deliver_method 
              left join prod on (prod.prod_id = prod_deliver_method.prod_id)
              order  by prod_deliver_method.prod_id ,prod_deliver_method.deliver_method_id";
      $prod_shipping = $this -> db_v1 -> fetch_array($sql);
      foreach ($prod_shipping as $ka => $va){
        switch(intval($va["deliver_method_id"])){
          case 10 :
            $deliver_method_id = 1;
          break;
          case 20:
            $deliver_method_id = 2;
          break;
          case 21:
            $deliver_method_id = 3;
          break;
        }
        if (intval($va["supplier_id"]) > 0){
          $sql = "insert into supplier_prod_shipping_setting (supplier_id,prod_id,deliver_method_id,supplier_account_id)
                                                      values ('{$va["supplier_id"]}','{$va["prod_id"]}','{$deliver_method_id}','0')";
          $this -> db_v3 -> execute($sql);
        }
      }
      $this -> setProdShippingFee();
  }
  private function set_prod_category(){
    $sql = "select * from prod_category order by prod_id,lvl";
    $prod_category = $this -> db_v1 -> fetch_array($sql);
    $prod_category_list = array();
    foreach ($prod_category as $ka => $va){
      $prod_category_list[$va["prod_id"]][$va["lvl"]] = $va["category_id"];
    }
    foreach ($prod_category_list as $kb => $vb) {
      $sql = "select supplier_id from prod where prod_id = '{$kb}'";
      $supplier = $this -> db_v1 -> fetch_one($sql);
      $prod_id = intval($kb);
      $supplier_id = intval($supplier["supplier_id"]);
      if (!empty($vb)){
        foreach ($vb as $kc => $vc){
          $sql = "select system_category_id,supplier_category_id,level from supplier_prod_category_list where old_mapping_id = '{$vc}'";
          $new_category_id = $this -> db_v3 -> fetch_one($sql);
          if (!empty($new_category_id)){
            $platform_category_id = intval($new_category_id["system_category_id"]);
            $platform_sub_category_id = intval($new_category_id["supplier_category_id"]);
            $platform_category_level = intval($new_category_id["level"]);
            $sql = "insert into supplier_prod_category_setting (prod_id,supplier_id,
                                                                platform_category_id,platform_sub_category_id,
                                                                platform_category_level,supplier_account_id)
                                                        values ('{$prod_id}','{$supplier_id}',
                                                                '{$platform_category_id}','{$platform_sub_category_id}',
                                                                '{$platform_category_level}','0')";
            $this -> db_v3 -> execute($sql);
          }
        }
      }
    }
  }
  private function set_category($data = array()){
    $sql = "select * from category where parent_id = 0 order by pos";
    $category = $this -> db_v1 -> fetch_array($sql);
    $category_list = array();
    foreach ($category as $ka => $va){
      switch (intval($va["category_id"])){
        case 30 : //[category_id] => 30 [title] => 揪好行
          $new_sys_category_id = 8;
        break;
        case 32 : //[category_id] => 32 [title] => 揪好水
          $new_sys_category_id = 1;
        break;
        case 27 : //[category_id] => 27 [title] => 揪好穿
          $new_sys_category_id = 2;
        break;
        case 28 : //[category_id] => 28 [title] => 揪好吃
          $new_sys_category_id = 3;
        break;
        case 31 : //[category_id] => 31 [title] => 揪好玩
          $new_sys_category_id = 4;
        break;
        case 29 : //[category_id] => 29 [title] => 揪好用
          $new_sys_category_id = 5;
        break;
        case 321 : //[category_id] => 321 [title] => 主題館
          $new_sys_category_id = 6;
        break;
        case 335 : //[category_id] => 335 [title] => 封存區
          $new_sys_category_id = 9;
        break;
      }
      $category_list[$new_sys_category_id]["old_id"] = intval($va["category_id"]);
      $category_list[$new_sys_category_id]["new_id"] = $new_sys_category_id;
    }
    foreach ($category_list as $kb => $vb){
      $sql = "select * from category where parent_id = '{$vb["old_id"]}' order by pos";
      $category_sub1 = $this -> db_v1 -> fetch_array($sql);
      $is_adult = 0;
      if (!empty($category_sub1)){
        $system_category_id = intval($vb["new_id"]);
        foreach ($category_sub1 as $kc => $vc){
          $title = str_replace('﹂','',trim(strip_tags($vc["title"])));
          $enabled = intval($vc["display"]);
          $old_mapping_id = intval($vc["category_id"]);
          $parent_id = $system_category_id;
          $sql = "insert into supplier_prod_category_list (system_category_id,title,enabled,
                                                           level,old_mapping_id,parent_id,is_adult)
                                                   values ('{$system_category_id}','{$title}','{$enabled}',
                                                           '1','{$old_mapping_id}','{$parent_id}','{$is_adult}') returning supplier_category_id";
          $new_ids1 = $this -> db_v3 -> fetch_array($sql);// new_parent_id
          if (!empty($new_ids1)){
            $sql = "select * from category where parent_id = '{$vc["category_id"]}' order by pos";
            $category_sub2 = $this -> db_v1 -> fetch_array($sql);
            if (!empty($category_sub2)){
              foreach ($category_sub2 as $kd => $vd){
                $title = str_replace('﹂','',trim(strip_tags($vd["title"])));
                $enabled = intval($vd["display"]);
                $old_mapping_id = intval($vd["category_id"]);
                $parent_id = $new_ids1[0]["supplier_category_id"];
                $sql = "insert into supplier_prod_category_list (system_category_id,title,enabled,
                                                           level,old_mapping_id,parent_id,is_adult)
                                                   values ('{$system_category_id}','{$title}','{$enabled}',
                                                           '2','{$old_mapping_id}','{$parent_id}','{$is_adult}') returning supplier_category_id";
                $new_ids2 = $this -> db_v3 -> fetch_array($sql);// new_parent_id
                if (!empty($new_ids2)){
                  $sql = "select * from category where parent_id = '{$vd["category_id"]}' order by pos";
                  $category_sub3 = $this -> db_v1 -> fetch_array($sql);
                  if (!empty($category_sub3)){
                    foreach ($category_sub3 as $ke => $ve){
                      $title = str_replace('﹂','',trim(strip_tags($ve["title"])));
                      $enabled = intval($ve["display"]);
                      $old_mapping_id = intval($ve["category_id"]);
                      $parent_id = $new_ids2[0]["supplier_category_id"];
                      $sql = "insert into supplier_prod_category_list (system_category_id,title,enabled,
                                                           level,old_mapping_id,parent_id,is_adult)
                                                   values ('{$system_category_id}','{$title}','{$enabled}',
                                                           '3','{$old_mapping_id}','{$parent_id}','{$is_adult}') returning supplier_category_id";
                      $new_ids3 = $this -> db_v3 -> fetch_array($sql);// new_parent_id
                      if (!empty($new_ids3)){
                        $sql = "select * from category where parent_id = '{$ve["category_id"]}' order by pos";
                        $category_sub4 = $this -> db_v1 -> fetch_array($sql);
                        if (!empty($category_sub4)){
                          foreach ($category_sub4 as $kf => $vf){
                            $title = str_replace('﹂','',trim(strip_tags($vf["title"])));
                            $enabled = intval($vf["display"]);
                            $old_mapping_id = intval($vf["category_id"]);
                            $parent_id = $new_ids3[0]["supplier_category_id"];
                            $sql = "insert into supplier_prod_category_list (system_category_id,title,enabled,
                                                           level,old_mapping_id,parent_id,is_adult)
                                                   values ('{$system_category_id}','{$title}','{$enabled}',
                                                           '4','{$old_mapping_id}','{$parent_id}','{$is_adult}') returning supplier_category_id";
                            $new_ids4 = $this -> db_v3 -> fetch_array($sql);// new_parent_id
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    } 
    /*if (!empty($data)){
      $sql = "select * from category where parent_id = 0 order by pos";
      $category = $this -> db_v1 -> fetch_array($sql);
      $category_list = array();
      foreach ($category as $ka => $va){
        $system_category_id = intval($va["category_id"]);
        $sql = "select * from category where parent_id = '{$va["category_id"]}' and display = 1 order by pos";
        $category_sub1 = $this -> db_v1 -> fetch_array($sql);
        foreach ($category_sub1 as $kb => $vb){ // level 1
          $category_list[$vb["parent_id"]][$vb["category_id"]]["title"] = $vb["title"];
          $title = trim(strip_tags($vb["title"]));
          $category_id = intval($vb["category_id"]);
          $sql = "insert into supplier_prod_category_list (system_category_id,title,
                                                           level,old_mapping_id,parent_id)
                                                   values ('{$system_category_id}','{$title}','1','{$category_id}','{$system_category_id}')";
          $this -> db_v3 -> execute($sql);
          $sql = "select * from category where parent_id = '{$vb["category_id"]}' and display = 1 order by pos";
          $category_sub2 = $this -> db_v1 -> fetch_array($sql);
          $items1 = array();
          foreach ($category_sub2 as $kc => $vc){ // level 2
            $items1[$vc["category_id"]]["title"] = $vc["title"];
            $title = trim(strip_tags($vc["title"]));
            $category_id = intval($vc["category_id"]);
            $sql = "insert into supplier_prod_category_list (system_category_id,title,
                                                               level,old_mapping_id,parent_id)
                                                     values ('{$system_category_id}','{$title}','2','{$category_id}','{$vb["category_id"]}')";
            $this -> db_v3 -> execute($sql);
            $sql = "select * from category where parent_id = '{$vc["category_id"]}' and display = 1 order by pos";
            $category_sub3 = $this -> db_v1 -> fetch_array($sql);
            $items2 = array();
            foreach ($category_sub3 as $kd => $vd){ // level 3
              $items2[$vd["category_id"]]["title"] = $vd["title"];
              $items1[$vc["category_id"]]["item"] = $items2;
              $title = strip_tags($vd["title"]);
              $category_id = intval($vd["category_id"]);
              $sql = "insert into supplier_prod_category_list (system_category_id,title,
                                                               level,old_mapping_id,parent_id)
                                                       values ('{$system_category_id}','{$title}','3','{$category_id}','{$vc["category_id"]}')";
              $this -> db_v3 -> execute($sql);
              $items3 = array();
              $sql = "select * from category where parent_id = '{$vd["category_id"]}' and display = 1 order by pos";
              $category_sub4 = $this -> db_v1 -> fetch_array($sql);
              foreach ($category_sub4 as $ke => $ve){ // level 4
                $items3[$ve["category_id"]]["title"] = $ve["title"];
                $items2[$vd["category_id"]]["item"] = $items3;
                $title = strip_tags($ve["title"]);
                $category_id = intval($ve["category_id"]);
                $sql = "insert into supplier_prod_category_list (system_category_id,title,
                                                                 level,old_mapping_id,parent_id)
                                                         values ('{$system_category_id}','{$title}','4','{$category_id}','{$vd["category_id"]}')";
                $this -> db_v3 -> execute($sql); 
              }
            }
            $category_list[$vb["parent_id"]][$vb["category_id"]]["item"] = $items1;
          }
        }
      }
      print_r($category_list);
    }*/
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
    $sql = "select name,passwd from supplier_users where email = '{$account}'";
    $rs = $this -> db_v1 -> fetch_one($sql);
    if (!empty($rs)){
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
  public function set_V3_supplier_prod($data){
    $supplier_id = intval($data["supplier_id"]);
    $sql = "select * from prod 
            where supplier_id = '{$supplier_id}' and 
                  prod_id > '5' and 
                  prod_id not in (select warranty_id from supplier_warranty) 
            order by prod_id";
    $rs = $this -> db_v1 -> fetch_array($sql);
    if (!empty($rs)){
      foreach ($rs as $k => $v){
        $prod_id = intval($v["prod_id"]);
        $prod_name = mb_substr(strip_tags(str_replace("'","",$v["title"])),0,30,"utf-8");
        $is_adult = intval($v["is_adult"]);
        $with_tax = intval($v["with_tax"]);
        $ct = $v["ct"];
        $status_id = 0;
        switch (intval($v["status"])){
          case 90 :
            $status_id = 2;
          break;
          case 20 : 
            $status_id = 1;
          break;
          case 10 :
            $status_id = -1;
          break;
        }
        $sql = "insert into supplier_prod (prod_id,supplier_id,prod_name,
                                           is_adult,with_tax,status_id,
                                           supplier_account_id,ct)
                                   values ('{$prod_id}','{$supplier_id}','{$prod_name}',
                                           '{$is_adult}','{$with_tax}','{$status_id}',
                                           '0','{$ct}')";
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
  public function set_V3_supplier_prod_profile($data){
    $supplier_id = intval($data["supplier_id"]);
    $sql = "select * from prod_dim_union_lang where supplier_id = '{$supplier_id}' and prod_id > '5'";
    $rs = $this -> db_v1 -> fetch_array($sql);
    if (!empty($rs)){
      foreach ($rs as $key => $val){
        $prod_id = intval($val["prod_id"]);
        $prod_keyword = strip_tags(str_replace("'","",trim($val["seo_keyword"])));
        $prod_description = strip_tags(str_replace("'","",trim($val["seo_description"])));
        $sql = "select description,ct from prod_dim_tab where prod_id = '{$prod_id}'";
        $rs2 = $this -> db_v1 -> fetch_one($sql);
        $prod_profile = "";
        $ct = date("Y-m-d H:i:s");
        if (!empty($rs2)){
          $prod_profile2 = str_replace("'","\'",$rs2["description"]);
          $prod_profile = str_replace(",","\,",$prod_profile2);
          $ct = $rs2["ct"];
        }
        $sql = "insert into supplier_prod_profile (prod_id,supplier_id,prod_keyword,
                                                   prod_description,prod_profile,supplier_account_id,ct)
                                           values ('{$prod_id}','{$supplier_id}','{$prod_keyword}',
                                                   '{$prod_description}','{$prod_profile}','0','{$ct}')";
        $this -> db_v3 -> execute($sql); 
      }
    }
  }
  public function set_V3_supplier_prod_fee_setting($data){
    $supplier_id = intval($data["supplier_id"]);
    echo $supplier_id." start :".date("Y-m-d H:i:s")."\n";
    if ($supplier_id <= 0){
      return 0;
    }
    $sql = "select fee_id,
                   title 
            from admin_prod_fee_setting_list 
            where enabled = 1 and 
                  disabled = 0
            order by fee_id";
    $rs1 = $this -> db_v3 -> fetch_array($sql);
    $fee_array = array();
    foreach ($rs1 as $k =>$v){
      $fee_array[$v["fee_id"]] = $v["title"];
    }
    $sql = "select * from prod where supplier_id = '{$supplier_id}' order by prod_id";
    $prod_list = $this -> db_v1 -> fetch_array($sql);
    if (!empty($prod_list)){
      foreach ($prod_list as $ka => $va){
        echo "supplier_id : ".$supplier_id." prod_id : ".$va["prod_id"]."\n";
        $prod_id = intval($va["prod_id"]);
        foreach ($fee_array as $k1 => $v1){// default prod fee
          switch ($k1){
            case 1 :
              $fee = intval($va["mprice_max"]);
            break;
            case 2 :
              $fee = intval($va["price_min"]);
            break;
            case 3 :
              $fee = 0;
            break;
            case 4 : 
              $fee = 0;
            break;
            case 5 :
              $fee = intval($va["commission_min"]);
            break;
          }
          $sql = "insert into supplier_prod_fee_setting2 (prod_id,supplier_id,fee_id,fee)
                                                  values ('{$prod_id}','{$supplier_id}','{$k1}','{$fee}')";
          $this -> db_v3 -> execute($sql); 
        }
        $sql = "select * from prod_dim_union where prod_id = '{$prod_id}'";
        $dim = $this -> db_v1 -> fetch_array($sql);
        if (!empty($dim)){
          foreach ($dim as $k2 => $v2){
            $sql = "select prod_dim_id,title from prod_dim where prod_dim_id in ({$v2["prod_dim_ids"]})";
            $dim_list = $this -> db_v1 -> fetch_array($sql);
            $prod_dim = array();
            $new_prod_dim = "";
            if (!empty($dim_list)){
              foreach ($dim_list as $k3 => $v3){
                $prod_dim[$v3["prod_dim_id"]] = strip_tags($v3["title"]);
              }
              $new_prod_dim = implode('-',$prod_dim);// 型號
            }
            $enabled = intval($v2["status"]);
            $sql = "insert into supplier_prod_standard (prod_id,supplier_id,title,enabled)
                                                values ('{$prod_id}','{$supplier_id}','{$new_prod_dim}','{$enabled}') 
                    returning prod_standard_id";
            $new_dim_id = $this -> db_v3 -> fetch_array($sql);
            $new_dim = intval($new_dim_id[0]["prod_standard_id"]);
            if ($new_dim > 0){
              foreach ($fee_array as $k4 => $v4){// default prod fee
                switch ($k4){
                  case 1 :
                    $fee = intval($v2["market_price"]);
                  break;
                  case 2 :
                    $fee = intval($v2["price"]);
                  break;
                  case 3 :
                    $fee = 0;
                  break;
                  case 4 :
                    $fee = 0;
                  break;
                  case 5 :
                    $fee = intval($v2["commission"]);
                  break;
                }
                $sql = "insert into supplier_prod_fee_setting2 (prod_id,supplier_id,fee_id,fee,types1,enabled)
                                                        values ('{$prod_id}','{$supplier_id}','{$k4}','{$fee}','{$new_dim}','{$enabled}')";
                $this -> db_v3 -> execute($sql);
              }
              $stock_qty = intval($v2["srq"]);
              $sql = "insert into supplier_prod_stock (prod_id,supplier_id,types1,stock_qty,enabled)
                                               values ('{$prod_id}','{$supplier_id}','{$new_dim}','{$stock_qty}','{$enabled}')";
              $this -> db_v3 -> execute($sql);
            }
          } 
        }
      }
    }
    echo $supplier_id." end :".date("Y-m-d H:i:s")."\n";
  }
  public function set_V3_supplier_supplier_prod_category_setting($data){
    /*$supplier_id = intval($data["supplier_id"]);
    echo $supplier_id." start :".date("Y-m-d H:i:s")."\n";
    $sql = "select * from prod where supplier_id = '{$supplier_id}'";
    $prod = $this -> db_v1 -> fetch_array($sql);
    if (!empty($prod)){
      foreach ($prod as $ka => $va){
        $sql = "";
      }
    }*/
  } 
}
$supplier = new import_supplier;
$supplier -> get_V1_SupplerData($sn = 0,$limit = 10000);
?>
