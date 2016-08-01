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
    $this -> get_AddressMappingData();
  }
  public function get_AddressMappingData(){
    $sql = "select id,name,disabled from country_state order by id";
    $rs = $this -> db_v1 -> fetch_array($sql);
    foreach ($rs as $key => $val){
      $enabled = 1;
      if (intval($val["disabled"]) == 1){
        $enabled = 0;
      }
      $this -> state_mapping[$val["id"]] = $val["name"];
      $state_name = $val["name"];
      $sql = "insert into system_address_state_list (state_name,enabled)
                                             values ('{$state_name}','{$enabled}')";
      //$this -> db_v3 -> execute($sql);
    }
    $sql = "select id,name,country_state_id,postcode from country_city order by id";
    $rs = $this -> db_v1 -> fetch_array($sql);
    foreach ($rs as $key => $val){
      $this -> city_mapping[$val["id"]]["city"] = $val["name"];
      $this -> city_mapping[$val["id"]]["postcode"] = $val["postcode"];
      $state_id = intval($val["country_state_id"]);
      $city_name = $val["name"];
      $postcode = $val["postcode"];
      $sql = "insert into system_address_city_list (state_id,city_name,postcode)
                                             values ('{$state_id}','{$city_name}','{$postcode}')";
      //$this -> db_v3 -> execute($sql);
    }
  }
  public function get_V1_MemberData($sn = 0,$limit = 1){
    $sql = "select * from member 
            where member_id > '{$sn}' 
            order by member_id 
            limit {$limit} ";
    $rs = $this -> db_v1 -> fetch_array($sql);
    if (!empty($rs)){
      $this -> set_V3_Member_data($rs);
    }
    //$this -> setSystemBoard();
  }
  private function set_V3_Member_data($data){
    if (!empty($data)){
      foreach ($data as $key => $val){
        //$this -> set_V3_member($val);
        $this -> set_V3_member_profile($val);
        //$this -> set_V3_member_verified($val);
        //$this -> get_V1_StoreData($val);
        //$this -> set_V3_member_payment_account($val);
      }
    }
  }
  private function set_V3_member_payment_account($data){
    $member_id = intval($data["member_id"]);
    $sql = "select * from member_account where member_id = '{$member_id}'";
    $rs = $this -> db_v1 -> fetch_one($sql);
    if (!empty($rs)){
      $account_type_id = 1;
      $johopay_upgrade = intval($rs["upgrade_account"]);
      $ct = $rs['ct'];
      $account = trim($rs['account']);
      $upgrade_day = $rs['upgrade_day'];
      if (!empty($upgrade_day)){
        $sql = "update member_verified
                set johopay_upgrade_verified = 1,
                    johopay_upgrade_verified_time = '{$upgrade_day}'
                where member_id = '{$member_id}'";
        $this -> db_v3 -> execute($sql);
      }
      if (!empty($account) && intval(substr($account,0,1)) != 8){
        $account_type_id = 2;
      }
      $sql = "insert into member_commission_account (member_id,account_type_id,
                                                     account,johopay_upgrade,ct)
                                             values ('{$member_id}','{$account_type_id}',
                                                   '{$account}','{$johopay_upgrade}','{$ct}')";
      $this -> db_v3 -> execute($sql);
    }
  }
  private function setSystemBoard(){
    //admin_system_announcement
    $sql = "select * 
            from system_alert ";
    $rs = $this -> db_v1 -> fetch_array($sql);
    foreach ($rs as $ka => $va){
      $title = strip_tags($va["title"]);
      $profile = str_replace("</pre>","",str_replace("<pre>","",$va["content"]));
      $ct = date("Y-m-d H:i:s",strtotime($va["ct"])); 
      $sql = "insert into admin_system_announcement (title,profile,ct)
                                             values ('{$title}','{$profile}','{$ct}')";
      $this -> db_v3 -> execute($sql);
    }
  }
  private function get_V1_StoreData($data){
    $member_id = intval($data["member_id"]);
    $sql = "select store.store_id,
                   store.logo,
                   store.member_id,
                   store.ct, 
                   store_domain.domain_name,
                   store.seo_title,
                   store.seo_description
            from store 
            left join store_domain on (store.store_id = store_domain.store_id)
            where store.member_id = '{$member_id}'";
    $rs = $this -> db_v1 -> fetch_array($sql);
    if (!empty($rs)){
      $this -> set_V3_member_store_basic_setting($rs);
      //$this -> set_V3_member_store_prod_setting($rs);
    }
  }
  private function set_V3_member_store_prod_setting($data){
    $member_id = intval($data[0]["member_id"]);
    $store_id = intval($data[0]["store_id"]);
    $sql = "select prod_id,
                   pos
            from store_prod 
            where store_id = '{$store_id}' 
            order by pos";
    $rs = $this -> db_v1 -> fetch_array($sql);
    if (!empty($rs)){
      foreach ($rs as $key => $val){
        $sql = "insert into member_store_prod_setting (member_id,store_id,prod_id,sort)
                                               values ('{$member_id}','{$store_id}','{$val["prod_id"]}','{$val["pos"]}')";
        //$this -> db_v3 -> execute($sql); 
      }
    }
  }
  private function set_V3_member_store_basic_setting($data){
    $member_id = intval($data[0]["member_id"]);
    $store_id = intval($data[0]["store_id"]);
    $uuids = explode(".",strtolower($data[0]["domain_name"]));
    $uuid = $uuids[0];
    $store_domain = strtolower($data[0]["domain_name"]);
    $store_logo = "johomy.jpg";
    $store_keyword = str_replace("'","",strip_tags(trim($data[0]["seo_title"])));
    $store_descripton = str_replace("'","",strip_tags(trim($data[0]["seo_description"])));
    $old_logo = "";
    if (!empty($data[0]["logo"])){
      //$logos = explode("/",$data[0]["logo"]);
      //$store_logo = $logos[1];
      $old_logo = $data[0]["logo"];
      $url = 'https://img.johomy.com.tw/store/logo/'.$data[0]["logo"];
      $img_path = "/var/www/johomy/uploads/logo/";
      $file_name = "store_".$member_id."_".$store_id.".jpg";
      $save_path = $img_path."/".$file_name;
      if (!file_exists($save_path)){
        $contents = file_get_contents($url);
        file_put_contents($save_path,$contents);
      }
      $store_logo = $file_name;
    }
    $sql = "insert into member_store_basic_setting (store_id,member_id,uuid,store_domain,
                                                    store_logo,store_keyword,store_descripton,old_logo)
                                            values ('{$store_id}','{$member_id}','{$uuid}',
                                                    '{$store_domain}','{$store_logo}','{$store_keyword}','{$store_descripton}','{$old_logo}')";
    $this -> db_v3 -> execute($sql); 
  }
  private function set_V3_member($data){
    $member_id = intval($data["member_id"]);
    $account = $data["uuid"];
    $password = $data["passwd"];
    $email = $data["email"];
    $fb_id = $data["fbid"];
    $ct = $data["ct"];
    $types_id = 5;
    switch (intval($data["types"])){
      case 9 :
        $types_id = 2;
      break;
    }
    $sql = "insert into member (member_id,uuid,password,email,fb_id,types_id,ct)
                        values ('{$member_id}','{$account}',
                                '{$password}','{$email}',
                                '{$fb_id}','{$types_id}','{$ct}')";
    //$this -> db_v3 -> execute($sql);
  }
  private function set_V3_member_profile($data){
    $member_id = intval($data["member_id"]);
    $roc_id = strtoupper(trim($data["roc_id"]));
    $realname = trim($data["realname"]);
    $gender = intval($data["gender"]); // 1 man 2 woman
    $postcode = "";
    if (!empty($data["postcalcode"])){
      $postcode = intval($data["postcalcode"]);
    } else {
      if (!empty($this -> city_mapping[$data["city_id"]]["postcode"])){
        $postcode = $this -> city_mapping[$data["city_id"]]["postcode"];
      }
    }
    $address = "";
    /*if (!empty($postcode)){
      $address .= $postcode;
    }*/
    $state_id = $data["state_id"];
    /*if (!empty($this -> state_mapping[$data["state_id"]])){
      $address .= $this -> state_mapping[$data["state_id"]];
    }*/
    $city_id = $data["city_id"];
    /*if (!empty($this -> city_mapping[$data["city_id"]]["city"])){
      $address .= $this -> city_mapping[$data["city_id"]]["city"];
    }*/
    $address .= trim($data["address"]);
    $address = str_replace("'","",$address);
    $mobile = trim($data["mobile"]);
    $tel = trim($data["tel"]);
    $edm_enabled = intval($data["send_edm"]);
    $reference_enabled = intval($data["accept_reference"]);
    $share_facebook = intval($data["share_fb"]);
    $share_email = intval($data["share_email"]);
    $accepted_platform_policy = 1;
    $is_foreigner = 0;
    $is_legal_person = 0;
    $is_auto_assign = intval($data["auto_assign"]);
    switch (intval($data["types"])){
      case 1 :
        $is_foreigner = 1;
      break;
      case 3 :
        $is_legal_person = 1;
      break;
    }
    $ct = $data["ct"];
    $sql = "insert into member_profile (member_id,roc_id,realname,
                                        gender,mobile,tel,
                                        edm_enabled,reference_enabled,share_facebook,
                                        share_email,accepted_platform_policy,is_foreigner,
                                        is_legal_person,is_auto_assign,
                                        postcode,state_id,city_id,address,ct)
                                values ('{$member_id}','{$roc_id}','{$realname}',
                                        '{$gender}','{$mobile}','{$tel}',
                                        '{$edm_enabled}','{$reference_enabled}','{$share_facebook}',
                                        '{$share_email}','{$accepted_platform_policy}','{$is_foreigner}',
                                        '{$is_legal_person}','{$is_auto_assign}',
                                        '{$postcode}','{$state_id}','{$city_id}','{$address}','{$ct}')";
    $this -> db_v3 -> execute($sql);
    if (!empty($data["birthday"])){
      $sql = "update member_profile 
              set birthday = '{$data["birthday"]}' 
              where member_id = '{$member_id}'";
      $this -> db_v3 -> execute($sql);
    }
    if (!empty($data["passport_no"])){
      $sql = "update member_profile
              set passport_no = '{$data["passport_no"]}',
                  passport_expiry_date = '{$data["date_of_expiry"]}'
              where member_id = '{$member_id}'";
      $this -> db_v3 -> execute($sql);
    }
  }
  private function set_V3_member_verified($data){
    $member_id = intval($data["member_id"]);
    $reference_verified = 1;
    $reference_verified_time = $data["ct"];
    $johopay_verified = intval($data["verified"]);
    $johopay_verified_time = 'NULL';
    if (!empty($data["verified_time"])){
      $johopay_verified_time = "'".$data["verified_time"]."'";
    }
    $open_store = 1;
    $open_store_time = $data["ct"];
    $sql = "insert into member_verified (member_id,reference_verified,reference_verified_time,
                                         johopay_verified,johopay_verified_time,open_store,
                                         open_store_time)
                                 values ('{$member_id}','{$reference_verified}','{$reference_verified_time}',
                                         '{$johopay_verified}',{$johopay_verified_time},'{$open_store}',
                                         '{$open_store_time}')";
    //$this -> db_v3 -> execute($sql);
  }
}
$member = new import_member; 
$member -> get_V1_MemberData($sn = 0,$limit = 10000);
?>
