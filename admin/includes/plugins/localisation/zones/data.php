<?php 
function Add(){}
function EDIT($ID){}
function DELETE($ID){
	$common = new OS_Common();
	$id = $common->delete('zones', "WHERE id=".$ID );
	echo '<script>window.location.href="?module=zones"</script>';
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
  $zone = $common->select('zones', array('id', 'name', 'active'), "WHERE id=". intval($_GET['id']) );
  if( $zone ){
    $id_zone = intval($_GET['id']);
  }else{
  	echo '<script>window.location.href="?module=zones"</script>';
  }
/*============================================================*/
} //END UPDATE MODE
/*============================================================*/

/**
 *=============================================================
 * INSERT POSTED DATA
 *=============================================================
 */
if( $_POST && $_POST['zone']['name'] != "" ){

	//customer informations
  $zone_data = array(
    'name' 	 => addslashes($_POST['zone']['name']),
    'active' => intval($_POST['zone']['active'])
  );

  //insert proccess
  if( isset($_POST['save']) ){
    //insert zone
    $id_zone = $common->save('zones', $zone_data);
    echo '<script>window.location.href="?module=zones"</script>';
 	}elseif( isset($_POST['update']) ){
 		//update zone
 		$common->update('zones', $zone_data, "WHERE id=".$id_zone );
 		echo '<script>window.location.href="?module=zones"</script>';
 	}

/*============================================================*/
} //END INSERT POSTED DATA
/*============================================================*/

?>
<form class="form-horizontal" method="post" action="">
	<input type="hidden" name="zone[id]" id="id_zone" value="<?= (isset($id_zone) && $id_zone > 0) ? $id_zone : '';?>">
  <div class="top-menu padding0">
    <div class="top-menu-title">
      <h3>
      	<i class="fa fa-globe"></i>
      	<?= (isset($id_zone) && $id_zone > 0) ? l("Modifier une Zone") : l("Ajouter une Zone", "core");?>
      </h3>
    </div>
    <div class="top-menu-button">
      <button type="submit" name="<?= (isset($id_zone) && $id_zone > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_zone) && $id_zone > 0) ? l("Mise à jour") : l("Enregister", "core");?></button>
    </div>
  </div><br>

  <div class="panel panel-default">
		<div class="panel-heading"><?=l("Zones", "core");?></div>
		<div class="panel-body">

			<div class="form-group">
			  <label class="control-label col-lg-3 required">
			  	<span class="label-tooltip" data-html="true" data-original-title="<?=l("Nom de la zone (ex. : Afrique, Europe, Pays voisins).", "core");?>" data-toggle="tooltip" title=""><?=l("Nom *", "core");?></span>
			  </label>
			  <div class="col-lg-3">
			    <input class="form-control" id="name" name="zone[name]" required="required" type="text" value="<?php echo $zone[0]['name'];?>">
			  </div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label"><?=l("Activer", "core");?></label> 
        <div class="col-sm-3">
          <input type="checkbox" name="zone[active]" class="switch" id="handling" data-on-text="<?=l("OUI", "core");?>" data-off-text="<?=l("NON", "core");?>" value="1" <?= ($zone[0]['active']=="1") ? 'checked' : '';?>/>
        </div>
      </div>

		</div><!--/ .panel-body -->
		<div class="panel-footer">
			<button type="button" class="btn btn-default" onclick="window.location='?module=zones';"><?=l("Fermer", "core");?></button>
			<button type="submit" name="<?= (isset($id_zone) && $id_zone > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?= (isset($id_zone) && $id_zone > 0) ? l("Mise à jour") : l("Enregister", "core");?></button>
		</div><!--/ .panel-footer -->
	</div><!--/ .panel -->


</form>

<script>
$(document).ready(function(){
	//Bootstrap Switch
	$(".switch").bootstrapSwitch({onColor:'success','offColor':'danger'});//state:'true',

});
</script>