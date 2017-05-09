<?php
//modules filter
global $hooks;
$hooks->load_inactive_modules();

//module filter
$get_args = array(
  'name'      => 'keywords', 
  'author'    => 'author', 
  'category'  => 'category', 
  'installed' => 'installed', 
  'active'    => 'active'
);
$args = array();
foreach ($get_args as $key => $value) {
  if( isset($_GET[ $value ]) ){
    if( !empty($_GET[ $value ]) || $_GET[ $value ] == "0" ){
      $args[ $key ] = $_GET[ $value ];
    }
  }
}

$modules_array = $hooks->modules_filter( $hooks->modules_infos, $args);

//categories
$modules = new modules();
$categories = $modules->getModuleCategories();


/*echo '<pre>';
print_r($modules_array);
echo '</pre>';*/
?>
<style>
#categories .list-group {
  border-radius: 0px;
  margin-bottom: 0px;
  margin: -15px 0px -10px -15px;
  border: 0px;
  border-right: 1px solid #000;
}

#categories .list-group-item.active, 
#categories .list-group-item.active:focus, 
#categories .list-group-item.active:hover {
  border-radius: 0px;
}

#categories .list-group-item:first-child {
  border-top-left-radius: 0px;
  border-top-right-radius: 0px;
  border-bottom: 2px solid #000;
}

/* filter form */
#filter{
  background-color: #fff;
  min-height: 55px;
  padding: 10px;
  border-bottom: 2px solid #dedede;
  margin-bottom: 10px;
}

#filter .btn {
  padding: 7px 15px;
}

/* table */
#modules .table-bordered>tbody>tr>td{
  border-right: 0px none;
  border-left: 0px none;
}

#modules .table-bordered>tbody>tr>td:first-child{
  border-right: 1px solid #ddd;
}

#modules .table {
  margin-top: 10px;
}

/* check all */
#checkall {
  padding: 5px 8px;
  cursor: pointer;
}
</style>

<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-puzzle-piece"></i> <?=l("Liste des Modules", "core");?></h3>
  </div>
  <!--div class="top-menu-button">
    <button type="button" class="btn btn-primary"><?php //echo _("Add a new module", "core");?></button>
  </div-->
</div><br>

<section id="filter">
  <form id="filterForm" method="get" name="filterForm">
    <input type="hidden" name="module" value="modules">
    <input type="hidden" value="<?=( isset($_GET['category']) ) ? $_GET['category'] : '';?>" name="category">
    <div class="col-sm-3 left0">
      <select class="form-control" id="install_filter" name="installed">
        <option value="" selected><?=l("Installés et non installés", "core");?></option>
        <option value="1" <?=(isset($_GET['installed']) && $_GET['installed'] == "1") ? "selected" : ""; ?>><?=l("Modules installés", "core");?></option>
        <option value="0" <?=(isset($_GET['installed']) && $_GET['installed'] == "0") ? "selected" : ""; ?>><?=l("Modules non installés", "core");?></option>
      </select>
    </div>
    <div class="col-sm-3 left0">
      <select class="form-control" id="status_filter" name="active">
        <option value="" selected><?=l("Activés &amp; désactivés", "core");?></option>
        <option value="1" <?=(isset($_GET['active']) && $_GET['active'] == "1") ? "selected" : ""; ?>><?=l("Modules activés", "core");?></option>
        <option value="0" <?=(isset($_GET['active']) && $_GET['active'] == "0") ? "selected" : ""; ?>><?=l("Modules désactivés", "core");?></option>
      </select>
    </div>
    <div class="col-sm-2 left0">
      <select class="form-control" id="author" name="author">
        <option value=""><?=l("Tous les Auteurs", "core");?></option>
        <?php 
        $authors = $hooks->modules_authors();
        foreach ($authors as $key => $name) {
          $selected = ( isset($_GET['author']) && $_GET['author'] == $name ) ? "selected" : "";
          echo '<option value="'. $name .'"  '. $selected .'>'. $name .'</option>';
        }
        ?>
      </select>
    </div>
    <div class="col-sm-4 left0 right0">
      <div class="input-group">
      <input autocomplete="off" class="form-control" id="keywords" name="keywords" placeholder="<?=l("Rechercher...", "core");?>" type="text" value="<?=isset($_GET['keywords']) ? $_GET['keywords'] : '';?>">
      <span class="input-group-btn" style="vertical-align: bottom;">
        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
      </span>
      </div>
    </div>
  </form>
