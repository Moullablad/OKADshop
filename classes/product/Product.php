<?php 
/**
* 
*/

namespace App\Product;

use Core\Security;

class Product
{
	

	public function getProductsImaes($PID){
		global $DB;
		try {
      $sql = "SELECT id,name FROM "._DB_PREFIX_."product_images WHERE id_product = ".$PID."  ORDER BY futured DESC";
      $res = $DB->pdo->query($sql);
      $res = $res->fetchAll( \PDO::FETCH_ASSOC);
      return $res;
    } catch (Exception $e) {
      return false;
    }
	}

	public function getcubyimg($img_id,$pid){
		global $DB;
		try {
      $sql = "SELECT * FROM `"._DB_PREFIX_."declinaisons` WHERE id_product = $pid AND images like '%".$img_id."%'";
      $res = $DB->pdo->query($sql);
      $res = $res->fetch( \PDO::FETCH_ASSOC);
      $return = array();
      if (isset($res['cu'])) {
      	 $tmp = explode(',', $res['cu']);
      	 foreach ($tmp as $key => $value) {
      	 	 $tmp2 = explode(':', $value);
      	 	 $return[] = array(
      	 	 								'attribute' => $tmp2[0] ,
      	 	 								'attribute_value' => end($tmp2)
      	 	 							);
      	 }
      }
      return $return;
    } catch (Exception $e) {
      return false;
    }
	}

	public function getimgbycu($cu,$pid){
		global $DB;
		try {
      $sql = "SELECT * FROM `"._DB_PREFIX_."declinaisons` WHERE id_product = $pid AND cu like '%$cu%'";
      $res = $DB->pdo->query($sql);
      $res = $res->fetch( \PDO::FETCH_ASSOC);
      $return = array();
      if (isset($res['images']) && !empty($res['images'])) {
      	 $return = explode(',', $res['images']);
      }
      return $return;
    } catch (Exception $e) {
      return false;
    }
	}

	public function the_translate(){

	}

	public function get_meta_data($type,$id,$page){
		try {
			if ($id != null) {
				$id = self::ToId($id);
				if (!$id) {
					return;
				}
			}
			
			global $hooks;
			global $DB;
			switch ($type) {
				case 'description':
					if ($page == "product") {
						$sql = "SELECT `meta_description` FROM "._DB_PREFIX_."products WHERE id = ".$id;
						$res = $DB->pdo->query($sql);
			      $res = $res->fetch( \PDO::FETCH_ASSOC);
			     	//$res = the_translate($res);
			      if (isset($res['meta_description'])) {
			      	$meta_description = strip_tags($res['meta_description']);
			      	$meta_description = stripslashes($res['meta_description']);
			      	return $meta_description;
			      }
		    	}else if ($page == "category") {
		    		$sql = "SELECT `meta_description` FROM "._DB_PREFIX_."categories WHERE id = ".$id;
						$res = $DB->pdo->query($sql);
			      $res = $res->fetch( \PDO::FETCH_ASSOC);
			      if (isset($res['meta_description'])) {
			      	$description = strip_tags($res['meta_description']);
			      	$description = stripslashes($res['meta_description']);
			      	return $description;
			      }
		    	}else if ($page == "home") {
		    		$shop = $hooks->select('shop');
		    		if (isset($shop[0]['meta_description'])) {
		    			return $shop[0]['meta_description'];
		    		}
		    	}
					break;
				case 'keywords':
					if ($page == "product") {
						$sql = "SELECT meta_keywords FROM "._DB_PREFIX_."products WHERE id = ".$id;
					/*	$sql = "SELECT GROUP_CONCAT(t.name SEPARATOR ', ') as keywords FROM `product_tags` pt ,`tags` t WHERE pt.`id_tag` = t.id AND `id_product` = ".$id;*/
						$res = $DB->pdo->query($sql);
			      $res = $res->fetch( \PDO::FETCH_ASSOC);
			      if (isset($res['keywords'])) {
			      	$keywords = strip_tags($res['keywords']);
			      	return $keywords;
			      }
		    	}else if ($page == "category") {
						$sql = "SELECT meta_keywords FROM "._DB_PREFIX_."categories WHERE id = ".$id;
						$res = $DB->pdo->query($sql);
			      $res = $res->fetch( \PDO::FETCH_ASSOC);
			      if (isset($res['meta_keywords'])) {
			      	$keywords = strip_tags($res['meta_keywords']);
			      	return $keywords;
			      }
		    	}else if ($page == "home") {
		    		$shop = $hooks->select('shop');
		    		if (isset($shop[0]['meta_keywords'])) {
		    			return $shop[0]['meta_keywords'];
		    		}
		    	}

					break;
					case 'title':
						if ($page == "product") {
							$sql = "SELECT `meta_title` FROM "._DB_PREFIX_."products WHERE id = ".$id;
							$res = $DB->pdo->query($sql);
				      $res = $res->fetch( \PDO::FETCH_ASSOC);
				      if (isset($res['meta_title']) && !empty($res['meta_title'])) {
				      	$meta_title = strip_tags($res['meta_title']);
				      	$meta_title = stripslashes($res['meta_title']);
				      	return $meta_title;
				      }
						}else if ($page == "category") {
							$sql = "SELECT `meta_title` FROM "._DB_PREFIX_."categories WHERE id = ".$id;
							$res = $DB->pdo->query($sql);
				      $res = $res->fetch( \PDO::FETCH_ASSOC);
				      if (isset($res['meta_title'])) {
				      	$name = strip_tags($res['meta_title']);
				      	$name = strip_tags($res['meta_title']);
				      	return $name;
				      }
						}else if ($page == "home") {
		    		$shop = $hooks->select('shop');
		    		if (isset($shop[0]['name'])) {
		    			return $shop[0]['name'];
		    		}
		    	}
						break;
			}
      

       return "";
    } catch (Exception $e) {
      return false;
    }
	}

