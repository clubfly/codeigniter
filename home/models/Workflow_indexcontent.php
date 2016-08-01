<?php
class Workflow_indexcontent extends CI_Model{
  public function __construct(){
    parent::__construct();
  }
  public function getIndexADS(){
    $adlist = $this -> Database_home -> getADS();
    $ad_block = array();
    $commerce_path = $this -> config -> item("commerce_path");
    $prod_img_path = $this -> config -> item("prod_img_path");
    $prod_img_suffix = $this -> config -> item("prod_img_suffix");
    if (!empty($adlist)){
      foreach ($adlist as $k1 => $v1){
        $ad_block[$v1["block_id"]][] = $v1;
      }
    }
    //echo "<pre>";print_r($ad_block);exit;
    return array(
                 "ad_block" => $ad_block,
                 "commerce_path" => $commerce_path,
                 "prod_img_path" => $prod_img_path,
                 "prod_img_suffix" => $prod_img_suffix
                );
  }
}
