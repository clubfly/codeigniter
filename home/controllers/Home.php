<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
  public function __construct(){
    parent::__construct();
  } 
  public function index(){
    $web_content = array();
    $common_setting = $this -> Workflow_headerfooter -> setStoreHeaderAndFooter("store_index",1);
    $this -> load -> model("Workflow_indexcontent");
    $index_content = $this -> Workflow_indexcontent -> getIndexADS();
    $web_content = array_merge($web_content,$common_setting,$index_content);
    $this -> smarty -> view('store_index.tpl',$web_content);
  }
}
