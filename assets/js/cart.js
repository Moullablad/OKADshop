$(document).ready(function() {


    //add coupon code
    $( "#coupon-code" ).submit(function( event ) {
        event.preventDefault();

        var code = $(this).find('input#code').val();
        if( code == '' ) return false;

        var url = 'includes/ajax/cart/coupon-code.php';
        var data = {code: code};

        //manupulate results
        ajax_handler(url, data, 'post', function(response) {
            if( response == "DONE" ){
                message_notif("Coupon code added successfully.");
                setTimeout(function(){ 
                    location.reload();
                }, 2000);
            } else if( response == "ERROR_SAVE" ){
                message_notif("Error coupon code.", {type : "danger"});
            } else if( response == "NOT_FOUND" ){
                message_notif("Coupon code not found.", {type : "danger"});
            }
        });

        return true;
    });

    //add coupon code
    $( "#delete-coupon" ).on('click', function( event ) {
        event.preventDefault();
        var url = 'includes/ajax/cart/coupon-delete.php';
        ajax_handler(url, {}, 'post', function(response) {
            if( response == "DONE" ){
                message_notif("Coupon code was deleted successfully.");
                setTimeout(function(){ 
                    location.reload();
                }, 2000);
            } else if( response == "ERROR_DELETE" ){
                message_notif("Error deleting coupon code.", {type : "danger"});
            }
        });
    });




});


//================================================================================
//
// Functions
//
//================================================================================

/**
 * AJAX ADD TO CART 
 * @param args json
 * @param handle_data callback
 **/
function ajax_add_to_cart(args, handle_data){

	// Exit if empty json
	if( args.id_product == "" || args.qty == "" ) return false;

	// Fire off the request to /form.php
    request = $.ajax({
        url: "includes/ajax/cart/items.php",
        type: "post",
        data: {
        	id_product : args.id_product,
        	id_declinaison : args.id_declinaison,
        	qty : args.qty
        }
    });

    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
    	try {
            var data = $.parseJSON(response);
            if( data.error ){
                message_notif(data.error, {
                    type : "danger", 
                    delay: 4000, 
                    width: "150px", 
                    align: "center"
                });
            } else if( data.cart ){
          		handle_data( data.cart );//check if response is json
            }
	    }catch (e) {
	    	error_message();
	    }
    });
    // Callback handler that will be called on failure
	request.fail(function (jqXHR, textStatus, errorThrown){
		error_message();
	    // Log the error to the console
	    console.error("The following error occurred: "+ textStatus, errorThrown);
	});

    // Prevent default posting of form
    event.preventDefault();

}


/**
 * AJAX REMOVE ITEM FROM CART 
 * @param args json
 * @param handle_data callback
 **/
function ajax_remove_from_cart(id_product, id_declinaison){
    // Exit if empty json
    if( id_product < 1 ) return false;

    var url = 'includes/ajax/cart/remove-item.php';
    var data = {
        id_product : id_product,
        id_declinaison : id_declinaison,
    }

    //manupulate results
    ajax_handler(url, data, 'post', function(obj) {
        if( obj.success ){
            
        }
    });

    return true;
}



/**
 * AJAX REFRESH CART ITEMS
 * @param args json
 **/
function ajax_refresh_block_cart(handle_data){
    var url = 'includes/ajax/cart/refresh.php';
    var data = {};

    //manupulate results
    ajax_handler(url, data, 'post', function(obj_data) {
        //check if response is json
        handle_data( obj_data );
    });

    return true;
}


/**
 * AJAX CART CART ITEMS
 * @param items json
 **/
function ajax_update_cart(items, handle_data){

    var url = 'includes/ajax/cart/update.php';
    var data = {
        items: JSON.stringify(items)
    };

    //manupulate results
    ajax_handler(url, data, 'post', function(obj_data) {
        //check if response is json
        handle_data( obj_data );
    });

    return true;
}


/**
 * AJAX CLEAR CART ITEMS
 * @param args json
 **/
function ajax_clear_cart(handle_data){
    var url = 'includes/ajax/cart/clear.php';
    var data = {};

    //manupulate results
    ajax_handler(url, data, 'post', function(obj_data) {
        //check if response is json
        handle_data( obj_data );
    });

    return true;
}