</section><!--/ section -->


<section id="modules_directory">
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="col-sm-3 left0" id="categories">
        <div class="list-group">
          <?php if(!empty($categories)) : ?>
            <a onclick="extend_search('category', '');return false" class="list-group-item <?=( !isset($_GET['category']) || empty($_GET['category']) ) ? 'active' : '';?>" href="javascrip:;"><?=l("Tous les Modules", "core");?></a>
            <?php foreach ($categories as $key => $category) : ?>
              <a onclick="extend_search('category', '<?=$category['slug'];?>');return false" class="list-group-item <?=( isset($_GET['category']) && $_GET['category'] == $category['slug'] ) ? 'active' : '';?>" href="javascrip:;" id="<?php echo $category['slug'];?>">
                <?php echo $category['name'];?>
                <span class="badge pull-right"><?php echo $modules->countModulesInCategory($category['id']); ?></span>
              </a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div><!--/ #categories -->

      <div class="col-sm-9 left0 right0" id="modules">
        <!-- action group -->
        <span class="btn btn-default" id="checkall">
          <input type="checkbox" name="checkall">
        </span>
        <div class="btn-group">
          <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button"><?=l("actions groupées", "core");?><span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><a href="javascript:;" class="bulk_install"><i class="fa fa-plus-square"></i>&nbsp; <?=l("Installer la sélection", "core");?></a></li>
            <li><a href="javascript:;" class="bulk_uninstall"><i class="fa fa-minus-square"></i>&nbsp; <?=l("Désinstaller la sélection", "core");?></a></li>
            <li class="divider"></li>
            <li><a href="javascript:;" class="bulk_enable"><i class="fa fa-power-off"></i>&nbsp; <?=l("Activer la sélection", "core");?></a></li>
            <li><a href="javascript:;" class="bulk_disable"><i class="fa fa-power-off"></i>&nbsp; <?=l("Disactiver la sélection", "core");?></a></li>
            <li class="divider"></li>
            <li><a href="javascript:;" class="bulk_delete"><i class="fa fa-trash"></i>&nbsp; <?=l("Supprimer la sélection", "core");?></a></li>
          </ul>
        </div>
        <table class="table table-striped table-bordered">
          <tbody>

          <?php 
          if(isset($modules_array) && !empty($modules_array)) : ?>
            <?php foreach ($modules_array as $key => $module) : ?>
              <tr data-slug="<?php echo $key;?>">
                <td class="text-center" style="width: 1%;">
                  <input class="slug" type="checkbox" value="<?php echo $key;?>">
                </td>
                <td style="width:73px;">
                  <?php 
                    $img = "../modules/".$key.'/screenshot.png'; 
                    if( file_exists( $img ) ){
                      $img = "../modules/".$key.'/screenshot.png'; 
                    }else{
                      $img = 'assets/images/screenshot.png';
                    }
                  ?>
                  <img src="<?php echo $img;?>" title="" width="60">
                </td>
                <td>
                  <div>
                    <div class="text-muted"><?= (isset($module['category'])) ? $module['category'] : ' [N-A] ';?></div>
                    <div class="module_name">
                      <?= (isset($module['name'])) ? $module['name'] : ' [N-A] ';?>
                      <small class="text-muted">v<?= (isset($module['version'])) ? $module['version'] : ' [N-A] ';?> - par <?= (isset($module['author'])) ? $module['author'] : ' [N-A] ';?></small>
                    </div>
                    <p><?= (isset($module['description'])) ? $module['description'] : '';?></p>
                  </div>
                </td>
                <td class="actions">
                  <div class="btn-group-action">
                    <div class="btn-group pull-right">
                      <?php if( $module['installed'] == 1 ) : ?>
                        <?php if( $module['active'] == 1 ) : ?>
                          <?php if( isset($module['config']) && $module['config'] != "" ) : ?>
                            <a class="btn btn-info config" href="<?php echo '?module=modules&slug='. $key .'&page='. $module['config']; ?>"><i class="fa fa-cogs"></i> <?=l("Configuration", "core");?></a>
                          <?php else : ?>
                            <a class="btn btn-default disable" href="javascript:;"><i class="fa fa-power-off"></i> <?=l("Désactiver", "core");?></a>
                          <?php endif; ?>
                        <?php elseif( $module['active'] == 0 ) : ?>
                          <a class="btn btn-default enable" href="javascript:;"><i class="fa fa-power-off"></i> <?=l("Activer", "core");?></a>
                        <?php endif; ?>
                      <?php elseif( $module['installed'] == 0 ) : ?>
                        <a class="btn btn-success install" href="javascript:;"><i class="fa fa-cog"></i> <?=l("Installer", "core");?></a>
                      <?php endif; ?>
                      <!-- Buttons -->
                      <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button"><span class="caret">&nbsp;</span></button>
                      <ul class="dropdown-menu">
                        <?php if( isset($module['config']) && $module['config'] != "" ) : ?>
                          <li><a class="disable" href="javascript:;"><i class="fa fa-power-off"></i> <?=l("Désactiver", "core");?></a></li>
                          <li class="divider"></li>
                        <?php endif; ?>
                        <?php if( $module['installed'] == 1 ) : ?>
                          <li><a href="javascript:;" class="uninstall"><i class="fa fa-minus-square"></i> <?=l("Désinstaller", "core");?></a></li>
                          <li class="divider"></li>
                        <?php endif; ?>
                        <!--li><a href="javascript:;" class="favorite"><i class="fa fa-star"></i> Ajouter aux favoris</a></li-->
                        <li><a href="javascript:;" class="delete"><i class="fa fa-trash"></i> <?=l("Supprimer", "core");?></a></li>
                      </ul>
                    </div>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="3">
                <center><strong><?=l("No Module found.", "core");?></strong></center>
              </td>
            </tr>
          <?php endif; ?>
          </tbody>
        </table>      
      </div><!--/ #modules -->
    </div><!--/ .panel-body -->
  </div><!--/ .panel -->
