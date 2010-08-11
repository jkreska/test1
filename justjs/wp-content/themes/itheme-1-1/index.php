<?php get_header(); ?>

      <div id="content">

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

        <div class="post" id="post-<?php the_ID(); ?>">
		  <div class="date"><span><?php the_time('M') ?></span> <?php the_time('d') ?></div>
		  <div class="title">
          <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
          <div class="postdata"><span class="category"><?php the_category(', ') ?></span> <span class="comments"><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></span></div>
		  </div>
          <div class="entry">
            <?php the_content('Continue reading &raquo;'); ?>
          </div><!--/entry -->
        </div><!--/post -->

		<?php endwhile; ?>
		
        <div class="page-nav"> <span class="previous-entries"><?php next_posts_link('Previous Entries') ?></span> <span class="next-entries"><?php previous_posts_link('Next Entries') ?></span></div><!-- /page nav -->

	<?php else : ?>

		<h2>Not Found</h2>
		<p>Sorry, but you are looking for something that isn't here.</p>

	<?php endif; ?>

      </div><!--/content -->
  <div id="footer">
<a href="http://www.linkedin.com/in/jeffkreska" ><img src="http://www.linkedin.com/img/webpromo/btn_liprofile_blue_80x15.gif" width="80" height="15" border="0" alt="View Jeff Kreska's profile on LinkedIn"></a>

<a title='PageRank for this page'
   href='http://livepr.raketforskning.com/?u=referer'>
    <img src='http://livepr.raketforskning.com/mylivepr.gif' 
         alt='PageRank for this page'
         width='40' 
         height='19' />
</a>

<a target="_blank" href="http://www.ndesign-studio.com/resources/wp-themes/">WP Theme</a> &amp; 
<a target="_blank" href="http://www.ndesign-studio.com/stock-icons/">Icons</a> by 
<a target="_blank" href="http://www.ndesign-studio.com">N.Design Studio</a>
</div>
    </div><!--/left-col -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>