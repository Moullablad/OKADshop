<?php
/**
 * 2016 OkadShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@okadshop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OkadShop <contact@okadshop.com>
 * @copyright 2016 OkadShop
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of OkadShop
 */

include '../../../config/bootstrap.php';



/*$DB = Database::getInstance();
$Param = $_GET['FSTParmOne'];
$query = "SELECT * FROM "._DB_PREFIX_."products WHERE title like '%$Param%'";


//echo $query;
if($res = $DB->pdo->query($query))
{
	$row = $res->fetchAll();
	$products = array();
	foreach ($row as $key => $prod) {
	 $test = array('value'=>$prod['title'],'label'=>$prod['title'],'id'=>$prod['id']);
	 array_push($products, $test );
	}
	echo json_encode($products);
}*/
?>