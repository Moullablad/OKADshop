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

use Core\Ajax;
use \Core\i18n\Translate;


class Languages {

    protected static $instance;


    /**
     * Get instance.
     *
     * @wp-hook plugins_loaded
     * @see    __construct()
     * @return void
     */
    public static function getInstance()
    {
        if( is_null(self::$instance) ){
            self::$instance = new self;
        }
        return self::$instance;
    }


    /**
     * Register the action
     */
    public function __construct()
    {
        // Add admin menu links
        global $os_admin_menu;
        $langs = $os_admin_menu->add( trans('Languages', 'lang'), get_page_url('langs', __FILE__));
        $langs->link->prepend('<span class="fa fa-language"></span>');
        $langs->add( trans('Languages', 'lang'), get_page_url('langs', __FILE__));
        $langs->add( trans('Strings translations', 'lang'), get_page_url('strings', __FILE__));
        // $langs->add( trans('Settings', 'lang'), get_page_url('settings', __FILE__));

        add_css('languages-css', [
            'src' => module_url(__FILE__, 'assets/css/languages.css'), 
            'admin' => true
        ]);

        add_css('flagstrap-flags', [
            'src' => module_url(__FILE__, 'assets/vendors/flagstrap/flags.css'), 
            'admin' => true
        ]);

        add_js('flagstrap', [
            'src' => module_url(__FILE__, 'assets/vendors/flagstrap/jquery.flagstrap.min.js'), 
            'admin' => true
        ]);

        add_js('languages-js', [
            'src' => module_url(__FILE__, 'assets/js/languages.js'), 
            'admin' => true
        ]);

        Ajax::addAction('date_time_format', array($this, 'dateTimeFormat'));
        Ajax::addAction('get_strings', array($this, 'getStrings'));
        Ajax::addAction('get_trans_location_by_group', array($this, 'getLocations'));
        Ajax::addAction('update_string', array($this, 'updateString'));
    }


    /**
     * Update String
     */
    function updateString($args)
    {
        $strings = self::getSavedStrings();
        $strings[$args['iso_code']][$args['location']][$args['msgid']] = $args['msgstr'];
        if( save_meta_value('strings_translations', serialize($strings)) ) {
            return ['success' => trans('String was updated.', 'lang')];
        }
        return ['error' => trans('Unable to update string.', 'lang')];
    }


    public static function getSavedStrings()
    {
        $strings = array();
        if( $saved_strings = unserialize(get_meta_value('strings_translations')) ) {
            $strings = $saved_strings;
        }
        return $strings;
    }



    /**
     * Get strings
     */
    function getStrings($args)
    {
        $location = $args['location'];
        $iso_code = $args['iso_code'];

        switch ($args['group']) {
            case 'themes':
                $filePath = site_base('themes/'. $location .'/languages/'. $iso_code .'.po');
                break;

            case 'modules':
                $index = get_module_index($location);
                $filePath = str_replace('index.php', 'languages/'. $iso_code .'.po', $index);
                break;
            
            default:
                $filePath = site_base('languages/'. $iso_code .'.po');
                break;
        }

        $strings = array();
        $filterResults = '';
        if( file_exists($filePath) ) {
            $parser = new Parser();
            $data = $parser->read($filePath);

            // get saved strings
            $saved_strings = self::getSavedStrings();

            if( !empty($data) ) {
                unset($data['']);
                foreach ($data as $msgid => $value) {
                    if( isset($saved_strings[$iso_code][$location][$msgid]) ) {
                        $msgstr = $saved_strings[$iso_code][$location][$msgid];
                    } else if(isset($value['msgstr'][0]) && $value['msgstr'][0] != '') {
                        $msgstr = $value['msgstr'][0];
                    } else {
                        $msgstr = $msgid;
                    }
                    $msgstr = '<span class="hidden">'.$msgstr.'</span><input autocomplete="off" class="form-control msgstr" type="text" value="'.$msgstr.'">';
                    $strings[] = array($msgid, $msgstr);
                }
            }
        }

        return json_encode($strings);
    }

    /**
     * Get Trans Locations
     */
    public function getLocations($args) {
        return self::getTransLocationByGroup($args['group']);
    }


    /**
     * Get Trans Location By Group
     */
    public static function getTransLocationByGroup($group_id) {
        $groups = array();
        switch ($group_id) {
            case 'themes':
                foreach (get_themes() as $key => $theme) {
                    $groups[$theme['name']] = $theme['displayName'];
                }
                break;

            case 'modules':
                foreach (get_modules() as $key => $module) {
                    $groups[$module['name']] = $module['displayName'];
                }
                break;
            
            default:
                $groups['core'] = trans('Core strings', 'core');
                break;
        }
        return $groups;
    }


    public function dateTimeFormat($args)
    {
        return ['date' => date($args['date'])];
    }


