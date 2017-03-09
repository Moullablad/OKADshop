<ul class="nav navbar-nav" id="main_menu">
	<?php foreach ($menu as $key => $value): ?>
		<?php if (isset($value->child) && $value->child != null && !is_empty($value->child)): ?>
			<li class="menu-item-has-children">
				<a href="<?= $value->link ?>">
					<?= $value->title ?>
					<span class="show-sub-menu-icon"><i class="fa fa-plus"></i></span>
				</a>
				<ul class="sub-menu">
					<?php foreach ($value->child as $key => $sub_menu): ?>
						<li><a href="<?= $sub_menu->link ?>"><?= $sub_menu->title ?></a></li>
					<?php endforeach ?>
				</ul>
			</li>
		<?php else: ?>
			<li><a href="<?= $value->link ?>"><?= $value->title ?></a></li>
		<?php endif ?>
	<?php endforeach ?>			
</ul>