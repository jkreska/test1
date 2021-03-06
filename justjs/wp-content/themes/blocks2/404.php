<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
	<link rel="alternate" type="application/rss+xml" title="<?php _e('RSS 2.0 - all posts', 'blocks2'); ?>" href="<?php echo $feed; ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php _e('RSS 2.0 - all comments', 'blocks2'); ?>" href="<?php bloginfo('comments_rss2_url'); ?>" />

	<!-- style START -->
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/404.css" type="text/css" media="screen" />
	<!-- style END -->

	<?php wp_head(); ?>
</head>

<body>

<div id="container">
	<div id="talker">
		<?php
			if (function_exists('get_avatar') && get_option('show_avatars')) {
				echo get_avatar(get_option('admin_email'), 96);
			}
		?>
	</div>
	<h1><?php _e('Welcome to 404 error page!', 'blocks2'); ?></h1>
	<div id="notice">
		<p><?php _e("Welcome to this customized error page. You've reached this page because you've clicked on a link that does not exist. This is probably our fault... but instead of showing you the basic '404 Error' page that is confusing and doesn't really explain anything, we've created this page to explain what went wrong.", 'blocks2'); ?></p>
		<p><?php _e("You can either (a) click on the 'back' button in your browser and try to navigate through our site in a different direction, or (b) click on the following link to go to homepage.", 'blocks2'); ?></p>
		<div class="back">
			<a href="<?php bloginfo('url'); ?>/"><?php _e('Back to homepage &raquo;', 'blocks2'); ?></a>
		</div>
	</div>
</div>

</body>
</html>
