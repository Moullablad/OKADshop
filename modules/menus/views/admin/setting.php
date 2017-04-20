<?php
$ajax_url = module_url(__FILE__,"ajax/ajax.php");
?>
<style type="text/css">
#sortable li{
  display: list-item;
  padding: 15px;
  border: 1px solid rgb(217, 217, 217);
  background: rgb(250, 250, 250);
  margin-bottom: 8px;
  font-size: 13px;
  font-weight: 600;
  line-height: 20px;
}
#sortable li:hover{
  border: 1px solid #000;
  cursor: move;
}
#sListsHint{
  background-color: initial !important;
  border: 1px dotted #000 !important;
}


/**
 * Nestable
 */

.dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }

.dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
.dd-list .dd-list { padding-left: 30px; }
.dd-collapsed .dd-list { display: none; }

.dd-item,
.dd-empty,
.dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

.dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:         linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
            border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
}
.dd-handle:hover { color: #2ea8e5; background: #fff; }

.dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
.dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
.dd-item > button[data-action="collapse"]:before { content: '-'; }

.dd-placeholder,
.dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
.dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
    background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                      -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                         -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                              linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-size: 60px 60px;
    background-position: 0 0, 30px 30px;
}

.dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
.dd-dragel > .dd-item .dd-handle { margin-top: 0; }
.dd-dragel .dd-handle {
    -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
            box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
}

/**
 * Nestable Extras
 */

.nestable-lists { display: block; clear: both; padding: 30px 0; width: 100%; border: 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; }

#nestable-menu { padding: 0; margin: 20px 0; }

#nestable-output,
#nestable2-output { width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }

