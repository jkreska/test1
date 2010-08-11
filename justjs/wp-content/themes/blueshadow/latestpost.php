<?php /* Template Name: Latest Post 
*/ ?>

<?php rewind_posts();Ê?>

<?php $my_query = new WP_Query('showposts=1');
  $wp_query->in_the_loop = true; while ($my_query->have_posts()) : $my_query->the_post();
  $do_not_duplicate = $post->ID;?>

	<div class="post" id="post-<?php the_ID(); ?>">
		<div class="postsolo"><h2>NEW: <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div class="date">
			<span><img src="<?php bloginfo('template_url'); ?>/images/author.png" alt="author" /> Posted by: <?php  the_author(); ?> on <img src="<?php bloginfo('template_url'); ?>/images/date.png" alt="date" /> <?php the_time('M') ?> <?php the_time('jS') ?>, <?php the_time('Y') ?> | <img src="<?php bloginfo('template_url'); ?>/images/filed.png" alt="filed" /> Filed under: <?php the_category(', ') ?></span>
		</div></div>
		
		<div class="cover">
			<div class="entry">
				<?php the_content('Read more &raquo;'); ?>
			</div>
	<div class="ads"><?php include (TEMPLATEPATH . '/banner-latest.php'); ?></div>
		</div>

		<div class="postmetadata">
			<div class="post_comments"><img src="<?php bloginfo('template_url'); ?>/images/comment.png" alt="comment" /><?php comments_popup_link('Be the first!', 'Comments (1)', 'Comments (%)'); ?>
			</div>
			<?php include (TEMPLATEPATH . '/tagging.php'); ?>
		</div>

	</div>

<?php endwhile; ?>
