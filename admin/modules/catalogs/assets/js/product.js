$(document).ready(function() {

	var ajax_url = admin_dirname() + 'includes/ajax/product/';


	$('.deleteProduct').click(function(){
    	var choice = confirm( trans("This option completely removes the image on your server. Are you really sure?", "default") );
		if (choice == false) return;
		var row = $(this).closest('tr');
		var url = ajax_url + 'delete-product.php';
		var data = {id_product: $(this).data('id')};
		ajax_handler(url, data, 'post', function(res) {
			if( res.message ){
				message_notif(res.message.body, {type : res.message.type, align: "right"});
				$(row).remove();
			} else {
				message_notif(trans("Error occurred, please try again.", "catalogs"), {type : 'danger', align: "right"});
			}
		});	
	});





	/**
	 * Load translation
	 *
	 * 
	 */
	$("#product #languages").on('change', function(){
		if( $('.id_lang').length < 1 ) return;
		var id_lang = $(this).val();
		var id_product = $('#id_product').val();
		if( id_product == '' ){
			$('.id_lang').val($(this).val());
			return false;
		} 

		var url = ajax_url + 'trans.php';
		var data = {id_lang: id_lang, id_product: id_product};
		$('.id_lang').val($(this).val());
		ajax_handler(url, data, 'post', function(product) {
			createCookie('product_lang', id_lang);
			$("#meta_keywords").tagsinput('destroy');
			$('.pname').text(product.name);
			$('#name').val(product.name);
			$('#description').code(product.description);
			$('#excerpt').code(product.excerpt);
			$('#meta_title').val(product.meta_title);
			$('#meta_description').val(product.meta_description);
			$('#meta_keywords').val(product.meta_keywords);
			$('#link_rewrite').val(product.link_rewrite);
			$('.friendly-url span').text(product.link_rewrite);
			$('.product_link').attr('href', product.link);
			$("#meta_keywords").tagsinput();
		});	
	});	

	//update link rewrite
	$("#link_rewrite").keyup(function(){
		$('.friendly-url span').text($(this).val());
	});

	//associations tree
	$( "#tree li.parent_1 a:first" ).css( "padding", "0 0 0px 49px" );

	//edit combination
	$('#os-tab-contents').on('shown.bs.modal', '#comb_form', function (e) {
		var id_comb = $(e.relatedTarget).data('id');
		if( id_comb == '0' ) return;
    	$('input#id_comb').val(id_comb);
    	var url = ajax_url + 'comb-data.php';
		var data_comb = {id_comb: id_comb};
    	ajax_handler(url, data_comb, 'post', function(data){
    		//Fill attributes
			$('#attributes').html(data.attributes);
			$('#json_attributes').val(data.comb_json);

			//Fill déclinaison
			$('#id_comb').val(id_comb);
			if(data.dec_data.default_dec == "1"){
				$("#default_dec").prop("checked", true);
			}
			$('#attr_reference').val(data.dec_data.reference);
			$('#attr_ean13').val(data.dec_data.ean13);
			$('#attr_upc').val(data.dec_data.upc);
			$('#attr_sell_price').val(data.dec_data.sell_price);
			$("#price_impact option[value='"+data.dec_data.price_impact+"").prop("selected", true);
			if(data.dec_data.price_impact != "0"){
				$('#attribute_price').removeClass('hidden');
				$('#attribute_price input').val(data.dec_data.price);
			}
			$("#weight_impact option[value='"+data.dec_data.weight_impact+"").prop("selected", true);
			if(data.dec_data.weight_impact != "0"){
				$('#attribute_weight').removeClass('hidden');
				$('#attribute_weight input').val(data.dec_data.weight);
			}
			$("#unit_impact option[value='"+data.dec_data.unit_impact+"").prop("selected", true);
			if(data.dec_data.unit_impact != "0"){
				$('#attribute_unity').removeClass('hidden');
				$('#attribute_unity input').val(data.dec_data.unity);
			}

			try {
				$("#dec_images input:checkbox").prop("checked", false);
				var obj = $.parseJSON(data.dec_data.images);
				$.each(obj, function(key, value) {
					$("#dec_images input:checkbox[value='"+ value +"']").prop("checked", true);
				});
			} catch (e) {

			}

			$('#quantity').val(data.dec_data.quantity);
			$('#min_quantity').val(data.dec_data.min_quantity);
			$('#available_date').val(data.dec_data.available_date);

    	});
    	return false;
	});





	$("#product").on('change', '.id_image', function(){
		var name = $(this).data("name");
		$("#image_name").empty().val(name);
	});


	$("#product").on('change', '.attr_qty', function(){
		var product_quantity = 0;
		$(".attr_qty").each(function() {
			product_quantity += parseInt( $(this).val() );
		});
		$('#product_quantity').empty().val(product_quantity);
	});


	//on change refresh points
	$("#product").on('change', '#sell_price', function(){
		var price = $(this).val();
		get_loyalty_points(price);
	});


	//loyalty_state
	var loyalty_points = $('#loyalty_points').val();
	if(loyalty_points == "0"){
		$('#loyalty_points').prop('disabled', true);
		$('.loyalty_state option[value=1]').prop('selected', true);
		$('.loyalty_state').css('border', '1px solid #F05050');
		$('#loyalty_value').val('0');
	}else{
		$('#loyalty_points').prop('disabled', false);
		$('.loyalty_state').css('border', '1px solid #3E9E28');
	}
	$("#product").on('change', '.loyalty_state', function(){
		if( $(this).val() === "1" ){
			$('#loyalty_points').prop('disabled', true);
			$('#loyalty_points').val('0');
			$('.loyalty_state').css('border', '1px solid #F05050');
			$('#loyalty_value').val('0');
		}else{
			$('#loyalty_points').prop('disabled', false);
			$('.loyalty_state').css('border', '1px solid #3E9E28');
		}
	});


	//jQuery Filer
	/*$('#attachments').filer({
		maxSize: 8,
		extensions: ['jpg', 'gif', 'png', 'pdf', 'doc', 'ppt', 'odt', 'docx', 'xlsx', 'pptx', 'psd', 'rar', 'zip']
	});*/

	$('#available_date').datetimepicker({
		format: 'YYYY-MM-DD'
	});


	//Product Type
	hide_combinations_tab();
	$("#product").on('change', 'select#type', function(){
		hide_combinations_tab();
	});


	//Clear attribute
	$('.clear').on("click", function() {
		//Clear input and select
		var tr = $(this).parent().parent();
		tr.find('td:nth-child(2) select option:selected').removeAttr('selected');
		tr.find('td:nth-child(3) input').val('');
		//call Gen Attributes Json function
		gen_features_json();

	});

	//remove image row
	$('.delete_img').each(function(){
		$(this).click(function() {
			var choice = confirm( trans("This option completely removes the image on your server. Are you really sure?", "default") );
			if (choice == false) return;
			var id = $(this).attr('id');
			var name = $(this).attr('data-name');
			var id_product = $('#id_product').val();
			$.ajax({
				type: "POST",
				url: 'ajax/products/delete-image.php',
				data: {id_img:id,image:name,id_product:id_product},
				success: function(data){
					$('ul#images li.'+id).remove();
					$('#message').empty().show(0).append(data).delay(2000).hide(0);
				}
			});
		});
	});

	//remove image row
	$('#os-tab-contents').on('click', '.delete_att', function(){
		var choice = confirm( trans("This option completely removes the file on your server. Are you really sure?", "default") );
		if (choice == false) return;
		var id_attachment = $(this).attr('id');
		var url = ajax_url + 'attachment-delete.php';
		var data = {
			id_attachment : id_attachment,
			id_product : $('#id_product').val(),
			att_name : $(this).attr('data-attachment')
		};
		ajax_handler(url, data, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger", align: "right"});
			} else if( response.success ){
				$('table#attachments').find('tr#'+id_attachment).remove();
				message_notif(response.success, {align: "right"});
			}
		});
	});

	//Attribute Group Population
	$("#product").on('change', '#attribute_group', function(){
		var id = $(this).val(); //get the current value's option
		$.ajax({
			type:'POST',
			url:'ajax/products/attribute-values.php',
			data:{'id':id},
			success:function(data){
				$("#values_group").html(data);
				if($('#values_group option').length == 0) {
					$('#values_group').prop('disabled', true);
					//$('.add_attr').addClass('disabled');
				}else{
					$('#values_group').prop('disabled',false);
				}
			}
		});
	});
	
	//Delete declinaison row
	$('.delete-declinaison').each(function(){
		$(this).click(function() {
			var choice = confirm( trans("This will permanently delete the declination. Are you really sure?", "default") );
			if (choice == false) return;
			var id = $(this).attr('data-id');
			$.ajax({
				type: "POST",
				url: 'ajax/products/delete-declinaison.php',
				data: {id:id},
				success: function(data){
					$('table#dec-table tr#'+id).remove();
					$('#message').empty().show(0).append(data).delay(2000).hide(0);
				}
			});
		});
	});

	//ADD NEW DECLINATION
	$('.add_dec').on('click', function(){
		resetDec();
		$('#dec-form').removeClass('hidden');
	});

	//EDIT RESET
	$('#edit-reset').on('click', function(){
		var choice = confirm( trans("This will permanently delete the declination. Are you really sure?", "default") );
		if (choice == false) return;
		resetDec();
		$('#dec-form').addClass('hidden');
	});

	//EDIT RESET
	$('.add_new_dec').on('click', function(){
		var choice = confirm( trans("Are you really sure?", "default") );
		if (choice == false) return;
		resetDec();
		$('#dec-form').removeClass('hidden');
	});

	//categories collapse
	$('.cat_collapse').on("click", function() {
		var li = $(this).closest('li');
		var ul = li.next("ul");
		if(ul.hasClass('hidden')){
			ul.removeClass('hidden');
			li.find('a').removeClass('plus').addClass('minus');
			li.find('i').removeClass('fa-plus-square').addClass('fa-minus-square');
		}else{
			ul.addClass('hidden');
			li.find('a').removeClass('minus').addClass('plus');
			li.find('i').removeClass('fa-minus-square').addClass('fa-plus-square');
		}
	});


	$(document).on('submit','#comb-form',function(event){
		event.preventDefault();
		if( $('#attributes option').length < 1 ){
			message_notif( trans("Please select attributes.", "default"), {type : "danger", align: "right"});
		} else {
			var url = ajax_url + 'comb-save.php';
			var data = $('#comb-form').serialize();
			ajax_handler(url, data, 'post', function(response) {
				if( response.error ){
					message_notif(response.error, {type : "danger", align: "right"});
				} else if( response.success ){
					if( response.id_comb ){
						$('input#id_comb').val(response.id_comb);
					}
					message_notif(response.success, {align: "right"});
					$('#comb_form').modal('toggle');
				}
			});	
		}
	});

	$(document).on('hidden.bs.modal', '#comb_form', function () {
		var activeTab = $('.nav-tabs>li.active>a');
		var tab = activeTab.data('tab');
		var location = activeTab.closest('ul').data('location');
		ajax_get_tab_content(tab, location);
	});


	//delete combination
	$('#os-tab-contents').on('click', '.delete_comb', function(event) {
		event.preventDefault();
		var choice = confirm( trans("This option completely removes the combination. Are you really sure?", "default") );
		if (choice == false) return;

		var url = ajax_url + 'comb-delete.php';
		var id_comb = $(this).data('id');
		ajax_handler(url, {id_comb : id_comb}, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger", align: "right"});
			} else if( response.success ){
				$('#combinations tr#'+id_comb).fadeOut('slow');
				message_notif(response.success, {align: "right"});
			}
		});	
		return true;
	});







	//choise home as product categories
	if( $('#tree input[type="checkbox"]:checked').length < 1 ){
		$('#tree input[type="checkbox"]:first').prop('checked', true);
	}
	//choise home as default category
	if( $('#tree input[type="radio"]:checked').length < 1 ){
		$('#tree input[type="radio"]:first').prop('checked', true);
	}



	//upload images
	$('#input_images').filer({
		showThumbs: false,
		addMore: true,
		maxSize: 8,
		extensions: ['png', 'jpg', 'jpeg', 'gif']
	});


	//upload attachments
	/*$('.attachments').filer({
		showThumbs: false,
		addMore: true,
		maxSize: 8,
		extensions: ['jpg', 'gif', 'png', 'doc', 'ppt', 'odt', 'docx', 'xlsx', 'pptx', 'psd' , 'rar', 'zip']
	});*/

	
    $('#os-tab-contents').on('click', '.delete', function(){
    	var choice = confirm( trans("This option completely removes the image on your server. Are you really sure?", "default") );
		if (choice == false) return;
		var id_image = $(this).data('id');
		var url = ajax_url + 'image-delete.php';
		var data = {
			id_image: id_image, 
			id_product: $('#id_product').val(), 
			//image_name: $(this).data('image')
		};
		ajax_handler(url, data, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger", align: "right"});
			} else if( response.success ){
				$('table#productImages tr#'+ id_image).remove().fadeOut('slow');
				update_product_images_pos(ajax_url);
				message_notif(response.success, {align: "right"});
			}
			$('.sortable').closest('table').attr('style', false);
			//set_sortable_height();
		});
	});


	//update featured
	$('#os-tab-contents').on('change', '.cover', function(){
		var id_image = $(this).closest('tr').attr('id');
		var url = ajax_url + 'image-cover.php';
		var data = {
			id_image: id_image,
			id_product: $('#id_product').val()
		};
		ajax_handler(url, data, 'post', function(response) {
			if( response.error ){
				message_notif(response.error, {type : "danger", align: "right"});
			} else if( response.success ){
				message_notif(response.success, {align: "right"});
			}
		});
	});	


	//update images positions
	$('#os-tab-contents').bind('sortupdate', '.sortable', function() {
		update_product_images_pos(ajax_url);
	});

	
	set_sortable_height();





