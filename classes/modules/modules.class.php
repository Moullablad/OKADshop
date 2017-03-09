<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Modules extends OS_Common
{

     

    /**
     *=============================================================
     * Get Module ID
     *=============================================================
     * @param int $Mod
     * @throws Exception
     * @return $result (int) || 0 (int) || error (string)
     */
    public static function getID($Mod)
    {
      $Security = new Security();
      if($Security->check_noSpecialCaracters($Mod))
      {
        $DB = Database::getInstance();
        $sql = "select id from "._DB_PREFIX_."modules where title = '$Mod' and deleted = 0";
        $query=$DB->pdo->query($sql);
        $query->execute();
        if($query->rowCount() > 0)
        {
          $result = $query->fetch(PDO::FETCH_ASSOC);
          return $result['id'];
        }else{
          return 0;
        }
      }else{
        return 'error';
      }
    }


    /**
     *=============================================================
     * Get Module Categories
     *=============================================================
     * @throws Exception
     * @return $data (array)
     */
    public function getModuleCategories()
    {
      try {
        $DB = Database::getInstance();
        $query = "SELECT `id`,`name`, `slug` FROM `"._DB_PREFIX_."modules_categories`";
        if($res = $DB->pdo->query($query)){
          $data = $res->fetchAll(PDO::FETCH_ASSOC);
          if(!empty($data)) return $data;
        }
      } catch (Exception $e) {
        echo "Get Module Categories Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
      }
    }


    /**
     *=============================================================
     * Get Module Informations
     *=============================================================
     * @throws Exception
     * @return $data (array)
     */
    public function getModuleInfos($slug)
    {
      try {
        $DB = Database::getInstance();
        $query = "SELECT `name`, `description` FROM `"._DB_PREFIX_."modules` WHERE `slug`='$slug'";
        if($res = $DB->pdo->query($query)){
          $data = $res->fetchAll(PDO::FETCH_ASSOC);
          if(!empty($data)) return $data[0];
        }
      } catch (Exception $e) {
        echo "Get Module Informations Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
      }
    }


    /**
     *=============================================================
     * Get Sections
     *=============================================================
     * @throws Exception
     * @return $data (array)
     */
    public function getSections()
    {
      try {
        $DB = Database::getInstance();
        $query = "SELECT * FROM `"._DB_PREFIX_."sections`";
        if($res = $DB->pdo->query($query)){
          $data = $res->fetchAll(PDO::FETCH_ASSOC);
          if(!empty($data)) return $data;
        }
      } catch (Exception $e) {
        exit;
      }
    }


    /**
     *=============================================================
     * Get Position ID by name
     *=============================================================
     * @throws Exception
     * @return $data (array)
     */
    public function getPositionIDBySlug($slug)
    {
      try {
        $DB = Database::getInstance();
        $query = "SELECT `id` FROM `"._DB_PREFIX_."sections` WHERE slug='$slug'";
        if($res = $DB->pdo->query($query)){
          $data = $res->fetch(PDO::FETCH_ASSOC);
          if(!empty($data)) return $data['id'];
        }
      } catch (Exception $e) {
        exit;
      }
    }




    /**
     *=============================================================
     * Scan Modules In Directory
     *=============================================================
     * @throws Exception
     * @return $data (array)
     */
    public function scanModulesInDirectory()
    {
      try {
        $modules_array = array();
        $modules_directory = "../../../../modules/";
        // Open a directory, and read its contents
        if (is_dir($modules_directory))
        {
          if ($dir = opendir($modules_directory) ){
            while (($module_name = readdir($dir)) !== false){
              if(!is_dir($module_name))
              {
                if($module_name != 'index.php')
                {
                  $module_path = $modules_directory.$module_name."/module.json";
                  if(file_exists($module_path)){
                    $module_infos = file_get_contents($module_path);
                    $array = json_decode($module_infos, true);
                    array_push($modules_array, $array[0]);
                  }
                }
              }
            }
            closedir($dir);
          }
        }
        return $modules_array;
      } catch (Exception $e) {
        exit;
      }
    }





    /**
     *=============================================================
     * Count Modules In Category
     *=============================================================
     * @param $id_category (int)
     * @throws Exception
     * @return $count (int)
     */
    public function countModulesInCategory($id_category)
    {
      try {
        $DB = Database::getInstance();
        $query = "SELECT COUNT(*) as count FROM `"._DB_PREFIX_."modules` WHERE `id_category`=$id_category";
        if($res = $DB->pdo->query($query)){
          $data = $res->fetch(PDO::FETCH_ASSOC);
          if(!empty($data)) return $data['count'];
        }
      } catch (Exception $e) {
        echo "Count Modules In Category Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
      }
    }


    /**
     *=============================================================
     * Get Module Slugs
     *=============================================================
     * @throws Exception
     * @return $data (array)
     */
    public function getModulesSlugs()
    {
      try {
        $DB = Database::getInstance();
        $query = "SELECT `slug`,`status` FROM `"._DB_PREFIX_."modules`";
        if($res = $DB->pdo->query($query)){
          $slugs = $res->fetchAll(PDO::FETCH_ASSOC);
          //if(!empty($slugs)){
            //$slug_list = array();
            //foreach ($slugs as $key => $slug) {
            //  array_push($slug_list, $slug['slug']);
            //}
            //if(!empty($slug_list)) return $slug_list;
         // }
          if(!empty($slugs)) return $slugs;
        }
      } catch (Exception $e) {
        echo "Get Module Slugs Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
      }
    }


    /**
     *=============================================================
     * Get Active Modules
     *=============================================================
     * @throws Exception
     * @return $data (array)
     */
    public function getActiveModules($position = "")
    {
      try {
        if($position == ""){
          $pos = "";
        }else{
          $pos = "AND s.slug='$position'";
        }
        $DB = Database::getInstance();
        $query = "SELECT m.slug, m.id as id_module, m.name as modname, s.id as id_section, s.slug as position
                  FROM "._DB_PREFIX_."modules m, "._DB_PREFIX_."sections s, "._DB_PREFIX_."modules_sections ms
                  WHERE s.id = ms.id_section AND m.id = ms.id_module $pos AND m.status='1'
                  ORDER BY ms.position ASC";
        if($res = $DB->pdo->query($query)){
          $slugs = $res->fetchAll(PDO::FETCH_ASSOC);
          $slug_array = array();
          foreach ($slugs as $key => $value) {
            array_push($slug_array, $value);//['slug']
          }
          if(!empty($slug_array)) return $slug_array;
        }
      } catch (Exception $e) {
        echo "Get Active Modules Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
      }
    }


    /**
     *=============================================================
     * get all active modules
     *=============================================================
     * @throws Exception
     * @return $data (array)
     */
    public function get_all_active_modules()
    {
      try {
        $DB = Database::getInstance();
        $query = "SELECT `slug` FROM `"._DB_PREFIX_."modules` WHERE `status`=1";
        if($res = $DB->pdo->query($query)){
          $data = $res->fetchAll(PDO::FETCH_ASSOC);
          if(!empty($data)) return $data;
        }
      } catch (Exception $e) {
        exit;
      }
    }


    /**
     *=============================================================
     * get active modules by position
     *=============================================================
     * @throws Exception
     * @return $data (array)
     */
    public function get_active_modules_by_position($position)
    {
      try {
        global $DB;
        $id_section = self::getPositionIDBySlug($position);
        $query = "SELECT m.name, m.slug FROM "._DB_PREFIX_."modules m
                  INNER JOIN "._DB_PREFIX_."modules_sections ms ON ms.id_module = m.id 
                  WHERE ms.id_section=$id_section ORDER BY ms.position ASC";
        if($res = $DB->pdo->query($query)){
          $data = $res->fetchAll(PDO::FETCH_ASSOC);
          if(!empty($data)) return $data;
        }
      } catch (Exception $e) {
        exit;
      }
    }


    /**
     *=============================================================
     * Get Module Sections
     *=============================================================
     * @throws Exception
     * @return $data (array)
     */
    public function getModulesSections()
    {
      try {
        $DB = Database::getInstance();
        $query = "SELECT `slug` FROM `"._DB_PREFIX_."sections`";
        $sections_arr = array();
        if($res = $DB->pdo->query($query)){
          $sections = $res->fetchAll(PDO::FETCH_ASSOC);
          foreach ($sections as $key => $value) {
            array_push($sections_arr, $value['slug']);
          }
          //$hooks_arr = call_user_func_array('array_merge', $hooks_arr);
          if(!empty($sections_arr)) return $sections_arr;
        }
      } catch (Exception $e) {
        echo "Get Module Sections Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
      }
    }



    /**
     *=============================================================
     * get_modules_in_section
     *=============================================================
     * @throws Exception
     * @return $data (array)
     */
    public function get_modules_in_section($id_section)
    {
      try {
        $DB = Database::getInstance();
        $query = "SELECT `id_module` FROM `"._DB_PREFIX_."modules_sections` WHERE `id_section`=$id_section";
        $id_mod_arr = array();
        if($res = $DB->pdo->query($query)){
          $rows = $res->fetchAll(PDO::FETCH_ASSOC);
          foreach ($rows as $key => $value) {
            array_push($id_mod_arr, $value['id_module']);
          }
          //if(!empty($id_mod_arr)) 
          return $id_mod_arr;
        }
      } catch (Exception $e) {
        exit;
      }
    }


    



  /**
   *=============================================================
   * Get Module By Slug
   *=============================================================
   * @param string $slug
   * @return $id (int)
   * @throws Exception
   */
  public function get_module_by_slug($slug)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id,name FROM "._DB_PREFIX_."modules WHERE slug='$slug'";
      $row = $DB->pdo->query($query);  
      $data = $row->fetch(PDO::FETCH_ASSOC);
      if(!empty($data)){
        return $data;
      }else{
        return false;
      }
    } catch (Exception $e) {
      echo "Get Module By Slug Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get Category ID By Name
   *=============================================================
   * @param string $name
   * @return $data['id'] (int)
   * @throws Exception
   */
  public function getCategoryByName($name)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id FROM "._DB_PREFIX_."modules_categories WHERE name='$name'";
      $row = $DB->pdo->query($query);  
      $data = $row->fetch(PDO::FETCH_ASSOC);
      if(!empty($data['id'])) return $data['id'];
    } catch (Exception $e) {
      echo "Get Category By Name Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get Category ID By slug
   *=============================================================
   * @param string $slug
   * @return $data['id'] (int)
   * @throws Exception
   */
  public function get_category_by_slug($slug)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT id FROM "._DB_PREFIX_."modules_categories WHERE slug='$slug'";
      $row = $DB->pdo->query($query);  
      $data = $row->fetch(PDO::FETCH_ASSOC);
      if(!empty($data['id'])) return $data['id'];
    } catch (Exception $e) {
      echo "Get Category By Name Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Get Module By Location
   *=============================================================
   * @param string $location
   * @return modules (array)
   * @throws Exception
   */
  public function getModuleSlugByLocation($location)
  {
    try {
      $DB = Database::getInstance();
      $query = "SELECT slug FROM "._DB_PREFIX_."modules WHERE location='$location'";
      $rows = $DB->pdo->query($query);  
      $modules = $rows->fetchAll(PDO::FETCH_ASSOC);
      if(!empty($modules)) return $modules;
    } catch (Exception $e) {
      echo "Get Module By Location Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }


  /**
   *=============================================================
   * Delete Module
   *=============================================================
   * @param string $slug
   * @return true
   * @throws Exception
   */
  public function deleteModule($slug)
  {
    try {
      $DB = Database::getInstance();
      $query = "DELETE FROM "._DB_PREFIX_."modules WHERE slug='$slug'";
      if($DB->pdo->query($query)){
        return true;
      }else{
        return false;
      }
    } catch (Exception $e) {
      echo "Delete Module Error at Line: ".$e->getLine()."<br> <strong>WITH MESSAGE:</strong> ".$e->getMessage();
    }
  }



/*============================================================*/
} //END PRODUCT CLASS
/*============================================================*/
?>