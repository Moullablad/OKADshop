 
<!-- Slider -->
<div class="carousel slide" data-ride="carousel" id="home_slider">
    <!-- Indicators -->
    <ol class="carousel-indicators">
    	<?php  
			$cmp = count($images);

			for ($i=0; $i < $cmp ; $i++) { 
				?>
					<li class="<?= ($i == 0) ? 'active' : ''; ?>" data-slide-to="<?= $i; ?>" data-target="#home_slider"></li>
				<?php
			}
    	?>		
    </ol><!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
    	<?php  
			$i=0;
			foreach ($images as $key => $image) {
				$active = "";
				if($i == 0){
					$i++;
					$active = "active";
				}
				?>
				<div class="item  <?= $active; ?>">
		            <img alt="" src="<?= site_url() .'modules/superslider/images/' .$image['file_name']?>">
		        </div>
				<?php 
			}
    	?>
    </div><!-- Left and right controls -->
    <a class="left carousel-control" data-slide="prev" href="#home_slider" role="button"><span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span> <span class="sr-only">Previous</span></a> <a class="right carousel-control" data-slide="next" href="#home_slider" role="button"><span aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span> <span class="sr-only">Next</span></a>
</div><!-- ./Slider -->

