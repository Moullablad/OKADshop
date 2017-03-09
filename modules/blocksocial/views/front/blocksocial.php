<ul id="blocksocial">
	<?php if( isset($bs->facebook) && trim($bs->facebook) != '' ) : ?>
		<li><a target="_blank" href="<?=$bs->facebook;?>"><i class="fa fa-facebook"></i></a></li>
	<?php endif; ?>
	<?php if( isset($bs->twitter) && trim($bs->twitter) != '' ) : ?>
		<li><a target="_blank" href="<?=$bs->twitter;?>"><i class="fa fa-twitter"></i></a></li>
	<?php endif; ?>
	<?php if( isset($bs->youtube) && trim($bs->youtube) != '' ) : ?>
		<li><a target="_blank" href="<?=$bs->youtube;?>"><i class="fa fa-youtube"></i></a></li>
	<?php endif; ?>
	<?php if( isset($bs->dribbble) && trim($bs->dribbble) != '' ) : ?>
		<li><a target="_blank" href="<?=$bs->dribbble;?>"><i class="fa fa-dribbble"></i></a></li>
	<?php endif; ?>
	<?php if( isset($bs->rss) && trim($bs->rss) != '' ) : ?>
		<li><a target="_blank" href="<?=$bs->rss;?>"><i class="fa fa-rss"></i></a></li>
	<?php endif; ?>
	<?php if( isset($bs->google_plus) && trim($bs->google_plus) != '' ) : ?>
		<li><a target="_blank" href="<?=$bs->google_plus;?>"><i class="fa fa-google-plus"></i></a></li>
	<?php endif; ?>
	<?php if( isset($bs->instagram) && trim($bs->instagram) != '' ) : ?>
		<li><a target="_blank" href="<?=$bs->instagram;?>"><i class="fa fa-instagram"></i></a></li>
	<?php endif; ?>
	<?php if( isset($bs->vimeo) && trim($bs->vimeo) != '' ) : ?>
		<li><a target="_blank" href="<?=$bs->vimeo;?>"><i class="fa fa-vimeo"></i></a></li>
	<?php endif; ?>
	<?php if( isset($bs->pinterest) && trim($bs->pinterest) != '' ) : ?>
		<li><a target="_blank" href="<?=$bs->pinterest;?>"><i class="fa fa-pinterest"></i></a></li>
	<?php endif; ?>
</ul>

