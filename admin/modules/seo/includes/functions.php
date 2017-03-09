<?php
Seo::$metas = get_seo_metas(); //Get metas
Seo::$settings = get_seo_settings(); //Get settings
Seo::$separator = Seo::$settings['general']['title']['separator'];
Seo::$pageName = get_shop('name');


/**
 * Add new metas
 */
function add_meta($property = '', $content = '', $type = 'name'){
	Seo::addMeta($property, $content, $type);
}


/**
 * Get metas
 * 
 * @return $metas array
 */
function get_seo_metas(){
	$metas = include 'metas.php';
	if( $meta_tags = get_meta_value('seo_meta_tags') ){
    	$results = json_decode($meta_tags, true);
		$metas = array_merge($metas, $results);
    }
    return $metas;
}


/**
 * Save metas
 * 
 * @param $data array
 * @return bool
 */
function save_seo_metas($data){
	$value = json_encode($data, JSON_UNESCAPED_UNICODE);
	return save_meta_value('seo_meta_tags', $value);
}


/**
 * Get seo settings
 * 
 * @return $settings array
 */
function get_seo_settings(){
	$settings = include 'settings.php';
	if( $seo_settings = get_meta_value('seo_settings') ){
    	$results  = json_decode($seo_settings, true);
    	$settings = array_merge($settings, $results);
    }
    return $settings;
}

/**
 * Save seo settings
 * 
 * @param $data array
 * @return bool
 */
function save_seo_settings($data){
	$value = json_encode($data, JSON_UNESCAPED_UNICODE);
	return save_meta_value('seo_settings', $value);
}

/**
 * Set Meta pageName
 * 
 * @param $name
 * @return void
 */
function set_meta_page($name) {
	Seo::$pageName = $name;
}

/**
 * Set Meta title
 * 
 * @param $title
 * @return void
 */
function set_meta_title($title) {
	Seo::$title = $title;
}

/**
 * Set Meta description
 * 
 * @param $description
 * @return void
 */
function set_meta_description($description) {
	Seo::$description = $description;
}

/**
 * Set Meta keywords
 * 
 * @param $keywords
 * @return void
 */
function set_meta_keywords($keywords) {
	Seo::$keywords = $keywords;
}



/**
 * Get all metas
 */
function generate_metatags(){
	if( is_admin() ) return;

	Seo::metaInit(); //Initialize seo metatags
	// $settings = Seo::getSettings(); //get seo Settings
	$metas = Seo::getMetas(); //get seo Metas
	if( empty($metas) ) return '';

	$position = Seo::$settings['general']['title']['position'];
	if( $position == '1' ){
		$title = Seo::$title .' '. Seo::$separator .' '. Seo::$pageName;
	} else {
		$title = Seo::$pageName .' '. Seo::$separator .' '. Seo::$title;
	}

	$newline = "\n\t";
	$output  = $newline .'<title>'.  $title .'</title>'. $newline;
	$output .= '<base href="'. site_url() .'">'. $newline;

	//Alternate languages
	$iso_code = get_lang('iso_code');
    $output .= '<link rel="alternate" hreflang="x-default" href="'. site_url() . $iso_code .'" />'. $newline;
	$languages = get_languages();
    $og_urls = array();
    if( !empty($languages) ) {
    	foreach ($languages as $key => $lang) {
    		if( $lang->iso_code != $iso_code ){
    			$locale_url = get_current_url($lang->iso_code);
    			array_push($og_urls, $locale_url);
    			$output .= '<link rel="alternate" hreflang="'. str_replace('_', '-', $lang->code) .'" href="'. $locale_url .'" />'. $newline;
    		}
    	}
    }

    // Get meta array keys
	$keys = array_keys($metas); 


	//Check if Open Graph enabled
	$og_image = '';
	if( Seo::$settings['og']['enabled'] == '0' ){
		$filter = preg_grep('#^og:#', $keys); // Get the keys starting with og:
		$metas = array_diff_key($metas, array_flip($filter)); // Filter it
	} else {
		//Open Graph locale alternate
   		$metas['og:locale:alternate']['content'] = $og_urls;
   		if( $image = $metas['og:image']['content'] ){
   			if (0 !== strpos($image, 'http')) {
			   $og_image = site_url($image);
			} else {
			   $og_image = $image;
			}
   		} else if( $image = Seo::$settings['og']['image'] ){
   			$og_image = site_url($image);
   		} 

   		if( $og_image != '' && remote_file_exists($og_image) ){
		    $metas['og:image']['content'] = $og_image;
	    	/*$raw = ranger($og_image);
	    	if( $im = imagecreatefromstring($raw) ){
				$width = imagesx($im);
				$height = imagesy($im);
	    		$metas['og:image:url']['content'] = $og_image;
	    		$metas['og:image:type']['content'] = '';
			    $metas['og:image:width']['content'] = $width;
			    $metas['og:image:height']['content'] = $height;
    			// $metas['og:url']['content'] = $og_image;
    			// $metas['og:image:size']['content'] = $image_size;
		    	// list($width, $height, $type, $attr) = getimagesize($og_image);
	    	}*/
	    }
	}

	//Check if Twitter enabled
	if( Seo::$settings['twitter']['enabled'] == '0' || Seo::$settings['twitter']['site'] == '' ){
		$filter = preg_grep('#^twitter:#', $keys); // Get the keys starting with og:
		$metas = array_diff_key($metas, array_flip($filter)); // Filter it
	} else {
   		$tw_image = $metas['twitter:image']['content'];
   		if( $tw_image == ''){
   			$tw_image = site_url(Seo::$settings['twitter']['image']);
   			$tw_image = ( $og_image != '') ? $og_image : $tw_image;
   		}
   		if( $tw_image != '' && remote_file_exists($tw_image) ){
		    $metas['twitter:image']['content'] = $tw_image;
	    }
	}

	$output .= '<link rel="website" href="'. site_url() .'">'. $newline;
	$output .= '<link rel="icon" href="'. get_favicon() .'">'. $newline;
    foreach ($metas as $property => $meta) {
    	if( $meta['content'] != '' ){
    		if( is_array($meta['content']) ){
    			foreach ($meta['content'] as $key => $content) {
        			$output .= '<meta '. $meta['type'] .'="'. $property .'" content="'. $content .'" />'. $newline;
    			}
    		} else {
        		$output .= '<meta '. $meta['type'] .'="'. $property .'" content="'. $meta['content'] .'" />'. $newline;
    		}
    	}
    }
    return $output . $newline;
}
add_action('os_head', 'generate_metatags', 0);





function ranger($url){
    $headers = array("Range: bytes=0-32768");
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
}