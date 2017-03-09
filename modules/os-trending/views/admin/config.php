 

<div class="panel panel-default">
	<div class="panel-heading">
		<h3><i class="fa fa-lastfm"></i> <?php trans_e("Trending Settings", "trending"); ?></h3>
	</div>
	<div class="panel-body">
		<form class="" action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<div class="input-group">
					<label for="categories"><?php trans_e("Ajouter categorie sur Trending", "trending"); ?></label>
		 			<select class="form-control" id="categories" name="category">
						<option value=""><?php trans_e("Choose a category", "trending"); ?></option>
						<?php foreach ($category_list as $key => $category): ?>
							<option value="<?= $category->id; ?>"><?= $category->name; ?></option>>
						<?php endforeach ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-primary" value="<?php trans_e("Ajouter", "trending"); ?>">
			</div>
			<div class="form-group">

			</div>
		</form>	
		<table class="table table-striped">
		  	<tr>
		  		<th>#</th>
		  		<th><?php trans_e("Category name", "trending"); ?></th>
		  		<th><?php trans_e("Action", "trending"); ?></th>
		  	</tr>
		  	<?php if (isset($category_trending) && !is_empty($category_trending)): ?>
		  		<?php foreach ($category_trending as $key => $cat): ?>
			  	<tr>
			  		<td><?= $cat->id; ?></td>
			  		<td id="<?= $cat->id; ?>"><?= $cat->name; ?></td>
			  		<td>
			  			
			  			<form class="" action="" method="post" >
			  				<input type="hidden" name="cat_id" value="<?= $cat->id; ?>">
			  				<input type="hidden" name="action" value="delete">
			  				<button class="btn btn-primary"><i class="fa fa-trash"></i> <?php trans_e("Supprimer", "trending"); ?></button>
			  			</form>
			  		
			  		</td>
			  	</tr>
			  	<?php endforeach ?>
		  	<?php endif ?>
		</table>
	</div>
</div>