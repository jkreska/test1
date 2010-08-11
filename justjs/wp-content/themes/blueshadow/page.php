<?php get_header(); ?>

<?php get_sidebar(); ?>
<div id="content"><a name="content"></a>

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>
<div class="post" id="post-<?php the_ID(); ?>">
	<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
	
	<div class="date">
		<span><img src="<?php bloginfo('template_url'); ?>/images/date.png" alt="date" /> Date: <?php the_time('M') ?> <?php the_time('jS') ?>, <?php the_time('Y') ?></span>
	</div>
	
	<div class="cover">
		<div class="entry">
			<?php the_content('Read more &raquo;'); ?>
		</div>

	</div>
	
<div class="postmetadata">
<div class="p_comments"><?php comments_popup_link('Be the first!', '1 Comment', '% Comments'); ?></div>
</div>

</div>
		<?php endwhile; endif; ?>
						
</div>

<?php get_footer(); ?>