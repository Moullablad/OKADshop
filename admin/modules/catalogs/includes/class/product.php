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

use Core\Theme;
use Core\Models\Admin\Product;
use Core\Controllers\Front\CategoryController;
use Core\Controllers\Front\ProductController;



class Catalog_Product {
	


	/**
     * Get Product by ID
     *
     * @param $id_product
     * @return void
     */
	public function get($id_product) {
		if( !is_valid_int($id_product) ) {
			header("Location: ". get_url());
		}
		
		do_action('before_product_page');

		$model = new Product();
		if( $product = $model->getByID($id_product) ){

			$data['product'] = $product;
			$data['product']->comb_images = array();
		    $data['currency'] = get_currency();
			$data['images'] = get_product_images($id_product);
			$data['features'] = get_features($id_product);
			$data['declinaisons'] = get_combinations($id_product);
			$tags = get_tags($id_product);
			$data['tags'] = $tags;
			$data['attachements'] = get_attachements($id_product);
			$meta_keywords = "";
			if( !empty($tags) ){
				foreach ((array) $tags as $key => $tag) {
					$meta_keywords .= $tag->name .',';
				}
			}

			//seo metatags
			if( function_exists('add_meta') ){

				$title = ($product->meta_title!='') ? $product->meta_title : $product->name;
				$description = ($product->meta_description!='') ? $product->meta_description : $product->description;
				$pageName = Seo::$pageName.' '. Seo::$separator .' '. $product->category; //
				set_meta_page($pageName);
				set_meta_title($title);
				set_meta_description(strip_tags($description));
				set_meta_keywords($product->meta_keywords);
				$image = get_product_cover($product->id, '360x360');
				if (strpos($image,'defaults') === false) {
					add_meta('og:image', $image, 'property');
				}
			}



			$combData = $model->db->prepare("SELECT `id`, `price_impact`, `price`, `quantity`, `min_quantity`, `available_date`, `images` FROM `{$model->db->prefix}declinaisons` WHERE `default_dec`=1 AND `id_product`=?", [$id_product], true);
			if( !is_empty($combData) ){
				//price impact
	            if( $combData->price_impact == "1" ){
	                $price = ($product->sell_price + $combData->price);
	            } elseif( $combData->price_impact == "2" ){
	                $price = ($product->sell_price - $combData->price);
	            } else {
	                $price = $product->sell_price;
	            }
				$data['product']->sell_price = format_price($price);
	            $data['product']->id_comb = $combData->id;
	            $data['product']->quantity = $combData->quantity;
	            $data['product']->min_quantity = $combData->min_quantity;
	            $data['product']->comb_images = $combData->images;
	            $data['product']->available_date = $combData->available_date;
			}
			//get product page template
			Theme::getTemplate('product', $data);
		}
	}


	/**
     * Get Products by Category
     *
     * @param $id_category
     * @return void
     */
	public function category($id_category) {
		if( !is_valid_int($id_category) ) {
			header("Location: ". get_url());
		}
		$controller = new CategoryController();
		if( $category = $controller->getCategory($id_category) ){

			$data['category'] = $category;
			$data['currency'] = get_currency();

			//get sub categories
			$data['shildrens'] = $controller->getChildrens($id_category);

			//category products
			$results = $controller->getProducts($id_category);
			$data['products'] = $results->products;
			$data['paginator'] = $results->paginator;

			//order by session
			$data['orderby'] = (isset($_SESSION['orderby'])) ? $_SESSION['orderby'] : "";

			//seo metatags
			if( function_exists('add_meta') ){
				set_meta_title($category->meta_title);
				set_meta_description(strip_tags($category->meta_description));
				set_meta_keywords($category->meta_keywords);
				$image = category_image($category->id, '140x35');
				if (strpos($image,'defaults') === false) {
					add_meta('og:image', $image, 'property');
				}
			}

		    //get category page template
			Theme::getTemplate('category', $data);
		}
	}


//END CLASS
}