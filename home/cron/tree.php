<?php
date_default_timezone_set("Asia/Taipei");
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


$db = new DB(0);
$db3 = new DB(1);
$mode = 1;
echo date("Y-m-d H:i:s")." start tree counter \n";
for ($x = $mode; $x < 3; $x++){
  switch ($x){
    case 1:
      $sql = "select member_id,
                     ref_member_id 
              from member 
              where ref_member_id = '0' 
              order by member_id ";// root tree
      $root_tree = $db -> fetch_array($sql);
      foreach ($root_tree as $key => $val){
        $i = 1;
        $data = array(
                      "root_node" => $val["member_id"],
                      "member_id" => $val["member_id"],
                      "level" => $i,
                      "ref_member_id" => $val["ref_member_id"],
                      "child_cnt" => 0,
                      "child_vaild_cnt" => 0
                     );
        insert_tree($db,$db3,$data);
        get_Child($val["member_id"],$val["member_id"],$db,$db3,$i);
      }
    break;
    case 2 :
      $sql = "select member_id,
                     ref_member_id 
              from member 
              where verified = '1' and 
                    enabled = '1' 
              order by member_id";
      $valid_list = $db -> fetch_array($sql);
      $valid_member = array();
      if (!empty($valid_list)){
        foreach ($valid_list as $k => $v){
          $valid_member[$v["member_id"]] = 1;
        }
      }
      $sql = "update member_reference 
              set child_cnt = '0',
                  child_vaild_cnt = '0',
                  account_valid = '0' ";
      $db3 -> execute($sql);
      $sql = "select root_node,
                     level,
                     count(member_id) as total
              from member_reference  
              group by root_node,level
              order by root_node,level ";// final level node
      $root_level_list = $db3 -> fetch_array($sql);
      foreach ($root_level_list as $key => $val){
        $root_level_cnt[$val["root_node"]]["last_level_cnt"] = $val["total"];
        $root_level_cnt[$val["root_node"]]["level"] = $val["level"];
        $root_level_cnt[$val["root_node"]]["root_node"] = $val["root_node"];
      }
      foreach ($root_level_cnt as $ka => $va){
        cnt_member_group($db,$db3,$va,$va["level"],$valid_member);
        recount_member($db,$db3,$va);
        recount_vaild_member($db,$db3,$va);
      }
    break;
  }
}
echo date("Y-m-d H:i:s")." end tree counter \n";
function recount_member($db,$db3,$data = array()){
  $sql = "select root_node,
                 member_id,
                 level,
                 ref_member_id,
                 child_cnt 
          from member_reference
          where root_node = '{$data["root_node"]}'
          order by level desc";
  $get_recount_list = $db3 -> fetch_array($sql);
  if (!empty($get_recount_list)){
    foreach ($get_recount_list as $ka => $va){
      update_parent_child_cnt($db,$db3,$va);
    }
  }
}
function update_parent_child_cnt($db,$db3,$data = array()){
  $sql = "select root_node,
                 member_id,
                 level,
                 ref_member_id,
                 child_cnt 
          from member_reference
          where root_node = '{$data["root_node"]}' and
                member_id = '{$data["member_id"]}'";
  $get_parent_id = $db3 -> fetch_one($sql);
  if (!empty($get_parent_id)){
    $sql = "update member_reference 
            set child_cnt = (child_cnt+1)
            where root_node = '{$data["root_node"]}' and
                  member_id = '{$get_parent_id["ref_member_id"]}'";
    $db3 -> execute($sql);
    update_parent_child_cnt($db,$db3,array(
                                           "root_node" => $data["root_node"],
                                           "member_id" => $get_parent_id["ref_member_id"]
                                          )
                           );
  }
}
function recount_vaild_member($db,$db3,$data = array()){
  $sql = "select root_node,
                 member_id,
                 level,
                 ref_member_id,
                 child_vaild_cnt,
                 account_valid 
          from member_reference 
          where root_node = '{$data["root_node"]}' and
                account_valid > 0
          order by level desc";
  $get_recount_list = $db3 -> fetch_array($sql);
  if (!empty($get_recount_list)){
    foreach ($get_recount_list as $ka => $va){
      update_parent_child_vaild_cnt($db,$db3,$va);
    }
  }
}
function update_parent_child_vaild_cnt($db,$db3,$data = array()){
  $sql = "select root_node,
                 member_id,
                 level,
                 ref_member_id,
                 child_vaild_cnt,
                 account_valid
          from member_reference 
          where root_node = '{$data["root_node"]}' and 
                member_id = '{$data["member_id"]}'";
  $get_parent_id = $db3 -> fetch_one($sql);
  if (!empty($get_parent_id)){
    $sql = "update member_reference 
            set child_vaild_cnt = (child_vaild_cnt+1) 
            where root_node = '{$data["root_node"]}' and
                  member_id = '{$get_parent_id["ref_member_id"]}'";
    $db3 -> execute($sql);
    update_parent_child_vaild_cnt($db,$db3,array(
                                                 "root_node" => $data["root_node"],
                                                 "member_id" => $get_parent_id["ref_member_id"]
                                                )
                                 );
  }
}
function cnt_member_group($db,$db3,$data = array(),$cnt_level = 0,$valid_member = array()){
  if ($cnt_level > 0){
    $sql = "select root_node,
                   member_id,
                   level,
                   ref_member_id,
                   child_cnt,
                   child_vaild_cnt 
            from member_reference  
            where root_node = '{$data["root_node"]}' and 
                  level = '{$cnt_level}'";
    $get_member_list = $db3 -> fetch_array($sql);
    if (!empty($get_member_list)){
      foreach ($get_member_list as $ka => $va){
        if (!empty($valid_member[$va["member_id"]])){
          upd_member_account_valid($db,$db3,$va,1);
        }
      }
    }
    $cnt_level--;
    cnt_member_group($db,$db3,array("root_node" => $data["root_node"]),$cnt_level,$valid_member);  
  }
}
function upd_member_child_cnt($db,$db3,$data = array(),$child_cnt){
  $sql = "update member_reference  
          set child_cnt = '{$child_cnt}' 
          where root_node = '{$data["root_node"]}' and 
                member_id = '{$data["member_id"]}'";
  $db3 -> execute($sql);
}
function upd_member_account_valid($db,$db3,$data = array(),$account_valid){
  $sql = "update member_reference
          set account_valid = '{$account_valid}'
          where root_node = '{$data["root_node"]}' and
                member_id = '{$data["member_id"]}'";
  $db3 -> execute($sql);
}
function get_Child($root_node,$member_id,$db,$db3,$i){
  $i++;
  $sql = "select member_id,
                 ref_member_id
        from member
        where ref_member_id = '{$member_id}'
        order by member_id "; // root tree
  $child_tree = $db -> fetch_array($sql);
  if (!empty($child_tree)){
    foreach ($child_tree as $key => $val){
      $data = array(
                    "root_node" => $root_node,
                    "member_id" => $val["member_id"],
                    "level" => $i,
                    "ref_member_id" => $val["ref_member_id"],
                    "child_cnt" => 0,
                    "child_vaild_cnt" => 0
                   );
      insert_tree($db,$db3,$data);
      get_Child($root_node,$val["member_id"],$db,$db3,$i);
    }
  }
}
function insert_tree($db,$db3,$data = array()){
  $sql = "select member_id from member_reference where member_id = '{$data["member_id"]}' ";
  $rs = $db3 -> fetch_one($sql);
  if (empty($rs)){
    $sql = "insert into member_reference (root_node,member_id,level,ref_member_id,child_cnt,child_vaild_cnt,replace_commission_member_id) 
                             values ('{$data["root_node"]}','{$data["member_id"]}','{$data["level"]}',
                                     '{$data["ref_member_id"]}','{$data["child_cnt"]}','{$data["child_vaild_cnt"]}','{$data["member_id"]}') ";
    $db3 -> execute($sql);
  }
}
?>

