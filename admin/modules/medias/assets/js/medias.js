$( document ).ready(function() {

	var ajax_url = 'modules/medias/ajax/';

	$('.medias').click(function(event){
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
	
});