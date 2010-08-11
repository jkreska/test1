<?php
global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>
<?php get_header(); ?>
			<div id="outer-column-container">
				<div id="inner-column-container">
					<div id="source-order-container">
						<div id="middle-column">
							<div class="inside">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>

			<?php if (is_last_post()) {?>
				<div class="post-last" id="post-<?php the_ID(); ?>">
			<?php } else { ?>
				<div class="post" id="post-<?php the_ID(); ?>">
			<?php } ?>

				<h2>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__ ('Permanent Link to %s', 'atahualpa'), get_the_title())?>"><?php the_title(); ?></a>
				</h2>
				<div style="clear: left;"></div>
				<div class="entry">
					<?php if ($ata_excerpts_home == "Full Posts") { 
					the_content(__('More &raquo;', 'atahualpa')); } else {
					the_excerpt(); } ?>
				<p class="postmetadata">
					<?php the_time('F jS, Y') ?> <?php if ( function_exists('the_tags') && get_the_tags()) {the_tags('| Tags: ', ', ', ' ');} ?>| Category: <?php the_category(', ') ?> <span class="remove-for-print"><?php if(function_exists('wp_print')) { echo " | "; print_link(); } ?> <?php if(function_exists('wp_email')) { echo " | "; email_link(); } ?><?php edit_post_link('Edit', ' | ', ''); ?> | <?php comments_popup_link('Leave a comment', 'Comments (1)', 'Comments (%)'); ?></span>
				</p>		
				</div>
			</div>
		<?php endwhile; ?>

	<?php if(function_exists('wp_pagenavi')) { ?>
		<div class="wp-pagenavi-navigation">
			<?php wp_pagenavi(); ?> 
		</div>
	<?php } else { ?>
		<div class="navigation">
			<div class="older"><?php next_posts_link(__('&laquo; Older Entries', 'atahualpa')); ?></div>
			<div class="newer"><?php previous_posts_link(__('Newer Entries &raquo;', 'atahualpa')); ?></div>
			<div style="clear:both"></div>
		</div>
	<?php } ?>
	
	<?php else : ?>
		<h2 class="center"><?php _e('Not Found', 'atahualpa'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that is not here.', 'atahualpa'); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	<?php endif; ?>
							</div>
						</div>
						<div id="left-column">
							<div class="inside">
<?php get_sidebar(); ?>
							</div>
						</div>
						<div class="clear-columns"><!-- do not delete --></div>
					</div>
					<div id="right-column">
						<div class="inside">
<?php include ('sidebar2.php'); ?>
						</div>
					</div>
					<div class="clear-columns"><!-- do not delete --></div>
				</div>
			</div>
<?php get_footer(); ?>