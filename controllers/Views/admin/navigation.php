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
        <h3><i class="<?php echo $icon; ?>"></i> <?php echo $name; ?></h3>
    </div>
    <div class="top-menu-button">
    	<?php
    	$args = array(
    		'label' => trans('Add new', 'core'),
			'class' => 'btn btn-primary',
			'icon' => 'fa fa-plus',
			'link' => '#'
		);
    	if( !empty($buttons) ) : foreach ($buttons as $key => $button) : 
    		$options = array_merge($args, $button);
    	?>
    		<a href="<?=$options['link']; ?>" class="<?=$options['class']; ?>"><i class="<?=$options['icon']; ?>"></i> <?=$options['label']; ?></a>
    	<?php endforeach; endif; ?>
	</div>
</div><br>