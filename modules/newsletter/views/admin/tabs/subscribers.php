<?php if( !is_empty($subscribers) ) : ?>
<div class="table-responsive">
<table cellspacing="0" class="table table-striped table-bordered" id="datatable" width="100%">
    <thead>
        <tr>
            <td><?php trans_e("ID", "nl"); ?></th>
			<td><?php trans_e("First name", "nl"); ?></th>
			<td><?php trans_e("Last name", "nl"); ?></th>
			<td><?php trans_e("Email", "nl"); ?></th>
			<td><?php trans_e("Created", "nl"); ?></th>
			<td><?php trans_e("Updated", "nl"); ?></th>
			<td width="80"><?php trans_e("Actions", "nl"); ?></th>
        </tr>
    </thead>
    <tbody>
    	<?php foreach ($subscribers as $key => $subscriber) : ?>
        <tr>
            <td width="10"><?= $subscriber->id; ?></td>
            <td><?= ($subscriber->first_name!='') ? $subscriber->first_name : '---'; ?></td>
            <td><?= ($subscriber->last_name!='') ? $subscriber->last_name : '---'; ?></td>
            <td><?= $subscriber->email; ?></td>
            <td><?= $subscriber->cdate; ?></td>
            <td><?= $subscriber->udate; ?></td>
            <td>
	            <form method="POST" action="">
	            	<button type="submit" class="btn btn-danger" value="<?= $subscriber->id; ?>" name="delete_subscriber"><?php trans_e("Delete", "nl"); ?></button>
	            </form>
            </td>
        </tr>
	    <?php endforeach; ?>
	</tbody>
</table>
</div>

<?php else : ?>
	<?php get_view(__FILE__, 'alerts', [
		'info' => trans("There is no subscribers.", "nl")
	]); ?>
<?php endif; ?>