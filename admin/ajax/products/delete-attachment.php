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


$DB = Database::getInstance();
$id = intval($_POST['id']);
$id_product = intval($_POST['id_product']);
$att = $_POST['att'];
$full_path = '../files/attachments/'.$id_product.'/'.$att;

try {
	if($id_product <= 0 && $id <= 0 && $att == '') return;
	//Delete image
	$query = "DELETE FROM "._DB_PREFIX_."product_attachments WHERE id=$id";
	if($DB->pdo->query($query)) {
		if (file_exists($full_path)) {
			unlink($full_path);
    }
    echo l("Attachment was removed.", "core");
	}
} catch (Exception $e) {
	exit;//echo $e->getMessage();
}