(function(window){

	var empty_cart = $('<div class="container" id="emptyCart" style="min-height:350px;">\
		<div class="alert alert-warning">Your shopping cart is empty.</div>\
	</div>');

	//Cart form add to Cart
	$('#cart_form').submit(function(event){
		// Prevent default posting of form
    	event.preventDefault();
		var args = [];
		args['id_product'] = $('#cart_form #idProduct').val();
		args['id_declinaison'] = $('#cart_form #idDeclinaison').val();
		args['qty'] = $('#cart_form input.qty').val();

		args['title'] = $('#single_product .product_title').text();
		args['link'] = window.location.href;
        var img_src = $('.product-thumb.active img').attr('src');
		args['cover'] = get_cover(img_src);

		add_to_cart(args);
		return false;
	});

	//ajax add to cart button
	$('.add_to_cart').on('click', function(event){
		// Prevent default posting of form
    	event.preventDefault();
		var args = [];
		args['id_product'] = $(this).data('prod');
		args['id_declinaison'] = $(this).data('dec');
		args['qty'] = 1;

		args['title'] = $(this).closest('.product').find('.product-info h3 a').text();
		args['link'] = window.location.href;
        var img_src = $(this).closest('.col-product').find('.product-thumb img').attr('src');
		args['cover'] = get_cover(img_src);

		add_to_cart(args);
		return false;
	});


	//Remove item from cart
	$('body').on('click', 'a.remove', function(event){
    	event.preventDefault();

    	//prepare data
		var id_product = $(this).data('prod');
		var id_declinaison = $(this).data('dec');

		//manupulate results
		var result = ajax_remove_from_cart(id_product, id_declinaison);
		if( result ){
			$(this).closest('.cart_item').remove();
			ajax_refresh_block_cart(function(cart) {
				if( cart.count == 0 && $('#orderSummary').length > 0 ){
					$('#orderSummary').replaceWith(empty_cart);
				}
				refresh_block_cart(cart);	
			});
		}

		return false;
	});


	//add quantity
	$('.quantity-plus').on('click', function(event){
		event.preventDefault();
		var input_qty = $(this).closest('.box-qty').find('.qty');
		var num = +input_qty.val() + 1;
		input_qty.attr('value', num);
		update_product_quantity();
	});
	$('.quantity-minus').on('click', function(event){
		event.preventDefault();
		var input_qty = $(this).closest('.box-qty').find('.qty');
		if( min_qty == undefined || input_qty.val() > min_qty ){
			var num = +input_qty.val() - 1;
			input_qty.val(num);
			update_product_quantity();
		}
	});


	//clear cart items
	$('#clear_cart').on('click', function(event){
		ajax_clear_cart(function(cart) {
			$('#orderSummary').replaceWith(empty_cart);
			refresh_block_cart(cart);	
		});
	});



	window.htmlentities = {
		/**
		 * Converts a string to its html characters completely.
		 *
		 * @param {String} str String with unescaped HTML characters
		 **/
		encode : function(str) {
			var buf = [];
			
			for (var i=str.length-1;i>=0;i--) {
				buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
			}
			
			return buf.join('');
		},
		/**
		 * Converts an html characterSet into its original character.
		 *
		 * @param {String} str htmlSet entities
		 **/
		decode : function(str) {
			return str.replace(/&#(\d+);/g, function(match, dec) {
				return String.fromCharCode(dec);
			});
		}
	};


	
})(window);

/**
 * ADD PRODUCT TO CART
 * @param args json
 **/
function add_to_cart(args){
	//manupulate results
	ajax_add_to_cart(args, function(cart) {
        if( cart.items ){
        	//refresh block cart
        	refresh_block_cart(cart);	
	    	var message = '<b><i class="fa fa-smile-o"></i> '+ trans("Product was added to shopping cart.", "mirzam");
	    	//message += '<a aria-hidden="true" class="btn btn-default"><i class="fa fa-long-arrow-left"></i> '+ trans('Continue shopping', 'mirzam') +'</a>';
	    	// message += '<a href="'+ generate_url('order/summary') +'" class="btn btn-primary mt-10"><i class="fa fa-shopping-cart"></i> '+ trans('View shopping cart', 'mirzam') +'</a>';
	    	//message_notif(message, {type : "success", align : "center", width : "450", delay : 3600});
        
	    	var result ='';
	        result += '<div class="popup-add-to-cart">';
	        result +='       <div class="message">';
	        result +='          <i class="fa fa-check-circle-o"></i>';
	        result +='          <p>'+ trans("Product was added to shopping cart.", "mirzam") +'</p>';
	        result +='      </div>';
	        result +='      <div class="popup-product">';
	        result +='          <img src="'+ args.cover +'" width="120" />';
	        result +='          <h3 class="product-name"><a href="'+ args.link +'">'+ args.title +'</a></h3>';
	        result +='          <a onclick="$.magnificPopup.close();" class="button button-continue-shop"><i class="fa fa-long-arrow-left"></i> '+ trans('Continue shopping', 'mirzam') +'</a>';
	        result +='          <a href="'+ generate_url('order/summary') +'" class="button button-view-cart"><i class="fa fa-shopping-bag"></i> '+ trans('View shopping cart', 'mirzam') +'</a>';
	        result +='      </div>';
	        result +='</div>';
	        $.magnificPopup.open({
	              items: {
	                src: result, // can be a HTML string, jQuery object, or CSS selector
	                type: 'inline'
	              }
	        });

        }
	});
}


