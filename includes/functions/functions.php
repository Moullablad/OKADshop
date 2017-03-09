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
 * THIS FILE GROUP ALL FUNCTIONS
 * ------------------------------------------------------------------
 *
 */


require_once 'core.php';
require_once 'admin.php';
require_once 'languages.php';
require_once 'shop.php';

require_once 'modules.php';
require_once 'actions.php';
require_once 'hooks.php';

require_once 'tabs.php';
require_once 'views.php';
require_once 'medias.php';
require_once 'themes.php';

require_once 'products.php';
require_once 'orders.php';
require_once 'users.php';

//old function to remove
require_once 'functions/functions.php';
require_once 'functions/cart.php';
require_once 'functions/geofunction.php';



/**
 * GET LOCATION
 * @return true
 **/
function os_redirect($location) {
   echo '<script>window.location.href = "'.$location.'"</script>';
   return true;
}


/**
 * @return array 
 **/
function os_get_date_liste() {
   $date = array();
   $date['days'] = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
   $date['months'] = array(1,2,3,4,5,6,7,8,9,10,11,12);
   $date['years'] = array();
   for ($i=1900; $i < date("Y") ; $i++) { 
   		$date['years'][] =  $i;
   }
   return (object)$date;
}

//get chare buttons
function get_chare_buttons(){
   $buttons = '<a href="#" title="'. l("Share on Facebook", "core") .'" class="facebook_chare"><i class="fa fa-facebook"></i></a>
      <a href="#" title="'. l("Tweet", "core") .'" class="twitter_chare"><i class="fa fa-twitter"></i></a>
      <a href="#" title="'. l("Share on Google+", "core") .'" class="googleplus_chare"><i class="fa fa-google-plus"></i></a>
      <a href="#" title="'. l("Email", "core") .'" class="mailto"><i class="fa fa-envelope"></i></a>';
   return $buttons;
}


