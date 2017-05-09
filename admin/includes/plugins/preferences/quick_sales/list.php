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
function ADD(){}
function EDIT($ID){}
function DELETE($ID){}

//exit if delete action
if ( $_GET['action'] == "delete" ) return;

//get shop infos
global $common;
$qs = $common->select('meta_value', array('id', 'name', 'value'), "WHERE name='os_quick_sales'");
$id_qs = $qs[0]['id'];
if( empty($qs) ){
  $common->save('meta_value', array('name' => 'os_quick_sales'));
}

//os_quick_sales_active
$qs_active = $common->select('meta_value', array('id', 'name', 'value'), "WHERE name='os_quick_sales_active'");
if( empty($qs_active) ){
  $common->save('meta_value', array('name' => 'os_quick_sales_active', 'value' => '0'));
}
$active = $qs_active[0]['value'];
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-home"></i> <?=l("Ventes flash", "core");?></h3>
  </div>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" id="qs_form" method="post" action="ajax/quick_sales/form.php">
  <div class="panel-heading"><?=l("Ventes flash", "core");?></div>
  <div class="panel-body">

    <input type="hidden" name="id_qs" value="<?=(isset($id_qs)) ? $id_qs : '0';?>" id="id_qs">
    
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Contenu de Ventes flash", "core");?></label>
      <div class="col-lg-6">
        <textarea rows="4" name="value" class="summernote" id="value" placeholder=""><?=(isset($qs[0]['value'])) ? $qs[0]['value'] : "";?></textarea>   
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3" for="active"><?=l("Activé", "core");?></label>
      <div class="col-lg-4">
        <input type="checkbox" name="active" class="active" id="active" value="1" <?=(isset($active) && $active=="1") ? 'checked' : '';?> data-on-text="<?=l("OUI", "core");?>" data-off-text="<?=l("NON", "core");?>" />
      </div>
    </div>

  </div><!--/ .panel-body -->
  <div class="panel-footer">
    <a href="?module=stores" class="btn btn-default"><?=l("Fermer", "core");?></a>
    <input type="submit" class="btn btn-success pull-right" value="<?=l("Sauvegarder et rester", "core");?>">
  </div><!--/ .panel-footer -->
</form>
</div>

<script>
$(document).ready(function(){

  //manufactures form
  $("form#qs_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("qs_form", function(data) {
      if( data.msg ) os_message_notif( data.msg );
    });
    return false;
  });

});
</script>