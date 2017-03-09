<?php 
function Add(){}
function EDIT($ID){}
function DELETE($ID){
	$common = new OS_Common();
	$id = $common->delete('cart_rule', "WHERE id=".$ID );
	echo '<script>window.location.href="?module=cart"</script>';
}

//exit if delete action
if ( $_GET['action'] == "delete" ) return;



global $common;
$errors = $success = array();


//get user id
use Core\Controllers\Admin\UserController;
$id_user = UserController::get('id');


/**
 *=============================================================
 * UPDATE CART MODE
 * This part well apply when you go to edit a cart rule from list
 * EX: [WewSite]/index.php?module=cart&action=edit&id=[82]
 *=============================================================
 */
if(isset($_GET['id']) && $_GET['id'] > 0 && isset($_GET['action']) && $_GET['action'] == 'edit'){
  $cart_rule = $common->select('cart_rule', array('id'), "WHERE id=".intval($_GET['id']) );
  if( !$cart_rule[0] ){
    echo '<script>window.location.href="?module=cart"</script>';
  }
  $id_cart = $cart_rule[0]['id'];
/*============================================================*/
} //END UPDATE CART MODE
/*============================================================*/


use Core\Models\Admin\Product;
$model = new Product();
$products = $model->all();

//PROCCESS POSTED DATA
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['name']) && !empty($_POST['code']) ){

  $cart_data = array(
    'name'                   => addslashes($_POST['name']),
    'description'            => addslashes($_POST['description']),
    'code'                   => addslashes($_POST['code']),
    'date_from'              => $_POST['date_from'], 
    'date_to'                => $_POST['date_to'],  
    'minimum_amount'         => floatval($_POST['minimum_amount']),  
    'quantity'               => intval($_POST['quantity']), 
    'quantity_per_user'      => intval($_POST['quantity_per_user']),  
    'free_shipping'          => isset($_POST['free_shipping']) ? intval($_POST['free_shipping']) : 0,  
    'reduction'              => floatval($_POST['reduction']),
    'apply_discount'         => intval($_POST['apply_discount']), 
    'reduction_type'         => $_POST['reduction_type'], 
    'gift_product'           => isset($_POST['gift_product']) ? intval($_POST['gift_product']) : '', 
    'gift_product_attribute' => intval($_POST['gift_product_attribute']),  
    'id_customer'            => intval($_POST['id_customer']),   
    'cby'                    => $id_user,
    'active'                 => isset($_POST['active']) ? intval($_POST['active']) : 0
  );
  if( isset($_POST['carrier_res']) && !empty($_POST['carrier_restriction']) ){
    $cart_data['carrier_restriction'] = implode(",", $_POST['carrier_restriction']);
  }else{
    $cart_data['carrier_restriction'] = "";
  }
  if( isset($_POST['group_res']) && !empty($_POST['group_restriction']) ){
    $cart_data['group_restriction'] = implode(",", $_POST['group_restriction']);
  }else{
    $cart_data['group_restriction'] = "";
  }
  if( isset($_POST['product_res']) && !empty($_POST['product_restriction']) ){
    $cart_data['product_restriction'] = implode(",", $_POST['product_restriction']);
  }else{
    $cart_data['product_restriction'] = "";
  }
  //product type
  if( $_POST['reduction_type'] == "specific"){
    $cart_data['reduction_product'] = intval($_POST['reduction_product']);
  }else{
    $cart_data['reduction_product'] = 0;
  }

  


  //SAVE PRODUCT PROCCESS
  if( isset($_POST['save']) )
  {

    //Insert cart rule
    $save = $common->save('cart_rule', $cart_data);
    if( $save ){
      echo '<script>window.location.href="?module=cart&action=edit&id='.$save.'"</script>';
    }

  }//END SAVE

  //UPDATE PRODUCT PROCCESS
  if( isset($_POST['update']) )
  {
    if(!isset($id_cart) && $id_cart <= 0) return;
    $update = $common->update('cart_rule', $cart_data, "WHERE id=".$id_cart );

  }//END UPDATE


}//END POSTED DATA



