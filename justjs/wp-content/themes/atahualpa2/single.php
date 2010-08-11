<?php get_header(); ?>
<?php
global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>
			<div id="outer-column-container">
				<div id="inner-column-container">
					<div id="source-order-container">
						<div id="middle-column">
							<div class="inside">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="navigation">
	<div class="older"><?php previous_post_link('&laquo; %link') ?></div>
	<div class="newer"><?php next_post_link('%link &raquo;') ?></div>
</div><div style="clear: both"></div><div class="line1pix"></div>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><?php the_title(); ?></h2>
			<div class="entry">
				<?php the_content(__('More &raquo;', 'atahualpa')); ?>
				<?php wp_link_pages(array("before" => "<p><strong>__('Pages:', 'atahualpa')</strong> ", "after" => "</p>", "next_or_number" => "number")); ?>
				<p class="postmetadata">
				<?php the_time(__('F jS, Y', 'atahualpa')); ?><?php _e(' | ', 'atahualpa'); ?>
				<?php if ( function_exists('the_tags') && get_the_tags()) {the_tags(__('Tags: ', 'atahualpa'), __(', ', 'atahualpa'), __(' | ', 'atahualpa'));} ?>
				<?php _e('Category:', 'atahualpa'); ?> <?php the_category(__(', ', 'atahualpa')) ?>
<span class="remove-for-print">
				<?php if(function_exists('wp_print')) { _e(' | ', 'atahualpa'); print_link(); } ?> 
				<?php if(function_exists('wp_email')) { _e(' | ', 'atahualpa'); email_link(); } ?>
						<?php if (function_exists(get_post_comments_feed_link) && $ata_nofollow == "Yes") {
						$url = get_post_comments_feed_link();
						_e(' | ', 'atahualpa'); echo "<a rel=\"nofollow\" href=\"$url\">"; _e('Subscribe to comments', 'atahualpa'); echo "</a>"; } else {
						_e(' | ', 'atahualpa'); comments_rss_link(__('Subscribe to comments', 'atahualpa')); } ?>
						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
						<?php _e(' | ', 'atahualpa');?> <a href="#respond"><?php _e('Leave a comment', 'atahualpa'); ?></a><?php _e(' | ', 'atahualpa'); ?><a href="<?php trackback_url(); ?>" rel="<?php if ($ata_nofollow == "Yes") { echo "nofollow, "; } ?>trackback"><?php _e('Trackback URL', 'atahualpa'); ?></a>
						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
						<?php _e(' | ', 'atahualpa');?><?php _e('Comments are currently closed', 'atahualpa'); ?><?php _e(' | ', 'atahualpa'); ?><a href="<?php trackback_url(); ?> " rel="<?php if ($ata_nofollow == "Yes") { echo "nofollow, "; } ?>trackback"><?php _e('Trackback URL', 'atahualpa'); ?></a>
						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
						<?php _e(' | ', 'atahualpa');?><?php _e('You can skip to the end and leave a response. Pinging is currently not allowed', 'atahualpa'); ?>
						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
						<?php _e(' | ', 'atahualpa');?><?php _e('Both comments and pings are currently closed', 'atahualpa'); ?>
						<?php } edit_post_link(__('Edit', 'atahualpa'), __(' | ', 'atahualpa'), ''); ?>
</span>
				</p>
			</div>
		</div>
	<?php comments_template(); ?>
	<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.', 'atahualpa'); ?></p>
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