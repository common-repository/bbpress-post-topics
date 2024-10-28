<?php

function bbppt_settings_page()
{
global $bbppt_settings;
	?>
	<Form method="post" action="options.php">
	<?php wp_nonce_field( 'settings', 'settings-nonce' ) ?>
	<?php settings_fields( 'bbppt_settings' );
	?>	
	
	<div class="wrap">
		<div id="upb-wrap" class="upb-help">
			<h2><?php _e('bbp Topics for Posts Settings', 'bbpress-post-topics'); ?></h2>
			<?php
			if ( ! isset( $_REQUEST['updated'] ) )
				$_REQUEST['updated'] = false;
			?>
			<?php if ( false !== $_REQUEST['updated'] ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'Settings saved', 'bbpress-post-topics'); ?> ); ?></strong></p></div>
			<?php endif; ?>
			
			
			<?php
			 _e('The settings for this plugin are held in dashboard>settings>discussion - click ' , 'bbpress-post-topics'); 
			echo '<a href="' . admin_url( 'options-discussion.php#disallowed_keys' ) . '">' ;
			_e('here' , 'bbpress-post-topics'); 
			
			echo '</a>' ;
			
			
}


// register the plugin settings
function bbppt_register_settings() {

	register_setting( 'bbppt_settings', 'bbppt_settings' );
}
	
//call register settings function
add_action( 'admin_init', 'bbppt_register_settings' );

function bbppt_settings_menu() {
	//allows filter for which capability can access the settings page - default = 'manage_options'
	$cap = apply_filters('bbppt_plugin_settings_capability','manage_options');
	// add settings page
	add_submenu_page('options-general.php', __('bbp Topics for Posts', 'bbpress-post-topics'), __('bbp Topics for Posts', 'bbpress-post-topics'), $cap, 'bbp-topics-for-posts-settings', 'bbppt_settings_page');
}
add_action('admin_menu', 'bbppt_settings_menu');

?>
			
						
		