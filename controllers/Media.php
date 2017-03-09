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

namespace Core;

use Core\Uploader;

class Media {
	
	/**
     * CSS array
     * @var CSS $styles
     */
    private static $styles;
	
	/**
     * Javascript array
     * @var Javascript $scripts
     */
    private static $scripts;



    /**
     * Register a CSS stylesheet.
     *
     * @param string $unique_id
     * @param array  $params
     *
     * @return void
     */
    public static function addCSS($unique_id, $params=[]){
        if( empty($params) && isset(self::$styles[$unique_id]) ){
            unset(self::$styles[$unique_id]);
        } else {
            $default = [
                'version' => false,
                'media'   => 'all',
                'admin'   => false,
                'front'   => true
            ];
            $array = array_merge($default, $params);
            if( \is_admin() ){
                if( $array['admin'] !== false ){
                    self::$styles[$unique_id] = $array;
                }
            } elseif ( $array['front'] !== false ){
                self::$styles[$unique_id] = $array;
            } 
        }
    }

    /**
     * Get styles.
     *
     * @return array $styles
     */
    public static function getStyles(){
        return self::$styles;
    }

    /**
     * Register a javascript.
     *
     * @param string $unique_id
     * @param array  $params
     *
     * @return void
     */
    public static function addJS($unique_id, $params=[]){
        if( empty($params) && isset(self::$scripts[$unique_id]) ){
            unset(self::$scripts[$unique_id]);
        } else {
            $default = [
                'version'   => false,
                'media'     => 'all',
                'admin'     => false,
                'front'     => true,
                'in_footer' => true
            ];
            $array = array_merge($default, $params);
            if( \is_admin() ){
                if( $array['admin'] !== false ){
                    self::$scripts[$unique_id] = $array;
                }
            } elseif ( $array['front'] !== false ){
                self::$scripts[$unique_id] = $array;
            }
        }
    }


    /**
     * Get scripts.
     *
     * @return array $scripts
     */
    public static function getScripts(){
        return self::$scripts;
    }



    /**
     * Upload Medias
     *
     * @param $files array
     * @param $options array
     *
     * @return $files || $errors
     */
    public static function upload($files=array(), $options=array())
    {
        $default = array(
            'extensions' => null,
            'uploadDir' => 'uploads/',
            'title' => array('auto', 15)
        );
        $args = array_merge($default, $options);
        $uploadDir = site_base() . $args['uploadDir'];
        //Create directory if not exist
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
        $args['uploadDir'] = $uploadDir;
        //Start uploading files
        $uploader = new Uploader();
        $upload = $uploader->upload($files, $args);
        if($upload['hasErrors']){
            $return['errors'] = $upload['errors'];
        } else if($upload['isComplete']){
            $return['files'] = str_replace($args['uploadDir'], '', $upload['data']['files']);
        }
        return $return;
    }



    /**
     *
     * UPLOAD ATTACHMENT
     *
     * @param array $files
     * @param string $uploadDir
     * @param string $file_name
     *
     * @return $files_path || $errors
     */
    public static function uploadAttachment($files=array(), $uploadDir, $file_name=null)
    {
        //Create directory if not exist
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
        
        //Start uploading files
        $uploader = new Uploader();
        $options = array(
          'extensions' => array('jpg', 'gif', 'png', 'doc', 'ppt', 'odt', 'docx', 'xlsx', 'pptx', 'psd' , 'rar', 'zip'),
          'uploadDir' => $uploadDir,
        );
        if( !is_null($file_name) ) $options['title'] = $file_name;

        $data = $uploader->upload($files, $options);
        if($data['hasErrors']) return false;
        if($data['isComplete']){
            return $data['data']['files'];
        }
    }



//END CLASS	
}