$(document).ready(function(){

	/* Credit-sleps */
	$('.credit-sleps table').dataTable({
		bFilter: false, 
		bInfo: false,
		bLengthChange: false,
		pageLength: 2
	});

	/* orders table */
	$('.orders-table').dataTable({
		bFilter: false, 
		bInfo: false,
		bLengthChange: false,
		pageLength: 10
	});

 
	/*Mega Menu*/
	$('.mega-menu .mega-menu-item').hover(function(){
		var cat = $(this).data('cat');
		
		var content = $("#mega_menu_cat_"+cat+" .categories_menus").html().trim();
		if (content != "") {
			$('.mega_menu_cat').addClass("hidden");
			$("#mega_menu_cat_"+cat).removeClass("hidden");
			$("#mega_menu_toogle").toggleClass("hidden");
		}

	});

	$('#mega_menu_toogle').hover(function(){
		$(this).toggleClass("hidden");
	});



	/* sub menu */
	$('.menu-item-has-children').hover(function(){
		$(this).addClass('show-submenu');
	},function(){
		$(this).removeClass('show-submenu');
	});
	

	$('.menu-item-has-children .show-sub-menu-icon').click(function(){
		if ($(this).find('.fa').hasClass('fa-plus')) {
			$(this).find('.fa').removeClass('fa-plus').addClass('fa-minus');
			$(this).closest('.menu-item-has-children').addClass('show-submenu');
		}else{
			$(this).find('.fa').removeClass('fa-minus').addClass('fa-plus');
			$(this).closest('.menu-item-has-children').removeClass('show-submenu');
			//sub-menu
		}
		
		return false;
	});

//END DOCUMENT
});