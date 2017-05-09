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
  $common->delete('shop', 'WHERE id='.$ID);
  echo '<script>window.location.href="?module=stores"</script>';
}
//exit if delete action
if ( $_GET['action'] == "delete" ) return;

//get shop infos
global $common;
$s = $common->select('shop');
$id_s = $s[0]['id'];
if( empty($s) ) return;
$countries = $common->select('countries', array('id', 'name'));




//var_dump( unserialize($_COOKIE['shop']));
//var_dump( $_COOKIE['stest']);
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-home"></i> <?=l("Coordonnées et magasins", "core");?></h3>
  </div>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" id="s_form" method="post" action="ajax/stores/form.php">
  <!--div class="panel-heading"><?//=l("Coordonnées", "core");?></div-->
  <div class="panel-body" style="padding-top: 0px;">

    <input type="hidden" name="id_s" value="<?=(isset($id_s)) ? $id_s : '0';?>" id="id_s">


    <div class="panel-subheading">
      <i class="fa fa-info-circle"></i>
      <strong>Shop contact details</strong>
    </div>


    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Nom de la boutique *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="name" id="name" value="<?=(isset($s[0]['name'])) ? $s[0]['name'] : "";?>" class="form-control" required autofocus>     
      </div>
    </div>

    
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Adresse e-mail *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="email" id="email" value="<?=(isset($s[0]['email'])) ? $s[0]['email'] : "";?>" class="form-control" required>     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("description", "core");?></label>
      <div class="col-lg-6">
        <textarea rows="4" name="description" class="form-control" id="description" placeholder=""><?=(isset($s[0]['description'])) ? $s[0]['description'] : "";?></textarea>   
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Adresse du magasin (ligne 1)", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="address1" id="address1" value="<?=(isset($s[0]['address1'])) ? $s[0]['address1'] : "";?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Adresse du magasin (ligne 2)", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="address2" id="address2" value="<?=(isset($s[0]['address2'])) ? $s[0]['address2'] : "";?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Code postal", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="zip_code" id="zip_code" value="<?=(isset($s[0]['zip_code'])) ? $s[0]['zip_code'] : "";?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Ville", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="city" id="city" value="<?=(isset($s[0]['city'])) ? $s[0]['city'] : "";?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Pays", "core");?></label>
      <div class="col-lg-4">
        <select name="id_country" class="form-control" id="id_country">
          <option value="0" style="font-weight: bold"><?=l("Sélectionnez un pays", "core");?></option>
          <?php 
          if( !empty($countries) )
          {
            foreach ($countries as $key => $country) {
            	$selected = (isset($s[0]['id_country']) && $s[0]['id_country']==$country['id']) ? "selected" : "";
              echo '<option value="'.$country['id'].'" '. $selected .'>'. l( $country['name'], "admin" ) .'</option>';
            }
          } 
          ?>
        </select>    
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Téléphone", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="phone" id="phone" value="<?=(isset($s[0]['phone'])) ? $s[0]['phone'] : "";?>" class="form-control">     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Fax", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="fax" id="fax" value="<?=(isset($s[0]['fax'])) ? $s[0]['fax'] : "";?>" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Immatriculation", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="immatriculation" id="immatriculation" value="<?=(isset($s[0]['immatriculation'])) ? $s[0]['immatriculation'] : "";?>" class="form-control">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("GPS coordinates", "core");?></label>
      <div class="col-lg-2 col-sm-3">
        <input placeholder="33.968198" type="text" name="latitude" id="latitude" value="<?=(isset($s[0]['latitude'])) ? $s[0]['latitude'] : "";?>" class="form-control">
      </div>
      <div class="col-lg-2 col-sm-3">
        <input placeholder="-6.860241" type="text" name="longitude" id="longitude" value="<?=(isset($s[0]['longitude'])) ? $s[0]['longitude'] : "";?>" class="form-control">
      </div>
    </div>


    <div class="panel-subheading">
      <i class="fa fa-line-chart"></i>
      <strong>Shop SEO</strong>
    </div>

    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("meta description", "core");?></label>
      <div class="col-lg-6">
        <textarea rows="4" name="meta_description" class="form-control" id="meta_description" placeholder=""><?=(isset($s[0]['meta_description'])) ? $s[0]['meta_description'] : "";?></textarea>   
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("meta keywords", "core");?></label>
      <div class="col-lg-6">
        <textarea rows="4" name="meta_keywords" class="form-control" id="" placeholder=""><?=(isset($s[0]['meta_keywords'])) ? $s[0]['meta_keywords'] : "";?></textarea> 
      </div>
    </div>

     <div class="form-group">
      <label class="control-label col-lg-3"><?=l("meta static", "core");?></label>
      <div class="col-lg-6">
        <textarea rows="4" name="meta_static" class="form-control" id="meta_static" placeholder=""><?=(isset($s[0]['meta_static'])) ? $s[0]['meta_static'] : "";?></textarea>   
      </div>
    </div>

    <div class="panel-subheading">
      <i class="fa fa-map-signs"></i>
      <strong>Shop URLS</strong>
    </div>

    <div class="form-group">
      <label class="control-label col-lg-3" for="ssl_active"><?=l("SSL Active", "core");?></label>
      <div class="col-lg-4">
        <input type="checkbox" name="ssl_active" class="active" id="ssl_active" value="1" <?=(isset($s[0]['ssl_active']) && $s[0]['ssl_active']=="1") ? 'checked' : '';?> data-on-text="<?=l("YES", "core");?>" data-off-text="<?=l("NO", "core");?>" />
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
  $("form#s_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("s_form", function(data) {
      if( data.msg ) os_message_notif( data.msg );
    });
    return false;
  });

});
</script>