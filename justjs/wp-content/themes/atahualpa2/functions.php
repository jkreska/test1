<?php
if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
        'name'=>'Left Sidebar',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
         'name'=>'Right Sidebar',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));  
} ?>
<?php
#include (TEMPLATEPATH . '/functions/simple_recent_comments.php');
#include (TEMPLATEPATH . '/functions/most_commented.php');
#include (TEMPLATEPATH . '/functions/most_commented_per_cat.php');
include (TEMPLATEPATH . '/functions/bfa_recent_comments.php');
include (TEMPLATEPATH . '/functions/bfa_popular_posts.php');
include (TEMPLATEPATH . '/functions/bfa_popular_in_cat.php');
?>
<?php 
function bfa_add_stuff_admin_head() {
    $url_base = get_bloginfo('template_directory');
	echo "<script src=\"$url_base/options/jscolor/jscolor.js\" type=\"text/javascript\"></script>\n";
}
add_action('admin_head', 'bfa_add_stuff_admin_head');
?>
<?php
$header_image_text_wp = "<br /><br /><em>You add your own header image(s), upload one or several images with any file names <strong>anything.[jpg|gif|png]</strong>  (i.e. hfk7wdfw8.gif, IMAGE_1475.jpg, bla.png) to /wp-content/themes/[theme-name]/images/header/ through FTP. The image(s) should be 1300 pixels wide or even wider, if you care about those who surf with an even wider browser viewport, like 1500 or 1600 pixels wide. The theme will autmatically recognize all images in that directory. If there's only one image, then it'll be your single, \"static\" header image. If there's more than one, then the theme will rotate them with every pageview.</em>";
$header_image_text_wpmu = "<br /><br /><em>To upload your own header images, you'll need to prepare your header image(s) on your harddrive first. The image(s) should be 1300 pixels wide or even wider, if you care about those who surf with an even wider browser viewport, like 1500 or 1600 pixels wide. Rename them to <strong>atahualpa_header_XX.[jpg|gif|png|bmp]</strong> (Example: atahualpa_header_1.jpg, atahualpa_header_3.png, atahualpa_header_182.gif) and then, upload them to your WordPress site through your WordPress Editor</strong>. <br /><br />There is no \"upload\" tab in the admin area though. To upload an image, you'll have to act as if you're going to add an image to a post: Go to Admin -> Manage -> Posts, and click on the title of an existing post to open the editor. Click on the \"Add Media\" link, and in the next window click on the \"Choose files to upload\" button. That will open a window on your local computer where you can find and select the header image (which you've already renamed as described before) on your harddrive. Select \"Full Size\" and, instead of clicking on \"Insert into Post\", you will click on \"Save all changes\" because you just want to upload the image and not insert it into the post. Now reload your Homepage and the new header image should appear. If you want more than one header image (to have them rotate) simply repeat all these steps. The theme will autmatically recognize all images that are named atahualpa_header_X.[jpg|png|gif]. If there's only one image, then it'll be your single, \"static\" header image. If there's more than one, then the theme will rotate them with every pageview.</em>";
$logo_icon_text_wp = "upload a \"logosymbol.gif\" with the size of 50x50 pixels and white background to <strong>/wp-content/themes/atahualpa2/images/</strong></em>";
$logo_icon_text_wpmu = "upload a \"logosymbol.gif\" with the size of 50x50 pixels and white background through the WordPress Editor. There's no \"upload\" tab though. To upload the image you will have to act as if you're going to add an image to a post: Go to Admin -> Manage -> Posts, and click on the title of an existing post to open the editor. Click on the \"Add Media\" link, and in the next window click on the \"Choose files to upload\" button. That will open a window on your local computer where you can select the \"logosymbol.gif\" on your harddrive. After you've selected the image, choose \"Full Size\" and, instead of clicking on \"Insert into Post\", click on \"Save all changes\". Now reload your Homepage and the logo icon should appear instead of the default one.</em>";
if (file_exists(ABSPATH."/wpmu-settings.php")) {
$header_image_text = $header_image_text_wpmu; 
$logo_icon_text = $logo_icon_text_wpmu; }
else {$header_image_text = $header_image_text_wp; 
$logo_icon_text = $logo_icon_text_wp;}
?>
<?php
$themename = "Atahualpa";
$shortname = "ata";
$options = array (

     array(    "name" => "Use Bytes For All SEO options",
    	    "category" => "seo",
            "id" => $shortname."_use_bfa_seo",
            "type" => "select",
            "std" => "No",
            "options" => array("No", "Yes"),
            "info" => "<strong>Leave this at \"No\" if you're using ANY SEO plugin</strong> such as \"All-in-one-SEO\", or any plugin that deals with meta tags in some way. If both a SEO plugin and the theme's SEO functions are activated, the meta tags of your site may get messed up, which might affect your search engine rankings. <br /><br />If you leave this at \"No\", the next SEO options (except the last one, \"Nofollow RSS...\") will become obsolete, you may just skip them. <br /><br /><em>Note: Even if you set this to \"Yes\", the SEO functions listed below (except \"Nofollow RSS...\") will NOT be activated IF the theme recognizes that a SEO plugin is activated.</em>"),

    array(    "name" => "Homepage Meta Description",
            "id" => $shortname."_homepage_meta_description",
            "std" => "",
            "type" => "textarea",
            "info" => "Type 1-3 sentences, about 20-30 words total. Will be used as Meta Description for (only) the homepage. If left blank, no Meta Description will be added to the homepage. Default: <strong>blank</strong>"),    

    array(    "name" => "Homepage Meta Keywords",
            "id" => $shortname."_homepage_meta_keywords",
            "std" => "",
            "type" => "textarea",
            "info" => "Type 5-30 words or phrases, separated by comma. Will be used as the Meta Keywords for (only) the homepage. If left blank, no Meta Keywords will be added to the homepage. Default: <strong>blank</strong>"),

     array(    "name" => "Meta Title Tag format",
    	    "category" => "seo",
            "id" => $shortname."_add_blogtitle",
            "type" => "select",
            "std" => "Page Title - Blog Title",
            "options" => array("Page Title - Blog Title", "Blog Title - Page Title", "Page Title"),
            "info" => "Show the blog title in front of or after the page title, in the meta title tag of every page? Or, show only the page title?"),

     array(    "name" => "Meta Title Tag Separator",
    	    "category" => "seo",
            "id" => $shortname."_title_separator_code",
            "type" => "select",
            "std" => "1",
            "options" => array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13"),
            "info" => "If you chose to include the blog title in the meta title (the option above), choose here what to put BETWEEN the page and the blog title (or vice versa):<br /><br /> 1( &#171; ),  2( &#187; ),  3( &#58; ),  4(&#58; ),  5( &#62; ),  6( &#60; ),  7( &#45; ),  8( &#8249; ),  9( &#8250; ),  10( &#8226; ), 11( &#183; ), 12( &#151; ) or 13( &#124; )."),
 
     array(    "name" => "Noindex Date Archive Pages?",
            "id" => $shortname."_archive_noindex",
            "type" => "select",
            "std" => "No",
            "options" => array("No", "Yes"),
            "info" => "Include meta tag \"noindex, follow\" into date based archive pages? The purpose is to keep search engines from spidering duplicate content from your site. Default is <strong>No</strong>"),

     array(    "name" => "Noindex Category pages?",
            "id" => $shortname."_cat_noindex",
            "type" => "select",
            "std" => "No",
            "options" => array("No", "Yes"),
            "info" => "Include meta tag \"noindex, follow\" into category pages? Same purpose as above. Default is <strong>No</strong>"),

     array(    "name" => "Noindex Tag pages?",
            "id" => $shortname."_tag_noindex",
            "type" => "select",
            "std" => "No",
            "options" => array("No", "Yes"),
            "info" => "Include meta tag \"noindex, follow\" into tag pages? Same purpose as above. Default is <strong>No</strong>"),

     array(    "name" => "Nofollow RSS, trackback & admin links?",
            "id" => $shortname."_nofollow",
            "type" => "select",
            "std" => "No",
            "options" => array("No", "Yes"),
            "info" => "Make RSS, trackback & admin links \"nofollow\"? Same purpose as above. Default is <strong>No</strong>"),

    array(    "name" => "Body Font",
            "id" => $shortname."_body_font",
            "type" => "select",
            "std" => "Tahoma",
            "options" => array("Tahoma", "Arial", "Calibri", "Cambria", "Candara", "Comic Sans MS", "Consolas", "Constantia", "Corbel", "Courier New", "Georgia", "Times New Roman", "Trebuchet MS", "Verdana"),
            "info" => "The font face for the main content. Default: <strong>Tahoma</strong>"),
          
    array(    "name" => "Body Backup Font",
            "id" => $shortname."_body_backup_font",
            "type" => "select",
            "std" => "Arial, sans-serif",
            "options" => array("Arial, sans-serif", "Calibri, sans-serif", "Cambria, serif", "Candara, sans-serif", "Comic Sans MS, sans-serif", "Consolas, sans-serif", "Constantia, serif", "Corbel, sans-serif", "Courier New, sans-serif", "Georgia, serif", "Tahoma, sans-serif", "Times New Roman, serif", "Trebuchet MS, sans-serif", "Verdana, sans-serif"),
            "info" => "Show this font for users that don't have the main font face (option above) installed on their computer. Default: <strong>Arial, sans serif</strong>"),

    array(    "name" => "Body Font Size",
            "id" => $shortname."_body_font_size",
            "std" => "80",
            "type" => "text",
            "info" => "In % (percent). Default: <strong>80</strong>"),
                                                        
    array(    "name" => "Link Default Color",
            "id" => $shortname."_link_color",
            "std" => "666666",
            "type" => "text",
            "info" => "All hex color codes. Default: <strong>666666</strong>"),

    array(    "name" => "Link Hover Color",
            "id" => $shortname."_link_hover_color",
            "std" => "cc0000",
            "type" => "text",
            "info" => "Color of links when \"hovering\" over them with the mouse pointer. All hex color codes. Default: <strong>cc0000</strong>"),

    array(    "name" => "Link Default Decoration",
            "id" => $shortname."_link_default_decoration",
            "type" => "select",
            "std" => "none",
            "options" => array("none", "underline"),
            "info" => "Underline links or not, in their default state? Default: <strong>none</strong>"),

    array(    "name" => "Link Hover Decoration",
            "id" => $shortname."_link_hover_decoration",
            "type" => "select",
            "std" => "underline",
            "options" => array("underline", "none"),
            "info" => "When the mouse pointer hovers over a link, underline it or not? Default: <strong>underline</strong>"),        

    array(    "name" => "Link Text Bold or Not",
            "id" => $shortname."_link_weight",
            "type" => "select",
            "std" => "bold",
            "options" => array("bold", "normal"),
            "info" => "Make link text bold or not? Default: <strong>bold</strong>"),

    array(    "name" => "Body Margin Left/Right",
            "id" => $shortname."_body_left_right_margin",
            "std" => "10",
            "type" => "text",
            "info" => "In the default setup, there's some space on the left and right hand side of the layout. You can increase that, or set it to \"0\" to make the layout stretch from left to right 100%. Default: <strong>10</strong> (pixels)"),

    array(    "name" => "Show Top Menu Bar?",
            "id" => $shortname."_show_top_menu_bar",
             "type" => "select",
            "std" => "Yes",
            "options" => array("Yes", "No"),
            "info" => "Show the Top Menu Bar for \"Pages\" at the very top of the layout? Default: <strong>Yes</strong>.<br /><br /> <em>To put the navigation for \"Pages\" into a sidebar, go to Admin -> Design (\"Presentation\" in WP 2.3 and older) -> Widgets, and add the \"Pages\" widget to one of the sidebars.</em>"),

    array(    "name" => "Show Header Logo Area?",
            "id" => $shortname."_show_logo_area",
             "type" => "select",
            "std" => "Yes",
            "options" => array("Yes", "No"),
            "info" => "Show the whole area BETWEEN the Top Menu Bar and the Header Image? If set to \"No\", the Logo Icon, the Blog Title, the Blog Tagline, the RSS Icon, the Header Search Box, and the whole area containing those will dissapear, and the next 4 setttings will become obsolete. Default: <strong>Yes</strong>.<br /><br /> <em>If you set this to \"No\" you will have no Blog Title anymore. Choose \"Yes\" at \"Overlay Blog Title over Header Image(s)?\" below, to get a Blog Title again. </em>"),

    array(    "name" => "Show Logo Icon?",
            "id" => $shortname."_show_logo_icon",
             "type" => "select",
            "std" => "Yes",
            "options" => array("Yes", "No"),
            "info" => "Show the graphic on the left hand side of the blog title? Default: <strong>Yes</strong>.<br /><br /> <em>To use your own graphic, leave this option at <strong>Yes</strong> and " . $logo_icon_text),

    array(    "name" => "Show search box in header area?",
            "id" => $shortname."_show_search_box",
            "type" => "select",
            "std" => "Yes",
            "options" => array("Yes", "No"),
            "info" => "You can remove the search box from the header here. Default: <strong>Yes</strong>. <br /><br /><em>To put a search box into one of the sidebars, go to Admin -> Design (Presentation in WP 2.3 and older) -> Widgets, and add the \"Search\" widget to one of the sidebars.</em>"),

    array(    "name" => "Search box width",
            "id" => $shortname."_searchbox_width",
            "std" => "15",
            "type" => "text",
            "info" => "Width of the searchbox in the header. For a visually pleasing result you should probably set this to the same value as \"Right sidebar width\" (see option below), unless you have removed the right sidebar. Default: <strong>15</strong>."),

    array(    "name" => "Show RSS icon in header area?",
            "id" => $shortname."_show_rss_icon",
            "type" => "select",
            "std" => "Yes",
            "options" => array("Yes", "No"),
            "info" => "You can remove the RSS icon from the header here. Default: <strong>Yes</strong>."),

    array(    "name" => "Show Header Image(s)?",
            "id" => $shortname."_show_header_image",
            "type" => "select",
            "std" => "Yes",
            "options" => array("Yes", "No"),
            "info" => "Choose whether to display Header Image(s) or not. If you chose \"No\" at \"Show Header Logo Area?\" (see a few options above), then you should leave this setting here at \"Yes\", and additionally set the next option \"Overlay Blog Title over Header Image?\" to \"Yes\", too, or you won't have a Blog Title anywhere. Default: <strong>Yes</strong>. " . $header_image_text),

    array(    "name" => "Overlay Blog Title over Header Image(s)?",
            "id" => $shortname."_overlay_blog_title",
            "type" => "select",
            "std" => "No",
            "options" => array("No", "Yes - left aligned", "Yes - centered", "Yes - right aligned"),
            "info" => "If you chose \"No\" at \"Show Header Logo Area?\" above, then you will have no blog title anywhere in the header area. This setting here is meant to provide an alternative location for the blog title. Default: <strong>No</strong>."),

    array(    "name" => "Overlayed Blog Title Top Padding",
            "id" => $shortname."_overlay_blog_title_top_padding",
            "std" => "20",
            "type" => "text",
            "info" => "Top padding (the space above the blog title, in pixels) for an overlayed blog title. If you chose to overlay the blog title over the header image, you may adjust it's position here by moving it up and down. Default: <strong>20</strong> (pixels). <br /><br /><em>Increase this value to push the blog title down. </em>"),
          
    array(    "name" => "Header Image Height",
            "id" => $shortname."_headerimage_height",
            "std" => "150",
            "type" => "text",
            "info" => "Visible height of the header image(s), in pixels. Default: <strong>150</strong>. Change this value to show a taller or less tall area of the header image(s). <br /><br /><em>This value does not need to match the actual height of your header image(s). In fact, all your header images could have different (actual) heights. Only the top XXX (= value that you set here) pixels of each image will be shown, the rest will be hidden. </em>"),

    array(    "name" => "Header Image Alignment",
            "id" => $shortname."_headerimage_alignment",
            "type" => "select",
            "std" => "top center",
            "options" => array("top center", "top left", "top right", "center left", "center center", "center right", "bottom left", "bottom center", "bottom right"),
            "info" => "Default: <strong>top center</strong>. You should have header images with a width of 1300 pixels or wider to account for visitors with large monitors. If someone with, say a 1024 pixel monitor comes along, SOME part of the header image(s) will have to be cut off. Choose here which part to cut off. The aligned edge or end of the image will be the fixed part, and the image will be cut off from the opposite edge or end. <br /><br />Example: If you choose \"Top Left\" as the alignment, then the image(s) will be cut off from the opposite edge, which would be \"Bottom Right\" in this case, if the image doesn't fit into the visitor's browser viewport. Default: <strong>top center</strong>."),

    array(    "name" => "Header Image Opacity",
            "id" => $shortname."_header_opacity",
            "std" => "40",
            "type" => "text",
            "info" => "Opacity overlay for the left and right hand side of the header image. Numeric values between 0 and 99. Put 0 here to remove the Opacity. Default: <strong>40</strong>. "),
                                                    
    array(    "name" => "Blog Title Color",
            "id" => $shortname."_blog_title_color",
            "std" => "666666",
            "type" => "text",
            "info" => "All hex color codes. Default: <strong>666666</strong>"),

    array(    "name" => "Blog Title Hover Color",
            "id" => $shortname."_blog_title_hover_color",
            "std" => "000000",
            "type" => "text",
            "info" => "Color when hovering over the blog title. All hex color codes. Default: <strong>000000</strong>"),
            
    array(    "name" => "Blog Title Font",
            "id" => $shortname."_blog_title_font",
            "type" => "select",
            "std" => "Tahoma",
            "options" => array("Tahoma", "Arial", "Calibri", "Cambria", "Candara", "Comic Sans MS", "Consolas", "Constantia", "Corbel", "Courier New", "Georgia", "Times New Roman", "Trebuchet MS", "Verdana"),
            "info" => "The font face for the blog title."),

    array(    "name" => "Blog Title Backup Font",
            "id" => $shortname."_blog_title_backup_font",
            "type" => "select",
            "std" => "Arial, sans-serif",
            "options" => array("Arial, sans-serif", "Calibri, sans-serif", "Cambria, serif", "Candara, sans-serif", "Comic Sans MS, sans-serif", "Consolas, sans-serif", "Constantia, serif", "Corbel, sans-serif", "Courier New, sans-serif", "Georgia, serif", "Tahoma, sans-serif", "Times New Roman, serif", "Trebuchet MS, sans-serif", "Verdana, sans-serif"),
            "info" => "The backup font for the blog title, for visitors that don't have the default font (see one option above) available on their computer."),

    array(    "name" => "Blog Title Font Size",
            "id" => $shortname."_blog_title_fontsize",
            "std" => "2.5",
            "type" => "text",
            "info" => "All numeric values such as <strong>2.5</strong>, <strong>3</strong> or <strong>1.92</strong>. Default: <strong>2.5</strong>"),

    array(    "name" => "Blog Tagline Color",
            "id" => $shortname."_blog_tagline_color",
            "std" => "666666",
            "type" => "text",
            "info" => "All hex color codes. Default: <strong>666666</strong>"),

    array(    "name" => "Post Title Color (h2)",
            "id" => $shortname."_h2_color",
            "std" => "666666",
            "type" => "text",
            "info" => "This will be used for post and page titles that are not linked, i.e. on single post pages, \"page\" pages, and for the titles on category, archive, tag and search result pages. Default: <strong>666666</strong><br /><br />If you use a <strong>h2</strong> heading within posts or pages, this color would be used there, too. You should probably not use h2 within posts and pages and leave h2 to the auto-generated post and page titles. h3 would be well suited for titles of paragraphs within post and page text."),
            
    array(    "name" => "Post Title Link Color",
            "id" => $shortname."_post_title_color",
            "std" => "666666",
            "type" => "text",
            "info" => "Used for the linked post tiles, on the home page, archive, category, tag and search pages. All hex color codes. Default: <strong>666666</strong>"),

    array(    "name" => "Post Title Link Hover Color",
            "id" => $shortname."_post_title_hover_color",
            "std" => "000000",
            "type" => "text",
            "info" => "For linked post titles. All hex color codes. Default: <strong>000000</strong>"),
            
    array(    "name" => "Sidebars: Title Color",
            "id" => $shortname."_sidebar_title_color",
            "std" => "555555",
            "type" => "text",
            "info" => "Color of the widget/section titles in the sidebars. All hex color codes. Default: <strong>555555</strong>"),

    array(    "name" => "Sidebars: Title Size",
            "id" => $shortname."_sidebar_title_size",
            "std" => "1.3",
            "type" => "text",
            "info" => "Font size of the widget/section titles in the sidebars, in \"em\". Default: <strong>1.3</strong>. Any numerical values such as <strong>1.23</strong>, <strong>2</strong> or <strong>0.9</strong>"),

    array(    "name" => "Sidebars: Link Default Color",
            "id" => $shortname."_sidebar_link_color",
            "std" => "666666",
            "type" => "text",
            "info" => "Default color of link text in a sidebar. All hex color codes. Default: <strong>666666</strong>"),

    array(    "name" => "Sidebars: Link Hover Color",
            "id" => $shortname."_sidebar_link_hover_color",
            "std" => "000000",
            "type" => "text",
            "info" => "Hover color of link text in a sidebar. All hex color codes. Default: <strong>000000</strong>"),

    array(    "name" => "Sidebars: Link Decoration Color",
            "id" => $shortname."_sidebar_link_decoration_color",
            "std" => "dddddd",
            "type" => "text",
            "info" => "Default color of the little (by default: gray) boxes on the left hand side of each link in the sidebar. All hex color codes. Default: <strong>dddddd</strong>"),

    array(    "name" => "Sidebars: Link Hover Decoration Color",
            "id" => $shortname."_sidebar_link_decoration_hover_color",
            "std" => "000000",
            "type" => "text",
            "info" => "Hover color of the little (by default: gray, and in hover state: black) boxes on the left hand side of each link in the sidebar. All hex color codes. Default: <strong>000000</strong>"),

    array(    "name" => "Sidebars: Link Decoration Size",
            "id" => $shortname."_sidebar_link_decoration_size",
            "std" => "7",
            "type" => "text",
            "info" => "Width (in pixels) of the little boxes on the left hand side of each link in the sidebar. Default: <strong>7</strong>. Set to 0 to remove those boxes. If you remove them, you could start using the default \"Recent Comments\" widget of WordPress because the styling shouldn't look messed up anymore. "),
            
    array(    "name" => "Posts or excerpts on HOME page?",
            "id" => $shortname."_excerpts_home",
            "type" => "select",
            "std" => "Full Posts",
            "options" => array("Only Excerpts", "Full Posts"),
            "info" => "Show full posts or only excerpts, on the Homepage? Default: <strong>Full Posts</strong>."),
            
    array(    "name" => "Posts or excerpts on CATEGORY pages?",
            "id" => $shortname."_excerpts_category",
            "type" => "select",
            "std" => "Only Excerpts",
            "options" => array("Only Excerpts", "Full Posts"),
            "info" => "Show full posts or only excerpts, on Category pages? Default: <strong>Only Excerpts</strong>."),
            
    array(    "name" => "Posts or excerpts on ARCHIVE pages?",
            "id" => $shortname."_excerpts_archive",
            "type" => "select",
            "std" => "Only Excerpts",
            "options" => array("Only Excerpts", "Full Posts"),
            "info" => "Show full posts or only excerpts, on (date based) Archive pages? Default: <strong>Only Excerpts</strong>."),

    array(    "name" => "Posts or excerpts on TAG pages?",
            "id" => $shortname."_excerpts_tag",
            "type" => "select",
            "std" => "Only Excerpts",
            "options" => array("Only Excerpts", "Full Posts"),
            "info" => "Show full posts or only excerpts, on Tag pages? Default: <strong>Only Excerpts</strong>."),
            
    array(    "name" => "Posts or excerpts on SEARCH RESULT pages?",
            "id" => $shortname."_excerpts_search",
            "type" => "select",
            "std" => "Only Excerpts",
            "options" => array("Only Excerpts", "Full Posts"),
            "info" => "Show full posts or only excerpts, on Search Result pages? Default: <strong>Only Excerpts</strong>."),

     array(    "name" => "Layout min width",
            "id" => $shortname."_min_width",
            "std" => "800",
            "type" => "text",
            "info" => "The width (in pixels) at which the layout will stop shrinking, and start to show a horizontal scrollbar instead. Default: <strong>800</strong>. <br /><br /><strong>As a rough estimate, this value should be approx. (width of your widest image) + 420 pixels</strong>, IF you use the default setup with 2 sidebars, each 15em wide. How to find the optimal min-width: Surf to a post or page with your biggest image, resize your browser window so that the image barely fits into the main column, estimate the current browser viewport width based on your screen size (i.e. current browser window width 3/4 of a 1280 pixels monitor = around 960 pixels), and add 50 or so pixels to be sure (IE6 will start dropping a little before the other browsers start overlapping).<br /><br /><em>This setting is needed mainly for IE6 because it will drop the sidebars below the main column, if you have images in the main column that are too big for the browser viewport (screen width) of a given visitor. This setting will benefit other browsers too, because otherwise, an image that is too big would overlap parts of the right sidebar if the browser viewport is too small for the given image. </em> "),
                                           
     array(    "name" => "Left sidebar width",
            "id" => $shortname."_leftcolumn_width",
            "std" => "15",
            "type" => "text",
            "info" => "Numbers between 10-25 make sense. Default: <strong>15</strong>. Put 0 here to make the left sidebar dissapear. You'll have a 2 column layout then."),
                                                           
     array(    "name" => "Right sidebar width",
            "id" => $shortname."_rightcolumn_width",
            "std" => "15",
            "type" => "text",
            "info" => "Numbers between 10-25 make sense. Default: <strong>15</strong>. Put 0 here to make the right sidebar dissapear. You'll have a 2 column layout then."),

    array(    "name" => "Allow comments on \"Page\" pages, too?",
            "id" => $shortname."_comments_on_pages",
            "type" => "select",
            "std" => "No",
            "options" => array("No", "Yes"),
            "info" => "Set to Yes to have a comment form (and comments if any) on \"Page\" pages, too, and not only on Post pages. Default: <strong>No</strong>."),

     array(    "name" => "Copyright start year",
           "id" => $shortname."_copyright_start_year",
            "std" => "",
            "type" => "text",
            "info" => "Start year for copyright notice at bottom of page: &copy; <strong>XXXX</strong> - [current year]. (The current year will be included automatically). Default: <strong>blank</strong>.<br /><br /><em> Example: If you put <strong>2006</strong> into this field, then in 2008 it will read \"2006-2008\" on your page, and on 1-1-2009 it will change to \"2006-2009\", and so on... </em>"),
);

