<section class="banner banner-contact bg-parallax">
    <div class="overlay"></div>
    <div class="container">
        <div class="banner-content text-center">
            <h2 class="page-title"><?php trans_e("Contact Us", "cf");?></h2>
            <div class="breadcrumbs">
                <a href="<?= $shop->home_url; ?>"><?php trans_e("Home", "cf");?></a>
                <span><?php trans_e("Contact Us", "cf");?></span>
            </div>
        </div>
    </div>
</section>

<div class="maincontainer page-contact">

    <div class="container">
        <div class="row">

            <div class="col-sm-6">
                <div class="section-contact-info">
                    <h3 class="block-title"><?php trans_e("contact informations", "cf");?></h3>
                    <p><?= $shop->tagline; ?></p>
                    <div class="block-info-contact">
                        <div class="social-network">
                            <span><?php trans_e("Connect with us", "cf");?></span>
                            <?= get_chare_buttons(); ?>
                        </div>
                        <div class="infomation">
                            <?php if( !is_empty($shop->address1) ) : ?>
                                <span><span class="icon"><i class="fa fa-anchor"></i></span> <?= $shop->address1; ?></span> 
                            <?php endif; ?>
                            <?php if( !is_empty($shop->phone) ) : ?>
                                <span><span class="icon"><i class="fa fa-phone"></i></span> <?php trans_e("Phone:", "cf");?> <?= $shop->phone; ?></span> 
                            <?php endif; ?>
                            <?php if( !is_empty($shop->email) ) : ?>
                                <span><span class="icon"><i class="fa fa-life-ring"></i></span> <?= $shop->email; ?></span> 
                            <?php endif; ?>
                            <!--span><span class="icon"><i class="fa fa-clock-o"></i></span> OPEN TIME: 9AM - 6PM</span-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="section-contact-info">
                    <h3 class="block-title"><?php trans_e("Leave message", "cf");?></h3>
                    <form id="contactForm" class="form-contact" method="post" action="modules/contact-form/ajax/form.php">
                        <div id="message-box-conact"></div>
                        <div class="row">
                            <div class="col-sm-6">
                                <p>
                                    <label><?php trans_e("Name", "cf");?> <span class="required">*</span></label> 
                                    <input name="name" id="name" type="text" required>
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p>
                                    <label><?php trans_e("Email", "cf");?> <span class="required">*</span></label> 
                                    <input name="email" id="email" type="text" required>
                                </p>
                            </div>
                        </div>
                        <p>
                            <label><?php trans_e("Website", "cf");?></label>
                            <input name="website" id="website" type="text">
                        </p>
                        <p>
                            <label><?php trans_e("Subject", "cf");?> <span class="required">*</span></label>
                            <input name="subject" id="subject" type="text" required>
                        </p>
                        <p>
                            <label><?php trans_e("Content", "cf");?> <span class="required">*</span></label> 
                            <textarea name="content" id="content" rows="5" required></textarea>
                        </p>
                        <p class="btn-submit">
                            <button type="submit" class="button"><?php trans_e("Send message", "cf");?></button>
                        </p>
                    </form>
                </div>
            </div>


        </div>
    </div>

    <?php if( !is_empty($shop->latitude) && !is_empty($shop->longitude) ) : ?>
    <div class="google-map">
        <div id="canvas-for-google-map">
            <iframe style="border: 0;" src="https://maps.google.com/maps?q=<?=$shop->latitude;?>,<?=$shop->longitude;?>&amp;z=14&amp;output=embed&amp;iwloc=0" width="100%" height="325" frameborder="0"></iframe>
        </div>
    </div>
    <?php endif; ?>


</div>