	public function getProduct($page,$limit = 8)
	{
		global $DB;
		switch ($page) {
			case 'home':
				try {
	        $sql = "SELECT * FROM "._DB_PREFIX_."products ORDER BY reference ASC LIMIT $limit";
	        $res = $DB->pdo->query($sql);
	        $res = $res->fetchAll( \PDO::FETCH_ASSOC);
	        $res = self::oslang_migrate_product($res,true);
	        return $res;
	      } catch (Exception $e) {
	        return false;
	      }
				break;
			
			default:
				# code...
				break;
		}
		return false;
	}

	public function getProductIdFromLink($link)
	{
		$id = explode('-', $link);
		$id = $id[0];
		$Security = new Security();
		if ($Security->check_numbers($id)) {
			global $DB;
			try {
	        $sql = "SELECT * FROM "._DB_PREFIX_."products WHERE id = ".$id;
	        $res = $DB->pdo->query($sql);
	        $res = $res->fetch( \PDO::FETCH_ASSOC);
	        $res = self::oslang_migrate_product($res);
	        return $res;
	      } catch (Exception $e) {
	        return false;
	      }
		}
		return false;
	}

	public function oslang_migrate_product($product,$list = false){
		if (!$product || empty($product)) return $product;
		$tmp = $product;
		if (!$list){
			$tmp = self::oslang_migrate_product_table($tmp);
		}else{
			for ($i=0; $i <count($tmp) ; $i++) { 
				$tmp[$i] = self::oslang_migrate_product_table($tmp[$i]);
			}
		}
		return $tmp;
	}

	public function oslang_migrate_product_table($product){
		$tmp = $product;
		global $hooks;
		if (isset($_SESSION['code_lang'])) {
			$id_product = $tmp['id'];
			$code_lang = $_SESSION['code_lang'];
			$condition = " WHERE id_product = ".$id_product." AND code_lang = '".$code_lang."'";
			$res = $hooks->select('lang_product',array('*'),$condition);
			if (isset($res[0])) {
				$res = $res[0];
				if (!empty($res['name'])) {
					$tmp['name'] = $res['name'];

				}
				if (!empty($res['short_description'])) {
					$tmp['short_description'] = $res['short_description'];
				}
				if (!empty($res['long_description'])) {
					$tmp['long_description'] = $res['long_description'];
				}
			}
		}
		return $tmp;
	}

