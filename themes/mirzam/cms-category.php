<?php
/**
 * The template for displaying blog category.
 *
 * @link https://okdashop.com
 *
 * @package OKADshop
 *
 *
 * 
 *
 */

 //paginator vars
$orderby = $paginator->orderby;
$perpage = $paginator->perpage;
/*$blog_style_class = "col-sm-4";
switch ($blog_style) {
	case 'list':
		$blog_style_class = "col-sm-12";
		break;
	case '2columns':
		$blog_style_class = "col-sm-6";
		break;
	case '3columns':
		$blog_style_class = "col-sm-6 col-md-4";
		break;
	case 'mansonry':
		$blog_style_class = "col-sm-6 col-md-3";
		break;
	default:
		# code...
		break;
}*/

$cms_style = "3columns";
$cms_style_class = "col-sm-6 col-md-4";
?>

<section class="banner bg-parallax" style="">
    <div class="overlay"></div>
    <div class="container">
        <div class="banner-content text-center">
            <h2 class="page-title"><?= $cms_category->title; ?></h2>
            <div class="breadcrumbs">
                <a href="<?= get_home_url(); ?>"><?php trans_e("Home", "frochka"); ?></a>
                <span><?= $cms_category->title; ?></span>
            </div>
        </div>
    </div>
</section>


<div class="maincontainer">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-sm-12 main-content">
            <?php if ($cms_style == "mansonry"): ?>
            	<h2 class="page-title"><?= $cms_category->title; ?></h2>
	            <hr>
	            <?php if ($cms_list): ?>	
            	<div id="blog-masonry" class="blog-masonry" data-cols="4" >
            		<?php foreach ($cms_list as $key => $cms): ?>
				   	<div class="blog-item blog-item-masonry">
				      <div class="post-format">
				         <figure><a href="<?= $cms->url; ?>"><img alt="" src="<?= $cms->cover; ?>"></a></figure>
				         <a href="<?= $cms->url; ?>" class="hover-format">
				         <span>+</span>
				         </a>
				      </div>
				      <h3><a href="<?= $cms->url; ?>"><?= $cms->title; ?></a></h3>
				      <div class="post-cat"><a><?= $cms_category->title; ?></a></div>
				      <div class="content-post"><?= $cms->short_description; ?></div>
				      <div class="meta-post">
				         <div class="date-post"><?= $cms->cdate; ?></div>
				      </div>
				   	</div>
				   	<?php endforeach ?>
				</div>
				<?php endif ?>
            <?php else: ?>
            	<div class="blog-grid">
	            	<h2 class="page-title"><?= $cms_category->title; ?></h2>
	            	<hr>
					<?php if ($cms_list && !empty($cms_list)): ?>
	               	<div class="row">
	               		<?php foreach ($cms_list as $key => $cms): ?>
	               			<div class="blog-item col-xs-12  <?= $cms_style_class .' ' . $cms_style; ?>">
			                    <div class="post-format">
			                        <figure><a href="<?= $cms->url; ?>"><img title="<?= $cms->title; ?>" alt="<?= $cms->title; ?>" src="<?= $cms->cover; ?>"></a></figure>
								</div>
								<h6><a href="<?= $cms->url; ?>"><?= $cms->title; ?></a></h6>
								<div class="content-post"><?= $cms->short_description; ?></div>
		                    </div>
	               		<?php endforeach ?>
	               		<nav class="pagination col-sm-12">
	                        <?= $paginator->links; ?>
	                    </nav>
	               	</div>
					<?php endif ?>
	            </div>
            <?php endif ?>
            

         </div>
      </div>
   </div>
</div>	