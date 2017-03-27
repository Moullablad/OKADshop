<?php
function Add(){}
function EDIT($ID){}
function DELETE($ID){
	$common = new OS_Common();
	$common->delete('carrier_users_groups', "WHERE id_carrier=".$ID );
	$common->delete('carrier_zones', "WHERE id_carrier=".$ID );
	$id_carrier = $common->delete('carrier', "WHERE id=".$ID );
	echo '<script>window.location.href="?module=shipping"</script>';
}
//exit if delete action
if ( $_GET['action'] == "delete" ) return;


$common = new OS_Common();
$errors = $success = array();
$allowed_tags = allowed_tags();

/**
 *=============================================================
 * UPDATE MODE
 * This part well apply when you go to edit a carrier from list
 * EX: [WewSite]index.php?module=shipping&action=edit&id=[1]
 *=============================================================
 */
if( 
  isset($_GET['action']) && $_GET['action'] == 'edit'
  && isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0
){
  $exist = $common->select('carrier', array('id'), "WHERE id=". intval($_GET['id']) );
  if( $exist ){
    $id_carrier = intval($_GET['id']);
  }else{
  	echo '<script>window.location.href="?module=shipping"</script>';
  }
/*============================================================*/
} //END UPDATE MODE
/*============================================================*/


/**
 *=============================================================
 * PROCCESS POSTED DATA
 *=============================================================
 */
if ( 
	$_SERVER['REQUEST_METHOD'] == 'POST'
	&& $_POST['shipping']['name'] != "" 
	&& $_POST['shipping']['min_delay'] != "" 
	&& $_POST['shipping']['max_delay'] != "" 
){


	//carrier informations
  $carrier_data = array(
    'id_tax' 						=> intval($_POST['shipping']['id_tax']),
		'name' 							=> addslashes($_POST['shipping']['name']),
		'type' 							=> $_POST['shipping']['type'],
		'description'				=> strip_tags($_POST['shipping']['description'], $allowed_tags),
		'min_delay' 				=> intval($_POST['shipping']['min_delay']),
		'max_delay' 				=> intval($_POST['shipping']['max_delay']),
		'grade' 						=> intval($_POST['shipping']['grade']),
		'url' 							=> addslashes($_POST['shipping']['url']),
		'shipping_handling' => isset($_POST['shipping']['handling']) ? intval($_POST['shipping']['handling']) : '',
		'is_free' 					=> isset($_POST['shipping']['is_free']) ? intval($_POST['shipping']['is_free']) : '',
		'shipping_method' 	=> intval($_POST['shipping']['method']),
		'range_behavior' 		=> intval($_POST['shipping']['range_behavior']),
		'range_inf' 				=> isset($_POST['shipping']['range_inf']) ? floatval($_POST['shipping']['range_inf']) : '',
		'range_sup' 				=> isset($_POST['shipping']['range_sup']) ? floatval($_POST['shipping']['range_sup']) : '',
		'max_width' 				=> intval($_POST['shipping']['max_width']),
		'max_height' 				=> intval($_POST['shipping']['max_height']),
		'max_depth' 				=> intval($_POST['shipping']['max_depth']),
		'max_weight' 				=> intval($_POST['shipping']['max_weight']),
		'active' 						=> intval($_POST['shipping']['active']),
		//'is_default' 						=> intval($_POST['shipping']['is_default']),
  );


	// upload logo
  if( isset($_FILES['logo']) && $_FILES['logo']['size'][0] > 0 ){
    $file_name   = time() . '_' . $_FILES['logo']['name'][0];
    $file_name   = md5($file_name);
    $uploadDir   = '../files/carriers/';
    $extensions  = array('jpg', 'jpeg', 'png', 'gif');
    $file_target = $common->uploadDocument($_FILES['logo'], $file_name, $uploadDir, $extensions);
    $logo 			 = str_replace( $uploadDir , '', $file_target[0] );
    if( $logo != "" ) $carrier_data['logo'] = $logo;
  }

	//insert proccess
  if( isset($_POST['save']) ){

    //insert carrier
    $id_carrier = $common->save('carrier', $carrier_data);
    if( $id_carrier ){
    	echo '<script>window.location.href="?module=shipping&action=edit&id='. $id_carrier .'"</script>';
    	//array_push($success, 'Le Transport a été ajouter avec success.');
    }

  }elseif( isset($_POST['update']) ) {
  	//update carrier
    $common->update('carrier', $carrier_data, "WHERE id=".$id_carrier );

    //Insert carrier zones
		if(!empty($_POST['carrier_zones'])){
			$zone_ids = "";
			$zones = json_decode($_POST['carrier_zones'], true);
			// var_dump($_POST['carrier_zones']);exit;
			if( !empty($zones) ){
				foreach ($zones as $key => $zone) {
					$zone_ids .= $zone['id_zone'].",";
					$zone_fees = ($carrier_data['is_free']=="0") ? floatval( $zone['fees'] ) : 0;
					$zone_data = array(
						'id_carrier' => intval( $id_carrier ),
						'id_zone' 	 => intval( $zone['id_zone'] ),
						'fees'       => $zone_fees,
					);
					//check if exist
					$exist = $common->select('carrier_zones', array('id'), "WHERE id_carrier=". $id_carrier ." AND id_zone=".$zone['id_zone'] );
				  if( ! $exist ){
				  	$zone_data['active'] = 1;
				    $common->save('carrier_zones', $zone_data);
				  }else{
				  	$common->update('carrier_zones', array('fees' => $zone_fees, 'active' => 1), "WHERE id_carrier=". $id_carrier ." AND id_zone=".$zone['id_zone'] );
 				  }
				}
				$zone_ids = substr_replace($zone_ids, "", -1);
				$common->update('carrier_zones', array('fees'=> 0, 'active' => '0'), "WHERE id_carrier=". $id_carrier ." AND id_zone NOT IN (". $zone_ids .")" );
			} else {
				// $common->update('carrier_zones', array('fees'=> null, 'active' => '0'), "WHERE id_carrier=". $id_carrier );
				$common->update('carrier_zones', array('fees'=> 0, 'active' => '0'), "WHERE id_carrier=". $id_carrier );
			}
		}



		//Insert carrier users groups
		if(!empty($_POST['carrier_groups'])){
			$groups = $_POST['carrier_groups'];
			$group_ids = "";
			if( !empty($groups) ){
				foreach ($groups as $key => $group) {
					$group_ids .= $group.",";
					//check if exist
					$exist = $common->select('carrier_users_groups', array('id'), "WHERE id_carrier=". $id_carrier ." AND id_group=".$group );
				 
				  if( ! $exist ){
				    $common->save('carrier_users_groups', array('id_carrier' => $id_carrier, 'id_group' => $group, 'active' => 1) );
				  }else{
				  	$common->update('carrier_users_groups', array('active' => 1), "WHERE id_carrier=". $id_carrier ." AND id_group=".$group );
 				  }
				}
				//disable unselected groups
				$group_ids = substr_replace($group_ids, "", -1);
				$common->update('carrier_users_groups', array('active' => '0'), "WHERE id_carrier=". $id_carrier ." AND id_group NOT IN (". $group_ids .")" );
			}
		}else{
			$common->update('carrier_users_groups', array('active' => '0'), "WHERE id_carrier=". $id_carrier );
		}
		

    array_push($success, l("Le Transport a été mise à jour avec success."));
  }


  if( isset($_POST['shipping']['is_default']) ){
  	$common->update('carrier', array('is_default' => '0'), "WHERE is_default=1" );
  	$common->update('carrier', array('is_default' => '1'), "WHERE id=". $id_carrier );
  } else {
  	$common->update('carrier', array('is_default' => '0'), "WHERE id=". $id_carrier );
  }

/*============================================================*/
} //END DATA PROCCESSING
/*============================================================*/



