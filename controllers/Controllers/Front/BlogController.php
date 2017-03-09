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
use App\Paginator\Paginator;

class BlogController extends FrontController
{
	
	/**
	 * Table int
	 * @var Table $table
	 */
    protected $table = "blog";

    /**
     *=============================================================
     * GET BLOG DATA
     *=============================================================
     * @param $id_blog int
     * @return $results (array)
     * @throws Exception
     */
    public function getBlog($id_blog)
    {
        if( !is_numeric($id_blog) )
          return false;

        try {

            //blog data
            $blog = $this->db->find($this->table, $id_blog );
            if( !empty($blog) ){
                return $blog;
            }

            return false;

        } catch (ControllerException $e) {
          $this->getException($e);
        }
    }


    public function allBlog()
    {
         
        try {

            //blog data
            $blog = $this->db->select($this->table,array("*"));
            if( !is_empty($blog) ){
                

                foreach ($blog as $key => $value) {
                   
                    $value->link = "blog/".$value->id;
                    if (!is_empty($value->permalink)) {
                         $value->link .= "-".$value->permalink;
                    }
                }

                return $blog;
            }

            return false;

        } catch (ControllerException $e) {
          $this->getException($e);
        }
    }

    public function allBlogCat()
    {
         
        try {

            //blog data
            $blog_categories = $this->db->select("blog_categories",array("*"));
            if( !is_empty($blog_categories) ){
                

                foreach ($blog_categories as $key => $value) {
                   
                    $value->link = "blog-category/".$value->id;
                    if (!is_empty($value->permalink)) {
                         $value->link = "blog-category/".$value->permalink;
                    }
                }

                return $blog_categories;
            }

            return false;

        } catch (ControllerException $e) {
          $this->getException($e);
        }
    }


    public function getBlogCat($id_blog)
    {
        

        try {

            //blog cat data
            if( is_numeric($id_blog) ){
                $blog_category = $this->db->find("blog_categories", $id_blog);
            }else{
                $blog_category = $this->db->query("SELECT * FROM ".$this->db->prefix."blog_categories WHERE permalink = '$id_blog'", true);
            }

            if( !empty($blog_category) ){
                return $blog_category;
            }

            return false;

        } catch (ControllerException $e) {
          $this->getException($e);
        }
    }

    public function blogCategory($id_parent){
        if( !is_numeric($id_parent) )
          return false;

        $query = "SELECT * FROM {$this->db->prefix}blog_categories WHERE parent = $id_parent";
        $blog_category = $this->db->query($query);
        if( !is_empty($blog_category) ){
            foreach ($blog_category as $cat) {
               $cat->cover = "files/blog/".$cat->img;
               $cat->url = "blog-category/".$cat->id;
               if ($cat->permalink != "") {
                   $cat->url .= "-".$cat->permalink;
               }
            }
            return $blog_category;
        }

        return false;

    }

    public function getBlogs($params = ""){


        $query = "SELECT * FROM {$this->db->prefix}blog $params";
        $blog_list = $this->db->query($query);
        if( !is_empty( $blog_list) ){
            foreach ($blog_list as $blog) {
               $blog->cover = "files/blog/".$blog->img_blog;
               $blog->url = "blog-detail/".$blog->id;
               if ($blog->permalink != "") {
                   $blog->url .= "-".$blog->permalink;
               }
               $blog->content = html_entity_decode($blog->content);
               $blog->content = strip_tags($blog->content);

               $blog->short_description = substr($blog->content, 0,100)."...";
               

            }
            return $blog_list;
        }

        return false;

    }

    public function blogsByCat($id_cat){
        if( !is_numeric($id_cat) )
          return false;

        $query = "SELECT * FROM {$this->db->prefix}blog WHERE id_category = $id_cat";
        $blogs = $this->db->query($query);
        if( !is_empty($blogs) ){
            foreach ($blogs as $blog) {
               $blog->cover = "files/blog/".$blog->img_blog;
               $blog->url = "blog-detail/".$blog->id;
               if ($blog->permalink != "") {
                   $blog->url .= "-".$blog->permalink;
               }
               $blog->short_description = substr($blog->content, 0,100);
               $blog->short_description = html_entity_decode($blog->short_description);

            }
            return $blogs;
        }

        return false;

    }

    public function getBlogStyle(){
        $res = $this->db->query("SELECT * FROM {$this->db->prefix}blog_settings WHERE name = 'blog_style'",true);
        return $res->value;
    }

    /**
     *=============================================================
     * GET BLOG BY CATEGOEY
     *=============================================================
     * @param int $id_category
     * @return data object
     */
    public function getBlogByCat($id_category){
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
        $current_page = intval($_GET['ID2']);
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
            FROM `{$this->db->prefix}blog` 
            WHERE `id_category` = $id_category 
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

                //blogs
                $blog_list = (object) $paginator->resultset->fetchAll(\PDO::FETCH_OBJ);
                if( !is_empty($blog_list) ){
                    foreach ($blog_list as $blog) {
                       $blog->cover = "files/blog/".$blog->img_blog;
                       $blog->url = "blog-detail/".$blog->id;
                       if ($blog->permalink != "") {
                           $blog->url .= "-".$blog->permalink;
                       }
                       $blog->content = html_entity_decode($blog->content);
                       $blog->content = strip_tags($blog->content);

                       $blog->short_description = substr($blog->content, 0,100)."...";
                       

                    }
                }
                $result->blog_list = $blog_list;

                return $result;
            }

            return false;

        } catch (Exception $e) {
            $this->getException($e);
        }
    }

}