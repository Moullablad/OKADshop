$(document).ready(function() {

	var ajax_url = admin_dirname() + 'modules/modules/includes/ajax/';
	var loading = $('<img src="../assets/img/icons/loading.gif" width="30" class="loadHook">');

	var norecord = '<tr class="norecord">\
		<td colspan="3">\
			<div class="alert alert-info alert-white rounded" id="message" style="display: block;margin: 12px auto;">\
			    <div class="icon"><i class="fa fa-info-circle"></i></div>\
			    <strong>'+ trans("There is no hook in this section.", "modules") +'</strong>\
			</div>\
		</td>\
	</tr>';

	var hTabale = $('#modulesHooks').dataTable({
		"bSort" : false,
		"pageLength": 10,
		"lengthChange": false,
		"orderable": false,
		//"info": false,
		"oLanguage": {
			"sSearch": "",
			"sSearchPlaceholder": "Find Hooks..."
		},
		"bAutoWidth": false,
		//"sDom": '<"row view-filter"<"col-sm-12"f>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>'
	});
	$('#modulesHooks_filter').parent().removeClass('col-sm-6').addClass('col-sm-12 left0');


	//modules filter table
	var moduleTabale = $('#moduleList table').dataTable({
		"bSort" : false,
		"pageLength": 10,
		"lengthChange": false,
		"orderable": false,
		"bAutoWidth": false,
		"language": {
			"emptyTable": "No results found matching your criteria",
			"zeroRecords": "No results found matching your criteria"
	    },
	});
	//find by keywords
	$('input#keywords').keyup( function () {
		moduleTabale.fnFilter( this.value );
		createCookie("keywords", $('#keywords').val());
	});
	//check all modules
	$('input[name="checkall"]').change(function(){
		var rows = moduleTabale.fnGetNodes();
		var checked = $(this).is(':checked');
		$.each(rows, function( index, tr ) {
			$( tr ).find(':checkbox').prop('checked', checked);
		});
	});
	//filter modules
	$('#filterForm select, #filterForm input#adminModules').change(function(){
		refrech_modules_table(moduleTabale, ajax_url);
	});
	//activate module
	$('#moduleList').on('click', '.enable', function(){
		var button = $(this);
		var url = ajax_url + 'enable.php';
		var data = {name: button.closest('tr').data('name')};
		$(button)
			.text( trans('Processing...', 'modules'))
			.toggleClass('btn-default btn-success')
			.addClass('disabled');

		ajax_handler(url, data, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger", align : "right", width : "100"});
			} else if( response.success ){
				message_notif(response.success, {align : "right", width : "100"});
				// $(button).replaceWith('<a class="btn btn-danger disable" href="#"><i class="fa fa-power-off"></i> '+ trans("Disable", "modules") +'</a>');
				refrech_modules_table(moduleTabale, ajax_url);
			}
		});
	});
	//disable module
	$('#moduleList').on('click', '.disable', function(){
		var button = $(this);
		var url = ajax_url + 'disable.php';
		var data = {name: button.closest('tr').data('name')};
		$(button)
			.text( trans('Processing...', 'modules'))
			.toggleClass('btn-danger btn-success')
			.addClass('disabled');

		ajax_handler(url, data, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger", align : "right", width : "100"});
			} else if( response.success ){
				message_notif(response.success, {align : "right", width : "100"});
				// $(button).replaceWith('<a class="btn btn-default enable" href="#"><i class="fa fa-power-off"></i> '+ trans("Enable", "modules") +'</a>');
				refrech_modules_table(moduleTabale, ajax_url);
			}
		});
	});
	//disable module
	$('#moduleList').on('click', '.delete', function(){
		var choice = confirm( trans("This option completely removes the module on your server. Are you really sure?", "modules") );
		if (choice == false) return;

		$('#moduleList a, #moduleList button').addClass('disabled');
  		$('#moduleList table tbody').append(loading);
  		
		var row = $(this).closest('tr');
		var url = ajax_url + 'delete.php';
		var data = {module_name: $(row).data('name')};
		ajax_handler(url, data, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger", align : "right", width : "100"});
			} else if( response.success ){
				loading.remove();
  				moduleTabale.fnDeleteRow(row);
  				$('#moduleList a, #moduleList button').removeClass('disabled');
				message_notif(response.success, {align : "right", width : "100"});
				refrech_modules_table(moduleTabale, ajax_url);
			}
		});
	});
	//uninstall module
	$('#moduleList').on('click', '.uninstall', function(){
		var choice = confirm( trans("This option completely uninstall the module from database. Are you really sure?", "modules") );
		if (choice == false) return;
		$('#moduleList a, #moduleList button').addClass('disabled');
  		$('#moduleList table tbody').append(loading);
		var row = $(this).closest('tr');
		var url = ajax_url + 'uninstall.php';
		var data = {module_name: $(row).data('name')};
		ajax_handler(url, data, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger", align : "right", width : "100"});
			} else if( response.success ){
				loading.remove();
  				moduleTabale.fnDeleteRow(row);
  				$('#moduleList a, #moduleList button').removeClass('disabled');
				message_notif(response.success, {align : "right", width : "100"});
				refrech_modules_table(moduleTabale, ajax_url);
			}
		});
	});
	//bulk actions
	$('#bulk-actions').submit(function(event){
		event.preventDefault();
		var action_name = $('#bulk-actions select option:selected').val();
		if( action_name == 'delete' ){
			var choice = confirm( trans("This option completely removes the modules on your server. Are you really sure?", "modules") );
			if (choice == false) return;
		}
		$('#moduleList .btn').addClass('disabled');
		if( action_name == '' ){
			message_notif(trans("Please select an action", "modules"), {type : "danger", align : "right"});
			loading.remove();
  			$('#moduleList .btn').removeClass('disabled');
			return false;
		}
		$('#moduleList table tbody').append(loading);
		var rows = moduleTabale.fnGetNodes();
		var modules = [];
		$.each(rows, function( index, tr ) {
			var checkbox = $( tr ).find(':checkbox');
			if( checkbox.is(':checked') ){
				var name = checkbox.closest('tr').data('name');
				modules.push(name);
			}
		});
		if( $.isEmptyObject(modules) ){
			message_notif(trans("Please check at least one module", "modules"), {type : "danger", align : "right"});
			loading.remove();
  			$('#moduleList .btn').removeClass('disabled');
			return false;
		}
		var url = ajax_url + 'bulk-actions.php';
		var data = {
			modules: JSON.stringify(modules),
			action: action_name
		};
		ajax_handler(url, data, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger", align : "right", width : "100"});
			} else if( response.success ){
				loading.remove();
				$('#moduleList .btn').removeClass('disabled');
  				refrech_modules_table(moduleTabale, ajax_url);
				message_notif(response.success, {align : "right", width : "100"});
			}
		});
	});


	//sort hooks
	if( $('.sortableHooks').length > 0 ){
		$('.sortableHooks').sortable({
		    forcePlaceholderSize: true 
		}).bind('sortupdate', function(e, ui) {
			update_hooks_positions(ajax_url);
		});
	}


	//add hook to section
	$('#modulesHooks').on('click', '.add_hook', function(){
		$('#modulesHooks a').addClass('disabled');
		var button = $(this);
  		$('#themePositions tbody').append(loading);
  		var row = $(button).closest('tr');
  		var hook_func = row.data('func');
  		if( $('#themePositions tbody tr[data-func="'+hook_func+'"]').length > 0 ){
  			loading.remove();
  			hTabale.fnDeleteRow(row);
			return false;
  		}
  		var url = ajax_url + 'hook-add.php';
  		var data = {
			module_name: row.data('name'),
			hook_func: row.data('func'),
			section_name: $('#sections option:selected').val()
		};
		ajax_handler(url, data, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger"});
			} else if( response.success ){
                loading.remove();
                if( $('.norecord').length > 0 ){
                	$('.norecord').remove();
                }
				row.addClass('bg-success').fadeIn('slow');
				var delete_hook = $('<a href="#" class="btn btn-danger btn-xs delete_hook">Remove</a>');
				row.find('.add_hook').replaceWith(delete_hook);
				row.find('img').closest('td').attr('width', '70');
				$('#themePositions tbody').append(row);
				setTimeout(function () {
                    hTabale.fnDeleteRow(row);
                    row.removeClass('bg-success')
                }, 1000);

                $('#modulesHooks a').removeClass('disabled');
			}
		});
	});

	//delete hook from section
	$('#themePositions').on('click', '.delete_hook', function(){
		$('#themePositions a').addClass('disabled');
  		var row = $(this).closest('tr');
  		row.addClass('bg-danger');
  		var url = ajax_url + 'hook-delete.php';
		var data = {
			hook_func: row.data('func'),
			section_name: $('#sections option:selected').val()
		};

		ajax_handler(url, data, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger"});
			} else if( response.success ){
                if( $('#themePositions tbody tr').length <= 1 ){
                	$('#themePositions tbody').append(norecord);
                }

				var add_hook = $('<a href="#" class="btn btn-default btn-xs add_hook">Add</a>');
				row.find('.delete_hook').replaceWith(add_hook);
				var ai = hTabale.fnAddData([
					row.find('td:eq(0)').html(),
					row.find('td:eq(1)').html(),
					row.find('td:eq(2)').html(),
		        ]);

		        var added_row = hTabale.fnGetNodes(ai[0]);
		        $(added_row)
		        	.attr('data-func', row.data('func'))
		        	.attr('data-name', row.data('name'));

		        $(added_row).find('td:eq(0)').attr('width', '56');
		        $(added_row).find('td:eq(2)').attr('width', '60');

                row.remove();

                update_hooks_positions(ajax_url, response.success);
                $('#themePositions a').removeClass('disabled');
			}
		});
	});


	//get section hooks
	$('#sections').change(function(){
		var section_name = $(this).find('option:selected').val();
		var url = ajax_url + 'sections.php';
		var data = {section_name: $(this).find('option:selected').val()};
		ajax_handler(url, data, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger"});
			} else if( response.active ){
				$('#themePositions tbody').empty().append(response.active);
				var inactive = JSON.parse(response.inactive);
				hTabale.fnClearTable();

				if( !$.isEmptyObject(inactive) ){
					hTabale.fnAddData(inactive);
					var rows = hTabale.fnGetNodes();
					$.each(rows, function( index, value ) {
				        $(value).attr('data-func', $(value).find('a').data('func'));
				        $(value).attr('data-name', $(value).find('a').data('name'));
				        $(value).find('td:eq(0)').attr('width', '56');
				        $(value).find('td:eq(2)').attr('width', '60');
					});
				}

				$('.sortableHooks').sortable({
				    forcePlaceholderSize: true 
				}).bind('sortupdate', function(e, ui) {
					update_hooks_positions(ajax_url);
				});
			}
		});
	});


	//get cookie values
	$('#categories option[value="'+ readCookie("category") +'"]').prop('selected', true);
	$('#status option[value="'+ readCookie("status") +'"]').prop('selected', true);
	$('#authors option[value="'+ readCookie("author") +'"]').prop('selected', true);
	var keywords = readCookie("keywords");
	if( keywords != 'undefined' ){
		$('#keywords').val( keywords );
		moduleTabale.fnFilter( $.trim(keywords) );
	}

	var admin_modules = readCookie("admin_modules");
	if( admin_modules != null ){
		if( admin_modules == 1 ){
			$('#adminModules').prop('checked', true);
		} else {
			$('#adminModules').prop('checked', false);
		}
	}

	if( $('#moduleFilter').length > 0 ){
		refrech_modules_table(moduleTabale, ajax_url);
	}




	// var pagination = $('div.dataTables_wrapper div.dataTables_info');
	// $('#bulk-actions').append(pagination)


