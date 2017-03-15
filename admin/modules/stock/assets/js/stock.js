var stock_ajaxurl = admin_dirname('modules/stock/includes/ajax/');


(function($) {
	"use strict";

	$('.deleteAction').click(function(e){
    	var choice = confirm( trans("This option completely removes the image on your server. Are you really sure?", "default") );
		if (choice == false) {
			e.preventDefault();
		}
	});


	//Quotation Rows
	$('#quoteProducts .add_new').click(function(e){
		e.preventDefault();
		var first_row = $(this).closest('tr').clone();
		first_row.find('input').val('');
		var add_new = first_row.find('.add_new');
		add_new.toggleClass('btn-primary btn-danger');
		add_new.toggleClass('add_new delete');
		add_new.find('i').toggleClass('fa-plus fa-minus');
		$('#quoteProducts').append(first_row);
		productAutoComplete();
	});
	$('#quoteProducts').on('click', '.delete', function(e){
		e.preventDefault();
		$(this).closest('tr').remove();
		updateQuoteTotal();
	});
	$('#quoteProducts').on('change', 'input[type="number"]', function(e){
		e.preventDefault();
		updateQuoteTotal();
	});
	updateQuoteTotal();




	//Get Customers
	if( $('#customers').length > 0 ) {
		$('#customers').autocomplete({
		    serviceUrl: stock_ajaxurl + 'customers.php',
		    onSelect: function (result) {
		    	console.log(result.id)
		    	$('#id_customer').val(result.id_customer);
		    }
		});
	}


	/* Stock total table */
	var tableItemsWidth = $('table#items thead th:last').outerWidth();
	$('table#totals tbody td:first').css('width', tableItemsWidth+'px');


	//Get Products
	productAutoComplete();



})(jQuery);



// Calculate products price
function updateQuoteTotal(){
	var total = discount_total = discount_amount = tax_total = tax_amount = total_ht = 0;
	var rows_count = $('#quoteProducts tbody tr').length;
	$('#quoteProducts tbody tr').each(function(){
		var price = $(this).find('input.price').val();
		var discount = $(this).find('input.discount').val();
		var tax = $(this).find('input.tax').val();
		var quantity = $(this).find('input.quantity').val();

		//Add discount
		if( discount > 0 ){
			discount_total += parseFloat( discount );
			discount_amount = (price * discount) / 100;
		}

		//Add Tax
		if( tax > 0 ){
			tax_total += parseFloat( tax );
			tax_amount = (price * tax) / 100;
		}

		//calcule
		total_ht += price * quantity;
		total += (total_ht + tax_amount) - discount_amount;
	});
	tax_total = tax_total / rows_count;
	discount_total = discount_total / rows_count;
	$('#quoteTotal td .discount').text( discount_total.toFixed(2) );
	$('#quoteTotal td .tax').text( tax_total.toFixed(2) );
	$('#quoteTotal td .tht').text( total_ht.toFixed(2) );
	$('#quoteTotal td .total').text( total.toFixed(2) );
}



//Auto complete
function productAutoComplete(){
	if( $('#customers').length < 1 ) return;
	$('.product_name').autocomplete({
	    serviceUrl: stock_ajaxurl+'products.php',
	    onSelect: function (result) {


	    	console.log(result)
	    	// $('#quoteCustomer .reference').val(result.data.clt_number);
	    }
	});
}