<div id="sidebar">
	
	<div><a href="<?php bloginfo('rss_url'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/rss-subscribe.png" alt="Subscribe to RSS" /></a></div>
	<div class="sidebar_top"></div>
	<div class="sidebar_content">
		<ul>
			<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar') ) : else : ?>
				<?php wp_list_categories('orderby=name&show_count=0&title_li=<h2>Categories</h2>'); ?>
				<li>
					<h2>Archives</h2>
					<ul>
						<?php wp_get_archives('type=monthly&limit=12'); ?>
					</ul>
				</li>	
				<li>
					<h2>Pages</h2>
					<ul>
					<?php wp_list_pages('title_li='); ?>
					</ul>
				</li>
				<li>
					<h2>Blogroll</h2>
					<ul>
						<?php get_links(-1, '<li>', '</li>', 'between', FALSE, 'name', FALSE, FALSE, -1, FALSE); ?>
					</ul>
				</li>
				<li>
				    <h2>Tags</h2>
				    <ul>
				         <?php wp_tag_cloud(); ?>
                    </ul>
                 </li>
	<?php endif; ?>
		</ul>
	</div> <!-- sidebar_content -->
	<div class="sidebar_bottom"></div>
</div> <!-- sidebar -->