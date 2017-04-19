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
namespace CoreModules\Languages\Controllers;

use Core\Tab;

class LanguageTabs extends Tab {


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
            self::$instance = new LanguageTabs();
        }
        return self::$instance;
    }


	public function __construct() {
		self::addTabs(__FILE__, 'lang', array(
			'info' => array(
				'name' => trans("Informations", "cats"),
				'function' => array($this, 'infosTab'),
				'with_form' => true,
				'position' => 1
			)
		));
		add_action('before_tab_lang', array($this, 'submitForm'));
	}

	/**
     * Save form data if submited or set default values
     *
     * @since 1.0.0
     */
	function submitForm(){
		// Proccess posted data
		if( form_submited() ) {
			if( isset($_GET['id']) ) {
                if( Languages::update($_POST) ) {

                } else {
                    set_flash_message('danger', trans('The language code must be unique.', 'lang'));
                }
			} else {
				if( $id_lang = Languages::create($_POST) ) {
					header("Location: ". get_page_url('lang&id='.$id_lang, __FILE__));
				} else {
                    set_flash_message('danger', trans('The language code must be unique.', 'lang'));
                }
			}
		}

		// get language data
        if( isset($_GET['id']) ) {
            $this->data['lang'] = Languages::getByID($_GET['id']);
            if( empty($this->data['lang']) || !is_valid_int($_GET['id']) ) {
                set_flash_message('danger', trans('Could not find the requested language.', 'lang'));
                header("Location: ". get_page_url('lang', __FILE__));
                exit;
            }
        }
	}



	/**
     * Language informations
     *
     * @since 1.0.0
     */
	function infosTab(){
        return get_view(__FILE__, 'admin/tabs/infos', $this->data);
	}


//END CLASS	
}