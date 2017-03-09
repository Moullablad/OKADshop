<div class="container">
	<div class="alert alert-danger" style="border-radius: 0px;margin-top: 25px;">
		<h1 style="font-size: 4em;margin-top: 0px;">404 <small style="font-size: 16px;display: inline;"><?php trans_e("Page not found.", "core"); ?></small></h1>
		<p><?php trans_e("Looks like the page you're trying to visit doesn't exist. Please check the URL and try your luck again.", "core"); ?></p><br>
		<a href="<?=site_url();?>" class="btn btn-default"><i class="fa fa-long-arrow-left"></i> <?php trans_e("Go Homepage", "core"); ?></a>
	</div>
</div>