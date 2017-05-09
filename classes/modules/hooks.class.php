<?php
class Hooks extends modules
{


	public $modules_infos = array();
  public $hooks_array = array();
  public $modules_path;


  public function __construct(){
    $this->modules_path = _BASE_URI_ . 'modules/';
  }


  

  /**
   *==============================================
   * Install logic is run when plugin is installed
   *==============================================
   * @return boolean true || false
   */
  function install()
  {
    return true;
  }

  /**
   *================================================
   * Install logic is run when plugin is uninstalled
   *================================================
   * @return boolean true || false
   */
  function uninstall()
  {
    return true;
  }

  /**
   *================================
   * When plugin is activated
   *================================
   * @return boolean true || false
   */
  function activate()
  {
    return true;   
  }

  /**
   *================================
   * When plugin is deactivated
   *================================
   * @return boolean true || false
   */
  function deactivate()
  {
    return true;
  }

	/**
   *======================================
   * adds hook to hook list, so developers 
   * can attach functions to hooks
   *======================================
   * @param array $where
   */
	function set_hook($where) {
		$this->hooks_array[ $where ] = '';
	}
	
	
	/**
   *=====================================
   * add multiple hooks
   *=====================================
   * @param  array  $wheres
   */
	function set_hooks($wheres) {
    if( !empty($wheres) ){
      foreach ( $wheres as $where ) {
        $this->set_hook( $where );
      }
    }
	}

  //check_module_install
  function check_module_active($slug)
  {
    if( isset($this->modules_infos[$slug]) )
    {
      return true;
    }
    return false;
  }


	/**
   *=============================================================
   * load active modules
   * this well require boot file of all active module in database
   *=============================================================
   * @throws Exception
   */
	function load_active_modules() {
		try {
      //get installed modules list
      $modules = $this->get_installed_modules();
      if( empty($modules) ) return false;
      //open modules directories, and read its contents
      foreach ($modules as $mod_slug => $active) {
      	if( $active == 1 ){
      		//scan module directory to find ~.module.php boot file
		  		$module_path = $this->modules_path . $mod_slug;
		  		if ((is_dir($module_path)) && ($mod_slug != '.') && ($mod_slug != '..')) {
						$module_boot = preg_grep( '~\.(module.php)$~', scandir( $module_path ) );
						if ( $module_boot ){
							require_once $module_path .'/'. implode('', $module_boot);
							$this->modules_infos[ $mod_slug ]['installed'] = 1;
							$this->modules_infos[ $mod_slug ]['active'] = 1;
						}
					}
      	}
	  	}
		} catch (Exception $e) {
			echo "<b>ERROR AT LINE [". $e->getLine() ."] </b><br>". $e->getMessage();
		}
	}


	/**
   *=============================================================
   * load inactive modules
   * this well require inactive module from modules directory
   *=============================================================
   * @throws Exception
   */
	function load_inactive_modules() {
		try {
      //get installed modules list
      $modules = $this->get_installed_modules();
      //open modules directories, and read its contents
      $directories = glob( $this->modules_path . '*' , GLOB_ONLYDIR);
      $directories = str_replace($this->modules_path, '', $directories);
      //loop to find inactive and uninstalled modules
      foreach ($directories as $key => $directory) {
      	if( ! isset($modules[ $directory ]) || $modules[ $directory ] == 0 ){
      		//scan module directory to find ~.module.php boot file
		  		$module_path = $this->modules_path . $directory;
					$module_boot = preg_grep( '~\.(module.php)$~', scandir( $module_path ) );
					if ( $module_boot ){
						require_once $module_path .'/'. implode('', $module_boot);
						if( isset($modules[ $directory ]) && $modules[ $directory ] == 0 ){
							$this->modules_infos[ $directory ]['installed'] = 1;
						}else{
							$this->modules_infos[ $directory ]['installed'] = 0;
						}
						$this->modules_infos[ $directory ]['active'] = 0;
					}
      	}
      }
		} catch (Exception $e) {
			echo "<b>ERROR AT LINE [". $e->getLine() ."] </b><br>". $e->getMessage();
		}
	}


