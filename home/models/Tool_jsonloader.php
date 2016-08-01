<?php
class Tool_jsonloader extends CI_Model{
  public function __construct(){
    parent::__construct();
  }
  public function getLoadedFiles($files){
    $ReturnValue = array();
    $content = file_get_contents($files);
    if (!empty($content)){
      $ReturnValue = json_decode($content,1);
    }
    return $ReturnValue;
  }
}
?>
