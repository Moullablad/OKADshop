<?php
//run session
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

use Core\Image;
use Core\Controllers\Admin\ModuleController;

class Okad_Install {


	public function runSQL($file){
        if( file_exists($file) ){
            global $db;
            $content = file_get_contents($file);
            $query = utf8_decode($content);
            $prefixed_query = str_replace('%%', $db->prefix ,$query);
            $stmt = $db->pdo->prepare($prefixed_query);
            if( $stmt->execute() ) return true;
        }
        return false;
    }


    public function writeConfig( $filename, $config ) {
        $fh = fopen($filename, "w");
        if (!is_resource($fh)) {
            return false;
        }
        fwrite($fh, '<?php '. print_r($config, true) );
        fclose($fh);
        return true;
    }


    public function getJson($file_path) {
        try {
            if( file_exists( $file_path ) ){
                $file_data = file_get_contents( $file_path );
                $data = json_decode( $file_data, true );
                if( !empty( $data ) ) return $data;
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    public function createUser($data){
        global $db;
        return $db->create('users', array(
            'id_gender' => 1,
            'id_country' => $data['id_country'],
            'id_lang' => 1,
            'first_name' => $data['firstname'],
            'last_name' => $data['lastname'],
            'email' => $data['email'],
            'password' => $data['password'],
            'active' => 'actived',
            'user_type' => 'admin',
            'password' => md5($data['password'])
        ));
    }


    public function createShop($data){
        global $db;
        $lastId = $db->create('shop', array(
            'id_activity' => $data['activity'],
            'id_country' => $data['id_country'],
            'email' => $data['email'],
            'phone' => '00 00 000 000',
            'home_url' => $data['home_url'],
            'domain' => $data['domain'],
            'domain_ssl' => $data['domain_ssl'],
            'physical_uri' => $data['uri']
        ));
        if( !$lastId ) return false;
        return $db->create('shop_trans', array(
            'id_shop' => $lastId,
            'id_lang' => $data['id_lang'],
            'name' => $data['name'],
            'tagline' => 'Just another OKADshop site'
        ));
    }


    public function createLanguage(){
        global $db;
        global $languages;
        $code = ( isset($_SESSION['default_lang']) ) ? $_SESSION['default_lang'] : 'en_US';
        $lang = $languages[$code];
        $date = date("Y-m-d H:i:s");
        return $db->create("languages", array(
            'name' => $lang['name'], 
            'locale' => $code, 
            'iso_code' => $lang['iso_code'], 
            'flag' => $lang['iso_code'], 
            'date_format' => $lang['date_format'], 
            'datetime_format' => $lang['datetime_format'], 
            'direction' => $lang['direction'], 
            'default_lang' => 1, 
            'active' => 1,
            'cdate' => $date,
            'udate' => $date           
        ));
    }


    public function getImages($id_product) {
        global $db;
        return $db->prepare("SELECT id, name, position, futured FROM {$db->prefix}product_images WHERE id_product=? ORDER BY position ASC", [$id_product]);
    }


    public function resizeProductsImages(){
        //'45x45', , '80x80', '100x122', '120x45', '200x200', '570x697', '828x220'
        $sizes = array('76x76', '360x360');
        for ($i=1; $i <= 17; $i++) { 
            //get product images
            $images = $this->getImages($i);
            if( !empty($images) ){
                foreach ($images as $key => $image) {
                    $image_path  = site_base('files/products/'. $i .'/'. $image->name);
                    Image::resizeImage($image_path, $sizes);
                }
            }
        }
    }


    public function resizeCategoriesImages(){
        $sizes = array('140x35', '237x65');
        for ($i=1; $i <= 10; $i++) { 
            $image_path  = site_base('files/category/'. $i .'/'. $i .'.png');
	    $image_target = site_base('uploads/category/'. $i .'/');
            Image::resizeImage($image_path, $sizes, $image_target);
        }
    }


    public function installModules(){
        $modules = array(
            // Core Modules
            'core-account',
            'core-cart',
            'core-catalogs',
            'core-categories',
            'core-languages',
            'core-medias',
            'core-modules',
            'core-orders',
            'core-preferences',
            'core-seo',
            'core-tabs',
            'core-themes',
            // Front Modules
            'ads',
            'advanced-search',
            'bankwire',
            'blockcart',
            'blockhtml',
            'blocklanguages',
            'blocksocial',
            'cheque',
            'contact-form',
            'menus',
            'newsletter',
            'paypal',
            'quick-view',
            'superslider',
            'trending',
            'wishlist',
        );
        foreach ($modules as $key => $module) {
            ModuleController::install($module);
        }
    }

    

    


//END CLASS
}
