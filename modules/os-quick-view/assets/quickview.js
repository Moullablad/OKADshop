$( document ).ready(function() {

	var ajax_url = 'modules/os-quick-view/ajax/';

	$('.quick-view').click(function(event){
		event.preventDefault();
		var url = ajax_url + 'content.php';
		var data = {id_product: $(this).data('prod')};
		ajax_handler(url, data, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger", align : "right", width : "100"});
			} else if( response.content ){
			    $.magnificPopup.open({
					items: {
						src: response.content,
						type: 'inline'
					}
			    });		
			}
		});
	});


	//get product combinations
	$('body').on('change', '#combinations select', function(){
		var combinations = {};
		$(this).each(function(){
			var id_attribute = $(this).data('id');
			if( combinations[id_attribute] === undefined){
            	combinations[id_attribute] = "";
			}
            combinations[id_attribute] = $(this).find('option:selected').val();
		});
		//get combinations data
		var json = JSON.stringify(combinations);
		//manupulate results
		ajax_get_combinations(json, function(obj) {
			$('.quick-view-popup .thumb').removeClass('hidden');
			//check if response is json



	        if( obj.comb ){
	        	//show cart_form form
				$('#cart_form').show();        	
	        	var comb = $.parseJSON(obj.comb);
	        	$('#availability_statut').empty().html('<span>'+ comb.quantity +' Item(s)</span>&nbsp;&nbsp;<span class="label label-success">In stock</span>');
	        	$('input#idDeclinaison').val(comb.id);

	        	var del = $('.quick-view-popup .price del').text();
	        	if( parseFloat(del) < comb.price ){
	        		$('.quick-view-popup .price del').hide();
	        	} else {
	        		$('.quick-view-popup .price del').show();
	        	}
	        	$('.quick-view-popup .price span').text(comb.price);

	        	/*try {
		    		var images = $.parseJSON(comb.images);
	        		//hide other images
					$('.quick-view-popup .thumb img').filter(function( index ) {
						var img_src = $( this ).attr('src');
						var fname = get_file_name(img_src).replace('-45x45', '');
					    return $.inArray( fname, images ) === -1;
				  	}).addClass('hidden');
			    }catch (e) {
			    	$('.quick-view-popup .thumb').removeClass('hidden');
			    }*/

	        } else if( obj.empty ){
				$('#cart_form').hide();
				$('#idDeclinaison').val('');
	        	$('#availability_statut').empty().html('<span id="availability_value" class="label label-warning">'+ obj.empty +'</span>');
	        }
			
		});
		return false;
	});


	//Cart form add to Cart
	$('body').on('click', '.quick-view-popup #add_to_cart', function(){
    	event.preventDefault();
		var args = [];
		args['id_product'] = $('#cart_form #idProduct').val();
		args['id_declinaison'] = $('#cart_form #idDeclinaison').val();
		args['qty'] = $('#cart_form input.quantity').val();
		args['title'] = $('.quick-view-popup .product-info h1').text();
		args['link'] = "#";
        var img_src = $('.quick-view-popup .thumb img').attr('src');
		args['cover'] = get_cover(img_src, '360x360');
		add_to_cart(args);
		return false;
	});

	
});