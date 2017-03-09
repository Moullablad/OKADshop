<?php
use Core\Form;

function DELETE($ID){
  global $common;
  $common->delete('attribute_values', "WHERE id=".$ID );
  echo '<script>window.location.href="?module=values"</script>';
}
//exit if delete action
if ( $_GET['action'] == "delete" ) return;



function ADD(){

  //Classe Instance
  $product = new OS_Product();
  $message = "";
  
  if(
    isset($_POST['saveValue'])
    && !empty($_POST['name'])
  ){

    //Set permalink
    if(empty($_POST['permalink'])){
      $permalink = $product->slugify($_POST['permalink']);
    }else{
      $permalink = addslashes($_POST['permalink']);
    }

    //Prepare data
    $data = array(
      'id_attribute' => intval($_POST['id_attribute']),
      'name' => addslashes($_POST['name']),
      'permalink' => $permalink,
      'id_lang' => get_default_id_lang(),
      'color' => $_POST['color'],
    );

    //check if value allready exist
    $id_value = intval($_POST['id_value']);
    //Update
    if($id_value > 0){
      $condition='WHERE id='.$id_value;
      $product->update('attribute_values',$data,$condition);
      $message = l("La valeur a été mise à jour");
    }else{
      $id_value = $product->save('attribute_values', $data);
      $message = l("La valeur a été ajouter avec success", "core");
      echo '<script>window.location.href="?module=values"</script>';
    }
  }


?>	


  <form class="form-horizontal" method="post" action="">
    <input type="hidden" name="id_value" id="id_value" value="<?= ($id_value) ? $id_value : '';?>">
    <div class="top-menu padding0">
      <div class="top-menu-title">
          <h3><i class="fa fa-shopping-bag"></i> <?=l("Ajouter une nouvelle valeur", "core");?></h3>
      </div>
      <div class="top-menu-button">
        <input type="submit" name="saveValue" class="btn btn-primary" value="<?= (isset($id_value)) ? l('Mise à jour', "core") : l('Enregistrer', "core");?>">
      </div>
    </div>
    <br>

    <?php if(!empty($message)) : ?>
      <div class="alert alert-info">
        <i class="fa fa-info-circle fa-2x"></i> <strong><?=$message;?></strong>
      </div>
    <?php endif; ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-info"></i> <?=l("VALEURS", "core");?>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <label class="col-md-3 control-label" for="attributs"><?=l("Groupe d'attributs *", "core");?></label>  
          <div class="col-md-6">
            <?php
              $colors=new Form();
              $form = array(array('COMBO','id_attribute','form-control','id_attribute', _DB_PREFIX_.'attributes','id','name'));
              $colors->Draw($form);
            ?>
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-md-3 control-label" for="name"><?=l("Valeur *", "core");?></label>  
          <div class="col-md-6">
            <input name="name" type="text" value="<?= (isset($_POST['name'])) ? htmlentities($_POST['name']) : '';?>" class="form-control" id="name">
          </div>
        </div>

        

        <div class="form-group">
          <label class="col-md-3 control-label" for="permalink"><?=l("URL", "core");?></label>  
          <div class="col-md-6">
            <input name="permalink" type="text" value="<?= (isset($_POST['permalink'])) ? htmlentities($_POST['permalink']) : '';?>" class="form-control" id="permalink">
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="color">Coleur </label><div class="col-md-3">
            <div class="input-group colorpicker-component colorpicker">
                <input type="text" name="color" value="" class="form-control" id="color" />
                <span class="input-group-addon"><i></i></span>
            </div>
          </div>
        </div>


      </div>
    </div><!--/ .panel -->

  </form>


<?php
//END ADD FUNCTION
}


function EDIT($ID){

  //Classe Instance
  $product = new OS_Product();
  $message = "";
  
  if(
    isset($_POST['updateValue'])
    && !empty($_POST['name'])
  ){

    //Set permalink
    if(empty($_POST['permalink'])){
      $permalink = $product->slugify($_POST['permalink']);
    }else{
      $permalink = addslashes($_POST['permalink']);
    }

    //Prepare data
    $options = array(
      'id_attribute' => intval($_POST['id_attribute']),
      'name' => addslashes($_POST['name']),
      'color' => $_POST['color'],
      'permalink' => $permalink,
      'id_lang' => get_default_id_lang(),
    );

    //Update
    $condition='WHERE id='.$ID;
    $product->update('attribute_values',$options,$condition);
    $message = l("La valeur a été mise à jour");
  }

  
  

  //get value data
  /*$data = $product->getValueByID($ID);
  if(isset($data['id_attribute']) && $data['id_attribute'] > 0){
    $id_attr = $data['id_attribute'];
  }else{
    $id_attribute = $product->getAttributeByID($ID);
    if(isset($id_attribute) && $id_attribute > 0){
      $id_attr = $id_attribute;
    }
  }
  print_r($data);*/
  
  //get value data
  $data = $product->getValueByID($ID);
  if(!isset($data)) echo '<script>window.location.href="?module=values"</script>';;
?>  


  <form class="form-horizontal" method="post" action="">
    <div class="top-menu padding0">
      <div class="top-menu-title">
          <h3><i class="fa fa-shopping-bag"></i> <?=l("Ajouter une nouvelle valeur", "core");?></h3>
      </div>
      <div class="top-menu-button">
        <input type="submit" name="updateValue" class="btn btn-primary" value="<?=l("Mise à jour", "core");?>">
      </div>
    </div>
    <br>

    <?php if(!empty($message)) : ?>
      <div class="alert alert-info">
        <i class="fa fa-info-circle fa-2x"></i> <strong><?=$message;?></strong>
      </div>
    <?php endif; ?>

    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="fa fa-info"></i> <?=l("VALEURS", "core");?>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <label class="col-md-3 control-label" for="attributs"><?=l("Groupe d'attributs *", "core");?></label>  
          <div class="col-md-6">
            <?php
            $colors = new Form();
            $form=array(
              array( _DB_PREFIX_.'attributes'/*table*/,'id'/*id table*/,$data['id_attribute']),
              array('COMBO','id','id_attribute','id_attribute','id_attribute', _DB_PREFIX_.'attributes','id','name')
            );
            $colors->EDraw($form);
            ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label" for="name"><?=l("Valeur *", "core");?></label>  
          <div class="col-md-6">
            <input name="name" type="text" value="<?=$data['name']?>" class="form-control" id="name">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label" for="permalink"><?=l("URL", "core");?></label>  
          <div class="col-md-6">
            <input name="permalink" type="text" value="<?=$data['permalink']?>" class="form-control" id="permalink">
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="color">Coleur </label><div class="col-md-3">
            <div class="input-group colorpicker-component colorpicker">
                <input type="text" name="color" value="<?=$data['color']?>" class="form-control" id="color" />
                <span class="input-group-addon"><i></i></span>
            </div>
          </div>
        </div>

      </div>
    </div><!--/ .panel -->

  </form>


<?php
//END EDIT FUNCTION
}
