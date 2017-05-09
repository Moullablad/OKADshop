$(document).ready(function() {

	var ajax_url = admin_dirname() + 'modules/themes/includes/ajax/';


	$('#themes .activate').click(function(){
		var url = ajax_url + 'activate.php';
		var data = {name: $(this).data('name')};
		ajax_handler(url, data, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger"});
			} else if( response.success ){
				location.reload();
				message_notif(response.success);
			}
		});
	});

	//install new theme
    $('#installTheme').filer({
        showThumbs: true,
        addMore: true,
        maxSize: 8,
        extensions: ['zip'],
        templates: {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: ' <li>{{fi-progressBar}}</li>',
            progressBar: '<div class="bar"></div>',
        },
        changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Drag&Drop files here</h3> <span style="display:inline-block; margin: 15px 0">or</span></div><a class="jFiler-input-choose-btn blue">Browse Files</a></div></div>',
        uploadFile: {
            url: ajax_url + 'install.php',
            type: 'POST',
            enctype: 'multipart/form-data',
            success: function(response, el){
                try {
                    if( data.error ){
                        message_notif(data.error, {type : "danger"});
                    } else if( data.success ){
                        //message_notif( data.success );
                        location.href = '?module=themes&controller=page&action=index';
                    }
                }catch (e) {
                    error_message();
                }
                $("#installTheme").prop("jFiler").reset();
            },
            error: function(el){
                message_notif( trans("Unable to install theme.", "themes") );
            },
            statusCode: null,
            onProgress: null,
            onComplete: null
        }
      });



//END DOCUMENT
});