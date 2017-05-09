<?php
global $common;
global $_CONFIG;
$id_lang = get_default_id_lang();
$features = $common->select(
  "features f", 
  array("f.id", "t.name", "f.position"), 
  "LEFT JOIN `"._DB_PREFIX_."feature_trans` t ON (t.`id_feature` = f.`id` AND t.`id_lang` = $id_lang) WHERE 1 ORDER BY f.`position` ASC"
);
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-magic"></i> <?=l("Caractéristiques", "core");?></h3>
  </div>
  <div class="top-menu-button">
    <a href="?module=features&amp;action=add" class="btn btn-primary"><?=l("Ajouter une caractéristique", "core");?></a>
    <a href="?module=feature_values&amp;action=add" class="btn btn-default"><?=l("Ajouter une valeur", "core");?></a>
  </div>
</div><br>

<div class="table-responsive">
  <table class="table table-bordered bg-white" id="datatable">
    <thead>
      <tr>
        <th><?=l("ID", "core");?></th>
        <th><?=l("Nom", "core");?></th>
        <th><?=l("Valeurs", "core");?></th>
        <th><?=l("Position", "core");?></th>
        <th><?=l("Actions", "core");?></th>
      </tr>
    </thead>
    <tbody>
    <?php if( !empty($features) ) : ?>
      <?php foreach ($features as $key => $feature) : ?>
      <tr>
        <td><?=$feature['id'];?></td>
        <td><?=$feature['name'];?></td>
        <td></td>
        <td><?=$feature['position'];?></td>
        <td>
          <div class="btn-group-action">
            <div class="btn-group">
              <a class="btn btn-default" href="?module=feature_values&amp;id_feature=<?=$feature['id'];?>" title="<?=l("Afficher", "core");?>"><i class="fa fa-search-plus"></i> <?=l("Afficher", "core");?></a>
              <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="caret"></i>&nbsp;</button>
              <ul class="dropdown-menu">
                <li>
                  <a href="?module=features&amp;action=edit&amp;id=<?=$feature['id'];?>" title="<?=l("Modifier", "core");?>"><i class="fa fa-pencil"></i> <?=l("Modifier", "core");?></a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="?module=features&action=delete&id=<?=$feature['id'];?>" title="<?=l("Supprimer", "core");?>"><i class="fa fa-trash"></i> <?=l("Supprimer", "core");?></a>
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