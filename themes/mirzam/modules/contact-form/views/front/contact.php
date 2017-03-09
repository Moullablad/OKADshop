<div class="container" id="contact">
    <div class="row">
        <div class="col-sm-3">
            <h1><?php trans_e("Contact Us", "mirzam");?></h1>
            <strong><?php trans_e("Contact information", "mirzam");?></strong>
            <ul>
                <li><p><?= $shop->name; ?></p></li>
                <li><?= $shop->tagline; ?></li>
                <?php if( !is_empty($shop->phone) ) : ?>
                    <li><?php trans_e("Phone:", "mirzam");?> <?= $shop->phone; ?></li>
                <?php endif; ?>
                <?php if( !is_empty($shop->phone) ) : ?>
                    <li><?php trans_e("E-mail:", "mirzam");?> <?= $shop->email; ?></li>
                <?php endif; ?>
            </ul>
        </div><!-- /.col-sm-3 -->

        <div class="col-sm-5 col-sm-offset-3">
            <form id="contactForm" class="osForm" method="post" action="<?=site_url('modules/contact-form/ajax/form.php');?>">
                <h2><?php trans_e("Leave a message", "mirzam");?></h2>
                <div class="form-group">
                    <label for="fullname"><?php trans_e("Full name", "mirzam");?> *</label>
                    <input value="" type="text" name="name" class="form-control" id="fullname" required>
                </div>
                <div class="form-group">
                    <label for="email"><?php trans_e("E-mail", "mirzam");?> *</label>
                    <input value="" type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="form-group">
                    <label for="website"><?php trans_e("Website", "mirzam");?></label>
                    <input value="" type="text" name="website" class="form-control" id="website">
                </div>
                <div class="form-group">
                    <label for="subject"><?php trans_e("Subject", "mirzam");?> *</label>
                    <input value="" type="text" name="subject" class="form-control" id="subject" required>
                </div>
                <div class="form-group">
                    <label for="content"><?php trans_e("Content", "mirzam");?> *</label>
                    <textarea name="content" class="form-control" id="content" required></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-orange pull-right" value="<?php trans_e("Send", "mirzam");?>">
                </div>
            </form>
        </div>
    </div>
</div>