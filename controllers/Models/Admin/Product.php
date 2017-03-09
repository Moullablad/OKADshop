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
namespace Core\Models\Admin;

use Core\Image;
use Core\Media;
use Core\Session;
use Core\i18n\Language;
use Core\Models\Model;

class Product extends Model
{



    /**
     * Table int
     * @var Table $table
     */
    protected $table = "products";


    /**
     * GET PRODUCTS
     *
     * @return $products
     */
    public function all($condition=null)
    {
        $results = array();
        if( !is_null($condition) ){
            $table = $this->db->prefix . $this->table;
            $products = $this->db->query("SELECT * FROM {$table} {$condition}");
        } else {
            $products = $this->db->all($this->table);
        }
        if( !is_empty($products) ){
            foreach ($products as $key => $product) {
                $results[] = $this->getByID($product->id);
            }
        }
        return $results;
    }

    /**
     * GET PRODUCTS
     *
     * @return $products
     */
    public function allByIds($ids,$limit = null)
    {
        $results = array();
        $sql = "SELECT id FROM {$this->prefix}$this->table WHERE id IN($ids)";
        if ($limit != null) {
            $sql .= " LIMIT $limit";
        }
        $products = $this->db->query($sql);
        if( !is_empty($products) ){
            foreach ($products as $product) {
                $tmp = $this->getByID($product->id);
                if (!is_empty($tmp)) {
                    $results[] = $tmp;
                }
            }
        }
        return $results;
    }
    


    /**
     * GET PRODUCT BY ID
     *
     * @param int $id_product
     * @param int $id_lang
     * @return object $data
     */
    public function getByID($id_product, $id_lang=null, $image_size='76x76'){
        if( !is_numeric($id_product) || $id_product < 1 ) return false;
 
        if( is_null($id_lang) ) $id_lang = Language::getLanguage()->id;

        $condition ='';
        if( !is_admin() ){
            $condition = 'AND p.`active`=1';
        }

        $product = $this->db->prepare("
            SELECT p.*, c.`id` as id_category, c.`permalink` as cat_slug, c.`name` as category FROM `{$this->prefix}products` p LEFT JOIN `{$this->prefix}categories` c ON p.id_category_default=c.id WHERE p.`id`=? $condition", 
            [$id_product], true
        );
        if( is_empty($product) ) return false;

        //get translation
        $default_lang = $product->id_lang;
        $trans = $this->getTrans($id_product, $id_lang, $default_lang);
        $product->discount_value = 0;
        //check if have discount
        $product->old_price = format_price($product->sell_price);
        $product->price_tax_excl = format_price($product->sell_price);
        if( $product->discount > 0 ){
            $discount = percent_to_amount($product->sell_price, $product->discount, $product->discount_type);
            $product->discount_value = $discount;
            $product->sell_price = format_price($product->sell_price - $discount);
        } else {
            $product->sell_price = format_price($product->sell_price);
        }

        //get cover and link
        $product->cover = default_product_image($product->id, $image_size);
        $link_rewrite = (isset($trans->link_rewrite)) ? '-'. $trans->link_rewrite : '';
        // $product->link = get_home_url() . 'product/' . $product->id . $link_rewrite;
        $path = 'product/' . $product->id . $link_rewrite;
        $product->link = generate_url( $path, $id_lang );

        $cat_link = 'category/' . $product->id_category .'-'. $product->cat_slug;
        $product->category_link = generate_url( $cat_link, $id_lang );

        //old version fields
        $product->permalink = (isset($trans->link_rewrite)) ? $trans->link_rewrite : '';
        $product->long_description = (isset($trans->description)) ? $trans->description : '';
        $product->short_description = (isset($trans->excerpt)) ? $trans->excerpt : '';
        $product->qty = $product->quantity;

        //remove fields
        unset($trans->id);

        return (object) array_merge((array)$product, (array)$trans);
    }



