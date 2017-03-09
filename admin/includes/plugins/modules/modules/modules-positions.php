<?php 
//MODULES POSITIONS PAGE
global $hooks;
global $os_global;

$theme_sections = $hooks->get_theme_sections( $os_global->theme );
//$theme_sections = "sec_dashboard";
array_push($theme_sections, "sec_dashboard");

//update hooks position
if(isset($_POST['update_position'])){
  $position_hooks = json_decode($_POST['position_hooks']);
  if(!empty($position_hooks)){
    foreach ($position_hooks as $key => $hook) {
      //set new position
      $hooks->update('modules_sections', array('position' => $hook->position), "WHERE id=".$hook->id_hook );
    }
  }
} 


/*echo '<pre>';
//execute_section_hooks( 'sec_sidebar' );
print_r($theme_sections);
echo '</pre>';
*/


?>
<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-puzzle-piece"></i> <?=l("Positions des modules", "core");?></h3>
  </div>
</div><br>

<style>
.disable_hook{
  margin: -6px;
  position: relative;
  border-radius: 0px;
  padding: 7px 10px;
}
</style>

<form method="post" action="">
  <input type="hidden" name="position_hooks" value="" id="position_hooks">
  <?php
  $i = 0;
  $lengh = count( $theme_sections );
  if( !empty($theme_sections) )
  {

    foreach ($theme_sections as $key => $section)
    {
      //add row wrap
      if ($key == 0) {
        echo '<div class="row">';
      }elseif( $i % 4 == 0 ){
        echo '</div><div class="row">';
      }
    ?>
    <div class="col-sm-3">
      <div class="panel panel-default">
        <div class="panel-heading">
          <?php echo $section; ?>
          <button type="button" class="btn btn-default btn-sm pull-right" data-section="<?php echo $section; ?>" data-toggle="modal" data-target="#set_sections">
            <i class="fa fa-plus"></i>
          </button>
        </div>
        <div class="panel-body">
          <ul class="sortable list">
            <?php 
              $active_hooks = $hooks->get_active_hooks( $section );
              if(!empty($active_hooks) ) {
                foreach ($active_hooks as $key => $hook) {
                  echo '<li id="'. $key .'">
                          <i class="fa fa-ellipsis-v"></i> '. $hook['mod_name'] .'
                          <a href="javascript:;" class="btn btn-danger btn-sm pull-right disable_hook"><i class="fa fa-trash"></i></a>
                        </li>';
                }
              } 
            ?>
          </ul>
        </div><!--/ .panel-body -->
        <div class="panel-footer">
          <input type="submit" name="update_position" class="btn btn-primary btn-block" value="Souvegarder">
        </div>
      </div>
    </div>
    <?php 
      //close last row
      if ($i == $lengh - 1) {
        echo '</div>';
      }
      $i++;
    }//END FOREACH
  
  }
  ?>
</form>


<!-- Modal -->
<div class="modal fade" id="set_sections" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?=l("Activer les positions des modules", "core");?></h4>
      </div>
      <div class="modal-body">
        <input type="hidden" value="" id="section">
        <div class="col-sm-4 padding0" id="cat_list">
          <ul class="links"></ul>
        </div>
        <div class="col-sm-8" id="modules">
          <div class="module hidden"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><?=l("Terminer", "core");?></button>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function(){

  // do action on bootstrap modal open
  $('#set_sections').on('shown.bs.modal', function (e) {
    var section = $(e.relatedTarget).data('section');
    $('input#section').val(section);
    // hook categories
    $.ajax({
      type: "POST",
      data: {section:section},
      url: 'ajax/modules/hook-categories.php',
      success: function(data){
        $('#cat_list .links').empty().append(data);
      }
    });
    //load inactive hooks
    $.ajax({
      type: "POST",
      data: {section:section},
      url: 'ajax/modules/hook-inactive.php',
      success: function(data){
        $('.module').removeClass('hidden');
        $('#modules').empty().append(data);
      }
    });
  });

  //reload page after modale close
  $('#set_sections').on('hidden.bs.modal', function () {
   location.reload();
  });

  // enable module hook
  $(document).on("click", ".enable_hook", function(e) {
    var id_hook = $(this).closest('.module').attr('id');
    $.ajax({
      type: "POST",
      url: 'ajax/modules/hook-enable.php',
      data: {id_hook:id_hook},
      success: function(data){
        $('.module[id="'+ id_hook +'"]').remove();
      }
    });
  });
  // disable module hook
  $('.disable_hook').on('click', function(){
    var id_hook = $(this).closest('li').attr('id');
    $.ajax({
      type: "POST",
      url: 'ajax/modules/hook-disable.php',
      data: {id_hook:id_hook},
      success: function(data){
       location.reload();
      }
    });
  });
  //hook filter
  $(document).on("click", "#cat_list a", function(e) {
    var section = $('input#section').val();
    var cat_slug = $(this).attr('id');
    $.ajax({
      type: "POST",
      url: 'ajax/modules/hook-filter.php',
      data: {section:section,cat_slug:cat_slug},
      success: function(data){
        $('.module').removeClass('hidden');
        $('#modules').empty().append(data);
      }
    });
  });
  //sortable
  $('.sortable').bind('sortupdate', function() {
    var json = '';
    $(this).find('li').each(function(){
      json += ('{ "id_hook":"'+ $(this).attr('id') +'", "position":"'+ ($(this).index()+1) +'" },');
    });
    json = json.slice(0,-1);
    json = json.replace(json, '['+json+']');
    $('#position_hooks').empty().val(json);
  });

});
</script>