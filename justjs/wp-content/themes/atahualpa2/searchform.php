<div style="width: 100%; margin: 0; padding: 15px 0 5px 0;">
<form method="get" class="searchform" action="<?php bloginfo('url'); ?>/">
<input name="submit" value="Search" type="image" src="<?php echo get_bloginfo('template_directory'); ?>/images/search.gif" style="float: right; border:none; vertical-align: 15%; padding: 0; margin: 0;" />
<input type="text" class="searchfield" value="<?php the_search_query(); ?>" name="s" />
</form></div>