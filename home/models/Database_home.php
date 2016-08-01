<?php
class Database_home extends CI_Model{
  private $fields = array();
  public function __construct(){
    parent::__construct();
  }
  public function getCategoryList($data = array()){
    $this -> fields = array();
    $this -> fields = array($this->config->item('store_id'));
    $sql = "select product_category.category_id,
                   product_category.category_name,
                   product_sub_category.category_sub_id,
                   product_sub_category.sub_category_name
            from product_category
            left join product_sub_category on (product_category.category_id = product_sub_category.category_id)
            where product_category.store_id = ? and 
                  product_category.enabled = 1 and 
                  product_category.disabled = 0 and
                  product_sub_category.enabled = 1 and
                  product_sub_category.disabled = 0 ";
    return $this -> Tool_dbconnector -> queryData($sql,$this -> fields);
  }
  public function getADS($data = array()){
    $this -> fields = array();
    $this -> fields = array($this->config->item('store_id'));
    $sql = "select ad_blocklists.block_id,
                   ad_blocklists.block_name,
                   ad_blocklists.store_id,
                   ad_blocklists.sort_no,
                   ad_blocklists.block_type,
                   ad_blocklists.more_url,
                   ad_blocklists_details.img_files,
                   ad_blocklists_details.url,
                   ad_blocklists_details.prod_id,
                   product.prod_short_name,
                   product.default_marketing_price,
                   product.default_sell_price
            from ad_blocklists
            left join ad_blocklists_details on (ad_blocklists_details.block_id = ad_blocklists.block_id)
            left join product on (ad_blocklists_details.prod_id = product.prod_id)
            where ad_blocklists.store_id = ? and 
                  ad_blocklists.enabled = 1 and 
                  ad_blocklists.disabled = 0 and 
                  ad_blocklists_details.enabled = 1 and 
                  ad_blocklists_details.disabled = 0
            order by ad_blocklists.sort_no";
    return $this -> Tool_dbconnector -> queryData($sql,$this -> fields);
  }
}
?>
