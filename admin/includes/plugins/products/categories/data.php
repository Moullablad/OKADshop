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
  $common->delete('categories', 'WHERE id='.$ID);
  echo '<script>window.location.href="?module=categories"</script>';
}
//exit if delete action
if ( $_GET['action'] == "delete" ) return;

global $common;
//we have id_canufacturers in url
if ( !empty($_GET['id']) && intval($_GET['id']) > 0 )
{
  $id_c = intval($_GET['id']);
  $c = $common->select('categories', array('*'), "WHERE id=".$id_c);
}
//categories list
$categories = $common->select('categories', array('id', 'name'));

?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-sitemap"></i> <?=l("Catégorie", "core");?></h3>
  </div>
  <a href="?module=categories" class="btn btn-primary pull-right"><?=l("Liste des Catégories", "core");?></a>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" id="c_form" method="post" action="ajax/categories/form.php">
  <div class="panel-heading"><?=( isset($id_c) ) ? l("Modifier la Catégorie", "core") : l("Nouvelle Catégorie", "core");?></div>
  <div class="panel-body">

    <input type="hidden" name="id_c" value="<?=(isset($id_c)) ? $id_c : '0';?>" id="id_c">
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Nom *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="name" id="name" value="<?=(isset($c[0]['name'])) ? $c[0]['name'] : "";?>" class="form-control" required autofocus>     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Catégorie Parent *", "core");?></label>
      <div class="col-lg-4">
        <select name="parent" class="form-control" id="parent">
        <!--option value="0"><?//=l("Accueil", "core");?></option-->
        <?php
        if( !empty($categories) )
        {
          $id_current_c = intval($_GET['id']);
          foreach ($categories as $key => $category) {
            if( $category["id"] != $id_current_c )
            {
              $selected = (isset($c[0]['parent']) && $c[0]['parent'] == $category["id"]) ? "selected" : "";
              echo '<option value="'.$category["id"].'" '.$selected.'>'. l( $category["name"], "core") .'</option>';
            }
          }
        }
        ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Affichée", "core");?></label>
      <div class="col-lg-4">
        <input type="checkbox" name="hidden" class="active" id="hidden" value="0" <?=(isset($c[0]['hidden']) && $c[0]['hidden']=="0") ? 'checked' : '';?> data-on-text="<?=l("OUI", "core");?>" data-off-text="<?=l("NON", "core");?>" />
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Description", "core");?></label>
      <div class="col-lg-6">
        <textarea name="description" class="form-control summernote" id="description"><?=(isset($c[0]['description'])) ? $c[0]['description'] : "";?></textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Image de la catégorie", "core");?></label>
      <div class="col-sm-3">
        <input type="file" name="image_cat" class="attachement" id="attachement">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-2 col-sm-offset-3" id="c_logo">
        <?php 
        if( isset($c[0]['image_cat']) && $c[0]['image_cat'] != "" ){
          echo '<img src="'. category_image($id_c, '226x55') .'" class="img-thumbnail" width="226">';
        }
        ?>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Balise titre", "core");?></label>
      <div class="col-lg-6">
        <input type="text" name="meta_title" id="meta_title" value="<?=(isset($c[0]['meta_title'])) ? $c[0]['meta_title'] : "";?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Meta description", "core");?></label>
      <div class="col-lg-6">
        <textarea rows="3" name="meta_description" class="form-control" id="meta_description" placeholder=""><?=(isset($c[0]['meta_description'])) ? $c[0]['meta_description'] : "";?></textarea>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Meta mots-clés", "core");?></label>
      <div class="col-lg-6">
        <input type="text" name="meta_keywords" id="tags" value="<?=(isset($c[0]['meta_keywords'])) ? $c[0]['meta_keywords'] : "";?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("URL simplifiée", "core");?></label>
      <div class="col-lg-6">
        <input type="text" name="permalink" id="permalink" value="<?=(isset($c[0]['permalink'])) ? $c[0]['permalink'] : "";?>" class="form-control" required>     
      </div>
    </div>

  </div><!--/ .panel-body -->
  <div class="panel-footer">
    <a href="?module=categories" class="btn btn-default"><?=l("Fermer", "core");?></a>
    <input type="submit" class="btn btn-success pull-right" value="<?=l("Sauvegarder et rester", "core");?>">
  </div><!--/ .panel-footer -->
</form>
</div>

<script>
$(document).ready(function(){

  //manufactures form
  $("form#c_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("c_form", function(data) {
      if( data.image_cat ){
        var image = '<img src="../files/category/'+ data.image_cat +'" class="img-thumbnail" width="150">';
        $('#c_logo').empty().append(image);
      } 
      if( data.id_c ) $('#id_c').val( data.id_c );
      if( data.msg ) os_message_notif( data.msg );
    });
    return false;
  });

});
</script>