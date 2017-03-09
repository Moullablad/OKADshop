<?php 
function Add(){}
function EDIT($ID){}
function DELETE($ID){
	$common = new OS_Common();
	$common->delete('taxes_rules_group', "WHERE id=".$ID );
	echo '<script>window.location.href="?module=taxes_rules_group"</script>';
}
//exit if delete action
if ( $_GET['action'] == "delete" ) return;

$product = new OS_Product();
$errors = $success = array();

//delete taxe rule
if( isset($_GET['delete']) && is_numeric($_GET['delete']) && $_GET['delete'] > 0 ){
  $delete = $product->delete('taxes_rules', "WHERE id=".intval($_GET['delete']) );
  if( $delete ) array_push($success, 'La règle de taxe a été supprimer avec success.');
}



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
  $exist = $product->select('taxes_rules_group', array('id'), "WHERE id=". intval($_GET['id']) );
  if( $exist ){
    $id_group = intval($_GET['id']);
  }else{
  	echo '<script>window.location.href="?module=taxes_rules_group"</script>';
  }
/*============================================================*/
} //END UPDATE MODE
/*============================================================*/

/**
 *=============================================================
 * INSERT POSTED DATA
 *=============================================================
 */
if( $_POST && $_POST['group']['name'] != "" ){

	//tax informations
  $group_data = array(
    'name'   => addslashes($_POST['group']['name']),
    'active' => addslashes($_POST['group']['active'])
  );

  //tax informations
  $id_tax = intval($_POST['tax_rule']['id_tax']);
  $id_country = intval($_POST['tax_rule']['id_country']);
  $taxes_rules_data = array(
    'id_group'    => $id_group, 
    'id_tax'      => $id_tax,
    'id_country'  => $id_country, 
    'description' => addslashes($_POST['tax_rule']['description'])
  );

  //insert proccess
  if( isset($_POST['save']) ){
    //insert tax
    $id_group = $product->save('taxes_rules_group', $group_data);
    echo '<script>window.location.href="?module=taxes_rules_group&action=edit&id='.$id_group.'"</script>';
 	}elseif( isset($_POST['update']) ){
 		//update tax
 		$product->update('taxes_rules_group', $group_data, "WHERE id=".$id_group );


    //add tax rule
    if( $_POST['tax_rule']['id_country'] != "0" && $_POST['tax_rule']['id_tax'] != "0" ){

      if( empty($_POST['tax_rule']['id']) ){
        $exist = $product->select('taxes_rules', array('id'), "WHERE id_tax=". $id_tax ." AND id_country=".$id_country );
        if( !$exist ){
          $product->save('taxes_rules', $taxes_rules_data);
        }else{
          array_push($errors, 'Une règle de taxe existe déjà pour ce pays/état.');
        }
        
      }else{
        $id_tax_rule = intval($_POST['tax_rule']['id']);
        $product->update('taxes_rules', $taxes_rules_data, "WHERE id=".$id_tax_rule );
      }

    }
    

 	}

/*============================================================*/
} //END INSERT POSTED DATA
/*============================================================*/



/**
 *=============================================================
 * PREPARE DATA AFTER SAVE
 * This part well apply after the first save of new customer
 *=============================================================
 */
if(isset($id_group) && $id_group > 0){
  $group       = $product->select('taxes_rules_group', array('id', 'name', 'active'), "WHERE id=".$id_group );
  $taxes_rules = $product->get_taxes_rules($id_group);
/*============================================================*/
} //END DATA PREPARATION
/*============================================================*/


//other data
$countries = $product->select('countries', array('id', 'name'));
$taxes     = $product->select('taxes', array('id', 'name', 'rate'), "WHERE active=1");
?>

  

