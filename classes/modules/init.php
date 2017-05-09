<?php
use Core\Menu\Menu;

// Hooks instance
$hooks = new Hooks();

// set multiple hooks to which module developers can assign functions
//$hooks->set_hooks( $hooks->get_modules_sections() );

//default admin menu links
//you can add your custom links via modules
//https://www.sitepoint.com/dynamic-menu-builder-bootstrap-3-menu-manager/
//$os_admin_menu = new Menu;
//$dashboard = $os_admin_menu->add('<i class="fa fa-dashboard"></i>'. l("Tableau de bord", "core"), './index.php');

/*$os_products = $os_admin_menu->add('<i class="fa fa-book"></i>'. l("Catalogue", "core"), '?module=products');
	$os_products->add( l("Produits", "core"), '?module=products');
	$os_products->add( l("Catégories", "core"), '?module=categories');
	$os_products->add( l("Fabricants", "core"), '?module=manufacturers');
	$os_products->add( l("Attributs des produits", "core"), '?module=attributes');
	$os_products->add( l("Valeurs des produits", "core"), '?module=values');
	$os_products->add( l("Caractéristiques", "core"), '?module=features');
	$os_products->add( l("Mots clés (Tags)", "core"), '?module=tags');*/


/*$os_admin_menu = new Menu;
$dashboard = $os_admin_menu->add('<i class="fa fa-dashboard"></i>'. l("Tableau de bord", "core"), './index.php');*/
global $os_admin_menu;
$os_orders = $os_admin_menu->add('<i class="fa fa-credit-card"></i>'. l("Commandes", "core"), '?module=orders');
	$os_orders->add( l("Commandes", "core"), '?module=orders');
	$os_orders->add( l("Factures", "core"), '?module=invoices');

$os_customers = $os_admin_menu->add('<i class="fa fa-users"></i>'. l("Clients", "core"), '?module=users');
	$os_customers->add( l("Clients", "core"), '?module=users');
	//$os_customers->add('Adresses', '?module=addresses');
	$os_customers->add( l("Groups", "core"), '?module=groups');
	// $os_customers->add( l("Contacts", "core"), '?module=contacts');

$os_cart_rule = $os_admin_menu->add('<i class="fa fa-tags"></i>'. l("Promotions", "core"), '?module=cart');
	$os_cart_rule->add( l("Règles panier", "core"), '?module=cart');

$os_shipping = $os_admin_menu->add('<i class="fa fa-truck"></i>'. l("Livraison", "core"), '?module=shipping');
	$os_shipping->add( l("Transporteurs", "core"), '?module=shipping');
	$os_shipping->add( l("Ajouter un transport", "core"), '?module=shipping&action=add');

$os_locale = $os_admin_menu->add('<i class="fa fa-globe"></i>'. l("Localisation", "core"), '?module=countries');
	$os_locale->add( l("Pays", "core"), '?module=countries');
	$os_locale->add( l("Devises", "core"), '?module=currencies');
	$os_locale->add( l("Zones", "core"), '?module=zones');
	$os_locale->add( l("Taxes", "core"), '?module=taxes');
	$os_locale->add( l("Règles de taxes", "core"), '?module=taxes_rules_group');

/*$os_preferences = $os_admin_menu->add('<i class="fa fa-cog"></i>'. l("Préférences", "core"), '#');
	$os_preferences->add( l("Coordonnées et magasins", "core"), '?module=stores' );

	$p_modules = $os_preferences->add( trans("Modules", "core"), '#' );


  $p_products = $os_preferences->add( l("Produits", "core"), '#');
    $p_products->add( l("Ventes flash", "core"), '?module=quick_sales' );
  $p_customers = $os_preferences->add( l("Clients", "core"), '#');
    //$p_customers->add( l("Ventes flash", "core"), '?module=quick_sales' );
  $p_payments = $os_preferences->add( l("Payments", "core"), '#');
  $p_cms = $os_preferences->add( l("CMS", "core"), '#');
    $p_cms->add( l("Pages", "core"), '?module=cms');
    $p_cms->add( l("Catégories", "core"), '?module=cms_categories');
  $p_blog = $os_preferences->add( l("Articles", "core"), '#');
    $p_blog->add( l("Articles", "core"), '?module=blog');
    $p_blog->add( l("Catégories", "core"), '?module=blog_categories');
  $p_theme = $os_preferences->add( l("Thèmes", "core"), '#');
  $p_seo_url = $os_preferences->add( l("SEO & URL", "core"), '?module=seo_url');*/

