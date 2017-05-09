$(document).ready(function() {
	var ajax_url = admin_dirname() + 'modules/seo/includes/ajax/';


	//Meta view refresh
	$('#metaForm input').keyup(function(){
		meta_view_refresh();
	});


	//Edit meta
	$('#metas .edit_meta').on('click', function(){
		var row  = $(this).closest('tr');
		var meta_id = $(row).data('id');
		console.log(meta_id)
		var type = $(row).find('td.mtype').text();
		var property = $(row).find('td.mproperty').text();
		var content = $(row).find('td.mcontent').text();
		$('#metaForm input#meta_id').val($.trim(meta_id));
		$('#metaForm input#meta_type').val($.trim(type));
		$('#metaForm input#meta_property').val($.trim(property));
		$('#metaForm input#meta_content').val($.trim(content));
	});



//END DOCUMENT
});


/**
 * Meta view refresh
 */
function meta_view_refresh(){
	$('#metaForm input').each(function(){
		var id = $(this).attr('id').replace('meta_', 'view_');
		var value = $(this).val();
		if( id == 'view_type' && value == '' ){
			$('#view_type').text('name');
		} else if( id == 'view_property' && value == '' ){
			$('#view_property').text('property');
		} else {
			$('#'+id).text(value);
		}
		if( $.trim($('#meta_content').val()) != '' ){
			$('#show_content').show();
		} else {
			$('#show_content').hide();
		}
	});
}