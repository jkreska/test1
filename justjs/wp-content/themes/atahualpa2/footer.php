<?php
global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>			<div id="footer">
				<div class="inside">
<p>Copyright &copy; <?php if ($ata_copyright_start_year != "" && $ata_copyright_start_year != date('Y')) {echo $ata_copyright_start_year . "-";} echo date('Y'); ?> <a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a> - All Rights Reserved<br />
Powered by <a href="http://www.wordpress.org/">WordPress</a> - <a href="http://wordpress.bytesforall.com/">WP Themes</a> by <a href="http://www.bytesforall.com/">BFA Webdesign</a>

		<!-- <?php echo get_num_queries(); ?> queries. <?php timer_stop(1); ?> seconds. -->
	</p>
				</div>
			</div>
		</div>
		<?php wp_footer(); ?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-5237189-1");
pageTracker._trackPageview();
</script>

<!-- Kontera ContentLink(TM);-->
<script type='text/javascript'>
var dc_AdLinkColor = 'blue' ;
var dc_UnitID = 14 ;
var dc_PublisherID = 60577 ;
var dc_open_new_win = 'yes';
var dc_adprod = 'ADL' ;
</script>
<script type='text/javascript' src='http://kona.kontera.com/javascript/lib/KonaLibInline.js'>
</script>
<!-- Kontera ContentLink(TM) -->

	</body>
</html>