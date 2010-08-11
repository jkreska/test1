<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>

			<p class="nocomments">This post is password protected. Enter the password to view comments.<p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

<div class="comments" id="comments">

<?php if ($comments) : ?>
<h3><img src="<?php bloginfo('template_url')?>/images/flag.png" alt="tag" /><?php comments_number('Be the first!', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</h3>
	<ol>

	<?php foreach ($comments as $comment) : ?>

		<div id="spacer"><li class="<?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
			<div id="avatar"><?php if(function_exists('get_avatar')){ echo get_avatar($comment, '34'); } ?></div>
			<strong><?php comment_author_link() ?></strong> Said,
			<?php if ($comment->comment_approved == '0') : ?>
			<p><em>Your comment is awaiting moderation.</em></p>
			<?php endif; ?>
            <br />
            <small class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('F jS, Y') ?> at <?php comment_time() ?></a> <img src="<?php bloginfo('template_url'); ?>/images/edit.png" alt="edit" /><?php edit_comment_link(' edit','&nbsp;&nbsp;',''); ?></small>
			<?php comment_text() ?>

		</li></div>

	<?php /* Changes every other comment to a different class */
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post->comment_status) : ?>

<h2 id="respond">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add A Comment</h2>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <img src="<?php bloginfo('template_url')?>/images/logout.png" alt="logout" /><a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account"> Logout &raquo;</a></p>

<?php else : ?>

<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" /> <label for="author"><small>Name <?php if ($req) echo "(required)"; ?></small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" /> <label for="email"><small>Mail (will not be published) <?php if ($req) echo "(required)"; ?></small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /> <label for="url"><small>Website</small></label></p>

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
<p>
<?php if ($post->ping_status == "open") { ?>
	<span><img src="<?php bloginfo('template_url')?>/images/trackback.png" alt="trackback" /> <a href="<?php trackback_url(display); ?>"><?php _e('Trackback URI', 'ml'); ?></a></span> |
<?php } ?>
<?php if ($post-> comment_status == "open") {?>
	<span><img src="<?php bloginfo('template_url')?>/images/rsscomment.png" alt="rsscomment" /> <?php comments_rss_link(__('Comments RSS', 'ml')); ?></span>
<?php }; ?>
</p>
<p><input name="submit" type="submit" id="submit" tabindex="5" value="Say It!" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>

</div>