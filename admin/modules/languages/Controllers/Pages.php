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
namespace CoreModules\Languages\Controllers;

use Core\Controllers\Admin\PageController;

class Pages extends PageController {

    public function __construct()
    {
        self::$buttons = [];
        self::$buttons = [
            [
                'label' => trans('Languages', 'lang'),
                'class' => 'btn btn-primary',
                'icon' => 'fa fa-globe',
                'link' => get_page_url('langs', __FILE__)
            ],
            [
                'label' => trans('Strings translations', 'lang'),
                'class' => 'btn btn-default',
                'icon' => 'fa fa-list',
                'link' => get_page_url('strings', __FILE__)
            ],
            [
                'label' => trans('Settings', 'lang'),
                'class' => 'btn btn-success',
                'icon' => 'fa fa-cogs',
                'link' => get_page_url('settings', __FILE__)
            ]
        ]; 
       switch (get_url_param('page')) {
           case 'langs':
               self::$buttons[0] = [
                    'label' => trans('Create new Language', 'lang'),
                    'class' => 'btn btn-primary',
                    'icon' => 'fa fa-plus',
                    'link' => get_page_url('lang', __FILE__)
                ];
               break;
            case 'strings':
               unset(self::$buttons[1]);
               break;
            case 'settings':
               unset(self::$buttons[2]);
               break;
       }
    }


    /**
     * Languages list
     *
     * @since 1.0.0
     */
    public function pageLangs() {
        self::$title = trans('Languages', 'lang');
        self::$icon = 'fa fa-globe';
        return get_view(__FILE__, 'admin/langs', [
            'langs' => getDB()->all('langs')
        ]);
    }

    /**
     * Create new Language
     *
     * @since 1.0.0
     */
    public function pageLang() {
        self::$title = trans('Create new Language', 'lang');
        self::$icon = 'fa fa-plus';
        return get_view(__FILE__, 'admin/lang', [
            // 'langs' => getDB()->all('langs')
        ]);
    }


    /**
     * Languages Strings
     *
     * @since 1.0.0
     */
    public function pageStrings() {
        self::$title = trans('Strings translations', 'lang');
        self::$icon = 'fa fa-list';
        return get_view(__FILE__, 'admin/strings', [
            'strings' => get_meta_value('core_lang_strings')
        ]);
    }


	/**
     * Settings page
     *
     * @since 1.0.0
     */
	public function pageSettings() {
        self::$title = trans('Settings', 'lang');
        self::$icon = 'fa fa-cogs';
        return get_view(__FILE__, 'admin/settings', [
            'settings' => get_meta_value('core_lang_settings')
        ]);
	}





//END CLASS	
}