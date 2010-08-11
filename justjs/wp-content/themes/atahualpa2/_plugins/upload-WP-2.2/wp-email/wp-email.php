<?php
/*
+----------------------------------------------------------------+
|																							|
|	WordPress 2.1 Plugin: WP-EMail 2.11										|
|	Copyright (c) 2007 Lester "GaMerZ" Chan									|
|																							|
|	File Written By:																	|
|	- Lester "GaMerZ" Chan															|
|	- http://www.lesterchan.net													|
|																							|
|	File Information:																	|
|	- E-Mail Post/Page To A Friend												|
|	- wp-content/plugins/email/wp-email.php									|
|																							|
+----------------------------------------------------------------+
*/


### Session Start
session_start();

### Require PHP-Mailer Class
require(ABSPATH.'wp-content/plugins/email/class-phpmailer.php');

### Filters
add_filter('wp_title', 'email_pagetitle');
add_action('loop_start', 'email_addfilters');

### We Use Page Template
if(file_exists(TEMPLATEPATH.'/page.php')) {
	include(get_page_template());
} elseif(file_exists(TEMPLATEPATH.'/single.php')) {
	include(get_single_template());
} else {
	include(TEMPLATEPATH.'/index.php');
}
?>