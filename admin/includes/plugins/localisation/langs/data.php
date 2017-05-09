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
  $common->delete('langs', 'WHERE id='.$ID);
  echo '<script>window.location.href="?module=langs"</script>';
}
//exit if delete action
if ( $_GET['action'] == "delete" ) return;

//get shop infos
global $common;
$id_lang = isset($_GET['id']) ? intval($_GET['id']) : 0;
if( $id_lang > 0 )
{
  $lang = $common->select('langs', array('*'), "WHERE id=".$id_lang );
}
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-language"></i> <?=l("Langues", "core");?></h3>
  </div>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" id="lang_form" method="post" action="ajax/langs/form.php">
  <div class="panel-heading"><?=l("Langues", "core");?></div>
  <div class="panel-body">

    <input type="hidden" name="id_lang" value="<?=(isset($id_lang)) ? $id_lang : '0';?>" id="id_lang">
    <div class="form-group">
      <label class="control-label col-lg-3" for="name"><?=l("Nom *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="name" id="name" value="<?=(isset($lang[0]['name'])) ? $lang[0]['name'] : "";?>" class="form-control" required autofocus>     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3" for="short_name"><?=l("Short Name *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="short_name" id="short_name" value="<?=(isset($lang[0]['short_name'])) ? $lang[0]['short_name'] : "";?>" class="form-control" required>     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3" for="iso_code"><?=l("Code ISO *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="iso_code" id="iso_code" value="<?=(isset($lang[0]['iso_code'])) ? $lang[0]['iso_code'] : "";?>" class="form-control" required>     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3" for="code"><?=l("Code de langue *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="code" id="code" value="<?=(isset($lang[0]['code'])) ? $lang[0]['code'] : "";?>" class="form-control" required>     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3" for="date_format"><?=l("Format de date *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="date_format" id="date_format" value="<?=(isset($lang[0]['date_format']) && $lang[0]['date_format']!="") ? $lang[0]['date_format'] : "d/m/Y";?>" class="form-control" required>     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3" for="datetime_format"><?=l("Format de date (complet) *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="datetime_format" id="datetime_format" value="<?=(isset($lang[0]['datetime_format']) && $lang[0]['date_format']!="") ? $lang[0]['datetime_format'] : "d/m/Y H:i:s";?>" class="form-control" required>     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3" for="direction"><?=l("Langue Right-to-Left", "core");?></label>
      <div class="col-lg-4">
        <input type="checkbox" name="direction" class="active" id="direction" value="1" <?=(isset($lang[0]['direction']) && $lang[0]['direction']=="1") ? 'checked' : '';?> data-on-text="<?=l("OUI", "core");?>" data-off-text="<?=l("NON", "core");?>" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label"><?=l("Par défaut", "core");?></label> 
      <div class="col-sm-3">
        <input type="checkbox" name="default_lang" class="active" id="handling" data-on-text="<?=l("OUI", "core");?>" data-off-text="<?=l("NON", "core");?>" value="1" <?=(isset($lang[0]['default_lang']) && $lang[0]['default_lang']=="1") ? 'checked' : '';?>/>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3" for="active"><?=l("État", "core");?></label>
      <div class="col-lg-4">
        <input type="checkbox" name="active" class="active" id="active" value="1" <?=(isset($lang[0]['active']) && $lang[0]['active']=="1") ? 'checked' : '';?> data-on-text="<?=l("activé", "core");?>" data-off-text="<?=l("désactivé", "core");?>" />
      </div>
    </div>

  </div><!--/ .panel-body -->
  <div class="panel-footer">
    <a href="?module=langs" class="btn btn-default"><?=l("Fermer", "core");?></a>
    <input type="submit" class="btn btn-success pull-right" value="<?=l("Sauvegarder et rester", "core");?>">
  </div><!--/ .panel-footer -->
</form>
</div>

<script>
$(document).ready(function(){

  //manufactures form
  $("form#lang_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("lang_form", function(data) {
      if( data.msg ) os_message_notif( data.msg );
    });
    return false;
  });

});
</script>