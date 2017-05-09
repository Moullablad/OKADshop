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
use Core\Paginator;

class CmsController extends FrontController
{
	
	/**
	 * Table int
	 * @var Table $table
	 */
    protected $table = "cms";

    /**
     *=============================================================
     * GET BLOG DATA
     *=============================================================
     * @param $id_cms int
     * @return $results (array)
     * @throws Exception
     */
    public function getCms($id_cms)
    {
        if( !is_numeric($id_cms) )
          return false;

        try {

            //blog data
            $cms = $this->db->find($this->table, $id_cms );
            if( !empty($cms) ){
                $cms->content = html_entity_decode($cms->content);
                return $cms;
            }

            return false;

        } catch (ControllerException $e) {
          $this->getException($e);
        }
    }

    /**
     *=============================================================
     * GET All BLOG DATA
     *=============================================================
     * @return $results (array)
     * @throws Exception
     */
    public function allCms()
    {
         
        try {

            //blog data
            $cms = $this->db->query("SELECT * FROM " . $this->prefix . $this->table . " WHERE active = 1");
            if( !is_empty($cms) ){
                

                foreach ($cms as $key => $value) {
                   
                    $value->link = "cms/".$value->id;
                    if (!is_empty($value->permalink)) {
                         $value->link .= "-".$value->permalink;
                    }
                }

                return $cms;
            }

            return false;

        } catch (ControllerException $e) {
          $this->getException($e);
        }
    }

    public function allCmsCat()
    {
         
        try {


            $cms_categories =  $this->db->select("cms_categories",array("*"));;
            if( !is_empty($cms_categories) ){
                

                foreach ($cms_categories as $key => $value) {
                   
                    $value->link = "cms-category/".$value->id;
                    if (!is_empty($value->permalink)) {
                         $value->link = "cms-category/".$value->permalink;
                    }
                }

                return $cms_categories;
            }

            return false;

        } catch (ControllerException $e) {
          $this->getException($e);
        }
    }


    public function getCMSCat($cat)
    {
        try {

            //blog cat data
            if( is_numeric($cat) ){
                $cms_category = $this->db->find("cms_categories", $cat);
            }else{
                $cms_category = $this->db->query("SELECT * FROM ".$this->db->prefix."cms_categories WHERE permalink = '$cat'", true);
            }

            if( !empty($cms_category) ){
                return $cms_category;
            }

            return false;

        } catch (ControllerException $e) {
          $this->getException($e);
        }
    }
    
    public function getCmsByCat($id_category){
        if( !is_numeric($id_category) )
            return false;

        $session = Session::getInstance();

        //defaults vars
        $orderby = "cdate asc";
        $page = 1;
        $perpage = 9;
        $isStartPage = true;
        $result = new \stdClass;

        //set current page
        $current_page = isset($_GET['ID2']) ? intval($_GET['ID2']) : '';
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
       /* if( !$isStartPage )
            $options['url'] = $_GET['Module']."/".'*VAR*';*/


        //sql query
        $sql = "SELECT * 
            FROM `{$this->db->prefix}cms` 
            WHERE `id_cmscat` = $id_category 
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

                //cms
                $cms_list = (object) $paginator->resultset->fetchAll(\PDO::FETCH_OBJ);
                if( !is_empty($cms_list) ){
                    foreach ($cms_list as $cms) {
                       $cms->cover = "files/cms/".$cms->img_cms;
                       $cms->url = "cms/".$cms->id;
                       if ($cms->permalink != "") {
                           $cms->url .= "-".$cms->permalink;
                       }
                       $cms->content = html_entity_decode($cms->content);
                       $cms->content = strip_tags($cms->content);

                       $cms->short_description = substr($cms->content, 0,100)."...";
                       

                    }
                }
                $result->cms_list = $cms_list;

                return $result;
            }

            return false;

        } catch (Exception $e) {
            $this->getException($e);
        }
    }

}