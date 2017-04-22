<?php

/**
 * Get languages array
 */
function get_languages_array() {
	return include module_base(__FILE__, 'inc/languages.php');
}



function get_locations($group_id){
	return \CoreModules\Languages\Controllers\Languages::getTransLocationByGroup($group_id);
}
