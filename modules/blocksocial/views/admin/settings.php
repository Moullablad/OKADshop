<div class="top-menu padding0">
    <div class="top-menu-title">
        <h3><i class="fa fa-share-alt"></i> <?php trans_e("Social sharing", "social");?></h3>
    </div>
</div><br>

<div class="panel panel-default">
    <form class="form-horizontal" id="blocksocial" method="post" action="">
        <div class="panel-heading"><?= l("Social networking block", "social");?></div>
        <div class="panel-body">

            <?php get_view(__FILE__, 'alerts', $message); ?>

            <div class="form-group">
                <label class="control-label col-sm-3" for="facebook"><?php trans_e("Facebook", "social"); ?></label>
                <div class="col-sm-4">
                    <input type="text" name="facebook" id="facebook" class="form-control" autofocus value="<?= $bs->facebook;?>" placeholder="<?php trans_e("Your Facebook fan page.", "social"); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="twitter"><?php trans_e("Twitter", "social"); ?></label>
                <div class="col-sm-4">
                   <input type="text" name="twitter" id="twitter" class="form-control" value="<?= $bs->twitter;?>" placeholder="<?php trans_e("Your official Twitter account.", "social"); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="rss"><?php trans_e("RSS", "social"); ?></label>
                <div class="col-sm-4">
                   <input type="text" name="rss" id="rss" class="form-control" value="<?= $bs->rss;?>" placeholder="<?php trans_e("The RSS feed of your choice (your blog, your store, etc.).", "social"); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="youtube"><?php trans_e("YouTube", "social"); ?></label>
                <div class="col-sm-4">
                   <input type="text" name="youtube" id="youtube" class="form-control" value="<?= $bs->youtube;?>" placeholder="<?php trans_e("Your official YouTube account.", "social"); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="google_plus"><?php trans_e("Google+", "social"); ?></label>
                <div class="col-sm-4">
                   <input type="text" name="google_plus" id="google_plus" class="form-control" value="<?= $bs->google_plus;?>" placeholder="<?php trans_e("Your official Google+ page.", "social"); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="pinterest"><?php trans_e("Pinterest", "social"); ?></label>
                <div class="col-sm-4">
                   <input type="text" name="pinterest" id="pinterest" class="form-control" value="<?= $bs->pinterest;?>" placeholder="<?php trans_e("Your official Pinterest account.", "social"); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="instagram"><?php trans_e("Instagram", "social"); ?></label>
                <div class="col-sm-4">
                   <input type="text" name="instagram" id="instagram" class="form-control" value="<?= $bs->instagram;?>" placeholder="<?php trans_e("Your official Instagram account.", "social"); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="vimeo"><?php trans_e("Vimeo", "social"); ?></label>
                <div class="col-sm-4">
                   <input type="text" name="vimeo" id="vimeo" class="form-control" value="<?= $bs->vimeo;?>" placeholder="<?php trans_e("Your official Vimeo account.", "social"); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="vimeo"><?php trans_e("Dribbble", "social"); ?></label>
                <div class="col-sm-4">
                   <input type="text" name="dribbble" id="dribbble" class="form-control" value="<?= $bs->dribbble;?>" placeholder="<?php trans_e("Your official Dribbble account.", "social"); ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-3">
                    <button type="submit" class="btn btn-primary pull-right"><?php trans_e("Save changes", "social"); ?></button>
                </div>
            </div>

        </div>
    </form>
</div>