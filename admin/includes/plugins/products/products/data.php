<?php
/**
 * 2016 OkadShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@okadshop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OkadShop <contact@okadshop.com>
 * @copyright 2016 OkadShop
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of OkadShop
 */


//DEFAULT FUNCTIONS
function Add(){}
function EDIT($ID){}
function DELETE($ID)
{
	global $common;
	global $DB;
	$query = "select COUNT('*') as count
						from (
					    select id_product from "._DB_PREFIX_."order_detail
					    union all
					    select id_product from "._DB_PREFIX_."invoice_detail
						) a
						where id_product=$ID";
	if($rows = $DB->pdo->query($query)){
		$data = $rows->fetch(PDO::FETCH_ASSOC);
    if( empty($data['count']) ){
    	$common->delete('product_associated', 'WHERE id_product='.$ID);
    	$common->delete('product_attachments', 'WHERE id_product='.$ID);
    	$common->delete('product_category', 'WHERE id_product='.$ID);
    	$common->delete('product_images', 'WHERE id_product='.$ID);
    	$common->delete('product_tags', 'WHERE id_product='.$ID);
    	$common->delete('declinaisons', 'WHERE id_product='.$ID);
    	$common->delete('products', 'WHERE id='.$ID);
    }
  }

  echo '<script>window.location.href="?module=products"</script>';

}
//exit if delete action
if ( $_GET['action'] == "delete" ) return;



//Classe Instance
$os_product = new OS_Product();
$errors = array();
$success = array();
$cat_list = array();
$tag_list = '';
$json_combinations = '';
$allowed_tags = allowed_tags();



//get user id
use Core\Image;
use Core\i18n\Language;
use Core\Controllers\Admin\UserController;


$id_user = UserController::get('id');
$id_lang = Language::getDefaultLanguage();


/**
 *=============================================================
 * UPDATE PRODUCT MODE
 * This part well apply when you go to edit a product from list
 * EX: [WewSite]/index.php?module=products&action=edit&id=[82]
 *=============================================================
 */
if(isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['action']) && $_GET['action'] == 'edit'){
	$id_product = $os_product->getProductByID( $_GET['id'] );
	if(!isset($id_product) || $id_product <= 0){
		echo '<script>window.location.href="?module=products"</script>';
	}
/*============================================================*/
} //END UPDATE PRODUCT MODE
/*============================================================*/




/**
 *=============================================================
 * PROCCESS POSTED DATA
 *=============================================================
 */
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

	

	//INSERT ASSOCIATED
	if(isset($_POST['associated']) && $_POST['associated'] == "insert" )
	{
		$save = $os_product->save(
			'product_associated', 
			array(
				'id_product' => intval($_POST['assoc']['id_product']), 
				'associated_with' => $id_product,
				'cby' => $id_user
			)
		);
		if( $save ){
			array_push($success, l("Le produit associé a été ajouter.", "core") );
		}
	}

	//DELETE ASSOCIATED
	if( isset($_POST['assoc_delete']) )
	{
		$id_assoc = intval($_POST['assoc_delete']);
		if( $id_assoc > 0 ){
			$delete = $os_product->delete('product_associated', "WHERE id=".$id_assoc );
			if( $delete ){
				array_push($success, l("Le produit associé a été supprimer.", "core") );
			}
		}
	}


	//Prepare data
	$product_data = array(
		'name' 							 	=> $_POST['product']['name'], 
		'reference' 				 	=> $_POST['product']['reference'], 
		'type' 							 	=> intval($_POST['product']['type']), 
		'short_description'  	=> strip_tags($_POST['product']['short_description'], $allowed_tags),
		'long_description' 	 	=> strip_tags($_POST['product']['long_description'], $allowed_tags),
		'product_condition'  	=> $_POST['product']['product_condition'], 
		'qty' 							 	=> intval($_POST['product']['qty']),
		'min_quantity' 			 	=> intval($_POST['product']['min_quantity']), 
		'loyalty_points' 			=> intval($_POST['product']['loyalty_points']), 
		'ean13' 						 	=> $_POST['product']['ean13'],
		'upc' 							 	=> $_POST['product']['upc'], 
		'buy_price' 				 	=> floatval($_POST['product']['buy_price']), 
		'sell_price' 				 	=> floatval($_POST['product']['sell_price']),
		'wholesale_price'  	 	=> floatval($_POST['product']['wholesale_price']), 
		'wholesale_per_qty'  	=> floatval($_POST['product']['wholesale_per_qty']), 
		'discount'				   	=> floatval($_POST['product']['discount']), 
		'discount_type'	  	 	=> intval($_POST['product']['discount_type']), 
		'width'					  	 	=> floatval($_POST['product']['width']),
		'height'					   	=> floatval($_POST['product']['height']), 
		'depth'					  	 	=> floatval($_POST['product']['depth']), 
		'weight' 				  	 	=> floatval($_POST['product']['weight']),
		'packing_price' 		 	=> floatval($_POST['product']['packing_price']),
		'meta_title' 				 	=> $_POST['product']['meta_title'], 
		'meta_description' 	 	=> $_POST['product']['meta_description'], 
		'link_rewrite' 			 	=> $_POST['product']['link_rewrite'], 
		'id_category_default' => intval($_POST['product']['id_category_default']),
		'cdate' 			 				=> $_POST['product']['cdate'], 
		'id_tax' 						  => intval($_POST['product']['id_tax']),
		'id_user' 					  => $id_user,
		'active' 						  => intval($_POST['product']['active']),
		'id_lang'						  => get_default_id_lang()
	);
	if ($_POST['product']['link_rewrite'] == "") {
		$product_data['permalink'] = $os_product->slugify($_POST['product']['name']);
	}else{
		$product_data['permalink'] = $_POST['product']['link_rewrite'];
	}

	/*echo '<pre>';
print_r($product_data);
echo '</pre>';
*/


	//SAVE PRODUCT PROCCESS
	if(isset($_POST['save']) && !empty($_POST['product']['name']) ){

		//Insert Product
		$id_product = $os_product->save('products', $product_data);
		if( $id_product ){
			//insert or update categories
			if(isset($_POST['product']['categories'])){
				$categories = $_POST['product']['categories'];
				$os_product->insertAssociations($id_product,$categories);
			}
			
			//Insert Tags
			if(!empty($_POST['tags'])){
				$tag_list = implode(",", $_POST['tags']);
				$tags = explode(",", $tag_list);
				$os_product->insertProductTags($id_product,$tags);
			}

			echo '<script>window.location.href="?module=products&action=edit&id='.$id_product.'"</script>';
		}

	/*============================================================*/
	} //END PRODUCT SAVE
	/*============================================================*/

	//UPDATE PRODUCT PROCCESS
	if(isset($_POST['update']) && !empty($_POST['product']['name'])){

		//var_dump($_POST['combinations']);exit;

		$id_product = intval($_POST['product']['id']);
		if(!isset($id_product) && $id_product <= 0) return;

		//push columns to product array
		//$product_data['buy_price'] = intval($_POST['product']['buy_price']);

		//Update Product
		$os_product->update('products',$product_data, "WHERE id=".$id_product );

		//insert or update categories
		if(isset($_POST['product']['categories'])){
			$categories = $_POST['product']['categories'];
			$os_product->insertAssociations($id_product,$categories);
		}else{
			$categories = array();
			$os_product->insertAssociations($id_product,$categories);
			array_push($errors, l("Le produit doit avoir au moin une seul catégorie.", "core") );
		}

		//Insert Tags
		if(!empty($_POST['tags'])){
			$tag_list = implode(",", $_POST['tags']);
			$tags = explode(",", $tag_list);
			$os_product->insertProductTags($id_product,$tags);
		}

		//Insert Attribute
		if(!empty($_POST['features'])){
			$feature_ids = $_POST['feature_ids'];
			$features = json_decode($_POST['features'], true);
			$insert = $os_product->insert_feature_product($id_product,$features,$feature_ids);
		}

		//AJOUTER OU MODIFIER DES DÉCLINAISONS DE PRODUIT

		if(!empty($_POST['combinations'])){

			//Insert declinaison
			$dec_data = $_POST['declinaison'];

			//set default_dec to 0
			if( !isset($_POST['declinaison']['default_dec']) )
				$dec_data['default_dec'] = 0;

			if( !empty($_POST['declinaison']['images'])){
				//$images_ids = implode(',', $_POST['declinaison']['images']);
				$dec_data['images'] = json_encode($_POST['declinaison']['images']);
			}
			$dec_data['id_product'] = $id_product;
			$id_declinaison = intval($_POST['id_declinaison']);
			if(isset($id_declinaison) && $id_declinaison > 0){
				$condition = 'WHERE id='.$id_declinaison;
				$os_product->update('declinaisons',$dec_data,$condition);
			}else{
				$id_declinaison = $os_product->save('declinaisons',$dec_data);
			}
			//Insert combinations
			$combinations = json_decode($_POST['combinations'], true);
			$os_product->insertProductCombinations($id_declinaison,$combinations);
		}

		//QUANTITÉS DISPONIBLES
		if(!empty($_POST['quantities'])){
			$os_product->updateDeclinaisonQuantities($_POST['quantities']);
		}

		//SET FUTURED IMAGE
		if(isset($_POST['id_image']) && isset($_POST['image_name']) && !empty($_POST['image_name'])){
			$id_image = intval($_POST['id_image']);
			if(isset($id_image) && $id_image > 0){
				$copy = $os_product->setFuturedImage($id_image, $id_product);
				if( $copy )
				{
					$file = "../files/products/".$id_product ."/". $os_product->get_file_name( $_POST['image_name'] );
					$newfile = "../files/products/".$id_product ."/dashboard.jpg";//.$id_product. $os_product->get_file_extension($_POST['image_name']);
					if( file_exists($file) )
					{
						if (!copy($file, $newfile)) {
						  array_push($errors, l("failed to copy.", "core") );
						}
					}else{
						array_push($errors, l("Le fichier [$file] n'exist pas.", "core") );
					}
				}
			}
		}



		//UPLOAD AND CROPING
		if(
			isset($_FILES['files']) 
			&& $_FILES['files']['size'][0] > 0
		){

			$p_featured = $os_product->select("product_images", array('id'), "WHERE `id_product`=".$id_product." AND `futured`=1");
			//Uploading Files
			$uploadDir = '../files/products/'.$id_product.'/';
			$files_upload = $os_product->uploadFiles($_FILES['files'],$uploadDir);

			//Prepare image to crop
			$new_files = array();
			foreach ($_FILES['files']['name'] as $file) {
				//Check if files allready in DB
				if(!empty($file)){
					$exist = $os_product->getImageByName($file,$id_product);
					if($exist == false){
						array_push($new_files, $file);
					}
				}
			}
			//START RESIZING IMAGES
			if(!empty($new_files)){
				//20-dashboard.png
				//$sizes = array('828x220','200x200','360x360','80x80','45x45');
				foreach ($new_files as $key => $filename) {
					//Croping Files
					$imageDir = _BASE_URI_ . 'files/products/' . $id_product . '/' . $filename;
            		$sizes = array("45x45", "76x76", "80x80", "100x122", "120x45", "200x200", "360x360", "570x697", "828x220");
                	Image::resizeImage($imageDir, $sizes);

					//$crop = $os_product->cropFile($uploadDir,$filename);
					//Insert images
					$id_image = $os_product->insertProductImage($id_product, $filename);
					//$copy = $os_product->setFuturedImage($id_image,$id_product);
					if( $key === 0 && $p_featured === false ){
						$os_product->update("product_images", array('futured' => 1), "WHERE `id`=".$id_image);
					}
				}
			}
		}



		//UPLOAD ATTACHMENT
		if(
			isset($_FILES['attachment']) 
			&& $_FILES['attachment']['size'][0] > 0 
			&& !empty($_POST['attachment']['name'])
		){
			//Uploading Files
			//$uploadDir = UPLOADS_PATH.'attachments/'.$id_product.'/';
			$uploadDir = '../files/attachments/';
			$extensions=array('jpg', 'gif', 'png', 'pdf', 'doc', 'ppt', 'odt', 'docx', 'xlsx', 'pptx', 'psd', 'rar', 'zip');
			$upload_success = $os_product->uploadFiles($_FILES['attachment'],$uploadDir,$extensions);
			$attachment = str_replace($uploadDir, "", $upload_success[0]);
			$name = $_POST['attachment']['name'];
			$slug = $os_product->slugify($name);
			$description = $_POST['attachment']['description'];
			//Save attachement
			$data = array(
				'name' => $name,
				'slug' => $slug,
				'description' => $description,
				'attachment' => $attachment,
				'file_md5' => md5($name),
				'id_product' => $id_product
			);
			$os_product->save('product_attachments',$data);
		}else if(
			isset($_FILES['attachment']) 
			&& $_FILES['attachment']['size'][0] > 0 
			&& empty($_POST['attachment']['name'])
		){
			array_push($errors, l("Le Nom du fichier est obligatoire.", "core") );
		}

		array_push($success, l("Le produit a été mise à jour.", "core") );

	/*============================================================*/
	} //END PRODUCT UPDATE
	/*============================================================*/



