<?php if ( logged() ) : ?>
    <ul class="auth">
        <li><a href="<?= get_url( 'account' );?>"><i class="fa fa-user-circle"></i> <?php trans_e("My account", "account"); ?></a></li>
        <li><a href="<?= get_url( 'account/logout' );?>"><i class="fa fa-sign-out"></i> <?php trans_e("Logout", "account"); ?></a></li>
    </ul>
<?php else : ?>
    <ul class="auth">
        <li><a href="<?= get_url('account/login');?>"><i class="fa fa-user"></i> <?php trans_e("Login", "account"); ?></a></li>
        <li><a href="<?= get_url( 'account/register' );?>"><i class="fa fa-user-plus"></i> <?php trans_e("Register", "account"); ?></a></li>
    </ul>
<?php endif; ?>