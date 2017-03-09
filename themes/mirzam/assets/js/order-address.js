$(document).ready(function() {



	//use same addresses
	$('#sameAddresses').on('change', function(){
		if( !$(this).is(':checked') ){
			$('.billing').removeClass('hidden');
			var id_billing = $('#billing_address option:selected').val();
			ajax_use_same_addresses(id_billing);
		} else {
			$('.billing').addClass('hidden');
			ajax_use_same_addresses();
			var delivery = $('#delivery').html();
			$('#billing').empty().append(delivery);
			var href = $('.edit_delivery_addr').attr('href');
			$('.edit_billing_addr').attr('href', href);
		}
	});
	//get delivery address
	$('#delivery_address').on('change', function(){
		var id_adress = $(this).find('option:selected').val();
		ajax_order_address(id_adress, 'delivery', function(response){
			if( id_adress == '0' ){
				$('#delivery li').text('');
				$('.edit_delivery_addr').hide();
			} else {
				var data = response.address;
				var fullname = data.firstname + ' ' + data.lastname;
				$('ul#delivery .fullname').text(fullname);
				$('ul#delivery .company').text(data.company);
				$('ul#delivery .addresse').text(data.addresse);
				$('ul#delivery .codepostal').text(data.codepostal);
				$('ul#delivery .country').text(data.country);
				$('ul#delivery .phone').text(data.phone);
				$('ul#delivery .mobile').text(data.mobile);
				var url = $('.edit_delivery_addr').attr('href');
				url = url.substr(0, url.lastIndexOf("/"));
				var new_url = url +'/'+ id_adress;
				$('.edit_delivery_addr').attr('href', new_url);
				$('.edit_delivery_addr').show();

				if( $('#sameAddresses').is(':checked') ){
					var delivery = $('#delivery').html();
					$('#billing').empty().append(delivery);
					var href = $('.edit_delivery_addr').attr('href');
					$('.edit_billing_addr').attr('href', href);
				}

			}
		});
	});
	//get delivery address
	$('#billing_address').on('change', function(){
		var id_adress = $(this).find('option:selected').val();
		ajax_order_address(id_adress, 'billing', function(response){
			if( id_adress == '0' ){
				$('#sameAddresses').trigger('click');
				var delivery = $('#delivery').html();
				$('#billing').empty().append(delivery);
				var href = $('.edit_delivery_addr').attr('href');
				$('.edit_billing_addr').attr('href', href);
			} else {
				var data = response.address;
				var fullname = data.firstname + ' ' + data.lastname;
				$('ul#billing .fullname').text(fullname);
				$('ul#billing .company').text(data.company);
				$('ul#billing .addresse').text(data.addresse);
				$('ul#billing .codepostal').text(data.codepostal);
				$('ul#billing .country').text(data.country);
				$('ul#billing .phone').text(data.phone);
				$('ul#billing .mobile').text(data.mobile);
				var url = $('.edit_billing_addr').attr('href');
				url = url.substr(0, url.lastIndexOf("/"));
				var new_url = url +'/'+ id_adress;
				$('.edit_billing_addr').attr('href', new_url);
				$('.edit_billing_addr').show();
			}
		});
	});





});