/*============================================================*/
} //END POSTED DATA
/*============================================================*/



/**
 *=============================================================
 * PREPARE DATA AFTER SAVE
 * This part well apply after the first save of new product
 *=============================================================
 */
if(isset($id_product) && $id_product > 0){
	//Product Data
	$infos = $os_product->getProductData($id_product);
	$tags = $os_product->getProductTags($id_product);
	if(!empty($tags)) $tag_list = implode(",", $tags);
	$cat_list = $os_product->getProductCategories($id_product);
	$images = $os_product->getProductImages($id_product);
	//Upload Directory
	$uploadDir = '../files/products/'.$id_product.'/';
	//Product Images
	$images = $os_product->getProductImages($id_product); 
	//Product Attributes
	$attributes = $os_product->getAttributes();
	//Generate Json attributes 
	/*$att_json = $os_product->AttributesToJson($id_product);
	if(!empty($att_json)){
		$attr_array = array();
		foreach ($att_json as $key => $attr) {
			$id = $attr['id_attribute'];
			$attr_array[$id] = array();
			$attr_array[$id]['id_product'] = $attr['id_product'];
			$attr_array[$id]['id_attribute'] = $id;
			$attr_array[$id]['id_value'] = $attr['id_value'];
			$attr_array[$id]['value'] = $attr['value'];
		}
		$json_attributes = json_encode($attr_array);
	}else{
		$json_attributes = '';
	}*/
	//Product Declinaisons
	$product_declinaisons = $os_product->getProductDeclinaisons($id_product);
	//Product Attachments
	$product_attachments = $os_product->getProductAttachments($id_product);
	//products list
	$product_list = $os_product->get_products_list();
	//associated products
	$associated_products = $os_product->get_associated_products($id_product);

	/*echo "<pre>";
	print_r($associated_products);
	echo "</pre>";*/

/*============================================================*/
} //END DATA PREPARATION
/*============================================================*/