/**
 *=============================================================
 * PREPARE DATA AFTER SAVE
 * This part well apply after the first save of new carrier
 *=============================================================
 */
if(isset($id_carrier) && $id_carrier > 0){
  $shipping = $common->select('carrier', array('*'), "WHERE id=".$id_carrier );
  //carrier_zones
  global $DB;
	$query = "SELECT cz.`fees`, cz.`active`, z.`id`, z.`name` FROM `"._DB_PREFIX_."zones` z 
			LEFT JOIN `"._DB_PREFIX_."carrier_zones` cz ON z.`id` = cz.`id_zone` AND cz.`id_carrier` = $id_carrier";
	if($rows = $DB->pdo->query($query)){
	  $carrier_zones = $rows->fetchAll(PDO::FETCH_ASSOC);
	}
	//json_zones
	$czones  = $common->select('carrier_zones', array('id_zone', 'fees'), "WHERE active=1 AND id_carrier=$id_carrier ORDER BY cdate ASC");
	$json_zones = '';
	if(!empty($czones)){
		foreach ($czones as $key => $cz) {
			$json_zones .= '{"id_zone":"'. $cz['id_zone'] .'","fees":"'. $cz['fees'] .'"},';
		}
		$json_zones = "[". substr_replace($json_zones, "", -1) ."]";
	}

	//carrier users groups
  global $DB;
	$query = "SELECT cg.`id_group`, cg.`active`, ug.`id`, ug.`name` FROM `"._DB_PREFIX_."users_groups` ug LEFT JOIN `"._DB_PREFIX_."carrier_users_groups` cg ON ug.`id` = cg.`id_group` AND cg.`id_carrier` = $id_carrier WHERE ug.`id` NOT IN(1)";
	if($rows = $DB->pdo->query($query)){
	  $carrier_groups = $rows->fetchAll(PDO::FETCH_ASSOC);
	}
/*============================================================*/
} //END DATA PREPARATION
/*============================================================*/


