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
        <h3><i class="fa fa-puzzle-piece"></i> <?php trans_e("Positions", "modules"); ?></h3>
    </div>
</div>


<div class="alert alert-info alert-white rounded" id="message" style="margin: 12px auto;">
    <div class="icon"><i class="fa fa-info-circle"></i></div>
    <strong><?php trans_e("Search hooks and add them to selected section in right side.", "modules"); ?></strong> 
</div>

<div class="col-sm-6 left0">
	<div class="table-responsive posBox">
		<table class="table" id="modulesHooks">
			<thead>
				<th>image</th>
				<th>name</th>
				<th>action</th>
			</thead>
			<tbody>
				<?php foreach ($hooks['inactive'] as $function => $hook) : ?>
				<tr data-func="<?=$function;?>" data-name="<?=$hook['module_name'];?>">
					<td width="56">
						<img src="<?=get_module_icon($hook['module_name']);?>" class="img-thumbnail">
					</td>
					<td>
						<strong><?=$hook['name'];?></strong>
						<p><?=$hook['description'];?></p>
					</td>
					<td width="60"><a href="#" class="btn btn-default btn-xs add_hook" data-func="<?=$function;?>">Add</a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<div class="col-sm-6 padding0">
	<div class="table-responsive posBox">
		<table class="table" id="themePositions">
			<thead>
				<th colspan="3">
					<select id="sections">
						<?php $sections = get_sections();
						if( !empty($sections) ) : foreach ($sections as $name => $section) : ?>
							<option value="<?=$name;?>"><?=$section['displayName'];?></option>
						<?php endforeach;  endif; ?>
					</select>
				</th>
			</thead>
			<tbody class="sortableHooks">
			<?php if( isset($hooks['active']) && !empty($hooks['active']) ) : ?>
				<?php foreach ($hooks['active'] as $function => $hook) : ?>
				<tr data-func="<?=$function;?>" data-name="<?=$hook['module_name'];?>">
					<td width="75">
						<img src="<?=get_module_icon($hook['module_name']);?>" class="img-thumbnail">
					</td>
					<td>
						<strong><?=$hook['name'];?></strong>
						<p><?=$hook['description'];?></p>
					</td>
					<td width="50"><a href="#" class="btn btn-danger btn-xs delete_hook" data-func="<?=$function;?>">Remove</a></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="norecord">
					<td colspan="3">
						<div class="alert alert-info alert-white rounded" id="message" style="display: block;margin: 12px auto;">
						    <div class="icon"><i class="fa fa-info-circle"></i></div>
						    <strong><?php trans_e("There is no hook in this section.", "modules"); ?></strong> 
						</div>
					</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>