<?php  
$class = "col-md-3";
switch ($cols) {
	case 1:
		$class = "col-md-12";
		break;
	case 2:
		$class = "col-md-6";
		break;
	case 3:
		$class = "col-md-4";
		break;
	case 4:
		$class = "col-md-3";
		break;
	default:
		# code...
		break;
}
?>

<section id="services">
	<div class="container">
	    <div class="row">
	    <?php foreach ($blockhtml as $key => $bloc): ?>
	    	<div class="<?= $class; ?> col-xs-12 mb-sm-30">
	    		<?= $bloc->icon; ?>
	    		<h3><?= $bloc->title; ?></h3>
	    		<p><?= $bloc->text; ?></p>
	    	</div>
	    <?php endforeach ?>
	    </div>
	</div>
</section><!-- /#services -->