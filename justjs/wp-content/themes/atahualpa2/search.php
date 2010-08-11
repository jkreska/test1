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
		<h2><?php _e('Search Results for', 'atahualpa');?> "<?php the_search_query(); ?>":</h2>
		<div class="line1pix"></div>
		<?php while (have_posts()) : the_post(); ?>
			<?php if (is_last_post()) {?><div class="post-last"><?php } else { ?><div class="post"><?php } ?>
				<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php if (function_exists('the_title_attribute')) {the_title_attribute();} elseif (function_exists('the_title')) {the_title();} ?>"><?php the_title(); ?></a></h2>
				<div style="clear: left;"></div><div class="entry">
					<?php if ($ata_excerpts_search == "Full Posts") { 
					the_content(__('More &raquo;', 'atahualpa')); } else {
					the_excerpt(); } ?>
				<p class="postmetadata">Posted on <?php the_time('F jS, Y') ?> under <?php the_category(', ') ?>. <?php if ( function_exists('the_tags') ) {the_tags('Tags: ', ', ', '. ');} ?><?php edit_post_link('Edit', '', '. '); ?><?php comments_popup_link('Comments: None', 'Comments: 1', 'Comments: %'); ?></p>
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
		<h2 class="center">No posts found. Try a different search?</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
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