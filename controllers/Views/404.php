<div class="container" style="margin: 50px auto;">
    <div class="col-lg-8 col-lg-offset-2 text-center">
        <div class="logo">
            <h1><?php trans_e("OPPS, Error 404 !", "core"); ?></h1>
        </div>
        <div class="clearfix"></div>
        <p class="text-muted"><?php trans_e("There is some error here, Please try later.", "core"); ?></p>
        <div class="clearfix"></div><br>
        <br>
        <div class="col-lg-6 col-lg-offset-3">
            <form action="#">
                <div class="input-group">
                    <input class="form-control" placeholder="<?php trans_e("search ...", "core"); ?>" type="text"> 
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
        <div class="clearfix"></div><br>
        <div class="col-lg-6 col-lg-offset-3">
            <div class="btn-group btn-group-justified">
                <a class="btn btn-success" href="<?= ghet_home_url(); ?>"><?php trans_e("Return Website", "core"); ?></a>
            </div>
        </div>
    </div>
</div><!-- END PAGE CONTENT -->