/**
 *=============================================================
 * PREPARE DATA AFTER SAVE
 * This part well apply after the first save of new product
 *=============================================================
 */
if(isset($id_cart) && $id_cart > 0){
  $cart_rule = $common->select('cart_rule', array('*'), "WHERE id=".$id_cart );
  $cart = $cart_rule[0];



  //carrier restriction
  $carrier_ids = $cart['carrier_restriction'];
  if( !empty($carrier_ids) ){
    $carrier_res = $common->select('carrier', array('id', 'name'), "WHERE id IN ($carrier_ids) AND active=1" );
  }
  //user groups restriction
  $group_ids = $cart['group_restriction'];
  if( !empty($group_ids) ){
    $group_res = $common->select('users_groups', array('id', 'name'), "WHERE id IN ($group_ids)" );
  }
  //product restriction
  $product_ids = $cart['product_restriction'];
  if( !empty($product_ids) ){
    $product_res = $model->all("WHERE id IN ($product_ids) AND active=1");
    // $common->select('products', array('id', 'name'), "WHERE id IN ($product_ids) AND active=1" );
  }
}


//OTHER DATA
$customers = $common->select('users', array('id', 'first_name', 'last_name'), "WHERE user_type='user'" );
$carriers = $common->select('carrier', array('id', 'name'), "WHERE active=1" );
$users_groups = $common->select('users_groups', array('id', 'name') );


// $products = $common->select('products', array('id', 'name'), "WHERE active=1" );


/*$check = $common->check_cart_rule( 1, 1, 2, array(121,38), 350 );

echo "<pre>";
var_dump($check);
echo "</pre>";*/
?>
<div class="top-menu padding0">
    <div class="top-menu-title">
        <h3><i class="fa fa-tags"></i> Cart rules</h3>
    </div>
</div><br>

