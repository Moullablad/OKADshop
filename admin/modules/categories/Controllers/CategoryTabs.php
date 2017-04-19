<?php
/**
 * 2016 - 2017 OkadShop
 * Open source ecommerce software
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OKADshop <contact@okadshop.com>
 * @copyright 2016 - 2017 OKADshop
 */
namespace CoreModules\Categories\Controllers;

use Core\Tab;

class CategoryTabs extends Tab {


	/**
     * Singleton int
     * @var Singleton $instance
     */
    private static $instance;


	/**
     * @var array $data
     */
    private $data = [];


    /**
     * Get tab instance
     * @return object $instance
     */
    public static function getInstance() {
        if( is_null(self::$instance) ){
            self::$instance = new CategoryTabs();
        }
        return self::$instance;
    }


	public function __construct() {
		if( $id_lang = read_cookie('tabs_selected_lang') ) {
			$this->data['id_lang'] = $id_lang ;
		} else {
			$this->data['id_lang'] = get_lang()->id;
		}
		$category = new \Core\Models\Admin\Category();
		$this->data['cats'] = $category->getCategories($this->data['id_lang']);
		self::addTabs(__FILE__, 'category', array(
			'info' => array(
				'name' => trans("Informations", "cats"),
				'function' => array($this, 'infosTab'),
				'with_form' => true,
				'multilang' => true,
				'position' => 1
			),
			'seo' => array(
				'name' => trans("SEO", "cats"),
				'function' => array($this, 'seoTab'),
				'with_form' => true,
				'multilang' => true,
				'position' => 2
			),
			'image' => array(
				'name' => trans("Image", "cats"),
				'function' => array($this, 'imageTab'),
				'with_form' => true,
				'position' => 3
			),
		));
		add_action('before_tab_category', array($this, 'submitForm'));
	}

	/**
     * Save form data if submited or set default values
     *
     * @since 1.0.0
     */
	function submitForm(){
		$category = new \Core\Models\Admin\Category();
		// Proccess posted data
		if( form_submited() ) {
			if( isset($_GET['id']) ) {
				$category->update($_POST);
			} else {
				if( $id_category = $category->create($_POST) ) {
					set_flash_message('success', trans('Category was created.', 'cats'));
					header("Location: ". get_page_url('category&id='.$id_category, __FILE__));
					exit;
				}
			}
		}

		// get category data if exist
        if( isset($_GET['id']) ) {
            $this->data['category'] = $category->getByID($_GET['id'], $this->data['id_lang']);
            if( empty($this->data['category']) || !is_valid_int($_GET['id']) ) {
                set_flash_message('danger', trans('Could not find the requested category.', 'cats'));
                header("Location: ". get_page_url('cats', __FILE__));
                exit;
            }
        }
	}



	/**
     * Category informations
     *
     * @since 1.0.0
     */
	function infosTab(){
        return get_view(__FILE__, 'admin/tabs/infos', $this->data);
	}


	/**
     * Category image
     *
     * @since 1.0.0
     */
	function imageTab(){
		return get_view(__FILE__, 'admin/tabs/image', $this->data);
	}


	/**
     * Category SEO
     *
     * @since 1.0.0
     */
	function seoTab(){
		return get_view(__FILE__, 'admin/tabs/seo', $this->data);
	}



//END CLASS	
}