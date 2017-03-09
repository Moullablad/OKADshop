<section id="featured_ads">
	<div class="container">
		<div class="row">
		<?php foreach ($ads_images_data as $key => $img): ?>
			<div class="col-md-6 mb-sm-20 mb-xs-20">
				<a href="#"><img src="<?= site_url().$img['filename'] ?>" class="img-responsive" /></a>
			</div>
		<?php endforeach ?>
		</div>
	</div>
</section>