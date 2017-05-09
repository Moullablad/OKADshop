<div class="dropdown" id="blocklanguages">
	<a data-toggle="dropdown" href="#" aria-expanded="true"><img src="<?php echo site_url() . 'assets/img/flags/'. $current->iso_code .'.png'; ?>"><?php echo $current->name;?></a>
    <ul class="dropdown-menu">
    	<?php if( !is_empty($languages) ) : ?>
    		<?php foreach ($languages as $key => $lang) : ?>
	    		<?php if( $current->id==$lang->id ) : ?>
			        <li><a class="current" href="<?php echo get_language_uri($lang->iso_code); ?>"><?php echo $lang->name;?></a></li>
			    <?php else : ?>
			    	<li>
				    	<a href="<?php echo get_language_uri($lang->iso_code); ?>"><?php echo $lang->name;?>
				    		<img src="<?php echo site_url() . 'assets/img/flags/'. $lang->iso_code .'.png'; ?>">
				    	</a>
			    	</li>
			    <?php endif; ?>
		    <?php endforeach; ?>
	    <?php endif; ?>
    </ul>
</div>