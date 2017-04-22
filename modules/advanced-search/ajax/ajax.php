<?php

if (isset($_POST['action'])) {
	$action 		= isset($_POST['action']) ? $_POST['action'] : null ;
	$max_price 		= isset($_POST['max_price']) ? $_POST['max_price'] : null ;
	$min_price 		= isset($_POST['min_price']) ? $_POST['min_price'] : null ;
	$sortby 		= isset($_POST['sortby']) ? $_POST['sortby'] : null ;
	$search_query 	= isset($_POST['search_query']) ? $_POST['search_query'] : null ;


	switch ($action) {
		case 'filter_refrech':
			$condition = array();
			if (!is_empty($max_price) && !is_empty($min_price)) {
				$condition['sell_price'] = "BETWEEN $min_price AND $max_price";
			}else if(!is_empty($min_price)){
				$condition['sell_price'] = ">= $min_price";
			}

			if (!is_empty($search_query)) {
				$condition['pt.name']    = "LIKE '%$search_query%'";
			}
			
			break;
		
		default:
			# code...
			break;
	}
}