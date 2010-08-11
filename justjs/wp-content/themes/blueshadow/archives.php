<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
<?php get_sidebar(); ?>

	<div id="content">

		<div class="post">

			<div class="entry">

				<h1>Monthly Archives</h1>
				<ul>
					<?php wp_get_archives('type=monthly'); ?>
				</ul>

				<h1>Archives By Categorie:</h1>
				<ul>
					 <?php wp_list_categories(); ?>
				</ul>
                                 <h1>Tag Cloud:</h1>
<ul>
<li><?php wp_tag_cloud(); ?></li>
<!-- <?php wp_tag_cloud('smallest=11&largest=24&'); ?> -->
</ul>

			</div>
		</div>

	</div>



<?php get_footer(); ?>