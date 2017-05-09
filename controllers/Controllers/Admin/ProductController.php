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

namespace Core\Controllers\Admin;

use Core\Models\Admin\Product;
use Core\Controllers\Admin\ViewController;

class ProductController extends AdminController
{


    
    /**
     * PRODUCTS LIST
     *
     * @return $products
     */
    public function index()
    {
        $model = new Product();
        $data['products'] = $model->all();
        ViewController::getTemplate('product/index', $data);
    }

    

    /**
     * PRODUCTS ADD
     *
     * @return $products
     */
    public function add()
    {
        ViewController::getTemplate('product/add');
    }

	

	/**
     * PRODUCTS EDIT
     *
     * @return $products
     */
    public function edit()
    {
        ViewController::getTemplate('product/edit');
    }




//END CLASS
}