//END DOCUMENT
});













//Gen Quantities
function genQuantities(){
	var json = '';
	var global_qty = 0;
	$("table#quantities tbody tr:not(.bg-gray)").each(function(){
		var id = $(this).attr('id');
		var quantity = $(this).find('td:nth-child(1) input').val();
		if(quantity > '0'){qty=quantity}else{qty=0}
		json += ('{"'+id+'":"'+qty+'"},');
		global_qty += parseInt(qty);
	});
	json = json.slice(0,-1);
	json = json.replace(json, '['+json+']');
	$('#json_quantities').empty().val(json);
	$('#quantity').val(global_qty);
}

function gen_features_json(){
	var json = {};
	var features_ids = []; 
	$("table#features tbody tr").each(function(){
		//Attribute ID and Value
		var id_feature = $(this).find('td:nth-child(1)').attr('id');
		var id_product = $('#id_product').val();
		var id_feature_value = $(this).find('td:nth-child(2) select option:selected').val();
		//Run Tests
		if ($(this).find('td:nth-child(2) select').length > 0) {
			if(id_feature_value != ''){
				var custom = $(this).find('td:nth-child(2) select option:selected').text();
				json[id_feature] = {};
				json[id_feature]['id_product'] = id_product;
				json[id_feature]['id_feature'] = id_feature;
				json[id_feature]['id_feature_value'] = id_feature_value;
				json[id_feature]['custom'] = null;
				//features_ids
				features_ids.push(id_feature);
			}else{
				var custom_value = $(this).find('td:nth-child(3) input').val();
				if(custom_value != ''){
					json[id_feature] = {};
					json[id_feature]['id_product'] = id_product;
					json[id_feature]['id_feature'] = id_feature;
					json[id_feature]['id_feature_value'] = 0;
					json[id_feature]['custom'] = custom_value;
					//features_ids
					features_ids.push(id_feature);
				}	
			}
		}else{
			
			var custom_value = $(this).find('td:nth-child(3) input').val();
			if(custom_value != ''){
				json[id_feature] = {};
				json[id_feature]['id_product'] = id_product;
				json[id_feature]['id_feature'] = id_feature;
				json[id_feature]['id_feature_value'] = null;
				json[id_feature]['custom'] = custom_value;
				//features_ids
				features_ids.push(id_feature);
			}			
		}
	});
	//Serializing to JSON
	var json_features = JSON.stringify(json, null, 2);
	$('#json_features').empty().val(json_features);
	$('#features_ids').empty().val(features_ids);
}//END ATTRIBUTES JSON FUNCTION

