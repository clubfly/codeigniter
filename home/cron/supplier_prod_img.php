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
  }
  public function setProdImages(){
    echo date("Y-m-d H:i:s")." - start \n";
    $img_path = "/var/www/supplier/uploads/supplier/";
    $sql = "select supplier_id
            from supplier
            order by supplier_id";
    $supplier_list = $this -> db_v3 -> fetch_array($sql);
    foreach ($supplier_list as $ka => $va){
      if (!is_dir($img_path.$va["supplier_id"])){
        mkdir($img_path.$va["supplier_id"],0775);
      }
    }
    $sql = "select supplier_id,prod_id 
            from supplier_prod
            where supplier_id = 19 
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
          echo  $save_path,"\n";
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
            //$this -> db_v3 -> execute($sql);
          }
          if (empty($get_data["old_img"])){
            $sql = "update supplier_prod_images
                    set old_img = '{$url}' 
                    where prod_id = '{$prod_id}' and 
                          file_name = '{$file_name}'";
            //$this -> db_v3 -> execute($sql);
          }
        }
      }
    }
    echo date("Y-m-d H:i:s")." - end \n";
  }
}
$supplier = new import_supplier;
$supplier -> setProdImages();
?>