function mytheme_add_admin() {
    global $themename, $shortname, $options;
    if ( $_GET['page'] == basename(__FILE__) ) {
        if ( 'save' == $_REQUEST['action'] ) {
                foreach ($options as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
                foreach ($options as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
                header("Location: themes.php?page=functions.php&saved=true");
                die;
        } else if( 'reset' == $_REQUEST['action'] ) {
            foreach ($options as $value) {
                delete_option( $value['id'] ); }
            header("Location: themes.php?page=functions.php&reset=true");
            die;
        }
    }
    add_theme_page($themename." Options", "Atahualpa Theme Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}
function mytheme_admin() {
    global $themename, $shortname, $options;
    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>
<div class="wrap">
<h2><?php echo $themename; ?> settings</h2>
<form method="post">
<table class="optiontable">
<?php foreach ($options as $value) {
if ($value['type'] == "text") { ?>
<tr valign="top">
    <th scope="row"><?php echo $value['name']; ?>:</th>
    <td>
        <input <?php if (eregi("color", $value['id'])) { ?>class="color" <?php } ?>name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
    </td>
    <td>
    <?php echo $value['info']; ?>
    </td>
    </tr><tr><td colspan="3"><HR NOSHADE SIZE=20 color="#eee"></td>
</tr>
<?php } elseif ($value['type'] == "textarea") { ?>
<tr valign="top">
    <th scope="row"><?php echo $value['name']; ?>:</th>
    <td>
        <textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="30" rows="6"><?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?></textarea>
    </td>
    <td>
    <?php echo $value['info']; ?>
    </td>
    </tr><tr><td colspan="3"><HR NOSHADE SIZE=20 color="#eee"></td>
</tr>
<?php } elseif ($value['type'] == "select") { ?>
    <tr valign="top">
        <th scope="row"><?php echo $value['name']; ?>:</th>
        <td>
            <select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
                <?php foreach ($value['options'] as $option) { ?>
                <option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
                <?php } ?>
            </select>
        </td>
        <td>
        <?php echo $value['info']; ?>
        </td>
    </tr><tr><td colspan="3"><HR NOSHADE SIZE=20 color="#eee"></td>
    </tr>
<?php
}
}
?>
</table>
<p class="submit">
<input name="save" type="submit" value="Save changes" />    
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
<?php
}
add_action('admin_menu', 'mytheme_add_admin'); ?>
<?php
function is_last_post()
{
	global $wp_query;
	return ($wp_query->current_post == $wp_query->post_count - 1);
}
?>
<?php if (file_exists(ABSPATH."/wpmu-settings.php")) { ?>
<?php
function m_find_in_dir( $root, $pattern, $recursive = true, $case_sensitive = false ) {
    $result = array();
    if( $case_sensitive ) {
        if( false === m_find_in_dir__( $root, $pattern, $recursive, $result )) {
            return false;
        }
    } else {
        if( false === m_find_in_dir_i__( $root, $pattern, $recursive, $result )) {
            return false;
        }
    }
   
    return $result;
}

/**
 * @access private
 */
function m_find_in_dir__( $root, $pattern, $recursive, &$result ) {
    $dh = @opendir( $root );
    if( false === $dh ) {
        return false;
    }
    while( $file = readdir( $dh )) {
        if( "." == $file || ".." == $file ){
            continue;
        }
        if( false !== @ereg( $pattern, "{$root}/{$file}" )) {
            $result[] = "{$root}/{$file}";
        }
        if( false !== $recursive && is_dir( "{$root}/{$file}" )) {
            m_find_in_dir__( "{$root}/{$file}", $pattern, $recursive, $result );
        }
    }
    closedir( $dh );
    return true;
}

/**
 * @access private
 */
function m_find_in_dir_i__( $root, $pattern, $recursive, &$result ) {
    $dh = @opendir( $root );
    if( false === $dh ) {
        return false;
    }
    while( $file = readdir( $dh )) {
        if( "." == $file || ".." == $file ){
            continue;
        }
        if( false !== @eregi( $pattern, "{$root}/{$file}" )) {
            $result[] = "{$root}/{$file}";
        }
        if( false !== $recursive && is_dir( "{$root}/{$file}" )) {
            m_find_in_dir__( "{$root}/{$file}", $pattern, $recursive, $result );
        }
    }
    closedir( $dh );
    return true;
}
?>     
<?php } ?>