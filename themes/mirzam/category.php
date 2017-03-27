<?php
/**
 * The template for displaying category products.
 *
 * @link https://okdashop.com
 *
 * @package OKADshop
 */
//paginator vars
$orderby = $paginator->orderby;
$perpage = $paginator->perpage;
?>
<div class="container" id="home_category">
    <div class="row">

        <div class="col-md-3">
            <?php get_section('left_sidebar'); ?>
        </div><!-- /.left-side -->

        <div class="col-md-9">

            <?php if( isset($display_category_cover) ) : ?>
                <img src="<?= category_image($category->id, '846x280');?>" class="img-thumbnail img-responsive mb-30">
                <?php if( !is_empty($shildrens) ) : ?>
                <div class="mt-40 mb-50">
                    <div class="sub-categories pt-30 pb-15 pl-20 pr-20">
                           <?php foreach ($shildrens as $key => $shild): ?>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <div class="cat-block">
                                    <a href="category/<?= $shild->id.'-'.$shild->permalink; ?>" title="<?= $shild->name ?>"> 
                                       <img alt="<?= $shild->name ?>" src="<?= category_image($shild->id) ;?>" class="img-responsive">
                                       <strong><?= $shild->name ?></strong>
                                   </a>
                                </div>
                            </div>
                           <?php endforeach; ?>
                        <div class="clearfix"></div>
                    </div><!-- /.sub-categories -->
                </div><!-- /.row -->
                <?php endif; ?>  
            <?php endif; ?>  


            <?php if( !is_empty($products) ) : ?>

                <div class="row mb-20">
                    <div class="col-md-6">
                        <div class="sortbar">
                        <form class="osForm" method="post" action="">
                            <label><?php trans_e("Sort By:", "mirzam"); ?></label>
                            <select  name="perpage" class="productSort">
                                <option value="" selected><?php trans_e("Perpage", "mirzam"); ?></option>
                                <option value="9" <?= ($perpage == 9) ? 'selected' : ''; ?>>9</option>
                                <option value="12" <?= ($perpage == 12) ? 'selected' : ''; ?>>12</option>
                                <option value="24" <?= ($perpage ==  24) ? 'selected' : ''; ?>>24</option>
                            </select>
                            <select name="orderby" class="productSort" style="float: right;">
                                <option <?= ($orderby == 'cdate:asc' || $orderby == '') ? 'selected' : ''; ?> value="cdate:asc"><?php trans_e("Order products by", "mirzam"); ?></option>
                                <option <?= ($orderby == 'sell_price:asc') ? 'selected' : ''; ?> value="sell_price:asc"><?php trans_e("Price: Lowest first", "mirzam"); ?></option>
                                <option <?= ($orderby == 'sell_price:desc') ? 'selected' : ''; ?> value="sell_price:desc"><?php trans_e("Price: Highest first", "mirzam"); ?></option>
                                <option <?= ($orderby == 'quantity:des') ? 'selected' : ''; ?> value="quantity:desc"><?php trans_e("In stock", "mirzam"); ?></option>
                                <option <?= ($orderby == 'reference:asc') ? 'selected' : ''; ?> value="reference:asc"><?php trans_e("Reference: Lowest first", "mirzam"); ?></option>
                                <option <?= ($orderby == 'reference:desc') ? 'selected' : ''; ?> value="reference:desc"><?php trans_e("Reference: Highest first", "mirzam"); ?></option>
                            </select>
                        </form>
                        </div><!-- /#sortbar -->
                    </div>
                    <div class="col-md-6">
                        <div class="display-option pull-right mb-30">
                            <span><?php trans_e("View:", "mirzam"); ?></span>
                            <a class="view-as-grid selected" href="#"><i class="fa fa-th-large"></i></a>
                            <a class="view-as-list" href="#"><i class="fa fa-th-list"></i></a>
                        </div>
                    </div>
                </div><!-- /.sortbar -->

                <div class="products grid-view">
                <?php $lastItem = count( $products ); $i=1; foreach ($products as $key => $product) : ?>

                    <?php if( $i==1) : ?><div class="row mb-30"><?php endif; ?>

                        <?php get_template_view('product-item', array('product' => $product)); ?>

                    <?php if( $i == $lastItem) : ?>
                        </div><!-- /.row -->
                    <?php elseif( $i%3 == 0 ) : ?>
                        </div><!-- /.row --><div class="row mb-30">
                    <?php endif; ?>

                    <?php $i++; ?>
                <?php endforeach; ?>
                </div><!-- /.products -->

                <nav class="pagination">
                    <?php echo $paginator->links; ?>
                </nav>

            <?php else : ?>
                <?php get_view(__FILE__, 'alerts', array('info' => trans("No products available for this category.", "mirzam"))) ?>
            <?php endif; ?>
        </div><!-- /.col-md-9 -->

    </div><!-- /.row -->
</div><!-- /.container -->