	/**
   *=========================================================
   * get installed modules slug and active
   *=========================================================
   * @throws Exception
   */
	function get_installed_modules(){
		global $DB;
	  $query = "SELECT `slug`, `active` FROM `"._DB_PREFIX_."modules`";
	  if($rows = $DB->pdo->query($query)){
	    $modules = $rows->fetchAll(PDO::FETCH_ASSOC);
	    if( !empty($modules) ){
	    	$modules_state = array();
		    foreach ($modules as $key => $module){
		      $modules_state[ $module['slug'] ] = $module['active'];
		    }
	      return $modules_state;
	    }
	  }
	  return false;
	}


	/**
   *============================================================
   * get active modules hooks position
   * this well return an array of active hooks using into theme
   *============================================================
   * @param  array  $positions
   * @return array  $hook_array
   * @throws Exception
   */
	function get_modules_hooks( array $positions, $active ){
		try {
			//prepare positions to query
			if( empty($positions) || !is_array($positions) ) return false;
			$positions = implode("', '", $positions);
			$positions = "'". $positions ."'";
			//get shop active modules hooks
			global $DB;
			$query ="SELECT ms.id as id_hook, ms.id_section, ms.id_module, ms.position, mc.name as cat_name,
							      	mc.slug as cat_slug, s.name as sec_name, s.slug as sec_slug, ms.active,
							      	m.name as mod_name, m.slug as mod_slug, ms.hook_function, ms.description
							FROM "._DB_PREFIX_."modules m
							INNER JOIN "._DB_PREFIX_."modules_categories mc ON m.id_category = mc.id 
							INNER JOIN "._DB_PREFIX_."modules_sections ms ON m.id = ms.id_module
							INNER JOIN "._DB_PREFIX_."sections s ON s.id = ms.id_section 
							WHERE m.active = 1 AND  ms.active = ".$active." AND s.slug IN ($positions) ORDER BY ms.position ASC";
			//generate positions hooks array
			if($rows = $DB->pdo->query($query)){
        $hooks = $rows->fetchAll(PDO::FETCH_ASSOC);
        if( !empty($hooks) ){
        	$hook_array = array();
					foreach ($hooks as $key => $hook) {
					  $sec_slug = $hook['sec_slug'];
					  $position = $hook['position'];
					  $hook_array[ $sec_slug ][ $position ]['id_hook']     = $hook['id_hook'];
					  $hook_array[ $sec_slug ][ $position ]['sec_name']    = $hook['sec_name'];
					  $hook_array[ $sec_slug ][ $position ]['cat_name']    = $hook['cat_name'];
					  $hook_array[ $sec_slug ][ $position ]['cat_slug']    = $hook['cat_slug'];
					  //$hook_array[ $sec_slug ][ $position ]['id_module']   = $hook['id_module'];
					  $hook_array[ $sec_slug ][ $position ]['mod_name']    = $hook['mod_name'];
					  $hook_array[ $sec_slug ][ $position ]['mod_slug']    = $hook['mod_slug'];
					  $hook_array[ $sec_slug ][ $position ]['function']    = $hook['hook_function'];
					  $hook_array[ $sec_slug ][ $position ]['description'] = $hook['description'];
					  $hook_array[ $sec_slug ][ $position ]['active'] = $hook['active'];
					}
					return $hook_array;
        }
      }
      return false;
		} catch (Exception $e) {
			echo "<b>ERROR AT LINE [". $e->getLine() ."] </b><br>". $e->getMessage();
		}
	}


  /**
   *=============================================================
   * get theme sections
   *=============================================================
   * @throws Exception
   * @return $infos (array)
   */
  public function get_theme_sections($theme_uri)
  {
    try {
      //Moullablad : get the default theme from database and remove this (THEMES_PATH . "maroc-artisana)
      $theme_path = $theme_uri . "/infos.json";//"../themes/".
      if( file_exists( $theme_path ) ){
        $theme_infos = file_get_contents( $theme_path );
        $infos = json_decode( $theme_infos, true );
        if( !empty( $infos[0]['sections'][0] ) ) return $infos[0]['sections'][0];
        return false;
      }
    } catch (Exception $e) {
      echo "<b>ERROR AT LINE [". $e->getLine() ."] </b><br>". $e->getMessage();
    }
  }


