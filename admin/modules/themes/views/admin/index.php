<?php
/**
 * 2016 OkadShop
 * Open source ecommerce software
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OKADshop <contact@okadshop.com>
 * @copyright 2016 OKADshop
 */
?>
<div class="top-menu padding0">
    <div class="top-menu-title">
        <h3><i class="fa fa-desktop"></i> <?php trans_e("Themes", "themes"); ?></h3>
    </div>
    <div class="top-menu-button">
    	<a href="?module=themes&page=install" class="btn btn-primary"><i class="fa fa-plus-square"></i> <?php trans_e("Add new", "themes"); ?></a>
	</div>
</div><br>

<div class="row" id="themes">
	<?php if( !empty($themes) ) : foreach ($themes as $key => $theme) : ?>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-body">
				<img src="<?=get_theme_icon($theme->name);?>" class="icon img-responsive">
			</div>
			<div class="panel-footer">
				<?php if( $theme->active == $theme->name) : ?>
					<span class="label label-success"><?php trans_e("Active", "themes"); ?></span> 
				<?php endif; ?>
				<strong><?=$theme->name;?></strong>
				<?php if( $theme->active != $theme->name) : ?>
					<a href="#" class="btn btn-primary activate btn-sm pull-right" data-name="<?=$theme->name;?>"><?php trans_e("Activate", "themes"); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endforeach; endif; ?>
</div>    