	public function oslang_migrate_category($category,$list = false){
		if (!$category || empty($category)) return $category;
		$tmp = $category;
		if (!$list){
			$tmp = self::oslang_migrate_category_table($tmp);
		}else{
			for ($i=0; $i <count($tmp) ; $i++) { 
				$tmp[$i] = self::oslang_migrate_category_table($tmp[$i]);
			}
		}
		return $tmp;
	}

	public function oslang_migrate_category_table($product){
		$tmp = $product;
		global $hooks;
		if (isset($_SESSION['code_lang'])) {
			$id_category = $tmp['id'];
			$code_lang = $_SESSION['code_lang'];
			$condition = " WHERE id_category = ".$id_category." AND code_lang = '".$code_lang."'";
			$res = $hooks->select('lang_category',array('*'),$condition);
			if (isset($res[0])) {
				$res = $res[0];
				if (!empty($res['name'])) {
					$tmp['name'] = $res['name'];
				}
				if (!empty($res['description'])) {
					$tmp['description'] = $res['description'];
				}
			}
		}
		return $tmp;
	}

	public function getProductByCategory($CID,$LIMIT){
		$CID = explode('-', $CID);
		$CID = $CID[0];
		$Security = new Security();
		if ($Security->check_numbers($CID)) {

			global $DB;
			try {
				$condition ='';
				if ($LIMIT != null) {
					$condition .=' LIMIT '.$LIMIT;
				}
		    $sql = "SELECT DISTINCT p.id,p.name,p.short_description,TRUNCATE(p.sell_price,2) as sell_price,p.permalink,p.qty
		    				FROM `"._DB_PREFIX_."product_category` pc , "._DB_PREFIX_."products p 
		    				WHERE pc.`id_product` = p.id and pc.`id_category` = $CID $condition";
		    $res = $DB->pdo->query($sql);
		    $res = $res->fetchAll( \PDO::FETCH_ASSOC);
		    return $res;
		  } catch (Exception $e) {
		    return false;
		  }
		 }
	}	

	public function getcategoryByName($name){
		global $DB;
		try {
		    $sql = "SELECT id from "._DB_PREFIX_."categories WHERE name = '$name'";
		    $res = $DB->pdo->query($sql);
		    $res = $res->fetch( \PDO::FETCH_ASSOC);
		    return $res;
		} catch (Exception $e) {
		    return false;
		}
	}


	public function ToId($str){
		$id = explode('-', $str);
		$id = $id[0];
		$Security = new Security();
		if (!$Security->check_numbers($id)) {
			return false;
		}
		return $id;
	}
	public function getProductListByOptions($page,$perpage,$params,$condition){
		try {
			
			$page = self::ToId($params['page']);
			if (!$page) {
				return false;
			}
			$return = array();
			global $DB;
			$options = array(
			  'results_per_page' => $params['perpage'],
			  'url' => '*VAR*',
			  'db_handle' => $DB,
			  'using_bound_values' => true
			);
			/*if ($options['isStartPage']) {
				$options['url'] = $link.'/*VAR*';
			}*/
			$sql = "SELECT DISTINCT p.id,p.name,p.short_description,TRUNCATE(p.sell_price,2) as sell_price ,p.permalink,p.qty
		    				FROM  "._DB_PREFIX_."products p 
		    				WHERE  $condition ORDER BY ".$params['orderby'];
		  
		  try {
			  	$paginator = new paginator($page,$sql, $options);
			  } catch (Exception $e) {
			  	return false;
			  }
			  $paginator->execute();
			  if($paginator->success == true)
		    {
		    	$return['total'] = $paginator->total_results;
		    	$return['result'] = $paginator->resultset->fetchAll();
		    	$return['result'] = self::oslang_migrate_product($return['result'],true);
		    	$return['links_html'] = $paginator->links_html;
		    	return $return;
		    }
		} catch (Exception $e) {
			return false;
		}
	}	

