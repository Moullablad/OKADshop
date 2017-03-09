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
$id_lang = get_default_id_lang();
$feature = new OS_Features();
$position = $feature->get_feature_position();
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-plus-circle"></i> <?=l("Ajouter une caractéristique", "core");?></h3>
  </div>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" id="feature_form" method="post" action="ajax/features/form/add.php">
  <div class="panel-heading"><?=l("Caractéristique", "core");?></div>
  <div class="panel-body">

    <input type="hidden" name="position" value="<?=(isset($position)) ? $position : '1';?>" id="position">
    <div class="form-group">
      <label class="control-label col-lg-3" for="name"><?=l("Nom *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="name" id="name" value="" class="form-control" required autofocus>     
      </div>
      <div class="col-sm-2 left0" style="left:-4px;">
        <select name="id_lang" id="id_lang" class="form-control" style="width: auto;">
          <?php
          $languages = get_languages();
          if( !empty($languages) )
          {
            foreach ($languages as $key => $lang) {
              $selected = ($id_lang==$lang->id) ? "selected" : "";
              echo '<option value="'.$lang->id.'" '.$selected.'>'.$lang->name.'</option>';
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

  //feature form
  $("form#feature_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("feature_form", function(data) {
      if( data.msg ) os_message_notif( data.msg );
      window.location = '?module=features';
    });
    return false;
  });

});
</script>