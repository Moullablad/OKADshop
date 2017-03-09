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
 *
 * ------------------------------------------------------------------
 * THIS FILE GROUP ALL PRODUCT FUNCTIONS
 * ------------------------------------------------------------------
 *
 *
 */

use Core\Image;
use Core\Controllers\Front\ProductController;
use Core\Controllers\Front\CategoryController;
use Core\Controllers\Front\CartController;

use Core\Models\Admin\Product;



/**
 *
 * Get all product
 *
 * @return object $products
 */
function get_products(){
    $model = new Product();
    return $model->all();
}


/**
 *
 * Get product data
 *
 * @param int $id_product
 * @return object $data
 */
function get_product($id_product){
    if( !is_numeric($id_product) )
        return false;
    
    $controller = new ProductController();
    return $controller->getProduct($id_product);
}




/**
 *
 * GET PRODUCT IMAGES
 *
 * @param int $id_product
 * @param string $image_size
 * @return object $images
 */
function get_product_images($id_product){
    if( !is_numeric($id_product) )
        return false;
    
    $model = new Product();
    return $model->getImages($id_product);
}


/**
 * Get product tags
 *
 * @param int $id_product
 * @return object $tags
 */
function get_tags($id_product){
    if( is_valid_int($id_product) ){
        $controller = new ProductController();
        return $controller->getTags($id_product);
    }
    return false;
}


/**
 * Get product attachements
 *
 * @param int $id_product
 * @return object $tags
 */
function get_attachements($id_product){
    if( is_valid_int($id_product) ){
        $controller = new ProductController();
        return $controller->getAttachements($id_product);
    }
    return false;
}



/**
 * Get product features
 *
 * @param int $id_product
 * @param int $id_lang
 * @return object $features
 */
function get_features($id_product, $id_lang=null){
    if( !is_numeric($id_product) )
        return false;

    if( is_null($id_lang) )
        $id_lang = get_lang()->id;

    $controller = new ProductController();
    return $controller->getFeatures($id_product, $id_lang);
}


/**
 * Get product combinations
 *
 * @param int $id_product
 * @return object $combinations
 */
function get_combinations($id_product){
    if( !is_numeric($id_product) )
        return false;

    $controller = new ProductController();
    return $controller->getDeclinaisons($id_product);
}


/**
 *
 * GET PRODUCT COVER
 *
 * @param int $id_product
 * @param string $image_size
 * @return string $image_url
 */
function get_product_cover($id_product, $image_size='76x76'){
	if( !is_numeric($id_product) )
    	return false;

	return ProductController::getCover($id_product, $image_size);
}


/**
 *
 * GET DEFAULT PRODUCT IMAGE
 *
 * @param int $id_product
 * @param string $image_size
 * @return string $image_url
 */
function default_product_image($id_product, $image_size='76x76'){
	if( !is_numeric($id_product) )
    	return false;

	return ProductController::getCover($id_product, $image_size);
}


/**
 *
 * GET PRODUCT IMAGE BY SIZE
 *
 * @param string $image_name
 * @param int $id_product
 * @param string $image_size
 * @return string $image_url
 */
function product_image_by_size($image_name, $id_product, $image_size){
    $image = Image::getInstance();
	$imageDir = 'files/products/' . $id_product . '/';
	$image_url = $image->getImageBySize($image_name, $imageDir, $image_size);
	return $image_url;
}


/**
 *
 * GET PRODUCT LINK
 *
 * @param string $permalink
 * @return string $product_url
 */
function get_product_url($id_product, $permalink){
	return get_home_url() . 'product/' . $id_product . '-' . $permalink;//_HOME_URL_
}


/**
 *
 * GET DEFAULT CATEGORY IMAGE
 *
 * @param int $id_product
 * @param string $image_size
 * @return string $image_url
 */
function category_image($id_category, $image_size=null){
	if( !is_numeric($id_category) )
    	return false;

	return CategoryController::getCover($id_category, $image_size);
}



/**
 *
 * GET BLOCK CART
 *
 * @return string $cart_html
 */
function get_block_cart(){
	$cart = new CartController();
	echo $cart->getBlockCart();
}


function get_cart_items(){
    $cart = new CartController();
    return $cart->getCartItems();
}




/**
 *
 * FORMAT PRODUCT PRICE
 *
 * @return float $price
 */
function format_price($price, $after_comma=2){
	return ProductController::formatPrice($price, $after_comma);
}


/**
 *
 * FORMAT PRODUCT PRICE WIDTH CURRENCY
 *
 * @return float $price
 */
function with_currency($price){
	$currency = $GLOBALS['os']->currency->sign;
	$price = format_price($price);
	return $price .' '. $currency;
}


/**
 *
 * PERCENT TO AMOUNT
 *
 * @param $price (float)
 * @param $discount (float)
 * @param $type (int)
 * @return $amount (float)
 */
function percent_to_amount($price, $discount, $type=1){
    //if discount or price small than 0
    if( $price <= 0 || $discount <= 0 ) return 0;
    //calculate amount
    if ( $type == 0 ) {
        return ( $price / $discount ) / 100;
    } elseif ( $type == 1 ){
    	return $discount;
    }
    return 0;
}




/**
 *
 * GET ATTRIBUTES
 *
 * @param $id_combination (float)
 * @return $attributes (object)
 */
function get_attributes($id_combination){
    $model = new Product();
    return $model->getAttributeValues($id_combination);
}



/**
 *
 * GET FEATURE VALUES
 *
 * @param $id_feature int
 * @param $id_lang int
 *
 * @return $values (object)
 */
function get_feature_values($id_feature, $id_lang){
    $model = new Product();
    return $model->getFeatureValures($id_feature, $id_lang);
}


/**
 *
 * GET PRODUCT FEATURES
 *
 * @param $id_feature int
 * @param $id_lang int
 *
 * @return $values (object)
 */
function get_product_features($id_feature, $id_product){
    $model = new Product();
    return $model->getProductFeatures($id_feature, $id_product);
}


/**
 * Resize products images
 *
 * @param $id_product null|int|array
 * @param $sizes array
 *
 * @return $values (object)
 */
function resize_product_images($id_product=null, $sizes=['76x76', '360x360']){
    $images = array();
    $db = getDb();
    if( is_null($id_product) ){
        $images = $db->prepare("SELECT id_product, name FROM {$db->prefix}product_images");
    } else if( is_array($id_product) && !empty($id_product) ){
        $products = implode(',', $id_product);
        $images = $db->prepare("SELECT id_product, name FROM {$db->prefix}product_images WHERE id_product IN({$products})");
    } else if( is_valid_int($id_product) ){
        $images = $db->prepare("SELECT id_product, name FROM {$db->prefix}product_images WHERE id_product=?", [$id_product]);
    }
    //start resize images
    if( !empty($images) ) : foreach ($images as $key => $image) :
        $image_path = site_base('files/products/'. $image->id_product .'/'. $image->name);
        if( file_exists($image_path) ){
            Image::resizeImage($image_path, $sizes);            
        }
    endforeach; endif;
}