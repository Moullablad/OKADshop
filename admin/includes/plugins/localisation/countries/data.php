<?php 
function Add(){}
function EDIT($ID){}
function DELETE($ID){
	$common = new OS_Common();
	$id = $common->delete('countries', "WHERE id=".$ID );
	echo '<script>window.location.href="?module=countries"</script>';
}
//exit if delete action
if ( $_GET['action'] == "delete" ) return;

$common = new OS_Common();


/**
 *=============================================================
 * UPDATE MODE
 * This part well apply when you go to edit a customer from list
 * EX: [WewSite]index.php?module=users&action=edit&id=[1]
 *=============================================================
 */
if( 
  isset($_GET['action']) && $_GET['action'] == 'edit'
  && isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0
){
  $country = $common->select('countries', array('*'), "WHERE id=". intval($_GET['id']) );
  if( $country ){
    $id_country = intval($_GET['id']);
  }else{
  	echo '<script>window.location.href="?module=countries"</script>';
  }
/*============================================================*/
} //END UPDATE MODE
/*============================================================*/

/**
 *=============================================================
 * INSERT POSTED DATA
 *=============================================================
 */
if( $_POST && $_POST['country']['name'] != "" ){

	//customer informations
  $country_data = array(
    'name' 	          => addslashes($_POST['country']['name']),
    'iso_code'        => addslashes($_POST['country']['iso_code']),
    'call_prefix'     => intval($_POST['country']['call_prefix']),
    'id_currency'     => intval($_POST['country']['id_currency']),
    'id_zone'         => intval($_POST['country']['id_zone']),
    'zip_code_format' => addslashes($_POST['country']['zip_code_format']),
    'active'          => intval($_POST['country']['active'])
  );

  //insert proccess
  if( isset($_POST['save']) ){
    //insert zone
    $id_country = $common->save('countries', $country_data);
    //echo '<script>window.location.href="?module=countries"</script>';
 	}elseif( isset($_POST['update']) ){
 		//update zone
 		$common->update('countries', $country_data, "WHERE id=".$id_country );
 		echo '<script>window.location.href="?module=countries"</script>';
 	}

/*============================================================*/
} //END INSERT POSTED DATA
/*============================================================*/


