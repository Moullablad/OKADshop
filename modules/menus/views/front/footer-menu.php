<div class="col-sm-4 col-md-3">
    <div class="widget widget_nav_menu">
        <h3 class="widget-title"><?= $menu->name; ?></h3>
        <ul>
	   		<?php foreach ($menu_list as $key => $value): ?>
	   			<?php if (isset( $value->content) && $value->content != null): ?>
	   				<li>
	   					<?= $value->content ?>
	   				</li>
	   			<?php else: ?>
	   				<li><a href="<?= $value->link ?>"><?= $value->title ?></a></li>
	   			<?php endif ?>
	   		<?php endforeach ?>	
	    </ul>
	</div>
 </div>