</section><!--/ #modules_directory -->


<script>
//submit form to filter modules
$("#install_filter, #status_filter, #author").on("change", function() {
  $("#filterForm").submit();
});

//Install module
$('.actions').on('click', '.install', function(){
  var tr = $(this).closest('tr');
  var slug = tr.attr('data-slug');
  $.ajax({
    type: "POST",
    url: 'ajax/modules/module_install.php',
    data: {slug:slug},
    success: function(data){
      location.reload();
    }
  });
});

//uninstall module
$('.actions').on('click', '.uninstall', function(){
  var tr = $(this).closest('tr');
  var slug = tr.attr('data-slug');
  $.ajax({
    type: "POST",
    url: 'ajax/modules/module_uninstall.php',
    data: {slug:slug},
    success: function(data){
      location.reload();
    }
  });
});

//uninstall module
$('.actions').on('click', '.delete', function(){
  var choice = confirm('<?=l("Cette action supprime définitivement le module sur votre serveur. Êtes-vous vraiment sûr ?", "core");?>');
  if (choice == false) return;
  var tr = $(this).closest('tr');
  var slug = tr.attr('data-slug');
  $.ajax({
    type: "POST",
    url: 'ajax/modules/module_delete.php',
    data: {slug:slug},
    success: function(data){
      location.reload();
    }
  });
});

//Enable module
$('.actions').on('click', '.enable', function(){
  var tr = $(this).closest('tr');
  var slug = tr.attr('data-slug');
  $.ajax({
    type: "POST",
    url: 'ajax/modules/module_enable.php',
    data: {slug:slug},
    success: function(data){
      location.reload();
    }
  });
});

//disable module
$('.actions').on('click', '.disable', function(){
  var tr = $(this).closest('tr');
  var slug = tr.attr('data-slug');
  $.ajax({
    type: "POST",
    url: 'ajax/modules/module_disable.php',
    data: {slug:slug},
    success: function(data){
      location.reload();
    }
  });
});

//extend search function
function extend_search(paramName, paramValue)
{
  var url = window.location.href;
  var hash = location.hash;
  url = url.replace(hash, '');
  if (url.indexOf(paramName + "=") >= 0)
  {
    var prefix = url.substring(0, url.indexOf(paramName));
    var suffix = url.substring(url.indexOf(paramName));
    suffix = suffix.substring(suffix.indexOf("=") + 1);
    suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
    url = prefix + paramName + "=" + paramValue + suffix;
  }
  else
  {
  if (url.indexOf("?") < 0)
    url += "?" + paramName + "=" + paramValue;
  else
    url += "&" + paramName + "=" + paramValue;
  }
  window.location.href = url + hash;
}
</script>