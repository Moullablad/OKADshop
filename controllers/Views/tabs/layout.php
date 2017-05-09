<div id="<?=$location;?>" class="os-tab-container <?=($args['ajax']) ? 'ajaxTab' : ''; ?>"  data-group="<?=$args['group'];?>">
	<div class="col-sm-12 padding0" id="os-tabs">
		<ul class="nav nav-tabs bg-white" data-location="<?=$location;?>">
			<?php foreach ($tabs as $key => $tab) : ?>
				<li <?=($active_tab==$key) ? 'class="active"' : '';?>>
					<?php if( $args['type'] == 'link' ) : ?>
						<a href="dddd"><?=ucfirst($tab['name']);?></a>
					<?php else : ?>
						<a data-toggle="tab" href="#" data-tab="<?=$key;?>" data-ajax="<?=$data_ajax;?>" data-lang="<?=($tab['multilang']) ? 'yes' : 'no'; ?>"><?=ucfirst($tab['name']);?></a>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>

			<?php //if($args['multilang']) : ?>
				<li class="pull-right" style="margin: 5px 5px 0 0;">
					<select class="form-control" id="languages">
					<?php foreach (get_languages() as $key => $lang) : ?>
						<?php $selected = ($id_lang == $lang->id) ? 'selected' : ''; ?>
						<option value="<?=$lang->id;?>" <?=$selected?>><?=$lang->name;?></option>
					<?php endforeach; ?>
					</select>
				</li>
			<?php //endif; ?>
		</ul>
	</div>

	<div class="col-sm-12 p-0 mt-10" id="os-tab-contents">
		<?php if( false !== $args['ajax'] ) : ?>
			<?php get_tab_contents($active_tab, $location, $args); ?>
		<?php else : ?>
			<?php foreach ($tabs as $active => $tab) : ?>
				<?php get_tab_contents($active, $location, $args); ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>