//OTHER DATA
$taxes = $os_product->select('taxes', array('id', 'name', 'rate'), "WHERE active=1");
//product_categories
$product_categories = $os_product->select('categories', array('id', 'name'));
//var_dump($infos);
?>
<form class="form-horizontal" method="post" action="" enctype="multipart/form-data" novalidate>
	<input type="hidden" name="product[id]" id="id_product" value="<?= (isset($id_product) && $id_product > 0) ? $id_product : '';?>">
  <div class="top-menu padding0">
    <div class="top-menu-title">
      <h3>
      	<i class="fa fa-shopping-cart"></i>
      	<?= (isset($id_product) && $id_product > 0) ? l("Modifier les informations de Produit", "core") : l('Ajouter un Produit');?>
      </h3>
    </div>
    <div class="top-menu-button">
    	<button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Terminer", "core");?></button>
      <button type="submit" name="<?= (isset($id_product) && $id_product > 0) ? 'update' : 'save';?>" class="btn btn-primary"><?=l("Sauvegarder et rester", "core");?></button>
    </div>
  </div><br>

	<?php if(!empty($errors)) : ?>
		<div class="alert alert-warning">
			<h4><?=l("Une erreur est survenue !", "core");?></h4>
			<ul>
			<?php foreach ($errors as $key => $error) : ?>
				<li><?=$error;?></li>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php elseif(!empty($success)) : ?>
		<div class="alert alert-success">
			<h4><?=l("Opération Effectué !", "core");?></h4>
			<ul>
			<?php foreach ($success as $key => $value) : ?>
				<li><?=$value;?></li>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>


	<!-- Message -->
	<div class="alert alert-success" id="message" style="display:none;"></div>

	<div class="col-sm-2 padding0">
		<ul class="nav nav-pills nav-stacked">
			<li class="active"><a data-toggle="pill" href="#Product"><?=l("Informations de Produit", "core");?></a></li>
			<li><a data-toggle="pill" href="#Associated"><?=l("Produits associés", "core");?></a></li>
			<li><a data-toggle="pill" href="#Prices"><?=l("Prix et Règle de taxe", "core");?></a></li>
			<li><a data-toggle="pill" href="#Seo"><?=l("Référencement - SEO", "core");?></a></li>
			<li><a data-toggle="pill" href="#Associations"><?=l("Catégories et Associations", "core");?></a></li>
			<li><a data-toggle="pill" href="#Declinaisons"><?=l("Déclinaisons", "core");?></a></li>
			<li><a data-toggle="pill" href="#Quantites"><?=l("Quantités", "core");?></a></li>
			<li><a data-toggle="pill" href="#Images"><?=l("Images", "core");?></a></li>
			<li><a data-toggle="pill" href="#Characteristics"><?=l("Caractéristiques", "core");?></a></li>
			<li><a data-toggle="pill" href="#Attachments"><?=l("Documents joints", "core");?></a></li>
		</ul>
	</div>

	<div class="col-sm-10">
		<div class="tab-content">

			<div class="panel panel-default tab-pane fade in active" id="Product">
				<div class="panel-heading">
					<?=l("Informations de Produit", "core");?>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="alert alert-info">
							<b>*</b> <?=l("Vous ne pouvez pas avoir de déclinaisons avec un produit virtuel.", "core");?><br>
							<b>*</b> <?=l("Vous ne pouvez pas utiliser de déclinaisons dans un pack.", "core");?>
						</div>
						<label class="col-md-3 control-label" for="type"><?=l("Type", "core");?></label>  
						<div class="col-md-6">
							<div class="radio">
								<label for="simple">
									<input type="radio" name="product[type]" id="simple" value="0" checked="checked">
									<?=l("Produit standard", "core");?>
								</label>
							</div>
							<div class="radio">
								<label for="pack">
									<input type="radio" name="product[type]" id="pack" <?=(isset($infos['type']) && $infos['type'] === "1") ? 'checked="checked"' : '';?> value="1"> <?=l("Pack de produits existants", "core");?>
								</label>
							</div>
							<div class="radio">
								<label for="virtual">
									<input type="radio" name="product[type]" id="virtual" <?=(isset($infos['type']) && $infos['type'] === "2") ? 'checked="checked"' : '';?> value="2">
									<?=l("Produit dématérialisé (services, réservations, produits téléchargeables, etc.)", "core");?>
								</label>
							</div>
						</div>
					</div><hr>
					<div class="form-group">
						<label class="col-md-3 control-label" for="Name"><?=l("Nom", "core");?></label>  
						<div class="col-md-4">
							<input id="Name" name="product[name]" type="text" class="form-control" value="<?=(isset($infos['name'])) ? $infos['name'] : '';?>" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="reference"><?=l("Référence", "core");?></label>  
						<div class="col-md-5">
						<input id="reference" name="product[reference]" type="text" class="form-control" value="<?=(isset($infos['reference'])) ? $infos['reference'] : '';?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="reference"><?=l("Code-barres EAN-13 ou JAN", "core");?></label>  
						<div class="col-md-3">
						<input id="ean13" name="product[ean13]" type="text" class="form-control" value="<?=(isset($infos['ean13'])) ? $infos['ean13'] : '';?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="upc"><?=l("Code-barres UPC", "core");?></label>  
						<div class="col-md-3">
						<input id="upc" name="product[upc]" type="text" class="form-control" value="<?=(isset($infos['upc'])) ? $infos['upc'] : '';?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="upc"><?=l("État", "core");?></label>  
						<div class="col-md-3">
							<select name="product[product_condition]" class="form-control" id="condition">
								<option value="new" selected><?=l("Nouveau", "core");?></option>
								<option value="used" <?=(isset($infos['product_condition']) && $infos['product_condition'] == 'used') ? 'selected' : '';?>><?=l("Utilisé", "core");?></option>
								<option value="refurbished" <?=(isset($infos['product_condition']) && $infos['product_condition'] == 'refurbished') ? 'selected' : '';?>><?=l("Reconditionné", "core");?></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="cdate"><?=l("Date de création", "core");?></label>  
						<div class="col-sm-8">
							<div class="input-group col-sm-4">
							  <input type="text" value="<?=(isset($infos['cdate'])) ? $infos['cdate'] : '0000-00-00';?>" name="product[cdate]" class="form-control datepicker" id="cdate">
							  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label class="col-md-3 control-label" ><?=l("Status", "core");?></label>  
						<div class="col-md-3">
							<label for="enabled">
								<input type="radio" name="product[active]" value="1" id="enabled" checked> <?=l("Activé", "core");?>
							</label>
							<label for="disabled">
								<input type="radio" name="product[active]" value="0" <?=(isset($infos['active']) && $infos['active'] === "0") ? 'checked' : '';?> id="disabled"> <?=l("Désactivé", "core");?>
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="short_description"><?=l("Résumé", "core");?></label>
						<div class="col-md-8">                     
							<textarea class="form-control summernote" name="product[short_description]"><?=(isset($infos['short_description'])) ? $infos['short_description'] : '';?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="long_description"><?=l("Description", "core");?></label>
						<div class="col-md-8">      
							<textarea class="form-control summernote" name="product[long_description]"><?=(isset($infos['long_description'])) ? $infos['long_description'] : '';?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="tags"><?=l("Mots-clés (Tags)", "core");?></label>  
						<div class="col-md-6">
							<input value="<?= (isset($tag_list)) ? $tag_list : '';?>" id="tags" name="tags[]" type="text" class="form-control">
							<small><?=l("Chaque mot-clé doit être suivi d'une virgule. Les caractères suivants sont interdits : !<;>;?=+#\"°{}_$%.", "core");?></small>
						</div>
					</div>
				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
					<button type="submit" name="<?= (isset($id_product) && $id_product > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_product) && $id_product > 0) ? l("Mise à jour", "core") : l("Sauvegarder et rester", "core");?></button>
				</div><!--/ .panel-footer -->
			</div><!--/ .panel -->

			<div class="tab-pane fade" id="Associated">
				<?php if(isset($id_product) && $id_product > 0) : ?>
				<div class="panel panel-default">
					<div class="panel-heading"><?=l("Produits associés", "core");?></div>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-md-3 control-label" for="associated"><?=l("Produit associé", "core");?></label>  
							<div class="col-md-4">
								<select class="form-control" name="assoc[id_product]"><!-- chosen -->
									<option value="" selected><?=l("Sélectionnez un produit", "core");?></option>
									<?php foreach ($product_list as $key => $product) : ?>
			            	<option value="<?php echo $product['id'];?>">
			            		<?php echo $product['name'];?>
			            	</option>
			            <?php endforeach;?>
			          </select>
							</div>
							<div class="col-sm-1 left0">
								<button type="submit" name="associated" value="insert" class="btn btn-primary"><i class="fa fa-plus"></i> <?=l("Ajouter", "core");?></button>
							</div>
						</div>

						<div class="col-sm-5 col-sm-offset-3">
							<table class="table">
								<thead>
									<tr>
										<th style="width:20px;"><?=l("ID", "core");?></th>
										<th style="text-align:center;width:70px;"><?=l("Image", "core");?></th>
										<th><?=l("Nom de produit", "core");?></th>
										<th><?=l("Prix HT", "core");?></th>
										<th><?=l("Action", "core");?></th>
									</tr>
								</thead>
								<tbody>
									<?php if( !empty($associated_products) ) : ?>
				            <?php foreach ($associated_products as $key => $assoc) : ?>
				            <tr>
											<td>#<?php echo $assoc['id_product'] ?></td>
											<td>
						  				<?php 
						  					$file_name = $os_product->get_file_name( $os_product->get_product_image($assoc['id_product']) );
						  					$image_path = "../files/products/". $assoc['id_product'] ."/". $file_name;
						  					if( file_exists($image_path) ){
						  						echo "<img class='img-thumbnail' src='../files/products/". $assoc['id_product'] ."/". $file_name ."'>";
						  					}else{
						  						echo "<img class='img-thumbnail' src='assets/images/no-image45.png' width='45'>";
						  					}
						  				?></td>
											<td><?php echo $assoc['product_name'] ?></td>
											<td><?php echo $assoc['product_price'] ?></td>
											<td><button type="submit" name="assoc_delete" value="<?php echo $assoc['id'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
										</tr>
				            <?php endforeach; ?>
			            <?php endif; ?>
								</tbody>
							</table>
						</div>
					</div><!--/ .panel-body -->
					<div class="panel-footer">
						<button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
						<button type="submit" name="<?= (isset($id_product) && $id_product > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_product) && $id_product > 0) ? l("Mise à jour", "core") : l("Sauvegarder et rester", "core");?></button>
					</div><!--/ .panel-footer -->
				</div><!--/ .panel -->
				<?php else: ?>
				<div class="alert alert-info">
					<h4><?=l("Il y a 1 avertissement.", "core");?></h4>
					<?=l("Vous devez enregistrer ce produit avant d'y ajouter des caractéristiques.", "core");?>
				</div>
				<?php endif; ?>
			</div><!--/ .tab-pane -->

			<div class="panel panel-default tab-pane fade" id="Prices">
				<div class="panel-heading">
					<?=l("Ajouter des Prix", "core");?>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-3 control-label" for="buy_price"><?=l("Prix d'achat (unitaire)", "core");?></label>  
						<div class="col-md-6">
							<div class="input-group">
								<div class="input-group-addon"><?=l("Dhs", "core");?></div>
								<input id="buy_price" name="product[buy_price]" type="number" min="0" step="0.01" value="<?=(isset($infos['buy_price'])) ? $infos['buy_price'] : '';?>" placeholder="00.00" class="form-control">
								<div class="input-group-addon"><?=l("HT", "core");?></div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="sell_price"><?=l("Prix de vente (unitaire)", "core");?></label>  
						<div class="col-md-6">
							<div class="input-group">
								<div class="input-group-addon"><?php echo get_currency();?></div>
								<input id="sell_price" name="product[sell_price]" type="number" min="0" step="0.01" value="<?=(isset($infos['sell_price'])) ? $infos['sell_price'] : '';?>" placeholder="00.00" class="form-control">
								<div class="input-group-addon"><?=l("HT", "core");?></div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="wholesale_price"><?=l("Prix du lot", "core");?></label>  
						<div class="col-md-3 right0">
							<div class="input-group">
								<div class="input-group-addon"><?php echo get_currency();?></div>
								<input id="wholesale_price" name="product[wholesale_price]" type="number" min="0" step="0.01" value="<?=(isset($infos['wholesale_price'])) ? $infos['wholesale_price'] : '';?>" placeholder="00.00" class="form-control">
								<div class="input-group-addon"><?=l("HT", "core");?></div>
							</div>
						</div>
						<div class="col-md-3 left0">
							<div class="input-group">
								<div class="input-group-addon"><?=l("Par", "core");?></div>
								<input id="sell_price" name="product[wholesale_per_qty]" type="number" min="1" value="<?=(isset($infos['wholesale_per_qty'])) ? $infos['wholesale_per_qty'] : '';?>" placeholder="1" class="form-control">
								<div class="input-group-addon"><?=l("(Pièces)", "core");?></div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" for="loyalty_points"><?=l("Points de fidélité", "core");?></label>  
						<div class="col-sm-4">
							<div class="input-group">
								<input id="loyalty_points" name="product[loyalty_points]" type="number" min="0" step="1" class="form-control" required="" value="<?=(isset($infos['loyalty_points'])) ? $infos['loyalty_points'] : '';?>">
					      <span class="input-group-btn">
					        <select class="btn loyalty_state">
					          <option value="0"><?=l("Activer", "core");?></option>
					          <option value="1" <?=($infos['loyalty_points']=="0") ? 'selected' : '';?>><?=l("Désactiver", "core");?></option>
					        </select>
					      </span>
					    </div>
						</div>
					</div><hr>

					<div class="form-group">
						<label class="col-md-3 control-label" for="id_tax"><?=l("Règle de taxe", "core");?></label>  
						<div class="col-md-6">
							<select class="form-control" id="id_tax" name="product[id_tax]">
	            	<option value="0" selected><?=l("Aucune taxe", "core");?></option>
		            <?php if( !empty($taxes) ) : ?>
		            <?php foreach ($taxes as $key => $tax) : ?>
		              <option value="<?php echo $tax['id'] ?>" <?= ( isset($infos['id_tax']) && $infos['id_tax'] == $tax['id'] ) ? 'selected' : '';?> ><?php echo $tax['name']. ' '. $tax['rate'] .'%'; ?></option>
		            <?php endforeach; ?>
		            <?php endif; ?>
		          </select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="discount"><?=l("Remise", "core");?></label>  
						<div class="col-md-4">
							<div class="input-group">
								<input name="product[discount]" type="number" min="0" step="0.01" placeholder="0.00" value="<?= ( isset($infos['discount']) ) ? $infos['discount'] : '';?>" class="form-control" id="discount">
								<span class="input-group-addon" style="padding: 0px;border: 0px;">
									<select name="product[discount_type]" id="discount_type" class="form-control" style="width: 70px;">
										<option value="0" selected>%</option>
										<option value="1" <?= ( isset($infos['discount_type']) && $infos['discount_type'] == "1" ) ? 'selected' : '';?>>&#128;</option>
									</select>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="weight"><?=l("Colisage", "core");?></label>  
						<div class="col-md-4">
							<div class="input-group">
								<input name="product[packing_price]" type="number" min="0" step="0.01" placeholder="0.00" value="<?=(isset($infos['packing_price'])) ? $infos['packing_price'] : '';?>" class="form-control" id="packing_price">
								<span class="input-group-addon"><?php echo get_currency();?></span>
							</div>
						</div>
					</div><hr>
					<div class="form-group">
						<label class="col-md-3 control-label" for="weight"><?=l("Poids", "core");?></label>  
						<div class="col-md-4">
							<div class="input-group">
								<input name="product[weight]" type="number" min="0" step="0.01" placeholder="0.00" value="<?=(isset($infos['weight'])) ? $infos['weight'] : '';?>" class="form-control" id="weight">
								<span class="input-group-addon"><?=l("KG", "core");?></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="height"><?=l("Hauteur", "core");?></label>  
						<div class="col-md-4">
							<div class="input-group">
								<input name="product[height]" type="number" min="0" step="0.01" placeholder="0.00" value="<?=(isset($infos['height'])) ? $infos['height'] : '';?>" class="form-control" id="height">
								<span class="input-group-addon"><?=l("CM", "core");?></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="width"><?=l("Largeur", "core");?></label>  
						<div class="col-md-4">
							<div class="input-group">
								<input name="product[width]" type="number" min="0" step="0.01" placeholder="0.00" value="<?=(isset($infos['width'])) ? $infos['width'] : '';?>" class="form-control" id="width">
								<span class="input-group-addon"><?=l("CM", "core");?></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="depth"><?=l("Profondeur", "core");?></label>  
						<div class="col-md-4">
							<div class="input-group">
								<input name="product[depth]" type="number" min="0" step="0.01" placeholder="0.00" value="<?=(isset($infos['depth'])) ? $infos['depth'] : '';?>" class="form-control" id="depth">
								<span class="input-group-addon"><?=l("m", "core");?></span>
							</div>
						</div>
					</div>
				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
					<button type="submit" name="<?= (isset($id_product) && $id_product > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_product) && $id_product > 0) ? l("Mise à jour", "core") : l("Sauvegarder et rester", "core");?></button>
				</div><!--/ .panel-footer -->
			</div><!--/ .panel -->


			<div class="panel panel-default tab-pane fade" id="Seo">
				<div class="panel-heading"><?=l("RÉFÉRENCEMENT - SEO", "core");?></div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-3 control-label" for="meta_title"><?=l("Balise titre", "core");?></label>  
						<div class="col-md-6">
							<input id="meta_title" name="product[meta_title]" type="text" value="<?=(isset($infos['meta_title'])) ? stripslashes($infos['meta_title']) : '';?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="meta_description"><?=l("Meta description", "core");?></label>  
						<div class="col-md-6">
							<textarea rows="5" id="meta_description" name="product[meta_description]" class="form-control"><?=(isset($infos['meta_description'])) ? stripslashes($infos['meta_description']) : '';?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="link_rewrite"><?=l("URL simplifiée", "core");?></label>  
						<div class="col-md-6">
							<div class="input-group">
								<div class="input-group-addon"><?=$infos['id'];?></div>
								<input id="link_rewrite" name="product[link_rewrite]" type="text" value="<?=(isset($infos['permalink'])) ? $infos['permalink'] : '';?>" class="form-control">
							</div>
						</div>
					</div>
				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
					<button type="submit" name="<?= (isset($id_product) && $id_product > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_product) && $id_product > 0) ? l("Mise à jour", "core") : l("Sauvegarder et rester", "core");?></button>
				</div><!--/ .panel-footer -->
			</div><!--/ .panel -->

			<div class="panel panel-default tab-pane fade" id="Associations">
				<div class="panel-heading">
					<?=l("Associations", "core");?>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-md-3 control-label" for="sell_price"><?=l("Catégories associées", "core");?></label>  
						<div class="col-md-6">
							<div class="assoc_categories">
								<div class="panel panel-custom" style="border-bottom: 0px none;margin-bottom: 0px;">
									<div class="panel-heading">
										<a onclick="colapse_all(); return false;" class="btn btn-default"><i class="fa fa-minus-square"></i> <?=l("Réduire tout", "core");?></a>
										<a onclick="develope_all(); return false;" class="btn btn-default"><i class="fa fa-minus-square"></i> <?=l("Ouvrire tout", "core");?></a>
										<a onclick="checkAllCategories(); return false;" class="btn btn-default"><i class="fa fa-check-square"></i> <?=l("Tout cocher", "core");?></a>
										<a onclick="uncheckAllCategories(); return false;" class="btn btn-default"><i class="fa fa-square-o"></i> <?=l("Tout décocher", "core");?></a>
									</div>
									<div class="panel-body">
										<?php echo $os_product->getCategories(0,$cat_list);?>
									</div>
								</div><!--/ .panel -->
							</div>
						</div>
					</div>

					<div class="form-group">
					  <div class="col-lg-1">
					    <span class="pull-right"></span>
					  </div><label class="control-label col-lg-2" for="id_category_default"><?=l("Catégorie par défaut", "core");?></label>
					  <div class="col-lg-5">
					    <select class="form-control" id="id_category_default" name="product[id_category_default]">
					    	<?php if( !empty($product_categories) ) : ?>
						    	<?php foreach ($product_categories as $key => $category) : ?>
						      <option value="<?php echo $category['id']; ?>" <?=(isset($infos['id_category_default']) && $infos['id_category_default'] == $category['id'] ) ? 'selected' : '';?>><?php echo $category['name']; ?></option>
							    <?php endforeach; ?>
							  <?php endif; ?>
					    </select>
					  </div>
					</div>
				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
					<button type="submit" name="<?= (isset($id_product) && $id_product > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_product) && $id_product > 0) ? l("Mise à jour", "core") : l("Sauvegarder et rester", "core");?></button>
				</div><!--/ .panel-footer -->
			</div><!--/ .panel -->

			<div class="tab-pane fade" id="Declinaisons">
			<?php if(isset($id_product) && $id_product > 0) : ?>
				<div class="panel panel-default">
					<div class="panel-heading"><?=l("Ajouter ou modifier des déclinaisons de produit", "core");?></div>
					<div class="panel-body">
						<!--div class="alert alert-info">
							Vous pouvez également utiliser le <a href="javascript:;">Générateur de Déclinaisons de Produit</a> pour créer automatiquement un ensemble de déclinaisons.
						</div-->
						<div class="panel panel-default hidden" id="dec-form" style="border-bottom: 2px solid #ddd;">
							<div class="panel-heading">
								<button type="submit" name="<?= (isset($id_product) && $id_product > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?=l("Sauvegarder la déclinaison", "core");?></button>
								<?=l("Déclinaisons de produit", "core");?>
							</div>
							<div class="panel-body">
								<input type="hidden" name="declinaison[cu]" value="" id="cu">
								<input type="hidden" id="id_declinaison" name="id_declinaison" value="">

								<div class="form-group">
									<label class="col-md-3 control-label" for="attribute_group"><?=l("Attribut", "core");?></label>  
									<div class="col-md-3">
										<select class="form-control" id="attribute_group">
											<option value="">---</option>
											<?php foreach ($attributes as $key => $attribute) : ?>
												<option value="<?=$attribute['id'];?>"><?=$attribute['name'];?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="values_group"><?=l("Valeur", "core");?></label>  
									<div class="col-md-6">
										<select class="form-control" id="values_group" disabled></select>
									</div>
									<div class="col-md-3">
										<a type="button" class="btn btn-default btn-block" onclick="add_attr();"><i class="fa fa-plus-square"></i> <?=l("Ajouter", "core");?></a>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-6 col-md-offset-3">
										<select id="combinations" style="padding: 5px;" multiple="multiple"></select>
										<input type="hidden" name="combinations" value='<?=$json_combinations;?>' id="json_combinations">
									</div>
									<div class="col-md-3">
										<a type="button" class="btn btn-default btn-block add_attr" onclick="del_attr();"><i class="fa fa-minus-square"></i> <?=l("Supprimer", "core");?></a>
									</div>
								</div>
								<hr>
								<div class="form-group">
									<label class="col-md-3 control-label" for="attr_reference"><?=l("Référence", "core");?></label>  
									<div class="col-md-5">
									 <input id="attr_reference" name="declinaison[reference]" type="text" class="form-control" value="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="attr_ean13"><?=l("Code-barres EAN-13 ou JAN", "core");?></label>  
									<div class="col-md-3">
										<input id="attr_ean13" name="declinaison[ean13]" type="text" class="form-control" value="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="attr_upc"><?=l("Code-barres UPC", "core");?></label>  
									<div class="col-md-3">
										<input id="attr_upc" name="declinaison[upc]" type="text" class="form-control" value="">
									</div>
								</div>
								<hr>
								<!--div class="form-group">
									<label class="col-md-3 control-label" for="sell_price"><?//=l("Prix de vente HT", "core");?></label>  
									<div class="col-md-3">
										<input id="attr_sell_price" name="declinaison[sell_price]" type="number" min="0" class="form-control" value="">
									</div>
								</div-->
								<!--div class="form-group">
									<label class="col-md-3 control-label" for="price_impact"><?//=l("Impact sur le prix", "core");?></label>  
									<div class="col-md-3">
										<select class="form-control" name="declinaison[price_impact]" id="price_impact" onchange="displayOrHide(this,'attribute_price')">
											<option value="0"><?//=l("Aucun", "core");?></option>
											<option value="1"><?//=l("Augmentation", "core");?></option>
											<option value="2"><?//=l("Diminution", "core");?></option>
										</select>
									</div>
									<div class="input-group col-md-3 hidden" id="attribute_price">
										<span class="input-group-addon"><?//=l("TTC", "core");?></span>
										<input class="form-control" type="number" min="0" name="declinaison[price]" value="" placeholder="0.00">
									</div>
								</div-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="weight_impact"><?=l("Impact sur le poids", "core");?></label>  
									<div class="col-md-3">
										<select class="form-control" name="declinaison[weight_impact]" id="weight_impact" onchange="displayOrHide(this,'attribute_weight')">
											<option value="0"><?=l("Aucun", "core");?></option>
											<option value="1"><?=l("Augmentation", "core");?></option>
											<option value="2"><?=l("Diminution", "core");?></option>
										</select>
									</div>
									<div class="input-group col-md-3 hidden" id="attribute_weight">
										<span class="input-group-addon" style="width: 53px;"><?=l("KG", "core");?></span>
										<input class="form-control" type="number" min="0" name="declinaison[weight]" value="" placeholder="0.00">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="unit_impact"><?=l("Impact sur le prix unitaire", "core");?></label>  
									<div class="col-md-3">
										<select class="form-control" name="declinaison[unit_impact]" id="unit_impact" onchange="displayOrHide(this,'attribute_unity')">
											<option value="0"><?=l("Aucun", "core");?></option>
											<option value="1"><?=l("Augmentation", "core");?></option>
											<option value="2"><?=l("Diminution", "core");?></option>
										</select>
									</div>
									<div class="input-group col-md-3 hidden" id="attribute_unity">
										<span class="input-group-addon" style="width: 53px;"><?php echo get_currency();?></span>
										<input class="form-control" type="number" min="0" name="declinaison[unity]" value="" placeholder="0.00">
									</div>
								</div><hr>
								<!--div class="form-group">
									<label class="col-md-3 control-label" for="quantity"><?//=l("Quantité En Stock", "core");?></label>  
									<div class="col-md-3">
										<input maxlength="6" name="declinaison[quantity]" class="form-control" id="quantity" type="number" min="0" value="" placeholder="1">
									</div>
								</div-->
								<div class="form-group">
									<label class="col-md-3 control-label" for="min_quantity"><?=l("Quantité minimale", "core");?></label>  
									<div class="col-md-3">
										<input maxlength="6" name="declinaison[min_quantity]" class="form-control" id="min_quantity" type="number" min="1" value="" placeholder="1">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label" for="available_date"><?=l("Date de disponibilité", "core");?></label>  
									<div class="col-md-3">
										<div class="input-group">
											<input class="datepicker form-control" id="available_date" name="declinaison[available_date]" value="" placeholder="0000-00-00" type="text">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>

								<?php if(isset($images) && !empty($images)) : ?>
								<div class="form-group">
									<label class="control-label col-lg-3" for="attribute_default"><?=l("Image", "core");?></label>
									<div class="col-lg-9">
										<ul class="list-inline" id="dec_images">
											<?php foreach ($images as $key => $image) : ?>
											<?php
												$ext      = pathinfo($image['name'], PATHINFO_EXTENSION);
												$title    = explode('.'.$ext, $image['name']);
												$uploadDir = '../files/products/'.$id_product.'/';
												$img_src 	= $uploadDir.$title[0].'-80x80.'.$ext;
											?>
											<li id="<?=$image['id'];?>">
												<label for="<?=$image['id'];?>">
													<img src="<?=$img_src;?>" class="img-thumbnail" id="<?=$image['id'];?>">
												</label>
												<div class="text-center">
													<span class="btn btn-default">
														<input type="checkbox" value="<?=$image['name'];?>" name="declinaison[images][]">
													</span>
												</div>
											</li>
											<?php endforeach; ?>
										</ul>
									</div>
								</div>
								<?php endif; ?>

								<div class="form-group">
									<label class="control-label col-lg-3"><?=l("Par défaut", "core");?></label>
									<div class="col-lg-9">
										<p class="checkbox">
										<label for="default_dec">
											<input type="checkbox" name="declinaison[default_dec]" id="default_dec" value="1">
											<?=l("Faire de cette déclinaison celle par défaut pour ce produit.", "core");?>
										</label>
										</p>
									</div>
								</div>

							</div><!--/ .panel-body -->
							<div class="panel-footer">
								<a href="javascript:;" type="reset" id="edit-reset" class="btn btn-default edit-reset"> <i class="fa fa-undo"></i> <?=l("Fermer la modification", "core");?></a>
								<span class="pull-right">
									<a href="javascript:;" class="btn btn-danger btn-sm add_new_dec"><?=l("Nouvelle déclinaison", "core");?></a>
									<button type="submit" name="<?= (isset($id_product) && $id_product > 0) ? 'update' : 'save';?>" class="btn btn-primary btn-sm"><?=l("Sauvegarder la déclinaison", "core");?></button>
								</span>
								</div>
						</div><!--/ .panel -->

						<div class="table-responsive">
							<table class="table" id="dec-table">
								<thead>
									<tr class="nodrag nodrop">
										<th><?=l("Paire attribut - valeur", "core");?></th>
										<th><?=l("Impact sur le prix", "core");?></th>
										<th><?=l("Impact sur le poids", "core");?></th>
										<th><?=l("Référence", "core");?></th>
										<th><?=l("EAN-13", "core");?></th>
										<th><?=l("UPC", "core");?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if(!empty($product_declinaisons)) : ?>
										<?php foreach ($product_declinaisons as $key => $value) : ?>
										<tr <?=($value['default_dec'] == '1') ? 'class="bg-info"' : '';?> id="<?=$value['id'];?>">
											<td><?php 
												$data_comb = $os_product->getCombinations($id_product, $value['id']);
												if(!empty($data_comb)){
												  $attr_string = '';
												  foreach ($data_comb as $key => $comb) {
												    $attr_string .= $comb['attr_name'].' - '.$comb['value_name'].', ';
												  }
												  echo substr($attr_string, 0, -2);
												}
											?></td>
											<td><?=$value['price_impact'];?></td>
											<td><?=$value['weight_impact'];?></td>
											<td><?=$value['reference'];?></td>
											<td><?=$value['ean13'];?></td>
											<td><?=$value['upc'];?></td>
											<td>
												<div class="dropdown">
													<a href="javascript:;" data-id="<?=$value['id'];?>"  class="btn btn-info edit_dec"><i class="fa fa-edit"></i> <?=l("Modifier", "core");?></a>
													<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button"><span class="caret">&nbsp;</span></button>
													<ul class="dropdown-menu">
														<li><a href="javascript:;" data-id="<?=$value['id'];?>" class="delete-declinaison"><?=l("Supprimer", "core");?></a></li>
													</ul>
												</div>
											</td>
										</tr>	
										<?php endforeach; ?>
									<?php else : ?>
									<tr>
										<td colspan="6"><center><i class="fa fa-warning fa-4x"></i><br> <?=l("Aucun enregistrement trouvé", "core");?></center></td>
									</tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>

						<div class="alert alert-info">
							<?=l("La ligne en bleu est la déclinaison par défaut.", "core");?><br>
							<?=l("Un produit qui possède des déclinaisons doit avoir une déclinaison par défaut.", "core");?>
							</ul>
						</div>
					</div><!--/ .panel-body -->
					<div class="panel-footer">
						<button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Terminer", "core");?></button>
						<span class="pull-right">
							<a href="javascript:;" class="btn btn-success add_dec"><?=l("Nouvelle déclinaison", "core");?></a>
							<button type="submit" name="<?= (isset($id_product) && $id_product > 0) ? 'update' : 'save';?>" class="btn btn-primary"><?= (isset($id_product) && $id_product > 0) ? l("Mise à jour", "core") : l("Sauvegarder et rester", "core");?></button>
						</span>
						</div><!--/ .panel-footer -->
				</div><!--/ .panel -->
				<?php else: ?>
				<div class="alert alert-info">
					<h4><?=l("Il y a 1 avertissement.", "core");?></h4>
					<?=l("Vous devez enregistrer ce produit avant d'y ajouter des déclinaisons.", "core");?>
				</div>
				<?php endif; ?>
			</div><!--/ .tab-pane -->

			<div class="tab-pane fade" id="Quantites">
			<?php if(isset($id_product) && $id_product > 0) : ?>
				<div class="panel panel-default">
					<div class="panel-heading"><?=l("QUANTITÉS DISPONIBLES À LA VENTE", "core");?></div>
					<div class="panel-body">
						<div class="alert alert-info">
							<?=l("Cette interface vous permet de gérer les quantités disponibles à la vente pour ce produit. Elle vous permet également de gérer les déclinaisons produit dans la boutique en cours.", "core");?><br>
							<?=l("Notez que si un produit du pack a plusieurs déclinaisons, c'est sa déclinaison par défaut qui sera utilisée pour les mouvements de stocks.", "core");?>
						</div>
						<input type="hidden" id="json_quantities" name="quantities" value="">
						<div class="form-group">
						  <div class="col-lg-9 col-lg-offset-3">
						    <table class="table" id="quantities">
					      	<thead>
						        <tr>
						          <th width="100"><?=l("Quantité", "core");?></th>
						          <th width="150"><?=l("Quantité minimale", "core");?></th>
						          <th><?=l("Nom de produit", "core");?></th>
						        </tr>
						      </thead>
						      <tbody>
					      	<tr class="bg-gray">
					          <td><input type="number" min="0" name="product[qty]" placeholder="0" value="<?=(isset($infos['qty'])) ? $infos['qty'] : '0';?>" class="form-control" id="product_quantity" style="width: 95px;" <?=(!empty($product_declinaisons)) ? "" : "";?>></td>
					          <td><input type="number" min="1" name="product[min_quantity]" placeholder="1" value="<?=(isset($infos['min_quantity'])) ? $infos['min_quantity'] : '1';?>" class="form-control" style="width: 95px;"></td>
					          <td><?=(isset($infos['name'])) ? $infos['name'] : '';?> </td>
					        </tr>
					        <?php if(!empty($product_declinaisons)) :?>
					        	<?php foreach ($product_declinaisons as $key => $value) : ?>
					        	<tr id="<?=$value['id'];?>">
						          <td><input width="95" type="number" min="0" placeholder="0" value="<?=intval($value['quantity']);?>" onchange="genQuantities();" class="form-control attr_qty" style="width: 95px;"></td>
						          <td></td>
						          <td><?php 
												$data_comb = $os_product->getCombinations($id_product, $value['id']);
												if(!empty($data_comb)){
												  $attr_string = '';
												  foreach ($data_comb as $key => $comb) {
												    $attr_string .= $comb['attr_name'].' - '.$comb['value_name'].', ';
												  }
												  echo substr($attr_string, 0, -2);
												}
											?></td>
						        </tr>
					        <?php endforeach;?>
					        <?php endif;?>
					        </tbody>
					    		</table>
						  </div>
						</div>
					</div><!--/ .panel-body -->
					<div class="panel-footer">
						<button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
						<button type="submit" name="<?= (isset($id_product) && $id_product > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_product) && $id_product > 0) ? l("Mise à jour", "core") : l("Sauvegarder et rester", "core");?></button>
					</div><!--/ .panel-footer -->
				</div><!--/ .panel -->
				<?php else: ?>
				<div class="alert alert-info">
					<h4><?=l("Il y a 1 avertissement.", "core");?></h4>
					<?=l("Vous devez enregistrer ce produit avant d'y ajouter des quantités.", "core");?>
				</div>
			<?php endif; ?>
			</div><!--/ .tab-pane -->

			<div class="tab-pane fade" id="Images">
			<?php if(isset($id_product) && $id_product > 0) : ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<?=l("Images", "core");?>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-md-3 control-label" for="filer_input"><?=l("Ajouter une nouvelle image à ce produit", "core");?></label>  
							<div class="col-md-6">
								<div class="input-group">
									<input type="file" name="files[]" id="filer_input" multiple="multiple">	
								</div>
							</div>
						</div>
						<?php if(isset($images) && !empty($images)) : ?>
						<div class="panel-subheading">
							<i class="fa fa-picture-o"></i>
							<strong><?=l("Sélectionnez l'image en vedette.", "core");?></strong>
						</div>
						<div class="col-sm-12">
							<input type="hidden" value="<?=$image['name'];?>" name="image_name" id="image_name">
							<ul class="list-inline" id="images">
								<?php foreach ($images as $key => $image) : ?>
								<?php
									$ext      = pathinfo($image['name'], PATHINFO_EXTENSION);
									$title    = explode('.'.$ext, $image['name']);
									$uploadDir = '../files/products/'.$id_product.'/';
									$img_src 	= $uploadDir.$title[0].'-80x80.'.$ext;
								?>
								<li class="<?=$image['id'];?>">
									<label for="<?=$image['id'];?>">
										<img src="<?=$img_src;?>" class="img-thumbnail" id="<?=$image['id'];?>">
									</label>
									<div class="text-center">
										<span class="btn btn-default">
											<input type="radio" class="id_image" data-name="<?=$image['name'];?>" value="<?=$image['id'];?>" <?=($image['futured'] == '1') ? 'checked="checked"' : '';?> name="id_image">
										</span>
										<a data-name="<?= $image['name'];?>" id="<?= $image['id'];?>" class="btn btn-danger delete_img" href="javascript:;"><i class="fa fa-trash"></i></a>
									</div>
								</li>
								<?php endforeach; ?>
							</ul>
						</div>
						<?php endif; ?>
					</div><!--/ .panel-body -->
					<div class="panel-footer">
						<button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
						<button type="submit" name="<?= (isset($id_product) && $id_product > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_product) && $id_product > 0) ? l("Mise à jour", "core") : l("Sauvegarder et rester", "core");?></button>
					</div><!--/ .panel-footer -->
				</div><!--/ .panel -->
				<?php else: ?>
				<div class="alert alert-info">
					<h4><?=l("Il y a 1 avertissement.", "core");?></h4>
					<?=l("Vous devez enregistrer ce produit avant d'y ajouter des images.", "core");?>
				</div>
				<?php endif; ?>
			</div><!--/ .tab-pane -->


			<div class="tab-pane fade" id="Characteristics">
			<?php 
			if(isset($id_product) && $id_product > 0) : ?>
				<div class="panel panel-default">
				<form class="form-horizontal" id="feature_form" method="post" action="ajax/products/feature_product/form.php">
					<div class="panel-heading">
						<?=l("Attribuer des caractéristiques à ce produit", "core");?>
					</div>
					<div class="panel-body">
						<div class="alert alert-info">
							<?=l("Vous pouvez préciser une valeur pour chaque caractéristique pertinente concernant ce produit ; les champs vides ne seront pas affichés.", "core");?><br>
							<?=l("Vous pouvez définir une valeur spécifique, ou choisir parmi les valeurs existantes prédéfinies que vous avez ajoutées précédemment.", "core");?>
						</div>


							<!-- Atributes Json -->
							<input type="hidden" name="features" value='<?=$json_attributes;?>' id="json_attributes">
							<input type="hidden" name="feature_ids" value="" id="attr_ids">

							<?php
							$f = new OS_Features();
							$features = $f->get_features($id_lang);
							?>

							<div class="table-responsive">
							<table class="table" id="features">
								<thead>
									<tr>
										<th><?=l("Caractéristique", "core");?></span></th>
										<th><?=l("Valeur prédéfinie", "core");?></span></th>
										<th><u><?=l("OU", "core");?></u> <?=l("Valeur personnalisée", "core");?></th>
										<th style="width: 60px;"><?=l("Actions", "core");?></th>
									</tr>
								</thead>
								<tbody>
								<?php if( !empty($features) ) : ?>
									<?php foreach ($features as $key => $feature) : ?>
										<tr>
											<td id="<?=$feature['id'];?>"><?=$feature['name'];?></td>
											<td>
												<?php
												$values = $f->get_feature_values($feature['id'], $id_lang);
												$f_product = $f->get_feature_product($feature['id'], $id_product);
												$id_value = $f_product[0]['id_feature_value'];
												$custom = $f_product[0]['custom'];
												if(!empty($values)) : ?>
												<select onchange="gen_attributes_json();" class="form-control">
													<option value="">---</option>
													<?php 
													foreach ($values as $key => $value)
													{	
														$selected = (isset($id_value) && $id_value==$value['id_value'] ) ? 'selected' : '';
														echo '<option value="'. $value['id_value'] .'" '. $selected .'>'. $value['value'] .'</option>';
													}
													?>
												</select>
												<?php else : ?>
													<?=l("N/D", "core");?> - <a target="_blank" href="?module=feature_values&amp;action=add"><i class="fa fa-plus-square"></i> <?=l("Ajouter une valeur prédéfinie dans un premier temps", "core");?></a> 	
												<?php endif; ?>
											</td>
											<td><input onchange="gen_attributes_json();" type="text" value="<?=(isset($custom) && $custom != '') ? $custom : '';?>" class="form-control"></td>
											<td><a href="javascript:;" class="btn btn-danger clear"><i class="fa fa-trash"></i></a></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
								</tbody>
							</table>
						</div>
					

					</div><!--/ .panel-body -->
					<div class="panel-footer">
						<button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
						<button type="submit" name="<?= (isset($id_product) && $id_product > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_product) && $id_product > 0) ? l("Mise à jour", "core") : l("Sauvegarder et rester", "core");?></button>
					</div><!--/ .panel-footer -->
				</form>
				</div><!--/ .panel -->
				<?php else: ?>
				<div class="alert alert-info">
					<h4><?=l("Il y a 1 avertissement.", "core");?></h4>
					<?=l("Vous devez enregistrer ce produit avant d'y ajouter des caractéristiques.", "core");?>
				</div>
				<?php endif; ?>
			</div><!--/ .tab-pane -->


			<div class="tab-pane fade" id="Attachments">
				<?php if(isset($id_product) && $id_product > 0) : ?>
				<div class="panel panel-default">
					<div class="panel-heading"><?=l("Documents joints", "core");?></div>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-md-3 control-label" for="attachment_name"><?=l("Nom du fichier *", "core");?></label>  
							<div class="col-md-6">
								<input type="text" name="attachment[name]" id="attachment_name" value="" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="description"><?=l("Description", "core");?></label>  
							<div class="col-md-6">
								<textarea rowspan="5" id="description" name="attachment[description]" class="form-control"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="attachments"><?=l("Fichier", "core");?></label>  
							<div class="col-md-6">
								<input type="file" name="attachment" id="attachments" required>	
								<small><?=l("Mettre un fichier en ligne depuis votre poste de travail", "core");?> (<?=_MAX_SIZE_;?> <?=l("max.", "core");?>)</small>
								<small><?=l("Formats autorisés :", "core");?> .jpg, .gif, .png, .doc, .ppt, .odt, .docx, .xlsx, .pptx, .psd , .rar, .zip</small>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2 col-sm-offset-3">
								<button type="submit" name="<?= (isset($id_product) && $id_product > 0) ? 'update' : 'save';?>" class="btn btn-success"><i class="fa fa-send-o"></i> <?=l("Envoyer", "core");?></button>
							</div>
						</div>
						<div class="panel-subheading">
							<i class="fa fa-file"></i>
							<strong><?=l("Liste des fichiers attachés", "core");?></strong>
						</div>
						<div class="table-responsive">
							<table class="table" id="attachments">
								<thead>
									<tr class="nodrag nodrop">
										<th><?=l("Nom du fichier", "core");?></th>
										<th><?=l("Description", "core");?></th>
										<th width="105"><?=l("Actions", "core");?></th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if(!empty($product_attachments)) : ?>
										<?php foreach ($product_attachments as $key => $value) : ?>
										<tr id="<?=$value['id'];?>">
											<td><?=$value['name'];?></td>
											<td><?=$value['description'];?></td>
											<td><a href="javascript:;" id="<?=$value['id'];?>" data-attachment="<?=$value['attachment'];?>" class="btn btn-default delete_att"><?=l("Supprimer", "core");?></a></td>
										</tr>	
										<?php endforeach; ?>
									<?php else : ?>
									<tr>
										<td colspan="6"><center><i class="fa fa-warning fa-4x"></i><br> <?=l("Aucun attachment trouvé", "core");?></center></td>
									</tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div><!--/ .panel-body -->
					<div class="panel-footer">
						<button type="button" class="btn btn-default" onclick="window.location='?module=products';"><?=l("Fermer", "core");?></button>
						<button type="submit" name="<?= (isset($id_product) && $id_product > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_product) && $id_product > 0) ? l("Mise à jour", "core") : l("Sauvegarder et rester", "core");?></button>
					</div><!--/ .panel-footer -->
				</div><!--/ .panel -->
				<?php else: ?>
				<div class="alert alert-info">
					<h4><?=l("Il y a 1 avertissement.", "core");?></h4>
					<?=l("Vous devez enregistrer ce produit avant d'y ajouter des caractéristiques.", "core");?>
				</div>
				<?php endif; ?>
			</div><!--/ .tab-pane -->

		</div><!--/ .tab-content -->
	</div><!--/ .col-sm-6 -->	
