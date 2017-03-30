<ul class="nav nav-pills nav-stacked mega-menu mb-xs-20 block-categories " id="nav_category">
    <li class="nav-title">
        <a><?php trans_e('CATEGORIES', 'mirzam'); ?></a>
    </li>
    <?php foreach ($main_category as $key => $category): ?>
    <li>
        <a class="mega-menu-item" href="<?= $category->link; ?>" data-cat="<?= $category->id; ?>">  <?= $category->name; ?></a>
    </li>
    <?php endforeach ?>
</ul>

<div class="row hidden" id="mega_menu_toogle">
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
</div>
