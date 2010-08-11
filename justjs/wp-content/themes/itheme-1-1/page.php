<?php get_header(); ?>
  <div id="content">
    
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  
    <div class="post" id="post-<?php the_ID(); ?>">
        <h2><?php the_title(); ?></h2>
		
		<div class="entry">
		<?php the_content('<p>Continue reading &raquo;</p>'); ?>
		<?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
		<?php edit_post_link('Edit', '<p>', '</p>'); ?>
		</div><!--/entry -->
	
	</div><!--/post -->
	
		<?php endwhile; endif; ?>

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