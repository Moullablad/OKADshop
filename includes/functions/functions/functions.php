<?php 

use App\Product\Product;

/* ===============================
 * function.php 
 * ==============================*/

function getUsersGroup(){
	$user = new user();
	return $user->getUsersGroup();
}

if (! function_exists('array_column')) {
    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if ( ! isset($value[$columnKey])) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            }
            else {
                if ( ! isset($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if ( ! is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }
}

function selling_rule(){
  global $hooks;
  $selling_rule = $hooks->select_meta_value("selling_rule");
  return $selling_rule;
}
function displayAddToCart($paramt){
  if ($paramt>0)
   return true;
  return false;
}
function displayPrice(){
  return true;
  global $hooks;
  if ($displayPrice = $hooks->select_meta_value("displayPrice")) {
      switch ($displayPrice) {
        case 'yes':
          return true;
          break;
        case 'no':
          return false;
          break;
        case 'connected':
          if (isConnected()) {
            return true;
          }
          return false;
          break;
        default:
          # code...
          break;
      }
  }
  return false;
}
function getAllContry(){
	$user = new user();
	return $user->getAllCountry();
}
function goHome(){
	echo '<script>window.location.href = "'._HOME_URL_.'"</script>';
}

function goTolink($url){
	echo '<script>window.location.href = "'.$url.'"</script>';
}

function getCurrentUser(){
	$user = new user();
	return $user->getCurrentUser();
}

function getHomeProduct($limit = 8){
	$product = new Product();
	return $product->getProduct('home',$limit);
}
function getProductsImaes($PID){
	$product = new Product();
	$res = $product->getProductsImaes($PID);
	$return = array();
	if ($res && !empty($res)) {
			$return['type'] = end(explode('.', $res[0]['name']));
			foreach ($res as $key => $value) {
			$img = $value['name'];
			$img = substr($img, 0, strrpos($img , '.'));
			$return['images'][] = 'files/products/'.$PID.'/'.$img;
		}
	}
	return $return;
}


function getCount($table,$condition =" 1"){
  $product = new Product();
  $res = $product->getCount($table,$condition);
  return $res;
}

function getProductsImaesBySize($PID,$size,$ids = false){
	$product = new Product();
	$res = $product->getProductsImaes($PID);
  $return = array();
  //$return['links'] = array();
	if ($res && !empty($res)) {
		foreach ($res as $key => $value) {
			$tmp = explode('.', $value['name']);
			$name = $tmp[0];
			$type = end($tmp);
			$link = 'files/products/'.$PID.'/'.$name.'-'.$size.'.'.$type;
			if (file_exists(WEBROOT.$link)) {
        if ($ids) {
          $return[] = array("link" => $link,"id" => $value['id']);
        }else{
          $return[] = $link;
        }
			}
		}
	}
	return $return;
}


function getProductByids($IDS,$LIMIT = null){
		$product = new Product();
		$res = $product->getProductByids($IDS,$LIMIT);
		return $res;
}
function getProductByid($ID){
		$product = new Product();
		$res = $product->getProductByid($ID);
		return $res;
}
function getsimProductByCategory($CID,$LIMIT){
		$product = new Product();
		$res = $product->getSimProductByCategory($CID,$LIMIT);
    $res = fixProduct($res);
		return $res;
}
function getcategoryByParent($parent,$LIMIT = null){
	$product = new Product();
	$res = $product->getcategoryByParent($parent,$LIMIT);
	return $res;
}
function getcategoryByName($name){
	$product = new Product();
	$res = $product->getcategoryByName($name);
	return $res;
}
function getThumbnail($PID,$size,$imgid = false){
	$product = new Product();
	$res = $product->getThumbnail($PID,$imgid);
	$tmp = explode('.', $res['name']);
	$name = $tmp[0];
	$type = end($tmp);
	$link = 'files/products/'.$PID.'/'.$name.'-'.$size.'.'.$type;
  
  return $link;
/*
	if (file_exists(getcwd().'/'.$link)) {
		return $link;
	}
	return false;*/
}

function getProductImage($PID){
 try {
    $product = new Product();
    $res = $product->getThumbnail($PID);
    return $res['name'];
  } catch (Exception $e) {
    return false;
  } 
}

function getProductByCategory($id,$condition){
	$product = new Product();
	return $product->getProductByCategory($id,$condition);
}

function getCategoryById($id){
	$product = new Product();
	return $product->getCategoryById($id);
}

function getProductListByCategory($CID,$page,$perpage,$condition,$isStartPage,$orderby){
	$product = new Product();
	$res =  $product->getProductListByCategory($CID,$page,$perpage,$condition,$isStartPage,$orderby);
  if (isset($res['result'])) {
    $res['result'] = fixProduct($res['result']);
  }
  return $res;
}

function fixProduct($products){
  $cmp = 0;
  $tmp = $products;
  foreach ($tmp as $key => $value) {
    $tmp[$cmp]['name'] = stripslashes($tmp[$cmp]['name']);
    $tmp[$cmp]['short_description'] = stripslashes($tmp[$cmp]['short_description']);
    $tmp[$cmp]['long_description'] = stripslashes($tmp[$cmp]['long_description']);
    $cmp++;
  }
  return $tmp;
}

function fixOneProduct($product){
  $tmp = $product;
  $tmp['name'] = stripslashes($tmp['name']);
  $tmp['short_description'] = stripslashes($tmp['short_description']);
  $tmp['long_description'] = stripslashes($tmp['long_description']);
  return $tmp;
}

function getProductListByOptions($page,$perpage,$params,$condition = "1"){
  $product = new Product();
  $res = $product->getProductListByOptions($page,$perpage,$params,$condition);
  if (isset($res['result'])) {
    $res['result'] = fixProduct($res['result']);
  }
  return $res;
}

function getTotalPanel(){
  $total=0;
  if (function_exists('os_totalpanel')) {
     $total = os_totalpanel();
  }
  return $total;
}

function goConnected(){
	if ( isset($_SESSION['user']) ) {
		return $_SESSION['user'];
	} else {
		echo '<script>window.location.href = "'._HOME_URL_.'account/login"</script>';
	}
}

function isConnected(){
	if (isset($_SESSION['user']))
		return $_SESSION['user'];
	else
		return false;
}

function getUserAdresse($uid,$aid){
	$user = new user();
	return $user->getUserAdresse($uid,$aid);
}

function getOrderList($uid){
	$account = new account();
	return $account->getOrderList($uid);
}
function getUserMail($email){
  $account = new account();
  return $account->getByEmail($email);
}

function getOrderById($oid,$condition){
	$account = new account();
	return $account->getOrderById($oid,$condition);
}
function getProductOrder($oid){
	$account = new account();
	return $account->getProductOrder($oid);
}

function getProductFetured($pid){
	$product = new Product();
	$res =  $product->getProductFetured($pid);
	$tmp = array();
	foreach ($res as $key => $value) {
		if ($value['value'] == null) {
			$tmp[$value['attribute']] = $value['name'];
		}else 
			$tmp[$value['attribute']] = $value['value'];
	}
	return $tmp;
}

function saveData($table, $data, $exclude = array()){
	$common = new Common();
	return $common->save($table, $data, $exclude);
}
function updateData($table, $params,$condition =""){
	$common = new Common();
	return $common->update($table, $params,$condition);
}
function addUserAdress($data,$uid){
	$account = new account();
	return $account->addUserAdress($data,$uid);
}
function customGET(){
	$req = $_SERVER['REQUEST_URI'];
    $req = substr($req,strpos($req, '?')+1);
    $req  = explode('&', $req);
    $return = array();
    foreach ($req as $value) {
    	$tmp = explode('=', $value);
    	if (count($tmp) == 2) {
    		$return[$tmp[0]] = $tmp[1];
    	}
    }
    return $return;
}

function deleteUserAdress($aid){
	$account = new account();
	if (isset($_SESSION['user'])) {
		return $account->deleteUserAdress($aid,$_SESSION['user']);
	}
	return false;
}

function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
function editUserInfo($data,$uid){
	$account = new account();
	return $account->editUserInfo($data,$uid);
}

function getProductDeclinaisons($pid){
	$product = new Product();
	$res =  $product->getProductDeclinaisons($pid);
	return $res;
}

function getProductByOption($options = array()){
	$product = new Product();
	$res =  $product->getProductByOption($options);
  $res = fixProduct($res);
	return $res;
}

  function getCatList($id){
    $category = getcategoryByParent($id);
    if ($category && !empty($category)) {
      foreach ($category as $key => $value) {
        $sub_cat = getcategoryByParent($value['id']);
        if ($sub_cat && !empty($sub_cat)) {
          echo '<li><a href="'._HOME_URL_.'category/'.$value['id'].'-'.$value['permalink'].'">'.$value['name'].'</a>  <span class="grower CLOSE" data-toggle="collapse" data-target="#cat_tab_'.$value['id'].'"></span>';
          echo '<ul id="cat_tab_'.$value['id'].'" class="collapse"> ';
          getCatList($value['id']);
          echo '</ul></li>';
        }else{
          echo '<li><a href="'._HOME_URL_.'category/'.$value['id'].'-'.$value['permalink'].'">'.$value['name'].'</a></li>';
        }
      }
    }
  }

   function getPanelCatList($id,$more = true,$first = false){
   	$output = "";
    $category = getcategoryByParent($id);
    if ($category && !empty($category)) {
      foreach ($category as $key => $value) {
        $sub_cat = getcategoryByParent($value['id']);
        if ($sub_cat && !empty($sub_cat) && $more) {
           /* $span_class = "grower CLOSE";
            if (!$first) {
              $span_class = "grower OPEN";
            }
          	$output.= '<li><a href="'._HOME_URL_.'category/'.$value['id'].'-'.$value['permalink'].'">'.$value['name'].'</a>  <span class="grower CLOSE" data-toggle="collapse" data-target="#cat_tab_'.$value['id'].'"></span>';
          	$output.= '<ul id="cat_tab_'.$value['id'].'" class="collapse"> ';
            $output.= getPanelCatList($value['id'],true);
          	$output.= '</ul></li>';*/

            if ($first) {
              $output.= '<li><a href="'._HOME_URL_.'category/'.$value['id'].'-'.$value['permalink'].'">'.$value['name'].'</a>  <span class=" OPEN" data-toggle="collapse" data-target="#cat_tab_'.$value['id'].'"></span>';
              $output.= '<ul id="cat_tab_'.$value['id'].'" class="collapse in"> ';
              $output.= getPanelCatList($value['id'],true);
              $output.= '</ul></li>';
            }else{
              $output.= '<li><a href="'._HOME_URL_.'category/'.$value['id'].'-'.$value['permalink'].'">'.$value['name'].'</a>  <span class="grower CLOSE" data-toggle="collapse" data-target="#cat_tab_'.$value['id'].'"></span>';
              $output.= '<ul id="cat_tab_'.$value['id'].'" class="collapse"> ';
              $output.= getPanelCatList($value['id'],true);
              $output.= '</ul></li>';
            }

           

        }else{
           	$output.= '<li><a href="'._HOME_URL_.'category/'.$value['id'].'-'.$value['permalink'].'">'.$value['name'].'</a></li>';
        }
      }
    }
    return 	$output;
  }

   function getSitemapCatList($id){
   	$output = "";
    $category = getcategoryByParent($id);
    if ($category && !empty($category)) {
      foreach ($category as $key => $value) {
        $sub_cat = getcategoryByParent($value['id']);
        if ($sub_cat && !empty($sub_cat)) {
          	$output.= '<li><a href="'._HOME_URL_.'category/'.$value['id'].'-'.$value['permalink'].'">'.$value['name'].'</a>';
          	$output.= '<ul> ';
          	$output.= getSitemapCatList($value['id']);
          	$output.= '</ul></li>';
        }else{
           	$output.= '<li><a href="'._HOME_URL_.'category/'.$value['id'].'-'.$value['permalink'].'">'.$value['name'].'</a></li>';
        }
      }
    }
    return 	$output;
  }

  function getCms($id){
  	$general = new general();
	$res =  $general->getCms($id);
	return $res;
  }


  function getAttachments($id){
  	$product = new Product();
	$res =  $product->getAttachments($id);
	return $res;
  }

  function getCmsByCatTitle($name){
  	$general = new general();
	$res =  $general->getCmsByCatTitle($name);
	return $res;
  }

    function getCmsByCatId($id){
      $general = new general();
      $res =  $general->getCmsByCatId($id);
      return $res;
    }

  function getCatImg($cid,$size = null){
  	$product = new Product();
	$res =  $product->getCatImg($cid,$size);
	if ($res == "") {
		return false;
	}else{
		$tmp = explode('.', $res);
		if ($size != null) $name = $tmp[0].$size.'.'.$tmp[1];
		else $name = $res;
		

		$file = 'files/category/'.$name;
		//return $file;
		if (file_exists($file)) {
			return $file;
		}
	}
	return false;
  }

  function setViewdProduct($id){
  	if (!isset($_SESSION['ViewdProduct'])){
      $_SESSION['ViewdProduct']=array();
   	}
   if (!array_search($id, $_SESSION['ViewdProduct'])) {
   		$_SESSION['ViewdProduct'][] = $id;
   }
   
   return true;
  }
  function getViewdProduct(){
  	if (!isset($_SESSION['ViewdProduct'])){
      $_SESSION['ViewdProduct']=array();
   	}

   	return $_SESSION['ViewdProduct'];
  }
  // Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function get_client_ip_country(){
  $ip = get_client_ip();
  $country = "";
  if ($c = getCountryByIp($ip)) {
    $country = $c['name'];
  }
  $ip_country = $ip .' - '.$country;
  $iso_code = getCurrentCountrycode();
  return  $ip_country ;
}
function ip_details($ip) {
 
  $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
  $details = json_decode($json, true);
  return $details;
}
function getQuotationById($idquotation,$condition,$user){

   global $DB;
   try {
      $sql = "SELECT  q.`id`,q.`cdate`,q.`id_state`,q.payment_method as payment ,q.current_state as status,q.id_state ,qo.`expiration_date`
      FROM ( `"._DB_PREFIX_."quotations` q, "._DB_PREFIX_."quotation_detail qp) LEFT JOIN "._DB_PREFIX_."quotation_options qo 
      on(q.id=qo.`id_quotation`) 
      WHERE  q.id = qp.`id_quotation` AND q.id = $idquotation AND q.id_customer = $user";
      $res = $DB->pdo->query($sql);
      $res = $res->fetch(PDO::FETCH_ASSOC);
      return $res;
   } catch (Exception $e) {
      return false;
   }
}



function save_mete_value($name, $value) {
	global $DB;
    try {
      $query = "DELETE FROM `"._DB_PREFIX_."meta_value` WHERE name = '$name'";
      $DB->pdo->query($query);
      $query = "INSERT INTO `"._DB_PREFIX_."meta_value`(`name`, `value`, `cdate`) VALUES('".$name."','".$value."',now())";
      if($DB->pdo->query($query)){
        $id_product = $DB->pdo->lastInsertId();
        return $id_product;
      }
    } catch (Exception $e) {
      return false;
    }
}

function select_mete_value($name){
	global $DB;
    try {
      $query = "SELECT value FROM "._DB_PREFIX_."meta_value WHERE name = '$name'";
      if($rows = $DB->pdo->query($query)){
        $data = $rows->fetch(PDO::FETCH_ASSOC);
        if(!empty($data)) return $data['value'];
      }
    } catch (Exception $e) {
      return false;
    }
}


function changeQuotationState($idquotation,$id_state,$condition =""){
	global $DB;
    try {
      $query = "UPDATE "._DB_PREFIX_."quotations SET id_state = $id_state WHERE id = $idquotation $condition";
      $DB->pdo->query($query);
      return true;
    } catch (Exception $e) {
      return false;
    }
}

function devisMessage($id_quotation,$objet,$attachement,$id_sender,$id_receiver,$msg){
   $msg = addslashes($msg);
   $attachement = addslashes($attachement);
   global $DB;
    $sql = "INSERT INTO `"._DB_PREFIX_."quotation_messages`( `id_quotation`, `id_sender`,`id_receiver`,`objet`, `message`, `attachement`, `file_name`,`status`,`cdate`) 
            VALUES ($id_quotation,$id_sender,$id_receiver,'$objet','$msg','$attachement','$attachement',0,now())";
    if($DB->pdo->query($sql)){
      $id_msg = $DB->pdo->lastInsertId();
      return $id_msg;
   }
   return false;
}

function getProductAssociated($id){
  global $DB;
    try {
      $query = "SELECT * FROM "._DB_PREFIX_."products p, `"._DB_PREFIX_."product_associated` pa 
                WHERE  p.id = pa.id_product AND pa.`associated_with` = $id";
      $res = $DB->pdo->query($query);
      $res = $res->fetchAll(PDO::FETCH_ASSOC);
      return $res;
    } catch (Exception $e) {
      return false;
    }
}

function get_meta_data($type){
  $product = new Product();
  if (empty($_GET['Module'])) {
    $res =  $product->get_meta_data($type,null,'home');
    if ($res && !empty($res)) {
      return $res;
    }
    return;
  }
  if (isset($_GET['Module']) && !empty($_GET['Module']) && isset($_GET['ID']) && !empty($_GET['ID'])) {
    //if ($_GET['Module'] == "product") {/*categories*/
     
      $res =  $product->get_meta_data($type,$_GET['ID'],$_GET['Module']);
      if ($res && !empty($res)) {
        return $res;
      }
    //}
  }
  return "";
}

function getUserloyalty($id){
  global $DB;
    try {
      $query = "SELECT * FROM `"._DB_PREFIX_."loyalty` WHERE  id_customer = $id";
      $res = $DB->pdo->query($query);
      $res = $res->fetchAll(PDO::FETCH_ASSOC);
      return $res;
    } catch (Exception $e) {
      return false;
    }
}

function getInvoicesList($id){
  global $DB;
    try {
      $query = "SELECT * FROM `"._DB_PREFIX_."invoices` WHERE  id_customer = $id";
      $res = $DB->pdo->query($query);
      $res = $res->fetchAll(PDO::FETCH_ASSOC);
      return $res;
    } catch (Exception $e) {
      return false;
    }
}

function getUserContactMsg($id){
  global $DB;
    try {
      $query = "SELECT *,
      CASE id_sender 
       WHEN $id THEN 'Vous'
       ELSE 'marchand'
      END as sender FROM `"._DB_PREFIX_."contact_messages` WHERE  id_sender = $id or id_receiver = $id";
      $res = $DB->pdo->query($query);
      $res = $res->fetchAll(PDO::FETCH_ASSOC);
      return $res;
    } catch (Exception $e) {
      return false;
    }
}


function changeUserPassword($email,$password){
  $user = new user();
  return $user->changeUserPassword($email,$password);
}
function recoverUserPassword($email,$pwrurl){
  try {
   /* $user = new user();
    if ($user->getByEmail($email)){
      $pass = generateRandomString();
      $newPass = md5($pass);
      $data = array(
        "email" => $email 
      );*/
      //Send mail to user with password.
      $Mails = new Mails();
      $Content = "Cher utilisateur,\n\nSi cet e-mail ne vous concerne pas s'il vous plaît ignorer. 
                  Il semble que vous avez demandé un nouveau mot de passe sur notre site web OkadShop.com
                   \n\nPour réinitialiser votre mot de passe, s'il vous plaît cliquez sur le lien ci-dessous. 
                   Si vous ne pouvez pas cliquer dessus, s'il vous plaît le coller dans la barre d'adresse 
                   de votre navigateur Web.\n\n".$pwrurl."\n\nMerci, L'Administration";

      $res = $Mails->SendFastMail('no-reply@okadshop.com',$email,'OkadShop.com - Réinitialiser le mot de passe',$Content);
      if ($res) {
       return true;
      }
  }catch (Exception $e) {
     return false;
  }
  return false;
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
  function getUserCartRule($user){
    global $DB;
      try {
        $query = "SELECT cr.code,cr.description,cru.quantity ,cr.reduction,cr.minimum_amount, cr.date_to, CASE cr.apply_discount  WHEN 0 THEN '%' WHEN 1 THEN '€' END as reduction_sign  FROM `"._DB_PREFIX_."cart_rule_user_codes` cru , "._DB_PREFIX_."cart_rule cr WHERE cru.id_cart_rule = cr.id AND cru.id_customer = $user";
        $res = $DB->pdo->query($query);
        $res = $res->fetchAll(PDO::FETCH_ASSOC);
        return $res;
      } catch (Exception $e) {
        return false;
      }
  }
  function getProductPromos(){
    global $DB;
      try {
        $query = "SELECT  GROUP_CONCAT(`product_restriction` SEPARATOR ',') as product_in_promos FROM `"._DB_PREFIX_."cart_rule` WHERE product_restriction != '' AND date_to > now()";
        $res = $DB->pdo->query($query);
        $res = $res->fetch(PDO::FETCH_ASSOC);
        return $res['product_in_promos'];
      } catch (Exception $e) {
        return false;
      }
  }
  function getCurrentCountrycode(){
    $whitelist = array(
      '127.0.0.1',
      '::1'
    );
    /* || strpos($_SERVER['REMOTE_ADDR'], '192.168') >= 0*/
    if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
        return;
    }
    $ipaddress = get_client_ip();
    $geo_details = ip_details($ipaddress); 
    $iso_code = $geo_details['country'];
    return $iso_code;
  }

  function getCountryByIp($ip){

    $geo_details = ip_details($ip); 
    $iso_code = $geo_details['country'];
    $condition = " WHERE iso_code = '".$geo_details['country']."'";
    $country = getCountryByOption($condition);
    if (isset($country['iso_code'])) {
      return $country;
    }
    return false;
  }

  function getCountryByOption($condition){
    global $hooks;
    $country = $hooks->select('countries', array('*'), $condition);
    if (isset($country[0])) {
      return $country[0];
    }
    return false;
  }

  function getCarrierByOption($option = array()){
    global $hooks;
    $condition = "";
    $carrier = array();
    if (isset($option['id_country'])) {
      $id_zone = $hooks->select('countries', array('id_zone'), ' WHERE id ='.$option['id_country']);
      if (isset($id_zone[0]['id_zone'])) {
        $id_zone = $id_zone[0]['id_zone'];
        $carrier_zones =  $hooks->select('carrier_zones', array('id_carrier'), ' WHERE active=1 AND id_zone ='.$id_zone);
        if (is_array($carrier_zones) && !empty($carrier_zones)) {
          $tmp = array();
          foreach ($carrier_zones as $key => $value) {
            $tmp[] = $value['id_carrier'];
          }
          $id_carriers = implode(',',$tmp);

          if (!empty($id_carriers)) {
            $carrier = $hooks->select('carrier', array('*'), ' WHERE id in('.$id_carriers.')');
          }
        }
      }
    }
    return $carrier;
  }

  function url_exists($url) {
    $hdrs = @get_headers($url);
    return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : false;
  }

  function chageUrl($url){
   // echo $url;
    echo "<script>window.history.pushState({url: '$url'}, '', '$url');</script>";
  }

  function addLangToUrl(){
    if (isset($_POST['lang_list']) || (!isset($_GET['lang']) && isset($_SESSION['code_lang'])) ) {
      $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      $lang = explode('_', $_SESSION['code_lang']);
      $lang = $lang[0];
      $module = $_GET['Module'];
      if (empty($module)) {
        if (isset($_GET['lang']))
          $actual_link = str_replace($_GET['lang'], $lang, $actual_link);
        else
          $actual_link .= $lang.'/';
      }else{
        if (isset($_GET['lang']))
           $actual_link = str_replace('/'.$_GET['lang'].'/', '/'.$lang.'/', $actual_link);
        else
          $pos = strpos($actual_link, $module);
          $actual_link = substr_replace($actual_link, $lang.'/', $pos, 0);
      }
      chageUrl($actual_link);
    }
  }

  function feature_product($id,$lang){
    global $DB;
    try {
      $query = "SELECT ft.name,fvt.value FROM `"._DB_PREFIX_."feature_product` fp,`"._DB_PREFIX_."feature_trans` ft, `"._DB_PREFIX_."feature_value_trans` fvt 
                WHERE fp.id_feature = ft.id_feature AND fp.id_feature_value = fvt.id_value  AND ft.id_lang =  $lang 
                AND fvt.id_lang = $lang AND fp.`id_product` = $id AND fp.custom = '' ";
      $res = $DB->pdo->query($query);
      $res = $res->fetchAll(PDO::FETCH_ASSOC);

      $query2 = "SELECT ft.name, fp.custom as value FROM `"._DB_PREFIX_."feature_product` fp,`"._DB_PREFIX_."feature_trans` ft
                 WHERE fp.id_feature = ft.id_feature AND ft.id_lang = $lang AND fp.custom !=  '' AND fp.`id_product` = $id";
      $res2 = $DB->pdo->query($query2);
      $res2 = $res2->fetchAll(PDO::FETCH_ASSOC);
      $res = array_merge($res, $res2);

      return $res;
    } catch (Exception $e) {
      return false;
    }
  }

?>