//Check All Categories
function checkAllCategories(){
	$("#categories input:checkbox").prop("checked", true);
}

//uncheck All Categories
function uncheckAllCategories(){
	$("#categories input:checkbox").prop("checked", false);
}

//colapse_all
function colapse_all(){
	$('ul#categories').addClass('hidden');
	$('ul#categories').first().removeClass('hidden');
}
function develope_all(){
	$('ul#categories').removeClass('hidden');
}


//Hide Tabs
function hide_combinations_tab(){
	var selected = $('select#type option:selected').val();
	if( selected == '1' || selected == '2' ){
		$('.nav-tabs a[data-tab="combinations"]').closest('li').addClass('hidden');
	} else {
		$('.nav-tabs a[data-tab="combinations"]').closest('li').removeClass('hidden');
	}
}

//Add Attribute
function add_attr(){
	var id_attribut = $('#attribute_group option:selected').val();
	var attribut_name = $('#attribute_group option:selected').text();
	var id_value = $('#values_group option:selected').val();
	var value_name = $('#values_group option:selected').text();
	//check if exist
	var exist = $("#attributes option[groupid='"+id_attribut+"']").length;//[value='"+id_value+"']
	if(value_name == '---' || attribut_name == '---'){
		alert('Veuillez choisir une valeur.'); return;
	}
	if(exist === 0){
		var option = '<option value="'+id_value+'" groupid="'+id_attribut+'">'+attribut_name+'&nbsp;&nbsp; : '+value_name+'</option>';
		$('#attributes').append(option);
	}else{
		alert( trans("You can only add one combination per attribute type.", "default") );
	}


	//Json Combinations
	var json = '{';
	var cu = '';
	var index = 0;
	$("#attributes option").each(function(index){
		json += ('"'+index+'": {"id_value":"'+$(this).val()+'","id_attribute":"'+$(this).attr('groupid')+'"},');
		cu += $(this).attr('groupid')+':'+$(this).val()+',';
		index++;
	});
	json = json.slice(0,-1);
	json += '}';
	$('#json_attributes').empty().val(json);
	cu = cu.slice(0,-1);
	$('#cu').empty().val(cu);

}

