<?php if ( logged() ) : ?>
    <ul class="auth">
        <li><a href="<?= get_url( 'account' );?>"><i class="fa fa-user-circle"></i> <?php trans_e("My account", "mirzam"); ?></a></li>
        <li><a href="<?= get_url( 'account/logout' );?>"><i class="fa fa-sign-out"></i> <?php trans_e("Logout", "mirzam"); ?></a></li>
    </ul>
<?php else : ?>
    <ul class="auth">
        <li><a href="<?= get_url('account/login');?>"><i class="fa fa-user"></i> <?php trans_e("Login", "mirzam"); ?></a></li>
        <li><a href="<?= get_url( 'account/register' );?>"><i class="fa fa-user-plus"></i> <?php trans_e("Register", "mirzam"); ?></a></li>
    </ul>
<?php endif; ?>