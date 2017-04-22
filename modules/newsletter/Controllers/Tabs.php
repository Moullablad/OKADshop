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
namespace Modules\Newsletter\Controllers;

use Core\Tab;

class Tabs {

	protected $options;


	public function __construct() {
		$options = unserialize( get_meta_value('newsletter_options') );
		$this->options = (is_array($options)) ? $options : [];
		Tab::addTabs(__FILE__, 'settings', [
			'subscribers' => [
				'name' => trans('Subscribers', 'sauth'),
				'function' => array($this, 'SubscribersTab'),
				'with_form' => false,
				'position' => 1
			],
			'settings' => [
				'name' => trans('Settings', 'sauth'),
				'function' => array($this, 'SettingsTab'),
				'with_form' => true,
				'position' => 2
			],			
        ]);
		add_action('before_tab_settings', array($this, 'saveConfig'));
	}


	/**
     * Save Config
     *
     * @since 1.0.0
     */
	function saveConfig(){
		// Proccess posted data
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !is_ajax() ){
			$upload_error = false;
			$options = array_replace_recursive($this->options, $_POST);
			if( isset($_FILES['bg_image']) && $_FILES['bg_image']['size'] > 0 ){
				// Check if image feet required dementions
				$image = getimagesize($_FILES["bg_image"]["tmp_name"]);
				$image_width = $image[0];
				$image_height = $image[1];
				if( $image_width < 770 || $image_height < 440 ) {
					$upload_error = true;
					set_flash_message('danger', trans('Image dimensions should be 770x440.', 'nl'));
				} else {
					// Upload image
	                $upload = upload_medias($_FILES['bg_image'], array(
	                    'title' => 'bg_image',
	                    'extensions' => array('jpg', 'png'),
	                    'uploadDir' => 'uploads/modules/newsletter/'
	                ));
	                if( isset($upload['files']) ){
	                    $options['bg_image'] = 'uploads/modules/newsletter/' . $upload['files'][0];
	                }
				}
            }

            if( ! $upload_error ) {
				$formName = get_url_param('tab') .'_form';
				unset($options[$formName]);
				save_meta_value('newsletter_options', serialize($options));
				set_flash_message('success', trans('Settings was updated.', 'nl'));
            }
		}
		$this->options = unserialize( get_meta_value('newsletter_options') );
	}



	/**
     * Subscribers Tab
     *
     * @since 1.0.0
     */
	function SubscribersTab(){
		$subscribers = getDB()->all('newsletter');
		return get_view(__FILE__, 'admin/tabs/subscribers', [
			'subscribers' => $subscribers
		]);
	}

	/**
     * Settings Tab
     *
     * @since 1.0.0
     */
	function SettingsTab(){
		return get_view(__FILE__, 'admin/tabs/settings', $this->options);
	}
	



//END CLASS	
}