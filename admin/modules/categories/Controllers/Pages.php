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

use Core\Controllers\Admin\PageController;

class Pages extends PageController {

    public function __construct()
    {
        self::$buttons = [];
        self::$buttons = [
            [
                'label' => trans('Categories', 'cats'),
                'class' => 'btn btn-primary',
                'icon' => 'fa fa-bars',
                'link' => get_page_url('cats', __FILE__)
            ],
            [
                'label' => trans('Create new Category', 'cats'),
                'class' => 'btn btn-default',
                'icon' => 'fa fa-plus',
                'link' => get_page_url('category', __FILE__)
            ],
        ]; 
       switch (get_url_param('page')) {
            case 'cats':
               unset(self::$buttons[0]);
               break;
            case 'category':
               unset(self::$buttons[1]);
               break;
       }
    }


    /**
     * Categories list
     *
     * @since 1.0.0
     */
    public function pageCats() {
        // Delete category
        if( form_submited() && isset($_POST['delete_cat']) ) {
            $db = getDB();
            $id_category = $_POST['delete_cat'];
            $delete_cat = $db->delete('categories', $_POST['delete_cat']);
            if( $delete_cat ) {
                $db->prepare("DELETE FROM {$db->prefix}category_trans WHERE id_category=?", [$id_category]);
                set_flash_message('success', trans('Category was deleted.', 'cats'));
            } else {
                set_flash_message('danger', trans('Unable to delete this Category.', 'cats'));
            }
        } 

        self::$title = trans('Categories', 'cats');
        self::$icon = 'fa fa-sitemap';

        $category = new \Core\Models\Admin\Category();
        
        return get_view(__FILE__, 'admin/categories', [
            'categories' => $category->getCategories()
        ]);
    }

    /**
     * Create or Update Category
     *
     * @since 1.0.0
     */
    public function pageCategory() {
        if( isset($_GET['id']) ) {
            self::$title = trans('Edit Category', 'cats');
            self::$icon = 'fa fa-pencil';
        } else {
            self::$title = trans('Create new Category', 'cats');
            self::$icon = 'fa fa-plus';
        }
        return CategoryTabs::getInstance()->render(__FILE__, 'category', [
            'ajax' => false
        ]);
    }


//END CLASS	
}