//other data
$currencies = $common->select('currencies', array('id', 'name'));
$zones = $common->select('zones', array('id', 'name'), "ORDER BY name ASC");
?>
<form class="form-horizontal" method="post" action="">
	<input type="hidden" name="country[id]" id="id_country" value="<?= (isset($id_country) && $id_country > 0) ? $id_country : '';?>">
  <div class="top-menu padding0">
    <div class="top-menu-title">
      <h3>
      	<i class="fa fa-globe"></i>
      	<?= (isset($id_country) && $id_country > 0) ? l("Modifier une Pays") : l("Ajouter une Pays", "core");?>
      </h3>
    </div>
    <div class="top-menu-button">
      <button type="submit" name="<?= (isset($id_country) && $id_country > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_country) && $id_country > 0) ? l("Mise à jour") : l("Enregister", "core");?></button>
    </div>
  </div><br>

  <div class="panel panel-default">
		<div class="panel-heading"><?=l("countries", "core");?></div>
		<div class="panel-body">

			<div class="form-group">
			  <label class="control-label col-lg-3 required">
			  	<span class="label-tooltip" data-html="true" data-original-title="Nom du pays - Caractères interdits <>;=#{}" data-toggle="tooltip" title=""><?=l("Nom du pays *", "core");?></span>
			  </label>
			  <div class="col-lg-3">
			    <input class="form-control" id="name" name="country[name]" required="required" type="text" value="<?=(isset($country[0]['name'])) ? $country[0]['name'] : '';?>">
			  </div>
			</div>
      <div class="form-group">
        <label class="control-label col-lg-3 required">
          <span class="label-tooltip" data-html="true" data-original-title="Code ISO à deux ou trois lettres (ex. : &quot;fr&quot; pour la France)." data-toggle="tooltip" title=""><?=l("Code ISO", "core");?></span>
        </label>
        <div class="col-lg-3">
          <input class="form-control" id="iso_code" maxlength="3" name="country[iso_code]" required="required" type="text" value="<?=(isset($country[0]['iso_code'])) ? $country[0]['iso_code'] : '';?>">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-lg-3 required">
          <span class="label-tooltip" data-html="true" data-original-title="Indicatif téléphonique international, ex. : 33 pour la France." data-toggle="tooltip" title=""><?=l("Indicatif téléphonique", "core");?></span>
        </label>
        <div class="col-lg-3">
          <input class="form-control" id="call_prefix" maxlength="3" name="country[call_prefix]" required="required" type="number" min="0" value="<?=(isset($country[0]['call_prefix'])) ? $country[0]['call_prefix'] : '';?>">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-lg-3"><?=l("Devise par défaut", "core");?></label>
        <div class="col-lg-3">
          <select class="form-control" id="id_currency" name="country[id_currency]">
            <option value="0"><?=l("Devise du magasin par défaut", "core");?></option>
            <?php if( !empty($currencies) ) : ?>
            <?php foreach ($currencies as $key => $currency) : ?>
              <option value="<?php echo $currency['id'] ?>" <?php if( isset($country[0]['id_currency']) && $country[0]['id_currency'] == $currency['id']){ echo "selected";} ?>><?php echo $currency['name']; ?></option>
            <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-lg-3">
          <span class="label-tooltip" data-html="true" data-original-title="<?=l("Zone géographique du pays.", "core");?>" data-toggle="tooltip" title=""><?=l("Zone", "core");?></span>
        </label>
        <div class="col-lg-3">
          <select class="form-control" id="id_zone" name="country[id_zone]">
            <?php if( !empty($zones) ) : ?>
            <?php foreach ($zones as $key => $zone) : ?>
              <option value="<?php echo $zone['id'] ?>" <?php if( isset($country[0]['id_zone']) && $country[0]['id_zone']== $zone['id']){ echo "selected";} ?>><?php echo $zone['name']; ?></option>
            <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-lg-3 required"><?=l("Format du code postal", "core");?></label>
        <div class="col-lg-3">
          <input class="form-control" id="zip_code_format" name="country[zip_code_format]" required="required" type="text" value="<?=(isset($country[0]['zip_code_format'])) ? $country[0]['zip_code_format'] : '';?>">
          <small><?=l("Indiquez le format du code postal : utilisez L pour une lettre, N pour un nombre, et C pour le code ISO 3166-1 alpha-2 du pays. Par exemple, NNNNN pour les États-Unis, la France, la Pologne et beaucoup d'autres ; LNNNNLLL pour l'Argentine, etc.", "core");?></small>
        </div>
      </div>


			<div class="form-group">
				<label class="col-md-3 control-label"><?=l("Activer", "core");?></label> 
        <div class="col-sm-3">
          <input type="checkbox" name="country[active]" class="switch" id="handling" data-on-text="OUI" data-off-text="NON" value="1" <?= (isset($country[0]['active']) && $country[0]['active']=="1") ? 'checked' : '';?>/>
        </div>
      </div>

		</div><!--/ .panel-body -->
		<div class="panel-footer">
			<button type="button" class="btn btn-default" onclick="window.location='?module=countries';">Fermer</button>
			<button type="submit" name="<?= (isset($id_country) && $id_country > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_country) && $id_country > 0) ? l("Mise à jour") : l("Enregister", "core");?></button>
		</div><!--/ .panel-footer -->
	</div><!--/ .panel -->


</form>

<script>
$(document).ready(function(){
	//Bootstrap Switch
	$(".switch").bootstrapSwitch({onColor:'success','offColor':'danger'});//state:'true',

});
</script>