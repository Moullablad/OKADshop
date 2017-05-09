<?php uasort($tabs, "sort_tabs"); ?>
<div id="<?=$location;?>" class="os-tab-container <?=($args['ajax']) ? 'ajaxTab' : ''; ?> mt-50">
	<div class="container">
		<div class="row">

			<div id="os-tabs">
				<ul class="nav nav-tabs bg-white" data-location="<?=$location;?>">
					<?php foreach ($tabs as $key => $tab) : ?>
						<li <?=($active_tab==$key) ? 'class="active"' : '';?>>
							<a data-toggle="tab" href="#" data-tab="<?=$key;?>" data-ajax="<?=$data_ajax;?>" data-lang="<?=($tab['multilang']) ? 'yes' : 'no'; ?>"><?php trans_e(ucfirst($tab['name']), "account"); ?></a>
						</li>
					<?php endforeach; ?>

					<?php //if($args['multilang']) : ?>
						<li class="pull-right" style="margin: 5px 5px 0 0;">
							<select name="trans[id_lang]" class="form-control" id="languages">
							<?php foreach (get_languages() as $key => $lang) : ?>
								<option value="<?=$lang->id;?>" <?=($lang->id==$id_lang) ? 'selected' : '';?>><?=$lang->name;?></option>
							<?php endforeach; ?>
							</select>
						</li>
					<?php //endif; ?>
				</ul>
			</div>

		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- /#account -->

<div id="os-tab-contents" class="tab-content mt-30">
	<div class="container" id="account-content">
		<div class="row">
			<?php if( false !== $args['ajax'] ) : ?>
				<?php get_tab_contents($active_tab, $location, $args); ?>
			<?php else : ?>
				<?php foreach ($tabs as $active => $tab) : ?>
					<?php get_tab_contents($active, $location, $args); ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div><!-- /.row -->
	</div><!-- /.container -->

</div><!-- /#os-tab-contents -->
