<style type="text/css">
	#advanced_search .title{
		color: #202020;
	    font-size: 18px;
	    font-weight: 700;
	    padding-bottom: 20px;
	}
	#advanced_search .advenced-search-bloc{
		padding-left: 20px;
	}
 	#advanced_search .bloc-title{
		font-size: 14px;
    	color: #1f1f1f;
		font-weight: bold;
    	text-transform: uppercase;
		margin: 10px 0;
 	}
 	.color-list li{
 		border: 1px solid #ddd;
	    display: inline-block;
	    height: 20px;
	    margin: 5px 5px 5px 0;
	    padding: 0;
	    width: 20px;
	    overflow: hidden;
	    text-indent: 100%;
	    white-space: nowrap;
	    box-sizing: content-box;
 	}
 	.color-list li a{
 		height: 100%;
 		width: 100%;
 		display: block;
 	}

 	.color-list li.checked a {
    	position:relative;
	}    
	
	.color-list li.checked a:before {
	    content: "\f00c";
	    font-family: 'FontAwesome';
	    left: -14px;
	    position: absolute;
	    top: 3px;
	    color: #dad4d4;
	    font-size: 10px;
	 }
	.filter-bar {
		font-size: 12px;
	    font-weight: 300;
	    padding: 9px 20px;
	    border: 1px solid #ddd;
	    margin: 0px;
	    color: #666;
	    background: #fff;
	    margin-bottom: 15px;
	    width: 100%;
		float: inherit;
	 }

 	input[name="filter_price"]{
		width: 10%;
    	height: 1.5em;
 	}
 	.sort-by label{
 		line-height: 2.5em;
 	}

 	.advenced-search-bloc input[type="checkbox"]{
 		width: 10%;
 		height: 1.5em;
 	}
 	.advenced-search-bloc.iscolor li {
 		display: inline-block;
 	}
 	.advenced-search-bloc.iscolor input[type="checkbox"] {
 		width: inherit;
 	}
 	/* Cachons la case à cocher */
	.advenced-search-bloc.iscolor [type="checkbox"]:not(:checked),
	.advenced-search-bloc.iscolor [type="checkbox"]:checked {
	  position: absolute;
	  left: -9999px;
	}
	 
	/* on prépare le label */
	.advenced-search-bloc.iscolor [type="checkbox"]:not(:checked) + label,
	.advenced-search-bloc.iscolor [type="checkbox"]:checked + label {
	  position: relative; /* permet de positionner les pseudo-éléments */
	  //padding-left: 25px; /* fait un peu d'espace pour notre case à venir */
	  cursor: pointer;    /* affiche un curseur adapté */
	  width: 20px;
	  height: 18px;
	  padding:0;
	  margin:0;
	}
	/* Aspect des checkboxes */
	/* :before sert à créer la case à cocher */
	.advenced-search-bloc.iscolor [type="checkbox"]:not(:checked) + label:before,
	.advenced-search-bloc.iscolor [type="checkbox"]:checked + label:before {
	  /*content: '';*/
	  position: absolute;
	  left:0; 
	  top: 2px;
	  width: 18px; 
	  height: 18px; // dim. de la case 
	  border: 1px solid #aaa;
	  background: #000;
	  border-radius: 3px; // angles arrondis 
	  box-shadow: inset 0 1px 3px rgba(0,0,0,.3) // légère ombre interne 
	  
	}
	 
	/* Aspect général de la coche */
	.advenced-search-bloc.iscolor [type="checkbox"]:not(:checked) + label:after,
	.advenced-search-bloc.iscolor [type="checkbox"]:checked + label:after {
	  content: '✔';
	    position: absolute;
	    top: 2px;
	    left: 4px;
	    font-size: 14px;
	    color: #fff;
	    transition: all .2s;
	}
	/* Aspect si "pas cochée" */
	.advenced-search-bloc.iscolor [type="checkbox"]:not(:checked) + label:after {
	  opacity: 0; /* coche invisible */
	  transform: scale(0); /* mise à l'échelle à 0 */
	}
	/* Aspect si "cochée" */
	.advenced-search-bloc.iscolor [type="checkbox"]:checked + label:after {
	  opacity: 1; /* coche opaque */
	  transform: scale(1); /* mise à l'échelle 1:1 */
	}

</style>

