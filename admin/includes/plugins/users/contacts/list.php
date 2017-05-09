<?php
global $common;
global $_CONFIG;
$id_lang = get_default_id_lang();
$contacts = $common->select(
  "contact c", 
  array("c.id", "c.email", "t.name", "t.description"), 
  "LEFT JOIN `"._DB_PREFIX_."contact_trans` t ON (t.`id_contact` = c.`id` AND t.`id_lang` = $id_lang) WHERE 1 ORDER BY c.`id` ASC"
);
?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-envelope"></i> <?=l("Contacts", "core");?></h3>
  </div>
  <div class="top-menu-button">
    <a href="?module=contacts&amp;action=add" class="btn btn-primary"><?=l("Ajouter un contact", "core");?></a>
  </div>
</div><br>

<div class="table-responsive">
  <table class="table table-bordered bg-white" id="datatable">
    <thead>
      <tr>
        <th><?=l("ID", "core");?></th>
        <th><?=l("Titre", "core");?></th>
        <th><?=l("Adresse e-mail", "core");?></th>
        <th><?=l("Description", "core");?></th>
        <th><?=l("Actions", "core");?></th>
      </tr>
    </thead>
    <tbody>
    <?php if( !empty($contacts) ) : ?>
      <?php foreach ($contacts as $key => $c) : ?>
      <tr>
        <td><?=$c['id'];?></td>
        <td><?=$c['name'];?></td>
        <td><?=$c['email'];?></td>
        <td><?=$c['description'];?></td>
        <td>
          <div class="btn-group-action">
            <div class="btn-group">
              <a class="btn btn-default" href="?module=contacts&amp;action=edit&amp;id=<?=$c['id'];?>" title="<?=l("Modifier", "core");?>"><i class="fa fa-pencil"></i> <?=l("Modifier", "core");?></a>
              <button class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="caret"></i>&nbsp;</button>
              <ul class="dropdown-menu">
                <li>
                  <a href="?module=contacts&action=delete&id=<?=$c['id'];?>" title="<?=l("Supprimer", "core");?>"><i class="fa fa-trash"></i> <?=l("Supprimer", "core");?></a>
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