<?php
/**
 * 2016 OkadShop
 * Open source ecommerce software
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OKADshop <contact@okadshop.com>
 * @copyright 2016 OKADshop
 */
namespace Core\Controllers\Front;

use Core\Image;
use Core\i18n\Language;
use Core\Database\Database;

use Core\Models\Admin\Product;

class ProductController extends FrontController
{



    /**
     * Table int
     * @var Table $table
     */
    protected $table = "products";



    /**
     *=============================================================
     * GET PRODUCT DATA
     *=============================================================
     * @param $id_product int
     * @return $results (array)
     * @throws Exception
     */
    public function getProduct($id_product, $id_lang=null)
    {
        if( !is_numeric($id_product) ) return false;
        $model = new Product();
        return $model->getByID($id_product, $id_lang=null);
    }


    /**
     *=============================================================
     * MIGRATE ONE PRODUCT TRANSLATION
     *=============================================================
     * @param array $product_data
     * @return object $translation
     */
    public function migrateProduct($product_data=array(), $id_lang=null){
        //return if no data
        if( is_empty($product_data) )
            return false;

        //set id lang
        if( is_null($id_lang) )
            $id_lang = Language::getLanguage()->id;

        //check if translation exist
        $translation = $this->db->prepare("SELECT * FROM {$this->prefix}lang_product WHERE id_product = ? AND id_lang = ?", [$product_data->id, $id_lang], true);

        //replace translations
        if( !is_empty($translation) ){
            if( $translation->name !== '' ) $product_data->name = $translation->name;
            if( $translation->permalink !== '' ) $product_data->permalink = $translation->permalink;
            if( $translation->short_description !== '' ) $product_data->short_description = $translation->short_description;
            if( $translation->long_description !== '' ) $product_data->long_description = $translation->long_description;
            if( $translation->meta_title !== '' ) $product_data->meta_title = $translation->meta_title;
            if( $translation->meta_description !== '' ) $product_data->meta_description = $translation->meta_description;
            if( $translation->meta_keywords !== '' ) $product_data->meta_keywords = $translation->meta_keywords;
        }

        return (object) $product_data;
    }



    /**
     *=============================================================
     * GET PRODUCTS DATA
     *=============================================================
     * @param $params array
     * @return $results (array)
     * @throws Exception
     */
    public function getProducts($params = array(),$LIMIT = null)
    {
        if( !is_array($params) )
          return false;

        try {
            $CONDITION = "";
            foreach ($params as $key => $value) {
                $CONDITION .= " ".$key ." = ". $value." AND";
            }
            if (!empty($CONDITION)) {
                //$CONDITION = " WHERE" . rtrim($CONDITION,"AND");
                $CONDITION = " WHERE" . $CONDITION . " active = 1";
            }

            $query = "SELECT * FROM `{$this->db->prefix}$this->table` $CONDITION";
            
            if ($LIMIT != null && is_numeric($LIMIT)) {
                $query .= " LIMIT $LIMIT";
            }


            //product data
            return $products = $this->db->query($query);
        } catch (ControllerException $e) {
          $this->getException($e);
        }
    }

    public function getProductOrders($LIMIT=null)
    {
        $model = new Product();
        try {
             
             
            $query = "SELECT id FROM `{$this->db->prefix}$this->table` 
                    WHERE id in ( SELECT id_product FROM `{$this->db->prefix}order_detail` ORDER BY cdate DESC  )";
            
            if ($LIMIT != null && is_numeric($LIMIT)) {
                $query .= " LIMIT $LIMIT";
            }

 
            //product data
            $products = $this->db->query($query);
            $tmp = array();
            foreach ($products as $key => $product) {
                $res =  $model->getByID( $product->id );
                if ($res) {
                   $tmp[] = $res;
                }
            }
            return (object) $tmp;

        } catch (ControllerException $e) {
          $this->getException($e);
        }

    }

    public function getProductsByCondition($params = array(),$custom_condition = "",$LIMIT = null)
    {
        if( !is_array($params) )
          return false;
        $model = new Product();
        

        try {
            $CONDITION = "";
            foreach ($params as $key => $value) {
                $CONDITION .= " ".$key ." = ". $value." AND";
            }
            if (!empty($CONDITION)) {
                //$CONDITION = " WHERE" . rtrim($CONDITION,"AND");
                $CONDITION = " WHERE" . $CONDITION . " active = 1 ". $custom_condition;
            }else{
                $CONDITION = " WHERE active = 1 ". $custom_condition;
            }

            $query = "SELECT id FROM `{$this->db->prefix}$this->table` $CONDITION";
            
            if ($LIMIT != null && is_numeric($LIMIT)) {
                $query .= " LIMIT $LIMIT";
            }
 
            //product data
            $products = $this->db->query($query);
            $tmp = array();
            foreach ($products as $key => $product) {
                $tmp[] = $model->getByID( $product->id );
            }
            return (object) $tmp;

        } catch (ControllerException $e) {
          $this->getException($e);
        }
    }




