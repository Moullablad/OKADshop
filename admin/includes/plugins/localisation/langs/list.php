<?php
$Args = array(
  'Select' => array(
    'id' => 'id',
    'name' => 'name',
    'iso_code' => 'iso_code',
    'code' => 'code',
    'active' => 'active',
    'default_lang' => 'default_lang',
  ),
  'From' => array( _DB_PREFIX_.'langs'),
  'Join' => array(),
  'Module'=> array('langs','Liste des Langues'),
  'Operations' => array('edit','delete'),
  'THead' => array(
    l("ID", "core"),
    l("Nom", "core"),
    l("Code ISO", "core"),
    l("Code de langue", "core"),
    l("Activé", "core"),
    l("Default", "core"),
    l("Operations", "core")
  ),
  'Butons' => array(
    array( l("Ajouter une Langue", "core"),'?module=langs&action=add','add_nw','add button',l("Ajouter une Langue", "core"),'facebox','iconAdd')
  ),
  'UPLOADFIELDS' => array()
  );
$Tables = new Core\Table();
$DATATABLE = $Tables->GET($Args);
?>
  