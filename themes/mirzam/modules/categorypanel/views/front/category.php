<?php 
    //var_dump($main_category);
 ?>
<ul class="nav nav-pills nav-stacked mega-menu mb-xs-20 block-categories " id="nav_category">
    <li class="nav-title">
        <a>CATEGORIES</a>
    </li>
    <?php foreach ($main_category as $key => $category): ?>
    <li>
        <a class="mega-menu-item" href="<?= $category->link; ?>" data-cat="<?= $category->id; ?>">  <?= $category->name; ?></a>
    </li>
    <?php endforeach ?>
</ul>

<div class="row hidden" id="mega_menu_toogle">
    

    <!-- <div class="col-md-8">

        <div class="row" id="categories_menus">
            <?php foreach ($main_category as $key => $category): ?>
            	<div class="col-md-4">
	                <h5 class="category-title">
	                    <?= $category->name; ?>
	                </h5>
	                <ul class="nav nav-pills nav-stacked">
	                	<?php foreach ($category->sub_category as $key => $sub_category): ?>
	                    <li>
	                        <a href="<?= $sub_category->link; ?>"><?= $sub_category->name; ?></a>
	                    </li>
	                	<?php endforeach ?> 
	                </ul>
	            </div>
            <?php endforeach ?>   
        </div>
    </div> -->
    <?php foreach ($main_category as $key => $category): ?>
    <div class="col-md-8 hidden mega_menu_cat" id="mega_menu_cat_<?= $category->id; ?>">
        <div class="row categories_menus">
            <?php foreach ($category->sub_category as $key => $sub_category): ?>
                 <div class="col-md-4">
                    <h5 class="category-title">
                        <a href="<?= $sub_category->link; ?>"><?= $sub_category->name; ?></a>
                    </h5>
                </div>
            <?php endforeach ?> 
        </div>
    </div>
    <?php endforeach ?>

    <!-- <div class="col-md-4">
        <div id="ads">
        	<?php if (!is_empty($category_menu_img_pub)): ?>
        		<a href="#"><img alt="ads" src="<?= $category_menu_img_pub; ?>" style="width: 262px;height: 360px;"></a>
        	<?php endif ?>
        </div>
    </div> -->
</div>