    public function allProduct()
    {
         
        try {
             $model = new Product();
        
            $products = $this->db->query("SELECT * FROM " . $this->prefix . $this->table . " WHERE active = 1");
            if( !is_empty($products) ){
                

                foreach ($products as $key => $value) {
                    $product = $model->getByID($value->id);
                    $value->url = "product/".$value->id;
                    if (!is_empty($product->link_rewrite)) {
                         $value->url .= "-".$product->link_rewrite;
                    }
                    $value->product = $product;
                }

                return $products;
            }

            return false;

        } catch (ControllerException $e) {
          $this->getException($e);
        }
    }


    /**
     *==============================================
     * GET PRODUCT DISCOUNT
     *==============================================
     * @param $price (float)
     * @param $discount (float)
     * @param $discount_type (int)
     * @throws Exception
     */
    public static function getDiscount($price, $discount, $discount_type=0){
        //if discount or price small than 0
        if( $discount <= 0 || $price <= 0 )
            return 0;

        $price = floatval($price);
        $discount = floatval($discount);

        //get discount value
        if( intval($discount_type) == 0 ){
            return ($price / $discount) / 100 ;
        } else {
            return $discount;
        }
    }



    /**
     *=============================================================
     * GET PRODUCT DECLINAISONS
     *=============================================================
     * @param int $id_product
     * @return $results (array)
     * @throws Exception
     */
    public function getDeclinaisons($id_product){
        try{

            $results = array();

            $attributes =  $this->db->query("
                SELECT DISTINCT a.id, a.name 
                FROM `{$this->db->prefix}attributes` a, `{$this->db->prefix}product_declinaisons` pd , `{$this->db->prefix}declinaisons` d 
                WHERE  a.`id` = pd.id_attribute  AND d.id = pd.id_declinaison 
                AND d.id_product = {$id_product}
            ");

            if( !empty($attributes) ){
                foreach ($attributes as $key => $attribute) {
                    $values =  $this->db->query("
                        SELECT DISTINCT av.id, av.name 
                        FROM `{$this->db->prefix}attribute_values` av, `{$this->db->prefix}product_declinaisons` pd , `{$this->db->prefix}declinaisons` d 
                        WHERE  av.`id` = pd.id_value  AND d.id = pd.id_declinaison 
                        AND d.id_product = {$id_product} AND pd.id_attribute = {$attribute->id}
                    ");

                    //push results
                    $results[] = (object) array(
                        "attribute" => $attribute,
                        "values" => (object) $values,
                    );
                }
            }

            return (object) $results;
         
        } catch (Exception $e) {
            $this->getException($e);
        }
    }



    /**
     *=============================================================
     * GET COMBINATION BY ID
     *=============================================================
     * @param int $id_combination
     * @return $results (array)
     * @throws Exception
     */
    public function getCombinationByID($id_product, $id_combination){
        try{
            $results = new \stdClass;

            $comb = $this->db->prepare("SELECT c.`id` as id_dec, c.`price`, c.`price_impact`, c.`quantity`, c.`images`, p.`id` as id_product, p.`sell_price`, p.`discount`, p.`discount_type`, t.`name`, t.`link_rewrite` FROM `{$this->db->prefix}declinaisons` c
                LEFT JOIN `{$this->db->prefix}products` p ON c.id_product = p.id
                LEFT JOIN `{$this->db->prefix}product_trans` t ON t.id_product = p.id
                WHERE c.`id` = ?", [$id_combination], true);

            if( $comb ){

                $results->id_product = $comb->id_product;
                $results->id_dec = $comb->id_dec;
                $results->name = $comb->name;
                $results->discount = $comb->discount;


                //price impact
                if( $comb->price_impact == "1" ){
                    $results->price = ($comb->sell_price + $comb->price);
                } elseif( $comb->price_impact == "2" ){
                    $results->price = ($comb->sell_price - $comb->price);
                } else {
                    $results->price = $comb->sell_price;
                }

                //price discount
                if( floatval($comb->discount) > 0 ){
                    $discount = self::getDiscount($results->price, $comb->discount, $comb->discount_type);
                    $results->price = format_price($results->price - $discount);
                }

                //get image url
                if( $comb->images !== '' ){
                    $images = json_decode($comb->images, true);
                    $imageDir = 'files/products/' . $id_product . '/';
                    $results->cover = Image::getImageBySize($images[0], $imageDir, '100x122');
                }

                $dec = $this->db->prepare("SELECT a.`name` as attribute, v.`name` as value
                    FROM `{$this->db->prefix}product_declinaisons` pd
                    LEFT JOIN `{$this->db->prefix}attributes` a ON pd.id_attribute = a.id
                    LEFT JOIN `{$this->db->prefix}attribute_values` v ON pd.id_value = v.id
                    WHERE pd.`id_declinaison` = ?", [$id_combination]);//CONCAT(a.`name`, ': ', v.`name`) as attrs

                if( !is_empty($dec) ){
                    foreach ($dec as $k => $v) {
                        $results->attrs[$v->attribute] = $v->value;
                    }
                }

                //items in stock
                $results->stock = $comb->quantity;
                $results->link = get_shop('home_url') . 'product/' .$id_product . '-' .$comb->link_rewrite;
            }

            return $results;
         
        } catch (Exception $e) {
            $this->getException($e);
        }
    }



    /**
     *=============================================================
     * GET PRODUCT FEATURES
     *=============================================================
     * @param int $id_product
     * @param int $id_lang
     * @return $results (array)
     * @throws Exception
     */
    function getFeatures($id_product, $id_lang=null){
        if( is_null($id_lang) ){
            $id_lang = \get_lang()->id;
        }
        $res = $this->db->query("
            SELECT ft.name, fvt.value 
            FROM `{$this->db->prefix}feature_product` fp,`{$this->db->prefix}feature_trans` ft, `{$this->db->prefix}feature_value_trans` fvt 
            WHERE fp.id_feature = ft.id_feature AND fp.id_feature_value = fvt.id_value  AND ft.id_lang = {$id_lang}
            AND fvt.id_lang = {$id_lang} AND fp.`id_product` = $id_product AND fp.custom = ''
        ");

        $res2 = $this->db->query("
            SELECT ft.name, fp.custom as value 
            FROM `{$this->db->prefix}feature_product` fp,`{$this->db->prefix}feature_trans` ft
            WHERE fp.id_feature = ft.id_feature AND ft.id_lang = $id_lang AND fp.custom !=  '' AND fp.`id_product` = $id_product
        ");

        return (object)array_merge((array)$res, (array)$res2);
    }


    /**
     *=============================================================
     * GET COMBINATIONS
     *=============================================================
     * @param $id_product int
     * @param $attr_values array 
     * EXEMPLE array(1 => 5, 3 => 7) WHERE 1 IS id_attribute AND 5 IS id_value
     * @return $declinaisons array
     * @throws Exception
     */
    public function getCombinations($id_product, $attr_values=array()){
        try {
            if( !is_numeric($id_product) || empty($attr_values))
            return false;

            $comb = new \stdClass;
            $decCount = count($attr_values);
            $attributes = implode(",", array_keys($attr_values));
            $values = implode(",", $attr_values);

            $result = $this->db->query("
                SELECT p.`sell_price`, p.`discount`, p.`discount_type`, d.`id`, d.`quantity`, d.`min_quantity`, d.`price_impact`, d.`price`, d.`available_date`, d.`images`, COUNT(*) as counted
                FROM `{$this->db->prefix}declinaisons` d
                LEFT JOIN `{$this->db->prefix}product_declinaisons` pd ON pd.`id_declinaison` = d.`id`
                LEFT JOIN `{$this->db->prefix}products` p ON d.`id_product` = p.`id`
                WHERE pd.`id_value` IN($values) AND pd.`id_attribute` IN($attributes) AND d.`id_product`=$id_product
                GROUP BY pd.`id_declinaison` HAVING COUNT(*) = $decCount LIMIT 1
            ", true);//p.`name`, 


            if( !is_empty($result) ){
                $comb->id = $result->id;
                //$comb->name = $result->name;
                $comb->quantity = $result->quantity;
                $comb->min_quantity = $result->min_quantity;

                //price impact
                if( $result->price_impact == "1" ){
                    $comb->price = ($result->sell_price + $result->price);
                } elseif( $result->price_impact == "2" ){
                    $comb->price = ($result->sell_price - $result->price);
                } else {
                    $comb->price = $result->sell_price;
                }

                //price discount
                if( floatval($result->discount) > 0 ){
                    $discount = self::getDiscount($comb->price, $result->discount, $result->discount_type);
                    $comb->price = format_price($comb->price - $discount);
                }
                
                $comb->available_date = $result->available_date;
                $comb->images = $result->images;
                return $comb;
            }

            return false;

        } catch (Exception $e) {
            $this->getException($e);
        }
    }


    /**
     *=============================================================
     * GET PRODUCT TAGS
     *=============================================================
     * @param int $id_product
     * @return $tag_array (array)
     * @throws Exception
     */
    public function getTags($id_product)
    {
        return $this->db->query("
            SELECT t.name FROM {$this->db->prefix}tags t 
            INNER JOIN {$this->db->prefix}product_tags pt ON pt.id_tag = t.id 
            WHERE pt.id_product=$id_product
        ");
    }


    /**
     *=============================================================
     * GET ATTREBUTE VALUES
     *=============================================================
     * @param array $args
     * @return $attributes_value (array)
     * @throws Exception
     */
    public function getAttributeValues($args)
    {
      $query = "SELECT * FROM {$this->db->prefix}attribute_values";
      if (!is_empty($args) && is_array($args)) {
        $CONDITION = "";
        foreach ($args as $key => $value) {
          # code...
        }
      }
      return $this->db->query($query);
    }

    /**
     *=============================================================
     * GET PRODUCT attachements
     *=============================================================
     * @param int $id_product
     * @return $attachements_array (array)
     * @throws Exception
     */
    public function getAttachements($id_product)
    {
        $res = $this->db->query("
            SELECT * FROM {$this->db->prefix}product_attachments pa 
            WHERE pa.id_product=$id_product
        ");
        foreach ($res as $key => $value) {
          $value->link = site_url('files/attachments/'. $value->id_product .'/'. $value->attachment);
        }
        return $res;
    }




    /**
     *=============================================================
     * GET PRODUCT IMAGES
     *=============================================================
     * @param int $id_product
     * @return $data (array)
     * @throws Exception
     */
    // public function getImages($id_product)
    // {
    //     return $this->db->query("SELECT id, name, position, futured FROM {$this->db->prefix}product_images WHERE id_product=$id_product ORDER BY position ASC");
    // }


    /**
     *=============================================================
     * GET PRODUCT IMAGES
     *=============================================================
     * @param int $id_product
     * @return $images (array)
     * @throws Exception
     */
    public function getImages($id_product)
    {
        if( !is_numeric($id_product) )
            return false;
        
        return $this->db->prepare("SELECT id, name, position, futured FROM {$this->db->prefix}product_images WHERE id_product = ? ORDER BY position ASC", [$id_product]);
    }


    /**
     *=============================================================
     * GET PRODUCT COVER IMAGE
     *=============================================================
     * @param int $id_product
     * @return $data (array)
     * @throws Exception
     */
    public static function getCover($id_product, $size='76x76')
    {
        if( !is_numeric($id_product) )
            return false;

        $db = Database::getInstance();
        $cover = $db->query("SELECT id, name FROM {$db->prefix}product_images WHERE id_product=$id_product AND futured=1", true);
        if( isset($cover->name) && $cover->name != '' ){
            $imageDir = 'files/products/' . $id_product . '/';
            $image_url = Image::getImageBySize($cover->name, $imageDir, $size);
            return $image_url;
        }

        return Image::defaultImage($size);
    }


    


    /**
     *=============================================================
     * RESIZE PRODUCT IMAGE
     *=============================================================
     * @param int $id_product
     * @param int $size
     * @return boolean
     * @throws Exception
     */
    public function resizeProductImages($id_product, $size=array('360x360'))
    {
        if( !is_numeric($id_product) )
            return false;

        //get product images
        $images = $this->getProductImages($id_product);
        if( !is_empty($images) ){
            foreach ($images as $key => $value) {
                $imageDir = WEBROOT . 'files/products/' . $id_product . '/' . $value->name;
                Image::resizeImage($imageDir, $size);
            }
        }

        return true;
    }


    


	/**
     *=============================================================
     * GET PRODUCT PRICE
     *=============================================================
     * @param int $id
     * @return price float
     */
	public function getPrice($id){
		return $this->db->find($this->table, $id, array('sell_price'));
	}


    /**
     *=============================================================
     * FORMAT PRODUCT PRICE
     *=============================================================
     * @param float $price
     * @param int $after_comma
     * @return formated_price float
     */
    public static function formatPrice($price, $after_comma=2){
        return number_format($price, $after_comma, '.', '');
    }





    







//END CLASS
}