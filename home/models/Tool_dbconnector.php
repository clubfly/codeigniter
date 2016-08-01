<?php
class Tool_dbconnector extends CI_Model{
  public function __construct(){
    parent::__construct();
  }
  public function queryData($sql = null,$fields = array(),$IUD = 0,$return_insert_id = 0){
    if (!empty($sql)){
      $rs = $this -> db -> query($sql,$fields);
      if ($IUD){
        return $this -> db -> affected_rows();
      } else {
        if ($return_insert_id){
          return $this -> db -> insert_id();;
        }
        return $rs -> result_array();
      }
    }
  }
}
?>
