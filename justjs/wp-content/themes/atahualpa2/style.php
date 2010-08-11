<style type="text/css">

a:link, a:visited, a:active {
	color: #<?php echo $ata_link_color; ?>; 
	font-weight: <?php echo $ata_link_weight; ?>; 
	text-decoration: <?php echo $ata_link_default_decoration; ?>; 
	}
	
a:hover {
	color: #<?php echo $ata_link_hover_color; ?>;
	font-weight: <?php echo $ata_link_weight; ?>; 
	text-decoration: <?php echo $ata_link_hover_decoration; ?>; 
	}
	
h1 { 
	font-family: <?php echo $ata_blog_title_font; ?>; 
	font-size: <?php echo $ata_blog_title_fontsize; ?>em; 
	}

h2 {
	color: #<?php echo $ata_h2_color; ?>; 
	}
	
h2 a:link, h2 a:visited, h2 a:active  {
	color: #<?php echo $ata_post_title_color; ?>; 
	}

h2 a:hover  {
	color:#<?php echo $ata_post_title_hover_color; ?>; 
	}

h3.widgettitle {
	color: #<?php echo $ata_sidebar_title_color; ?>; 
	font-size: <?php echo $ata_sidebar_title_size; ?>em; 
	}
		
a.header:link, a.header:visited, a.header:active {
	color: #<?php echo $ata_blog_title_color; ?>; 
	}
	
a.header:hover {
	color: #<?php echo $ata_blog_title_hover_color; ?>; 
	}

p.header { 
	color: #<?php echo $ata_blog_tagline_color; ?>; 
	}
			
#page-container {
	font-family: <?php echo $ata_body_font; ?>, <?php echo $ata_body_backup_font; ?>; 
	min-width: <?php echo $ata_min_width; ?>px;
	font-size: <?php echo $ata_body_font_size; ?>%;
	margin: 0 <?php echo $ata_body_left_right_margin; ?>px; 
	}

<?php if ($ata_body_left_right_margin < 10) { 
// these things shouldn't touch the browser border: ?>
#left-column .inside {
	margin-left: <?php echo 10 - $ata_body_left_right_margin; ?>px;		
	}
.rss-icon {
	margin-right: <?php echo 10 - $ata_body_left_right_margin; ?>px;
	}
.logo-icon {
	margin-left: <?php echo 10 - $ata_body_left_right_margin; ?>px;
	}
	
	<?php if ($ata_show_logo_icon == "No") { ?>
	.blogtitle-box {
	margin-left: <?php echo 10 - $ata_body_left_right_margin; ?>px;
	}
	<?php } ?>
<?php } ?>

#outer-column-container {
	border-left: solid <?php echo $ata_leftcolumn_width; ?>em #fff; 
	border-right: solid <?php echo $ata_rightcolumn_width; ?>em #fff;
	}
	
#left-column {
	margin-left: -<?php echo $ata_leftcolumn_width; ?>em; 
	width: <?php echo $ata_leftcolumn_width; ?>em; 
	}
	
#right-column {
	margin-right: -<?php echo $ata_rightcolumn_width; ?>em; 
	width: <?php echo $ata_rightcolumn_width; ?>em; 
	}
	
.searchbox {
	width: <?php echo $ata_searchbox_width; ?>em; 
	}

#left-column .inside .searchfield {
	width: <?php echo 100 - (ceil(100 / $ata_leftcolumn_width * 3)); ?>%;
	}

#right-column .inside .searchfield {
	width: <?php echo 100 - (ceil(100 / $ata_rightcolumn_width * 3)); ?>%;
	}

#left-column .inside ul li a, 
#right-column .inside ul li a {
	color: #<?php echo $ata_sidebar_link_color; ?>; 
	border-left: solid <?php echo $ata_sidebar_link_decoration_size; ?>px #<?php echo $ata_sidebar_link_decoration_color; ?>; 
<?php if ($ata_sidebar_link_decoration_size == 0 ) { ?>
	padding: 0;
<?php } ?>
	}
	
#left-column .inside ul li a:hover, 
#right-column .inside ul li a:hover {
	color: #<?php echo $ata_sidebar_link_hover_color; ?>; 
	border-left: solid <?php echo $ata_sidebar_link_decoration_size; ?>px #<?php echo $ata_sidebar_link_decoration_hover_color; ?>; 
	}

<?php if ($ata_show_header_image == "No") { ?>
#headerimage-bottom { 
	height: 1px; 
	padding: 0;
	margin: 0;
	}
<?php } ?>

<?php if ($ata_show_top_menu_bar == "Yes" && $ata_show_logo_area == "No") { ?>
#headerimage-top { 
	border-top: none; 
	}
<?php } ?>

<?php if ($ata_show_top_menu_bar == "No" && $ata_show_logo_area == "No") { ?>
#headerimage-top { 
	display: none; 
	}
<?php } ?>

/* Print Style Sheet */
@media print {

body { background:white; color:black; margin:0; }
a:link:after, a:visited:after { content:" [" attr(href) "] "; font-weight: normal; text-decoration:none; font-size: 12pt;} 
a:link, a:visited {text-decoration:underline; color:#000}
.postmetadata a:link:after, .postmetadata a:visited:after { content:""; } 
h2 a:link:after, h2 a:visited:after { content:""; } 
h2, h2 a:link, h2 a:visited, h2 a:active {color: #000; font-size: 18pt}
h3 {color: #000; font-size: 15pt;} 
#outer-column-container { border-left: none; border-right: none }
#page-container {font-size: 12pt; font-family: arial, sans-serif; margin:0; background: #fff; color: #000}
.remove-for-print, 
#left-column, 
#right-column, 
#footer, 
.navigation, 
.wp-pagenavi-navigation, 
#commentform {display:none}

}		

</style>
<!--[if lte IE 6]>
<style type="text/css" media="screen">
    div#page-container {
        width:expression(((document.compatMode && document.compatMode=='CSS1Compat') ? document.documentElement.clientWidth : document.body.clientWidth) < <?php echo $ata_min_width; ?> ? "<?php echo $ata_min_width; ?>px" : "auto");
        }
    .searchbox { margin-right: -6px; }
    em { font-style:normal;}  
</style>
<![endif]-->