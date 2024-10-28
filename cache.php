<?php

/*

adds cache refresh to the plugin

if using caching software, there is nothing to recognise that a post or page has changed when a reply is submitted.

This code adds a cache purge for w3 total cache and wp-rocket

*/

add_action ('plugins_loaded', 'bbppt_check_cache') ;

function bbppt_check_cache () {
	//see if either wp-rocket or w3 total cache are running
	if (function_exists('rocket_clean_post') || function_exists('w3tc_flush_post') ) {
		add_action( 'bbp_new_reply_post_extras', 'bbppt_purge_cache_reply' );
		add_action( 'bbp_edit_reply_post_extras', 'bbppt_purge_cache_reply' );
		add_action ('bbp_new_topic_post_extras' , 'bbppt_purge_cache_topic' ) ;
		add_action ('bbp_edit_topic_post_extras' , 'bbppt_purge_cache_topic' ) ;
	}
}

function bbppt_purge_cache_reply ($reply_id) {
	$topic_id = bbp_get_reply_topic_id ($reply_id) ;
	bbppt_purge_cache_topic ($topic_id) ;
}

function bbppt_purge_cache_topic ($topic_id) {
	$purge_posts = get_posts(
				array(
					'post_type'		=> apply_filters( 'bbppt_eligible_post_types', array( 'post', 'page' ) ),
					'meta_key'		=> 'bbpress_discussion_topic_id',
					'meta_value'	=> $topic_id
				)
	);
			
	if ( $purge_posts ) {
		foreach ($purge_posts as $purge_post) {
			if (function_exists ('rocket_clean_post'))rocket_clean_post ($purge_post->ID) ;
			if (function_exists ('w3tc_flush_post'))w3tc_flush_post ($purge_post->ID) ;
		}
	}
}