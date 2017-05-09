$(document).ready(function() {

  
	//sort form
	$('.productSort').on('change', function(){
		$(this).closest('form').submit();
	});


	/**
	 * sortBar
	 */
	//get sortBar session
	var view_as = sessionStorage.getItem('view_items_as');
	if( view_as === null || view_as === 'grid' ){
		view_as_grid();
	} else {
		view_as_list();
	}
	//view items as grid
	$('.view-as-grid').on('click', function(event){
		event.preventDefault();
		view_as_grid();
	});
	//view items as list
	$('.view-as-list').on('click', function(event){
		event.preventDefault();
		view_as_list();
	});


	$('.product-categories > li').each(function(){
		if( $(this).has('ul').length ){
			$(this).addClass('cat-parent');
		}
	});


	//get product combinations
	$("#product_attributes select").on('change', function(){
		var combinations = {};
		$("#product_attributes select").each(function(){
			var id_attribute = $(this).data('id');

			if( combinations[id_attribute] === undefined)
            	combinations[id_attribute] = "";

            combinations[id_attribute] = $(this).find('option:selected').val();
		});
		//get combinations data
		var json = JSON.stringify(combinations);

		//manupulate results
		ajax_get_combinations(json, function(obj) {
			$('.single-product-thumbnails a').removeClass('hidden');


			//check if response is json
	        if( obj.comb ){
	        	
	        	//show cart_form form
				$('#cart_form').show();

	        	var comb = $.parseJSON(obj.comb);
	        	$('#availability_statut').empty().html('<span>'+ comb.quantity +' Item(s)</span>&nbsp;&nbsp;<span class="label label-success">In stock</span>');
	        	$('#idDeclinaison').val(comb.id);


	        	var old_discount = $('.summary .old-amount').text();
	        	if( old_discount < comb.price ){
	        		$('.summary .old-amount').closest('del').hide();
	        	} else {
	        		$('.summary .old-amount').closest('del').show();
	        	}
	        	$('.summary .amount').text(comb.price);

	        	try {
	        		//images array
		    		var images = $.parseJSON(comb.images);

	        		//hide other images
					$('.single-product-thumbnails a').filter(function( index ) {
					    return $.inArray( $( this ).data( "name" ), images ) === -1;
				  	}).addClass('hidden');

				  	//set single image
				  	var path = $('.popup-image').attr('href');
				  	var image_path = path.substr(0, path.lastIndexOf("/"));
				  	var extention = get_extention(images[0]);
				  	var file_name = images[0].replace("."+extention, "-570x697."+extention);
				  	var full_path = image_path + '/' + file_name;
				  	$('.popup-image').attr('href', full_path);
				  	$('.main-image').attr('href', full_path);
			    }catch (e) {
			    	$('.single-product-thumbnails a').removeClass('hidden');
			    }

	        } else if( obj.empty ){
	        	//hide cart_form form
				$('#cart_form').hide();
				$('#idDeclinaison').val('');
	        	$('.single-product-thumbnails span').removeClass('hidden');
	        	$('#availability_statut').empty().html('<span id="availability_value" class="label label-warning">'+ obj.empty +'</span>');
	        }
			
		});
		return false;
	});



	$(document).on('click','.single-product-thumbnails a',function(){
        $(this).closest('.single-product-thumbnails').find('a').each(function(){
            $(this).removeClass('selected');
        });
        $(this).addClass('selected');
        var image_full = $(this).data('image-full');
        $('.single-images').find('.main-image').attr('src',image_full);
        $('.single-images').find('.popup-image').attr('href',image_full);
        
        return false;
    })
	


//END DOCUMENT READY
});







/*================================================================================
#
# Product page function Functions
#
================================================================================*/


/**
 * View items as grid
 */
function view_as_grid(){
	if( $('.products').length < 1 )
		return false;
	
	//exit if already grid
	if( $('.products').hasClass('grid-view') ){
		$('.products .list').hide();
		$('.products .grid').show();
		return false;
	}

	//set to active
	$('.view-as-grid').addClass('selected');
	$('.view-as-list').removeClass('selected');

	$('.products .list').hide();
	$('.products .grid').show();
	$('.products').removeClass('list-view').addClass('grid-view');

	$('.product').each(function(){
		//remove li classes
		$(this).addClass('col-sm-6 col-md-4');
		if( $(this).find('.row').length != 0 ){
			//unwrap col-sm-4
			$(this).find('.product-thumb').unwrap();

			//unwrap col-sm-8
			$(this).find('.product-info').unwrap();

			//unwrap row
			$(this).find('.product-info').unwrap();
		}
	});

	//store option in session
	sessionStorage.setItem('view_items_as', 'grid');
}


/**
 * View items as list
 **/
function view_as_list(){
	//exit if already list
	if( $('.products').hasClass('list-view') )
		return false;

	//set to active
	$('.view-as-list').addClass('selected');
	$('.view-as-grid').removeClass('selected');

	$('.products .grid').hide();
	$('.products .list').show();
	$('.products').removeClass('grid-view').addClass('list-view');

	$('.product').each(function(){
		//remove li classes
		$(this).removeClass('col-sm-6 col-md-4');

		//wrapAll
		$(this).find('.product-thumb').next().andSelf().wrapAll( "<div class='row m-0'></div>" );

		//wrap col-sm-4
		$(this).find('.product-thumb').wrap( "<div class='col-sm-4'></div>" );

		//wrap col-sm-8
		$(this).find('.product-info').wrap( "<div class='col-sm-8'></div>" );
	});

	//store option in session
	sessionStorage.setItem('view_items_as', 'list');
}