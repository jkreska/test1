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
<?php if (function_exists('is_tag')) {is_tag();} ?>
		<?php if (have_posts()) : ?>
 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2><?php _e('Archive for', 'atahualpa'); ?> <?php single_cat_title(); ?></h2>
 	  <?php /* If this is a tag archive */ } elseif( function_exists('is_tag') && is_tag() ) { ?>
		<h2><?php _e('Posts tagged', 'atahualpa'); ?> <?php single_tag_title(); ?></h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2><?php _e('Archive for', 'atahualpa'); ?> <?php the_time(__('F jS, Y', 'atahualpa')); ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2><?php _e('Archive for', 'atahualpa'); ?> <?php the_time(__('F, Y', 'atahualpa')); ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2><?php _e('Archive for', 'atahualpa'); ?> <?php the_time(__('Y', 'atahualpa')); ?></h2>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2><?php _e('Author Archive', 'atahualpa'); ?></h2>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2><?php _e('Blog Archives', 'atahualpa'); ?></h2>
 	  <?php } ?>

<div style="clear: both"></div><div class="line1pix"></div>
		<?php while (have_posts()) : the_post(); ?>
			<?php if (is_last_post()) {?><div class="post-last"><?php } else { ?><div class="post"><?php } ?>
				<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'atahualpa'); ?> <?php if (function_exists('the_title_attribute')) {the_title_attribute();} elseif (function_exists('the_title')) {the_title();} ?>"><?php the_title(); ?></a></h2>
				<div style="clear: left;"></div><div class="entry">
					<?php if (is_category()) { if ($ata_excerpts_category == "Full Posts") { 
					the_content(__('More &raquo;', 'atahualpa')); } else {
					the_excerpt(); }} 
					elseif (is_day() OR is_month() OR is_year()) { if ($ata_excerpts_archive == "Full Posts") { 
					the_content(__('More &raquo;', 'atahualpa')); } else {
					the_excerpt(); }}
					elseif (function_exists('is_tag') && is_tag() ) { if ($ata_excerpts_tag == "Full Posts") { 
					the_content(__('More &raquo;', 'atahualpa')); } else {
					the_excerpt(); }}
					elseif (is_search()) { if ($ata_excerpts_search == "Full Posts") { 
					the_content(__('More &raquo;', 'atahualpa')); } else {
					the_excerpt(); }}
					else { the_excerpt(); } ?>
				<p class="postmetadata">
				<?php the_time(__('F jS, Y', 'atahualpa')); ?><?php _e(' | ', 'atahualpa'); ?>
				<?php if ( function_exists('the_tags') && get_the_tags()) {the_tags(__('Tags: ', 'atahualpa'), __(', ', 'atahualpa'), __(' | ', 'atahualpa'));} ?>
				<?php _e('Category:', 'atahualpa'); ?> <?php the_category(__(', ', 'atahualpa')) ?><?php _e(' | ', 'atahualpa'); ?>
				<?php comments_popup_link(__('Leave a comment', 'atahualpa'),
                          	__('Comments (1)', 'atahualpa'), __ngettext('Comment (%)', 'Comments (%)', get_comments_number(), 'atahualpa')); ?>				
				<?php edit_post_link(__('Edit', 'atahualpa'), __(' | ', 'atahualpa'), ''); ?>
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