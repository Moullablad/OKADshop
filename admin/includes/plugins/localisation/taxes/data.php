<?php 
function Add(){}
function EDIT($ID){}
function DELETE($ID){
	$common = new OS_Common();
	$id = $common->delete('taxes', "WHERE id=".$ID );
	echo '<script>window.location.href="?module=taxes"</script>';
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
  $tax = $common->select('taxes', array('id', 'name', 'rate', 'active'), "WHERE id=". intval($_GET['id']) );
  if( $tax ){
    $id_tax = intval($_GET['id']);
  }else{
  	echo '<script>window.location.href="?module=taxes"</script>';
  }
/*============================================================*/
} //END UPDATE MODE
/*============================================================*/

/**
 *=============================================================
 * INSERT POSTED DATA
 *=============================================================
 */
if( $_POST && $_POST['tax']['name'] != "" && $_POST['tax']['rate'] != ""){

	//customer informations
  $tax_data = array(
    'name' 	 => addslashes($_POST['tax']['name']),
    'rate'   => floatval($_POST['tax']['rate']),
    'active' => intval($_POST['tax']['active'])
  );

  //insert proccess
  if( isset($_POST['save']) ){
    //insert tax
    $id_tax = $common->save('taxes', $tax_data);
    echo '<script>window.location.href="?module=taxes"</script>';
 	}elseif( isset($_POST['update']) ){
 		//update tax
 		$common->update('taxes', $tax_data, "WHERE id=".$id_tax );
 		echo '<script>window.location.href="?module=taxes"</script>';
 	}

/*============================================================*/
} //END INSERT POSTED DATA
/*============================================================*/

?>
<form class="form-horizontal" method="post" action="">
	<input type="hidden" name="tax[id]" id="id_tax" value="<?= (isset($id_tax) && $id_tax > 0) ? $id_tax : '';?>">
  <div class="top-menu padding0">
    <div class="top-menu-title">
      <h3>
      	<i class="fa fa-money"></i>
      	<?= (isset($id_tax) && $id_tax > 0) ? l("Modifier une Taxe") : l("Ajouter une Taxe", "core");?>
      </h3>
    </div>
    <div class="top-menu-button">
      <button type="submit" name="<?= (isset($id_tax) && $id_tax > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_tax) && $id_tax > 0) ? l("Mise à jour") : l("Enregister", "core");?></button>
    </div>
  </div><br>

  <div class="panel panel-default">
		<div class="panel-heading"><?=l("Taxes", "core");?></div>
		<div class="panel-body">

			<div class="form-group">
			  <label class="control-label col-lg-3 required">
			  	<span class="label-tooltip" data-html="true" data-original-title="<?=l("Nom de la taxe à afficher dans le panier et sur la facture (ex. : &quot;TVA&quot;). - Caractères interdits &lt;&gt;;=#{}", "core");?>" data-toggle="tooltip" title=""><?=l("Nom *", "core");?></span>
			  </label>
			  <div class="col-lg-3">
			    <input class="form-control" id="name" name="tax[name]" required="required" type="text" value="<?php echo $tax[0]['name'];?>">
			  </div>
			</div>
			<div class="form-group">
				<label class="control-label col-lg-3 required">
					<span class="label-tooltip" data-toggle="tooltip" data-html="true" title="" data-original-title="<?=l("Format : XX.XX ou XX.XXX (ex. : 19.60 ou 13.925) - Caractères interdits <>;=#{}", "core");?>"><?=l("Taux *", "core");?></span>
				</label>
			  <div class="col-lg-3">
			    <input class="form-control" id="rate" name="tax[rate]" required="required" type="number" min="0" step="0.01" value="<?php echo $tax[0]['rate'];?>">
			  </div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label"><?=l("Activer", "core");?></label> 
        <div class="col-sm-3">
          <input type="checkbox" name="tax[active]" class="switch" id="handling" data-on-text="<?=l("OUI", "core");?>" data-off-text="<?=l("NON", "core");?>" value="1" <?= ($tax[0]['active']=="1") ? 'checked' : '';?>/>
        </div>
      </div>

		</div><!--/ .panel-body -->
		<div class="panel-footer">
			<button type="button" class="btn btn-default" onclick="window.location='?module=taxes';"><?=l("Fermer", "core");?></button>
			<button type="submit" name="<?= (isset($id_tax) && $id_tax > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_tax) && $id_tax > 0) ? l("Mise à jour") : l("Enregister", "core");?></button>
		</div><!--/ .panel-footer -->
	</div><!--/ .panel -->


</form>

<script>
$(document).ready(function(){
	//Bootstrap Switch
	$(".switch").bootstrapSwitch({onColor:'success','offColor':'danger'});

});
</script>