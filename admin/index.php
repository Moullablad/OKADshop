<?php require_once '../config/bootstrap.php';

use Core\Controllers\Admin\AdminController;
use Core\Controllers\Admin\PageController;

//Check if user connected
$module = ( isset($_GET['module']) && $_GET['module'] != '' ) ? $_GET['module'] : '';
if( !isset($_SESSION['admin']) && $module != 'Login' ){
	header("Location: index.php?module=Login");
}

if( $module === '' ) AdminController::getDashboard();


//get page content
if( isset($_GET['page']) && $_GET['page'] != '' ) {
	PageController::render($_GET['page']);
}
require 'includes/controller.php';
require 'includes/views.php';
?>