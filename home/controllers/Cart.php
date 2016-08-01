<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this -> load -> model('Workflow_shopcart');
  }
  public function setCart(){
  }
  public function getCart(){
  }
}