    /**
     * GET PRODUCT TRANSLATION
     *
     * @param int $id_product
     * @param int $id_lang
     * @return object $trans
     */
    public function getTrans($id_product, $id_lang, $default_lang){
        //get requested translation
        $trans = $this->db->prepare("
            SELECT * FROM `{$this->prefix}product_trans` WHERE `id_product`=? AND `id_lang`=?", 
            [$id_product, $id_lang], true
        );
        //get default if not exist
        if( is_empty($trans) ){
            $trans = $this->db->prepare("
                SELECT * FROM `{$this->prefix}product_trans` WHERE `id_product`=? AND id_lang=?", 
                [$id_product, $default_lang], true
            );
        }
        unset($trans->id);
        return $trans;
    }




    /**
     * CREATE PRODUCT
     *
     * @param $data
     * @return boolean
     */
    public function create($data)
    {
        if( !empty($data['product']) ){
            if( empty($data['product']['active']) ) $data['product']['active'] = 0;//set active value
            $data['product']['id_lang'] = $_POST['id_lang'];
            $id_product = $this->db->create('products', $data['product']);
            //create translation
            if( $id_product && !empty($data['trans']) ){
                $data['trans']['id_lang'] = $_POST['id_lang'];
                $data['trans']['id_product'] = $id_product;
                $data['trans']['meta_title'] = $data['trans']['name'];
                $data['trans']['meta_description'] = strip_tags($data['trans']['excerpt']);
                $data['trans']['link_rewrite'] = slugify($data['trans']['name']);
                $data['trans']['meta_keywords'] = str_replace(' ', ', ', $data['trans']['name']);
                $data['trans']['cdate'] = date("Y-m-d H:i:s");
                $this->db->create('product_trans', $data['trans']);
            }
            Session::set('product_id_lang', $_POST['id_lang']);
            return $id_product;
        }
        return false;
    }




    /**
     * UPDATE PRODUCT
     *
     * @param $data
     * @return boolean
     */
    public function update($data)
    {
        $id_product = $data['id_product'];
        $id_lang = isset($data['id_lang']) ? $data['id_lang'] : get_lang('id');
        //create or update translation
        if( !empty($data['trans']) ){
            $data['trans']['id_lang'] = $id_lang;
            $data['trans']['id_product'] = $id_product;
            $data['trans']['udate'] = date("Y-m-d H:i:s");
            //check if translation exist
            $trans = $this->db->prepare("
                SELECT id FROM {$this->prefix}product_trans WHERE id_product=? AND id_lang=?", 
                [$id_product, $id_lang], true
            );
            if( $trans ){
                $this->db->update('product_trans', $trans->id, $data['trans']);
            } else {
                $data['trans']['meta_title'] = $data['trans']['name'];
                $data['trans']['meta_description'] = strip_tags($data['trans']['excerpt']);
                $data['trans']['link_rewrite'] = slugify($data['trans']['name']);
                $data['trans']['meta_keywords'] = str_replace(' ', ', ', $data['trans']['name']);
                $data['trans']['cdate'] = date("Y-m-d H:i:s");
                $this->db->create('product_trans', $data['trans']);
            }
        }
        //update product information
        if( !empty($data['product']) ){
            if( isset($data['product']['reference']) ){
                if( empty($data['product']['active']) ) $data['product']['active'] = 0;
            }          
            return $this->db->update('products', $id_product, $data['product']);
        }
        return true;
    }


    /**
     *
     * INSERT PRODUCT ASSOCIATION
     *
     * @param int $id_product
     * @param array $categories
     * @throws Exception
     */
    public function saveAssociations($id_product, $categories)
    {
        if( !is_empty($categories) ) {
            foreach ($categories as $id_category) {
                if( !$this->associationExist($id_product, $id_category) ){
                    $this->db->create('product_category', array('id_product' => $id_product, 'id_category' => $id_category));
                }
            }
            //Delete old associations
            $cat_ids = implode(",", $categories);
            return $this->db->prepare("DELETE FROM {$this->prefix}product_category WHERE id_product=? AND id_category NOT IN ($cat_ids)", [$id_product]);
        } else {
            return $this->db->prepare("DELETE FROM {$this->prefix}product_category WHERE id_product=?", [$id_product]);
        }
    }


