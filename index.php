<?php require_once 'config/bootstrap.php';

if( !defined('_LIVE_SITE_') ){
	error_reporting(E_ALL);
	ini_set("display_errors", true);
}

use Core\Module;
use Core\Image;
use Core\Theme;
use Core\Controllers\Controller;
use Core\Controllers\Front\BlogController;
use Core\Controllers\Front\CmsController;


//display module page if exist
Module::PageRender();

 
if (isset($_GET['Module']) && !empty($_GET['Module'])) {
	$Module = $_GET['Module'];
	switch ($Module) {
		case 'cms-category':
			$CmsController = new CmsController();
			$data = array();
			$res = explode('-', $_GET['ID'])[0];
			$cms_category = $CmsController->getCmsCat($res);

			if ($cms_category) {


				// os_initialize_meta('meta_title',$cms_category->meta_title);
	 		// 	os_initialize_meta('meta_description',$cms_category->meta_description);
	 		// 	os_initialize_meta('meta_keywords',$cms_category->meta_keywords);


	 			//seo metatags
				if( function_exists('add_meta') ){
					set_meta_title($cms_category->meta_title);
					set_meta_description(strip_tags($cms_category->meta_description));
					set_meta_keywords($cms_category->meta_keywords);
				}


				$data['cms_category'] = $cms_category;


				$result = $CmsController->getCmsByCat($cms_category->id);

				$data['cms_category'] = $cms_category;
				$data['cms_list'] = $result->cms_list;
				$data['paginator'] = $result->paginator;
				//$data['blog_style'] = $BlogControllers->getBlogStyle();

				 

				

				//get cms template
				Theme::getTemplate('cms-category', $data);
			}else{
				//redirect to 404 page
				Controller::notFound();
			}
			break;
		case 'cms': 
			$CmsController = new CmsController();
			$data = array();

			$id_cms = explode('-', $_GET['ID'])[0];
			$cms = $CmsController->getCms($id_cms);
			if ($cms) {
				
				$cms->cover = 'files/cms/cover/'. $cms->cover_cms ;
	 			$cms->content = html_entity_decode($cms->content);

	 			/*os_initialize_meta('meta_title',$cms->meta_title);
	 			os_initialize_meta('meta_description',$cms->meta_description);
	 			os_initialize_meta('meta_keywords',$cms->meta_keywords);
	 			os_initialize_ogdata(array(
					"url" => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 
					"title" => $cms->meta_title, 
					"description" => $cms->meta_description, 
					"image" => $cms->cover
				));*/

				//seo metatags
				if( function_exists('add_meta') ){
					set_meta_title($cms->meta_title);
					set_meta_description(strip_tags($cms->meta_description));
					set_meta_keywords($cms->meta_keywords);
					if( file_exists(site_base($cms->cover)) ){
						$image = site_url($cms->cover);
						add_meta('og:image', $image, 'property');
					}
				}

				//get cms template
	 			$data['cms'] = $cms;
				Theme::getTemplate('cms', $data);
			}else{
				//redirect to 404 page
				Controller::notFound();
			}
			
			break;
		case 'blog':
		case 'blog-category': 
			$BlogControllers = new BlogController();
			$data = array();

			$id_category = explode('-', $_GET['ID'])[0];
			if ($id_category == null || $id_category == "") {
				$id_category = 1;
			}
			if ($id_category) {
				$blog_category = $BlogControllers->getBlogCat($id_category);
				if ($blog_category) {
					// os_initialize_meta('meta_title',$blog_category->meta_title);
		 		// 	os_initialize_meta('meta_description',$blog_category->meta_description);
		 		// 	os_initialize_meta('meta_keywords',$blog_category->meta_keywords);

		 			//seo metatags
					if( function_exists('add_meta') ){
						set_meta_title($blog_category->meta_title);
						set_meta_description(strip_tags($blog_category->meta_description));
						set_meta_keywords($blog_category->meta_keywords);
					}
	 			
					$blog_category->cover = 'files/blog/'. $blog_category->img ;

					$sub_category = $BlogControllers->blogCategory($blog_category->id);
					$result = $BlogControllers->getBlogByCat($blog_category->id);

					$data['blog_category'] = $blog_category;
					$data['sub_category'] = $sub_category;
					$data['blog_list'] = $result->blog_list;
					$data['paginator'] = $result->paginator;
					$data['blog_style'] = $BlogControllers->getBlogStyle();
				}
				
			}


			Theme::getTemplate('blog-category',$data);
			break;
		case 'blog-detail':
			$BlogControllers = new BlogController();
			$data = array();

			//get id_blog
			$id_blog = explode('-', $_GET['ID'])[0];
			if ($id_blog) {
 				$blog = $BlogControllers->getBlog($id_blog);
 				if ($blog) {
 					$blog->cover = 'files/blog/'. $blog->img_blog ;
	 				$blog->content = html_entity_decode($blog->content);
	 				$blog_category = $BlogControllers->getBlogCat($blog->id_blogcat);

	 				$data['blog'] = $blog;
	 				$data['blog_category'] = $blog_category;

	 				/*os_initialize_meta('meta_title',$blog->meta_title);
	 				os_initialize_meta('meta_description',$blog->meta_description);
	 				os_initialize_meta('meta_keywords',$blog->meta_keywords);

	 				os_initialize_ogdata(array(
						"url" => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 
						"title" => $blog->meta_title, 
						"description" => $blog->meta_description, 
						"image" => $blog->cover
					));*/

					//seo metatags
					if( function_exists('add_meta') ){
						set_meta_title($blog->meta_title);
						set_meta_description(strip_tags($blog->meta_description));
						set_meta_keywords($blog->meta_keywords);
						if( file_exists(site_base($blog->cover)) ){
							$image = site_url($blog->cover);
							add_meta('og:image', $image, 'property');
						}
					}
	 				
 				}
			}
			//get home page template
			Theme::getTemplate('blog-detail',$data);

			break;
		case 'search':
			$data = array();
			Theme::getTemplate('search',$data);
			break;
		case 'views':
			if (isset($_GET['ID']) && !empty($_GET['ID'])) {
				$dir = get_theme_directory() .'/views/'.$_GET['ID'].'.php';
				if (file_exists($dir)) {
					require_once $dir;
				}else
					Controller::notFound();
			}
			else
				Controller::notFound();
			break;
		default:
			Controller::notFound();
		break;
	}
} else{
	
	//get home page template
	Theme::getTemplate('index');
}
?>