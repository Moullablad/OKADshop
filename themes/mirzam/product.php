<section class="banner bg-parallax" style="background: url('<?= default_product_image($product->id, '570x697') ?>') no-repeat; background-size: cover;">
    <div class="overlay" ></div>
    <div class="container">
        <div class="banner-content text-center">
            <h2 class="page-title"><?= $product->name; ?></h2>
            <div class="breadcrumbs">
                <a href="<?= get_home_url();?>" title=""><?php trans_e("Home", "frochka"); ?></a>
                <a href="<?= $product->category_link; ?>" title=""><?= $product->category; ?></a>
                <span><?= $product->name; ?></span>
            </div>
        </div>
    </div>
</section>

<?php get_section('top_product'); ?>

<div id="main-container">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="single-images">
                <?php if( $product->discount > 0 ) : ?>
                    <?php $percent = ($product->discount/$product->sell_price) * 100; ?>
                    <div class="percent-saleoff"> <span><label><?php echo intval($percent); ?>%</label></span></div>
                <?php endif; ?>
                <?php if( !is_empty($images) ) : ?>
                    <a class="popup-image" href="<?= default_product_image($product->id, '570x697'); ?>">
                        <img alt="" class="main-image img-responsive" src="<?= default_product_image($product->id, '570x697'); ?>">
                    </a>
                <?php endif; ?>
                </div>
                <div class="single-product-thumbnails">
                    <?php foreach ($images as $key => $image) : ?>
                        <a data-name="<?= $image->name; ?>" data-image-full="<?= product_image_by_size($image->name, $product->id, '570x697'); ?>">
                            <img class="img-thumbnail" src="<?= product_image_by_size($image->name, $product->id, '76x76'); ?>">
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="summary entry-summary">
                    <h1 class="product_title entry-title"><?= $product->name; ?></h1>
                    <div class="description">
                        <p><?= $product->short_description; ?></p>
                    </div>
                    <p class="price">
                        <?php
                         if( $product->discount > 0 ) : ?>
                            <ins><?=$product->sell_price .' '. $currency;?></ins>
                            <del><span class="old-amount"><?=$product->old_price .' '. $currency;?></span></del>
                        <?php else : ?>
                            <ins><?=$product->sell_price .' '. $currency;?></ins>
                        <?php endif; ?>
                    </p>

                    <p>
                        <table>
                            <?php if( !is_empty($product->reference) ) : ?>
                                <tr>
                                    <th width="90"><?php trans_e("Reference", "frochka"); ?></th>
                                    <td>: <?= $product->reference; ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if( !is_empty($product->product_condition) ) : ?>
                                <tr>
                                    <th><?php trans_e("Condition", "frochka"); ?></th>
                                    <td>: <?= $product->product_condition; ?></td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </p>
                    <br>

                    <div id="product_attributes">
                        <?php if ( !is_empty($declinaisons) ) : ?>
                            <?php foreach ($declinaisons as $key => $dec): ?>
                                <div class="form-group">
                                    <label for="<?= $dec->attribute->name; ?>"><?= $dec->attribute->name; ?> :</label>
                                    <select class="select_chosen" data-id="<?= $dec->attribute->id; ?>" id="<?= $dec->attribute->name; ?>">
                                        <option value="0"><?php trans_e('Choose a value', 'mirzam'); ?></option>
                                        <?php foreach ($dec->values as $key => $value): ?>
                                            <option value="<?= $value->id; ?>"><?= $value->name; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>
                        <p id="availability_statut">
                            <?php if( isset($product->id_comb) || $product->quantity!='0' ) : ?>
                                <span><?=$product->quantity .' '. trans("Item(s)", "core");?></span>&nbsp;&nbsp;<span class="label label-success"><?php trans_e("In stock", "core");?></span>
                            <?php else : ?>
                                <span id="availability_value" class="label label-warning"><?php trans_e("This product is no longer in stock with those attributes but is available with others.", "core");?></span>
                            <?php endif; ?>
                        </p>
                    </div>

                    <form id="cart_form" action="" method="post" <?=($product->quantity=='0') ? 'style="display:none;"' : '';?>>
                        <input id="idProduct" name="id_product" type="hidden" value="<?= $product->id; ?>"> 
                        <input id="idDeclinaison" name="id_declinaison" type="hidden" value="<?=( isset($product->id_comb) ) ? $product->id_comb : '';?>">
                        <div class="single_variation_wrap">
                            <div class="box-qty">
                                <a class="quantity-plus" href="#"><i class="fa fa-angle-up"></i></a>
                                <input class="input-text qty text" name="quantity" size="4" step="1" min="<?=$product->min_quantity;?>" title="Qty" type="text" value="<?=$product->min_quantity;?>"> 
                                <a class="quantity-minus" href="http://192.168.1.40/okadshop/product/8-"><i class="fa fa-angle-down"></i></a>
                            </div>
                            <button type="submit" id="add_to_cart" class="single_add_to_cart_button"><?=get_cart_label($product->id);?></button> 
                            <!--a class="buttom-wishlist" href="#"><i class="fa fa-heart-o"></i></a-->
                        </div>
                    </form>


                    <div class="product-share">
                        <strong><?php trans_e("Share:", "frochka"); ?></strong> 
                        <?= get_chare_buttons(); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product tab -->
        <div class="product-tabs">
            <ul class="nav-tab">
                <?php if( $product->long_description != "" ) : ?>
                    <li class="active">
                        <a data-toggle="tab" href="#tab_long_desc"><?php trans_e("Description", "frochka"); ?></a>
                    </li>
                <?php endif; ?>
                <?php if( !is_empty($features) ) : ?>
                    <li>
                        <a data-toggle="tab" href="#tab_features"><?php trans_e("Product Features", "frochka"); ?></a>
                    </li>
                <?php endif; ?>
                <?php if( !is_empty($tags) ) : ?>
                    <li>
                        <a data-toggle="tab" href="#tab_tags"><?php trans_e("Product tags", "frochka"); ?></a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="tab-content">
                <?php if( $product->long_description != "" ) : ?>
                    <div class="active tab-pane" id="tab_long_desc">
                        <?= $product->long_description; ?>
                    </div>
                <?php endif; ?>
                <?php if( !is_empty($features) ) : ?>
                    <div class="tab-pane" id="tab_features">
                        <table class="table table-bordered">
                            <?php foreach ($features as $key => $feature) : ?>
                                <tr>
                                    <th width="100"><?= $feature->name; ?></th>
                                    <td><?= ($feature->custom != "") ? $feature->custom : $feature->value; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                <?php endif; ?>
                <?php if( !is_empty($tags) ) : ?>
                    <div class="tab-pane" id="tab_tags">
                        <div class="tagcloud">
                            <?php foreach ($tags as $key => $tag) : ?>
                                <a><?= $tag->name; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div><!-- ./ Product tab -->


    </div>
</div>
