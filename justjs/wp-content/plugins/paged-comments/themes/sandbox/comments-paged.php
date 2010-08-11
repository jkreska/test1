<?php
/*	modified for paging by Stephen Rider -- http://striderweb.com/
	1 July 2008
	based on comments.php from Sandbox theme version 1.5.2  */

	if ( 'comments-paged.php' == basename($_SERVER['SCRIPT_FILENAME']) )
		die ( 'Please do not load this page directly. Thanks!' );
?>
			<div id="comments">
<?php
	$req = get_option('require_name_email'); // Checks if fields are required. Thanks, Adam. ;-)
	if ( !empty($post->post_password) ) :
		if ( $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password ) :
?>
				<div class="nopassword"><?php _e('This post is protected. Enter the password to view any comments.', 'sandbox') ?></div>
			</div><!-- .comments -->
<?php
		return;
	endif;
endif;
?>
<?php if ( $comments ) : ?>
<?php global $sandbox_comment_alt ?>

<?php /* numbers of pings and comments */
$ping_count = $comment_count = 0;
foreach ( $comments as $comment )
//	get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
	++$comment_count;
?>
<?php if ( $comment_count ) : ?>
<?php $sandbox_comment_alt = 0 ?>

				<div id="comments-list" class="comments">
					<h3><?php comments_number('<span>No</span> Comments', '<span>One</span> Comment', '<span>%</span> Comments' ); ?></h3>

<!-- Comment page numbers -->
<?php if ($paged_comments->pager->num_pages() > 1): ?>
					<p class="comment-page-numbers"><?php _e("Pages:"); ?> <?php paged_comments_print_pages(); ?></p>
<?php endif; ?>
<!-- End comment page numbers -->
					<ol>
<?php foreach ($comments as $comment) : ?>
<?php // Because of the pagination, we can't separate Comments from Trackbacks....
// if ( get_comment_type() == "comment" ) : ?>
						<li id="comment-<?php comment_ID() ?>" class="<?php sandbox_comment_class() ?>">
							<div class="comment-number"><?php echo $comment_number; $comment_number += $comment_delta;?></div>
							<div class="comment-author vcard"><?php sandbox_commenter_link() ?></div>
							<div class="comment-meta"><?php printf(__('Posted %1$s at %2$s <span class="meta-sep">|</span> <a href="%3$s" title="Permalink to this comment">Permalink</a>', 'sandbox'),
										get_comment_date(),
										get_comment_time(),
										paged_comments_url('comment-'.get_comment_ID()) );
										edit_comment_link(__('Edit', 'sandbox'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
<?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'sandbox') ?>
							<?php comment_text() ?>
						</li>
<?php // endif; /* if ( get_comment_type() == "comment" ) */ ?>
<?php endforeach; ?>

					</ol>
<!-- Comment page numbers -->
<?php if ($paged_comments->pager->num_pages() > 1): ?>
					<p class="comment-page-numbers"><?php _e("Pages:"); ?> <?php paged_comments_print_pages(); ?></p>
<?php endif; ?>
<!-- End comment page numbers -->

				</div><!-- #comments-list .comments -->

<?php endif; /* if ( $comment_count ) */ ?>
<?php endif /* if ( $comments ) */ ?>
<?php if ( 'open' == $post->comment_status ) : ?>
				<div id="respond">
					<h3><?php _e('Post a Comment', 'sandbox') ?></h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
					<p id="login-req"><?php printf(__('You must be <a href="%s" title="Log in">logged in</a> to post a comment.', 'sandbox'),
					get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink() ) ?></p>

<?php else : ?>
					<div class="formcontainer">	
						<form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">

<?php if ( $user_ID ) : ?>
							<p id="login"><?php printf(__('<span class="loggedin">Logged in as <a href="%1$s" title="Logged in as %2$s">%2$s</a>.</span> <span class="logout"><a href="%3$s" title="Log out of this account">Log out?</a></span>', 'sandbox'),
								get_option('siteurl') . '/wp-admin/profile.php',
								wp_specialchars($user_identity, true),
								get_option('siteurl') . '/wp-login.php?action=logout&amp;redirect_to=' . get_permalink() ) ?></p>

<?php else : ?>

							<p id="comment-notes"><?php _e('Your email is <em>never</em> published nor shared.', 'sandbox') ?> <?php if ($req) _e('Required fields are marked <span class="required">*</span>', 'sandbox') ?></p>

							<div class="form-label"><label for="author"><?php _e('Name', 'sandbox') ?></label> <?php if ($req) _e('<span class="required">*</span>', 'sandbox') ?></div>
							<div class="form-input"><input id="author" name="author" type="text" value="<?php echo $comment_author ?>" size="30" maxlength="20" tabindex="3" /></div>

							<div class="form-label"><label for="email"><?php _e('Email', 'sandbox') ?></label> <?php if ($req) _e('<span class="required">*</span>', 'sandbox') ?></div>
							<div class="form-input"><input id="email" name="email" type="text" value="<?php echo $comment_author_email ?>" size="30" maxlength="50" tabindex="4" /></div>

							<div class="form-label"><label for="url"><?php _e('Website', 'sandbox') ?></label></div>
							<div class="form-input"><input id="url" name="url" type="text" value="<?php echo $comment_author_url ?>" size="30" maxlength="50" tabindex="5" /></div>

<?php endif /* if ( $user_ID ) */ ?>

							<div class="form-label"><label for="comment"><?php _e('Comment', 'sandbox') ?></label></div>
							<div class="form-textarea"><textarea id="comment" name="comment" cols="45" rows="8" tabindex="6"></textarea></div>

							<div class="form-submit"><input id="submit" name="submit" type="submit" value="<?php _e('Post Comment', 'sandbox') ?>" tabindex="7" accesskey="P" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></div>

							<?php do_action('comment_form', $post->ID); ?>

						</form><!-- #commentform -->
					</div><!-- .formcontainer -->
<?php endif /* if ( get_option('comment_registration') && !$user_ID ) */ ?>

				</div><!-- #respond -->
<?php endif /* if ( 'open' == $post->comment_status ) */ ?>

			</div><!-- #comments -->
