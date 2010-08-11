<?php
/*
+----------------------------------------------------------------+
|																							|
|	WordPress 2.5 Plugin: WP-Print 2.31										|
|	Copyright (c) 2008 Lester "GaMerZ" Chan									|
|																							|
|	File Written By:																	|
|	- Lester "GaMerZ" Chan															|
|	- http://lesterchan.net															|
|																							|
|	File Information:																	|
|	- Printer Friendly Post/Page Template										|
|	- wp-content/plugins/wp-print/print-posts.php							|
|																							|
+----------------------------------------------------------------+
*/
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="Robots" content="noindex, nofollow" />
	<style type="text/css" media="screen, print">
		BODY {
			direction: <?php echo $text_direction; ?>;
			text-align: <?php echo $text_align; ?>;
		}
		#Outline {
			direction: <?php echo $text_direction; ?>;
			text-align: <?php echo $text_align; ?>;
		}
	</style>
	<?php if(@file_exists(TEMPLATEPATH.'/print-css.css')): ?>
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/print-css.css" type="text/css" media="screen, print" />
	<?php else: ?>
		<link rel="stylesheet" href="<?php echo WP_PLUGIN_URL; ?>/wp-print/print-css.css" type="text/css" media="screen, print" />
	<?php endif; ?>
</head>
<body>
<p style="text-align: center;"><strong>- <?php bloginfo('name'); ?> - <?php bloginfo('url')?> -</strong></p>
<div class="Center">
	<div id="Outline">
		<?php if (have_posts()): ?>
			<?php while (have_posts()): the_post(); ?>
					<p id="BlogTitle"><?php the_title(); ?></p>
					<p id="BlogDate"><?php _e('Posted By', 'wp-print'); ?> <u><?php the_author(); ?></u> <?php _e('On', 'wp-print'); ?> <?php the_time(sprintf(__('%s @ %s', 'wp-print'), get_option('date_format'), get_option('time_format'))); ?> <?php _e('In', 'wp-print'); ?> <?php print_categories('<u>', '</u>'); ?> | <u><a href='#comments_controls'><?php print_comments_number(); ?></a></u></p>
					<div id="BlogContent"><?php print_content(); ?></div>
			<?php endwhile; ?>
			<hr class="Divider" style="text-align: center;" />
			<?php if(print_can('comments')): ?>
				<?php comments_template(); ?>
			<?php endif; ?>
			<p style="text-align: <?php echo $text_direction; ?>;"><?php _e('Article printed from', 'wp-print'); ?> <?php bloginfo('name'); ?>: <strong><?php bloginfo('url'); ?></strong></p>
			<p style="text-align: <?php echo $text_direction; ?>;"><?php _e('URL to article', 'wp-print'); ?>: <strong><?php the_permalink(); ?></strong></p>
			<?php if(print_can('links')): ?>
				<p style="text-align: <?php echo $text_direction; ?>;"><?php print_links(); ?></p>
			<?php endif; ?>
			<p style="text-align: <?php echo $text_align_opposite; ?>;" id="print-link"><?php _e('Click', 'wp-print'); ?> <a href="#Print" onclick="window.print(); return false;" title="<?php _e('Click here to print.', 'wp-print'); ?>"><?php _e('here', 'wp-print'); ?></a> <?php _e('to print.', 'wp-print'); ?></p>
		<?php else: ?>
				<p style="text-align: <?php echo $text_direction; ?>;"><?php _e('No posts matched your criteria.', 'wp-print'); ?></p>
		<?php endif; ?>
	</div>
</div>
<p style="text-align: center;"><?php echo stripslashes($print_options['disclaimer']); ?></p>
</body>
</html>