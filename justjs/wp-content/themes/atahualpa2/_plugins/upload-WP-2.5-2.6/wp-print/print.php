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
|	- Process Printing Page															|
|	- wp-content/plugins/wp-print/print.php									|
|																							|
+----------------------------------------------------------------+
*/


### Variables
$links_text = '';

### Actions
add_action('init', 'print_content');

### Filters
add_filter('wp_title', 'print_pagetitle');
add_filter('comments_template', 'print_template_comments');

### Print Options
$print_options = get_option('print_options');

### Determine Text Direction
$text_direction = 'ltr';
$text_align = 'left';
$text_align_opposite = 'right';
if($print_options['text_direction'] == 'rtl') {
	$text_direction = 'rtl';
	$text_align = 'right';
	$text_align_opposite = 'left';
}

### Load Print Post/Page Template
if(file_exists(TEMPLATEPATH.'/print-posts.php')) {
	include(TEMPLATEPATH.'/print-posts.php');
} else {
	include(WP_PLUGIN_DIR.'/wp-print/print-posts.php');
}
?>