</form>


<script>
$(document).ready(function(){

	//manufactures form
  // $("form#feature_form").submit(function(event){
  //   event.preventDefault();
  //   submit_ajax_form("feature_form", function(data) {
  //     if( data.msg ) os_message_notif( data.msg );
  //     if( data.id_feature ){
  //       //window.location = '?module=feature_values&id_feature='+data.id_feature;
  //     }
  //   });
  //   return false;
  // });

	$('.id_image').on('change', function(){
		var name = $(this).data("name");
		$("#image_name").empty().val(name);
	});


	$('.attr_qty').on('change', function(){
		var product_quantity = 0;
		$(".attr_qty").each(function() {
			product_quantity += parseInt( $(this).val() );
		});
		$('#product_quantity').empty().val(product_quantity);
	});


	//get_loyalty_points
	/*var price = $('#sell_price').val();//parseFloat($('#sell_price').val().replace(",", "."));
	//console.log(typeof price)
	//if($('#loyalty_points') != "0"){
	if(parseInt( $('#loyalty_points').val() ) == 0){
		get_loyalty_points(price);
	}*/
	//on change refresh points
	$('#sell_price').on('change', function(){
		var price = $(this).val();
		get_loyalty_points(price);
	});
	//loyalty_state
	//loyalty_state
  var loyalty_points = $('#loyalty_points').val();
  if(loyalty_points == "0"){
  	$('#loyalty_points').prop('disabled', true);
  	$('.loyalty_state option[value=1]').prop('selected', true);
  	$('.loyalty_state').css('border', '1px solid #F05050');
  	$('#loyalty_value').val('0');
  }else{
  	$('#loyalty_points').prop('disabled', false);
  	$('.loyalty_state').css('border', '1px solid #3E9E28');
  }
  $('.loyalty_state').on('change', function(){
  	if( $(this).val() === "1" ){
  		$('#loyalty_points').prop('disabled', true);
  		$('#loyalty_points').val('0');
  		$('.loyalty_state').css('border', '1px solid #F05050');
  		$('#loyalty_value').val('0');
  	}else{
  		$('#loyalty_points').prop('disabled', false);
  		$('.loyalty_state').css('border', '1px solid #3E9E28');
  	}
  });
	

	//collapse categories
	colapse_all();
	//remove menus link for categories dont have sub cat
	$('.assoc_categories li').each(function(){
		if( $(this).next().attr('id') != "categories" ){
			$(this).find('a').remove();
		}else{
			$(this).find('i').removeClass('fa-minus-square').addClass('fa-plus-square');
		}
	}); 


	//jQuery Filer
  $('#attachments').filer({
    maxSize: <?=intval(_MAX_SIZE_);?>,
    extensions: ['jpg', 'gif', 'png', 'pdf', 'doc', 'ppt', 'odt', 'docx', 'xlsx', 'pptx', 'psd', 'rar', 'zip']
  });

  $('.datepicker').datepicker({
    format: 'yyyy/mm/dd',
    startDate: '2010-01-01',
    endDate: '2020-01-01'
  });

	// Javascript to enable link to tab
	var hash = document.location.hash;
	var prefix = "tab_";
	if (hash) {
		$('.nav-pills a[href='+hash.replace(prefix,"")+']').tab('show');
	} 
	//console.log(hash)

	// Change hash for page-reload
	$('.nav-pills a').on('shown.bs.tab', function (e) {
		window.location.hash = e.target.hash.replace("#", "#");// + prefix
	});

	//Product Type
	hideTab();
	$("input[name=product_type]:radio").change(function () {
		hideTab();
	});

	//Clear attribute
	$('.clear').on("click", function() {
		//Clear input and select
		var tr = $(this).parent().parent();
		tr.find('td:nth-child(2) select option:selected').removeAttr('selected');
		tr.find('td:nth-child(3) input').val('');
		//call Gen Attributes Json function
		gen_attributes_json();

	});

	//remove image row
	$('.delete_img').each(function(){
		$(this).click(function() {
			var choice = confirm("<?=l('Cette action supprime définitivement l\'image sur votre serveur. Êtes-vous vraiment sûr ?', 'admin');?>");
			if (choice == false) return;
			var id = $(this).attr('id');
			var name = $(this).attr('data-name');
			var id_product = $('#id_product').val();
			$.ajax({
				type: "POST",
				url: 'ajax/products/delete-image.php',
				data: {id_img:id,image:name,id_product:id_product},
				success: function(data){
					$('ul#images li.'+id).remove();
					$('#message').empty().show(0).append(data).delay(2000).hide(0);
				}
			});
		});
	});

	//remove image row
	$('.delete_att').on('click', function(){
		var choice = confirm("<?=l('Cette action supprime définitivement le fichier sur votre serveur. Êtes-vous vraiment sûr ?', 'admin');?>");
		if (choice == false) return;
		var id = $(this).attr('id');
		var att = $(this).attr('data-attachment');
		var id_product = $('#id_product').val();
		$.ajax({
			type: "POST",
			url: 'ajax/products/delete-attachment.php',
			data: {id:id,att,att,id_product:id_product},
			success: function(data){
				$('table#attachments').find('tr#'+id).remove();
				$('#message').empty().show(0).append(data).delay(2000).hide(0);
			}
		});
	});

	//Attribute Group Population
	$('#attribute_group').change(function() {
		var id = $(this).val(); //get the current value's option
		$.ajax({
			type:'POST',
			url:'ajax/products/attribute-values.php',
			data:{'id':id},
			success:function(data){
				$("#values_group").html(data);
				if($('#values_group option').length == 0) {
					$('#values_group').prop('disabled', true);
					//$('.add_attr').addClass('disabled');
				}else{
					$('#values_group').prop('disabled',false);
				}
			}
		});
	});

	//Edit Declinaison
	$('.edit_dec').on('click', function() {
		var id = $(this).attr('data-id');
		$.ajax({
			type:'POST',
			url:'ajax/products/edit-declinaison.php',
			data:{'id':id},
			success:function(data){
				var data = $.parseJSON(data);
				//console.log(data)

				//Fill combinations
				$('#combinations').html(data['combinations']);
				$('#json_combinations').val(data['comb_json']);
				//Fill déclinaison
				$('#id_declinaison').val(id);
				$('#cu').val(data['dec_data']['cu']);
				if(data['dec_data']['default_dec'] == "1"){
					$("#default_dec").prop("checked", true);
				}
				$('#attr_reference').val(data['dec_data']['reference']);
				$('#attr_ean13').val(data['dec_data']['ean13']);
				$('#attr_upc').val(data['dec_data']['upc']);
				$('#attr_sell_price').val(data['dec_data']['sell_price']);
				$("#price_impact option[value='"+data['dec_data']['price_impact']+"']").prop("selected", true);
				if(data['dec_data']['price_impact'] != "0"){
					$('#attribute_price').removeClass('hidden');
					$('#attribute_price input').val(data['dec_data']['price']);
				}
				$("#weight_impact option[value='"+data['dec_data']['weight_impact']+"']").prop("selected", true);
				if(data['dec_data']['weight_impact'] != "0"){
					$('#attribute_weight').removeClass('hidden');
					$('#attribute_weight input').val(data['dec_data']['weight']);
				}
				$("#unit_impact option[value='"+data['dec_data']['unit_impact']+"']").prop("selected", true);
				if(data['dec_data']['unit_impact'] != "0"){
					$('#attribute_unity').removeClass('hidden');
					$('#attribute_unity input').val(data['dec_data']['unity']);
				}

				//check active images
				//console.log(typeof data['dec_data']['images'])
				//var images_array = "["+ data['dec_data']['images'] +"]";
				$("#dec_images input:checkbox").prop("checked", false);


				try {
					//var images_array = $( data['dec_data']['images'] ).split(',');;
					var obj = $.parseJSON(data['dec_data']['images']);
					$.each(obj, function(key,value) {
						$("#dec_images input:checkbox[value='"+ value +"']").prop("checked", true);
					});
				}catch (e) {

				}
				// if( data['dec_data']['images'] != "" ){
				// }



				$('#quantity').val(data['dec_data']['quantity']);
				$('#min_quantity').val(data['dec_data']['min_quantity']);
				$('#available_date').val(data['dec_data']['available_date']);
				//Display the panel
				$('#dec-form').removeClass('hidden');
			}
		});
	});
	
	//Delete declinaison row
	$('.delete-declinaison').each(function(){
		$(this).click(function() {
			var choice = confirm("<?=l('Cette action supprime définitivement la declinaison. Êtes-vous vraiment sûr ?', 'admin');?>");
			if (choice == false) return;
			var id = $(this).attr('data-id');
			$.ajax({
				type: "POST",
				url: 'ajax/products/delete-declinaison.php',
				data: {id:id},
				success: function(data){
					$('table#dec-table tr#'+id).remove();
					$('#message').empty().show(0).append(data).delay(2000).hide(0);
				}
			});
		});
	});

	//ADD NEW DECLINATION
	$('.add_dec').on('click', function(){
		resetDec();
		$('#dec-form').removeClass('hidden');
	});

	//EDIT RESET
	$('#edit-reset').on('click', function(){
		var choice = confirm("<?=l('Cette action Fermer la declinaison. Êtes-vous vraiment sûr ?', 'admin');?>");
		if (choice == false) return;
		resetDec();
		$('#dec-form').addClass('hidden');
	});

	//EDIT RESET
	$('.add_new_dec').on('click', function(){
		var choice = confirm("<?=l('Cette action Fermer la declinaison. Êtes-vous vraiment sûr ?', 'admin');?>");
		if (choice == false) return;
		resetDec();
		$('#dec-form').removeClass('hidden');
	});

	//categories collapse
	$('.cat_collapse').on("click", function() {
		var li = $(this).closest('li');
		var ul = li.next("ul");
		if(ul.hasClass('hidden')){
			ul.removeClass('hidden');
			li.find('a').removeClass('plus').addClass('minus');
			li.find('i').removeClass('fa-plus-square').addClass('fa-minus-square');
		}else{
			ul.addClass('hidden');
			li.find('a').removeClass('minus').addClass('plus');
			li.find('i').removeClass('fa-minus-square').addClass('fa-plus-square');
		}
	});
	
});//END DOCUMENT READY

