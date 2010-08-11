<?php get_header(); ?>

<?php get_sidebar(); ?>

<div id="content">

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

	<div class="post" id="post-<?php the_ID(); ?>">
		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div class="date">
			<span><img src="<?php bloginfo('template_url'); ?>/images/author.png" alt="author" /> Posted by: <?php  the_author(); ?> on <img src="<?php bloginfo('template_url'); ?>/images/date.png" alt="date" /> <?php the_time('M') ?> <?php the_time('jS') ?>, <?php the_time('Y') ?> | <img src="<?php bloginfo('template_url'); ?>/images/filed.png" alt="filed" /> Filed under: <?php the_category(', ') ?></span>
		</div>
		
		<div class="cover">
			<div class="entry">
				<?php the_content('Read more &raquo;'); ?>
			</div>
	<div class="ads"><?php include (TEMPLATEPATH . '/banner-single.php'); ?></div>
		</div>

		<div class="postmetadata">
		<?php include (TEMPLATEPATH . '/tagging.php'); ?>
		</div>

	</div> <!-- post -->
			
<?php comments_template(); ?>

<?php endwhile; else: ?>

	<h1 class="title">Not Found</h1>
	<p>Sorry, but you are looking for something that isn't here.</p>

<?php endif; ?>

</div> <!-- content -->

<?php get_footer(); ?>