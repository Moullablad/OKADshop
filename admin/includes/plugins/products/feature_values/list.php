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

global $common;
global $_CONFIG;
$id_lang = get_default_id_lang();
$id_feature = (isset($_GET['id_feature'])) ? intval($_GET['id_feature']) : 0;
if( $id_feature == 0 ) echo '<script>window.location.href="?module=features"</script>';
$values = $common->select(
  "feature_value v", 
  array("vt.id", "vt.value", "vt.id_value" , "v.id_feature"), 
  "LEFT JOIN `"._DB_PREFIX_."feature_value_trans` vt ON (vt.`id_value` = v.`id` AND vt.`id_lang` = $id_lang) WHERE v.`id_feature`=$id_feature ORDER BY vt.`id` ASC"
);
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-th-list"></i> <?=l("Properties", "core");?></h3>
  </div>
  <div class="top-menu-button">
    <a href="?module=feature_values&amp;action=add" class="btn btn-primary"><?=l("Ajouter une valeur", "core");?></a>
    <a href="?module=features" class="btn btn-default"><?=l("Fermer", "core");?></a>
  </div>
</div><br>

<div class="table-responsive">
  <table class="table table-bordered bg-white" id="datatable">
    <thead>
      <tr>
        <th><?=l("ID", "core");?></th>
        <th><?=l("Valeur", "core");?></th>
        <th><?=l("Actions", "core");?></th>
      </tr>
    </thead>
    <tbody>
    <?php if( !empty($values) ) : ?>
      <?php foreach ($values as $key => $value) : ?>
      <tr>
        <td><?=$value['id'];?></td>
        <td><?=$value['value'];?></td>
				<td>
          <div class="btn-group-action">
            <div class="btn-group">
              <a class="btn btn-default" href="?module=feature_values&amp;action=edit&amp;id=<?=$value['id'];?>&amp;id_feature=<?=$value['id_feature'];?>" title="<?=l("Modifier", "core");?>"><i class="fa fa-pencil"></i> <?=l("Modifier", "core");?></a>
              <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="caret"></i>&nbsp;</button>
              <ul class="dropdown-menu">
                <li>
                  <a href="?module=feature_values&amp;action=delete&amp;id=<?=$value['id'];?>&amp;id_value=<?=$value['id_value'];?>&amp;id_feature=<?=$value['id_feature'];?>" title="<?=l("Supprimer", "core");?>"><i class="fa fa-trash"></i> <?=l("Supprimer", "core");?></a>
                </li>
              </ul>
            </div>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
</div>