//Gen Quantities
function genQuantities(){
	var json = '';
	$("table#quantities tbody tr:not(.bg-gray)").each(function(){
		var id = $(this).attr('id');
		var quantity = $(this).find('td:nth-child(1) input').val();
		if(quantity > '0'){qty=quantity}else{qty=0}
		json += ('{"'+id+'":"'+qty+'"},');
	});
	json = json.slice(0,-1);
	json = json.replace(json, '['+json+']');
	$('#json_quantities').empty().val(json);
}

function gen_attributes_json(){
	var json = {};
	var attr_ids = []; 
	$("table#features tbody tr").each(function(){
		//Attribute ID and Value
		var id_feature = $(this).find('td:nth-child(1)').attr('id');
		var id_product = $('#id_product').val();
		var id_feature_value = $(this).find('td:nth-child(2) select option:selected').val();
		//Run Tests
		if ($(this).find('td:nth-child(2) select').length > 0) {
			if(id_feature_value != ''){
				var custom = $(this).find('td:nth-child(2) select option:selected').text();
				json[id_feature] = {};
				json[id_feature]['id_product'] = id_product;
				json[id_feature]['id_feature'] = id_feature;
				json[id_feature]['id_feature_value'] = id_feature_value;
				json[id_feature]['custom'] = null;
				//attr_ids
				attr_ids.push(id_feature);
			}else{
				var custom_value = $(this).find('td:nth-child(3) input').val();
				if(custom_value != ''){
					json[id_feature] = {};
					json[id_feature]['id_product'] = id_product;
					json[id_feature]['id_feature'] = id_feature;
					json[id_feature]['id_feature_value'] = 0;
					json[id_feature]['custom'] = custom_value;
					//attr_ids
					attr_ids.push(id_feature);
				}	
			}
		}else{
			
			var custom_value = $(this).find('td:nth-child(3) input').val();
			if(custom_value != ''){
				json[id_feature] = {};
				json[id_feature]['id_product'] = id_product;
				json[id_feature]['id_feature'] = id_feature;
				json[id_feature]['id_feature_value'] = null;
				json[id_feature]['custom'] = custom_value;
				//attr_ids
				attr_ids.push(id_feature);
			}			
		}
	});
	//Serializing to JSON
	var json_attributes = JSON.stringify(json, null, 2);
	$('#json_attributes').empty().val(json_attributes);
	$('#attr_ids').empty().val(attr_ids);
}//END ATTRIBUTES JSON FUNCTION

