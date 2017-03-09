$( document ).ready(function() {


	//submit contact form
	$("form#contactForm").submit(function(event){
		event.preventDefault();

		// var loading = $('<img src="modules/contact-form/assets/img/loading.gif" class="pull-left" width="30" height="30">');
		// $(loading).insertAfter('form input[type="submit"]');

		ajax_form("contactForm", function(data) {
			if( data.success ){
				$('.form-contact .loading').remove();
				$(".form-contact").find("input, textarea").val('');
				//$(loading).remove();
			 	message_notif( data.success );
			}
		});
		return false;
	});

});