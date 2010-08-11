<?php get_header(); ?>

<?php get_sidebar(); ?>

<div id="content"><a name="content"></a>

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle">Search Results</h2>

		<?php while (have_posts()) : the_post(); ?>

<div class="post" id="post-<?php the_ID(); ?>">
<div class="date"><span><img src="<?php bloginfo('template_url'); ?>/images/save.png" alt="save" /> <?php the_time('M-j-Y'); ?> </span></div>
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
<div class="cover">
<div class="entry">
<?php the_content('Read more &raquo;'); ?>
<img src="<?php bloginfo('template_url'); ?>/images/filed.png" alt="filed" /> Posted under <?php the_category(', '); ?> and the 
<img src="<?php bloginfo('template_url'); ?>/images/tags.png" alt="tags" /> <?php if (function_exists('the_tags')) the_tags(__('Tags: ','ml'), ', ', ''); ?>
</div>

</div>
<div class="postmetadata">
<div class="post_comments"><img src="<?php bloginfo('template_url'); ?>/images/comment.png" alt="comment" /><?php comments_popup_link('Be the first!', 'Comments (1)', 'Comments (%)'); ?>
			</div>
			<div class="tagging"></div>
</div>

</div>
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h1 class="title">Not Found</h1>
		<p>Sorry, no post matched your criteria. Maybe you can search again?</p>

	<?php endif; ?>

</div>

<?php get_footer(); ?>