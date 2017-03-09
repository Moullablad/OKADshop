<?php
function Add(){}
function EDIT($ID){}
function DELETE($ID){
	$common = new OS_Common();
	$common->delete('order_detail', "WHERE id_order=".$ID );
	$common->delete('order_carrier', "WHERE id_order=".$ID );
	$common->delete('orders', "WHERE id=".$ID );
	echo '<script>window.location.href="?module=orders"</script>';
}
//exit if delete action
if ( $_GET['action'] == "delete" ) return;

function View($ID){
	echo '<script>window.location.href="../pdf/order.php?id_order='. $ID .'"</script>';
}




/**
 *=============================================================
 * UPDATE MODE
 * This part well apply when you go to edit an order from list
 * EX: [WewSite]index.php?module=orders&action=edit&id=[1]
 *=============================================================
 */

//prepare vars
global $common;
$errors = $success = array();

//check url for get
$id_order = intval( $_GET['id'] );
$orders_list = '<script>window.location.href="?module=orders"</script>';
if ( $id_order <= 0 ) echo $orders_list;

//get id_customer
$id_customer = $common->select('orders', array('id_customer'), "WHERE id=".$id_order );
if( !$id_customer[0] ) echo $orders_list;
$id_customer = $id_customer[0]['id_customer'];

//ckeck if invoice exist
$o = $common->get_order($id_order, $id_customer);
if( !$o ) echo $orders_list;

//get product list
$products = get_products();//$common->select('products', array('id', 'name'));

//payment_methodes
$payment_methodes = $common->select('payment_methodes', array('id', 'value') );

//quote has ordered
$order_invoiced = $common->select('invoices', array('id'), "WHERE id_order=".$id_order." ORDER BY id DESC LIMIT 1");
$id_invoice = intval($order_invoiced[0]['id']);

//prepare vars
$currency_sign = $o['order']['currency_sign'];


//order total
$voucher_code  	 = $o['order']['voucher_code'];
$voucher_value 	 = $o['order']['voucher_value']; 
$global_discount = $o['order']['global_discount']; 
$avoir 					 = $o['order']['avoir'];
$total_products  = $o['total']['product_tht'];
$total_ht 			 = $o['total']['tht'];
$global_weight   = floatval($o['total']['weight']);
$shipping_costs  = $o['carrier']['shipping_costs'];

/*echo '<pre>';
print_r($id_invoice);
echo '</pre>';*/
?>

<div class="top-menu padding0">
  <div class="top-menu-title">
    <h3><i class="fa fa-credit-card"></i> <?=l("Edition de la Commande", "core");?>
    <span class="badge badge-default"><?php echo $o['order']['reference']; ?></span>
		<span class="badge">N°<?php echo sprintf("%06d", $o['order']['id']);?></span>
	</h3>
  </div>
  <a href="?module=orders" class="btn btn-default pull-right"><?=l("Términer", "core");?></a>
</div><br>
<input type="hidden" value="<?=$id_order;?>" id="id_order">
<input type="hidden" value="<?=$id_customer;?>" id="id_customer">


<div class="col-sm-12 padding0" style="margin-bottom:10px;border-bottom:1px solid #A5245E;">
	<ul class="nav nav-tabs bg-white">
		<li class="active"><a data-toggle="tab" href="#step-1"><span class="number">1</span> <?=l("Produits", "core");?></a></li>
		<li><a data-toggle="tab" href="#step-2"><span class="number">2</span> <?=l("Client", "core");?></a></li>
		<!--li><a data-toggle="tab" href="#step-3"><span class="number">3</span> Paiement</a></li-->
		<li><a data-toggle="tab" href="#step-4"><span class="number">3</span> <?=l("Transporteur", "core");?></a></li>

		<!--li class="pull-right">
			<?php if( $id_invoice > 0 ) : ?>
			<a target="_blank" href="../pdf/invoice.php?id_invoice=<?=$id_invoice;?>&id_customer=<?=$o['order']['id_customer'];?>" class="btn btn-success" style="border-radius: 0px;color: #fff;"><i class="fa fa-file-text"></i> <?=l("Apérçu la facture", "core");?></a>
			<?php else : ?>
				<a target="_blank" class="btn btn-success gen_invoice" style="border-radius: 0px;color: #fff;"><i class="fa fa-cogs"></i> <?=l("Générer la facture", "core");?></a>
			<?php endif; ?>
		</li>
		<li class="pull-right">
			<a target="_blank" href="../pdf/order.php?id_order=<?=$o['order']['id'];?>&id_customer=<?=$o['order']['id_customer'];?>" class="btn"><i class="fa fa-file-pdf-o"></i> <?=l("Apérçu la Commande", "core");?></a>
		</li-->
	</ul>