/*$os_modules = $os_admin_menu->add('<i class="fa fa-plug"></i>'. l("Modules et Services", "core"), '?module=modules');
	$os_modules->add( l("Gestion des Modules", "core"), '?module=modules');
	$os_modules->add( l("Positions", "core"), '?module=modules&page=positions');
*/
// load modules from folder, this method will load all *.module.php
//$load_modules = $hooks->load_active_modules();


// register new hook from module files
// function add_hook($where, $module="", $function, $description=""){
// 	global $hooks;
// 	$hooks->add_hook($where, $module, $function, $description);
// }

// execute_section_hooks
// function execute_section_hooks( $section ) {
// 	global $hooks;
//   if ( $hooks->hooks_exist( $section ) ) {
//     return $hooks->execute_hooks( $section );
//   }
// }

// allowed html tags method
function allowed_tags() {
  return '<img><strong><p><h1><h2><h3><h4><h5><h6><b><i><u><ul><ol><li><table><thead><tbody><tr><th><td><a><hr><br><span><blockquote><pre><iframe><script><div>';
}

// print menu items
function print_menu_items($items) {
	// Starting from items at root level
	if( !is_array($items) ) $items = $items->roots();
	// loop items
	$menu = '';
  	$i = 1;

  	/*echo '<pre>';
  	print_r($items);
  	echo '</pre>';exit;*/

  	
	foreach( $items as $item ) {
    $class = ( $item->hasChildren() ) ? 'class="dropdown-submenu"' : '';
		//$sub_id = ( $item->hasChildren() ) ? 'id="sub_'.$i.'"' : '';
		$menu .= '<li '. $class .'>';
		$menu .= '<a tabindex="-1" href="'. $item->link->get_url() .'">'.$item->link->get_text().'</a>';
		if( $item->hasChildren() ){
			$menu .= '<ul class="dropdown-menu">'. print_menu_items( $item->children() ) .'</ul>';
		}
		$menu .= '</li>';
    $i++;
	}
	return $menu;
}

//get cron job
function get_cron_job($name){
	global $common;
  $cron_job = $common->select('cron_job', array('name', 'cron_date', 'cron_time', 'active'), "WHERE name='". $name ."'");
  if( $cron_job[0] ) return $cron_job[0];
  return false;
}

//register cron job
function register_cron_job($name, $cron_date="", $cron_time, $active){
  if( empty($name) || empty($cron_time) || empty($active) ) return false;
  global $common;
  $cron_data = array('name' => $name, 'cron_date' => $cron_date, 'cron_time' => $cron_time, 'active' => $active);
  $id_cron 	 = $common->save('cron_job', $cron_data);
  if( $id_cron ) return $id_cron;
  return false;
}

//update cron job
function update_cron_job($name, $active, $cron_date="", $cron_time=""){
  if( empty($name) || $active < 0 || $active > 1 ) return false;
  $cron_data = array('active' => $active);
  if( $cron_data != "" ) $cron_data['cron_date'] = $cron_date;
  if( $cron_time != "" ) $cron_data['cron_time'] = $cron_time;
  global $common;
  $id_cron = $common->update('cron_job', $cron_data, "WHERE name='". $name ."'");
  if( $id_cron ) return $id_cron;
  return false;
}

//print styles
/*function os_header(){
	global $common;
	$common->os_render_styles();
}*/

//print javascript
/*function os_footer(){
	global $common;
	do_action('os_footer');
	return $common->os_render_scripts();
}*/

//return to dashboard
function go_dashboard(){
	$admin_dir = get_admin_dir();
	return _HOME_URL_. $admin_dir ."/index.php";
}

//get admin directory
function get_admin_dir(){
	global $common;
	return $common->get_admin_directory_name();
}