	/**
   *=============================================================
   * get modules sections
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_modules_sections()
  {
    try {
      global $DB;
      $sec_array = array();
      $query = "SELECT `slug` FROM `"._DB_PREFIX_."sections`";
      if($rows = $DB->pdo->query( $query )){
        $sections = $rows->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $sections as $key => $sec ) {
        	$sec_array[ $key ] = $sec['slug'];
        }
        if(!empty($sec_array)) return $sec_array;
      }
    } catch (Exception $e) {
      echo "<b>ERROR AT LINE [". $e->getLine() ."] </b><br>". $e->getMessage();
    }
  }


  /**
   *=============================================================
   * get active hooks
   *=============================================================
   * @throws Exception
   * @return $hooks (array)
   */
  public function get_active_hooks( $where )
  {
    try {
      $hooks = array();
      $modules_hooks = $this->get_modules_hooks( array($where), 1 );
      if( !empty($modules_hooks) ){
        foreach ($modules_hooks[ $where ] as $key => $hook) {
          if( $hook['active'] == 1 ){
            $id_hook = $hook['id_hook'];
            $hooks[ $id_hook ]['mod_name'] = $hook['mod_name'];
            $hooks[ $id_hook ]['description'] = $hook['description'];
          }
        }
        return $hooks;
      }
      return false;
    } catch (Exception $e) {
      echo "<b>ERROR AT LINE [". $e->getLine() ."] </b><br>". $e->getMessage();
    }
  }



	/**
   *=============================================================
   * get inactive hooks
   *=============================================================
   * @throws Exception
   * @return $hooks (array)
   */
  public function get_inactive_hooks( $where )
  {
    try {
    	$hooks = array();
    	$modules_hooks = $this->get_modules_hooks( array($where), 0 );


    	//foreach ($modules_hooks[ $where ] as $key => $hook) {
    	//	$cat_name = $hook['cat_name'];
    	//	@$hooks[ $cat_name ] += 1;
    	//}

    	if( !empty($modules_hooks) ){
    		foreach ($modules_hooks[ $where ] as $key => $hook) {
	    		if( $hook['active'] == 0 ){
	    			$id_hook = $hook['id_hook'];
            $hooks[ $id_hook ]['cat_slug'] = $hook['cat_slug'];
	    			$hooks[ $id_hook ]['mod_name'] = $hook['mod_name'];
	    			$hooks[ $id_hook ]['description'] = $hook['description'];
	    			//$hooks[ $cat_name ][ $mod_name ][ $function ] = $hook['description'];
	    		}
	    	}
	    	return $hooks;
    	}
      return false;
    } catch (Exception $e) {
      echo "<b>ERROR AT LINE [". $e->getLine() ."] </b><br>". $e->getMessage();
    }
  }


	/**
   *=============================================================
   * get inactive hooks categories
   *=============================================================
   * @throws Exception
   * @return $hooks (array)
   */
  public function get_inactive_hooks_categories( $where )
  {
    try {
      $inactive_hooks = $this->get_inactive_hooks( $where );
      $cat_count = array();
      if( !empty($inactive_hooks) ){
        foreach ($inactive_hooks as $key => $hook) {
          $cat_slug = $hook['cat_slug'];
          @$cat_count[ $cat_slug ] += 1;
        }
      }
      
      return $cat_count;
    } catch (Exception $e) {
      echo "<b>ERROR AT LINE [". $e->getLine() ."] </b><br>". $e->getMessage();
    }
  }


