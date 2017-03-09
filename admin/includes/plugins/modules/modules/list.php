<?php

/**
 *=============================================================
 * SHOW MODULE PAGE
 *=============================================================
 * @require string $slug
 * @require string $page
 */
if( isset($_GET['slug']) && isset($_GET['page']) ) 
{



  $module_dir = "../modules/" . $_GET['slug'];
  if( file_exists( $module_dir ) )
  {
    $function = 'page_' . str_replace('-', '_', $_GET['page']);
    if (function_exists( $function )) {
      echo $function();
    }else{
      get_current_admin_page();
      //echo '<center>Page not found</center>';
    }
  }else{
    echo '<center>Module Not Found !!</center>';
  }


}elseif( isset($_GET['page']) && $_GET['page'] == 'positions' )
{
  //modules positions
  include_once 'modules-positions.php';

}else{
  //modules directory
  include_once 'modules-directory.php';
}