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
include '../../../../../config/bootstrap.php';

//This is an ajax request
if( !is_ajax() ){
	die();
}

$group   = $_POST['group'];
$active_tab = $_POST['active_tab'];
$location   = $_POST['location'];
if( $active_tab == '' || $location == '' ) return;

use Core\Tab;
$data = Tab::getTabs($group, $location);
$args = $data[$active_tab];
$args['group'] = $_POST['group'];
$args['ajax'] = true;
echo get_tab_contents($active_tab, $location, $args);
