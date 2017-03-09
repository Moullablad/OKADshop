<div class="row">
    <div class="col-xs-6">
        <strong> <?php trans_e("From:", "stk"); ?> </strong><br>
        <img src="<?=get_logo(); ?>" height="60">
        <h4>PT. Nobelo K</h4>
        <p id="from">
            <span class="address">Jl. Wisma Menanggal I/ No. 28</span>,<br>
            <span class="country">India</span>,<br>
            <span class="city">Indonesia</span>,<br>
            <?php trans_e("Phone:", "stk"); ?> <span class="phone">0318289865</span>,<br>
            <?php trans_e("Email:", "stk"); ?> <span class="email">nobelcomm@gmail.com</span>,<br>
        </p>
    </div>
    <div class="col-xs-6">
        <strong> <?php trans_e("TO:", "stk"); ?> </strong>
        <div class="form-group">
        	<input id="id_customer" name="id_customer" type="hidden" value="">
            <input type="text" id="customers" class="form-control" placeholder="<?php trans_e("Client Name", "stk"); ?>" autocomplete="off" style="max-width: 450px;">
        </div>
        <p id="toclient">
        	<span class="address1">No: 34, New street, New Jersey</span>,<br>
        	<span class="address2">New Jersey,New Jersey</span>,<br>
        	<span class="country">America - 456457</span>
        </p>
    </div>
</div>


<div class="row">
	<div class="col-md-12">
		<p class="mb-30" id="action-buttons">
			<button class="btn btn-danger delete" type="button">- <?php trans_e("Delete", "stk"); ?></button>
			<button class="btn btn-success addnew" type="button">+ <?php trans_e("Add More", "stk"); ?></button>
		</p>
		<table class="table table-striped table-bordered mb-10" id="items">
			<thead>
				<tr>
					<th width="25" align="center"><input type="checkbox" class="checkall"></th>
					<th width="30%"><?php trans_e("Product Name", "stk"); ?></th>
					<th><?php trans_e("Reference", "stk"); ?></th>
					<th><?php trans_e("Price", "stk"); ?></th>
					<th><?php trans_e("Discount", "stk"); ?> (%)</th>
					<th><?php trans_e("Quantity", "stk"); ?></th>
					<th><?php trans_e("Total", "stk"); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php if( !empty($items) ) : foreach ($items as $key => $item) : ?>
				<tr>
					<td>
						<input type="checkbox" class="check-item">
						<i class="fa fa-sort"></i>
					</td>
					<td>
						<input type="text" name="items[<?=$key;?>][name]" value="<?=$item->name;?>" class="form-control product_name" placeholder="<?php trans_e("Type product name or reference to search.", "stk"); ?>" required>
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
						<input type="number" min="1" step="1" name="items[<?=$key;?>][quantity]" value="<?=$item->quantity;?>" class="form-control quantity" required>
					</td>
					<td>
						<input type="text" value="0.00" class="form-control total_line" disabled>
					</td>
				</tr>
			<?php endforeach; endif; ?>
			</tbody>
		</table>
	</div><!-- /.col-md-12 -->
</div>


<div class="row">
	<div class="col-md-6">
        <p class="mb-30" id="action-buttons">
        	<button class="btn btn-danger delete" type="button">- Delete</button>
        	<button class="btn btn-success add_new" type="button">+ Add More</button>
        </p>
        <div id="footer-tabs">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
		        <li role="presentation" class="active">
		            <a href="#note-tab" aria-controls="note-tab" role="tab" data-toggle="tab" aria-expanded="true">Note To Client</a>
		        </li>
		        <li role="presentation" class="">
		            <a href="#invoice-terms-tab" aria-controls="invoice-terms-tab" role="tab" data-toggle="tab" aria-expanded="false">Invoice Terms</a>
		        </li>
		        <li role="presentation" class="">
		            <a href="#footer-tab" aria-controls="footer-tab" role="tab" data-toggle="tab" aria-expanded="false">Footer Text</a>
		        </li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content mt-10">
	            <div role="tabpanel" class="tab-pane active" id="note-tab">
	                <div class="form-group">
	                    <textarea name="invoice_notes" id="invoice_notes" class="form-control smartTextChange" placeholder="Your Notes" rows="5"></textarea>                        </div>
	            </div>
	            <div role="tabpanel" class="tab-pane" id="invoice-terms-tab">
	                <div class="form-group">
	                    <textarea name="invoice_terms" id="invoice_terms" class="form-control smartTextChange" placeholder="Invoice Terms &amp; Conditions" rows="5"><?= $terms; ?></textarea>                        </div>
	            </div>
	            <div role="tabpanel" class="tab-pane" id="footer-tab">
	                <div class="form-group">
	                    <textarea name="invoice_footer" id="invoice_footer" class="form-control smartTextChange" placeholder="Invoice Footer Text" rows="5"><?= $terms; ?></textarea>
	                </div>
	            </div>
	        </div>
        </div>
	</div><!-- col-md-6 -->
	<div class="col-md-3 col-md-offset-3">
		<table class="table table-striped table-bordered pull-right" id="totals">
			<tbody>
				<tr>
					<th><?php trans_e("Subtotal", "stk"); ?></th>
					<td><span class="subtotal">0.00</span> <?=get_currency(); ?></td>
				</tr>
				<tr>
					<th><?php trans_e("Discount", "stk"); ?></th>
					<td><span class="discount">0.00</span> %</td>
				</tr>
				<tr>
					<th><?php trans_e("Tax", "stk"); ?></th>
					<td><span class="tax">0.00</span> %</td>
				</tr>
				<tr>
					<th><?php trans_e("Total", "stk"); ?></th>
					<td><span class="total">0.00</span> <?=get_currency(); ?></td>
				</tr>
				<tr>
					<th><?php trans_e("Amount Paid", "stk"); ?></th>
					<td><span class="amount_paid">0.00</span> <?=get_currency(); ?></td>
				</tr>
				<tr>
					<th><?php trans_e("Amount Due", "stk"); ?></th>
					<td><span class="amount_due">0.00</span> <?=get_currency(); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>