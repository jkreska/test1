<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta http-equiv="Content-Language" content="English" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_get_archives('type=monthly&format=link'); ?>
<?php //comments_popup_script(); // off by default ?>
<?php wp_head(); ?>

</head>
<body>
<div id="top">

	<div id="header_top">

		<div class="title">
		
			<h1><a href="<?php bloginfo('siteurl');?>/" title="<?php bloginfo('name');?>"><?php bloginfo('name');?></a></h1><br />
			<h2><?php bloginfo('description'); ?></h2>
			
		</div>
		
			<div id="search-box">
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</div>
	</div> <!-- header_top -->
		
	<div id="header_nav">
		<div id="nav">
			<div id="menu">
				<ul>
					<li><a href="<?php bloginfo('home'); ?>/">Home</a></li>
					<?php wp_list_pages('title_li=&depth=1'); ?>
				</ul>
			</div>
		</div> <!-- nav -->
	</div> <!-- header_nav -->
	
</div> <!-- top -->

<div id="wrapper">