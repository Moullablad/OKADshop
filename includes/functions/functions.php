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


include __DIR__ . '/core.php';
include __DIR__ . '/admin.php';
include __DIR__ . '/admin-users.php';
include __DIR__ . '/languages.php';
include __DIR__ . '/shop.php';

include __DIR__ . '/modules.php';
include __DIR__ . '/actions.php';
include __DIR__ . '/hooks.php';

include __DIR__ . '/tabs.php';
include __DIR__ . '/views.php';
include __DIR__ . '/medias.php';
include __DIR__ . '/themes.php';

include __DIR__ . '/products.php';
include __DIR__ . '/category.php';
include __DIR__ . '/orders.php';
include __DIR__ . '/users.php';

//old function to remove
include __DIR__ . '/functions/functions.php';
include __DIR__ . '/functions/cart.php';
include __DIR__ . '/functions/geofunction.php';



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