<form class="form-horizontal" method="post" action="">
  <div class="col-sm-12 padding0" style="margin-bottom:10px;border-bottom:1px solid #A5245E;">
    <ul class="nav nav-tabs bg-white">
      <li><a data-toggle="tab" href="#step-1"><span class="number">1</span> <?=l("Informations", "core");?></a></li>
      <li><a data-toggle="tab" href="#step-2"><span class="number">2</span> <?=l("Conditions", "core");?></a></li>
      <li><a data-toggle="tab" href="#step-3"><span class="number">3</span> <?=l("Actions", "core");?></a></li>
    </ul>
  </div>


  <div class="tab-content col-sm-12 padding0">

    <div class="tab-pane active" id="step-1">
      <div class="panel panel-default">
        <div class="panel-heading"><?=l("Informations", "core");?></div>
        <div class="panel-body">

          <div class="form-group">
            <label class="control-label col-sm-3" for="name"><?=l("Nom", "core");?></label>
            <div class="col-sm-3">
              <input name="name" type="text" value="<?=( isset($cart['name']) ) ? $cart['name'] : '';?>" class="form-control" id="name" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="description"><?=l("Description", "core");?></label>
            <div class="col-sm-5">
              <textarea name="description" id="description" rows="2" class="form-control"><?=( isset($cart['description']) ) ? $cart['description'] : '';?></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3" for="code"><?=l("Code", "core");?></label>
            <div class="col-sm-3">
              <div class="input-group">
                <input name="code" type="text" value="<?=( isset($cart['code']) ) ? $cart['code'] : '';?>" class="form-control" id="code" required>
                <span class="input-group-btn">
                  <button type="button" class="btn btn-default gencode"><i class="fa fa-random"></i> <?=l("Générer", "core");?></button>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label"><?=l("État", "core");?></label>  
            <div class="col-sm-3">
              <input type="checkbox" name="active" value="1" <?=( isset($cart['active']) && $cart['active'] == "1" ) ? 'checked' : '';?>>
            </div>
          </div>

        </div><!--/ .panel-body -->
        <div class="panel-footer">
          <button type="button" class="btn btn-danger" onclick="window.location='?module=cart';"><?=l("Fermer", "core");?></button>
          <button type="submit" name="<?= (isset($id_cart) && $id_cart > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?=l("Sauvegarder et rester", "core");?></button>
        </div><!--/ .panel-footer -->
      </div><!--/ .panel -->
    </div><!--/ #step-1 -->

    <div class="tab-pane" id="step-2">
      <div class="panel panel-default">
        <div class="panel-heading"><?=l("Informations", "core");?></div>
        <div class="panel-body">
          <div class="form-group">
            <label class="col-sm-3 control-label" for="id_customer"><?=l("Limiter à un seul client", "core");?></label>  
            <div class="col-sm-3">
              <select name="id_customer" class="form-control">
                <option value=""><?=l("Sélectionnez un Client", "core");?></option>
                <?php if( !empty($customers) ) : ?>
                  <?php foreach ($customers as $key => $customer) : ?>
                    <option value="<?php echo $customer['id'];?>" <?=( isset($cart['id_customer']) && $cart['id_customer'] == $customer['id'] ) ? 'selected' : '';?>>
                      <?php echo $customer['first_name'].' '.$customer['last_name'];?>
                    </option>
                  <?php endforeach;?>
                <?php endif;?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <?php 
            $today = date('Y-m-d H:i:s');
            $next_month = date("Y-m-d H:i:s", strtotime("+1 month", time() )); 
            ?>
            <label class="col-sm-3 control-label"><?=l("Valide", "core");?></label>  
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-addon"><?=l("Du", "core");?></span> 
                <input type="text" value="<?=( isset($cart['date_from']) ) ? $cart['date_from'] : $today;?>" name="date_from" class="form-control datetimepicker" id="date_from" required>
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3 col-sm-offset-3">
              <div class="input-group">
                <span class="input-group-addon"><?=l("Au", "core");?></span> 
                <input type="text" value="<?=( isset($cart['date_to']) ) ? $cart['date_to'] : $next_month;?>" name="date_to" class="form-control datetimepicker" id="date_to" required>
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              </div>
            </div><!-- 2016-05-20 16:30:35 -->
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="minimum_amount"><?=l("Montant minimum", "core");?></label>  
            <div class="col-sm-3">
              <div class="input-group">
                <div class="input-group-addon"><?php echo get_currency(); ?></div>
                <input id="minimum_amount" name="minimum_amount" type="number" min="0" step="0.01" value="<?=(isset($cart['minimum_amount'])) ? $cart['minimum_amount'] : '';?>" placeholder="00.00" class="form-control">
                <div class="input-group-addon"><?=l("TTC", "core");?></div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="quantity"><?=l("Quantité totale disponible", "core");?></label>  
            <div class="col-sm-3">
              <input id="quantity" name="quantity" type="number" min="0" step="1" value="<?=(isset($cart['quantity'])) ? $cart['quantity'] : '';?>" placeholder="0" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="quantity_per_user"><?=l("Quantité disponible pour chaque utilisateur", "core");?></label>  
            <div class="col-sm-3">
              <input id="quantity_per_user" name="quantity_per_user" type="number" min="1" step="1" value="<?=(isset($cart['quantity_per_user'])) ? $cart['quantity_per_user'] : '';?>" placeholder="1" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label"><?=l("Restrictions", "core");?></label>  
            <div class="col-sm-8">
              <p class="checkbox">
                <label><input type="checkbox" name="carrier_res" id="carrier_restriction" <?=( isset($cart['carrier_restriction']) && $cart['carrier_restriction'] != "" ) ? 'checked' : '';?>><?=l("Sélection de transporteurs", "core");?></label>
                <div class="row hidden" id="carrier_row">
                  <br>
                  <div class="col-xs-6">
                    <select id="carrier" class="form-control" size="5" multiple="multiple">
                      <?php if( !empty($carriers) ) : ?>
                        <?php foreach ($carriers as $key => $carrier) : ?>
                          <option value="<?php echo $carrier['id'];?>"><?php echo $carrier['name'];?></option>
                        <?php endforeach;?>
                      <?php endif;?>
                    </select>
                    <button type="button" id="carrier_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                  </div>
                  <div class="col-xs-6">
                    <select name="carrier_restriction[]" id="carrier_to" class="form-control" size="5" multiple="multiple">
                      <?php if( !empty($carrier_res) ) : ?>
                        <?php foreach ($carrier_res as $key => $res) : ?>
                          <option value="<?php echo $res['id'];?>"><?php echo $res['name'];?></option>
                        <?php endforeach;?>
                      <?php endif;?>
                    </select>
                    <button type="button" id="carrier_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                  </div>
                </div>
              </p>
              <p class="checkbox">
                <label><input type="checkbox" name="group_res" id="group_restriction" <?=( isset($cart['group_restriction']) && $cart['group_restriction'] != "" ) ? 'checked' : '';?>><?=l("Sélection de groupes de clients", "core");?>>
                <div class="row hidden" id="group_row">
                  <br>
                  <div class="col-xs-6">
                    <select id="group" class="form-control" size="5" multiple="multiple">
                      <?php if( !empty($users_groups) ) : ?>
                        <?php foreach ($users_groups as $key => $group) : ?>
                          <option value="<?php echo $group['id'];?>"><?php echo $group['name'];?></option>
                        <?php endforeach;?>
                      <?php endif;?>
                    </select>
                    <button type="button" id="group_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                  </div>
                  <div class="col-xs-6">
                    <select name="group_restriction[]" id="group_to" class="form-control" size="5" multiple="multiple">
                      <?php if( !empty($group_res) ) : ?>
                        <?php foreach ($group_res as $key => $res) : ?>
                          <option value="<?php echo $res['id'];?>"><?php echo $res['name'];?></option>
                        <?php endforeach;?>
                      <?php endif;?>
                    </select>
                    <button type="button" id="group_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                  </div>
                </div>
              </p>
              <p class="checkbox">
                <label><input type="checkbox" name="product_res" id="product_restriction" <?=( isset($cart['product_restriction']) && $cart['product_restriction'] != "" ) ? 'checked' : '';?>><?=l("Sélection de produit", "core");?></label>
                <div class="row hidden" id="product_row">
                  <br>
                  <div class="col-xs-6">
                    <select id="product" class="form-control" size="5" multiple="multiple">
                      <?php if( !empty($products) ) : ?>
                        <?php foreach ($products as $key => $product) : ?>
                          <option value="<?php echo $product->id;?>"><?php echo $product->name;?></option>
                        <?php endforeach;?>
                      <?php endif;?>
                    </select>
                    <button type="button" id="product_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button> 
                  </div>
                  <div class="col-xs-6">
                    <select name="product_restriction[]" id="product_to" class="form-control" size="5" multiple="multiple">
                      <?php if( !empty($product_res) ) : ?>
                        <?php foreach ($product_res as $key => $res) : ?>
                          <option value="<?php echo $res->id;?>"><?php echo $res->name;?></option>
                        <?php endforeach;?>
                      <?php endif;?>
                    </select>
                    <button type="button" id="product_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                  </div>
                </div>
              </p>
            </div>
          </div>
        </div><!--/ .panel-body -->
        <div class="panel-footer">
          <button type="button" class="btn btn-danger" onclick="window.location='?module=cart';"><?=l("Fermer", "core");?></button>
          <button type="submit" name="<?= (isset($id_cart) && $id_cart > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?=l("Sauvegarder et rester", "core");?></button>
        </div><!--/ .panel-footer -->
      </div><!--/ .panel -->
    </div><!--/ #step-2 -->

    <div class="tab-pane" id="step-3">
      <div class="panel panel-default">
        <div class="panel-heading"><?=l("Actions", "core");?></div>
        <div class="panel-body">
          <div class="form-group">
            <label class="col-sm-3 control-label" ><?=l("Frais de port offerts", "core");?></label>  
            <div class="col-sm-3">
              <input type="checkbox" name="free_shipping" value="1" <?=( isset($cart['free_shipping']) && $cart['free_shipping'] == "1" ) ? 'checked' : '';?>>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="reduction"><?=l("Appliquer une réduction", "core");?></label>
            <div class="col-sm-3">
              <div class="input-group">
                <span class="input-group-addon"><?=l("TTC", "core");?></span>
                <input class="form-control" id="reduction" min="0" name="reduction" placeholder="0.00" step="0.01" type="number" value="<?=(isset($cart['reduction'])) ? $cart['reduction'] : '';?>"> 
                <span class="input-group-addon" style="padding: 0px;border: 0px;">
                  <select name="apply_discount" id="apply_discount" class="form-control" style="width: 70px;">
                    <option value="0" selected="">%</option>
                    <option value="1" <?=(isset($cart['apply_discount']) && $cart['apply_discount'] == "1") ? 'selected' : '';?>><?php echo get_currency();?></option>
                  </select>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-3"><?=l("Appliquer la réduction à", "core");?></label>
            <div class="col-lg-7">
              <p class="radio">
                <label for="to_order">
                  <input checked="checked" id="to_order" name="reduction_type" type="radio" value="order" <?=( isset($cart['reduction_type']) && $cart['reduction_type'] == "order" ) ? 'checked' : '';?>> 
                  <?=l("La commande (hors frais de port)", "core");?>
                </label>
              </p>
              <p class="radio">
                <label for="to_product">
                  <input id="to_product" name="reduction_type" type="radio" value="specific" <?=( isset($cart['reduction_type']) && $cart['reduction_type'] == "specific" ) ? 'checked' : '';?>> 
                  <?=l("Un produit spécifique", "core");?>
                </label>
              </p>
              <!--p class="radio">
                <label for="to_cheapest" style="display: inline-block;">
                  <input id="to_cheapest" name="reduction_type" type="radio" value="cheapest" <?//=( isset($cart['reduction_type']) && $cart['reduction_type'] == "cheapest" ) ? 'checked' : '';?>> 
                  Le produit le moins cher
                </label>
              </p-->
              <p class="radio">
                <label for="to_selection" style="display: inline-block;">
                  <input id="to_selection" name="reduction_type" type="radio" value="selection" <?=( isset($cart['reduction_type']) && $cart['reduction_type'] == "selection" ) ? 'checked' : '';?>> 
                  <?=l("Le(s) produit(s) sélectionné(s)", "core");?>
                </label>
                <div class="alert alert-info msg hidden" style="width: 350px;margin-top: 10px;"><?=l("Vous devez sélectionner au moins un produit", "core");?></div>
              </p>
            </div>
              
            <div class="form-group <?=( isset($cart['reduction_product']) && $cart['reduction_product'] == "0" ) ? 'hidden' : '';?>" id="reduction_product">
              <div class="col-sm-3 col-sm-offset-3">
                <select name="reduction_product" class="form-control">
                  <option value=""><?=l("Sélectionnez un produit", "core");?></option>
                  <?php if( !empty($products) ) : ?>
                    <?php foreach ($products as $key => $product) : ?>
                      <option value="<?php echo $product->id;?>" <?=( isset($cart['reduction_product']) && $cart['reduction_product'] == $product->id ) ? 'selected' : '';?>>
                        <?php echo $product->name;?>
                      </option>
                    <?php endforeach;?>
                  <?php endif;?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label"><?=l("Envoyer un cadeau", "core");?></label>  
            <div class="col-sm-3">
              <input type="checkbox" name="gift_product" value="1" <?=( isset($cart['gift_product']) && $cart['gift_product'] == "1" ) ? 'checked' : '';?>>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-3 col-sm-offset-3">
              <select name="gift_product_attribute" class="form-control hidden">
                <option value=""><?=l("Sélectionnez un produit", "core");?></option>
                <?php if( !empty($products) ) : ?>
                  <?php foreach ($products as $key => $product) : ?>
                    <option value="<?php echo $product->id;?>" <?=( isset($cart['gift_product_attribute']) && $cart['gift_product_attribute'] == $product->id ) ? 'selected' : '';?>>
                      <?php echo $product->name;?>
                    </option>
                  <?php endforeach;?>
                <?php endif;?>
              </select>
            </div>
          </div>
        </div><!--/ .panel-body -->
        <div class="panel-footer">
          <button type="button" class="btn btn-danger" onclick="window.location='?module=cart';"><?=l("Fermer", "core");?></button>
          <button type="submit" name="<?= (isset($id_cart) && $id_cart > 0) ? 'update' : 'save';?>" class="btn btn-primary pull-right"><?=l("Sauvegarder et rester", "core");?></button>
        </div><!--/ .panel-footer -->
      </div><!--/ .panel -->
    </div><!--/ #step-3 -->

  </div><!--/ .tab-content -->

