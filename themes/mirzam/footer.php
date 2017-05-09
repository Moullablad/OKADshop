	</div><!-- /#site-wrapper -->

	<?php if( is_home() ) : 
		get_section('before_footer');
	endif; ?>

    <footer id="footer">
	    <div class="widgets">
	    	<div class="container">
		    	<div class="row">
		    		<?php get_section('footer'); ?>
		    	</div>
	    	</div>
	    </div>
	    <div class="footer-bottom">
			<div class="container">
			<div class="col-sm-4">
				<p><?php trans_e("Powered by", "mirzam"); ?> <a href="http://okadshop.com" target="_blank">OKADshop</a></p>
			</div>
			<div class="col-sm-8">
				<?php get_section('footer_copyright'); ?>
			</div>
			</div>
	    </div>
    </footer>

    <?= os_footer(); ?>
  </body>
</html>
