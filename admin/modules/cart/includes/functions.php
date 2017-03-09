<?php
/**
 * Save labels
 * 
 * @param $data array
 * @return bool
 */
function save_cart_labels($data){
	$value = json_encode($data, JSON_UNESCAPED_UNICODE);
	$save = save_meta_value('cart_labels', $value);
	if( $save ){
		return create_session('cart_labels', $value);
	}
	return false;
}

/**
 * Get cart labels
 * 
 * @return $labels array
 */
function get_cart_labels(){
	$cart_labels = array();
	$labels_session = read_session('cart_labels');
	if( $labels_session ){
		$labels = $labels_session;
	} else {
		$labels = get_meta_value('cart_labels');
	}
    if( $labels ){
    	$cart_labels = json_decode($labels, true);
    }
    return $cart_labels;
}

/**
 * Save default cart label
 * 
 * @param $data array
 * @return bool
 */
function save_default_cart_label($data){
	$value = json_encode($data, JSON_UNESCAPED_UNICODE);
	$save = save_meta_value('cart_label_default', $value);
	if( $save ){
		return create_session('cart_label_default', $value);
	}
	return false;
}

/**
 * Get default cart label
 * 
 * @return $default name
 */
function get_default_cart_label(){
	$label_default = array();
	$default_session = read_session('cart_label_default');
	if( $default_session ){
		$default = $default_session;
	} else {
		$default = get_meta_value('cart_label_default');
	}
    if( $default ){
    	$label_default = json_decode($default, true);
    }
    return $label_default;
}


/**
 * Get cart label
 */
function get_cart_label($id_product){
	$slug = '';
	$iso_code = get_lang()->iso_code;
	$labels   = get_cart_labels();
	$default  = get_default_cart_label();
	if( isset($default[$id_product]) ){
		$slug = $default[$id_product];
	}
	//if not exist chose first one
	if( $slug == '' ){
		reset($labels);
        $slug = key($labels);
	}
	//get label name
    if( isset($labels[$slug][$iso_code]) ){
        $label_name = $labels[$slug][$iso_code];
    } else {
    	if( !empty($labels) ){
	        reset($labels[$slug]);
	        $iso_code = key($labels[$slug]);
	        $label_name = $labels[$slug][$iso_code];
    	} else {
    		 $label_name = trans("Add to Cart", "cart");
    	}
    }
    return $label_name;
}