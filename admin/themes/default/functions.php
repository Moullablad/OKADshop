<?php
/**
 * Register CSS and JS
 *
 */
add_css('default-styles', [
	'src'=> get_admin_theme_url('assets/css/styles.css'), 
	'admin' => true
]);

add_js('jquery', []);
add_js('default-app', [
	'src'=> get_admin_theme_url('assets/js/app.js'), 
	'admin' => true
]);
add_js('default-scripts', [
	'src'=> get_admin_theme_url('assets/js/scripts.js'), 
	'admin' => true
]);