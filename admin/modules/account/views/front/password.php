<div class="container" id="reset-password">
    <div class="row">
        <!-- message notification -->
        <div class="col-sm-12">
            <?php //get_view(__FILE__, 'alerts', $message); ?>
        </div>

        <div class="col-sm-12 col-md-7">
            <h2 class="crimson-text font-italic"><?php trans_e("Forgot your password?", "frochka"); ?></h2>
            <strong><?php trans_e("Please enter the email address you used to register. We will then send you a new password.", "frochka"); ?></strong>
            <form class="osForm mt-30" role="form" method="POST">
                <div class="form-group">
                    <label for="email"><?php trans_e("Email address", "account"); ?> *</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="<?php trans_e("Your E-mail...", "account"); ?>" required>
                </div>
                <div class="form-group">
                    <input name="reset" type="submit" class="btn btn-large" value="<?php trans_e("Retrieve Password", "account"); ?>">
                </div>
            </form>
        </div>
    </div><!-- /.row -->
</div><!-- /#reset-password -->