//Delete Attribute
function del_attr(){
	//$('#combinations option:selected').prop('selected', false);
	$('#attributes option:selected').remove();
	//Json Combinations
	var json = '';
	var cu = '';
	if($("#attributes option").length > 0){
		json = '{';
		var index = 0;
		$("#attributes option").each(function(index){
			json += ('"'+index+'": {"id_value":"'+$(this).val()+'","id_attribute":"'+$(this).attr('groupid')+'"},');
			cu += $(this).attr('groupid')+':'+$(this).val()+',';
			index++;
		});
		json = json.slice(0,-1);
		json += '}';
	}
	$('#json_attributes').empty().val(json);
	// cu = cu.slice(0,-1);
	// $('#cu').empty().val(cu);
}

//Display Hide
function displayOrHide(sel,id){
	if(sel.value != '0'){
		$('#'+id).removeClass('hidden');
	}else{
		$('#'+id).addClass('hidden');
		$('#'+id).find('input').val('');	
	}
}

function resetDec(){
	$("#combinations option").remove();
	$('#dec-form').find('input').val('');
	$('#dec-form').find('select option:selected').prop("selected", false);
	$('#attribute_price').addClass('hidden');
	$('#attribute_weight').addClass('hidden');
	$('#attribute_unity').addClass('hidden');
}

function get_loyalty_points(price){
	var points = price / 10;
	$('#loyalty_points').val( points | 0 );
}


/**
 *
 * Set sortable height
 *
 **/
function set_sortable_height(){
	var tableSortable = $('.sortable').closest('table');
	if( tableSortable.length > 0 ){
		tableSortable.css('min-height', tableSortable.height() );
	}
}

/**
 *
 * Update images positions
 *
 * @param ajax_url
 **/
function update_product_images_pos(ajax_url){
	var positions = {};
	$('.sortable tr').each(function(index){
		var id_image = $(this).attr('id');
		var index = $(this).index() + 1;
		$(this).find('input').val(index);
		positions[id_image] = index;//{id_image: $(this).attr('id'), position: index};
	});
	var url = ajax_url + 'image-sort.php';
	var data = {
		//id_product: $('#id_product').val(),
		positions: JSON.stringify(positions) 
	};
	ajax_handler(url, data, 'post', function(response) {
		if( response.error ){
			message_notif(response.error, {type : "danger", align: "right"});
		} else if( response.success ){
			message_notif(response.success, {align: "right"});
		}
	});
}