</div>



<div class="tab-content col-sm-12 padding0">

	<div class="tab-pane active" id="step-1">
		<div class="panel panel-default">
			<div class="panel-body">

				<form class="form-horizontal" id="product_form" method="post" action="ajax/orders/form/product.php">
					<table id="add_product" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<input type="hidden" value="<?=$id_order;?>" name="id_order" class="id_order">
					<input type="hidden" value="" name="product_name" class="name">
					<input type="hidden" value="" name="product_image" class="image">
					<input type="hidden" value="" name="product_buyprice" class="buyprice">
					<input type="hidden" value="" name="product_discount" class="discount">
					<input type="hidden" value="" name="loyalty_points" class="loyalty_points">
					<input type="hidden" value="" name="product_packing" class="product_packing">
					<thead>
						<tr>
							<th><?=l("Nom de produit", "core");?></th>
							<th width="190"><?=l("Référence", "core");?></th>
							<th width="150"><?=l("Prix HT", "core");?> (<?=$currency_sign;?>)</th>
							<th width="150"><?=l("Quantité", "core");?></th>
							<th width="150"><?=l("Poids (Kg)", "core");?></th>
							<th width="95"><?=l("Actions", "core");?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<!--select style="width: 100%;" name="id_product" id="based_product" data-placeholder="Sélectionnez un produit..." class="chosen" required-->
								<select name="id_product" class="form-control" id="based_product" style="margin-bottom: 5px;" required>
									<option value="" selected><?=l("Sélectionnez un produit", "core");?></option>
									<?php if( !empty($products) ) : ?>
										<?php foreach ($products as $key => $product) : ?>
				            	<option value="<?php echo $product->id;?>"><?=stripslashes($product->name);?></option>
				            <?php endforeach;?>
			            <?php endif;?>
			          </select>
			          <select style="margin-top: 8px;" name="id_declinaisons" class="form-control hidden" id="based_attributs" disabled required>
									<option value="" selected><?=l("Sélectionnez une attribut", "core");?></option>
								</select>
								<input type="hidden" value="" name="attributs" class="attributs">
			        </td>
							<td><input type="text" value="" name="product_reference" class="form-control reference" required></td>
							<td><input type="number" min="0" step="0.01" value="" name="product_price" class="form-control price" required></td>
							<td><input type="number" min="1" step="1" value="" name="product_quantity" class="form-control quantity" required></td>
							<td><input type="number" min="0" step="0.01" value="" name="product_weight" class="form-control weight" required></td>
							<td style="text-align:center;">
				      	<button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> <?=l("Ajouter", "core");?></button>
				      </td>
						</tr>
					</tbody>
					</table>
				</form>

		    <div class="panel-subheading">
					<i class="fa fa-list"></i>
					<strong><?=l("Produits de la Commande", "core");?></strong>
				</div>

				<table id="order_products" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><?=l("Nom de produit", "core");?></th>
						<th width="190"><?=l("Référence", "core");?></th>
						<th width="150"><?=l("Prix HT", "core");?> (<?=$currency_sign;?>)</th>
						<th width="150"><?=l("Quantité", "core");?></th>
						<th width="150"><?=l("Poids (Kg)", "core");?></th>
						<th width="95"><?=l("Actions", "core");?></th>
					</tr>
				</thead>
				<tbody>
				<?php if( !empty($o['products']) ) : ?>
					<?php foreach ($o['products'] as $key => $product) : ?>
					<tr id="<?=$product['id'];?>">
						<td><input type="text" value="<?=stripslashes($product['product_name']);?>" class="form-control name"></td>
						<td><input type="text" value="<?=$product['product_reference'];?>" class="form-control reference"></td>
						<td><input type="number" min="0" step="0.01" value="<?=$product['product_price'];?>" class="form-control price"></td>
						<td><input type="number" min="1" step="1" value="<?=$product['product_quantity'];?>" class="form-control quantity"></td>
						<td><input type="number" min="0" step="0.01" value="<?=$product['product_weight'];?>" class="form-control weight"></td>
						<td style="text-align:center;">
			      	<a href="javascript:;" class="btn btn-default update" title="Mettre à jour"><i class="fa fa-refresh"></i></a>
			      	<a href="javascript:;" class="btn btn-danger delete" title="Supprimer ce produit"><i class="fa fa-trash"></i></a>
			      </td>
					</tr>
					<?php endforeach; ?>
				<?php endif; ?>
				</tbody>
				</table>

				<div class="col-sm-3 col-xs-12 pull-right padding0">
						<table class="table table-striped table-bordered" id="order_total">
							<tbody>
								<tr>
									<th width="150"><?=l("Total produits HT", "core");?></th>
									<td><span class="total_products"><?=$total_products;?></span></td>
								</tr>
								<?php if( $global_discount > 0 ) : ?>
								<tr>
									<th width="150"><?=l("Remise globale", "core");?></th>
									<td><span class="discount"><?=$global_discount;?></span></td>
								</tr>
								<?php endif; ?>
								<?php if( $voucher_value > 0 ) : ?>
								<tr>
									<th width="150"><?=l("Bon de réduction", "core");?></th>
									<td><span class="reduction"><?=$voucher_value;?></span></td>
								</tr>
								<?php endif; ?>
								<?php if( $avoir > 0 ) : ?>
								<tr>
									<th width="150"><?=l("Avoir", "core");?></th>
									<td><span class="avoir"><?=$avoir;?></span></td>
								</tr>
								<?php endif; ?>
								<?php if( $voucher_code != "" ) : ?>
								<tr>
									<th width="150"><?=l("Code promo", "core");?></th>
									<td><span class="code"><?=$voucher_code;?></span></td>
								</tr>
								<?php endif; ?>
								<tr>
									<th width="150"><?=l("Frais de transport", "core");?></th>
									<td><span class="shipping"><?=$shipping_costs;?></span></td>
								</tr>
								<tr>
									<th width="150"><?=l("TOTAL HT", "core");?></th>
									<td><span class="tht"><?=$total_ht;?></span></td>
								</tr>
								<!--tr>
									<th width="150">Acompte</th>
									<td><span class="acompte"></span></td>
								</tr>
								<tr>
									<th width="150">Solde</th>
									<td><span class="solde"></span></td>
								</tr-->
								<tr>
									<th width="150"><?=l("Poids total", "core");?></th>
									<td><span class="weight"><?=$global_weight;?></span></td>
								</tr>
							</tbody>
						</table>
					</div><!--/ .col-sm-3 -->

			</div><!--/ .panel-body -->
		</div><!--/ .panel -->
	</div><!--/ #step-1 -->

	<div class="tab-pane" id="step-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<table id="customet" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th><?=l("N° Client", "core");?></th>
							<th><?=l("Client", "core");?></th>
							<th><?=l("Email", "core");?></th>
							<th><?=l("Téléphone domicile", "core");?></th>
							<th><?=l("Téléphone portable", "core");?></th>
							<th><?=l("Socièté", "core");?></th>
							<th><?=l("Pays", "core");?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo '#'.sprintf("%06d", $o['customer']['id']);?></td>
							<td><?=$o['customer']['first_name'] ." ". $o['customer']['first_name'];?></td>
							<td><?=$o['customer']['email'];?></td>
							<td><?=$o['customer']['phone'];?></td>
							<td><?=$o['customer']['mobile'];?></td>
							<td><?=$o['customer']['company'];?></td>
							<td><?=$o['customer']['user_country'];?></td>
						</tr>
					</tbody>
				</table>
			</div><!--/ .panel-body -->
		</div><!--/ .panel -->
	</div><!--/ #step-2 -->

	<div class="tab-pane" id="step-3">
		<div class="panel panel-default">
			<div class="panel-body">

				<form class="form-horizontal" method="post" action="">
					<table id="add_payment" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th width="200"><?=l("Date de transaction", "core");?></th>
							<th><?=l("Methode de paiment", "core");?></th>
							<th><?=l("ID de transaction", "core");?></th>
							<th width="150"><?=l("Montant payé", "core");?></th>
							<th width="50"><?=l("Actions", "core");?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="input-group">
								  <input type="text" value="<?php echo date('Y-m-d H:i:s');?>" name="payment[date]" class="form-control datepicker" id="payment_date" required>
								  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</td>
							<td>
								<select name="payment[method]" class="form-control" id="payment_methodes" required>
			            <?php if( !empty($payment_methodes) ) : ?>
			            <?php foreach ($payment_methodes as $key => $method) : ?>
			              <option value="<?php echo $method['value'] ?>"><?php echo $method['value']; ?></option>
			            <?php endforeach; ?>
			            <?php endif; ?>
			          </select>
							</td>
							<td>
								<input type="text" name="payment[transaction_id]" value="" class="form-control" id="transaction_id"  placeholder="ID de la transaction" required>
							</td>
							<td>
								<div class="input-group">
						  		<input type="number" min="0" step="0.01" name="payment[amount]" value="" class="form-control" id="payment_amount" placeholder="0.00" required>
									<span class="input-group-addon"><?=$currency_sign;?></span>
								</div>
							</td>
							<td style="text-align:center;">
				      	<button type="submit" name="save_payment" class="btn btn-primary"><i class="fa fa-plus"></i> <?=l("Ajouter", "core");?></button>
				      </td>
						</tr>
					</tbody>
					</table>
				</form>

		    <div class="panel-subheading">
					<i class="fa fa-money"></i>
					<strong><?=l("Tranches payés", "core");?></strong>
				</div>

				<div class="table-responsive">
			    <table class="table table-striped table-bordered" cellspacing="0" width="100%">
			      <thead>
			        <tr style="background-color: #EFF9FD;border-bottom:2px solid #ddd;">
			          <th><?=l("ID", "core");?></th>
			          <th><?=l("Date de transaction", "core");?></th>
			          <th><?=l("Méthode de paiement", "core");?></th>
			          <th><?=l("ID de transaction", "core");?></th>
			          <th><?=l("Montant payé", "core");?> (<?=$currency_sign;?>)</th>
			        </tr>
			      </thead>
			      <tbody>
			      	<?php if( !empty($invoice_payments) ) : ?>
	            <?php foreach ($invoice_payments as $key => $payment) : ?>
								<tr>
				        	<td>#<?php echo $payment['id'] ?></td>
				          <td><?php echo $payment['payment_date'] ?></td>
				          <td><?php echo $payment['payment_method'] ?></td>
				          <td><?php echo $payment['payment_transaction_id'] ?></td>
				          <td><?php echo $payment['payment_amount'] ?></td>
				        </tr>
	            <?php endforeach; ?>
	            <?php endif; ?>
			      </tbody>
			    </table>
			  </div>

			</div><!--/ .panel-body -->
		</div><!--/ .panel -->
	</div><!--/ #step-3 -->

	<div class="tab-pane" id="step-4">
		<div class="panel panel-default">
			<div class="panel-body">

				<form class="form-horizontal" id="carrier_form" method="post" action="ajax/orders/form/carrier.php">
					<input type="hidden" value="<?=$id_order;?>" id="id_order" name="id_order">
					<div class="form-group">
						<label class="col-sm-3 control-label"><?=l("Formule", "core");?></label>  
						<div class="col-sm-3">
							<input type="text" value="<?=(isset($o['order']['carrier_type'])) ? $o['order']['carrier_type'] : '';?>" class="form-control" id="formule" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"><?=l("Poids total hors emballage", "core");?></label>  
						<div class="col-sm-3">
							<input type="text" value="<?=$o['total']['weight'];?>" class="form-control" id="global_weight" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"><?=l("Pays", "core");?></label>  
						<div class="col-sm-3">
							<input type="text" value="<?=(isset($o['customer']['user_country'])) ? $o['customer']['user_country'] : '';?>" class="form-control" id="country" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="carrier_name"><?=l("Nom de Transporteur", "core");?></label>  
						<div class="col-sm-3">
							<input type="text" name="carrier_name" id="carrier_name" class="form-control" value="<?=$o['carrier']['carrier_name'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="shipping_costs"><?=l("Frais de transport", "core");?></label>  
						<div class="col-sm-3">
							<input id="shipping_costs" name="shipping_costs" type="number" min="0" step="0.01" placeholder="0.00" class="form-control" required="" value="<?=$o['carrier']['shipping_costs'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=l("Délai de livraison", "core");?></label>
						<div class="col-sm-2 right0">
							<div class="input-group">
								<span class="input-group-addon"><?=l("Entre", "core");?></span>
								<input class="form-control" type="number" id="min_delay" name="min_delay" value="<?=$o['carrier']['min_delay'];?>" placeholder="min" required>
							</div>
						</div>
						<div class="col-sm-2 left0 right0">
							<div class="input-group" style="left:-2px;">
								<span class="input-group-addon"><?=l("Et", "core");?></span>
								<input class="form-control" type="number" id="max_delay" name="max_delay" value="<?=$o['carrier']['max_delay'];?>" placeholder="max" required>
							</div>
						</div>
						<div class="col-sm-2 left0" style="left:-4px;">
							<select name="delay_type" id="delay_type" class="form-control" style="width: auto;">
			          <option value="0" selected=""><?=l("Jours", "core");?></option>
			          <option value="1" <?=($o['carrier']['delay_type']=="1") ? 'selected' : '';?>><?=l("Semaines", "core");?></option>
			        </select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=l("Délai de préparation", "core");?></label>
						<div class="col-sm-2 right0">
							<div class="input-group">
								<span class="input-group-addon"><?=l("Entre", "core");?></span>
								<input class="form-control" type="number" id="min_prepa" name="min_prepa" value="<?=$o['carrier']['min_prepa'];?>" placeholder="min" required>
							</div>
						</div>
						<div class="col-sm-2 left0 right0">
							<div class="input-group" style="left:-2px;">
								<span class="input-group-addon"><?=l("Et", "core");?></span>
								<input class="form-control" type="number" id="max_prepa" name="max_prepa" value="<?=$o['carrier']['max_prepa'];?>" placeholder="max" required>
							</div>
						</div>
						<div class="col-sm-2 left0" style="left:-4px;">
							<select name="delay_type" id="prepa_type" class="form-control" style="width: auto;">
			          <option value="0" selected=""><?=l("Jours", "core");?></option>
			          <option value="1" <?=($o['carrier']['delay_type']=="1") ? 'selected' : '';?>><?=l("Semaines", "core");?></option>
			        </select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="weight_including_packing"><?=l("Poids total estimé emballage compris", "core");?></label>  
						<div class="col-sm-3">
							<div class="input-group">
								<input id="weight_including_packing" name="weight_including_packing" type="number" min="0" step="0.01" placeholder="0.00" class="form-control" required="" value="<?=$o['carrier']['weight_including_packing'];?>">
								<span class="input-group-addon"><?=l("Kg", "core");?></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="number_packages"><?=l("Nombre de colis estimé", "core");?></label>  
						<div class="col-sm-3">
							<input id="number_packages" name="number_packages" type="number" min="0" step="1" placeholder="1" class="form-control" required="" value="<?=$o['carrier']['number_packages'];?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="more_info"><?=l("Informations complémentaires", "core");?></label>  
						<div class="col-sm-6">
							<textarea name="more_info" id="more_info" class="form-control summernote"><?=$o['carrier']['more_info'];?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-2 col-sm-offset-3">
							<button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i> <?=l("Mise à jour", "core");?></button>
						</div>
					</div>

					
				</form>
			</div><!--/ .panel-body -->
		</div><!--/ .panel -->
	</div><!--/ #step-4 -->

