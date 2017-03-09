<style type="text/css">
	.btn-trash{
		background: transparent;
	    border: 0;
	    color: red;
	}
	.btn-edit{
		background: transparent;
	    border: 0;
	    color: blue;
	}
	.btn-move{
		background: transparent;
	    border: 0;
	    color: #000;
	}
	.form-action-btn{
		display: inline-block;
	}
</style>

 

<div class="panel panel-default">
	<div class="panel-body">
		<form class="" action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<div class="input-group">
					<label for="cols">Numéro de colonne</label>
					<select class="form-control" id="cols" name="cols">
						<option value=""><?php trans_e("Choose", "blockhtml"); ?></option>
						<option value="1" <?= ($cols == 1) ? "selected" : ""; ?>>1</option>
						<option value="2" <?= ($cols == 2) ? "selected" : ""; ?>>2</option>
						<option value="3" <?= ($cols == 3) ? "selected" : ""; ?>>3</option>
						<option value="4" <?= ($cols == 4) ? "selected" : ""; ?>>4</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-primary" value="<?php trans_e("Enregistrer", "blockhtml"); ?>">
			</div>
		</form>
		<hr>
		<form class="" action="" method="post" enctype="multipart/form-data">
			<h3>Ajouter un nouveux bloc</h3>
			<div class="form-group">
				<div class="input-group">
					<label for="icon" class="control-label">icon de <a href="http://fontawesome.io/icons/" target="_blanc">fontawesome</a></label>
					<input type="text" name="icon" class="form-control" placeholder="Entrer code html ...">
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
					<label for="title" class="control-label">Title</label>
					<input type="text" name="title" class="form-control" placeholder="Entrer le title ...">
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
					<label for="text" class="control-label">Text</label>
					<textarea class="form-control" cols="50" rows="5" name="text"></textarea>				
				</div>
			</div>
			<div class="form-group">
				<input type="hidden" name="action" value="add">
				<input type="submit" name="submit" class="btn btn-primary" value="<?php trans_e("Ajouter", "blockhtml"); ?>">
			</div>
		</form>	
		<table class="table table-striped" id="sortable">
		  	<tr>
		  		<th>Icon</th>
		  		<th>Title</th>
		  		<th>Text</th>
		  		<th>Action</th>
		  	</tr>
		  	<?php foreach ($blockhtml as $key => $value): ?>
		  		<tr>
		  			<td class="blockhtml-icon"><?= $value->icon; ?></td>
		  			<td class="blockhtml-title"><?= $value->title; ?></td>
		  			<td class="blockhtml-text"><?= $value->text; ?></td>
		  			<td class="blockhtml-action">
		  				<!-- <button class="btn-move"><i class="fa fa-arrows"></i></button> -->
		  				<button class="btn-edit"><i class="fa fa-edit"></i></button>	
		  				<form action="" method="post" class="form-action-btn">
		  					<input type="hidden" name="blockhtml_id" class="blockhtml-id" value="<?= $value->id; ?>" />
		  					<input type="hidden" name="submit" value="delete" />
		  					<button class="btn-trash"><i class="fa fa-trash"></i></button>	
		  				</form>
		  			</td>
		  		</tr>
		  	<?php endforeach ?>
		</table>
	</div>
</div>
 


<!-- Modal -->
<div class="modal fade" id="editbloc-modal" tabindex="-1" role="dialog" aria-labelledby="editbloc-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modifier</h4>
      </div>
      <div class="modal-body">
        <form action="" method="post" class=""> 
         	<div class="form-group">
				<div class="input-group">
					<label for="icon" class="control-label">icon de <a href="http://fontawesome.io/icons/" target="_blanc">fontawesome</a></label>
					<input type="text" name="icon" class="form-control" placeholder="Entrer code html ...">
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
					<label for="title" class="control-label">Title</label>
					<input type="text" name="title" class="form-control" placeholder="Entrer le title ...">
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
					<label for="text" class="control-label">Text</label>
					<textarea class="form-control" cols="50" rows="5" name="text"></textarea>				
				</div>
			</div>
			<div class="form-group">
				<input type="hidden" name="id">
				<input type="hidden" name="action" value="edit">
				<input type="submit" name="submit" class="btn btn-primary" value="<?php trans_e("Enregistrer", "blockhtml"); ?>">
			</div>
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
	$('.btn-edit').click(function(){
		var line 	= $(this).closest('tr');
		var icon 	= line.find('.blockhtml-icon');
		var title 	= line.find('.blockhtml-title');
		var text 	= line.find('.blockhtml-text');
		var id 		= line.find('.blockhtml-id');

		$('#editbloc-modal').find('input[name=icon]').val(icon.html());
		$('#editbloc-modal').find('input[name=title]').val(title.html());
		$('#editbloc-modal').find('textarea[name=text]').val(text.html());
		$('#editbloc-modal').find('input[name=id]').val(id.val());
		$('#editbloc-modal').modal("show");
	});

	$( function() {
	   //$( "#sortable" ).sortable();
 
	} );

	$('.fa-trash').click(function(){
		return confirm('Confirmé');
	});
</script>