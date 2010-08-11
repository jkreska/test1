<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php
global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>
<?php include (TEMPLATEPATH . '/functions/bfa_meta_tags.php'); ?>
<?php if ( $ata_show_header_image == "Yes") { 
include (TEMPLATEPATH . '/functions/bfa_rotating_header_images.php'); 
} ?>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
<?php include (TEMPLATEPATH . '/style.php'); ?>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>
<body>
<div id="page-container">

<div class="remove-for-print">
	<?php if ($ata_show_top_menu_bar == "Yes" ) { ?>
	<div class="clearfix" id="modernbricksmenu">
		<ul>
		<li class="page_item"><a href="<?php echo get_option('home'); ?>/" title="<?php bloginfo('name'); ?>">Home</a></li>
		<?php wp_list_pages('title_li=&depth=1' ); ?>
		</ul>
	</div>

	<div style="clear: both"></div>
	<?php } // END: If Show Menu Bar ?>

	<?php if ($ata_show_logo_area == "Yes" ) { ?>
	<div class="headerleft">

		<?php if ($ata_show_logo_icon == "Yes") { ?>

		<img class="logo-icon" src="<?php
			// if this is WordPress MU 
			if (file_exists(ABSPATH."/wpmu-settings.php")) {
			// see if user has uploaded his own "logosymbol.gif" somewhere into his upload folder
			$wpmu_logosymbol = m_find_in_dir(get_option('upload_path'),'logosymbol.gif');
				// if yes, figure out the URL
				if ($wpmu_logosymbol) {
				$new_logosymbol = str_replace(get_option('upload_path'),
				get_option('fileupload_url'), $wpmu_logosymbol); 
				// ... and print it
				echo $new_logosymbol[0] . '" alt="'; bloginfo('name'); 
				// otherwise: print the one in the theme folder
				} else { echo get_bloginfo('template_directory'); ?>/images/logosymbol.gif" alt="<?php bloginfo('name'); }
			// if not WPMU, print the one in the theme folder right away
			} else {
			echo get_bloginfo('template_directory'); ?>/images/logosymbol.gif" alt="<?php bloginfo('name'); 
			} 
			?>" />

		<?php } // END: If Show Logo Icon ?>
		
		<div class="blogtitle-box">
			<h1><a class="header" href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
			<div style="clear: both"></div>
			<p class="header"><?php bloginfo('description'); ?></p>
		</div>
	</div>

	<?php if ($ata_show_rss_icon == "Yes" ) { ?>
	<a <?php if ($ata_nofollow == "Yes") { echo "rel=\"nofollow\" "; } ?>href="<?php bloginfo('rss2_url'); ?>">
	<img class="rss-icon" src="<?php echo get_bloginfo('template_directory'); ?>/images/rss-icon-20x20.gif" alt="<?php bloginfo('name'); ?> RSS Feed" border="0" />
	</a>
	<div style="clear: right"></div>
	<?php } // END: If Show RSS Icon ?>
	
	<?php if ($ata_show_search_box == "Yes" ) { ?>
	<div class="searchbox">
		<div class="searchbox-form">
			<form method="get" class="searchform" action="<?php bloginfo('url'); ?>/">
			<input type="text" style="width: 99%" value="<?php the_search_query(); ?>" name="s" />
			</form>
		</div>
	</div>
	<?php } // END: If Show Search Box ?>

	<div style="clear:both"></div>
	<?php } // END: If Show Logo Area ?>

	<?php if ($ata_show_header_image == "Yes" ) { ?>
	<div id="headerimage-top">&nbsp;</div>

	<div style="margin: 0; padding: 0; height: <?php echo $ata_headerimage_height; ?>px; background: url(<?php echo $selected_header_image; ?>) <?php echo $ata_headerimage_alignment; ?> no-repeat;">

		<?php if ( $ata_overlay_blog_title == "No") { ?>
		<?php if ( $ata_header_opacity != 0 ) { ?>
			<div style="background-color: white; float: left; height: <?php echo $ata_headerimage_height; ?>px; width: <?php echo $ata_leftcolumn_width; ?>em; filter:alpha(opacity=<?php echo $ata_header_opacity; ?>);-moz-opacity:.<?php echo $ata_header_opacity; ?>;opacity:.<?php echo $ata_header_opacity; ?>;">
			&nbsp;
			</div>
			<div style="background-color: white; float: right; height: <?php echo $ata_headerimage_height; ?>px; width: <?php echo $ata_rightcolumn_width; ?>em; filter:alpha(opacity=<?php echo $ata_header_opacity; ?>);-moz-opacity:.<?php echo $ata_header_opacity; ?>;opacity:.<?php echo $ata_header_opacity; ?>;">
			&nbsp;
			</div>
			<div style="clear:both"></div>
		<?php } // END: If Header Opacity ?>
		<?php } else { 
			if ($ata_overlay_blog_title == "Yes - left aligned") {
			$overlay_style = "float: left; padding-left: 20px; "; }
			elseif ($ata_overlay_blog_title == "Yes - right aligned") {
			$overlay_style = "float: right; padding-right: 20px; "; }
			elseif ($ata_overlay_blog_title == "Yes - centered") {
			$overlay_style = "text-align: center; margin-left: auto; margin-right: auto; "; }
			echo "<div style=\"" . $overlay_style . "padding-top: " . $ata_overlay_blog_title_top_padding . "px \">"; ?>
			<h1><a class="header" href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
			</div>
		<?php } ?>

	</div>
	<?php } // END: If Show Header Image ?>
	
	<div id="headerimage-bottom">&nbsp;</div>
</div>