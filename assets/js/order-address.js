//================================================================================
//
// Functions
//
//================================================================================

/**
 * AJAX GET ORDER ADDRESS
 * @param args json
 **/
function ajax_order_address(id_address, address_type, handle_data){
    var url = 'includes/ajax/order/address.php';
    var data = {
    	id_address: id_address,
    	type: address_type
    };

    //manupulate results
    ajax_handler(url, data, 'post', function(obj_data) {
        //check if response is json
        handle_data( obj_data );
    });

    return true;
}

function ajax_use_same_addresses(id_billing){
	// Fire off the request to request_url
    request = $.ajax({
        url: 'includes/ajax/order/same-addresses.php',
        type: 'post',
        data: { id_billing: id_billing}
    });
    return true;
}