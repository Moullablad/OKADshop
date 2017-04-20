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
namespace CoreModules\Categories\Controllers;

use Core\Ajax;

class Categories {

    private static $instance;
    private static $firstKey = true;
    

    /**
     * Get instance.
     *
     * @wp-hook plugins_loaded
     * @see    __construct()
     * @return void
     */
    public static function getInstance()
    {
        if( is_null(self::$instance) ){
            self::$instance = new self;
        }
        return self::$instance;
    }


    /**
     * Register the action
     */
    public function __construct()
    {
        // Add admin menu links
        global $os_admin_menu;
        $cats = $os_admin_menu->add( trans('Categories', 'cats'), get_page_url('cats', __FILE__));
        $cats->link->prepend('<span class="fa fa-sitemap"></span>');

        add_css('categories-css', [
            'src' => module_url(__FILE__, 'assets/css/categories.css'), 
            'admin' => true
        ]);

        add_js('categories-js', [
            'src' => module_url(__FILE__, 'assets/js/categories.js'), 
            'admin' => true
        ]);

        // Register ajax actions
        Ajax::addAction('category_trans', array(new \Core\Models\Admin\Category(), 'getCategoryTrans'));
        Ajax::addAction('delete_category_cover', array($this, 'deleteCategoryCover'));

    }


    public function deleteCategoryCover($args)
    {       
        $id_category = $args['id_category'];
        $success = getDB()->update('categories', $id_category, [
            'cover' => ''
        ]);
        if( $success ) {
            $mask = site_base('uploads/category/'. $id_category .'/'. $id_category .'*.*');
            $unlink = array_map('unlink', glob($mask));
            return ['success' => trans('Cover was deleted.', 'cats')];
        }
        return ['error' => trans('Unable to delete Cover.', 'cats')];
    }


    /**
     * Draw Categories Tree
     *
     * @param array $cat_tree
     * @return $output
     */
    public static function drawCategoriesTree($cat_tree)
    {
        //Base case: an empty array produces no list
        if (empty($cat_tree)) return '';

        $class = ( self::$firstKey ) ? 'class="mcd-menu"' : '';

        //Recursive Step: make a list with child lists
        $output = '<ul '. $class .'>';
        if( self::$firstKey ) {
            // $output .= '<li><a class="active"><strong>'. trans('Categories', 'cats') .'</strong></a></li>';
            self::$firstKey = false;
        }

        // Set active category
        $id_category = 0;
        if( isset($_GET['Module']) && $_GET['Module'] == 'category' ) {
            $id_category = explode('-', $_GET['ID']);
            $id_category = $id_category[0];
        }
        foreach ($cat_tree as $key => $subArray) {
            $key_value = explode('|', $key);
            $cat_ID = $key_value[0];
            $link_rewrite = $key_value[1];
            $cat_name = $key_value[2];
            $active = ''; //($id_category==$cat_ID) ? 'class="active"' : '';
            $output .= '<li class="parent_'.$cat_ID.'">';
            $output .= '<a '. $active .' href="'. get_category_link($cat_ID, $link_rewrite) .'">'. $cat_name .'</a>';

            $output .= self::drawCategoriesTree($subArray) . '</li>';
        }
        $output .= '</ul>';
        
        return $output;
    }



//END CLASS 
}