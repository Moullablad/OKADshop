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
  $common->delete('manufacturers', 'WHERE id='.$ID);
  echo '<script>window.location.href="?module=manufacturers"</script>';
}
//exit if delete action
if ( $_GET['action'] == "delete" ) return;

//we have id_manufacturers in url
if ( !empty($_GET['id']) && intval($_GET['id']) > 0 )
{
  global $common;
  $id_m = intval($_GET['id']);
  $m = $common->select('manufacturers', array('*'), "WHERE id=".$id_m);
}

?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-industry"></i> <?=l("Fabricants", "core");?></h3>
  </div>
  <a href="?module=manufacturers" class="btn btn-primary pull-right"><?=l("Liste des Fabricants", "core");?></a>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" id="m_form" method="post" action="ajax/manufacturers/form.php">
  <div class="panel-heading"><?=l("Nouveau Fabricant", "core");?></div>
  <div class="panel-body">

    <input type="hidden" name="id_m" value="<?=(isset($id_m)) ? $id_m : '0';?>" id="id_m">
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Nom *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="name" id="name" value="<?=(isset($m[0]['name'])) ? $m[0]['name'] : "";?>" class="form-control" required autofocus>     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Résumé", "core");?></label>
      <div class="col-lg-6">
        <textarea name="short_description" class="form-control summernote" id="short_description" placeholder=""><?=(isset($m[0]['short_description'])) ? $m[0]['short_description'] : "";?></textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Description", "core");?></label>
      <div class="col-lg-6">
        <textarea name="description" class="form-control summernote" id="description" placeholder=""><?=(isset($m[0]['description'])) ? $m[0]['description'] : "";?></textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Logo", "core");?></label>
      <div class="col-sm-3">
        <input type="file" name="logo" class="attachement" id="attachement">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-2 col-sm-offset-3" id="m_logo">
        <?php 
        if( isset($m[0]['logo']) && $m[0]['logo'] != "" ){
          echo '<img src="../files/m/'.$m[0]['logo'].'" class="img-thumbnail" width="150">';
        }
        ?>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Balise titre", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="meta_title" id="meta_title" value="<?=(isset($m[0]['meta_title'])) ? $m[0]['meta_title'] : "";?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Meta description", "core");?></label>
      <div class="col-lg-6">
         <textarea rows="1" name="meta_description" class="form-control" id="meta_description" placeholder=""><?=(isset($m[0]['meta_description'])) ? $m[0]['meta_description'] : "";?></textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Meta mots-clés", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="meta_keywords" id="tags" value="<?=(isset($m[0]['meta_keywords'])) ? $m[0]['meta_keywords'] : "";?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Activer", "core");?></label>
      <div class="col-lg-4">
        <input type="checkbox" name="active" class="active" id="active" value="1" <?=(isset($m[0]['active']) && $m[0]['active']=="1") ? 'checked' : '';?> data-on-text="<?=l("activé", "core");?>" data-off-text="<?=l("désactivé", "core");?>" />
      </div>
    </div>

  </div><!--/ .panel-body -->
  <div class="panel-footer">
    <a href="?module=manufacturers" class="btn btn-default"><?=l("Fermer", "core");?></a>
    <input type="submit" class="btn btn-success pull-right" value="<?=l("Sauvegarder et rester", "core");?>">
  </div><!--/ .panel-footer -->
</form>
</div>

<script>
$(document).ready(function(){

  //manufactures form
  $("form#m_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("m_form", function(data) {
      if( data.logo ){
        var image = '<img src="../files/m/'+ data.logo +'" class="img-thumbnail" width="150">';
        $('#m_logo').empty().append(image);
      } 
      if( data.id_m ) $('#id_m').val( data.id_m );
      if( data.msg ) os_message_notif( data.msg );
    });
    return false;
  });

});
</script>