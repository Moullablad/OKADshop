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
    protected $table = "categories";


    /**
     *=============================================================
     * GET CATEGORY DATA
     *=============================================================
     * @param int $id_category
     * @return data object
     */
    public function getCategory($id_category){
        $category = $this->db->find($this->table, $id_category);
        unset($category->hidden, $category->parent, $category->position, $category->cby, $category->uby, $category->cdate, $category->udate);
        return $category;
    }


    public function allCategory($condition = "")
    {
        try {
 
            $Category  =  $this->db->prepare("SELECT * FROM `{$this->db->prefix}categories` $condition");
            
            if( !is_empty($Category) ){

                return $Category;
            }

            return false;

        } catch (ControllerException $e) {
          $this->getException($e);
        }
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
        $orderby = "cdate asc";
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
        if ( isset($_POST['orderby']) && !empty($_POST['orderby']) ) {
            $orderby = str_replace(':', ' ', $_POST['orderby']);
            $session->set('orderby', $orderby);
        } elseif ( $session->get('orderby') ) {
            $orderby = $session->get('orderby');
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


        //sql query
        $sql = "SELECT p.id, p.cdate
            FROM `{$this->db->prefix}products` p
            LEFT JOIN `{$this->db->prefix}product_category` pc ON pc.`id_product` = p.id
            WHERE pc.`id_category` = $id_category AND p.active=1
            ORDER BY $orderby";
          
        try {

            $paginator = new Paginator($page, $sql, $options);
            if( true === $paginator->success ){

                //pagination
                $result->paginator = new \stdClass;
                $result->paginator->total = $paginator->total_results;
                $result->paginator->links = $paginator->links_html;
                $result->paginator->orderby = str_replace(' ', ':', $orderby);
                $result->paginator->perpage = $perpage;

                //category products
                $model = new Product();
                $products = (object) $paginator->resultset->fetchAll(\PDO::FETCH_OBJ);
                foreach ($products as $key => $product) {
                    $result_products[] = $model->getByID($product->id); 
                }
                $result->products = $result_products;

                //$controller = new ProductController();
                //$result->products = $controller->migrateProduct($products);

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
        $cats =  $this->db->prepare("SELECT * FROM `{$this->db->prefix}categories` WHERE parent = ? AND hidden = 0 ORDER BY position ASC", [$id_category]);
        foreach ($cats as $key => $cat) {
            $cat->link = site_url()."category/".$cat->id;
            if (!is_empty($cat->permalink)) {
                $cat->link .= "-".$cat->permalink;
            }
        }
        return $cats;
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
        $cover = $db->prepare("SELECT `image_cat` FROM `{$db->prefix}categories` WHERE `id` = ?", [$id_category], true);
        if( $cover->image_cat !== '' ){
            $imageDir = 'files/category/'. $id_category .'/';
            $image_url = Image::getImageBySize($cover->image_cat, $imageDir, $size);
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
        $cover = $db->prepare("SELECT `image_cat` FROM `{$db->prefix}categories` WHERE `id` = ?", [$id_category], true);
        if( $cover->image_cat !== '' ){
            $imageDir = 'files/category/'. $id_category .'/'. $cover->image_cat;
            if( file_exists($imageDir) ){
                return Image::resizeImage($imageDir, $sizes);
            }
        }

        return false;
    }



//END CLASS
}