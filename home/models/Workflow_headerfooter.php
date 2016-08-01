<?php
class Workflow_headerfooter extends CI_Model{
  public function __construct(){
    parent::__construct();
  }
  public function setStoreHeaderAndFooter($tpl_setting = "",
                                          $store_id = 1,
                                          $prod_id = 0){
    $header_content = array();
    $footer_content = array();
    $style_setting = $this -> getTplSettingFiles("store",$tpl_setting);
    $header_content = $footer_content = $style_setting;
    $category = $this -> Database_home -> getCategoryList();
    $categoryList = array();
    if (!empty($category)){
      foreach ($category as $k1 => $v1){
        $categoryList[$v1["category_id"]][] = $v1;
      }
    }
    $header_content["categoryList"] = $categoryList;
    $header = $this -> smarty -> view ("common/store_header.tpl",$header_content,1);
    $footer_content["prod_id"] = $prod_id;
    $footer = $this -> smarty -> view ("common/footer.tpl",$footer_content,1);
    return array(
                 "store_header" => $header,
                 "footer" => $footer,
                );
  }
  private function getTplSettingFiles($header_footer_types = "",$files_name = ""){
    $ReturnValue = array();
    $style_files = dirname(dirname(__file__))."/config/pages_setting/css_js_setting.json";
    $settings = $this -> Tool_jsonloader -> getLoadedFiles($style_files);
    if (!empty($settings)){
      $ReturnValue = array_merge($ReturnValue,$settings[$files_name]);
      $ReturnValue["css"] = array_merge($settings[$header_footer_types."_header"]["css"],$ReturnValue["css"]);
      $ReturnValue["js"] = array_merge($settings[$header_footer_types."_header"]["js"],$ReturnValue["js"]);
    }
    $language_files = dirname(dirname(__file__))."/config/pages_setting/tch_languages.json";
    $settings = $this -> Tool_jsonloader -> getLoadedFiles($language_files);
    if (!empty($settings)){
      $ReturnValue = array_merge($ReturnValue,$settings[$header_footer_types."_header"]);
      $ReturnValue = array_merge($ReturnValue,$settings["footer"]);
      if (!empty($settings[$files_name])){
        $ReturnValue = array_merge($ReturnValue,$settings[$files_name]);
      }
    }
    $url_files = dirname(dirname(__file__))."/config/pages_setting/pages_url_setting.json";
    $settings = $this -> Tool_jsonloader -> getLoadedFiles($url_files);
    if (!empty($settings)){
      $ReturnValue = array_merge($ReturnValue,$settings);
    }
    return $ReturnValue;
  }
}
