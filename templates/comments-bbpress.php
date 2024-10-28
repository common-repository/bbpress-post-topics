<?php
/**
 * The template for displaying a comment topic when the user has selected one.
 *
 */
?>
<div id="comments" class="comment-respond">
	<a name="respond"></a>
	<div class="entry-content">
		<?php do_action( 'bbp_template_before_single_topic' ); ?>
		<?php 
			global $bbp, $bbp_post_topics;
			
			/** Fix pagination for replies */
			/** removed in version 1.8.3 as it caused paginatiin to disappear - function is I think no longer required. */
			//add_filter( 'bbp_replies_pagination', 'bbppt_replies_pagination') ;
			
			if( is_object($bbp) && isset($bbp->shortcodes) ) {
				/** bbPress 2.0.x */
				echo $bbp->shortcodes->display_topic(array('id'=>$bbp_post_topics->topic_ID));
			} else {
				/** bbPress 2.1.x */
				echo bbpress()->shortcodes->display_topic(array('id'=>$bbp_post_topics->topic_ID));
			}
			
		?>
		<?php do_action( 'bbp_template_after_single_topic' ); ?>
	</div><!-- .entry-content -->
</div><!-- #comments -->
<?php
	/** Hide pagination and form when we are only displaying a certain number of posts */
	global $bbp_post_topics, $post;
	$settings = $bbp_post_topics->get_topic_options_for_post( $post->ID );
	if($settings['display'] == 'xreplies') {
		?>
		<style type="text/css">
			.bbp-pagination, .bbp-reply-form {
				display: none;
			}
		</style>
		<?php
	}
?>