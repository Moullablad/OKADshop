<?php if( !is_empty($categories) ) : ?>
<div class="table-responsive">
	<table cellspacing="0" class="table table-striped table-bordered" id="datatable" width="100%">
	    <thead>
	        <tr>
	            <td><?php trans_e("#", "cats"); ?></th>
				<td><?php trans_e("Image", "cats"); ?></th>
				<td><?php trans_e("Name", "cats"); ?></th>
				<td><?php trans_e("Description", "cats"); ?></th>
				<td><?php trans_e("Parent", "cats"); ?></th>
				<td><?php trans_e("Position", "cats"); ?></th>
				<td><?php trans_e("Active", "cats"); ?></th>
				<td width="130"><?php trans_e("Actions", "cats"); ?></th>
	        </tr>
	    </thead>
	    <tbody>
	    	<?php foreach ($categories as $key => $cat) : ?>
	        <tr>
	            <td width="10"><?php echo $cat->id_category; ?></td>
	            <td width="64">
	            	<?php 
	            	if( !empty($cat->cover) && file_exists(site_base($cat->cover)) ) :
	            	?>
	            		<img class="img-thumbnail" width="64" src="<?php echo site_url($cat->cover); ?>">
	            	<?php else : ?>
	            		<img class="img-thumbnail" width="64" src="<?php echo site_url('assets/img/defaults/76x76.png'); ?>">
	            	<?php endif; ?>
	            </td>
				<td><?php echo $cat->name; ?></td>
				<td><?php echo word_limit($cat->description, 20); ?></td>
				<td width="50">
					<span class="label label-default"><?php echo ($cat->parent_name!='') ? $cat->parent_name : 'N/A'; ?></span>
				</td>
				<td width="50" align="center">
					<input style="width:90%;text-align: center;" type="text" value="<?php echo $cat->position; ?>" disabled>
				</td>
				<td width="50" align="center">
	            	<?php if( $cat->active == '1' ) : ?>
		           		<i class="fa fa-check-circle"></i>
		           	<?php else : ?>
		           		<i class="fa fa-times" style="color: #d9534f;"></i>
		           	<?php endif; ?>
	            </td>
	            <td>
		            <form method="POST" action="">
	            		<a class="btn btn-default" href="<?php echo get_page_url('category&id='.$cat->id_category, __FILE__); ?>"><i class="fa fa-pencil"></i>&nbsp;<?php trans_e("Edit", "cats") ?></a>
	            		<?php if( $cat->id_parent != '0' ) : ?>
		            		<button onclick="return confirmMessage();" type="submit" class="btn btn-danger" value="<?php echo $cat->id_category; ?>" name="delete_cat"><i class="fa fa-trash"></i>&nbsp;<?php trans_e("Delete", "cats"); ?></button>
		            	<?php endif; ?>
		            </form>
	            </td>
	        </tr>
		    <?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php else : ?>
	<?php get_view(__FILE__, 'alerts', [
		'info' => trans("No records found.", "cats")
	]); ?>
<?php endif; ?>