<form class="form-horizontal" method="post" action="">
	<!--input type="hidden" name="tax[id]" id="id_group" value="<?//= (isset($id_group) && $id_group > 0) ? $id_group : '';?>"-->
  <div class="top-menu padding0">
    <div class="top-menu-title">
      <h3>
      	<i class="fa fa-money"></i>
      	<?= (isset($id_group) && $id_group > 0) ? l("Modifier une règles de taxes") : l("Ajouter une règles de taxes", "core");?>
      </h3>
    </div>
    <div class="top-menu-button">
      <button type="submit" name="<?= (isset($id_group) && $id_group > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?=l("Sauvegarder et rester", "core");?></button>  
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

  <div class="panel panel-default">
		<div class="panel-heading"><?=l("Règles de taxes", "core");?></div>
		<div class="panel-body">

			<div class="form-group">
			  <label class="control-label col-lg-3 required">
			  	<span class="label-tooltip" data-html="true" data-original-title="<?=l("Nom de la taxe à afficher dans le panier et sur la facture (ex. : &quot;TVA&quot;). - Caractères interdits &lt;&gt;;=#{}", "core");?>" data-toggle="tooltip" title=""><?=l("Nom *", "core");?></span>
			  </label>
			  <div class="col-lg-3">
			    <input class="form-control" id="name" name="group[name]" required="required" type="text" value="<?php echo $group[0]['name'];?>">
			  </div>
			</div>
      <div class="form-group">
        <label class="col-md-3 control-label"><?=l("Activer", "core");?></label> 
        <div class="col-sm-3">
          <input type="checkbox" name="group[active]" class="switch" id="handling" data-on-text="<?=l("OUI", "core");?>" data-off-text="<?=l("NON", "core");?>" value="1" <?= ($group[0]['active']=="1") ? 'checked' : '';?>/>
        </div>
      </div>


      <div class="panel-subheading">
        <strong class="edit_tax"><?=l("NOUVELLE RÈGLE DE TAXE", "core");?></strong>
      </div>
      <input type="hidden" name="tax_rule[id]" id="id_tax_rule" value="">
      <div class="form-group">
        <label class="control-label col-lg-3"><?=l("Pays", "core");?></label>
        <div class="col-lg-2">
          <select name="tax_rule[id_country]" class="form-control" id="countries">
            <option value="0" selected><?=l("Toutes", "core");?></option>
            <?php if( !empty($countries) ) : ?>
            <?php foreach ($countries as $key => $country) : ?>
              <option value="<?php echo $country['id'] ?>"><?php echo $country['name'] ?></option>
            <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label"><?=l("Taxes", "core");?></label> 
        <div class="col-sm-2">
          <select name="tax_rule[id_tax]" class="form-control" id="taxes">
            <option value="0" selected><?=l("Aucune taxe", "core");?></option>
            <?php if( !empty($taxes) ) : ?>
            <?php foreach ($taxes as $key => $tax) : ?>
              <option value="<?php echo $tax['id'] ?>"><?php echo $tax['name']. ' '. $tax['rate'] .'%'; ?></option>
            <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-lg-3"><?=l("Description", "core");?></label>
        <div class="col-lg-5">
          <input type="text" name="tax_rule[description]" id="description" value="" class="form-control">
        </div>
      </div>
      <div class="panel-subheading">
        <strong><?=l("RÈGLE DE TAXE", "core");?></strong>
      </div>
      <div class="col-sm-10 col-sm-offset-1">
        <table class="table bg-white">
          <thead>
            <tr>
              <th width="120"><?=l("Pays", "core");?></th>
              <th width="120"><?=l("Taxes", "core");?></th>
              <th><?=l("Description", "core");?></th>
              <th width="95"><?=l("Actions", "core");?></th>
            </tr>
          </thead>
          <tbody>
            <?php if( !empty($taxes_rules) ) : ?>
              <?php foreach ($taxes_rules as $key => $rule) : ?>
                <tr id="<?php echo $rule['id']; ?>">
                  <td id="<?php echo $rule['id_country']; ?>"><?php echo $rule['country']; ?></td>
                  <td id="<?php echo $rule['id_tax']; ?>"><?php echo $rule['rate']; ?> %</td>
                  <td class="description"><?php echo $rule['description']; ?></td>
                  <td>
                    <a href="javascript:;" class="btn btn-default edit_tax" title="<?=l("Modifier cette règle", "core");?>"><i class="fa fa-edit"></i></a>
                    <a href="?module=taxes_rules_group&action=edit&id=<?php echo $id_group; ?>&delete=<?php echo $rule['id']; ?>" class="btn btn-danger delete_tax" title="<?=l("Supprimer cette règle", "core");?>"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div><!--/ .col-sm-8  -->

		</div><!--/ .panel-body -->
		<div class="panel-footer">
			<button type="button" class="btn btn-default" onclick="window.location='?module=taxes_rules_group';"><?=l("Fermer", "core");?></button>
		  <button type="submit" name="<?= (isset($id_group) && $id_group > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?=l("Sauvegarder et rester", "core");?></button>
    </div><!--/ .panel-footer -->
	</div><!--/ .panel -->
</form>

<script>
$(document).ready(function(){
	//Bootstrap Switch
	$(".switch").bootstrapSwitch({onColor:'success','offColor':'danger'});

  //edit_tax
  $('.edit_tax').on('click', function(){
    var tr = $(this).closest('tr');
    var id_taxes_rules = tr.attr('id');
    var id_country = tr.find("td:nth-child(1)").attr('id');
    var id_tax = tr.find("td:nth-child(2)").attr('id');
    var description = tr.find('.description').text();
    $('#id_tax_rule').val(id_taxes_rules);
    $('#description').val(description);
    $('#countries option[value="'+id_country+'"]').prop('selected', true);
    $('#taxes option[value="'+id_tax+'"]').prop('selected', true);
    $('.edit_tax').val('<?=l("EDITION DE LA RÈGLE DE TAXE", "core");?>');
    //message de notif
    $.bootstrapGrowl("<?=l("Vous êtes en mode de modification de règle de taxe.", "core");?>" , {
      type: 'info',
      align: 'right',
    });
  });


});
</script>