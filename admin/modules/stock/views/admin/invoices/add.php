<section class="panel">
	<header class="panel-heading"><?php trans_e("Create Invoice", "stk"); ?></header>
	<form method="post" action="<?=get_current_url(); ?>" class="form-horizontal">
	<div class="panel-body">
		
		<input id="id_customer" name="id_customer" type="hidden" value="">
		<div class="form-group">
			<label class="col-lg-3 control-label" for="customer"><?php trans_e("Customer", "stk"); ?></label>  
			<div class="col-lg-4">
				<input id="customers" type="text" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label" for="tax"><?php trans_e("Tax Rate", "stk"); ?></label>  
			<div class="col-lg-2">
				<select name="tax" class="form-control" id="tax">
					<option value="0"><?php trans_e("Choose Tax Rate", "stk"); ?></option>
					<?php if( !empty($taxes) ) : foreach ($taxes as $key => $tax) : ?>
						<option value="<?=$tax->id;?>"><?=$tax->name;?></option>
					<?php endforeach; endif; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label" for="created"><?php trans_e("Invoice date", "stk"); ?></label>  
			<div class="col-lg-2">
				<input id="created" name="created" value="<?=date('Y-m-d H:i:s');?>" type="text" class="form-control datetime" required>
			</div>
		</div>

	</div><!-- /.panel-body -->
	<div class="panel-footer">
	    <a type="button" href="<?=get_page_url('invoices', __FILE__); ?>" class="btn btn-default"><?php trans_e("Close", "stk"); ?></a>
	    <button name="invoice_form" type="submit" class="btn btn-primary pull-right"><?php trans_e("Save and continue", "stk"); ?></button>
	</div><!-- /.panel-footer -->
	</form>
</section>	
