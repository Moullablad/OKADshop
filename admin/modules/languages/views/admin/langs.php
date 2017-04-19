<?php if( !is_empty($langs) ) : ?>
<div class="table-responsive">
	<table cellspacing="0" class="table table-striped table-bordered" id="datatable" width="100%">
	    <thead>
	        <tr>
	            <td><?php trans_e("#", "lang"); ?></th>
				<td><?php trans_e("Flag", "lang"); ?></th>
				<td><?php trans_e("Name", "lang"); ?></th>
				<td><?php trans_e("Locale", "lang"); ?></th>
				<td><?php trans_e("ISO code", "lang"); ?></th>
				<td><?php trans_e("Date format", "lang"); ?></th>
				<td><?php trans_e("Datetime format", "lang"); ?></th>				
				<td><?php trans_e("Direction", "lang"); ?></th>
				<td><?php trans_e("Default", "lang"); ?></th>
				<td><?php trans_e("Active", "lang"); ?></th>
				<td width="130"><?php trans_e("Actions", "lang"); ?></th>
	        </tr>
	    </thead>
	    <tbody>
	    	<?php foreach ($langs as $key => $lang) : ?>
	        <tr>
	            <td width="10"><?php echo $lang->id; ?></td>
	            <td width="50" align="center">
	            	<i class="flagstrap-icon flagstrap-<?php echo strtolower($lang->flag); ?>"></i>
	            </td>
	            <td><?php echo $lang->name; ?></td>
	            <td><?php echo $lang->locale; ?></td>
	            <td><?php echo $lang->iso_code; ?></td>
	            <td><?php echo date($lang->date_format); ?></td>
	            <td><?php echo date($lang->datetime_format); ?></td>
	            <td width="50" align="center">
	            	<?php if( $lang->direction == '0' ) : ?>
		           		<i class="fa fa-align-left"></i>
		           	<?php else : ?>
		           		<i class="fa fa-align-right" style="color: #d9534f;"></i>
		           	<?php endif; ?>
	            </td>
	            <td width="50" align="center">
	            	<?php if( $lang->default_lang == '1' ) : ?>
		           		<i class="fa fa-star" style="color: #A5245E;"></i>
		           	<?php endif; ?>
	            </td>
	            <td width="50" align="center">
	            	<?php if( $lang->active == '1' ) : ?>
		           		<i class="fa fa-check-circle"></i>
		           	<?php else : ?>
		           		<i class="fa fa-times" style="color: #d9534f;"></i>
		           	<?php endif; ?>
	            </td>
	            <td>
		            <form method="POST" action="">
	            		<a class="btn btn-default" href="<?php echo get_page_url('lang&id='.$lang->id, __FILE__); ?>"><i class="fa fa-pencil"></i>&nbsp;<?php trans_e("Edit", "lang") ?></a>
		            	<button onclick="return confirmMessage();" type="submit" class="btn btn-danger" value="<?php echo $lang->id; ?>" name="delete_lang"><i class="fa fa-trash"></i>&nbsp;<?php trans_e("Delete", "lang"); ?></button>
		            </form>
	            </td>
	        </tr>
		    <?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php else : ?>
	<?php get_view(__FILE__, 'alerts', [
		'info' => trans("There is no installed languages.", "lang")
	]); ?>
<?php endif; ?>