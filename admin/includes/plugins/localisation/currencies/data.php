<?php 
function Add(){}
function EDIT($ID){}
function DELETE($ID){
	$common = new OS_Common();
	$id = $common->delete('currencies', "WHERE id=".$ID );
	echo '<script>window.location.href="?module=currencies"</script>';
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
  $currency = $common->select('currencies', array('*'), "WHERE id=". intval($_GET['id']) );
  if( $currency ){
    $id_currency = intval($_GET['id']);
  }else{
  	echo '<script>window.location.href="?module=currencies"</script>';
  }
/*============================================================*/
} //END UPDATE MODE
/*============================================================*/

/**
 *=============================================================
 * INSERT POSTED DATA
 *=============================================================
 */
if( $_POST && $_POST['currency']['name'] != "" ){

	//customer informations
  $currency_data = array(
    'name' 	       => addslashes($_POST['currency']['name']),
    'iso_code'     => addslashes($_POST['currency']['iso_code']),
    'iso_code_num' => intval($_POST['currency']['iso_code_num']),
    'sign'         => addslashes($_POST['currency']['sign']),
    'active'       => intval($_POST['currency']['active']),
    'default_currency' => intval($_POST['currency']['default_currency'])
  );

  //insert proccess
  if( isset($_POST['save']) ){
    //insert currency
    $id_currency = $common->save('currencies', $currency_data);
    echo '<script>window.location.href="?module=currencies"</script>';
 	}elseif( isset($_POST['update']) ){
 		//update currency
 		$common->update('currencies', $currency_data, "WHERE id=".$id_currency );
 		echo '<script>window.location.href="?module=currencies"</script>';
 	}

/*============================================================*/
} //END INSERT POSTED DATA
/*============================================================*/

?>
<form class="form-horizontal" method="post" action="">
	<input type="hidden" name="currency[id]" id="id_currency" value="<?= (isset($id_currency) && $id_currency > 0) ? $id_currency : '';?>">
  <div class="top-menu padding0">
    <div class="top-menu-title">
      <h3>
      	<i class="fa fa-money"></i>
      	<?= (isset($id_currency) && $id_currency > 0) ? l("Modifier un Devise") : l("Ajouter un Devise", "core");?>
      </h3>
    </div>
    <div class="top-menu-button">
      <button type="submit" name="<?= (isset($id_currency) && $id_currency > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_currency) && $id_currency > 0) ? l("Mise à jour") : l("Enregister", "core");?></button>
    </div>
  </div><br>

  <div class="panel panel-default">
		<div class="panel-heading"><?=l("Devises", "core");?></div>
		<div class="panel-body">

			<div class="form-group">
			  <label class="control-label col-lg-3 required">
			  	<span class="label-tooltip" data-html="true" data-original-title="<?=l("Seuls les lettres et le tiret sont autorisés", "core");?>" data-toggle="tooltip" title=""><?=l("Nom de la devise *", "core");?></span>
			  </label>
			  <div class="col-lg-3">
			    <input class="form-control" id="name" name="currency[name]" required="required" type="text" value="<?php echo $currency[0]['name'];?>" placeholder="<?=l("Euro", "core");?>">
			  </div>
			</div>
      <div class="form-group">
        <label class="control-label col-lg-3 required">
          <span class="label-tooltip" data-html="true" data-original-title="<?=l("Code ISO (ex. : USD pour dollar, EUR pour euro, etc.).", "core");?>" data-toggle="tooltip" title=""><?=l("Code ISO", "core");?></span>
        </label>
        <div class="col-lg-3">
          <input class="form-control" id="iso_code" maxlength="32" name="currency[iso_code]" required="required" type="text" value="<?php echo $currency[0]['iso_code'];?>" placeholder="<?=l("ex. : USD pour dollar, EUR pour euro, etc.", "core");?>">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-lg-3 required">
          <span class="label-tooltip" data-html="true" data-original-title="<?=l("Code ISO numérique (ex. : 840 pour dollar, 978 pour euro).", "core");?>" data-toggle="tooltip" title=""><?=l("ISO code numérique", "core");?></span>
        </label>
        <div class="col-lg-3">
          <input class="form-control" id="iso_code_num" maxlength="32" name="currency[iso_code_num]" required="required" type="number" min="0" step="0.01" value="<?php echo $currency[0]['iso_code_num'];?>" placeholder="<?=l("ex. : 840 pour dollar, 978 pour euro", "core");?>">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-lg-3 required">
          <span class="label-tooltip" data-html="true" data-original-title="<?=l("Apparaîtra sur le front-office (ex. : €, $)", "core");?>" data-toggle="tooltip" title=""><?=l("Symbole", "core");?></span>
        </label>
        <div class="col-lg-3">
          <input class="form-control" id="sign" maxlength="8" name="currency[sign]" required="required" type="text" value="<?php echo $currency[0]['sign'];?>" placeholder="<?=l("ex. : €, $", "core");?>">
        </div>
      </div>
      <!--div class="form-group">
        <label class="control-label col-lg-3 required">
          <span class="label-tooltip" data-html="true" data-original-title="Les taux de change sont calculés à partir d'une unité de la monnaie par défaut actuelle de votre boutique. Par exemple, si la monnaie par défaut de votre boutique est l'euro et que vous choisissez le dollar, saisissez &quot;1,20&quot; comme taux de change." data-toggle="tooltip" title="">Taux de change</span>
        </label>
        <div class="col-lg-3">
          <input class="form-control" id="conversion_rate" maxlength="11" name="currency[conversion_rate]" required="required" type="text" value="<?php //echo $currency[0]['conversion_rate'];?>">
        </div>
      </div-->
			<div class="form-group">
				<label class="col-md-3 control-label"><?=l("Activer", "core");?></label> 
        <div class="col-sm-3">
          <input type="checkbox" name="currency[active]" class="switch" id="handling" data-on-text="<?=l("OUI", "core");?>" data-off-text="<?=l("NON", "core");?>" value="1" <?= ($currency[0]['active']=="1") ? 'checked' : '';?>/>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label"><?=l("Par défaut", "core");?></label> 
        <div class="col-sm-3">
          <input type="checkbox" name="currency[default_currency]" class="switch" id="handling" data-on-text="<?=l("OUI", "core");?>" data-off-text="<?=l("NON", "core");?>" value="1" <?= ($currency[0]['default_currency']=="1") ? 'checked' : '';?>/>
        </div>
      </div>

		</div><!--/ .panel-body -->
		<div class="panel-footer">
			<button type="button" class="btn btn-default" onclick="window.location='?module=currencies';"><?=l("Fermer", "core");?></button>
			<button type="submit" name="<?= (isset($id_currency) && $id_currency > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_currency) && $id_currency > 0) ? l("Mise à jour") : l("Enregister", "core");?></button>
		</div><!--/ .panel-footer -->
	</div><!--/ .panel -->


</form>

<script>
$(document).ready(function(){
	//Bootstrap Switch
	$(".switch").bootstrapSwitch({onColor:'success','offColor':'danger'});//state:'true',

});
</script>