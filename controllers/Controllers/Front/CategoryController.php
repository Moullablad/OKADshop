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

namespace Core\Controllers\Front;






use Core\Session;
use Core\Image;
use Core\Database\Database;
use Core\Paginator;
use Core\Controllers\Front\ProductController;

use Core\Models\Admin\Product;

class CategoryController extends FrontController
{

	/**
     * Table int
     * @var Table $table
     */
    private $table = "categories";
    private $query_args = [
        'multilangues' => [
            [
                'table' => [
                    'c' => 'categories'
                ],
                'table_trans' => [
                    'ct' => 'category_trans'
                ],
                'foreign_key' => 'id_category'
            ]
        ],
        'columns' => [
            '*' => ['c', 'ct']
        ],
        'orderby' => 'c.position',
        'order' => 'ASC',
    ];


    /**
     *=============================================================
     * GET CATEGORY DATA
     *=============================================================
     * @param int $id_category
     * @return data object
     */
    public function getCategory($id_category){
        $this->query_args['conditions'] = [
            [
                'key' => 'c.id',
                'value' => $id_category,
                'operator' => '=',
                'relation' => 'AND'
            ]
        ];
        $this->query_args['limit'] = 1;
        return getDB()->trans($this->query_args);
    }


    public function allCategory($condition = "")
    {
        $category = new \Core\Models\Admin\Category();
        return $category->getCategories();
    }

 

	/**
     *=============================================================
     * GET CATEGORY PRODUCTS
     *=============================================================
     * @param int $id_category
     * @return data object
     */
	public function getProducts($id_category){
        if( !is_numeric($id_category) )
            return false;

        $session = Session::getInstance();

        //defaults vars
        $orderby = "pt.cdate";
        $order = "ASC";
        $page = 1;
        $perpage = 9;
        $isStartPage = true;
        $result = new \stdClass;
        $result_products = array();

        //set current page
        $current_page = isset($_GET['ID2']) ? intval($_GET['ID2']) : 1;
        if ( $current_page ) {
            $page = $current_page;
            $isStartPage = false;
        } 

        //per page
        if ( isset($_POST['perpage']) && is_numeric($_POST['perpage']) ) {
            $perpage = intval($_POST['perpage']);
            $session->set('perpage', $perpage);
        } elseif ( $session->get('perpage') ) {
            $perpage = $session->get('perpage');
        }

        //order by
        $order_method = "cdate:asc";
        if ( isset($_POST['orderby']) && !empty($_POST['orderby']) ) {
            $order_method = $_POST['orderby'];
            $session->set('order_method', $order_method);
        } elseif ( $session->get('order_method') ) {
            $order_method = $session->get('order_method');
        }

        $implode = explode(":", $order_method);
        if( isset($implode[1]) && in_array($implode[1], ['asc', 'desc']) )
            $order = strtoupper($implode[1]);

        switch ($implode[0]) {
            case 'name':
                $orderby = "pt.name";
                break;

            case 'quantity':
                $orderby = "p.quantity";
                break;

            case 'reference':
                $orderby = "p.reference";
                break;

            case 'sell_price':
                $orderby = "p.sell_price";
                break;
            
            default:
                $orderby = "pt.cdate";
                break;
        }

 
        //default options
        $options = array(
            'results_per_page' => $perpage,
            'url' => $_GET['Module']."/".$_GET['ID'] .'/*VAR*',
            'db_handle' => $this->db->pdo,
            'using_bound_values' => false
        );

        //update url
        if( !$isStartPage )
            $options['url'] = $_GET['Module']."/".$_GET['ID'] .'/*VAR*';        

        $id_lang = get_lang('id');
        $sql = "
            SELECT p.*, pt.*, pi.name AS cover FROM `{$this->db->prefix}products` AS p 

            LEFT JOIN `{$this->db->prefix}product_trans` AS pt ON pt.id_product = p.id 
            LEFT JOIN `{$this->db->prefix}product_images` AS pi ON (pi.id_product=p.id AND pi.futured=1)  
            LEFT JOIN `{$this->db->prefix}product_category` pc ON pc.`id_product` = p.id

            WHERE pt.id_lang = CASE WHEN EXISTS(SELECT 1 FROM `{$this->db->prefix}product_trans` AS pt WHERE pt.id_lang = {$id_lang} AND pt.id_product = p.id) THEN ({$id_lang}) ELSE p.id_lang END 

            AND (pc.`id_category`={$id_category} OR p.`id_category_default`={$id_category}) AND p.active=1
            GROUP BY pc.`id_product`
            ORDER BY {$orderby} {$order} 
        ";

        try {

            $paginator = new Paginator($page, $sql, $options);
            if( true === $paginator->success ){

                //pagination
                $result->paginator = new \stdClass;
                $result->paginator->total = $paginator->total_results;
                $result->paginator->links = $paginator->links_html;
                $result->paginator->orderby = $order_method;
                $result->paginator->perpage = $perpage;

                //category products
                $model = new Product();
                $products = $paginator->resultset->fetchAll(\PDO::FETCH_OBJ);
                foreach ($products as $key => $product) {
                    \Core\Models\Admin\Product::setProductAssets($product);
                }
                $result->products = $products;                

                return $result;
            }

            return false;

        } catch (Exception $e) {
            $this->getException($e);
        }
	}




    /**
     *=============================================================
     * GET CATEGORY CHILDRENS
     *=============================================================
     * @param int $id_category
     * @return data object
     */
    public function getChildrens($id_category){
        $this->query_args['conditions'] = [
            [
                'key' => 'c.id_parent',
                'value' => $id_category,
                'operator' => '=',
                'relation' => 'AND'
            ],
            [
                'key' => 'c.active',
                'value' => 1,
                'operator' => '=',
                'relation' => 'AND'
            ]
        ];
        return getDB()->trans($this->query_args);
    }


    /**
     *=============================================================
     * GET CATEGORY COVER IMAGE
     *=============================================================
     * @param int $id_product
     * @return $data (array)
     * @throws Exception
     */
    public static function getCover($id_category, $size=null)
    {
        if( !is_numeric($id_category) )
            return false;

        //image instance
        $db = Database::getInstance();
        $category = $db->prepare("SELECT `cover` FROM `{$db->prefix}categories` WHERE `id` = ?", [$id_category], true);
        if( isset($category->cover) && $category->cover !== '' ){
            $imageDir = 'files/category/'. $id_category .'/';
            $image_url = Image::getImageBySize($category->cover, $imageDir, $size);
            return $image_url;
        }

        return Image::defaultImage($size);
    }


    /**
     *=============================================================
     * RESIZE CATEGORY IMAGE
     *=============================================================
     * @param int $id_product
     * @param int $size
     * @return boolean
     * @throws Exception
     */
    public static function resizeCategoryImage($id_category, $sizes=array('226x55'))
    {
        if( !is_numeric($id_category) )
            return false;

        $db = Database::getInstance();
        $category = $db->prepare("SELECT `cover` FROM `{$db->prefix}categories` WHERE `id` = ?", [$id_category], true);
        if( $category->cover !== '' ){
            $imageDir = 'files/category/'. $id_category .'/'. $category->cover;
            if( file_exists($imageDir) ){
                return Image::resizeImage($imageDir, $sizes);
            }
        }

        return false;
    }



//END CLASS
}