#nestable2 .dd-handle {
    color: #fff;
    border: 1px solid #999;
    background: #bbb;
    background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
    background:    -moz-linear-gradient(top, #bbb 0%, #999 100%);
    background:         linear-gradient(top, #bbb 0%, #999 100%);
}
#nestable2 .dd-handle:hover { background: #bbb; }
#nestable2 .dd-item > button:before { color: #fff; }

@media only screen and (min-width: 700px) {

    .dd { float: left; width: 48%; }
    .dd + .dd { margin-left: 2%; }

}

.dd-hover > .dd-handle { background: #2ea8e5 !important; }

/**
 * Nestable Draggable Handles
 */

.dd3-content { display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 40px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:         linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
            border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
}
.dd3-content:hover { color: #2ea8e5; background: #fff; }

.dd-dragel > .dd3-item > .dd3-content { margin: 0; }

.dd3-item > button { margin-left: 30px; }

.dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;
    border: 1px solid #aaa;
    background: #ddd;
    background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
    background:    -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
    background:         linear-gradient(top, #ddd 0%, #bbb 100%);
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
.dd3-handle:before { content: '≡'; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 20px; font-weight: normal; }
.dd3-handle:hover { background: #ddd; }
/* ./Nestable end */
</style>
 
 
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3> <i class="fa fa-bars"></i> <?=l("Menus - Gérer les menus de votre boutique.", "menu");?></h3>
  </div>
</div>
<hr>

<div class="row">
  <div class="col-md-12">
    <?php if (is_array($return->error) && !empty($return->error)): ?>
      <div class="alert alert-danger" role="alert">
      <?php foreach ($return->error as $error): ?>
        <p><?= $error; ?></p>
      <?php endforeach ?>
      </div>
    <?php endif ?>

    <?php if (is_array($return->result) && !empty($return->result)): ?>
      <div class="alert alert-success" role="alert">
      <?php foreach ($return->result as $result): ?>
        <p><?= $result; ?></p>
      <?php endforeach ?>
      </div>
    <?php endif ?>

  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Créer un nouveau menu</h3>
      </div>
      <div class="panel-body">
        <form action="" method="post" class="form-inline">
          <input type="hidden" name="action" value="addmenu">
          <div class="form-group">
            <label for="name">Nom du Menu</label>
            <input type="text" name="name" class="form-control" required>
            <input type="submit" name="submit" class="btn btn-default" value="Ajouter menu">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default" role="tab" id="heading4">
      <div class="panel-heading">
        <form method="post" action="" class="form-inline">
          <div class="form-group">
            <label for="menu_name">Selectioner un menu</label>
            <select name="menu_list" id="menu_list" class="form-control">
              <?php if (isset($menu_list) && !empty($menu_list)): ?>
                <?php foreach ($menu_list as $key => $menu): ?>
                  <?php $menu_trans = getMenuTrans($menu['id']);  ?>
                   <option value="<?= $menu['id']; ?>"><?= $menu_trans->name; ?></option>
                <?php endforeach ?>
              <?php endif ?>
            </select>
            <a href="javascript:;" class="edit-menu"><i class="fa fa-pencil"></i></a>

            <!-- <input type="submit" name="submit" class="btn btn-primary" value="Enregistrer le menu"/> -->
          </div>
        </form>
      </div>
      <div class="panel-body">
        <div class="add-element">
          <h3>Ajouter des éléments au menu</h3>
          <form class="form-horizontal" method="post"  id="menu_item_form" action="<?= $ajax_url;?>">
            <input type="hidden" name="id_menu" class="menu_selected" value="">
            <div class="form-group">
              <label class="control-label col-lg-3"><?=l("Titre *", "menu");?></label>
              <div class="col-lg-4">
                <input type="text" name="title" id="title" value="" class="form-control" required autofocus>     
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-lg-3"><?=l("Type d'element *", "menu");?></label>
              <div class="col-lg-4">
                <select name="id_type" class="form-control" id="id_type">
                  <option value="0">Selectionner une type</option>
                  <?php if (!empty($menu_item_type)): ?>
                    <?php foreach ($menu_item_type as $key => $type): ?>
                      <option value="<?= $type['id']; ?>"><?= $type['title']; ?></option>
                    <?php endforeach ?>
                  <?php endif ?>
                </select>
              </div>
            </div>

            <div class="form-group" id="element_content"></div>
              
            <div class="form-group">
              <input type="submit" class="btn btn-default" value="<?=l("Ajouter", "menu");?>">
            </div>
          </form>
        </div>
        <hr>
        <form class="form-horizontal" action="" method="post">
          <input type="hidden" name="id_menu" class="menu_selected" value="">
          <input type="hidden" name="action" value="save_menu">
          <input type="hidden" name="nestable_result" id="nestable_result" value="">
          <h3>Structure du menu</h3>
          <p>Glissez chaque élément pour les placer dans l’ordre que vous préférez. Cliquez sur la flèche à droite de l’élément pour afficher d’autres options de configuration.</p>
            

         <!--  <ul id="sortable" class="menu-list">
          </ul> -->

          <div class="form-group">
            <div class="col-md-12">
              <div class="nestable-list" id="nestable">
                
              </div>

            </div>
          </div>

          <hr>
          <h3>Réglages du menu</h3>
          <div class="form-group">
            <label class="col-md-4 control-label" for="section">Emplacements du thème</label>
            <div class="col-md-8">
              <div class="checkbox">
                <label for="grp1-0">
                  <?php if ($menu_location_lang && !empty($menu_location_lang)): ?>
                    <?php foreach ($menu_location_lang as $key => $location): ?>
                      <p><input type="checkbox" name="location[]" id=""  class="location"  value="<?= $location['id'] ?>"> <?= $location['name'] ?> </p>
                    <?php endforeach ?>
                  <?php endif ?>
                </label>
              </div>
            </div>
            <div class="col-md-12">
              <input type="submit" name="submit" class="btn btn-primary pull-right" value="enregistré le menu">
            </div>
          </div>
        </form>

      </div>
      <div class="panel-footer">
        <a href="javascript:;" onclick="deleteMenu()"> Supprimer le menu</a>
      </div>
    </div>
  </div>
</div>

<!-- menu item Modal -->
<div id="menuItemModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

  <!-- menu Modal content-->
  <div class="modal-content menu-modal">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Edit Menu</h4>
    </div>
    <div class="modal-body">
      <form class="edit-menu-form" method="post" action="" data-menuitemid="">
        <div class="form-group">
          <label for="menu-item-link">Languages</label>
          <select name="trans[id_lang]" class="form-control" id="menu_item_languages">
            <?php foreach ($languages as $key => $value): ?>
              <option id="<?= $value->id; ?>" data-code="<?= $value->code; ?>" 
              <?= ($id_lang == $value->id) ? "selected" :""; ?>><?= $value->name; ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <label for="menu-item-link">Title</label>
          <input type="text" value="" class="form-control menu-item-name" placeholder="title" />
        </div>
        <div class="form-group">
          <label for="menu-item-link">URL</label>
          <input type="text" value="" class="form-control menu-item-link" placeholder="url" />
        </div>

        <div class="form-group">
          <label for="menu-item-link">Content</label>
          <textarea class="form-control menu-item-content"  placeholder="Content" rows="5"></textarea> 
        </div>

      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      <button type="button" class="btn btn-primary save-menu-item">Enregistrer</button>
    </div>
  </div>

  </div>
</div>
<!-- ./menu item modal -->

<!-- menu modal -->
<div id="menuModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

  <!-- menu Modal content-->
  <div class="modal-content menu-modal">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Edit Menu</h4>
    </div>
    <div class="modal-body">
      <form class="edit-menu-form" method="post" action="" data-menuitemid="">
        <div class="form-group">
          <select name="trans[id_lang]" class="form-control" id="menu_languages">
            <?php foreach ($languages as $key => $value): ?>
              <option id="<?= $value->id; ?>" data-code="<?= $value->code; ?>" 
              <?= ($id_lang == $value->id) ? "selected" :""; ?>><?= $value->name; ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="form-group">
          <input type="text" value="" class="form-control menu-name" />
        </div>
        <div class="form-group">
          <input type="text" name="position" value="" class="form-control menu-position" />
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
      <button type="button" class="btn btn-primary save-menu">Enregistrer</button>
    </div>
  </div>

  </div>
</div>
<!-- ./menu modal -->


<script type="text/javascript">
   $(function()
    {
      var options = {
        currElClass: 'red',
        placeholderClass: 'bgC2',
        listsClass:'',
        isAllowed: function(cEl, hint, target)
        {
          hint.css('background-color', '#99ff99');
         
          if (hint.prevObject != undefined) {

          }

          return true;
        }
      };
    });

  $(document).ready(function(){
    $('#id_type').change(function(){
      var id_type = $(this).val();
      $("#element_content").html('');
      if (id_type != 0){
        jQuery.ajax({
          url: "<?= $ajax_url;?>",
          data:{action:'elementByType',id_type:id_type},
          type: "POST",
          success:function(data){
            try {
              data = $.parseJSON(data);
              $("#element_content").html(data);
            }catch(err) {

            }
            
          },
          error:function (){}
        });
      }
    });


    // menu item form
    $("form#menu_item_form").submit(function(event){
      event.preventDefault();
      if ($("#menu_item_title").val() == "" || $("#id_type").val() == 0  || $("#position").val() == 0 || $(".element").val() == 0 || $(".element").val() == "" ) {
        os_message_notif( "<?=l("veuillez remplire tous les champ obligatoire", "menu");?>" ,"warning");
      }else{
        submit_ajax_form("menu_item_form", function(data) {
          //console.log(data);
          os_message_notif( "<?=l("Bien Ajouté", "menu");?>" );
          $("#element_content").html("");
          $("#title").val("");
          $("#permalink").val("");
          $("#id_type").val("0");
          $("#position").val("0");
          refrechMenu();
        });
      }
      return false;
    });



    $(".menu_selected").val($("#menu_list").val());
   

    $("#menu_list").change(function(){
      var menu_selected = $(this).val();
      if (menu_selected != "" && menu_selected != "0") {
        $(".menu_selected").val(menu_selected);
      }else{
        $(".menu_selected").val('');
      }
      refrechMenu();
    });



    refrechMenu();

    
    


  });

  function refrechMenu(){
    var id_menu = $(".menu_selected").val();
    if (id_menu == "") {
      return;
    }
    jQuery.ajax({
      url: "<?= $ajax_url;?>",
      data:{action:'refrechMenu',id_menu:id_menu},
      type: "POST",
      success:function(data){

        try {

          data = $.parseJSON(data);
          $("#nestable").html(data['menu_item']);
          var obj = data['menu_location'];

          nestableEvent();
           //console.log("here");
          $('.location').each(function(){$(this).prop('checked', false);});
          for (var prop in obj) {
            var location = obj[prop]['id_location'];
            $('.location[value="'+location+'"]').prop('checked', true);
          }

          deleteMenuItem();
          editMenuItem();

        }catch(err) {

        }
        
      },
      error:function (){}
    });
  }

  function nestableEvent(){
    $('.dd').nestable({ /* config options */ });
    updateNestableResult();
    $('.dd').on('change', function() {
      updateNestableResult();
    });
  }

  function updateNestableResult(){
    var serialize = $('.dd').nestable('serialize');
    var result = nestableFetchObject(serialize).replace(/,+$/,'');
    //console.log(result);
    $("#nestable_result").val(result);
  }

  function nestableFetchObject(obj,id= null){
    $result = "";
    var pos = 1 ;
    for (var k in obj) {
        if (id != null) {
          //console.log(obj[k].id + " parent: " + id);
          $result += obj[k].id + ":" + id + ":" + pos + ",";
        }else{
         // console.log(obj[k].id);
          $result += obj[k].id + ":0"+ ":" + pos + ",";
        }
        pos++;
        if (obj[k].children != undefined) {
          var child = obj[k].children;
          $result += nestableFetchObject(child,obj[k].id);
        }
      }
      return $result;
  }


  function deleteMenu(){
    var res = confirm("Voulez vous vraiment supprimer le menu?");
    if (res) {
      var id_menu = $(".menu_selected").val();
      if (id_menu == "") {
        return;
      }
      jQuery.ajax({
        url: "<?= $ajax_url;?>",
        data:{action:'deleteMenu',id_menu:id_menu},
        type: "POST",
        success:function(data){
          try {
            data = $.parseJSON(data);
            location.reload();
          }catch(err) {
            os_message_notif( "<?=l("Problém de Suppression", "menu");?>" ,"warning");
          }
          
        },
        error:function (){}
      });
    }else{
      os_message_notif( "<?=l("Suppression Annulée", "menu");?>" ,"warning");
    }
  } 

  function deleteMenuItem(){
    $('.delete-menu-item').click(function(){   
      var res = confirm("Voulez vous vraiment supprimer le menu?");
      var id_menu_item = $(this).parent().data('id');
      if (id_menu_item == "") {
        return;
      }
      if (res) {
        jQuery.ajax({
          url: "<?= $ajax_url;?>",
          data:{action:'deleteMenuItem',id_menu_item:id_menu_item},
          type: "POST",
          success:function(data){
            try {
              data = $.parseJSON(data);
              //location.reload();
              $('li[data-id="'+id_menu_item+'"]').hide("slow");
              os_message_notif( "<?=l("Bien Supprimé", "menu");?>" );

            }catch(err) {
              os_message_notif( "<?=l("Problém de Suppression", "menu");?>" ,"warning");
            }
            
          },
          error:function (){}
        });
      }
    });
  }

  function editMenuItem(){
    $('.edit-menu-item').click(function(){ 

      var modal = $('#menuItemModal'); 
      var id_menu_item = $(this).parent().data("id");
      if (id_menu_item == "") {
        return;
      }
      jQuery.ajax({
        url: "<?= $ajax_url;?>",
        data:{action:'getMenuItem',id_menu_item:id_menu_item},
        type: "POST",
        success:function(data){
          try { 
            data = $.parseJSON(data);
            modal.find('.menu-item-name').val(data['title']);
            modal.find('.menu-item-link').val(data['link']);
            modal.find('.menu-item-content').val(data['content']);
            modal.find('form').data('menuitemid',id_menu_item);
            $('#menu_item_languages option#' + <?= $id_lang; ?>).prop('selected', true);
            modal.modal('show');
          }catch(err) {
            os_message_notif( "<?=l("Problém de chargement", "menu");?>" ,"warning");
          }
          
        },
        error:function (){}
      });
    });
  }

 
  $("#menu_item_languages").on('change', function(){
    var modal = $('#menuItemModal'); 
    var url = "<?= $ajax_url;?>";
    var id_menu_item = $(this).closest("form").data("menuitemid");
    var id_lang = $(this).children(":selected").attr("id");
    var data = {id_lang: id_lang, id_menu_item: id_menu_item, action: 'getMenuItemTrans'};
    ajax_handler(url, data, 'post', function(res) {
      modal.find('.menu-item-name').val(res['title']);
    }); 

  }); 


  $(".save-menu-item").on('click', function(){
    var modal = $('#menuItemModal'); 
    var url = "<?= $ajax_url;?>"; 
    var id_menu_item = modal.find("form").data("menuitemid");
    var id_lang = $("#menu_item_languages").children(":selected").attr("id");
    var title = modal.find('.menu-item-name').val();
    var link = modal.find('.menu-item-link').val();
    var content = modal.find('.menu-item-content').val();
    var data = {id_lang: id_lang, id_menu_item: id_menu_item, action: 'saveMenuItemTrans', title: title,link:link,content:content};

    ajax_handler(url, data, 'post', function(res) {
      os_message_notif( "<?=l("Terminée", "menu");?>");
    });

  });

   
  $(".edit-menu").on('click', function(){
    var id_menu = $(".menu_selected").val();
    if (id_menu == "") {
      return;
    }
    var modal = $('#menuModal'); 
    var url = "<?= $ajax_url;?>";
    var id_lang = $("#menu_languages").children(":selected").attr("id");
    var data = {id_lang: id_lang, id_menu: id_menu, action: 'getMenuTrans'};
    ajax_handler(url, data, 'post', function(res) {
        modal.find('.menu-name').val(res['name']);
        modal.find('.menu-position').val(res['position']);
        modal.modal('show'); 
    });
   
  });

  $("#menu_languages").on('change', function(){
    var modal = $('#menuModal'); 
    var url = "<?= $ajax_url;?>";
    var id_menu = $(".menu_selected").val();
    if (id_menu == "") {
      return;
    }
    var id_lang = $(this).children(":selected").attr("id");
    var data = {id_lang: id_lang, id_menu: id_menu, action: 'getMenuTrans'};
    ajax_handler(url, data, 'post', function(res) {
      modal.find('.menu-name').val(res['name']);
      modal.find('.menu-position').val(res['position']);
    }); 

  }); 

  $(".save-menu").on('click', function(){
    var modal = $('#menuModal'); 
    var url = "<?= $ajax_url;?>"; 
    var id_menu = $(".menu_selected").val();
    if (id_menu == "") {
      return;
    }
    var id_lang = $("#menu_languages").children(":selected").attr("id");
    var name = modal.find('.menu-name').val();
    var position = modal.find('.menu-position').val();
    var data = {id_lang: id_lang, id_menu: id_menu, action: 'saveMenuTrans', name: name, position: position};

    ajax_handler(url, data, 'post', function(res) {
      os_message_notif( "<?=l("Terminée", "menu");?>");
    });

  });
  
  </script> 