</form><!--/ .form -->

<script>
$(document).ready(function(){

  
	//Bootstrap Switch
  $("input[name='active'], input[name='free_shipping'], input[name='gift_product']").bootstrapSwitch({onColor:'success','offColor':'danger'});
  
  //display product gift
  var gift_state = $('input[name=gift_product]').bootstrapSwitch('state');
  product_gift(gift_state);
  //change state
  $("input[name='gift_product']").on('switchChange.bootstrapSwitch', function(event, state) {
    product_gift(state);
  });

  


  //multiselect
  $('#carrier').multiselect();
  $('#group').multiselect();
  $('#product').multiselect({
    search: {
      left: '<input type="text" name="q" class="form-control" placeholder="Rechercher..." />',
      right: '<input type="text" name="q" class="form-control" placeholder="Rechercher..." />',
    }
  });

  //carrier restriction
  if( $('input[id=carrier_restriction]').is(':checked') ){
    $('#carrier_row').removeClass('hidden');
  } else {
    $('#carrier_row').addClass('hidden');
  }
  //carrier restriction
  if( $('input[id=group_restriction]').is(':checked') ){
    $('#group_row').removeClass('hidden');
  } else {
    $('#group_row').addClass('hidden');
  }
  //carrier restriction
  if( $('input[id=product_restriction]').is(':checked') ){
    $('#product_row').removeClass('hidden');
  } else {
    $('#product_row').addClass('hidden');
  }

  //carrier restriction change
  $("input[id=carrier_restriction]").change(function() {
    if(this.checked) {
      $('#carrier_row').removeClass('hidden');
    }else{
      $('#carrier_row').addClass('hidden');
    }
  });
  //group restriction change
  $("input[id=group_restriction]").change(function() {
    if(this.checked) {
      $('#group_row').removeClass('hidden');
    }else{
      $('#group_row').addClass('hidden');
    }
  });
  //product restriction change
  $("input[id=product_restriction]").change(function() {
    if(this.checked) {
      $('#product_row').removeClass('hidden');
    }else{
      $('#product_row').addClass('hidden');
    }
  });

  //Le(s) produit(s) sélectionné(s)
  $("input[type=radio]").change(function() {
    if( $('input[id=to_selection]').is(':checked') ) {
      if ($('#product_to option').length == 0) {
        $('.msg').removeClass('hidden');
      }
    }else{
      $('.msg').addClass('hidden');
    }
    if( $('input[id=to_product]').is(':checked') ) {
      $('#reduction_product').removeClass('hidden');
    }else{
      $('#reduction_product').addClass('hidden');
    }
  });

  //datetimepicker
  $('.datetimepicker').datetimepicker({format: 'YYYY-MM-DD H:m:s'});
  

  $('.gencode').click(function(){
    genCode(8);
  });


});

//Generate a string
function genCode(nbr)
{
  var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  for( var i=0; i < nbr; i++ ){
    text += possible.charAt(Math.floor(Math.random() * possible.length));
  }
  $('#code').val(text);
}

//display product gift select
function product_gift(state){
  if( state == true ){
    $('select[name=gift_product_attribute]').removeClass('hidden');
  }else{
    $('select[name=gift_product_attribute]').addClass('hidden');
  }
}
</script>