<form action="" method="post" class="hidden" id="form_filter">
	<input type="text" name="search_query" value="<?= isset($_POST['search_query']) ?  $_POST['search_query']: '' ; ?>">
	<input type="text" name="min_price" value="<?= isset($_POST['min_price'])  ? $_POST['min_price'] : '' ; ?>">
	<input type="text" name="max_price" value="<?= isset($_POST['max_price']) ? $_POST['max_price']  : '' ; ?>">
	<input type="text" name="filter_price_radio" value="<?= isset($_POST['filter_price_radio']) ? $_POST['filter_price_radio'] : '' ; ?>">
	<input type="text" name="sortby_option" value="<?= isset($_POST['sortby_option']) ? $_POST['sortby_option']  : '' ; ?>">
	<input type="text" name="data_attribute_value" value="<?= isset($_POST['data_attribute_value']) ? htmlentities($_POST['data_attribute_value']) : '' ; ?>">
</form>
 
<div class="container"  id="main">
	<div class="row">
		<div class="hidden-xs col-sm-4 col-md-3">
			<div id="advanced_search">
				<h2 class="title"><span><?= trans('FILTER','advanced_search') ?></span></h2>
				<?php if (!is_empty($filter_price)): ?>
					<div class="advenced-search-bloc">
						<div class="bloc-title"><?= trans('PRICE','advanced_search') ?></div>
						<ul class="price-list">
						<?php foreach ($filter_price as $key => $value): ?>
							<li>
								<input type="radio" name="filter_price" class="filter-refrech radio-<?= $key; ?>" data-max="<?= $value['max']; ?>" 
								data-min="<?= $value['min']; ?>" value="radio-<?= $key; ?>">
								<?php if ($value['max'] == null): ?>
									<?= with_currency($value['min']); ?>
								<?php else: ?>
									<?= with_currency($value['min']); ?> - <?= with_currency($value['max']); ?>
								<?php endif ?>
							</li>
						<?php endforeach ?>
						</ul>
					</div>
				<?php endif ?>
				
				<?php if (isset($filtre_block) && !is_empty($filtre_block)): ?>
					<?php foreach ($filtre_block as $key => $search_bloc): ?>
						<div class="advenced-search-bloc <?= ($search_bloc->color == 1) ? 'iscolor' : ''; ?>">
							<div class="bloc-title"><?= $search_bloc->name; ?></div>
							<ul>
								<?php foreach ($search_bloc->attribute_value as $key => $value): ?>
									<li style="background-color: <?=  $value->color; ?>;">
										<input type="checkbox" name="" class="attribute_value" 
										data-attrtibute="<?= $search_bloc->id; ?>" data-value="<?= $value->id; ?>" id="checkbox-<?= $search_bloc->id.$value->id; ?>" > 
										<label for="checkbox-<?= $search_bloc->id.$value->id; ?>">
											<?= ($search_bloc->color == 0 ) ? $value->name : ''; ?>
										</label>
									</li>
								<?php endforeach ?>
							</ul>
						</div>
					<?php endforeach ?>
				<?php endif ?>

			</div>
		</div>
		<div class="col-sm-8 col-md-9"  id="body">
			<div class="filter-bar">
				<div class="sort-by pull-right">
					<div class="row">
						<div class="col-sm-4">
							<label for="SortBy"><?= trans('Sort by','advanced_search') ?></label>
						</div>
						<div class="col-sm-8">
							<select class="form-control filter-order" name="sortby" id="sortby">
								<option></option>
						        <option value="price-ascending"><?= trans('Price, low to high','advanced_search') ?></option>
						        <option value="price-descending"><?= trans('Price, high to low','advanced_search') ?></option>
						        <option value="created-descending"><?= trans('Date, new to old','advanced_search') ?></option>
						        <option value="created-ascending"><?= trans('Date, old to new','advanced_search') ?></option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="products grid-view">
            <?php 
	            $i = 1;
	            $lastItem = count($products); 
	            foreach ($products as $key => $product) : 

            	if( $i == 1) : ?><div class="row"><?php endif; ?>

                    <?php 
                    get_template_view('product-item', [
						'product' => $product,
						'class' => 'col-xs-12 col-sm-6 col-md-4 animated fadeInUp'
					]);
					?>

                <?php if( $i == $lastItem) : ?>
                    </div><!-- /.row -->
                <?php elseif( $i%3 == 0 ) : ?>
                    </div><!-- /.row --><div class="row">
                <?php endif; ?>

                <?php $i++; ?>
            <?php endforeach; ?>
            </div><!-- /.products -->
		</div>
	</div>
</div>
 


