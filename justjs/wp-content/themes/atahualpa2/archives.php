<?php get_header(); ?>
			<div id="outer-column-container">
				<div id="inner-column-container">
					<div id="source-order-container">
						<div id="middle-column">
							<div class="inside">
<h2><?php _e('Archives by Month:', 'atahualpa'); ?></h2>
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>
<h2><?php _e('Archives by Subject:', 'atahualpa'); ?></h2>
	<ul>
		 <?php wp_list_categories(); ?>
	</ul>
							</div>
						</div>
						<div class="clear-columns"><!-- do not delete --></div>
					</div>
					<div id="right-column">
						<div class="inside">
<?php get_sidebar(); ?>
						</div>
					</div>
					<div class="clear-columns"><!-- do not delete --></div>
				</div>
			</div>
<?php get_footer(); ?>