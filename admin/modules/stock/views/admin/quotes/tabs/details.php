<table id="quoteHeader">
	<tr>
		<th>
			<img src="<?=get_logo(); ?>" height="60">
		</th>
		<th align="right">
			<h2><?php trans_e('Quotation', 'stk'); ?></h2>
		</th>
	</tr>
</table>




<div class="panel-subheading">
	<i class="fa fa-user"></i>
	<strong><?php trans_e('Customer', 'stk'); ?></strong>
</div>
<div id="quoteCustomer">
	<input id="id_customer" type="hidden" value="<?=(isset($customer->id)) ? $customer->id : '';?>">
	<div class="form-group">
		<label class="col-sm-3 control-label" for="customers"><?php trans_e("Customer", "stk"); ?></label>  
		<div class="col-sm-3 col-md-3">
			<input type="text" class="form-control" id="customers" placeholder="Search a Customer">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="clt_number"><?php trans_e("Number", "stk"); ?></label>  
		<div class="col-sm-3 col-md-2">
			<input id="clt_number" type="text" class="form-control" value="<?=(isset($customer->clt_number)) ? $customer->clt_number : '';?>" disabled>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="company"><?php trans_e("Company", "stk"); ?></label>  
		<div class="col-sm-4 col-md-3">
			<input id="company" name="customer[company]" type="text" class="form-control" value="<?=(isset($customer->company)) ? $customer->company : '';?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="phone"><?php trans_e("Phone", "stk"); ?></label>  
		<div class="col-sm-4 col-md-3">
			<input id="phone" name="customer[phone]" type="text" class="form-control" value="<?=(isset($customer->phone)) ? $customer->phone : '';?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="email"><?php trans_e("Email", "stk"); ?></label>  
		<div class="col-sm-4 col-md-3">
			<input id="email" name="customer[email]" type="text" class="form-control" value="<?=(isset($customer->email)) ? $customer->email : '';?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="address"><?php trans_e("Address", "stk"); ?></label>  
		<div class="col-sm-4 col-md-5">
			<input id="company" name="customer[address]" type="text" class="form-control" value="<?=(isset($customer->address)) ? $customer->address : '';?>">
		</div>
	</div>
</div>




<div class="panel-subheading">
	<i class="fa fa-list"></i>
	<strong><?php trans_e('Items', 'stk'); ?></strong>
</div>

<table class="table table-striped table-bordered" id="quoteProducts">
	<thead>
		<tr>
			<th width="25"><?php //trans_e("Actions", "stk"); ?></th>
			<th width="40%"><?php trans_e("Name", "stk"); ?></th>
			<th><?php trans_e("Reference", "stk"); ?></th>
			<th><?php trans_e("Price", "stk"); ?></th>
			<th><?php trans_e("Discount", "stk"); ?> (%)</th>
			<th><?php trans_e("Tax", "stk"); ?> (%)</th>
			<th><?php trans_e("Quantity", "stk"); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php if( !empty($items) ) : foreach ($items as $key => $item) : ?>
		<tr>
			<td align="right">
				<input type="hidden" name="items[<?=$key;?>][id]" value="<?=$item->id;?>" class="form-control id_product">
				<?php if( $key != 0 ) : ?>
      				<a href="#" class="btn btn-danger delete" title="<?php trans_e("Delete", "stk"); ?>"><i class="fa fa-minus"></i></a>
      			<?php else : ?>
      				<a href="#" class="btn btn-primary add_new" title="<?php trans_e("Add", "stk"); ?>"><i class="fa fa-plus"></i></a>
      			<?php endif; ?>
			</td>
			<td>
				<input type="text" name="items[<?=$key;?>][name]" value="<?=$item->name;?>" class="form-control product_name" required>
			</td>
			<td>
				<input type="text" name="items[<?=$key;?>][reference]" value="<?=$item->reference;?>" class="form-control reference">
			</td>
			<td>
				<input type="number" name="items[<?=$key;?>][price]" min="0" step="0.01" value="<?=$item->price;?>" class="form-control price" required>
			</td>
			<td>
				<input type="number" name="items[<?=$key;?>][discount]" min="0" step="0.01" value="<?=$item->discount;?>" class="form-control discount">
			</td>
			<td>
				<input type="number" name="items[<?=$key;?>][tax]" min="0" step="0.01" value="<?=$item->tax;?>" class="form-control tax">
			</td>
			<td>
				<input type="number" min="1" step="1" name="items[<?=$key;?>][quantity]" value="<?=$item->quantity;?>" class="form-control quantity" required>
			</td>
		</tr>
	<?php endforeach; endif; ?>
	</tbody>
</table>


<div class="col-sm-3 col-xs-12 pull-right padding0">
	<table class="table table-striped table-bordered" id="quoteTotal">
		<tbody>
			<tr>
				<th width="150"><?php trans_e("Discount", "stk"); ?></th>
				<td><span class="discount">0</span> (%)</td>
			</tr>
			<tr>
				<th width="150"><?php trans_e("Tax", "stk"); ?></th>
				<td><span class="tax">0</span> (%)</td>
			</tr>
			<tr>
				<th width="150"><?php trans_e("Total HT", "stk"); ?></th>
				<td><span class="tht">0</span> <?=get_currency(); ?></td>
			</tr>
			<tr>
				<th width="150"><?php trans_e("Total", "stk"); ?></th>
				<td><span class="total">0</span> <?=get_currency(); ?></td>
			</tr>
		</tbody>
	</table>
</div><!--/ .col-sm-3 -->