(function($){

	var stringsTable = $('#stringsTable').dataTable({
		// searching: false,
		// bLengthChange: false
	});


    $('#flag-strap').flagStrap({
    	placeholder: {
            value: "",
            text: trans("Choose a flag", "lang")
        }
    });


    /*var langs = {};
	jQuery('#lang_list option').each(function(){
		var value = jQuery(this).val().split(':');
		var text = jQuery(this).text().split(' - ');
		langs[value[1]] = {
			'name': text[0],
			'locale': value[1],
			'iso_code': value[0],
			'direction': value[2],
			'flag': value[3]		
		}
	})
	console.log(JSON.stringify(langs))*/



    $('#lang_list').change(function() {
    	var option = $(this).find('option:selected');
    	var flag = option.data('flag');
		$('input#name').val(option.text());
		$('input#iso_code').val(option.data('iso_code'));
		$('input#locale').val(option.val());
		var flag_option = $('select#flags option[value="'+ flag +'"]');
		if( flag_option.length > 0 ) {
			// Change selected option
			flag_option.prop('selected', true)
			$('select#flags').trigger('change')
			// get old flag
			var button_icon = $('#flag-strap button i.flagstrap-icon');
			var old_flag = button_icon.attr("class")
			old_flag = old_flag.replace('flagstrap-icon flagstrap-', '')
			button_icon.toggleClass('flagstrap-'+old_flag+' flagstrap-'+flag.toLowerCase())
			$('#flag-strap button span:first').contents().last()[0].textContent = ' '+ flag_option.text();
		}
		$('#direction').bootstrapSwitch('state', option.data('direction'));
	});
 

 	// Change input date value
 	$('#date_format').change(function(){
 		okad_ajax('date_time_format', {date: $(this).val()}, 'POST', function(response){
 			$('#date_format_preview').val(response.date)
		});	
 	})

 	$('#datetime_format').change(function(){
 		okad_ajax('date_time_format', {date: $(this).val()}, 'POST', function(response){
 			$('#datetime_format_preview').val(response.date)
		});
 	})


 	$('#groups').change(function(){
 		var group = $(this).val();
 		$('#locations').find('option').not(':first').remove()
 		if( group != '' ) {
 			okad_ajax('get_trans_location_by_group', {group: group}, 'POST', function(response){
 				$('#locations').prop('disabled', false);
 				var options = '';
	 			$.each(response, function(k, v){
	 				options += '<option value="'+ k +'">'+ v +'</option>';
	 			});
	 			$('#locations').append(options);
			});
 		} else {
 			$('#locations').prop('disabled', true);
 		}
 	});

 	$('#stringsForm select, #stringsForm input').change(function(){
 		var iso_code = $('select#iso_code').val();
 		var group = $('select#groups').val();
 		var location = $('select#locations').val();
 		var keywords = $('input#keywords').val();
 		if( iso_code != '' && location != '' ) {
 			okad_ajax('get_strings', {
 				iso_code: iso_code, 
 				group: group,
 				location: location,
 				keywords: keywords
 			}, 'POST', function(response){
 				var strings = JSON.parse(response);
 				stringsTable.fnClearTable();
 				if( !$.isEmptyObject(strings) ){
 					stringsTable.fnAddData(strings);
 				}
 			});
 		} else {
 			stringsTable.fnClearTable();
 		}
 		createCookie('strings_trans_' + $(this).attr('id'), $(this).val());
 	});

 	if( $('#stringsForm').length > 0 ) {
 		$('#iso_code').trigger('change')
 	}


 	//find by keywords
	$('#stringsForm	input#keywords').keyup( function () {
		stringsTable.fnFilter( this.value );
	});


	// save changed strings
	$('body').on('change', 'input.msgstr', function(){
		okad_ajax('update_string', {
			iso_code: $('#iso_code').val(),
			location: $('#locations').val(),
			msgid: $(this).closest('tr').find('td:first').text(),
			msgstr: $(this).val(),
		}, 'POST', function(response){
			if( response.success ) {
				message_notif(response.success)
			} else if( response.error ) {
				message_notif(response.error, {type:'danger'})
			}
		});
	});




})(jQuery);