</div><!--/ .tab-content -->



<script>
//Ajax URL
var ajaxurl = 'ajax/orders/';


$(document).ready(function(){

	//$('.chosen').focus();


	//generate order
	$('.gen_invoice').on('click', function() {
		$(this).prop( "disabled", true );
		os_message_notif("<?=l('En cours de Génération de la Facture.', 'admin');?>");
		var id_order = $('#id_order').val();
		var id_customer = $('#id_customer').val();
		$.ajax({
			type: "POST",
			url: 'ajax/orders/gen-invoice.php',
			data: {id_order:id_order},
			success: function(id_invoice){
				window.location.href="../pdf/invoice.php?id_invoice="+id_invoice+"&id_customer="+id_customer;
			}
		});
	});

	
	//product form
  $("form#product_form").submit(function(event){
    event.preventDefault();
    /*$('#product_form input').each(function(){
    	if( $(this).val() === "") return false;
    });*/

    //return false;
    
    submit_ajax_form("product_form", function(data) {
    	if( data.row ) $( data.row ).prependTo("#order_products > tbody");
    	$('#product_form input').not('.id_order').val('');
    	$('#product_form select option:selected').prop('selected', false);
    	$('#based_attributs').prop('disabled', true).addClass('hidden');
    	refresh_products_total();
    	os_message_notif("<?=l('Le produit a été enregistré avec succès', 'admin');?>");
    });
    return false;
  });

  //carrier form
  $("form#carrier_form").submit(function(event){
    event.preventDefault();
    submit_ajax_form("carrier_form", function(data) {
    	os_message_notif( data );
    });
    return false;
  });

	
	//update product
	$('#order_products').on('click', '.update', function() {
		var tr = $(this).closest('tr');
		var id_order = $('#id_order').val();
		var id_customer = $('#id_customer').val();
		//product array
		var product = {};
		product['id'] = tr.attr('id');
		product['product_name'] = tr.find('input.name').val().replace(/'/g, "\\'");
		product['product_reference'] = tr.find('input.reference').val().replace(/'/g, "\\'");
		product['product_price'] = tr.find('input.price').val();
		product['product_quantity'] = tr.find('input.quantity').val();
		product['product_weight'] = tr.find('input.weight').val();
		//object to array
		product = JSON.stringify(product);
		//send ajax request
		$.ajax({
			type: "POST",
			url: ajaxurl + 'update/product.php',
			data: {product:product,id_order:id_order,id_customer:id_customer},
			success: function(data){
				var data = $.parseJSON(data);
				refresh_products_total();
				//notif message
				os_message_notif("<?=l('Le produit a été mise à jour.', 'admin');?>");
			},
      error: function(jqXHR, textStatus, errorThrown){
      	get_error_message(textStatus, errorThrown);
      }
		});
	});

	//based product
	$('#based_product').on('change', function(){
		var id_product = $(this).find('option:selected').val();
		//$('#add_product input[type=number]').val('');
		$('#add_product input:not(".id_order")').val('');
		if( id_product == "" ) return;
    $.ajax({
      type: "POST",
      data: {id_product:id_product},
      url: ajaxurl + 'load-product.php',
      success: function(data){
      	var data = $.parseJSON(data);
      	if (data.dec !== undefined){
      		$('#based_attributs option').not(':eq(0)').remove();
      		$('#based_attributs ')
	      		.prop('disabled', false)
	      		.append( data['dec'] )
	      		.removeClass('hidden');
      		//notif message
					os_message_notif("<?=l('Sélectionnez une attribut.', 'admin');?>");
	      }else{
	      	$('#based_attributs')
	      	.prop('disabled', true)
	      	.addClass('hidden');
      		fill_product_data(data);
	      }
      },
      error: function(jqXHR, textStatus, errorThrown){
      	get_error_message(textStatus, errorThrown);
      }
    });
	});

	//based attributs
	$('#based_attributs').on('change', function(){
		var id_dec = $(this).find('option:selected').val();
		var dec = $(this).find('option:selected').text();
		$('#add_product input:not(".id_order")').val('');
		$('input.attributs').val(dec);
		if( id_dec == "" ) return;
    $.ajax({
      type: "POST",
      data: {id_dec:id_dec},
      url: ajaxurl + 'load-attributs.php',
      success: function(data){
      	var data = $.parseJSON(data);
      	fill_product_data(data);
      },
      error: function(jqXHR, textStatus, errorThrown){
      	get_error_message();
      }
    });
	});

	//delete-product
	$('#order_products').on('click', '.delete', function(){
		var choice = confirm("<?=l('Cette action supprime définitivement le produit de la base de donné. Êtes-vous vraiment sûr ?', 'admin');?>");
		if (choice == false) return;
		var id = $(this).closest('tr').attr('id');
		var id_order = $('#id_order').val();
		var id_customer = $('#id_customer').val();
    $.ajax({
      type: "POST",
      data: {id:id,id_order:id_order,id_customer:id_customer},
      url: ajaxurl + 'delete/product.php',
      success: function(data){
      	//refresh total
      	refresh_products_total();
      	os_message_notif( "<?=l('Le produit a été supprimer avec success.', 'admin');?>" );
				//remove row
				$('#order_products tbody tr#'+id).fadeOut(500, function() { 
      		$(this).remove(); 
      	});
      },
      error: function(jqXHR, textStatus, errorThrown){
      	get_error_message(textStatus, errorThrown);
      }
    });
	});

	
});


function refresh_products_total(){
	var id_order = $('#id_order').val();
	var id_customer = $('#id_customer').val();
	$.ajax({
    type: "POST",
    data: {id_order:id_order,id_customer:id_customer},
    url: ajaxurl + 'refresh/total.php',
    success: function(data){
    	var data = $.parseJSON(data);
    	$('table#order_total > tbody').empty().append( data );
    },
    error: function(jqXHR, textStatus, errorThrown){
    	get_error_message(textStatus, errorThrown);
    }
  });
}

function fill_product_data(data){
	//console.log(data)
	$('#add_product input.name').val( data['product_name'] );
	$('#add_product input.image').val( data['product_image'] );
	$('#add_product input.reference').val( data['product_reference'] );
	$('#add_product input.price').val( data['product_price'] );
	$('#add_product input.buyprice').val( data['product_buyprice'] );
	$('#add_product input.discount').val( data['product_discount'] );
	$('#add_product input.loyalty_points').val( data['loyalty_points'] );
	$('#add_product input.product_packing').val( data['product_packing'] );
	$('#add_product input.quantity').val( '1' );
	$('#add_product input.weight').val( data['product_weight'] );
	//notif message
	os_message_notif("<?=l('Le produit a été changé.', 'admin');?>");
}    	
</script>