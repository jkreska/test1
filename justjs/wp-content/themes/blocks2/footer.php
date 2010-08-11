	</div>
	<!-- main END -->

	<?php get_sidebar(); ?>

	<div class="fixed"></div>

	<!-- footer START -->
	<div id="footer">
		<div id="about">
			<?php printf(__('Powered by <a href="%1$s">WordPress</a>', 'blocks2'), 'http://wordpress.org/'); ?>
			 | <?php printf(__('Valid <a href="%1$s">XHTML 1.1</a> and <a href="%2$s">CSS 3</a>', 'blocks2'), 'http://validator.w3.org/check?uri=referer', 'http://jigsaw.w3.org/css-validator/check/referer?profile=css3'); ?>
		</div>
		<ul id="admin">
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<li id="gotop"><a href="#" onclick="MGJS.goTop();return false;"><?php _e('TOP', 'blocks2'); ?></a></li>
		</ul>
		<div class="fixed"></div>
	</div>
	<!-- footer END -->

</div>
<!-- content END -->

		</div><!-- container -->
	</div><!-- wrap -->

<?php
	$options = get_option('blocks2_options');
	if ($options['analytics']) {
		echo($options['analytics_content']);
	}

	wp_footer();
?>

</body>
</html>
