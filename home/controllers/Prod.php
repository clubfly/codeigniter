<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Prod extends CI_Controller {
  private $store_id = 1;
  public function __construct(){
    parent::__construct();
    $this -> load -> model("Workflow_prodcontent");
    $this -> store_id = $this -> config -> item("store_id");
  }
  public function category($category_sub_id = 0){
    $web_content = array();
    $common_setting = $this -> Workflow_headerfooter -> setStoreHeaderAndFooter("prod_list",$this -> store_id);
    $search_content = $this -> Workflow_prodcontent -> getProdByCategorySubID($category_sub_id);
    $web_content = array_merge($web_content,$common_setting,$search_content);
    $this -> smarty -> view('prod_list.tpl',$web_content);
  }
  public function detail($prod_id = 0){
    $web_content = array();
    $common_setting = $this -> Workflow_headerfooter -> setStoreHeaderAndFooter("prod_detail",$this -> store_id,$prod_id);
    $search_content = $this -> Workflow_prodcontent -> getProdByProdID($prod_id);
    $web_content = array_merge($web_content,$common_setting,$search_content);
    $this -> smarty -> view('prod_detail.tpl',$web_content);
  }
  public function search($keywords = ""){
    $web_content = array();
    $common_setting = $this -> Workflow_headerfooter -> setStoreHeaderAndFooter("prod_list",$this -> store_id);
    $search_content = $this -> Workflow_prodcontent -> getProdByKeywords($keywords);
    $web_content = array_merge($web_content,$common_setting,$search_content);
    $this -> smarty -> view('prod_list.tpl',$web_content);
  }
  public function models($prod_id = 0){
    $web_content = array();
    $common_setting = $this -> Workflow_headerfooter -> setStoreHeaderAndFooter("prod_models",$this -> store_id,$prod_id);
    $search_content = $this -> Workflow_prodcontent -> getProdByProdID($prod_id);
    $web_content = array_merge($web_content,$common_setting,$search_content);
    $this -> smarty -> view('prod_models.tpl',$web_content);
  }
}