//Check All Categories
function checkAllCategories(){
	$("#categories input:checkbox").prop("checked", true);
}

//uncheck All Categories
function uncheckAllCategories(){
	$("#categories input:checkbox").prop("checked", false);
}

//colapse_all
function colapse_all(){
	$('ul#categories').addClass('hidden');
	$('ul#categories').first().removeClass('hidden');
}
function develope_all(){
	$('ul#categories').removeClass('hidden');
}


//Hide Tabs
function hideTab(){
	$('.nav-pills a[href="#Declinaisons"]').parent('li').removeClass('hidden');
	if($("input[id='pack']:checked").length > 0 || $("input[id='virtual']:checked").length > 0){
		$('.nav-pills a[href="#Declinaisons"]').parent('li').addClass('hidden');
	}
}

//Add Attribute
function add_attr(){
	var id_attribut = $('#attribute_group option:selected').val();
	var attribut_name = $('#attribute_group option:selected').text();
	var id_value = $('#values_group option:selected').val();
	var value_name = $('#values_group option:selected').text();
	//check if exist
	var exist = $("#combinations option[groupid='"+id_attribut+"']").length;//[value='"+id_value+"']
	if(value_name == '---' || attribut_name == '---'){
		alert('Veuillez choisir une valeur.'); return;
	}
	if(exist === 0){
		var option = '<option value="'+id_value+'" groupid="'+id_attribut+'">'+attribut_name+'&nbsp;&nbsp; : '+value_name+'</option>';
		$('#combinations').append(option);
	}else{
		alert("<?=l('Vous ne pouvez ajouter qu\'une déclinaison par type d\'attribut.', 'admin');?>");
	}


	//Json Combinations
	var json = '{';
	var cu = '';
	var index = 0;
	$("#combinations option").each(function(index){
		json += ('"'+index+'": {"id_value":"'+$(this).val()+'","id_attribute":"'+$(this).attr('groupid')+'"},');
		cu += $(this).attr('groupid')+':'+$(this).val()+',';
		index++;
	});
	json = json.slice(0,-1);
	json += '}';
	$('#json_combinations').empty().val(json);
	cu = cu.slice(0,-1);
	$('#cu').empty().val(cu);

}

