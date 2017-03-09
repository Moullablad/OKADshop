<?php
namespace Core;
use Core\Database\Database;
class OS_Common {

  public $os_scripts = array();
  public $os_styles = array();



  /**
   * generate random string
   * 
   * @param int    $length number of caracters.
   * 
   * @return array $os_scripts.
   **/
  public function generate_random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }



  /**
   * getLanguage
   * @return id_lang int
   **/
  public function getLanguage(){
    if( isset($_SESSION['id_lang']) ){
      return $_SESSION['id_lang'];
    } else{
      return 1;
    }
  }


  /**
   * add scripts to header
   * 
   * @param string $src file source.
   * @param int    $pos file position.
   * 
   * @return array $os_scripts.
   **/
  public function os_inject_scripts($src, $pos) {
    try {
      if( !in_array($src, $this->os_scripts) )
      {
        $this->os_scripts[]['src'] = $src;
        end($this->os_scripts);
        $key = key($this->os_scripts);
        $this->os_scripts[ $key ]['pos'] = $pos;
      }
    } catch (Exception $e) {
      exit;
    }
  }


  /**
   * render scripts
   * @return $javascript
   **/
  public function os_render_scripts() {
    try {
      $scripts = $this->msort($this->os_scripts, array('pos'));
      $javascript = "";
      foreach ($scripts as $key => $script) {
        $javascript .= '<script src="'.$script['src'].'" type="text/javascript" position="'.$script['pos'].'"></script>';
      }
      print $javascript;
    } catch (Exception $e) {
      exit;
    }
  }


  /**
   * add styles to header
   * 
   * @param string $src file source.
   * @param int    $pos file position.
   * 
   * @return array $os_styles.
   **/
  public function os_inject_styles($src, $pos) {
    try {
      if( !in_array($src, $this->os_styles) )
      {
        $this->os_styles[]['src'] = $src;
        end($this->os_styles);
        $key = key($this->os_styles);
        $this->os_styles[ $key ]['pos'] = $pos;
      }
    } catch (Exception $e) {
      exit;
    }
  }


  /**
   * render styles
   * @return $stylesheet
   **/
  public function os_render_styles(){
    try {
      $styles = $this->msort($this->os_styles, array('pos'));
      $stylesheet = "";
      foreach ($styles as $key => $style) {
        $stylesheet .= '<link href="'.$style['src'].'" position="'.$style['pos'].'" rel="stylesheet" type="text/css" />';
      }
      print $stylesheet;
    } catch (Exception $e) {
      exit;
    }
  }



  /**
   * get module page content
   * 
   * @param array $pages The array to pages.
   * 
   * @return html.
   **/
  public public function get_module_page_content($pages, $module_name=""){
    if( !isset($_GET['slug']) && $_GET['slug'] != $module_name ||
        !in_array($_GET['page'], $pages)
    ) return false;
      
    $page_path = _BASE_URI_ .'modules/'. $module_name .'/pages/'.$_GET['page'].'.php';
    $view_path = _BASE_URI_ .'modules/'. $module_name .'/views/admin/'.$_GET['page'].'.php';
    if( file_exists($view_path) ){
      include $view_path;
    } elseif( file_exists($page_path) ){
      include $page_path;
    }
    return false;
  }


  /**
   * get admin directory name
   *
   * 
   * @return string.
   **/
  public public function get_admin_directory_name($excludes=array()){
    $website_root = _BASE_URI_;
    if( empty($excludes) ){
      $excludes = array('.git', 'classes', 'config', 'files', 'functions', 'includes', 'install', 'languages', 'modules', 'os-updates', 'pdf', 'themes');
    }

    //get admin directory
    $directories = scandir($website_root);
    foreach ($directories as $key => $directory) {
      if( is_dir( $website_root. '/'. $directory) && !in_array($directory, $excludes) ) {
        $files = glob( $website_root. $directory ."/*.{php}", GLOB_BRACE);
        foreach ($files as $key => $full_path) {
          if (preg_match('/adminbar.php$/', $full_path)) {
            $admin_dir = dirname($full_path);
            $admin_dir = str_replace("\\", "/", $admin_dir);
            $admin_dir = str_replace($website_root, "", $admin_dir);
          }
        }
      }
    }

    if( $admin_dir != "" ) 
      return $admin_dir;
    return false;
  }


  


  /**
   * Sort a 2 dimensional array based on 1 or more indexes.
   * 
   * msort() can be used to sort a rowset like array on one or more
   * 'headers' (keys in the 2th array).
   * 
   * @param array        $array      The array to sort.
   * @param string|array $key        The index(es) to sort the array on.
   * @param int          $sort_flags The optional parameter to modify the sorting 
   *                                 behavior. This parameter does not work when 
   *                                 supplying an array in the $key parameter. 
   * 
   * @return array The sorted array.
   */
  public function msort($array, $key, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
      if (!empty($key)) {
        $mapping = array();
        foreach ($array as $k => $v) {
          $sort_key = '';
          if (!is_array($key)) {
            $sort_key = $v[$key];
          } else {
            // @TODO This should be fixed, now it will be sorted as string
            foreach ($key as $key_key) {
              $sort_key .= $v[$key_key];
            }
            $sort_flags = SORT_STRING;
          }
          $mapping[$k] = $sort_key;
        }
        asort($mapping, $sort_flags);
        $sorted = array();
        foreach ($mapping as $k => $v) {
          $sorted[] = $array[$k];
        }
        return $sorted;
      }
    }
    return $array;
  }




  /**
   *==============================================
   * get exception error
   *==============================================
   * @param $e
   * @throws Exception
   */
  public public function get_exception_error($e){
    try {
      $message = "<b>ERROR AT LINE [". $e->getLine() ."] </b><br>". $e->getMessage();
      return $message; 
    } catch (Exception $e) {
      echo "<b>ERROR FROM GET EXCEPTION ERROR FUNCTION";
    }
  }



  /**
   *===================================================
   * run sql file
   * to get file path in your module do the folowing
   * $module_path = dirname(__DIR__);
   * $file = $module_path .'/[module-name]/[path-to]/[file-name].sql';
   *===================================================
   * @param $e
   * @throws Exception
   */
  public function run_sql_file( $file ){
    if( file_exists( $file ) ){
      global $DB;
      $content = file_get_contents( $file );
      if ( '' != $content )
      {
        $query = utf8_decode($content);
        $prefixed_query = $this->os_prefix_query($query);
        $stmt = $DB->pdo->prepare($prefixed_query);
        if( $stmt->execute() ) return true;
      }
    }
    return false;
  }



  //os_prefix_query
  public function os_prefix_query($query)
  {
    return str_replace('}','',str_replace('{', _DB_PREFIX_ ,$query));
  }


  /**
   *=============================================================
   * Slect Table data
   *=============================================================
   * @param string $table
   * @param string $columns
   * @param string $condition
   * @return $data (array)
   * @throws Exception
   */
  public public function select($table, $columns = array('*'), $condition = "")
  {
    try {
      global $DB;
      $columns = implode(",", $columns);
      $query = "SELECT ". $columns ." FROM ". _DB_PREFIX_ . $table ." ".$condition;
      if($rows = $DB->pdo->query($query)){
      $data = $rows->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($data)){
          return $data;
        }else{
          return false;
        }
      }
    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }




  /**
   *=============================================================
   * Insert Table Data
   *=============================================================
   * @param string $table
   * @param array  $data
   * @param array  $exclude
   * @return $id_product (int)
   * @throws Exception
   */
  public public function save($table, $data, $exclude = array()) {
    try {
      $fields = $values = array();
      if( !is_array($exclude) ) $exclude = array($exclude);
      //Add Created date to data
      foreach( array_keys($data) as $key ) {
        if( !in_array($key, $exclude) ) {
          $fields[] = "`$key`";
          //$values[] = "'" . addslashes($data[$key]) . "'";
          $values[] = '"' . $data[$key] . '"';
        }
      }
      //Add Created date to data
      if( !isset($data['cdate']) )
      {
        $fields[] = "`cdate`";
        $values[] = "'" . date('Y-m-d H:s:m') . "'";
      }
      // Set fields and values
      $fields = implode(",", $fields);
      $values = implode(",", $values);
      //Start saving data
      $DB = Database::getInstance();
      $query = "INSERT INTO ". _DB_PREFIX_ . $table."(".$fields.") VALUES(".$values.")";
      if($DB->pdo->query($query)){
        $id_product = $DB->pdo->lastInsertId();
        return $id_product;
      }
    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }


  /**
   *=============================================================
   * Update Table
   *=============================================================
   * @param string $table
   * @param array $data
   * @param string $condition
   * @return rowCount (int)
   * @throws Exception
   */
  public function update($table,$params,$condition="") {
    try {
      //Create SQL from Params
      $param_string = '';
      //Add Updated date to params
      $params['udate'] = date('Y-m-d H:s:m');
      foreach ($params as $key => $param) {
        $param_string .= $key.'=:'.$key.',';
      }
      $param_string =  rtrim($param_string, ',');
      //Update Table
      $DB = Database::getInstance();
      $query = 'UPDATE '. _DB_PREFIX_ . $table.' SET '.$param_string.' '.$condition;

      $stm = $DB->pdo->prepare($query);
      //Bind Params
      foreach($params as $param => &$value) {
        $stm->bindParam($param, $value);
      }
      //Execute
      $stm->execute();
      return $stm->rowCount();
    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }

  
  public function os_getLoyalty($id_customer,$id_quotation){
    try{
      $loyalty  = $this->select('`'._DB_PREFIX_.'loyalty_customer`', array('*'), "WHERE id_customer =".$id_customer );
      if (!$loyalty) {
        $loyalty  = 0;
      }else{
         $loyalty  = $loyalty[0];
      }

    }catch (Exception $e){
      return false;
    }
  }
  /**
   *=============================================================
   * Delete Table
   *=============================================================
   * @param string $table
   * @param string $condition
   * @return $deleted_ids (array) || false
   * @throws Exception
   */
  public function delete($table,$condition="")
  {
    $DB = Database::getInstance();
    $select = "SELECT id FROM ". _DB_PREFIX_ . $table." ".$condition;
    if($rows = $DB->pdo->query($select)){
      $deleted_ids = $rows->fetchAll(PDO::FETCH_ASSOC);
    }
    //start deleting
    $query = "DELETE FROM ". _DB_PREFIX_ . $table." ".$condition;
    if($DB->pdo->query($query)) return $deleted_ids;
    // if we are here, something was wrong
    return false;
  }

  public function updateColumn($table,$columns,$condition=""){
   try {
      $DB = Database::getInstance();
      $query = 'UPDATE '. _DB_PREFIX_ . $table.' SET '.$columns.' '.$condition;
      $DB->pdo->query($query);
      return true;
    } catch (Exception $e) {
      return false;
    } 
  }
  /**
   *=============================================================
   * Get Categories
   *=============================================================
   * @param int $parent
   * @param array $cat_list
   * @throws Exception
   * @return html
   */
  public public function getCategories($parent,$cat_list)
  {
    $DB = Database::getInstance();
    $query = "SELECT id,name FROM "._DB_PREFIX_."categories WHERE parent=$parent";
    $stmt = $DB->pdo->query($query);  
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    if($res!=NULL)
    {
      //$in=rand(1,100);
      echo '<ul id="categories">';
      foreach($res as $row)
      {
        if(isset($_POST['categories'])){
          $checked = (in_array($row->id, $_POST['categories'])) ? 'checked' : '';
        }else if(isset($cat_list)){
          $checked = (in_array($row->id, $cat_list)) ? 'checked' : '';
        }else{
          $checked = '';
        }
        echo '<li>';// id="tab_'.$row->id.'"
        echo '<label for="'.$row->id.'">';
        echo '<input type="checkbox" name="product[categories][]" value="'.$row->id.'" id="'.$row->id.'" '.$checked.'>';
        echo $row->name;
        echo '</label>';
        echo '&nbsp;&nbsp;<a href="javascript:;" class="cat_collapse"><i class="fa fa-minus-square"></i></a>';
        echo '</li>';
        self::getCategories($row->id,$cat_list);
      }
      echo '</ul>';
    }
  }



  /**
   *=============================================================
   * Multiple Files Uploader
   *=============================================================
   * @param array $files
   * @param string $uploadDir
   * @param array  $extensions
   * @return $files || $errors
   * @throws Exception
   */
  public public function uploadFiles($files,$uploadDir,$extensions=array('jpg', 'jpeg', 'png', 'gif'),$maxSize = 10)
  {
    //Create directory if not exist
    if (!file_exists($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }
    //Start uploading files
    $uploader = new Uploader();
    $data = $uploader->upload($files, array(
      'limit' => 10, //Maximum Limit of files. {null, Number}
      'maxSize' => $maxSize, //Maximum Size of files {null, Number(in MB's)}
      'extensions' => $extensions, //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
      'required' => false, //Minimum one file is required for upload {Boolean}
      'uploadDir' => $uploadDir, //Upload directory {String}
      'title' => null, //New file name {null, String, Array} *please read documentation in README.md
      'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
      'perms' => 0777, //Uploaded file permisions {null, Number}
      'onCheck' => null, //A callback public function name to be called by checking a file for errors (must return an array) | ($file) | Callback
      'onError' => null, //A callback public function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
      'onSuccess' => null, //A callback public function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
      'onUpload' => null, //A callback public function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
      'onComplete' => null, //A callback public function name to be called when upload is complete | ($file) | Callback
      //'onRemove' => 'onFilesRemoveCallback' //A callback public function name to be called by removing files (must return an array) | ($removed_files) | Callback
    ));
    if($data['hasErrors']){
      //$errors = $data['errors'];
      return false;
    }
    if($data['isComplete']){
      $files = $data['data']['files'];
      return $files;
    }
  }



  /**
   *=============================================================
   * Upload Image
   *=============================================================
   * @param array $files
   * @param string $title
   * @param string $uploadDir
   * @return $files || $errors
   * @throws Exception
   */
  public public function uploadImage($image, $uploadDir, $title=null)
  {
    //Create directory if not exist
    if (!file_exists($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }
    //Start uploading files
    $uploader = new Uploader();
    $extensions=array('jpg', 'jpeg', 'png', 'gif');
    $data = $uploader->upload($image, array(
      'maxSize' => 8,
      'extensions' => $extensions,
      'uploadDir' => $uploadDir,
      'title' => $title,
    ));
    if($data['hasErrors']){
      return false;
    }
    if($data['isComplete']){
      $files = $data['data']['files'];
      return $files;
    }
  }


  /**
   *=============================================================
   * Upload Document
   *=============================================================
   * @param array $files
   * @param string $title
   * @param string $uploadDir
   * @return $files || $errors
   * @throws Exception
   */
  public public function uploadDocument($file, $file_name=array('auto', 10), $uploadDir, $extensions="")
  {
    //Create directory if not exist
    if (!file_exists($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }
    //Start uploading files
    $uploader = new Uploader();
    if( $extensions == "") $extensions = array('pdf', 'doc', 'docx', 'xlsx', 'ppt', 'pptx', 'odt');
    $data = $uploader->upload($file, array(
      'limit' => 1,
      'maxSize' => 8,
      'extensions' => $extensions,
      'uploadDir' => $uploadDir,
      'title' => $file_name,
    ));
    if($data['hasErrors']){
      return false;
    }
    if($data['isComplete']){
      $files = $data['data']['files'];
      return $files;
    }
  }


  /**
   *=============================================================
   * File Image
   *=============================================================
   * @param string $uploadDir
   * @param string $filename
   * @param array  $sizes
   * @param int    $quality
   * @return true
   * @throws Exception
   */
  public public function cropImage($uploadDir,$filename,$sizes=null,$quality=100)
  {
    //Vars
    $ext      = pathinfo($filename, PATHINFO_EXTENSION);
    $title    = explode('.'.$ext, $filename);
    $fullpath = $uploadDir.$filename;
    //Defauls Sizes
    if($sizes == null) $sizes = array('80x80' => 'thumb', '846x280' => 'category');
    $crop = new resize($fullpath);
    if(file_exists($fullpath)){
      foreach ($sizes as $key => $value) {
        $size = explode("x", $key);
        $crop->resizeImage($size[0], $size[1], 'auto');
        $crop->saveImage($uploadDir.'/'.$title[0].'-'. $value .'.'.$ext, $quality);
      }
    }
  }


  public public function get_file_extension($filename){
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    return $ext;
  }


  /**
   *=============================================================
   * File Crop
   *=============================================================
   * @param string $uploadDir
   * @param string $filename
   * @param array  $sizes
   * @param int    $quality
   * @return true
   * @throws Exception
   */
  public public function cropFile($uploadDir,$filename,$sizes=null,$quality=100)
  {
    //Vars
    $ext      = pathinfo($filename, PATHINFO_EXTENSION);
    $title    = explode('.'.$ext, $filename);
    //$path     = getcwd().'/'.$uploadDir;
    $fullpath = $uploadDir.'/'.$filename;
    return $this->os_resize_images_in_folder($fullpath);



    //Defauls Sizes
    /*if($sizes == null) $sizes = array('45x45' => '45x45', '60x60' => '60x60', '80x80' => '80x80', '200x200' => '200x200', '360x360' => '360x360');
    //Check if file exist
    $crop = new resize($fullpath);
    if(file_exists($fullpath)){
      foreach ($sizes as $size => $name) {
        $size = explode("x", $size);
        $crop->resizeImage($size[0], $size[1], 'auto');
        $crop->saveImage($uploadDir.'/'.$title[0].'-'.$name.'.'.$ext, $quality);
        //$crop->saveImage($uploadDir.'/'.$title[0].'-'.$size[0].'x'.$size[1].'.'.$ext, $quality);
      }
    }*/
  }


  /**
   *=============================================================
   * URL Slugify
   *=============================================================
   * @param string $text
   * @return $text
   * @throws Exception
   */
  public public function slugify($text)
  {
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, '-');
    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // lowercase
    $text = strtolower($text);
    if (empty($text))
    {
      return time();//'n-a'
    }
    return $text;
  }


   /**
   *=============================================================
   * Delete Directory
   *=============================================================
   * @param string $dir_path
   * @throws Exception
   */
  public public function deleteDirectory($dir_path) {
    if (! is_dir($dir_path)) {
      throw new InvalidArgumentException("$dir_path must be a directory");
    }
    if (substr($dir_path, strlen($dir_path) - 1, 1) != '/') {
      $dir_path .= '/';
    }
    $files = glob($dir_path . '*', GLOB_MARK);
    foreach ($files as $file) {
      if (is_dir($file)) {
        self::deleteDirectory($file);
      } else {
        unlink($file);
      }
    }
    rmdir($dir_path);
  }


  /**
   *=============================================================
   * Searching multidimensional arrays
   *=============================================================
   * @param array $array
   * @param string $arr_key
   * @param string $arr_val
   * @throws Exception
   */
  public function searching_multidimensional_arrays($array, $arr_key, $arr_val) {
    foreach ($array as $key => $item){
      if ( $item[ $arr_key ] === $arr_val ) return $key;
    }
    return false;
  }


  /**
   *=============================================================
   * Searching  arrays
   *=============================================================
   * @param array $array
   * @param string $field
   * @param string $value
   * @throws Exception
   */
  public function array_searching($array, $field, $value)
  {
    if( !empty($array) )
    {
      foreach($array as $key => $val)
      {
        if ( $val[$field] === $value )
          return $key;
      }
    }
    return false;
  }


  /**
   *=============================================================
   * random string
   *=============================================================
   * @param int $length
   * @throws Exception
   */
  public function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('A', 'Z'));
    for ($i = 0; $i < $length; $i++) {
      $key .= $keys[array_rand($keys)];
    }
    return $key;
  }



  /**
   *=============================================================
   * UList Function
   *=============================================================
   * @param $table = name of table
   * @param $fields : array , format : $fields = array('*'), format : $fields = array('field1','field1','field1',..)
   * @param $limit = array($start,$end) ex : select * from $table limit $limit[0],$limit[0]
   * @param $where : array = format $where = array('where1'=>array('fieldname','value'),'where2'=>array('fieldname','value'),xxx) ex  
   * @param $order = filed name
   * @param $join  : array(array(table,field1,field2),array(table,field1,field2),x) 
   * @throws Exception
   */
	public public function UList($table,$fields,$limit,$order,$where,$join){
		$DB = Database::getInstance();
		if(!empty($where))
		{
			foreach($where as $where_el)
			{
				echo 1;
				echo $where_el;
				$this->where = $where_el;
			}
		}else{
			$this->where = '';
		}
		$this->table = $table;
		$this->limit = $limit;
		$this->order = $order[0];
		$this->fields = $fields;
		foreach($fields as $field)
		{
			$this->sql_fields .= ",$field";
		}
		foreach($join as $join_e => $join_k)
		{
			$this->sql_join = "$join_k[0] join $join_k[1] on ($join_k[2] = $join_k[1].$join_k[3]) ";
		}
		$this->sql_fields = substr($this->sql_fields, 1 );
		$sql = 'select '.$this->sql_fields.' from '.$this->table.' '.$this->sql_join.' where 1=1 '.$this->where.' order by '.$this->order.' limit '.$this->limit[0].','.$this->limit[1];
		return $DB->pdo->query($sql)->fetchAll();
	}


  public public function save_mete_value($name, $value) {
    $DB = Database::getInstance();
    try {
      $value = addslashes($value);
      $value = strip_tags($value);
      $query = "DELETE FROM `"._DB_PREFIX_."meta_value` WHERE name = '$name'";
      $DB->pdo->query($query);
      $query = "INSERT INTO `"._DB_PREFIX_."meta_value`(`name`, `value`, `cdate`) VALUES('".$name."','".$value."',now())";
      if($DB->pdo->query($query)){
        $id_product = $DB->pdo->lastInsertId();
        return $id_product;
      }
    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }

  public public function select_mete_value($name){
    $DB = Database::getInstance();
    try {
      $query = "SELECT value FROM "._DB_PREFIX_."meta_value WHERE name = '$name'";
      if($rows = $DB->pdo->query($query)){
        $data = $rows->fetch(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data['value'];
      }
    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }


  public public function select_meta_value($name){
    $DB = Database::getInstance();
    try {
      $query = "SELECT value FROM "._DB_PREFIX_."meta_value WHERE name = '$name'";
      if($rows = $DB->pdo->query($query)){
        $data = $rows->fetch(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data['value'];
      }
    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }

  /**
   *==============================================
   * get quotation
   *==============================================
   * @param $id_invoice (int)
   * @throws Exception
   */
  public public function get_quotation($id_quotation, $id_customer){
    try {

      //get quotation data
      $quotation = $this->select('quotations', array('*'), "WHERE id=". $id_quotation ." AND id_customer=".$id_customer );
      if( ! $quotation[0] ) return false;

      //prepare data
      $result   = array();
      $total_ht = $total_products = $global_weight =  $total_buyprice = 0;
      $carrier  = $this->select('quotation_carrier', array('*'), "WHERE id_quotation=".$id_quotation );
      $products = $this->select('quotation_detail', array('*'), "WHERE id_quotation=".$id_quotation." ORDER BY id DESC" );
      $status   = $this->select('quotation_status', array('*'), "WHERE id=".$quotation[0]['id_state']);
      $customer = $this->os_get_customer_infos($id_customer);

      //push result array
      $result['quotation'] = $quotation[0];
      
      //start calculating
      if( !empty($products) )
      {
        foreach ($products as $key => $product)
        {
          //product total ht
          $buy_price  = floatval($product['product_buyprice']);
          $sell_price = floatval($product['product_price']);
          $quantity   = floatval($product['product_quantity']);
          $weight     = floatval($product['product_weight']);
          $total_ht   = ($sell_price * $quantity);
          $total_products += $total_ht;
          $global_weight  += $weight * $quantity;
          $total_buyprice += $buy_price * $quantity;
          //add products to new array with total
          $result['products'][ $key ] = $product;
          $result['products'][ $key ]['product_name'] = preg_replace('/\\\\/', '', $product['product_name']);
          $result['products'][ $key ]['attributs'] = preg_replace('/\\\\/', '', $product['attributs']);;
          $result['products'][ $key ]['total_ht'] = number_format((float)$total_ht, 2, '.', '');
        }
      }

      //push carrier & customer
      $result['carrier']  = $carrier[0];
      $result['customer'] = $customer;
      $result['status'] = $status[0];
      
      //total
      $loyalty_value    = $quotation[0]['loyalty_points'] * $quotation[0]['loyalty_value'];
      $global_discount  = floatval($quotation[0]['global_discount']);
      $voucher_value    = floatval($quotation[0]['voucher_value']);
      $avoir            = floatval($quotation[0]['avoir']);
      $total_saved      = floatval($quotation[0]['total_saved']);
      $global_reduction = $loyalty_value + $global_discount + $voucher_value + $avoir + $total_saved;

      //results
      $result['total']['product_tht']     = number_format((float)$total_products, 2, '.', '');
      $result['total']['tht']             = $total_products - $global_reduction;
      $result['total']['weight']          = floatval($global_weight);
      $result['total']['profit_margin']   = ($total_products * 10.8) - $total_buyprice;
      $result['total']['total_purchases'] = $total_buyprice;//$total_ht - $global_reduction;

      //return results
      return $result;     

    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }

  /**
   *==============================================
   * get order
   *==============================================
   * @param $id_invoice (int)
   * @throws Exception
   */
  public public function get_order($id_order, $id_customer){
    try {

      //get quotation data
      $order = $this->select('orders', array('*'), "WHERE id=". $id_order ." AND id_customer=".$id_customer." ORDER BY id DESC LIMIT 1" );
      if( ! $order[0] ) return false;

      //prepare data
      $result   = array();
      $total_ht = $total_products = $global_weight =  $total_buyprice = 0;
      $carrier  = $this->select('order_carrier', array('*'), "WHERE id_order=".$id_order );
      $products = $this->select('order_detail', array('*'), "WHERE id_order=".$id_order." ORDER BY id DESC" );
      $status   = $this->select('order_states', array('id', 'name'), "WHERE id=".$order[0]['id_state']);
      $customer = $this->os_get_customer_infos($id_customer);

      //push result array
      $result['order'] = $order[0];
      
      //start calculating
      if( !empty($products) )
      {
        foreach ($products as $key => $product)
        {
          //product total ht
          $buy_price  = floatval($product['product_buyprice']);
          $sell_price = floatval($product['product_price']);
          $quantity   = floatval($product['product_quantity']);
          $weight     = floatval($product['product_weight']);
          $total_ht   = ($sell_price * $quantity);
          $total_products += $total_ht;
          $global_weight  += $weight * $quantity;
          $total_buyprice += $buy_price * $quantity;
          //add products to new array with total
          $result['products'][ $key ] = $product;
          $result['products'][ $key ]['product_name'] = stripslashes( $product['product_name'] );
          $result['products'][ $key ]['attributs'] = stripslashes( $product['attributs'] );
          $result['products'][ $key ]['total_ht'] = number_format((float)$total_ht, 2, '.', '');
        }
      }

      //push carrier & customer
      $result['carrier']  = $carrier[0];
      $result['customer'] = $customer;
      $result['status'] = $status[0];
      
      //total
      $loyalty_value    = $order[0]['loyalty_points'] * $order[0]['loyalty_value'];
      $global_discount  = floatval($order[0]['global_discount']);
      $voucher_value    = floatval($order[0]['voucher_value']);
      $avoir            = floatval($order[0]['avoir']);
      $total_saved      = floatval($order[0]['total_saved']);
      $global_reduction = $loyalty_value + $global_discount + $voucher_value + $avoir + $total_saved;

      //results
      $result['total']['product_tht']     = $total_products;
      $result['total']['tht']             = $total_products - $global_reduction;
      $result['total']['weight']          = floatval($global_weight);
      $result['total']['profit_margin']   = ($total_products * 10.8) - $total_buyprice;
      $result['total']['total_purchases'] = $total_buyprice;//$total_ht - $global_reduction;

      //return results
      return $result;     

    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }


  /**
   *==============================================
   * get invoice
   *==============================================
   * @param $id_invoice (int)
   * @throws Exception
   */
  public public function get_invoice($id_invoice, $id_customer){
    try {

      //get quotation data
      $invoice = $this->select('invoices', array('*'), "WHERE id=". $id_invoice ." AND id_customer=".$id_customer." ORDER BY id DESC LIMIT 1" );
      if( ! $invoice[0] ) return false;

      //prepare data
      $result   = array();
      $total_ht = $total_products = $global_weight =  $total_buyprice = 0;
      $carrier  = $this->select('invoice_carrier', array('*'), "WHERE id_invoice=".$id_invoice );
      $products = $this->select('invoice_detail', array('*'), "WHERE id_invoice=".$id_invoice." ORDER BY id DESC" );
      //$status   = $this->select('invoice_states', array('id', 'name'), "WHERE id=".$invoice[0]['id_state']);
      $customer = $this->os_get_customer_infos($id_customer);

      //push result array
      $result['invoice'] = $invoice[0];
      
      //start calculating
      if( !empty($products) )
      {
        foreach ($products as $key => $product)
        {
          //product total ht
          $buy_price  = floatval($product['product_buyprice']);
          $sell_price = floatval($product['product_price']);
          $quantity   = floatval($product['product_quantity']);
          $weight     = floatval($product['product_weight']);
          $total_ht   = ($sell_price * $quantity);
          $total_products += $total_ht;
          $global_weight  += $weight * $quantity;
          $total_buyprice += $buy_price * $quantity;
          //add products to new array with total
          $result['products'][ $key ] = $product;
          $result['products'][ $key ]['product_name'] = stripslashes( $product['product_name'] );
          $result['products'][ $key ]['attributs'] = stripslashes( $product['attributs'] );
          $result['products'][ $key ]['total_ht'] = number_format((float)$total_ht, 2, '.', '');
        }
      }

      //push carrier & customer
      $result['carrier']  = $carrier[0];
      $result['customer'] = $customer;
      //$result['status'] = $status[0];
      
      //total
      $loyalty_value    = $invoice[0]['loyalty_points'] * $invoice[0]['loyalty_value'];
      $global_discount  = floatval($invoice[0]['global_discount']);
      $voucher_value    = floatval($invoice[0]['voucher_value']);
      $avoir            = floatval($invoice[0]['avoir']);
      $total_saved      = floatval($invoice[0]['total_saved']);
      $global_reduction = $loyalty_value + $global_discount + $voucher_value + $avoir + $total_saved;

      //results
      $result['total']['product_tht']     = $total_products;
      $result['total']['tht']             = $total_products - $global_reduction;
      $result['total']['weight']          = floatval($global_weight);
      $result['total']['profit_margin']   = ($total_products * 10.8) - $total_buyprice;
      $result['total']['total_purchases'] = $total_buyprice;//$total_ht - $global_reduction;

      //return results
      return $result;     

    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }

  //customer infos
  public public function os_get_customer_infos($id_customer){
    global $DB;
    $query = "SELECT u.id, u.first_name, u.last_name, u.email, u.phone, u.mobile, u.active,
                     ug.name as user_group, g.name as gender, uc.company, c.name as user_country
              FROM "._DB_PREFIX_."users u
              LEFT JOIN "._DB_PREFIX_."gender g ON g.id=u.id_gender
              LEFT JOIN "._DB_PREFIX_."users_groups ug ON ug.id=u.id_group
              LEFT JOIN "._DB_PREFIX_."user_company uc ON uc.id_user=u.id
              LEFT JOIN "._DB_PREFIX_."countries c ON u.id_country=c.id
              WHERE u.id=$id_customer";
    if($rows = $DB->pdo->query($query)){
      $customer = $rows->fetch(PDO::FETCH_ASSOC);
      return $customer;
    }
    return false;
  }



  /**
   *==============================================
   * get_quotation_total
   *==============================================
   * @param $tht (float)
   * @throws Exception
   */
  /*public public function os_get_quotation_total($total, $buyprice, $weight){
    try {

      $results = array();
      $results['tht'] = $total;
      $results['weight'] = $weight;
      $results['total_purchases'] = $buyprice;
      $results['profit_margin'] = $total - $buyprice;

      //total
      $total_tht -= $total_discount;
      $ttc = ($total_tht + $total_tax) + $total_shipping;
      $result['total']['quantity'] = $total_quantity;
      $result['total']['weight']   = number_format((float)$total_weight, 2, '.', '');
      $result['total']['tax']      = number_format((float)$total_tax, 2, '.', '');
      $result['total']['discount'] = number_format((float)$total_discount, 2, '.', '');
      $result['total']['shipping'] = number_format((float)$total_shipping, 2, '.', '');
      //$result['total']['tht']      = number_format((float)($total_tht - $total_discount), 2, '.', '');
      $result['total']['tht']      = number_format((float)($total_tht), 2, '.', '');
      $result['total']['ttc']      = number_format((float)$ttc, 2, '.', '');
      

      return $results;
    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }*/



  /**
   *==============================================
   * get discount percent
   *==============================================
   * @param $id_invoice (int)
   * @throws Exception
   */
  public public function discount_percent($price, $discount){
    try {
      if( $discount <= 0 || $price <= 0 ){
        return 0;
      }else{
        return ($price / $discount) / 100 ;
      }
    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }


  /**
   *==============================================
   * get discount devise
   *==============================================
   * @param $id_invoice (int)
   * @throws Exception
   */
  public public function discount_devise($price, $discount){
    try {
      if( $discount <= 0 || $price <= 0 ){
        return 0;
      }else{
        return ($price * $discount) / 100;
      }
    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }


  /**
   *==============================================
   * get tax percent
   *==============================================
   * @param $id_invoice (int)
   * @throws Exception
   */
  public public function tax_percent($price, $tax){
    try {
      if( $tax <= 0 || $price <= 0 ){
        return 0;
      }else{
        return ($price / $tax) / 100 ;
      }
    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }


  /**
   *==============================================
   * get taxe devise
   *==============================================
   * @param $id_invoice (int)
   * @throws Exception
   */
  public public function tax_devise($price, $tax){
    try {
      if( $tax <= 0 || $price <= 0 ){
        return 0;
      }else{
        return ($price * $tax) / 100;
      }
    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }



  /**
   *==============================================
   * get file name
   *==============================================
   * @param $file_name (string)
   * @throws Exception
   */
  public public function get_file_name( $file_name, $file_dem="80x80" )
  {
    try {
      $extension = pathinfo($file_name, PATHINFO_EXTENSION);
      $title     = explode('.'.$extension, $file_name);
      $new_name  = $title[0]."-".$file_dem.".".$extension;
      return $new_name;
    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }


  /**
   *==============================================
   * check cart rule
   *==============================================
   * @param $file_name (string)
   * @throws Exception
   */
  public public function check_cart_rule( $code, $id_customer, $id_carrier, array $product_ids, $amount )
  {
    try {
      
      if( 
        empty($code)
        || !is_numeric($id_customer) 
        || !is_numeric($id_carrier)
        || !is_array($product_ids) 
      ) return false;

        //check if cart rule exist
        $cart = $this->select('cart_rule', array('*'), "WHERE code='". $code ."' AND active=1" );
        if( !$cart[0] || floatval($cart[0]['minimum_amount']) > $amount ) return false;

        //check if cart rule valid
        $date_from = strtotime($cart[0]['date_from']);
        $date_to   = strtotime($cart[0]['date_to']);
        $current   = time();
        if($date_from <= $current && $date_to >= $current) {
          //check if customer allowed to use this cart rule
          if( $cart[0]['id_customer'] == $id_customer || $cart[0]['id_customer'] == 0){
            //check customer group
            $id_group = $this->select('users', array('id_group'), "WHERE id=".$id_customer );
            $id_group = $id_group[0]['id_group'];
            //$group_res = array_map('intval', explode(',', $cart[0]['group_restriction']));
            $group_res = explode(',', $cart[0]['group_restriction']);
            if( $group_res[0] == "" || in_array( $id_group, $group_res ) ){

              //check if selected carrier in list
              $carrier_res = explode(',', $cart[0]['carrier_restriction']);
              if( $carrier_res[0] == "" || in_array( $id_carrier, $carrier_res ) ){

                $quotation_cr = array(
                  'id_cart_rule'           => $cart[0]['id'], 
                  'name'                   => $cart[0]['name'], 
                  'code'                   => $cart[0]['code'], 
                  'free_shipping'          => $cart[0]['free_shipping'], 
                  'reduction'              => $cart[0]['reduction'], 
                  'apply_discount'         => $cart[0]['apply_discount'], 
                  'reduction_type'         => $cart[0]['reduction_type'], 
                  'gift_product'           => $cart[0]['gift_product'], 
                  'gift_product_attribute' => $cart[0]['gift_product_attribute']
                );
                //get reduction products
                if( $cart[0]['reduction_type'] == "order" ){
                  $quotation_cr['reduction_products'] = "";
                }elseif( $cart[0]['reduction_type'] == "specific" ){
                  $quotation_cr['reduction_products'] = $cart[0]['reduction_product'];
                }elseif( $cart[0]['reduction_type'] == "selection" ){
                  $quotation_cr['reduction_products'] = $cart[0]['product_restriction'];
                }
                //return array
                return $quotation_cr;
              }

            }
            
          }

        }

        return false;

    } catch (Exception $e) {
      echo $this->get_exception_error($e);
    }
  }



  


  /**
   *==============================================
   * check in range
   *==============================================
   * @param $start_date (datetime)
   * @param $end_date (datetime)
   * @param $date_from_user (datetime)
   * @throws Exception
   * $start_date = '2009-06-17';
   * $end_date = '2009-09-05';
   * $date_from_user = '2009-08-28';
   * $this->check_in_range($start_date, $end_date, $date_from_user);
   */
  /*public function check_in_range($start_date, $end_date, $date_from_user)
  {
    // Convert to timestamp
    $start_ts = strtotime($start_date);
    $end_ts = strtotime($end_date);
    $user_ts = strtotime($date_from_user);
    // Check that user date is between start & end
    return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
  }*/




  /**
   * Copy a file, or recursively copy a folder and its contents
   *
   * @author      Aidan Lister <aidan@php.net>
   * @version     1.0.1
   * @link        http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
   * @param       string   $source    Source path
   * @param       string   $dest      Destination path
   * @param       string   $excludes  Excludes files and dirs
   * @return      bool     Returns TRUE on success, FALSE on failure
   */
  public function copyr($source, $dest, $excludes=array())
  {
    // Check for symlinks
    if (is_link($source)) {
      return symlink(readlink($source), $dest);
    }
    // Simple copy for a file
    if (is_file($source)) {
      echo $source.'<br>';
      if( !in_array($source, $excludes) ){
        return copy($source, $dest);
      }
    }
    // Make destination directory
    if (!is_dir($dest)) {
      mkdir($dest);
    }
    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
      // Skip pointers
      if ($entry == '.' || $entry == '..') {
        continue;
      }
      if( !in_array($entry, $excludes) ){
        // Deep copy directories
        $this->copyr("$source/$entry", "$dest/$entry", $excludes=array());
      }
    }
    // Clean up
    $dir->close();
    return true;
  }

  //get_dir_contents
  public function get_dir_contents($dir, $exclude_dir=array(), &$results = array()){
    $files = scandir($dir);
    foreach($files as $key => $value){
      if( !in_array($value, $exclude_dir) )
      {
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
        if(!is_dir($path)) {
          $results[] = $path;
        } else if($value != "." && $value != "..") {
          $this->get_dir_contents($path, $exclude_dir=array(), $results);
          $results[] = $path;
        }
      }
    }
    return $results;
  }



  public function os_resize_images_in_folder($file_path, $sizes=array())
  {
    try {
      //exit if directory not exist
      //if (!file_exists($directory)) return false;
      
      //define sizes if empty
      if( empty($sizes) )
      {
        //Defauls Sizes
        $sizes = array(
          //"45x45" => "dashboard", 
          "45x45" => "45x45", 
          "76x76" => "76x76", 
          "80x80" => "80x80", 
          "100x122" => "100x122", 
          "120x45" => "120x45", 
          "200x200" => "200x200", 
          "360x360" => "360x360", 
          "570x697" => "570x697", 
          "828x220" => "828x220"
        );
      }

      //scan directory for files
      //$files = $this->get_dir_contents( $directory );
      //foreach ($files as $key => $file_path) {
        if(  strpos($file_path, 'jpg') !== false 
          || strpos($file_path, 'jpeg') !== false
          || strpos($file_path, 'png') !== false
          || strpos($file_path, 'gif') !== false
        ){
          $file_target = dirname($file_path)."/";
          $extension = pathinfo($file_path, PATHINFO_EXTENSION);
          $file_name = explode('.'.$extension, $file_path);
          $file_name = basename($file_name[0]);
          //resize images
          foreach ($sizes as $key => $file_size) {
            $size = explode("x", $key);
            $image_output = $file_name."-".$file_size.".jpg";
            $layer = ImageWorkshop::initFromPath( $file_path );
            $layer->resizeInPixel($size[0], $size[1], true, 0, 0, 'MM');
            $layer->save( $file_target, $image_output, true, null, 95);
          }
        }
      //}
      
      return true;

    } catch (Exception $e) {
      return false;
    }    
  }




/*============================================================*/
} //END COMMON CLASS
/*============================================================*/
?>