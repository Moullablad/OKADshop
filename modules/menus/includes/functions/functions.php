<?php

/*function get_menu_lists_old($data,$id_parent = 0){
	$result = array();

	global $common;
	$i = 0;
	if (!empty($data)) {
		foreach ($data as $key => $value) {
			if ($value->id_parent != $id_parent) {
				continue;
			}
			switch ($value->type) {
				case 'cms':
					$cms = $common->select("cms",array("*"),"where id = ".$value->id_content." LIMIT 1");
					if (isset($cms[0]) && !empty($cms[0])) {
						$href = get_home_url()."cms/".$cms[0]['id'].(!empty($cms[0]['permalink']) ? "-".$cms[0]['permalink'] : "");
						$tmp = get_menu_lists($data,$value->id);
						array_push($result, (object)array(
							"id" => $value->id,
							"title" => $value->title,
							"uri" => $href,
							"child" => $tmp
						));
						$i++;
					}
					break;
				case 'blog':
					$blog = $common->select("blog",array("*"),"where id = ".$value->id_content." LIMIT 1");
					if (isset($blog[0]) && !empty($blog[0])) {
						$href = get_home_url()."blog/".$blog[0]['id'].(!empty($blog[0]['permalink']) ? "-".$blog[0]['permalink'] : "");
						array_push($result,(object) array(
							"id" => $value->id,
							"title" => $value->title,
							"uri" => $href
						));
						$i++;
					}
					break;
				case 'product_category':
					$categories = $common->select("categories",array("*"),"where id = ".$value->id_content." LIMIT 1");
					if (isset($categories[0]) && !empty($categories[0])) {
						$href = get_home_url()."category/".$categories[0]['id'].(!empty($categories[0]['permalink']) ? "-".$categories[0]['permalink'] : "");
						$tmp = get_menu_lists($data,$value->id);
						array_push($result,(object) array(
							"id" => $value->id,
							"title" => $value->title,
							"uri" => $href,
							"child" => $tmp
						));
						$i++;

					}
					break;
				case 'blog_category':
					$categories = $common->select("blog_categories",array("*"),"where id = ".$value->id_content." LIMIT 1");
					if (isset($categories[0]) && !empty($categories[0])) {
						$href = get_home_url()."blog-category/".(!empty($categories[0]['permalink']) ? $categories[0]['permalink'] : $categories[0]['id']);
						array_push($result,(object) array(
							"id" => $value->id,
							"title" => $value->title,
							"uri" => $href
						));
						$i++;
					}
					break;
				case 'link':
					$href = $value->link;
					if (strpos($href,'http://') === false){
					    $href = 'http://'.$href;
					}
					array_push($result,(object) array(
						"id" => $value->id,
						"title" => $value->title,
						"uri" => $href
					));
					$i++;
					break;
				case 'html':
					array_push($result,(object) array(
						"id" => $value->id,
						"title" => $value->html,
						"uri" => "javascript:;"
					));
					break;
					$i++;
				default:
					# code...
					break;
			}
		}
	}
	return (object)$result;
}
*/

function get_html_menu_lists($data,$id_parent = 0){
	$result = "";

	global $common;
	$i = 0;
	if (!empty($data)) {
		foreach ($data as $key => $value) {
			if ($value->id_parent != $id_parent) {
				continue;
			}
			switch ($value->type) {
				case 'cms':
					$cms = $common->select("cms",array("*"),"where id = ".$value->id_content." LIMIT 1");
					if (isset($cms[0]) && !empty($cms[0])) {
						$href = get_home_url()."cms/".$cms[0]['id'].(!empty($cms[0]['permalink']) ? "-".$cms[0]['permalink'] : "");
						$tmp = get_html_menu_lists($data,$value->id);
						if ($tmp == "") {
							$result .= '<li><a href="'.$href.'">'.$value->title.'</a></li>';
						}else{
							$result .= '<li class="menu-item-has-children"><a href="'.$href.'">'.$value->title.'</a>';
							$result .= '<ul class="sub-menu">'.$tmp.'</ul>';
							$result .= '</li>';
						}

					}
					break;
				case 'blog':
					$blog = $common->select("blog",array("*"),"where id = ".$value->id_content." LIMIT 1");
					if (isset($blog[0]) && !empty($blog[0])) {
						$href = get_home_url()."blog-detail/".$blog[0]['id'].(!empty($blog[0]['permalink']) ? "-".$blog[0]['permalink'] : "");
						$tmp = get_html_menu_lists($data,$value->id);
						if ($tmp == "") {
							$result .= '<li><a href="'.$href.'">'.$value->title.'</a></li>';
						}else{
							$result .= '<li class="menu-item-has-children"><a href="'.$href.'">'.$value->title.'</a>';
							$result .= '<ul class="sub-menu">'.$tmp.'</ul>';
							$result .= '</li>';
						}
					}
					break;
				case 'product_category':
					$categories = $common->select("categories",array("*"),"where id = ".$value->id_content." LIMIT 1");
					if (isset($categories[0]) && !empty($categories[0])) {
						$href = get_home_url()."category/".$categories[0]['id'].(!empty($categories[0]['permalink']) ? "-".$categories[0]['permalink'] : "");
						$tmp = get_html_menu_lists($data,$value->id);
						if ($tmp == "") {
							$result .= '<li><a href="'.$href.'">'.$value->title.'</a></li>';
						}else{
							$result .= '<li class="menu-item-has-children"><a href="'.$href.'">'.$value->title.'</a>';
							$result .= '<ul class="sub-menu">'.$tmp.'</ul>';
							$result .= '</li>';
						}


					}
					break;
				case 'blog_category':
					$categories = $common->select("blog_categories",array("*"),"where id = ".$value->id_content." LIMIT 1");
					if (isset($categories[0]) && !empty($categories[0])) {
						$href = get_home_url()."blog-category/".(!empty($categories[0]['permalink']) ? $categories[0]['permalink'] : $categories[0]['id']);
						$tmp = get_html_menu_lists($data,$value->id);
						if ($tmp == "") {
							$result .= '<li><a href="'.$href.'">'.$value->title.'</a></li>';
						}else{
							$result .= '<li class="menu-item-has-children"><a href="'.$href.'">'.$value->title.'</a>';
							$result .= '<ul class="sub-menu">'.$tmp.'</ul>';
							$result .= '</li>';
						}
					}
					break;
				case 'link':
					$href = $value->link;
					if (strpos($href,'http://') === false){
					    $href = 'http://'.$href;
					}
					$tmp = get_html_menu_lists($data,$value->id);
					if ($tmp == "") {
						$result .= '<li><a href="'.$href.'">'.$value->title.'</a></li>';
					}else{
						$result .= '<li class="menu-item-has-children"><a href="'.$href.'">'.$value->title.'</a>';
						$result .= '<ul class="sub-menu">'.$tmp.'</ul>';
						$result .= '</li>';
					}

					break;
				case 'html':
					$tmp = get_html_menu_lists($data,$value->id);
						if ($tmp == "") {
							$result .= '<li><a href="javascript:;">'.$value->html.'</a></li>';
						}else{
							$result .= '<li class="menu-item-has-children"><a href="'.$href.'">'.$value->title.'</a>';
							$result .= '<ul class="sub-menu">'.$tmp.'</ul>';
							$result .= '</li>';
						}
					break;
				default:
					# code...
					break;
			}
		}
	}

	return $result;
}