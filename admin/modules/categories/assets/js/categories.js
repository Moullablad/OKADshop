(function($){

	$('#cat_cover').filer({
        showThumbs: false,
        addMore: false,
        maxSize: 8,
        extensions: ['png', 'jpg', 'jpeg'],
	});


	$('ul[data-location="category"] select#languages').change(function(){
		var id_category = $('#id_category').val();
		if( id_category == '0' ) return;
		var id_lang = $(this).val();
 		okad_ajax('category_trans', {id_lang: id_lang, id_category: id_category}, 'POST', function(fields){
 			updateMultiLangFields(fields);
		});
 	});




})(jQuery);


function deleteCategoryCover() {
	okad_ajax('delete_category_cover', {id_category: get_url_param('id')}, 'POST', function(response){
		if( response.error ) {
			message_notif(response.error, {type:'danger'})
		} else if( response.success ) {
			$('#category-cover-wrap').remove();
			message_notif(response.success)
		}
	});
}