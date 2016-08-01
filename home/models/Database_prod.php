<?php
class Database_prod extends CI_Model{
  private $fields = array();
  public function __construct(){
    parent::__construct();
  }
  public function getCategoryName($data = array()){
    $this -> fields = array();
    $this -> fields = array($this->config->item('store_id'),
                            $data["category_sub_id"]
                           );
    $sql = "select product_category.category_id,
                   product_category.category_name,
                   product_sub_category.category_sub_id,
                   product_sub_category.sub_category_name
            from product_category
            left join product_sub_category on (product_sub_category.category_id = product_category.category_id)
            where product_category.enabled = 1 and
                  product_category.disabled = 0 and
                  product_sub_category.enabled = 1 and
                  product_sub_category.disabled = 0 and
                  product_category.store_id = ? and 
                  product_sub_category.category_sub_id = ? ";
    return $this -> Tool_dbconnector -> queryData($sql,$this -> fields);
  }
  public function getCategoryProdList($data = array()){
    $this -> fields = array();
    $this -> fields = array($this->config->item('store_id'),
                            $data["category_sub_id"],
                            $data["status"]
                           );
    $sql = "select product_category.category_name,
                   product_sub_category.sub_category_name,
                   product_category_lists.prod_id,
                   product_category_lists.store_id,
                   product.prod_short_name,
                   product.default_sell_price,
                   product.default_marketing_price,
                   product.priority
            from product_category_lists
            left join product_category on (product_category.category_id = product_category_lists.category_id)
            left join product_sub_category on (product_sub_category.category_sub_id = product_category_lists.category_sub_id) 
            left join product on (product_category_lists.prod_id = product.prod_id)
            where product_category.enabled = 1 and 
                  product_category.disabled = 0 and 
                  product_sub_category.enabled = 1 and
                  product_sub_category.disabled = 0 and
                  product_category_lists.store_id = ? and 
                  product_category_lists.category_sub_id = ? and 
                  product_category_lists.enabled = 1 and
                  product_category_lists.disabled = 0 and 
                  product.status = ? and 
                  product.enabled = 1 and 
                  product.disabled = 0";
    return $this -> Tool_dbconnector -> queryData($sql,$this -> fields);
  }
  public function getKeywordsProdList($data = array()){
    $this -> fields = array();
    $this -> fields = array($this->config->item('store_id'),
                            $data["status"]
                           );
    $sql = "select product.prod_id,
                   product.store_id,
                   product.prod_short_name,
                   product.default_sell_price,
                   product.default_marketing_price,
                   product.priority
            from product
            left join product_profile on (product_profile.prod_id = product.prod_id)
            where product.store_id = ? and
                  (lower(product.prod_name) like '%".$data["keywords"]."%' or 
                   lower(product_profile.seo_keyword) like '%".$data["keywords"]."%' or
                   lower(product_profile.seo_title) like '%".$data["keywords"]."%' or
                   lower(product_profile.commerce_profile) like '%".$data["keywords"]."%' or
                   lower(product_profile.prod_profile) like '%".$data["keywords"]."%' ) and 
                  product.status = ? and
                  product.enabled = 1 and
                  product.disabled = 0";
    return $this -> Tool_dbconnector -> queryData($sql,$this -> fields);
  }
  public function getProdByID($data = array()){
    $this -> fields = array();
    $this -> fields = array($this->config->item('store_id'),
                            $data["prod_id"],
                            $data["status"]
                           );
    $sql = "select product.prod_id,
                   product.store_id,
                   product.prod_name,
                   product.is_adult,
                   product.is_tax,
                   product.is_free_shipping,
                   product.force_deliver_method,
                   product.default_sell_price,
                   product.default_marketing_price,
                   product_profile.seo_keyword,
                   product_profile.seo_description,
                   product_profile.seo_title,
                   product_profile.commerce_profile,
                   product_profile.prod_profile
            from product
            left join product_profile on (product_profile.prod_id = product.prod_id) 
            where product.store_id = ? and 
                  product.prod_id = ? and 
                  product.status = ? and 
                  product.enabled = 1 and 
                  product.disabled = 0 ";
    return $this -> Tool_dbconnector -> queryData($sql,$this -> fields);
  }
  public function getProdModelByID($data = array()){
    $this -> fields = array();
    $this -> fields = array($this->config->item('store_id'),
                            $data["prod_id"]
                           );
    $sql = "select product_models.sn,
                   product_models.store_id,
                   product_models.models_ids,
                   product_models.models_names,
                   product_models.stock_qty,
                   product_models.sell_price,
                   product_models.shipping_price	
            from product_models
            where product_models.store_id = ? and 
                  product_models.prod_id = ? and 
                  product_models.enabled = 1 and 
                  product_models.disabled = 0";
    return $this -> Tool_dbconnector -> queryData($sql,$this -> fields);
  }
}
?>
