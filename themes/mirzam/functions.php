<?php
/**
 * Register theme stylesheets
 */
add_css('mz-styles', ['src'=> get_theme_url('assets/vendors/bootstrap/css/margin-padding.css') ]);
add_css('mz-style', ['src'=> get_theme_url('assets/css/style.css') ]);
add_css('mz-styles', ['src'=> get_theme_url('assets/css/styles.css') ]);

/**
 * Register theme javascript
 */
add_js('mz-product', ['src' => get_theme_url('assets/js/product.js') ]);
add_js('mz-cart', ['src' => get_theme_url('assets/js/cart.js') ]);
add_js('mz-order-address', ['src' => get_theme_url('assets/js/order-address.js') ]);
add_js('mz-scripts', ['src' => get_theme_url('assets/js/scripts.js') ]);



/**
 * Register sections
 */
add_section('top_nav', 'Top Navigation');
add_section('contact_info', 'Contact Information');
add_section('column_left', 'Column Left');
add_section('column_right', 'Column Right');


$theme_options_custom_style = (object)  array(
	"bgcolor" 			=> (object) array(
			"selector"  	=> "body",
			"attribute" 	=> "background-color",
			"value"     	=>	""
		),
	"text_color"		 => (object) array(
			"selector"  	=> "p",
			"attribute" 	=> "color",
			"value"     	=>	""
		),
	"link_color" 		=> (object) array(
			"selector"  	=>	"a",
			"attribute" 	=>	"color",
			"value"     	=>	""
		),
	"top_nav_color" 	=> (object) array(
			"selector"  	=> "#top-nav",
			"attribute" 	=> "background-color",
			"value"  		=> ""),
	"trending_background" 	=> (object) array(
			"selector"  	=> "#trending .nav-tabs>li.active>a, #trending .nav-tabs>li.active>a:focus, #trending .nav-tabs>li.active>a:hover",
			"attribute" 	=> "background-color",
			"value"  		=> ""),
	"header_searchbox" 	=> (object) array(
			"selector"  	=> "#header_top #searchbox [type='submit']",
			"attribute" 	=> "background-color",
			"value"  		=> ""),
	"btn_add_to_cart" 	=> (object) array(
			"selector"  	=> ".col-product .block .add_to_cart",
			"attribute" 	=> "background-color",
			"value"  		=> ""),
	"newsletter_backgroud" 	=> (object) array(
			"selector"  	=> "#newsletter",
			"attribute" 	=> "background-color",
			"value"  		=> ""),
	"newsletter_color" 	=> (object) array(
			"selector"  	=> "#newsletter p",
			"attribute" 	=> "color",
			"value"  		=> ""),
	"footer_backgroud" 	=> (object) array(
			"selector"  	=> "footer",
			"attribute" 	=> "background-color",
			"value"  		=> ""),
	"footer_color" 		=> (object) array(
			"selector"  	=> "footer",
			"attribute" 	=> "color",
			"value"  		=> ""),
	"footer_bottom_backgroud" 		=> (object) array(
			"selector"  	=> "footer .footer-bottom",
			"attribute" 	=> "background-color",
			"value"  		=> ""),
	"footer_bottom_color" 		=> (object) array(
			"selector"  	=> "footer .footer-bottom p",
			"attribute" 	=> "color",
			"value"  		=> ""),
	"font awsome" 		=> (object) array(
			"selector"  	=> "i.fa",
			"attribute" 	=> "color",
			"value"  		=> "inherit",
			"protected"  	=> "true"),
);


save_meta_value("theme_options_custom_style",serialize($theme_options_custom_style));
//remove_meta_value("theme_options_custom_style");