//shipping data
$common = new OS_Common();
//$groups = $common->select('users_groups', array('`id`, `name`'), "WHERE id NOT IN(1)");
$taxes  = $common->select('taxes', array('id', 'name', 'rate'), "WHERE active=1");
//print_r($shipping);
?>
<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
	<input type="hidden" name="customer[id]" id="id_carrier" value="<?= (isset($id_carrier) && $id_carrier > 0) ? $id_carrier : '';?>">
  <div class="top-menu padding0">
    <div class="top-menu-title">
      <h3>
      	<i class="fa fa-truck"></i>
      	<?= (isset($id_carrier) && $id_carrier > 0) ? l("Modifier le Transporteur") : l("Ajouter un Transporteur", "core");?>
      </h3>
    </div>
    <div class="top-menu-button">
    	<button type="button" class="btn btn-default" onclick="window.location='?module=shipping';"><?=l("Terminer", "core");?></button>
      <button type="submit" name="<?= (isset($id_carrier) && $id_carrier > 0) ? 'update' : 'save';?>" class="btn btn-primary"><?=l("Sauvegarder et rester", "core");?></button>
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


	<div class="col-sm-12 padding0" style="margin-bottom:10px;border-bottom:1px solid #A5245E;">
		<ul class="nav nav-tabs bg-white">
			<li><a data-toggle="tab" href="#step-1"><span class="number">1</span> <?=l("Paramètres généraux", "core");?></a></li>
			<li><a data-toggle="tab" href="#step-2"><span class="number">2</span> <?=l("Destinations d'expédition et coûts", "core");?></a></li>
			<li><a data-toggle="tab" href="#step-3"><span class="number">3</span> <?=l("Taille, poids et groupes associés", "core");?></a></li>
			<li><a data-toggle="tab" href="#step-4"><span class="number">4</span> <?=l("Récapitulatif", "core");?></a></li>
		</ul>
	</div>

	<div class="tab-content col-sm-12 padding0">

		<div class="tab-pane active" id="step-1">
			<div class="panel panel-default">
				<div class="panel-heading"><?=l("Paramètres généraux", "core");?></div>
				<div class="panel-body">
					<div class="form-group">
					<label class="col-md-3 control-label"><?=l("Statut", "core");?></label> 
						<div class="col-sm-3">
							<input type="checkbox" name="shipping[active]" class="switch" id="active" value="1" <?=  ( isset($shipping[0]['active']) && $shipping[0]['active']=="1") ? 'checked' : '';?> data-on-text="<?=l("activé", "core");?>" data-off-text="<?=l("désactivé", "core");?>" />
						</div>
						<div class="col-sm-3" style="position: absolute;left: 0px;">
							<span id="carrier_img">
								<?php if( isset($shipping[0]['logo']) && $shipping[0]['logo'] != "" ) : ?>
									<img class="img-thumbnail" src="<?php echo '../files/carriers/'. $shipping[0]['logo'];?>" width="125">
		            <?php else : ?>
		            	<img class="img-thumbnail" src="assets/images/carrier-default.jpg" width="125">
		            <?php endif; ?>
							</span>
						</div>
					</div>


					<div class="form-group">
						<label class="col-md-3 control-label"><?=l("Default carrier", "core");?></label> 
				         <div class="col-sm-3">
				            <input type="checkbox" name="shipping[is_default]" value="1" <?= (isset($shipping[0]['is_default']) && $shipping[0]['is_default']=="1") ? 'checked' : '';?>  class="switch" id="is_default" data-on-text="<?=l("YES", "core");?>" data-off-text="<?=l("NO", "core");?>" />
				         </div>
			        </div>


					<div class="form-group">
					  <label class="control-label col-lg-3"><?=l("Mode de livraison", "core");?></label>
					  <div class="col-lg-3">
					    <select name="shipping[type]" class="form-control" id="type">
					      <option value="economic" selected><?=l("Economique (le moins cher)", "core");?></option>
					      <option value="express" <?=( isset($shipping[0]['type']) && $shipping[0]['type']=="express" ) ? "selected" : "";?>><?=l("Express (le plus rapide)", "core");?></option>
					    </select>
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-lg-3 required"><span class="label-tooltip" data-html="true" data-original-title="<?=l("Caractères autorisés : lettres, espaces et &quot;().-&quot;. Nom du transporteur tel qu'il apparaîtra durant la commande. Pour le retrait en boutique, mettez le chiffre 0 afin de remplacer le nom du transporteur par le nom de votre boutique.", "core");?>" data-toggle="tooltip" title=""><?=l("Nom du transporteur *", "core");?></span></label>
					  <div class="col-lg-3">
					    <input class="form-control" id="name" type="text" name="shipping[name]" value="<?=isset($shipping[0]['name']) ? $shipping[0]['name'] : '';?>" required>
					  </div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3 required">
							<span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="<?=l("L'estimation du délai de livraison sera affichée durant la commande.", "core");?>"><?=l("Délai de livraison *", "core");?></span>
						</label>
						<div class="col-lg-1">
							<input class="form-control" type="number" id="min_delay" name="shipping[min_delay]" value="<?=(isset($shipping[0]['min_delay'])) ? $shipping[0]['min_delay'] : '';?>" placeholder="<?=l("min", "core");?>" value="" required>
						</div>
						<div class="col-lg-1">
							<input class="form-control" type="number" id="max_delay" name="shipping[max_delay]" value="<?=(isset($shipping[0]['max_delay'])) ? $shipping[0]['max_delay'] : '';?>" placeholder="<?=l("max", "core");?>" value="" required>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">
							<span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="<?=l("Saisissez &quot;0&quot; pour le délai d'expédition le plus long, ou &quot;9&quot; pour le délai le plus court.", "core");?>"><?=l("Vitesse", "core");?></span>
						</label>
						<div class="col-lg-3">
							<input type="number" min="0" size="1" name="shipping[grade]" value="<?=isset($shipping[0]['grade']) ? $shipping[0]['grade'] : '';?>" id="grade" placeholder="0" class="form-control">
						</div>
					</div>
					<div class="form-group">
					  <label class="control-label col-lg-3"><?=l("Logo", "core");?></label>
					  <div class="col-lg-3">
							<input type="file" name="logo" id="attachement">
							<small><?=l("Format JPG, GIF, PNG. Taille du fichier 8.00 Mo max. Taille actuelle", "core");?> <span id="carrier_logo_size"><?=l("indéfini", "core");?></span>.</small>
						</div>
					</div>
					<div class="form-group">
					  <label class="control-label col-lg-3"><span class="label-tooltip" data-html="true" data-original-title="<?=l("URL pour le suivi des colis : placez le caractère &quot;@&quot; là où la référence doit apparaître. Elle sera automatiquement remplacée par le numéro de suivi.", "core");?>" data-toggle="tooltip" title=""><?=l("URL de suivi", "core");?></span></label>
					  <div class="col-lg-3">
					    <input class="form-control" name="shipping[url]" value="<?=isset($shipping[0]['url']) ? $shipping[0]['url'] : '';?>" id="url" type="text" placeholder="http://..">
					    <p class="help-block"><?=l('Par exemple : "http://example.com/track.php?num=@" avec "@" à l\'emplacement du numéro de suivi.');?></p>
					  </div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="description"><?=l("Informations complémentaires", "core");?></label>  
						<div class="col-sm-6">
							<textarea name="shipping[description]" id="description" class="form-control summernote"><?=(isset($shipping[0]['description'])) ? $shipping[0]['description'] : '';?></textarea>
						</div>
					</div>

				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<button type="button" class="btn btn-default" onclick="window.location='?module=shipping';"><?=l("Fermer", "core");?></button>
					<button type="submit" name="<?= (isset($id_carrier) && $id_carrier > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?=l("Sauvegarder et rester", "core");?></button>
				</div><!--/ .panel-footer -->
			</div><!--/ .panel -->
		</div><!--/ #step-1 -->

		<div class="tab-pane" id="step-2">
			<?php if(isset($id_carrier) && $id_carrier > 0) : ?>
			<div class="panel panel-default">
				<div class="panel-heading"><?=l("Destinations d'expédition et coûts", "core");?></div>
				<div class="panel-body">

				<div class="col-sm-6">
					<div class="form-group">
						<label class="col-md-4 control-label"><?=l("Ajouter les frais de manutention", "core");?></label> 
	          <div class="col-sm-3">
	            <input type="checkbox" name="shipping[handling]" value="1" <?= ($shipping[0]['shipping_handling']=="1") ? 'checked' : '';?>  class="switch" id="handling" data-on-text="<?=l("OUI", "core");?>" data-off-text="<?=l("NON", "core");?>" />
	          </div>
	        </div>
					<div class="form-group">
						<label class="col-md-4 control-label"><?=l("Frais de port offerts", "core");?></label> 
	          <div class="col-sm-3">
	            <input type="checkbox" name="shipping[is_free]" value="1" <?= ($shipping[0]['is_free']=="1") ? 'checked' : '';?>  class="switch" id="isfree" data-on-text="<?=l("OUI", "core");?>" data-off-text="<?=l("NON", "core");?>" />
	          </div>
	        </div>
					<div class="form-group">
						<label class="control-label col-lg-4"><?=l("Facturation", "core");?></label>
						<div class="col-lg-4">
							<div class="radio t">
								<label><input type="radio" name="shipping[method]" id="billing_price" <?= ($shipping[0]['shipping_method']=="0") ? 'checked' : '';?> value="0" checked><?=l("En fonction du prix total.", "core");?></label>
							</div>
							<div class="radio t">
								<label><input type="radio" name="shipping[method]" id="billing_weight" <?= ($shipping[0]['shipping_method']=="1") ? 'checked' : '';?> value="1"><?=l("En fonction du poids total.", "core");?></label>
							</div>
						</div>
					</div>
					<div class="form-group">
		        <label class="col-md-4 control-label"><?=l("Taxes", "core");?></label> 
		        <div class="col-sm-4">
		          <select name="shipping[id_tax]" class="form-control" id="taxes">
		            <option value="0" selected><?=l("Aucune taxe", "core");?></option>
		            <?php if( !empty($taxes) ) : ?>
		            <?php foreach ($taxes as $key => $tax) : ?>
		              <option value="<?php echo $tax['id'] ?>" <?= ( $shipping[0]['id_tax'] == $tax['id'] ) ? 'selected' : '';?> ><?php echo $tax['name']. ' '. $tax['rate'] .'%'; ?></option>
		            <?php endforeach; ?>
		            <?php endif; ?>
		          </select>
		        </div>
		      </div>
					<div class="form-group">
					  <label class="control-label col-lg-4">
					  	<span class="label-tooltip" data-html="true" data-original-title="<?=l("Le comportement hors tranches désigne le comportement à adopter lorsqu'aucune tranche ne correspond au panier du client (par exemple, lorsque le poids total des articles mis au panier est plus grand que le poids maximal défini dans les tranches de poids).", "core");?>" data-toggle="tooltip"><?=l("Comportement hors tranches", "core");?></span>
					  </label>
					  <div class="col-lg-4">
					    <select name="shipping[range_behavior]" class="form-control" id="range_behavior">
					      <option <?= ( $shipping[0]['range_behavior'] == "0" ) ? 'selected' : '';?> value="0"><?=l("Prendre la tranche la plus grande", "core");?></option>
					      <option <?= ( $shipping[0]['range_behavior'] == "1" ) ? 'selected' : '';?> value="1"><?=l("Désactiver le transporteur", "core");?></option>
					    </select>
					  </div>
					</div>
				</div><!--/ .col-sm-6  -->


				<div class="col-sm-6 col-lg-6 col-xs-12">
					<div class="form-group">
					  <div id="zone_ranges">
					    <h4><?=l("Plages", "core");?></h4>
					    <input type="hidden" name="carrier_zones" id="carrier_zones" value='<?php echo $json_zones;?>'>
					    <table class="table" id="zones_table" cellpadding="4">
					      <tbody>
					        <tr class="bg-gray">
					          <td class="range_type" width="300"><?=l("Sera appliquée lorsque le poids est", "core");?></td>
					          <td class="border_left border_bottom range_sign">&gt;=</td>
					          <td class="border_bottom">
					            <div class="input-group fixed-width-md">
					              <span class="input-group-addon unit"><?= ( $shipping[0]['shipping_method'] == "1" ) ? l("kg") : get_currency();?></span>
					              <input name="shipping[range_inf]" value="<?php echo $shipping[0]['range_inf'];?>" type="number" min="0" step="0.01" placeholder="0.00" autocomplete="off" class="form-control">
					            </div>
					          </td>
					        </tr>
					        <tr class="bg-gray">
					          <td class="range_type"><?=l("Sera appliquée lorsque le poids est", "core");?></td>
					          <td class="border_left range_sign">&lt;</td>
					          <td class="range_data">
					            <div class="input-group fixed-width-md">
					              <span class="input-group-addon unit"><?= ( $shipping[0]['shipping_method'] == "1" ) ? 'kg' : '€';?></span>
					              <input name="shipping[range_sup]" value="<?php echo $shipping[0]['range_sup'];?>" type="number" min="0" step="0.01" placeholder="0.00" autocomplete="off" class="form-control">
					            </div>
					          </td>
					        </tr>
					        <tr class="fees_all">
					          <td><span class="fees_all"><?=l("All", "core");?></span></td>
					          <td style="">
					          	<input id="checkall" class="form-control" onclick="check_all('zones[]', this.checked)" type="checkbox">
					          </td>
					          <td>
					            <div class="input-group">
					              <span class="input-group-addon currency_sign">€</span> 
					              <input name="all" value="<?=isset($shipping[0]['all']) ? $shipping[0]['all'] : '';?>" autocomplete="off" class="form-control" type="number" min="0" step="0.01" placeholder="0.00">
					            </div>
					          </td>
					        </tr>

					        <?php if( isset($carrier_zones) && !empty($carrier_zones) ) : ?>
						        <?php foreach ($carrier_zones as $key => $zone): ?>
											<tr data-zoneid="<?php echo $zone['id']; ?>">
							          <td><label for="zone_<?php echo $zone['id']; ?>"><?php echo $zone['name']; ?></label></td>
							          <td class="zone">
							          	<input class="form-control" id="zone_<?php echo $zone['id']; ?>" name="zones[]" type="checkbox" value="<?php echo $zone['id']; ?>" <?= ( $zone['active'] == "1" ) ? 'checked' : '';?>>
							          </td>
							          <td>
							            <div class="input-group fixed-width-md">
							              <span class="input-group-addon">€</span> 
							              <input value="<?php echo $zone['fees']; ?>" autocomplete="off" class="form-control fees" type="number" min="0" step="0.01" placeholder="0.00">
							            </div>
							          </td>
							        </tr>
							      <?php endforeach; ?>
						      <?php endif; ?>

					      </tbody>
					    </table>
					  </div>
					</div>
					<div class="new_range">
						<a target="_blank" class="btn btn-default" href="?module=zones&action=add" id="add_new_range" onclick="add_new_range();return false;"><?=l("Ajouter une nouvelle tranche", "core");?></a>
					</div>
				</div><!--/ .col-sm-6  -->
					
				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<button type="button" class="btn btn-default" onclick="window.location='?module=shipping';"><?=l("Fermer", "core");?></button>
					<button type="submit" name="<?= (isset($id_carrier) && $id_carrier > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?=l("Sauvegarder et rester", "core");?></button>
				</div><!--/ .panel-footer -->
			</div><!--/ .panel -->
			<?php else: ?>
			<div class="alert alert-info">
				<h4><?=l("Il y a 1 avertissement.", "core");?></h4>
				<?=l("Vous devez enregistrer ce transport avant d'y ajouter des destinations d'expédition et coûts.", "core");?>
			</div>
			<?php endif; ?>
		</div><!--/ #step-2 -->

		<div class="tab-pane" id="step-3">
			<?php if(isset($id_carrier) && $id_carrier > 0) : ?>
			<div class="panel panel-default">
				<div class="panel-heading"><?=l("Taille, poids et groupes associés", "core");?></div>
				<div class="panel-body">

					<div class="form-group">
					  <label class="control-label col-lg-3">
					  	<span class="label-tooltip" data-html="true" data-original-title="<?=l("Largeur maximale gérée par ce transporteur. Inscrivez &quot;0&quot; ou laissez vide pour ignorer cette option. La valeur doit être un entier.", "core");?>" data-toggle="tooltip" title=""><?=l("Largeur maximum du paquet (cm)", "core");?></span>
					  </label>
					  <div class="col-lg-3">
					    <input class="form-control" id="max_width" name="shipping[max_width]" value="<?php echo $shipping[0]['max_width'];?>" type="number" min="0" placeholder="0">
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-lg-3">
					  	<span class="label-tooltip" data-html="true" data-original-title="<?=l("Hauteur maximale gérée par ce transporteur. Inscrivez &quot;0&quot; ou laissez vide pour ignorer cette option. La valeur doit être un entier.", "core");?>" data-toggle="tooltip" title=""><?=l("Hauteur maximum du paquet (cm)", "core");?></span>
					  </label>
					  <div class="col-lg-3">
					  	<input class="form-control" id="max_height" name="shipping[max_height]" value="<?php echo $shipping[0]['max_height'];?>" type="number" min="0" placeholder="0">
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-lg-3">
					  	<span class="label-tooltip" data-html="true" data-original-title="<?=l("Profondeur maximale gérée par ce transporteur. Inscrivez &quot;0&quot; ou laissez vide pour ignorer cette option. La valeur doit être un entier.", "core");?>" data-toggle="tooltip" title=""><?=l("Profondeur maximum du paquet (cm)", "core");?></span>
					  </label>
					  <div class="col-lg-3">
					  	<input class="form-control" id="max_depth" name="shipping[max_depth]" value="<?php echo $shipping[0]['max_depth'];?>" type="number" min="0" placeholder="0">
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-lg-3">
					  	<span class="label-tooltip" data-html="true" data-original-title="<?=l("Poids maximal géré par ce transporteur. Inscrivez &quot;0&quot; ou laissez vide pour ignorer cette option.", "core");?>" data-toggle="tooltip" title=""><?=l("Poids maximum du paquet (kg)", "core");?></span>
					  </label>
					  <div class="col-lg-3">
					  	<input class="form-control" id="max_weight" name="shipping[max_weight]" value="<?php echo $shipping[0]['max_weight'];?>" type="number" min="0" placeholder="0.00">
					  </div>
					</div>
					<div class="form-group">
					  <label class="control-label col-lg-3"><span class="label-tooltip" data-html="true" data-original-title="<?=l("Cochez tous les groupes qui ont accès à ce transporteur.", "core");?>" data-toggle="tooltip" title=""><?=l("Accès des groupes", "core");?></span></label>
					  <div class="col-lg-9">
					    <div class="row">
					      <div class="col-lg-6">
					        <table class="table table-bordered">
					          <thead>
					            <tr>
					              <th class="fixed-width-xs" width="30">
					              	<span class="title_box">
					              		<input id="checkme" name="checkme" onclick="check_all('carrier_groups[]', this.checked)" type="checkbox">
					              	</span>
					              </th>
					              <th><label for="checkme"><?=l("Nom du groupe", "core");?></label></th>
					            </tr>
					          </thead>
					          <tbody>
					          	<?php if( !empty($carrier_groups) ) : ?>
						          	<?php foreach ($carrier_groups as $key => $group) : ?>
												<tr>
						              <td>
						              	<input class="group" id="group_<?php echo $group['id']; ?>" name="carrier_groups[]" type="checkbox" value="<?php echo $group['id']; ?>" <?php echo ( $group['active'] == "1" ) ? 'checked' : '';?>>
						              </td>
						              <td><label for="group_<?php echo $group['id']; ?>"><?php echo $group['name']; ?></label></td>
						            </tr>
						          	<?php endforeach; ?>
						          <?php endif; ?>
					          </tbody>
					        </table>
					      </div>
					    </div>
					  </div>
					</div>

				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<button type="button" class="btn btn-default" onclick="window.location='?module=shipping';"><?=l("Fermer", "core");?></button>
					<button type="submit" name="<?= (isset($id_carrier) && $id_carrier > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?=l("Sauvegarder et rester", "core");?></button>
				</div><!--/ .panel-footer -->
			</div><!--/ .panel -->
			<?php else: ?>
			<div class="alert alert-info">
				<h4><?=l("Il y a 1 avertissement.", "core");?></h4>
				<?=l("Vous devez enregistrer ce transport avant d'y ajouter la taille, poids et groupes associés.", "core");?>
			</div>
			<?php endif; ?>
		</div><!--/ #step-3 -->

		<div class="tab-pane" id="step-4">
			<?php if(isset($id_carrier) && $id_carrier > 0) : ?>
			<div class="panel panel-default">
				<div class="panel-heading"><?=l("Informations de transporteur", "core");?></div>
				<div class="panel-body">
					<?php if(isset($id_carrier) && $id_carrier > 0) : ?>
						<?php $key = $common->array_searching($taxes, 'id', $shipping[0]['id_tax']); ?>
						<?php $unit = ( $shipping[0]['shipping_method'] == "1" ) ? 'kg' : '€';?>
						<p>
							<?=l("Le transporteur est", "core");?> <strong><?= ($shipping[0]['is_free']=="1") ? l("Offert", "core") : l("payant", "core"); ?></strong> <?=l("et le délai de livraison affiché est :", "core");?> <strong><?= ($shipping[0]['min_delay']) ? $shipping[0]['min_delay'] : "0"; ?> à <?= (isset($shipping[0]['max_delay'])) ? $shipping[0]['max_delay'] : "0"; ?> <?=l("jours.", "core");?></strong><br>
							<?=l("Le coût d'envoi est calculé", "core");?> <strong><?= ($shipping[0]['shipping_method']=="1") ? l("en fonction du poids") : l("en fonction du prix", "core"); ?></strong>, <?=l("et la règle de taxe", "core");?> <strong><?= ($shipping[0]['id_tax'] > 0) ? $taxes[ $key ]['name'] : l("Aucune taxe", "core"); ?></strong> <?=l("est appliquée", "core");?> <br>
							<span class="is_free"><?=l("Ce transporteur peut livrer des commandes de", "core");?> <strong><?=$shipping[0]['range_inf'].' '.$unit;?> à <?=$shipping[0]['range_sup'].' '.$unit;?>.</strong></span> <?=l("Si la commande est hors de cette tranche, le comportement est défini comme : prendre la tranche la plus grande.", "core");?> <br>
							<br><?=l("Ce transporteur sera proposé pour les zones :", "core");?><br>
							<ul style="margin-left:30px;">
								<?php
								if( !empty($carrier_zones) ){
									foreach ($carrier_zones as $key => $zone) {
										if( $zone['active'] == 1){
											echo "<li><strong>". $zone['name'] ."</strong></li>";
										}
									}
								}
								?>
							</ul>
							<?=l("Et il sera proposé pour les groupes de clients suivants :", "core");?>
							<ul style="margin-left:30px;">
								<?php
								if( !empty($carrier_groups) ){
									foreach ($carrier_groups as $key => $group) {
										if( $group['active'] == 1){
											echo "<li><strong>". $group['name'] ."</strong></li>";
										}
									}
								}
								?>
							</ul>
						</p>
					<?php else: ?>
						<div class="alert alert-info">
							<h4><?=l("Il y a 1 avertissement.", "core");?></h4>
							<?=l("Vous devez enregistrer ce transport avant de percevoir la Récapitulatif.", "core");?>
						</div>
					<?php endif; ?>
				</div><!--/ .panel-body -->
				<div class="panel-footer">
					<button type="button" class="btn btn-default" onclick="window.location='?module=shipping';"><?=l("Fermer", "core");?></button>
					<button type="submit" name="<?= (isset($id_carrier) && $id_carrier > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?=l("Sauvegarder et rester", "core");?></button>
				</div><!--/ .panel-footer -->
			</div><!--/ .panel -->
			<?php else: ?>
			<div class="alert alert-info">
				<h4><?=l("Il y a 1 avertissement.", "core");?></h4>
				<?=l("Vous devez enregistrer ce transport avant d'afficher les informations de transporteur.", "core");?>
			</div>
			<?php endif; ?>
		</div><!--/ #step-4 -->

	</div><!--/ .tab-content -->

