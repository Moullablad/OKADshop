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

use PHPImageWorkshop\ImageWorkshop;

use Core\Uploader;

class Image
{


    /**
     * Singleton int
     * @var Singleton $instance
     */
    private static $instance;


    /**
     * GET THEME INSTANCE
     * @return object $instance
     */
    public static function getInstance()
    {
        if( is_null(self::$instance) ){
            self::$instance = new Image();
        }
        return self::$instance;
    }



    /**
     *=============================================================
     * GET IMAGE BY SIZE
     *=============================================================
     * @param $image_name string
     * @param $id_product int
     * @param $size string
     * @return $results (array)
     * @throws Exception
     */
    public static function getImageBySize($image_name, $imageDir, $size=null){
        try {
            if( $image_name == "" || $imageDir == "" )
                return false;

            //get image extention
            $extention = self::getExtension($image_name);
            $filename  = str_replace(".".$extention, "", $image_name);

            //get image full path
            $full_path = $imageDir . $filename . '-' . $size . '.' . $extention;
            if( file_exists(site_base($full_path)) ){
                return site_url($full_path);
            } else {
                return site_url($imageDir . $filename . '.' . $extention); //Real image
            }

            //return default image
            return self::defaultImage($size);

        } catch (ControllerException $e) {
            exit;
        }
    }


    /**
     *=============================================================
     * GET EXTENSION
     *=============================================================
     * @param $filename string
     * @return $extension string
     * @throws Exception
     */
    public static function getExtension($filename){
        return pathinfo($filename, PATHINFO_EXTENSION);
    }

    /**
     *=============================================================
     * GET FILE NAME
     *=============================================================
     * @param $file string
     * @return $filename string
     * @throws Exception
     */
    public static function getFileName($file){
        $extension = self::getExtension($file);
        $file_name = explode('.'.$extension, $file);
        $file_name = basename($file_name[0]);
        return $file_name;
    }


    /**
     *=============================================================
     * DEFAULT IMAGE
     *=============================================================
     * @return $image_url string
     * @throws Exception
     */
    public static function defaultImage($size=null){
        if( is_null($size) )
            return _HOME_URL_ . 'assets/img/defaults/76x76.png';

        $imagePath = 'assets/img/defaults/'.$size.'.png';
        if( !file_exists(_BASE_URI_ . $imagePath) )
            return _HOME_URL_ . 'assets/img/defaults/76x76.png';

        return _HOME_URL_ . $imagePath;
    }


    /**
     *=============================================================
     * Upload Image
     *=============================================================
     * @param array $files
     * @param string $uploadDir
     * @param string $file_name
     * @return $files_path || $errors
     * @throws Exception
     */
    public static function uploadImage($files=array(), $uploadDir, $file_name=null)
    {
        //Create directory if not exist
        if (!file_exists($uploadDir)) {
          mkdir($uploadDir, 0777, true);
        }

        //Start uploading files
        $uploader = new Uploader();
        $options = array(
          'extensions' => array('png', 'jpg', 'jpeg', 'gif'),
          'uploadDir' => $uploadDir,
        );
        if( !is_null($file_name) ) $options['title'] = $file_name;

        $data = $uploader->upload($files, $options);
        if($data['hasErrors']) return false;
        if($data['isComplete']){
          $files_path = $data['data']['files'];
          return $files_path;
        }
    }


    


    /**
     *=============================================================
     * RESIZE IMAGE
     *=============================================================
     * @param $image_path string
     * @param $image_sizes array
     * @param $file_target string
     * @return true
     * @throws Exception
     */
    public static function resizeImage($image_path, $image_sizes=array('45x45'), $file_target=null)
    {
        try {
            //set file target
            if( is_null($file_target) )
                $file_target = dirname($image_path)."/";

            //get image name
            $image_name = self::getFileName($image_path);
            $extention = self::getExtension($image_path);

            //resize images
            foreach ($image_sizes as $key => $image_size) {
                if( file_exists($image_path) ){
                    $size = explode("x", $image_size);
                    $image_output = $image_name ."-". $image_size .".". $extention;
                    $layer = ImageWorkshop::initFromPath( $image_path );
                    $layer->resizeInPixel($size[0], $size[1], true, 0, 0, 'MM');
                    $layer->save( $file_target, $image_output, true, null, 95);
                }
            }

            return true;
        } catch (Exception $e) {
            exit;
        }
    }






//END CLASS
}