    public static function getByID($id_lang)
    {
        return getDB()->find('languages', $id_lang);
    }


    public static function create($columns)
    {
        // Get Database instance
        $db = getDB();
        unset(
            $columns['info_form'],
            $columns['id_lang']
        );
        if( !isset($columns['direction']) ) $columns['direction'] = 0;
        if( !isset($columns['active']) ) $columns['active'] = 0;
        $columns['cdate'] = $columns['udate'] = date("Y-m-d H:i:s");

        if( isset($columns['default_lang']) ) {
            $db->prepare("UPDATE `{$db->prefix}languages` SET `default_lang`=0");
        }

        $exist = $db->findByColumn('languages', 'iso_code', $columns['iso_code']);
        if( !empty($exist) ) {
            return false;
        }
        return $db->create('languages', $columns);
    }


    public static function update($columns)
    {
        // Get Database instance
        $db = getDB();
        unset(
            $columns['info_form'],
            $columns['id_lang']
        );
        if( !isset($columns['direction']) ) $columns['direction'] = 0;
        if( !isset($columns['default_lang']) )   $columns['default_lang'] = 0;
        if( !isset($columns['active']) )    $columns['active'] = 0;
        $columns['cdate'] = $columns['udate'] = date("Y-m-d H:i:s");

        if( isset($columns['default_lang']) ) {
            $db->prepare("UPDATE `{$db->prefix}languages` SET `default_lang`=0");
        }

        return $db->update('languages', $_GET['id'], $columns);
    }


    /**
     * Scan directory for strings
     */
    function stringsScan($directory) {
        $data = array();
        $files = self::FilesRecursiveGet($directory);
        foreach($files as $v) {
            $extention = pathinfo($v, PATHINFO_EXTENSION);
            if( !in_array($extention, ['php', 'js']) ) continue;

            preg_match_all("/trans[\s]*\([\s]*[\'\"](.*?)[\'\"].*?\)/uis", $pv, $m);

            // preg_match_all("/(?:\<\?.*?\?\>)|(?:\<\?.*?[^\?]+[^\>]+)/uis", file_get_contents($v), $p);
                echo $extention .'<br>';
                var_dump($m); echo '<hr>';


            /*if ( preg_match("/\/.*?\.[a-z0-9]+$/uis", $v) ) {
                if (count($p[0])) {
            // echo $extention .'<br>';
                    foreach ($p[0] as $pv) {
                        preg_match_all("/trans[\s]*\([\s]*[\'\"](.*?)[\'\"].*?\)/uis", $pv, $m);
                        if (count($m[0])) {
                            foreach ($m[1] as $mv) {
                                if (!in_array($mv, $data)) {
                                    $data[] = $mv;
                                }
                            }
                        }
                    }
                }
            }*/
        }

        // return $data;


        /*if ( !isset($_REQUEST['page']) || $_REQUEST['page'] != 'mlang' || !isset($_REQUEST['tab']) || $_REQUEST['tab'] != 'strings' ) return;

        $plugins = array('sht-books', 'sht-forms', 'sht-advanced-search', 'sht-last-seens');
        foreach ($plugins as $key => $plugin) {
            $data = array(
                'name'    => $plugin,
                'strings' => array()
            );

            $plugin_path = WP_PLUGIN_DIR .'/'. $plugin .'/';
            if (file_exists($plugin_path)) {
                $files = files_recursive_get($plugin_path);
                foreach($files as $v) {
                    if ( preg_match("/\/.*?\.[a-z0-9]+$/uis", $v) ) {
                        preg_match_all("/(?:\<\?.*?\?\>)|(?:\<\?.*?[^\?]+[^\>]+)/uis", file_get_contents($v), $p);

                        if (count($p[0])) {
                            foreach ($p[0] as $pv) {
                                preg_match_all("/pll_[_e][\s]*\([\s]*[\'\"](.*?)[\'\"].*?\)/uis", $pv, $m);
                                if (count($m[0])) {
                                    foreach ($m[1] as $mv) {
                                        if (!in_array($mv, $data)) {
                                            $data['strings'][] = $mv;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                update_option(str_replace('-', '_', $plugin) .'_data', $data);
            }
        }*/ /* endforeach */       
    }


    public static function FilesRecursiveGet($dir)
    {
        $files = array();
        if ($h = opendir($dir))
        {
            while (($item = readdir($h)) !== false)
            {
                $f = $dir . '/' . $item;
                if (is_file($f))
                {
                    $files[] = $f;
                }
                else
                if (is_dir($f) && !preg_match("/^[\.]{1,2}$/uis", $item))
                {
                    $files = array_merge($files, self::FilesRecursiveGet($f));
                }
            }
            closedir($h);
        }
        return $files;
    }



//END CLASS 
}