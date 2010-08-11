<?php
# check to see if any of these SEO plugins is installed. If yes, the Bytes For All SEO options will be
# deactivated, not matter what the option "Use Bytes For All SEO options?" is set to
# (at Admin -> Design|Presentation -> [Theme Name] Theme Options)
#
if(class_exists('All_in_One_SEO_Pack') OR // if "All-In-One_SEO" Plugin (http://semperfiwebdesign.com) is installed
class_exists('wpSEO') OR // if "WpSEO" Plugin (http://www.wpseo.de/) is installed
class_exists('HeadSpace2_Admin') OR // if "HeadSpace2" Plugin (http://urbangiraffe.com/plugins/headspace2/) is installed
function_exists('seo_title_tag_options_page') OR // if "SEO Title Tag" Plugin (http://www.netconcepts.com/seo-title-tag-plugin/) is installed
class_exists('Another_WordPress_Meta_Plugin') OR // if "Another WordPress Meta Plugin" (http://wp.uberdose.com/2006/11/04/another-wordpress-meta-plugin/) is installed
class_exists('Platinum_SEO_Pack') OR // if "Platinum_SEO_Pack" Plugin (http://techblissonline.com/platinum-seo-pack/) is installed
function_exists('headmeta') OR // if "HeadMeta" Plugin (http://dougal.gunters.org/blog/2004/06/17/my-first-wordpress-plugin-headmeta) is installed
function_exists('bas_improved_meta_descriptions') OR // if "Improved Meta Description Snippets" Plugin (http://www.microkid.net/wordpress-plugins/improved-meta-description-snippets/) is installed
function_exists('head_meta_desc') OR // if "Head META Description" Plugin (http://guff.szub.net/head-meta-description/) is installed
class_exists('RobotsMeta_Admin') OR // if "Robots Meta" Plugin (http://yoast.com/wordpress/robots-meta/) is installed
function_exists('quickkeywords') OR // if "Quick META Keywords" Plugin (http://www.quickonlinetips.com/) is installed
class_exists('Add_Your_Own_Headers') OR // if "Add Your Own Headers" Plugin (http://wp.uberdose.com/2007/03/30/add-your-own-headers/) is installed
function_exists('SEO_wordpress') OR // if "SEO_Wordpress" Plugin (http://www.utheguru.com/seo_wordpress-wordpress-seo-plugin) is installed
$ata_use_bfa_seo == "No") { // if the option "Use Bytes For All SEO options?" is set to "No" (at Admin -> Design|Presentation -> [Theme Name] Theme Options)
?>
<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
<?php } else { ?>
<title><?php 
if ( is_home() ) {
	bloginfo('name');} else {

	if ( is_single() OR is_page() ) { 
#		$ata_page_title = htmlentities(single_post_title('', false),ENT_QUOTES); } 
		$ata_page_title = single_post_title('', false); } // post and page titles get their own filter from WP
	elseif ( is_category() ) { 
		$ata_page_title = htmlentities(single_cat_title('', false),ENT_QUOTES); } // cat titles don't get a filter, so htmlentities is required
	elseif ( function_exists('is_tag') && is_tag() ) { 
#		$ata_page_title = htmlentities(single_tag_title('', false),ENT_QUOTES); }
		$ata_page_title = single_tag_title('', false); } // tag titles get their own filter from WP
	elseif ( is_search() ) { 
		$ata_page_title = htmlentities(wp_specialchars($s),ENT_QUOTES);	} // no WP filter, htmlentities required 
	elseif ( is_day() ) { 
		$ata_page_title = get_the_time('l, F jS, Y'); } 
	elseif ( is_month() ) { 
		$ata_page_title = get_the_time('F Y'); }
	elseif ( is_year() ) { 
		$ata_page_title = get_the_time('Y'); } 
#	elseif ( is_author() ) { 
#		$ata_page_title = htmlentities(the_author(),ENT_QUOTES); }   // this won't work
	elseif ( is_404() ) { 
		$ata_page_title = "404 - Page not found"; }
	else { 
		$ata_page_title = wp_title('', false); } 
	
	switch ($ata_title_separator_code) {
		case 1: $ata_title_separator = " &#171; "; break;
		case 2: $ata_title_separator = " &#187; "; break;
		case 3: $ata_title_separator = " &#58; "; break;
		case 4: $ata_title_separator = "&#58; "; break;
		case 5: $ata_title_separator = " &#62; "; break;
		case 6: $ata_title_separator = " &#60; "; break;
		case 7: $ata_title_separator = " &#45; "; break;
		case 8: $ata_title_separator = " &#8249; "; break;
		case 9: $ata_title_separator = " &#8250; "; break;
		case 10: $ata_title_separator = " &#8226; "; break;
		case 11: $ata_title_separator = " &#183; "; break;
		case 12: $ata_title_separator = " &#151; "; break;
		case 13: $ata_title_separator = " &#124; "; break;	
	}
//
// 3 different styles for meta title tag: (1) Blog Title - Page Title, (2) Page Title - Blog Title, (3) Page Title
// To be set in WP Admin -> Design ("Presentation" in WP 2.3 and older) -> [Theme Name] Theme Options 
//
	if ($ata_add_blogtitle == "Blog Title - Page Title") {
		bloginfo('name'); echo $ata_title_separator . $ata_page_title; }
	elseif ($ata_add_blogtitle == "Page Title - Blog Title") {
		echo $ata_page_title . $ata_title_separator; bloginfo('name'); }
	elseif ($ata_add_blogtitle == "Page Title") { echo $ata_page_title; }
}
// END TITLE TAG
//
?>
</title>
<?php 
//
// META DESCRIPTION Tag for (only) the HOMEPAGE. 
// To be set in WP Admin -> Design ("Presentation" in WP 2.3 and older) -> [Theme Name] Theme Options 
//
if ( is_home() && trim($ata_homepage_meta_description) != "" ) { 
	echo "<meta name=\"description\" content=\"" . htmlentities($ata_homepage_meta_description,ENT_QUOTES) . "\" />\n"; 
	}
//
// META KEYWORDS Tag for (only) the HOMEPAGE. 
// To be set in WP Admin -> Design ("Presentation" in WP 2.3 and older) -> [Theme Name] Theme Options 
if ( is_home() && trim($ata_homepage_meta_keywords) != "" ) { 
	echo "<meta name=\"keywords\" content=\"" . htmlentities($ata_homepage_meta_keywords,ENT_QUOTES) . "\" />\n"; 
	}
//
// META DESCRIPTION Tag for CATEGORY PAGES, if a category description exists:
//
if ( is_category() && strip_tags(trim(category_description())) != "" ) {
	// the category description gets its own ASCII code filter from WP, 
	// but <p> ... </p> tags will be included by WP, so we remove them here:
	echo "<meta name=\"description\" content=\"" . strip_tags(trim(category_description())) . "\" />\n"; 	 
}
//
// prevent duplicate content by making archive pages noindex:
// To be set in WP Admin -> Design ("Presentation" in WP 2.3 and older) -> [Theme Name] Theme Options 
//
// If it's a date based archive page:
if ($ata_archive_noindex == "Yes" && (is_day() OR is_month() OR is_year()) ) { ?>
<meta name="robots" content="noindex, follow" />  <?php echo "\n"; } 
// If it's a category page:
elseif ($ata_cat_noindex == "Yes" && is_category() ) { ?>
<meta name="robots" content="noindex, follow" />  <?php echo "\n"; } 
// If it's a tag page:
elseif ($ata_tag_noindex == "Yes" && is_tag() ) { ?>
<meta name="robots" content="noindex, follow" />  <?php echo "\n"; } ?>
<?php } ?>