    /**
     *
     * GET ASSOCIATION
     *
     * @param int $id_product
     * @param int $id_category
     * @throws Exception
     */
    public function associationExist($id_product, $id_category){
        $ssociation = $this->db->prepare("SELECT COUNT(id) as count FROM {$this->prefix}product_category WHERE id_product=? AND id_category=?", [$id_product, $id_category], true);
        if( $ssociation->count > 0 )
            return true;
        return false;
    }


    /**
     * Get Categories
     *
     * @param int $id_product
     * @return categories
     */
    public function getCategories($id_product)
    {
        return $this->db->prepare("SELECT id_category FROM `{$this->prefix}product_category` WHERE id_product=?", [$id_product]);
    }


    /**
     * Get Categories By Parent
     *
     * @param int $parent
     * @return categories
     */
    public function getCategoriesByParent($parent=0)
    {
        return $this->db->prepare("SELECT id, name, permalink FROM `{$this->prefix}categories` WHERE `parent`=?", [$parent]);
    }



    /**
     * Get Combinations
     *
     * @param int $id_product
     * @return $combinations
     */
    public function getCombinations($id_product)
    {
        return $this->db->prepare("SELECT * FROM `{$this->prefix}declinaisons` WHERE `id_product`=?", [$id_product]);
    }


    /**
     * Get Combination BY ID
     *
     * @param int $id_combination
     * @return $combinations
     */
    public function getCombByID($id_combination)
    {
        return $this->db->prepare("SELECT * FROM `{$this->prefix}declinaisons` WHERE id=?", [$id_combination], true);
    }




    /**
     * Get Attributes Values
     *
     * @param int $id_combination
     * @return $attributes
     */
    public function getAttributeValues($id_combination)
    {
        return $this->db->prepare("
            SELECT d.id as id_comb, d.id_attribute, d.id_value, a.name as attr_name, av.name as value_name
            FROM `{$this->prefix}product_declinaisons` d
            INNER JOIN `{$this->prefix}attributes` a ON a.`id` = d.`id_attribute` 
            INNER JOIN `{$this->prefix}attribute_values` av ON av.`id` = d.`id_value` 
            WHERE d.`id_declinaison`=?", [$id_combination]
        );
    }


    /**
     * Get Attributes
     *
     * @return $attributes
     */
    public function getAttributes()
    {
        return $this->db->prepare("SELECT id, name FROM {$this->prefix}attributes");
    }

    /**
     * Check if product attribute exist
     *
     * @param $id_comb int
     * @param $id_attribute int
     *
     * @return $id_product_attribute
     */
    public function attrExist($id_comb, $id_attribute)
    {
        $product_attr = $this->db->prepare("SELECT id FROM {$this->prefix}product_declinaisons WHERE id_attribute=? AND id_declinaison=?", [$id_attribute, $id_comb], true);
        if( $product_attr ) 
            return intval($product_attr->id);
        return false;
    }


    /**
     * Get Images
     *
     * @return $images
     */
    public function getImages($id_product)
    {
        return $this->db->prepare("SELECT id, name, position, futured FROM {$this->prefix}product_images WHERE id_product=? ORDER BY position ASC", [$id_product]);
    }



    /**
     * Update product quantities
     *
     * @return $images
     */
    public function updateQuantities($json) {
        $fail = 0;
        $quantities = json_decode($json, true);
        if( !empty($quantities) ){
            foreach ($quantities as $key => $value) {
                $update = $this->db->prepare("UPDATE {$this->prefix}declinaisons SET quantity=? WHERE id=?", [end($value), key($value)]);
                if( !$update ) $fail += 1;
            }
        }
        if( $fail > 0 ) return false;
        return true;
    }