/**
 * REFRESH BLOCK CART
 * @param items object
 **/
function refresh_block_cart(cart){
	var items_html = '';
	var items_count = sub_total = 0;

	if( $('#blockcart').length > 0 ){
	    if( cart.items ){
	    	//add items to cart
	    	$('.blockcart-content').show();
	    	$.each(cart.items, function(i, value){

	    		//get attributes values
	    		var attr_values = '';
	    		if( value.attrs ){
	    			$.each(value.attrs, function(attr, value){
	    				attr_values += '<b>'+ attr +'</b>: '+ value +', ';//(value.attrs != '') ? value.attrs : '';
	    			});
	    		}

	    		//console.log(cart.currency)

	    		var quantity = parseInt(value.qty);
	    		items_count += quantity;
	    		sub_total += parseFloat(value.price) * quantity;
	    		items_html += '<li>\
	                <div class="product-thumb">\
	                    <a href="'+ value.link +'"><img alt="" src="'+ value.cover +'"></a>\
	                </div>\
	                <div class="product-info">\
	                    <h5 class="product-name"><a href="'+ value.link +'">'+ value.name +'</a></h5>\
	                    <span class="price">'+ with_currency(value.price, cart.currency) +'</span>\
	                    <span class="qty">Qty: '+ value.qty +'</span>\
	                    <span class="attrs">'+ attr_values.slice(0,-2) +'</span>\
	                    <a class="remove" href="#" data-prod="'+ value.id_product +'" data-dec="'+ value.id_dec +'">remove</a>\
	                </div>\
	            </li>';
			});
	    } else {
	    	// $('.blockcart-content').hide();
	    	location.reload();
	    }

		//refresh block cart
	    $('#blockcart .cart-products').empty().html(items_html);
	    $('#blockcart .sub-toal .price').empty().html( with_currency(sub_total, cart.currency) );//sub_total.toFixed(2)
	    $('#blockcart .count').empty().html(items_count);
	}
}


//update product quantity
function update_product_quantity(){
	if( $('.shop_table .cart_item').length > 0 ){
		var items = {};
		var sub_total = 0;

		$('.loading').remove();
		var loading = $("<div class='loading'></div>");
		$(loading).appendTo(".cart_totals, .items_wrapper");	

		//var order_total = 0;
		$('.shop_table .cart_item').each(function(){
			var item = $(this).closest('.cart_item');
			var id_product = $(item).data('prod');
			var id_declinaison = $(item).data('dec');
			var quantity = $(item).find('.qty').val();	

	        //prepare items object array
	        if( parseInt(quantity) > 0 ){
				//if id_product not defined
		        if( items[id_product] === undefined)
		            items[id_product] = {};
		        
				if( id_declinaison > 0 ){
					items[id_product][id_declinaison] = parseInt(quantity);
				} else {
					items[id_product]['qty'] = parseInt(quantity);
				}
	        } else {
	        	$(item).remove();
	        }

			//total price
			var price = $(item).find('.product-price .amount').text();
			var sub_total = price * quantity;
			$(item).find('.product-subtotal .amount').text(sub_total.toFixed(2));
		});

		//update cart items
		ajax_update_cart(items, function(cart) {
			refresh_block_cart(cart);	

			var currency = htmlentities.decode(cart.currency);
			//totals
			$('.total_products .amount').text( with_currency(cart.total_products, currency) );
			$('.total_voucher .amount').text( with_currency(cart.total_voucher, currency) );
			$('.total_discount .amount').text( with_currency(cart.total_discount, currency) );
			$('.total_shipping .amount').text( with_currency(cart.total_shipping, currency) );
			$('.total_tax_excl .amount').text( with_currency(cart.total_tax_excl, currency) );
			$('.total_tax .amount').text( with_currency(cart.total_tax, currency) );
			$('.total_tax_incl .amount').text( with_currency(cart.total_tax_incl, currency) );

			//display custom notif
			$('.loading').remove();
			message_notif('Cart was updated', {
			    type: "success",
			    align: "right",
			    width: 200,
			});
		});
	}
}