//END DOCUMENT
});




/**
 * Update Hooks positions
 *
 * @param ajax_url
 **/
function update_hooks_positions(ajax_url, message=''){
	var positions = {};
	$('.sortableHooks tr').each(function(index){
		var hook_func = $(this).data('func');
		var index = $(this).index() + 1;
		positions[hook_func] = index;
	});
	var url = ajax_url + 'hook-sort.php';
	var data = {
		section_name: $('#sections option:selected').val(),
		positions: JSON.stringify(positions) 
	};
	ajax_handler(url, data, 'post', function(response) {
		if( response.error ){
			message_notif(response.error, {type : "danger", align: "right", width: "100px"});
		} else if( response.success ){
			if( message == '' ) message = response.success;
			message_notif(message, {align: "right", width: "100px"});
		}
	});
}


/**
 * Rafrech modules table
 */
function refrech_modules_table(moduleTabale, ajax_url){
	var loading = $('<img src="../assets/img/icons/loading.gif" width="30" class="loadHook">');
	$('#moduleList table tbody').empty().append(loading);

	var admin_modules = 0;
	if( $('#adminModules').is(':checked') ){
		admin_modules = 1;
	}

	//get selected
	var category	  = $('#categories option:selected').val();
	var status 		  = $('#status option:selected').val();
	var author 		  = $('#authors option:selected').val();
	var keywords 	  = $('#keywords').val();

	createCookie("category", category);
	createCookie("status", status);
	createCookie("author", author);
	createCookie("admin_modules", admin_modules);
	createCookie("keywords", keywords);

	var url = ajax_url + 'filter.php';
	var data = {
		category: category,
		status: status,
		author: author,
		keywords: keywords,
		admin_modules: admin_modules
	};
	ajax_handler(url, data, 'post', function(response) {
		loading.remove();
		if( response.error ){
			message_notif(response.error, {type : "danger"});
		} else if( response.filter ){
			var modules = JSON.parse(response.filter);
			moduleTabale.fnClearTable();
			if( !$.isEmptyObject(modules) ){
				$('#bulk-actions').show();
				moduleTabale.fnAddData(modules);
				var rows = moduleTabale.fnGetNodes();
				$.each(rows, function( index, tr ) {
					var name = $(tr).find('input[type="checkbox"]').data('name');
			        $(tr).attr('data-name', name);
			        $(tr).find('td:eq(0)')
			        	.attr('width', '10')
			        	.attr('align', 'center');
			        $(tr).find('td:eq(1)')
			        	.attr('width', '100')
			        	.attr('align', 'center');
			        $(tr).find('td:eq(3)')
			        	.attr('width', '170')
			        	.attr('class', 'actions');
				});
			} else {
				$('#bulk-actions').hide();
			}
		}
	});
}