    /**
     * Update Features
     *
     * @return $images
     */
    public function updateFeatures($data) {
        if( empty($data['features']) ) return true;
        $fail = 0;
        foreach ($data['features'] as $f){
            $count = $this->db->prepare("SELECT COUNT(id) as num FROM {$this->prefix}feature_product WHERE id_feature=? AND id_product=?", [$f['id_feature'], $f['id_product']], true);
            
            $f['custom'] = ($f['custom']) ? $f['custom'] : '';           
            if( $count->num > 0 ) {
                $attributes = array();
                $attributes[] = $f['id_feature_value'];
                $attributes[] = $f['custom'];
                $attributes[] = $f['id_feature'];
                $attributes[] = $f['id_product'];
                $update = $this->db->prepare("UPDATE `{$this->prefix}feature_product` SET `id_feature_value`=?, `custom`=? WHERE id_feature=? AND id_product=?", $attributes);
                if( !$update ) $fail += 1;
            } else {
                $create = $this->db->create('feature_product', $f);
                if( !$create ) $fail += 1;
            }
        }
        if( $data['ids'] != '' ){
            $features_ids = $data['ids'];
            $this->db->prepare("DELETE FROM `{$this->prefix}feature_product` WHERE id_product=? AND id_feature NOT IN ($features_ids)", [$_GET['id']]);
        }

        if( $fail > 0 ) return false;

        return true;
    }


    /**
     * Get Features
     *
     * @return $features
     */
    public function getFeatures($id_lang)
    {
        return $this->db->prepare("SELECT f.id, f.position, t.name FROM {$this->prefix}features f LEFT JOIN `{$this->prefix}feature_trans` t ON (t.`id_feature` = f.`id` AND t.`id_lang` =?) WHERE 1 ORDER BY f.`position` ASC", [$id_lang]);
    }



    /**
     * Get Features Valures
     *
     * @return $valures
     */
    public function getFeatureValures($id_feature, $id_lang)
    {
        return $this->db->prepare("SELECT vt.id, vt.value, vt.id_value, v.id_feature FROM {$this->prefix}feature_value v LEFT JOIN `{$this->prefix}feature_value_trans` vt ON (vt.`id_value` = v.`id` AND vt.`id_lang` = ?) WHERE v.`id_feature`=? ORDER BY vt.`id` ASC", [$id_lang, $id_feature]);
    }



    /**
     * GET PRODUCT FEATURES
     *
     * @return $features
     */
    public function getProductFeatures($id_feature, $id_product)
    {
        return $this->db->prepare("SELECT * FROM {$this->prefix}feature_product WHERE `id_feature`=? AND `id_product`=? ", [$id_feature, $id_product], true);
    }



    /**
     * GET ATTACHMENTS
     *
     * @return $features
     */
    public function getAttachments($id_product) {
        return $this->db->prepare("SELECT id, name, slug, description, attachment FROM {$this->prefix}product_attachments WHERE id_product=?", [$id_product]);

    }



    /**
     * UPLOAD ATTACHMENTS
     *
     * @return boolean
     */
    public function saveAttachment($files, $data) {
        $fail = 0;
        $fields = array(
            'id_product' => $_POST['id_product'], 
            'name' => $data['name'], 
            'slug' => slugify($data['name']), 
            'description' => $data['description'], 
        );
        $uploadDir = site_base() . 'files/attachments/'. $_POST['id_product'] .'/';
        $imagesPath = Media::uploadAttachment($files, $uploadDir);
        if( !empty($imagesPath) ){
            foreach ($imagesPath as $key => $path) {
                $file_name = basename($path);
                $fields['attachment'] = $file_name;
                $fields['file_md5'] = md5( $file_name );
                $saveAtt = $this->db->create("product_attachments", $fields);
                if( !$saveAtt ) $fail += 1;
            }
        }
        return ($fail>0) ? false : true;
    }
    





//END CLASS
}