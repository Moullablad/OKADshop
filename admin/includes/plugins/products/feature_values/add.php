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
global $_CONFIG;
global $common;
$id_lang = get_default_id_lang();
$features = $common->select("feature_trans", array('id_feature', 'name'), "WHERE id_lang=".$id_lang);
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-plus-circle"></i> <?=l("Ajouter une valeur", "core");?></h3>
  </div>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" id="value_form" method="post" action="ajax/features/values/form/add.php">
  <div class="panel-heading"><?=l("Valeur de caractéristique", "core");?></div>
  <div class="panel-body">

    <div class="form-group">
      <label class="control-label col-lg-3" for="id_feature"><?=l("Caractéristique *", "core");?></label>
      <div class="col-sm-3">
        <select name="id_feature" id="id_feature" class="form-control" required>
          <?php
          if( !empty($features) )
          {
            foreach ($features as $key => $feature) {
              echo '<option value="'.$feature['id_feature'].'">'.$feature['name'].'</option>';
            }
          }
          ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3" for="name"><?=l("Valeur *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="value" id="value" value="" class="form-control" required autofocus>     
      </div>
      <div class="col-sm-2 left0" style="left:-4px;">
        <select name="id_lang" id="id_lang" class="form-control" style="width: auto;">
          <?php
          $languages = $common->select("langs", array("id", "name"));
          if( !empty($languages) )
          {
            foreach ($languages as $key => $lang) {
              $selected = ($id_lang==$lang['id']) ? "selected" : "";
              echo '<option value="'.$lang['id'].'" '.$selected.'>'.$lang['name'].'</option>';
            }
          }
          ?>
        </select>
      </div>
    </div>

  </div><!--/ .panel-body -->
  <div class="panel-footer">
    <a href="?module=features" class="btn btn-default"><?=l("Fermer", "core");?></a>
    <input type="submit" class="btn btn-success pull-right" value="<?=l("Sauvegarder", "core");?>">
  </div><!--/ .panel-footer -->
</form>
</div>

<script>
$(document).ready(function(){

  //manufactures form
  $("form#value_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("value_form", function(data) {
      if( data.msg ) os_message_notif( data.msg );
      if( data.id_feature ){
        window.location = '?module=feature_values&id_feature='+data.id_feature;
      }
    });
    return false;
  });

});
</script>