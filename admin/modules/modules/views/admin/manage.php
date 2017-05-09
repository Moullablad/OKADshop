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

// var_dump(module_url('core-account'));


//get modules categories
$categories = get_modules_categories();

//get categories and authors
$authors = array();
foreach ($modules as $key => $module) {
	if( !array_key_exists($module['category'], $categories) ){
		$categories[$module['category']] = $module['category'];
	}
	if( !in_array($module['author'], $authors) ){
		$authors[] = $module['author'];
	}
}
?>
<div class="top-menu padding0">
    <div class="top-menu-title">
        <h3><i class="fa fa-puzzle-piece"></i> <?php trans_e("Manage", "modules"); ?></h3>
    </div>
</div>

<div class="alert alert-info alert-white rounded" id="message" style="margin: 12px auto;">
    <div class="icon"><i class="fa fa-info-circle"></i></div>
    <strong><?php trans_e("Here you can manage modules.", "modules"); ?></strong> 
</div>


<section id="moduleFilter" class="bg-white">
	<form id="filterForm" method="get" name="filterForm">
		<div class="form-group col-sm-3 left0">
			<div class="input-group">
				<span class="input-group-btn" title="<?php trans_e("Show administration modules", "modules"); ?>">
					<div class="btn btn-default">
						<input type="checkbox" id="adminModules" name="adminModules">
					</div>
		        </span>
				<select class="form-control" id="categories" name="category">
					<option value=""><?php trans_e("Choose a category", "modules"); ?></option>
					<?php if( !empty($categories) ) : foreach ($categories as $name => $displayName) : ?>
						<?php if( $name != 'administration' ) : ?>
							<option value="<?=$name;?>"><?=$displayName;?></option>
						<?php endif; ?>
					<?php endforeach; endif; ?>
				</select>
			</div>
		</div>
		<div class="form-group col-sm-3 left0">
			<select class="form-control" id="status" name="status">
				<option value="" selected><?php trans_e("Activated & deactivated", "modules");?></option>
				<option value="1"><?php trans_e("Enabled modules", "modules");?></option>
				<option value="0"><?php trans_e("Disabled modules", "modules");?></option>
			</select>
		</div>
		<div class="form-group col-sm-2 left0">
			<select class="form-control" id="authors" name="authors">
				<option value=""><?php trans_e("Choose an author", "modules"); ?></option>
				<?php if( !empty($categories) ) : foreach ($authors as $author) : ?>
					<option value="<?=$author;?>"><?=$author;?></option>
				<?php endforeach; endif; ?>
			</select>
		</div>
		<div class="form-group col-sm-4 left0 right0">
			<input autocomplete="off" class="form-control" id="keywords" name="keywords" placeholder="<?php trans_e("Search...", "modules"); ?>" type="text" value="">
		</div>
	</form>
</section>

<section id="moduleList">
	<!-- bulk actions -->
    <form class="form-inline" id="bulk-actions" style="display: none;">
        <div class="form-group col-sm-3 padding0">
        	<span class="btn btn-default" id="checkall">
	          <input type="checkbox" name="checkall">
	        </span>
	        <select class="form-control">
	        	<option value=""><?php trans_e("Bulk Actions", "modules");?></option>
	        	<option value="activate"><?php trans_e("Activate", "modules");?></option>
	        	<option value="deactivate"><?php trans_e("Deactivate", "modules");?></option>
	        	<option value="delete"><?php trans_e("Delete", "modules");?></option>
	        </select>	
    		<button type="submit" class="btn btn-primary"><?php trans_e("Apply", "modules");?></button>
        </div>
    </form>

	<table class="table table-striped table-bordered bg-white">
		<thead class="hidden">
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</thead>
		<tbody></tbody>
	</table>
</section>