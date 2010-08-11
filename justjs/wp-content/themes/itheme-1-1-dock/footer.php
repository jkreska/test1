    <hr class="hidden" />

  </div><!--/wrapper -->

<!--dock -->
<div class="dock" id="dock">
  <div class="dock-container">
  <a class="dock-item" href="<?php echo get_settings('home'); ?>"><span>Home</span><img src="<?php bloginfo('stylesheet_directory'); ?>/dock/images/home.png" alt="Home" /></a> 
  <a class="dock-item" href="<?php bloginfo('rss2_url'); ?>"><span>Entries RSS</span><img src="<?php bloginfo('stylesheet_directory'); ?>/dock/images/rss1.png" alt="Entry RSS" /></a>
  <a class="dock-item" href="<?php bloginfo('comments_rss2_url'); ?>"><span>Comments RSS</span><img src="<?php bloginfo('stylesheet_directory'); ?>/dock/images/rss2.png" alt="Comments RSS" /></a>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#dock').Fisheye(
				{
					maxWidth: 60,
					items: 'a',
					itemsText: 'span',
					container: '.dock-container',
					itemWidth: 40,
					proximity: 80,
					alignment : 'left',
					valign: 'bottom',
					halign : 'center'
				}
			)
		}
	);
</script>

</div><!--/page -->

<?php wp_footer(); ?>
</body>
</html>