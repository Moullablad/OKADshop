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
global $common;
$c_data = $common->select(
  "contact c", 
  array("c.id", "c.email", "c.save_msg", "t.name", "t.description"), 
  "LEFT JOIN `"._DB_PREFIX_."contact_trans` t ON (t.`id_contact` = c.`id` AND t.`id_lang` = $id_lang) WHERE c.`id`=$ID ORDER BY c.`id` ASC"
);
//prepare langs
$options = "";
$languages = $common->select("langs", array("id", "name"));
if( !empty($languages) )
{
  foreach ($languages as $key => $lang) {
    $selected = ($id_lang==$lang['id']) ? "selected" : "";
    $options .= '<option value="'.$lang['id'].'" '.$selected.'>'.$lang['name'].'</option>';
  }
}
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-plus-circle"></i> <?=l("Ajouter un Contact", "core");?></h3>
  </div>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" id="contact_form" method="post" action="ajax/users/contacts/edit.php">
  <div class="panel-heading"><?=l("Contacts", "core");?></div>
  <div class="panel-body">
  

  <input type="hidden" name="id_contact" value="<?=$ID;?>" id="id_contact">

    <div class="form-group">
      <label class="control-label col-lg-3" for="name"><?=l("Titre *", "core");?></label>
      <div class="col-sm-3">
        <input type="text" name="name" id="name" value="<?=$c_data[0]['name'];?>" class="form-control" required autofocus>     
      </div>
      <div class="col-sm-2 left0" style="left:-4px;">
        <select name="id_lang" id="id_lang" class="form-control current_lang" style="width: auto;">
          <?=$options;?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3" for="email"><?=l("Adresse e-mail", "core");?></label>
      <div class="col-sm-5">
        <input type="text" name="email" id="email" value="<?=$c_data[0]['email'];?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3" for="save_msg"><?=l("Enregistrer les messages ?", "core");?></label>
      <div class="col-lg-4">
        <input type="checkbox" name="save_msg" class="active" id="save_msg" value="1" <?=(isset($c_data[0]['save_msg']) && $c_data[0]['save_msg']=="1") ? 'checked' : '';?> data-on-text="<?=l("OUI", "core");?>" data-off-text="<?=l("NON", "core");?>" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3" for="description"><?=l("Description *", "core");?></label>
      <div class="col-sm-6">
        <textarea name="description" rows="5" id="description" class="form-control"><?=$c_data[0]['description'];?></textarea>  
      </div>
      <div class="col-sm-2 left0" style="left:-4px;">
        <select id="id_lang" class="form-control current_lang" style="width: auto;">
          <?=$options;?>
        </select>
      </div>
    </div>

    

  </div><!--/ .panel-body -->
  <div class="panel-footer">
    <a href="?module=contacts" class="btn btn-default"><?=l("Fermer", "core");?></a>
    <input type="submit" class="btn btn-success pull-right" value="<?=l("Sauvegarder", "core");?>">
  </div><!--/ .panel-footer -->
</form>
</div>

<script>
$(document).ready(function(){

  //feature form
  $("form#contact_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("contact_form", function(data) {
      if( data.msg ) os_message_notif( data.msg );
      //window.location = '?module=contacts';
    });
    return false;
  });


  //load contact trans
  $(".current_lang").on("change", function(){
    var current = $(this).find('option:selected').val();
    $(".current_lang option[value='"+current+"']").prop("selected", true);
    $.ajax({
      type: "POST",
      url: 'ajax/users/contacts/contact-trans.php',
      data: {id_lang:$(this).val(), id_contact:$("#id_contact").val()},
      success: function(data){
        var obj = $.parseJSON( data );
        $("input#name").val( obj.name );
        $("textarea#description").val( obj.description );
      }
    });
  });



});
</script>