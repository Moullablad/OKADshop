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
$s = $common->select('shop', array('id', 'domain', 'domain_ssl', 'uri'));
$id_s = $s[0]['id'];
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-cogs"></i> <?=l("SEO & URL", "core");?></h3>
  </div>
</div><br>

<div class="panel panel-default">
<form class="form-horizontal" id="s_form" method="post" action="ajax/preferences/seo/form.php">
  <div class="panel-heading"><?=l("URL DE LA BOUTIQUE", "core");?></div>
  <div class="panel-body">

    <input type="hidden" name="id_s" value="<?=(isset($id_s)) ? $id_s : '0';?>" id="id_s">
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Domaine de la boutique *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="domain" id="domain" value="<?=(isset($s[0]['domain'])) ? $s[0]['domain'] : "";?>" class="form-control" required autofocus>     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Domaine SSL *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="domain_ssl" id="domain_ssl" value="<?=(isset($s[0]['domain_ssl'])) ? $s[0]['domain_ssl'] : "";?>" class="form-control" required>     
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-lg-3"><?=l("Chemin de base *", "core");?></label>
      <div class="col-lg-4">
        <input type="text" name="uri" id="uri" value="<?=(isset($s[0]['uri'])) ? $s[0]['uri'] : "";?>" class="form-control" required>     
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