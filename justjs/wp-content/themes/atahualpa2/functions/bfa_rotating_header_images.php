<?php
global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>
<?php

if (file_exists(ABSPATH."/wpmu-settings.php")) {

	################### images in WP upload folder (on WPMU)
	
	$header_images_in_wp_upload_folder = m_find_in_dir(get_option('upload_path'),
		'atahualpa_header_[0-9]+\.(jpe?g|png|gif|bmp)$');

	if ($header_images_in_wp_upload_folder) {
		shuffle($header_images_in_wp_upload_folder);
		$selected_header_image = array_shift($header_images_in_wp_upload_folder);
		$selected_header_image = str_replace(get_option('upload_path'),
		get_option('fileupload_url'), $selected_header_image); 
		}

} else {
		
	################### images in /images/header/

	$files = "";
	$imgpath = TEMPLATEPATH . '/images/header/';
	$imgdir = get_bloginfo('template_directory') . '/images/header/';
	$dh  = opendir($imgpath);

	while (false !== ($filename = readdir($dh))) {
		if(eregi('.jpg', $filename) || eregi('.gif', $filename) || eregi('.png', $filename)) {
	   $files[] = $filename;
	   }
	}
	closedir($dh);

	/* Generate a random number */
	$amount_images = count($files);
	$number_images = ($amount_images-1);
	$randnum = rand(0,$number_images);

	/* print the result */
	$selected_header_image = $imgdir . $files[$randnum];

}
?>