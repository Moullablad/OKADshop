<?php if( isset($category->id_category) ) : ?>
    <input type="hidden" name="id_category" id="id_category" value="<?php echo $category->id_category; ?>">
    <div class="form-group">
        <label class="col-md-3 control-label" for="cover"><?php trans_e("Cover", "cats"); ?></label>  
        <div class="col-md-4">
            <input type="file" name="cover" id="cat_cover" accept="image/*">
        </div>
    </div>
    <?php if(isset($category->cover) && $category->cover != '') : ?>
    <div class="form-group" id="category-cover-wrap">
        <div class="col-md-4 col-md-offset-3">
            <img src="<?php echo site_url($category->cover); ?>" height="120" class="img-responsive img-thumbnail">
            <a href="#" class="delete-cover" onclick="return deleteCategoryCover();"><i class="fa fa-times-circle fa-2x"></i></a>
        </div>
    </div>
    <?php endif; ?>
<?php else : ?>
  <?php get_view(__FILE__, 'alerts', [
    'warning' => trans("You must save this category before adding image.", "cats")
  ]); ?>
<?php endif; ?>