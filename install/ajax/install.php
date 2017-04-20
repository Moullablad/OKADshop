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
error_reporting(-1);
ini_set('display_errors', 'On');

header('Content-Type: text/html; charset=utf-8');

set_time_limit(3600);
error_reporting(-1);
ini_set('display_errors', 'On');

$shop = json_decode($_POST['shop'], true);
$user = json_decode($_POST['user'], true);
$database = json_decode($_POST['db'], true);
if( empty( $shop ) || empty( $user ) || empty( $database ) ) return;
// $dirname = str_replace("\\", "/", dirname(__DIR__));
// $root = $_SERVER['DOCUMENT_ROOT'];
// $physical_uri = preg_replace("!$root|install!", "", $dirname);
if( !defined("_LIVE_SITE_") ){
    define("_LIVE_SITE_", false);
}

//prepare database object
$db = array();
foreach ($database as $key => $d) {
    $name = str_replace('db_', '', $d['name']);
    $db[$name] = $d['value'];
}
//database.inc.php Content
$config = '
define("_DB_SERVER_", "'. $db['server'] .'");
define("_DB_NAME_", "'. $db['database'] .'");
define("_DB_USER_", "'. $db['user'] .'");
define("_DB_PASS_", "'. $db['password'] .'");
define("_DB_PREFIX_", "'. $db['prefix'] .'");
define("_PHYSICAL_URI_", "'. $shop['uri'] .'");
';

require '../../vendor/autoload.php';
require '../classes/install.class.php';
require '../languages.php';
$install = new Okad_Install();
$writeConfig = $install->writeConfig("../../config/database.inc.php", $config);
if( !$writeConfig ) return;
require '../../config/database.inc.php';
use Core\Database\Database;
$db = Database::getInstance();
$str_file = '../sql/structure.sql';
$writeStructure = $install->runSQL($str_file);
if( !$writeStructure ) return;
$data_file = '../sql/data.sql';
$savedata = $install->runSQL($data_file);

//save user
$country_code = $shop['country'];
$country = $db->prepare("SELECT `id` FROM `{$db->prefix}countries` WHERE `iso_code`=?", [$country_code], true);
$id_country = (isset($country->id)) ? $country->id : 9;
$user['id_country'] = $id_country;
if( $savedata && $install->createUser($user) ){
    $shop['id_country'] = $id_country;
    $shop['email'] = $user['email'];
    $shop['id_lang'] = 1;
    $install->createLanguage();
    $install->createShop($shop);
    require '../../config/bootstrap.php';

    // Copy files
    copy_folders(site_base('install/img/files/'), site_base('files'));

    $install->resizeProductsImages();
    $install->resizeCategoriesImages();
    $install->installModules();
    //Save modules datas
    $module_file = '../sql/modules_data.sql';
    $modules_data = $install->runSQL($module_file);
    if( !$modules_data ) return;
    echo json_encode("done");
}