	/**
   *=============================================================
   * modules filter
   * $pairs = array('author' => 'abc', 'version' => 'all'); 
   * $array = array();
   *=============================================================
   * @param array $array
   * @param array $pairs
   * @throws Exception
   * @return $hooks (array)
   */
  public function modules_filter(array $array, array $pairs)
  {
    try {
      $filter = array();
      foreach ($array as $aKey => $aVal) {
        $coincidences = 0;
        foreach ($pairs as $pKey => $pVal) {
          if( $pKey == "name"){
            if (strpos( strtolower($aVal['name']), strtolower($pVal)) !== false) {
              $coincidences++;
            }
          }else{
            if (array_key_exists($pKey, $aVal) && strtolower($aVal[$pKey]) == strtolower($pVal)) {
              $coincidences++;
            }
          }
        }
        if ($coincidences == count($pairs)) {
          $filter[$aKey] = $aVal;
        }
      }
      return $filter;
    } catch (Exception $e) {
      echo "<b>ERROR AT LINE [". $e->getLine() ."] </b><br>". $e->getMessage();
    }
  }


  /**
   *=============================================================
   * modules authors
   *=============================================================
   * @throws Exception
   * @return $authors (array)
   */
  public function modules_authors()
  {
    try {
      $authors = array();
      foreach($this->modules_infos as $info){
        if(!in_array($info['author'], $authors, true)){
          array_push($authors, $info['author']);
        }
      }
      return $authors;
    } catch (Exception $e) {
      echo "<b>ERROR AT LINE [". $e->getLine() ."] </b><br>". $e->getMessage();
    }
  }


	/**
   *=======================================
   * attach custom function to hook 
   * use this function to regester new hook
   *=======================================
   * @param string $where
   * @param string $function
   */
	function add_hook($where, $module="", $function, $description="") {
		try {
      if( $where == "" || $module == "" || $function == "") return false;


			//echo $description.'<br>';
			//get module path and directory name
			//$backtrace = debug_backtrace();
			//print_r($backtrace[1]['args']);
			// $dir_path  = dirname($backtrace[1]['file']);
			// $dir_path  = str_replace("\\", "/", $dir_path);
			// $dir_name  = str_replace( $this->modules_path , "", $dir_path);


			//add hook to hooks array
			if( isset($this->hooks_array[ $where ]) ){
				// if( isset($backtrace[1]['args'][2]) ){
				// 	$desc = $backtrace[1]['args'][2];
				// }else{
				// 	$desc = "";
				// }
				$these_hooks = $this->hooks_array[$where];
				$these_hooks[ $module ][ $function ]  = $description;
				$this->hooks_array[ $where ] = $these_hooks;
			}
		} catch (Exception $e) {
			echo "<b>ERROR AT LINE [". $e->getLine() ."] </b><br>". $e->getMessage();
		}
	}


	/**
   *=================================================
   * check whether any function is attached to hook
   *=================================================
   * @param  string  $where
   * @return boolean true || false
   * @throws Exception
   */
	function hooks_exist($where) {
		if (array_key_exists($where, $this->hooks_array)) {
		  return true;
		}
		return false;
	}


	/**
   *==============================================================
   * execute all functions which are attached to hook, you can
   * provide argument (or arguments via array) as second parameter
   *==============================================================
   * @param  string $where
   * @param  array  $args
   * @return string $result
   * @throws Exception
   */
	function execute_hooks( $where, $args ="" ) {
		if (array_key_exists($where, $this->hooks_array)) {
			//get active modules by position
			$mod_hooks = $this->get_modules_hooks( array($where), 1 );
      //$result = $args;
			$result = "";
		  if( !empty($mod_hooks) ){
		  	foreach ($mod_hooks[ $where ] as $key => $hook) {
		  		//execute hook function
		  		if ( function_exists( $hook['function'] ) ) { 
            $result .= '<div class="'.$hook['function'].'">';
              $result .= call_user_func( $hook['function'] );
            $result .= '</div>';
			  	}
			  }
			  return $result;
		  }
		}
	}


	/**
   *================================================
   * register module data in $this->module
   *================================================
   * @param  int   $module_id
   * @return array $data
   */
	function register_module($module_id, $data) {
		foreach ( $data as $key => $value ) {
			$this->modules_infos[ $module_id ][ $key ] = $value;
		}
	}
	
	/**
   *====================================
   * get data of module as array
   *====================================
   * @param  int   $module_id
   * @return array $this->modules_infos
   */
	function get_module_data($module_id) {
		return $this->modules_infos[ $module_id ];
	}
	

/*============================================================*/
} //END CLASS
/*============================================================*/