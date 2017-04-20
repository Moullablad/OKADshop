<?php if (isset($menu_items) && !empty($menu_items)): ?>
	<?php foreach ($menu_items as $key => $item): ?>
		<li class=""><a href="<?= $item->uri; ?>"><?= $item->title ?></a>
		</li>
	<?php endforeach ?>
<?php endif ?>

<!-- 
    <ul class="sub-menu">
        <li class="menu-item-has-children"><a href="index.html">Home Version 01</a>
            <ul class="sub-menu">
            	<li><a href="index2.html">Home Version 02</a></li>
            	<li class="menu-item-has-children"><a href="index2.html">Home Version 02</a>
            		<ul class="sub-menu">
	                	<li><a href="index2.html">Home Version 02</a></li>
	                	<li><a href="index2.html">Home Version 02</a></li>
	                </ul>
            	</li>
            </ul>
        </li>
        <li><a href="index2.html">Home Version 02</a></li>
    </ul>
 -->