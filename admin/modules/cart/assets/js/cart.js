$(document).ready(function() {

	var ajax_url = admin_dirname() + 'modules/cart/includes/ajax/';

	$('#os-tab-contents').on('click', '#labels .edit_label', function(){
		var row  = $(this).closest('tr');
		var slug = $(row).data('slug');
		var name = $(row).find('td.name').text();
		$('#labelForm input#name').val($.trim(name));
		$('#labelForm input#slug').val(slug);
	});


	//set default label
	$('#os-tab-contents').on('change', '#labels .cart_label', function(){
		var row  = $(this).closest('tr');
		var url = ajax_url + 'labels/default.php';
		var data = {
			slug: $(row).data('slug'),
			id_product: get_url_param('id')
		};
		ajax_handler(url, data, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger", align: "right"});
			} else if( response.success ){
				message_notif(response.success, {align: "right", width: "100px"});
			}
		});
	});	



});