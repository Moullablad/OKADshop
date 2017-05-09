<?php
//cart label tab 
$cart_label_tabs = array(
	'cart-labels' => array(
		'name' => trans("Cart labels", "cart"),
		'function' => 'cart_label_tab',
		'with_form' => false,
		'with_head' => false,
		'position' => 10
	)
);
attach_tabs('catalogs', 'product', $cart_label_tabs);


/**
 * Cart labels
 */
function cart_label_tab(){
    $cart_labels = get_cart_labels();
	//save cart labels
	if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !is_ajax() ){
		if( isset($_POST['save']) ){
			$slug = $_POST['slug'];
			$name = $_POST['name'];
			$iso_code = $_POST['iso_code'];
			if( $slug == '' ){
				$slug = slugify($_POST['name']);
			}
			$cart_labels[$slug][$iso_code] = $name;
			save_cart_labels($cart_labels);
		} else if( isset($_POST['delete']) ){
			$slug = $_POST['delete'];
			if( isset($cart_labels[$slug]) ){
				unset($cart_labels[$slug]);
				save_cart_labels($cart_labels);
				$data['message']['success'] = trans("Label was deleted successfully.", "cart");
			}				
		}
	}

	//get default label
	$id_product = get_url_param('id');
	$default = get_default_cart_label();
	if( isset($default[$id_product]) ){
		$label_default = $default[$id_product];
	} else {
		reset($cart_labels);
        $label_default = key($cart_labels);
	}

	$db = getDB();
	$selected_lang = read_session('selected_lang');
	$id_lang = ($selected_lang) ? $selected_lang : get_lang()->id;
	$lang = $db->find('langs', $id_lang, array('iso_code'));
	$data['iso_code'] = $lang->iso_code;
	$data['default']  = $label_default;
    $data['labels']   = $cart_labels;
    get_view(__FILE__, 'admin/settings', $data);
}