//Delete Attribute
function del_attr(){
	//$('#combinations option:selected').prop('selected', false);
	$('#combinations option:selected').remove();
	//Json Combinations
	var json = '';
	var cu = '';
	if($("#combinations option").length > 0){
		json = '{';
		var index = 0;
		$("#combinations option").each(function(index){
			json += ('"'+index+'": {"id_value":"'+$(this).val()+'","id_attribute":"'+$(this).attr('groupid')+'"},');
			cu += $(this).attr('groupid')+':'+$(this).val()+',';
			index++;
		});
		json = json.slice(0,-1);
		json += '}';
	}
	$('#json_combinations').empty().val(json);
	cu = cu.slice(0,-1);
	$('#cu').empty().val(cu);
}

//Display Hide
function displayOrHide(sel,id){
	if(sel.value != '0'){
		$('#'+id).removeClass('hidden');
	}else{
		$('#'+id).addClass('hidden');
	}

	$('#'+id).find('input').val('');	
}

function resetDec(){
	$("#combinations option").remove();
	$('#dec-form').find('input').val('');
	$('#dec-form').find('select option:selected').prop("selected", false);
	$('#attribute_price').addClass('hidden');
	$('#attribute_weight').addClass('hidden');
	$('#attribute_unity').addClass('hidden');
}

function get_loyalty_points(price){
	var points = price / 10;
	$('#loyalty_points').val( points | 0 );
}

</script>