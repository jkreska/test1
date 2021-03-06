<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
<?php if (have_posts()) : the_post(); ?>
<div class="post" id="post-<?php the_ID(); ?>">
	<h2 class="title"><?php the_title(); ?></h2>
	<div class="meta">
		<div class="info"><?php _e('Update: ', 'blocks2'); ?><?php the_modified_time(__('M jS, Y', 'blocks2')); ?></div>
		<div class="comments"><?php edit_post_link(__('Edit', 'blocks2'), '', ''); ?></div>
		<div class="fixed"></div>
	</div>

	<div id="archives" class="content">
		<?php
			if (function_exists('wp_easyarchives')) {
				wp_easyarchives();
			} else {
				echo '<ul>';
				wp_get_archives('type=monthly&show_post_count=1');
				echo '</ul>';
			}
		?>
	</div>
</div>
<?php else : ?>	<div class="errorbox">		<?php _e('Sorry, no posts matched your criteria.', 'blocks2'); ?>	</div><?php endif; ?>

<?php
	if (function_exists('wp_list_comments')) {
		comments_template('', true);
	} else {
		comments_template();
	}
?>

<?php get_footer(); ?>