		public function getProductListByCategory($link,$page,$perpage,$condition,$isStartPage,$orderby = " id DESC"){
		$CID = self::ToId($link);
		$page = self::ToId($page);
		if (!$CID || !$page) {
			return false;
		}
		$return = array();
		global $DB;
		$options = array(
		  'results_per_page' => $perpage,
		  'url' => '*VAR*',
		  'db_handle' => $DB,
		  'using_bound_values' => true
		);
		if ($isStartPage) {
			$options['url'] = $link.'/*VAR*';
		}
		$sql = "SELECT DISTINCT p.id,p.name,p.short_description,TRUNCATE(p.sell_price,2) as sell_price,p.permalink,p.qty
	    				FROM `"._DB_PREFIX_."product_category` pc , "._DB_PREFIX_."products p 
	    				WHERE pc.`id_product` = p.id and pc.`id_category` = $CID $condition ORDER BY $orderby";
	  

	  try {
	  	$paginator = new paginator($page,$sql, $options);
	  } catch (Exception $e) {
	  	return false;
	  }
	  $paginator->execute();
	  if($paginator->success == true)
    {
    	$return['total'] = $paginator->total_results;
    	$return['result'] = $paginator->resultset->fetchAll();
    	$return['result'] = self::oslang_migrate_product($return['result'],true);
    	$return['links_html'] = $paginator->links_html;
    	return $return;
    }
    return false;
	}


	public function getSimProductByCategory($CID,$LIMIT){
		global $DB;
		try {
			$condition ='';
			if ($LIMIT != null) {
				$condition .=' LIMIT '.$LIMIT;
			}
     /* $sql = "SELECT DISTINCT p.id,p.name,p.short_description,p.sell_price,p.permalink 
      				FROM `product_category` pc , products p 
      				WHERE pc.`id_product` = p.id  and pc.`id_product` != $CID 
      				and pc.`id_category` in 
      				(SELECT pcc.`id_category` FROM product_category pcc WHERE pcc.`id_product` = $CID) $condition";*/
      $sql = "SELECT DISTINCT p.id,p.name,p.short_description,TRUNCATE(p.sell_price,2) as sell_price,p.permalink 
      				FROM "._DB_PREFIX_."products p 
      				WHERE p.id_category_default = $CID $condition";
      $res = $DB->pdo->query($sql);
      $res = $res->fetchAll( \PDO::FETCH_ASSOC);
      //$res = self::oslang_migrate_product($res);
      return $res;
    } catch (Exception $e) {
      return false;
    }
	}	

	public function getThumbnail($PID,$imgid = false){
		global $DB;
		try {
			$condition ="";
			if ($imgid) {
				$condition = " AND id = $imgid ";
			}
      $sql = "SELECT name FROM "._DB_PREFIX_."product_images WHERE id_product = $PID $condition ORDER BY futured DESC,position ASC LIMIT 1";
      $res = $DB->pdo->query($sql);
      $res = $res->fetch( \PDO::FETCH_ASSOC);
      return $res;
    } catch (Exception $e) {
      return false;
    }
	}


