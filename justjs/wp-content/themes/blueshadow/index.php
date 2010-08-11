<?php get_header(); ?>
<?php get_sidebar(); ?>
<div id="content">

<?php
if (is_home() && $post==$posts[0] && !is_paged()) {
   include(TEMPLATEPATH . '/latestpost.php');
} else {
   
}
?>
 


<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post();
    if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>

	<div class="post" id="post-<?php the_ID(); ?>">
		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div class="date">
			<span><img src="<?php bloginfo('template_url'); ?>/images/author.png" alt="author" /> Posted by: <?php  the_author(); ?> on <img src="<?php bloginfo('template_url'); ?>/images/date.png" alt="date" /> <?php the_time('M') ?> <?php the_time('jS') ?>, <?php the_time('Y') ?> | <img src="<?php bloginfo('template_url'); ?>/images/filed.png" alt="filed" /> Filed under: <?php the_category(', ') ?></span>
		</div>

		<div class="cover">
			<div class="entry">
			<?php the_content('Read more &raquo;'); ?>
			</div>

		</div>

		<div class="postmetadata">
			<div class="post_comments"><img src="<?php bloginfo('template_url'); ?>/images/comment.png" alt="comment" /><?php comments_popup_link('Be the first!', 'Comments (1)', 'Comments (%)'); ?>
			</div>
			<?php include (TEMPLATEPATH . '/tagging.php'); ?>
		</div>
     
	</div> <div style="clear: both;"> </div><!-- post -->
					
<?php endwhile; ?>

	<div class="navigation">
		<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
		<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
	</div>

<?php else : ?>

	<div class="post">
		<h1 class="title">Not Found</h1>
		<p>Sorry, but you are looking for something that isn't here.</p>
	</div>

<?php endif; ?>	

</div> <!-- content -->



<?php get_footer(); ?>
