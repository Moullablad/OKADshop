<div class="panel panel-default tab-pane fade <?=($args['ajax']) ? 'in active' : '';?>" id="<?=$active;?>">
	<?php if($with_form) : ?>
	<form class="form-horizontal" method="post" enctype="multipart/form-data">
	<?php endif; ?>
		<?php if($with_head) : ?>
			<div class="panel-heading"><?=ucfirst($tab_name);?></div>
		<?php endif; ?>
		<div class="panel-body">
			<?= $content; ?>
		</div>
	<?php if($with_form) : ?>
		<div class="panel-footer">
		    <a type="button" href="<?=admin_url('index.php');?>" class="btn btn-default"><?php trans_e("Cancel", "core"); ?></a>
		    <button name="<?=$active;?>_form" type="submit" class="btn btn-primary pull-right"><?php trans_e("Save", "core"); ?></button>
		</div>
	</form>
	<?php endif; ?>
</div>