	public function getCategoryById($CID){
		$CID = explode('-', $CID);
		$CID = $CID[0];
		global $DB;
		try {
      $sql = "SELECT * FROM "._DB_PREFIX_."categories WHERE id = $CID";
      $res = $DB->pdo->query($sql);
      $res = $res->fetch( \PDO::FETCH_ASSOC);
      $res = self::oslang_migrate_category($res);
      return $res;
    } catch (Exception $e) {
      return false;
    }
	}
	public function getCount($table,$condition){
		try {
			global $DB;
      $sql = "SELECT COUNT(*) AS NBTOTAL FROM "._DB_PREFIX_."$table WHERE $condition";
      $res = $DB->pdo->query($sql);
      $res = $res->fetch( \PDO::FETCH_ASSOC);
      return $res['NBTOTAL'];
    } catch (Exception $e) {
      return false;
    }
	}
	public function getcategoryByParent($p,$LIMIT){
		$p = explode('-', $p);
		$p = $p[0];
		$condition = " AND hidden = 0 ORDER BY position ASC,`image_cat` DESC ";
		global $DB;
		if ($LIMIT != null) 
			$condition .="LIMIT $LIMIT";
		try {
      $sql = "SELECT * FROM "._DB_PREFIX_."categories WHERE parent = $p $condition";
      $res = $DB->pdo->query($sql);
      $res = $res->fetchAll( \PDO::FETCH_ASSOC);
      $res = self::oslang_migrate_category($res,true);
      return $res;
    } catch (Exception $e) {
    	//echo $e;
      return false;
    }
	}
	public function getProductByids($ids,$LIMIT){
		global $DB;

		try {
      $sql = "SELECT * FROM "._DB_PREFIX_."products WHERE id in ($ids)";
      if ($LIMIT != null) {
      	$sql .= " LIMIT $LIMIT";
      }
      $res = $DB->pdo->query($sql);
      $res = $res->fetchAll( \PDO::FETCH_ASSOC);
      return $res;
    } catch (Exception $e) {
      return false;
    }
	}
	public function getProductByid($id){
		global $DB;
		try {
      $sql = "SELECT p.*,t.rate FROM "._DB_PREFIX_."products p LEFT join "._DB_PREFIX_."taxes t ON p.id_tax = t.id WHERE p.id = ($id)";
      $res = $DB->pdo->query($sql);
      $res = $res->fetch( \PDO::FETCH_ASSOC);
      /*$tmp = array();
      foreach ($res as $key => $value) {
      	echo $value;
      }*/
      return $res;
    } catch (Exception $e) {
      return false;
    }
	}

	public function confirmOrder($cart,$uid,$payment_methode,$status,$total,$adress_fact,$adress_liv){
		global $DB;
		try {
      $sql = "INSERT INTO `"._DB_PREFIX_."orders` (`id_user`, `id_payment`, `id_status`, `total`,adress_fact,adress_liv, `cdate`) VALUES($uid,$payment_methode,$status,$total,$adress_fact,$adress_liv,now())";
       $DB->pdo->query($sql);
       $id_order = $DB->lastInsertId("id");
       $common = new Common();
       for ($i=0; $i < count($cart['idProduit']) ; $i++) { 
       		$data = array(
       			"id_order" => intval($id_order),
       			"id_product" => intval($cart['idProduit'][$i]),
       			"qte" => intval($cart['qteProduit'][$i]),
       			"prix" => floatval($cart['prixProduit'][$i])
       		);
       		$common->save('order_details',$data);
       }
       supprimePanier();
       return $id_order;
    } catch (Exception $e) {
      return false;
    }
	}

	public function getProductFetured($pid){
		//SELECT a.name,pa.`value`, pa.`value` FROM `products_attributes` pa,attributes a WHERE pa.`id_attribute` = a.id and pa.`id_product` = 81
		global $DB;
		try {
      $sql = "SELECT a.name as attribute, pa.`value`,av.name 
      FROM (`"._DB_PREFIX_."product_attributes` pa, "._DB_PREFIX_."attributes a) LEFT OUTER JOIN "._DB_PREFIX_."attribute_values av 
      ON av.id = pa.id_value  WHERE pa.`id_attribute` = a.id  AND pa.`id_product` = $pid";
      $res = $DB->pdo->query($sql);
      $res = $res->fetchAll( \PDO::FETCH_ASSOC);
      return $res;
    } catch (Exception $e) {
      return false;
    }
	}

