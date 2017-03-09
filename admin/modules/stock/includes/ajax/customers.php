<?php
/**
 * 2016 - 2017 OkadShop
 * Open source ecommerce software
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OKADshop <contact@okadshop.com>
 * @copyright 2016 - 2017 OKADshop
 */
include '../../../../../config/bootstrap.php';

$db = getDB();
$query = $_GET['query'];
$users = $db->prepare("SELECT id, last_name, first_name FROM {$db->prefix}users WHERE user_type='user' AND first_name LIKE '%$query%' OR last_name LIKE '%$query%' OR clt_number LIKE '%$query%'");

$result['suggestions'] = [];
if ( !empty($users) ) : foreach ($users as $key => $user) :

	$result['suggestions'][] = array(
		'value' => $user->last_name .' '. $user->first_name,
		'id_customer' => $user->id
	);

endforeach; endif;

echo json_encode($result);