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

if (!defined('_OS_VERSION_'))
  exit;



function blocknewsletter_install(){

    global $DB;
	$query = "CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."newsletter` (
		`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`email` varchar(255) NOT NULL,
		`cdate` DATE NOT NULL,
		`udate` DATE NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$res = $DB->pdo->query($query);
}



function display_blocknewsletter(){
	try {
		$data = array();
		$db = getDB();
		if (isset($_POST['submit']) && isset($_POST['email'])) {
			$db = getDB();
			$email = $_POST['email'];
			$fields = array(
				"email" => $_POST['email']
			);
			$result = $db->create("newsletter",$fields);
			$data['result'] = $result;
		}
		get_view(__FILE__, 'front/blocknewsletter',$data);
	} catch (Exception $e) {
		blocknewsletter_install();
	}
	
}
add_hook(__FILE__, 'before_footer', 'display_blocknewsletter', 'blocknewsletter', 'display blocknewsletter.');

function page_blocknewsletter_settings(){
	$data = array();
	
	//get_view(__FILE__, 'admin/config',$data);
}
add_admin_page(__FILE__, [
    'name' => 'blocknewsletter_settings',
    'title' => 'Blocknewsletter settings page',
    'function' => 'page_blocknewsletter_settings'
]);