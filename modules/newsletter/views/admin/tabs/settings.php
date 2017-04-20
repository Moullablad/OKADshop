<div class="form-group">
    <label class="col-md-3 control-label" for="bg_image"><?php trans_e("Background Image", "nl"); ?></label>
    <div class="col-md-3">
        <div class="input-group file-upload">
            <input type="text" class="form-control" readonly>
            <label class="input-group-btn">
                <span class="btn btn-primary">
                    <?php trans_e("Browse", "nl"); ?> 
                    <input type="file" name="bg_image" id="bg_image" accept="image/*">
                </span>
            </label>
        </div>
        <strong class="help-block mb-0"><?php trans_e('Image dimensions should be 770x440.', 'nl'); ?></strong>
    </div>
</div>
<?php if(isset($bg_image) && $bg_image != '') : ?>
<div class="form-group">
    <div class="col-md-4 col-md-offset-3">
        <img src="<?php echo site_url($bg_image); ?>" width="770" class="img-thumbnail">
    </div>
</div>
<?php endif; ?>
<div class="form-group">
    <label class="control-label col-md-3" for="notice_message"><?php trans_e("Notice message", "nl"); ?></label>
    <div class="col-md-6">
        <textarea rows="5" name="notice_message" id="notice_message" class="form-control"><?= $notice_message;?></textarea>
    </div>
</div>