	public function getProductDeclinaisons($pid){
		global $DB;
		try {
      $sql = "SELECT DISTINCT a.id,a.name 
      FROM `"._DB_PREFIX_."attributes` a, "._DB_PREFIX_."product_declinaisons pd , "._DB_PREFIX_."declinaisons d 
      WHERE  a.`id` = pd.id_attribute  AND d.id = pd.id_declinaison 
      AND d.id_product = $pid";
      $attributes = $DB->pdo->query($sql);
      $attributes = $attributes->fetchAll( \PDO::FETCH_ASSOC);
      $product_attributes_values = array();
      foreach ($attributes as $key => $attribute) {
      	$sql2 ="SELECT DISTINCT av.id,av.name 
				      FROM `"._DB_PREFIX_."attribute_values` av, "._DB_PREFIX_."product_declinaisons pd , "._DB_PREFIX_."declinaisons d 
				      WHERE  av.`id` = pd.id_value  AND d.id = pd.id_declinaison 
				      AND d.id_product = $pid AND pd.id_attribute = ".$attribute['id'];
	      $attribute_values = $DB->pdo->query($sql2);
	      $attribute_values = $attribute_values->fetchAll( \PDO::FETCH_ASSOC);
	      $tmp = array(
	      	"attributes" => $attribute,
	      	"attribute_values" => $attribute_values,
	      );
				array_push($product_attributes_values, $tmp);
      }

      return $product_attributes_values;
     
    } catch (Exception $e) {
      return false;
    }
	}


	public function getDeclinaisonByCombinaison($data = array(),$product_id){
		global $DB;
		if (empty($data))
			 return false;

			

		$cu = "";
		foreach ($data as $key => $value) {
			$cu .= ($key.':'.$value.',');
		}
		$cu = rtrim($cu, ",");
		try {
			$sql = "SELECT (`buy_price`+`price_impact`) as sell_price , `quantity`,min_quantity FROM "._DB_PREFIX_."declinaisons WHERE cu = '$cu'";
		  $res = $DB->pdo->query($sql);
      $res = $res->fetch( \PDO::FETCH_ASSOC);
      return $res;
		} catch (Exception $e) {
			 return false;
		}
	}

	public function getProductByOption($options){
		global $DB;
		$condition	 = "";
		$options['search_query'] = strip_tags($options['search_query']);
		$options['search_query'] = addslashes($options['search_query']);
		/*
		if (strlen($options['search_query']) < 3) {
			return false;
		}/
		*/
		//don't forget security
		if (isset($options['search_query']) && !empty($options['search_query'])) {
			$condition .= " `name` LIKE '%".$options['search_query']."%' or `short_description` LIKE '%".$options['search_query']."%' or `long_description` LIKE '%".$options['search_query']."%' AND";
		}

		if ($condition != "") {
			$condition = rtrim($condition, "AND");
			$condition = "WHERE ".$condition;
		}

		try {
	    $sql = "SELECT * FROM "._DB_PREFIX_."products $condition";
	    //echo $sql;
	    $res = $DB->pdo->query($sql);
	    $res = $res->fetchAll( \PDO::FETCH_ASSOC);
	    $res = self::oslang_migrate_product($res,true);
	    return $res;
	  } catch (Exception $e) {
	    return false;
	  }
	}

	public function getAttachments($PID){
		global $DB;
		try {
      $sql = "SELECT * FROM "._DB_PREFIX_."product_attachments WHERE id_product = ".$PID;
      $res = $DB->pdo->query($sql);
      $res = $res->fetchAll( \PDO::FETCH_ASSOC);
      return $res;
    } catch (Exception $e) {
      return false;
    }
	}



	public function getCatImg($cid,$size){
		global $DB;
		try {
      $sql = "SELECT image_cat FROM  "._DB_PREFIX_."categories WHERE id = ".$cid;
      $res = $DB->pdo->query($sql);
      $res = $res->fetch( \PDO::FETCH_ASSOC);
      return $res["image_cat"];
    } catch (Exception $e) {
      return false;
    }
	}






}/* ./prodduct class*/
?>