</form>
<script>
$(document).ready(function(){

	//Facturation
  $('input[type=radio][name="shipping[method]"]').change(function() {
    if (this.value == '0') {
      $('span.unit').text('<?php echo get_currency();?>');
      $('.range_type').text("<?=l('Sera appliquée lorsque le prix est', 'admin');?>");
    }else{
    	$('span.unit').text("<?=l('kg', 'admin');?>");
    	$('.range_type').text("<?=l('Sera appliquée lorsque le poids est', 'admin');?>");
    }
  });

	//Bootstrap Switch
	$(".switch").bootstrapSwitch({onColor:'success','offColor':'danger'});
	var switch_state = $('#isfree').bootstrapSwitch('state');
	switcher(switch_state);
	
	$("#isfree").on('switchChange.bootstrapSwitch', function(event, state) {
		switcher(state);
	});
	// jquery filer
  $('#attachement').filer({
    maxSize: 8,
    extensions: ['jpg', 'jpeg', 'png', 'gif']
  });

  //zones_table
  $('#zones_table input[type="checkbox"], #zones_table input[type=number]').on('change', function(){
  	get_carrier_fees();
  });


  //check all
  $('#zones_table input[name=all]').on('change', function(){
	if ( $('#checkall').is(":checked") ) {
		var value = $(this).val();
		$('#zones_table .fees').each(function () {
			$(this).val( value );
		});
	}
	$(this).val('');
	get_carrier_fees();
  });

  


  


});



function get_carrier_fees(){
	var json = "";
	$('tr[data-zoneid]').each(function() {
		var zone = $(this).find("input[type='checkbox']");
		if ( zone.is(":checked") ){
			var fees = $(this).find("input[type='number']");
			var value = $(fees).val();
			if( value == '' ){
				value = 0;
			}
			json += ('{"id_zone":"'+ zone.val() +'","fees":"'+ value +'"},');
		}
  	});
  	json = "["+ json.slice(0,-1) +"]";
	$('#carrier_zones').empty().val( json );
}


//functions
function switcher(state){
	if( state == true ){
  	$('#zones_table tr td:nth-child(3) input').val('').prop('disabled', true);
  	$("#handling").bootstrapSwitch('toggleState');
  	$("#handling").bootstrapSwitch('disabled',true);
  }else{
  	$('#zones_table tr td:nth-child(3) input').prop('disabled', false);
  	$("#handling").bootstrapSwitch('state', true);
  	$("#handling").bootstrapSwitch('disabled',false);
  }
}
</script>