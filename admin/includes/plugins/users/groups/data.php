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
function DELETE($ID)
{
  global $common;
  $common->delete('users_groups', 'WHERE id='.$ID);
  echo '<script>window.location.href="?module=groups"</script>';
}
//exit if delete action
if ( $_GET['action'] == "delete" ) return;

//get shop infos
if( isset($_GET['id']) && intval($_GET['id']) > 0 )
{
  global $common;
  $ug = $common->select('users_groups');
  $id_ug = $ug[0]['id'];
}
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-list"></i> <?=l("Groupe", "core");?></h3>
  </div>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" id="ug_form" method="post" action="ajax/users/groups/form.php">
  <div class="panel-heading"><?=l("Modifier le groupe", "core");?></div>
  <div class="panel-body">

    <input type="hidden" name="id_ug" value="<?=(isset($id_ug)) ? $id_ug : '0';?>" id="id_ug">
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Nom de groupe *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="name" id="name" value="<?=(isset($ug[0]['name'])) ? $ug[0]['name'] : "";?>" class="form-control" required autofocus>     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3" for="active"><?=l("Activé", "core");?></label>
      <div class="col-lg-4">
        <input type="checkbox" name="active" class="active" id="active" value="1" <?=(isset($ug[0]['active']) && $ug[0]['active']=="1") ? 'checked' : '';?> data-on-text="<?=l("OUI", "core");?>" data-off-text="<?=l("NON", "core");?>" />
      </div>
    </div>
    
  </div><!--/ .panel-body -->
  <div class="panel-footer">
    <a href="?module=groups" class="btn btn-default"><?=l("Fermer", "core");?></a>
    <input type="submit" class="btn btn-success pull-right" value="<?=l("Sauvegarder et rester", "core");?>">
  </div><!--/ .panel-footer -->
</form>
</div>

<script>
$(document).ready(function(){

  //manufactures form
  $("form#ug_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("ug_form", function(data) {
      if( data.id_ug ) $('#id_ug').val( data.id_ug );
      if( data.msg ) os_message_notif( data.msg );
    });
    return false;
  });

});
</script>