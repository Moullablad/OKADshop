$(document).ready(function(){

	initialize_filter();
	
	$( ".filter-refrech" ).on('click',function() {
		var max_price 	 = $('input[name=filter_price]:checked').data('max');
 		var min_price 	 = $('input[name=filter_price]:checked').data('min');
 		var filter_price = $('input[name=filter_price]:checked').val();
 		var sortby 		 = $('select[name=sortby]').val();

 		$('input[name=min_price]').val(min_price);
 		$('input[name=max_price]').val(max_price);
 		$('input[name=filter_price_radio]').val(filter_price);
 		$('input[name=sortby_option]').val(sortby);

		$( "#form_filter" ).submit();
	});

	$( ".filter-order" ).on('change',function() {
		var max_price 	 = $('input[name=filter_price]:checked').data('max');
 		var min_price 	 = $('input[name=filter_price]:checked').data('min');
 		var filter_price = $('input[name=filter_price]:checked').val();
 		var sortby 		 = $('select[name=sortby]').val();

 		$('input[name=min_price]').val(min_price);
 		$('input[name=max_price]').val(max_price);
 		$('input[name=filter_price_radio]').val(filter_price);
 		$('input[name=sortby_option]').val(sortby);

		$( "#form_filter" ).submit();
	});

	$( ".attribute_value" ).on('click',function() {
		var data_attribute_value = "";
		var i = 0;
		$('.attribute_value').each(function(){ 
			var attribute_value = $(this);
			if (attribute_value.prop('checked') == true) {
				//data_attribute_value += "\"" + attribute_value.data("attrtibute") + "\":\"" + attribute_value.data("value") + "\",";
				data_attribute_value += "\"" + i + "\":{\"attr_id\":" + attribute_value.data("attrtibute") + ",\"val_id\":" + attribute_value.data("value") + "},";
			}
			i++;
		});
		data_attribute_value = "{" + data_attribute_value.replace(/,(?=[^,]*$)/, '') + "}";
		$('input[name=data_attribute_value]').val(data_attribute_value);
		
		$( "#form_filter" ).submit();
	});

});

function initialize_filter(){
	var filter_price = $('input[name=filter_price_radio]').val();
	var sortby_option = $('input[name=sortby_option]').val();
	
 	if (filter_price != "") {
 		$('.' + filter_price).prop('checked', true);
 	}
	$('select[name=sortby]').val(sortby_option);


	try {
		var data_attribute_value = JSON.parse( $('input[name=data_attribute_value]').val() );
		$.each(data_attribute_value,function(key,value){
			if (value['attr_id'] != "" && value['val_id'] != "") {
				$('*[data-attrtibute="'+value['attr_id']+'"][data-value="'+value['val_id']+'"]').prop('checked',true);
			}
		});
	}
	catch (e) {
 
	};
	
}