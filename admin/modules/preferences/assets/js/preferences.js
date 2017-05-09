$(document).ready(function() {

	var ajax_url = admin_dirname() + 'modules/preferences/includes/ajax/';


	/**
     * Load translation
     */
    $("#shop #languages").on('change', function(){
        var id_lang = $(this).val();
        ajax_handler(ajax_url + 'trans/shop.php', {id_lang: id_lang}, 'post', function(data) {
            createCookie('shop_lang', id_lang);
            $('#shop #name').val(data.name);
            $('#shop #tagline').val(data.tagline);
            $('#shop #meta_title').val(data.meta_title);
            $('#shop #meta_description').val(data.meta_description);
            $('#meta_keywords').tagsinput('removeAll');
            $("#meta_keywords").tagsinput('add', data.meta_keywords);
        }); 
    }); 




//END DOCUMENT
});