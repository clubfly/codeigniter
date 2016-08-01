<?php
class Workflow_prodcontent extends CI_Model{
  public function __construct(){
    parent::__construct();
  }
  public function getProdByCategorySubID($category_sub_id = 0){
    $search_list = $this -> Database_prod -> getCategoryProdList(array(
                                                                       "category_sub_id" => $category_sub_id,
                                                                       "status" => 0
                                                                      )
                                                                );
    $commerce_path = $this -> config -> item("commerce_path");
    $prod_img_path = $this -> config -> item("prod_img_path");
    $prod_img_suffix = $this -> config -> item("prod_img_suffix");
    $search_titles = $this -> Database_prod -> getCategoryName(array("category_sub_id" => $category_sub_id));
    $search_title = "";
    if (!empty($search_titles)){
      $search_title = $search_titles[0]["category_name"]." > ".$search_titles[0]["sub_category_name"];
    }
    return array(
                 "search_list" => $search_list,
                 "commerce_path" => $commerce_path,
                 "prod_img_path" => $prod_img_path,
                 "prod_img_suffix" => $prod_img_suffix,
                 "search_title" => $search_title
                );
  }
  public function getProdByProdID($prod_id = 0){
    $search_list = array();
    $prod_list = $this -> Database_prod -> getProdByID(array(
                                                             "prod_id" => $prod_id,
                                                             "status" => 0
                                                            )
                                                      );
    if (!empty($prod_list)){
      $prod_model = $this -> Database_prod -> getProdModelByID(
                                                               array("prod_id" => $prod_id)
                                                              );
    }
    //echo "<pre>";print_r($prod_list);print_r($prod_model);exit;
    $search_list["prod_info"] = $prod_list[0];
    $search_list["prod_model"] = $prod_model;
    $commerce_path = $this -> config -> item("commerce_path");
    $prod_img_path = $this -> config -> item("prod_img_path");
    $prod_img_suffix = $this -> config -> item("prod_img_suffix");
    $search_title = "";
    return array(
                 "search_list" => $search_list,
                 "commerce_path" => $commerce_path,
                 "prod_img_path" => $prod_img_path,
                 "prod_img_suffix" => $prod_img_suffix,
                 "search_title" => $search_title
                );
  }
  public function getProdByKeywords($keywords = ""){
    $search_list = $this -> Database_prod -> getKeywordsProdList(array(
                                                                       "keywords" => strtolower(urldecode($keywords)),
                                                                       "status" => 0
                                                                      )
                                                                );
    $commerce_path = $this -> config -> item("commerce_path");
    $prod_img_path = $this -> config -> item("prod_img_path");
    $prod_img_suffix = $this -> config -> item("prod_img_suffix");
    $search_title = $this-> smarty -> getTemplateVars('search_text')." > ".urldecode($keywords);
    return array(
                 "search_list" => $search_list,
                 "commerce_path" => $commerce_path,
                 "prod_img_path" => $prod_img_path,
                 "prod_img_suffix" => $prod_img_suffix,
                 "search_title" => $search_title
                );
  }
}