//get default language id
function get_default_id_lang(){
	//from session
	if( isset($_SESSION['default_id_lang']) && !empty($_SESSION['default_id_lang']) )
		return $_SESSION['default_id_lang'];

	//from database
	global $common;
	$lang = $common->select('langs', array('id'), "WHERE default_lang=1 LIMIT 1");
	if( isset($lang[0]['id']) ){
		$id_lang = intval($lang[0]['id']);
	} else {
		$id_lang = 1;
	}

	//update session
	$_SESSION['default_id_lang'] = $id_lang;

	return $id_lang;
}



//add global javascript
//global $common;

//Stylesheets
// $common->os_inject_styles( _HOME_URL_."assets/css/vendors/bootstrap.min.css", 1);
// $common->os_inject_styles( _HOME_URL_."assets/css/vendors/font-awesome.min.css", 2);
// $common->os_inject_styles( _HOME_URL_."assets/css/vendors/chosen/chosen.css", 4);
// $common->os_inject_styles( _HOME_URL_."assets/css/global.css", 9);



/*if( !is_admin() ){
	// $common->os_inject_styles( _HOME_URL_."assets/css/vendors/owl.carousel.css", 3);
	// $common->os_inject_styles( _HOME_URL_."assets/css/vendors/superslides.css", 5);
	// $common->os_inject_styles( _HOME_URL_."assets/css/vendors/magnific-popup.css", 6);
	// $common->os_inject_styles( _HOME_URL_."assets/css/vendors/jquery.mCustomScrollbar.css", 7);
	// $common->os_inject_styles( _HOME_URL_."assets/css/vendors/animate.css", 8);
} else {
	// $common->os_inject_styles( _HOME_URL_."assets/css/vendors/datatables/datatables.bootstrap.min.css", 1);
	// $common->os_inject_styles( _HOME_URL_."assets/css/vendors/tagsinput/bootstrap-tagsinput.css", 4);
	// $common->os_inject_styles( _HOME_URL_."assets/css/vendors/summernote/summernote.css", 4);
	// $common->os_inject_styles( _HOME_URL_."assets/css/vendors/filer/jquery.filer.css", 4);
	// $common->os_inject_styles( _HOME_URL_."assets/css/vendors/bootstrap-switch/bootstrap-switch.min.css", 4);
}*/







//Javascript
// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/jquery-2.1.4.min.js", 1);
// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/bootstrap.min.js", 2);


// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/datepicker/raphael-min.js", 3);
// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/datepicker/morris.min.js", 4);
// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/datepicker/moment.js", 5);
// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/datepicker/bootstrap-datepicker.min.js", 6);
// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/datepicker/bootstrap-datetimepicker.min.js", 7);


// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/chosen.jquery.min.js", 6);
// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/bootstrap-growl.min.js", 13);
// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/isotope.pkgd.js", 7);
// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/jquery.magnific-popup.min.js", 11);
// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/filer/jquery.filer.min.js", 12);

//if( !is_admin() ){
	// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/jquery.fitvids.js", 3);
	// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/owl.carousel.min.js", 4);
	// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/jquery.parallax-1.1.3.js", 5);
	// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/packery-mode.pkgd.min.js", 8);
	// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/jquery-ui.min.js", 9);
	// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/jquery.superslides.min.js", 10);
	// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/jquery.mCustomScrollbar.concat.min.js", 12); 
	// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/Modernizr.js", 14); 
	// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/jquery.actual.min.js", 15); 
	// $common->os_inject_scripts( _HOME_URL_."assets/js/vendors/blog-masonry.js", 16);
	// $common->os_inject_scripts( _HOME_URL_."assets/js/cart.js", 17);
	// $common->os_inject_scripts( _HOME_URL_."assets/js/order-address.js", 18);
//}


// $common->os_inject_scripts( _HOME_URL_ ."assets/js/vendors/datatables/jquery.dataTables.min.js", 19);
// $common->os_inject_scripts( _HOME_URL_ ."assets/js/vendors/datatables/dataTables.bootstrap.min.js", 20);
// $common->os_inject_scripts( _HOME_URL_ ."assets/js/global.js", 21);
// $common->os_inject_scripts( _HOME_URL_ ."assets/js/tabs.js", 22);