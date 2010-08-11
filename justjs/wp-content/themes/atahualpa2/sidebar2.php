<?php
global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>

<?php if ($ata_rightcolumn_width != 0) { ?>

			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>

			<?php wp_list_bookmarks('categorize=1&category_before=&category_after=&title_before=<h3 class="widgettitle">&title_after=</h3>'); ?>
			
			<h3 class="widgettitle">Meta</h3>
			<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
			</ul>
			
			<?php endif; ?>
			
<?php } ?>