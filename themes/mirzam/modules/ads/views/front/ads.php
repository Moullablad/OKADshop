<ul id="aside_banner">
<?php foreach ($ads_images_data as $key => $img): ?>
	<li class="mt-20">
		<img src="<?=site_url($img['filename']); ?>" class="img-responsive" />
	</li>
<?php endforeach ?>
</ul>