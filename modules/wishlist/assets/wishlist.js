$( document ).ready(function() {

	var ajax_url = 'modules/wishlist/ajax/';

	$('.add_to_wishlist').click(function(event){
		event.preventDefault();

		var wishlist = readCookie("wishlist");
		var id_product = $(this).data('prod');

		if( wishlist != null ){
			wishlist = $.parseJSON(wishlist);
		} else {
			wishlist = [];
		}
		var message = '';
		if( $.inArray( id_product, wishlist ) === -1 ){
			wishlist.push(id_product);
			wishlist = JSON.stringify(wishlist);
			createCookie("wishlist", wishlist);
			message = trans("Product was added to wishlist.", "wishlist");
		} else {
			message = trans("Product already exist in wishlist.", "wishlist");
		}

		var content = '<div class="wishlist-popup">\
			<div class="message">\
			    <i class="fa fa-check-circle-o fa-3x"></i>\
			    <p>'+ message +'</p>\
			</div>\
		    <a href="'+ generate_url('account/wishlist/?tab=wishlist') +'" class="btn btn-wishlist">\
			     <i class="fa fa-heart"></i> \
			     '+ trans("View my wishlist.", "wishlist") +'\
		    </a>\
		</div>';
		$.magnificPopup.open({
			items: {
				src: content,
				type: 'inline'
			}
	    });
		/*var url = ajax_url + 'add.php';
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
		});*/
	});
	

	//delete from wishlist
	var delete_btn = $('<a href="#" class="delete"><i class="fa fa-times-circle"></i></a>');
	$('#wishlist-items .product').append(delete_btn);

	$('#wishlist-items .product .delete').click(function(event){
		event.preventDefault();
		var id_product = $(this).closest('.product').find('.add_to_cart').data('prod');
		var wishlist = readCookie("wishlist");
		if( wishlist != null ){
			wishlist = $.parseJSON(wishlist);
			wishlist = $.grep(wishlist, function(value) {
			  return value != id_product;
			});
			wishlist = JSON.stringify(wishlist);
			createCookie("wishlist", wishlist);
			$(this).closest('.product').fadeOut('slow');
		}
	});


	




});