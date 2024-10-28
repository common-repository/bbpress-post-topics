<?php
add_action ('plugins_loaded' , 'bbppt_add_custom_post_type') ;

function bbppt_add_custom_post_type() {
		//add to eligible post types
	add_filter( 'bbppt_eligible_post_types', 'bbppt_add_post_types');
		//add to exclude options
	add_filter( 'bbppt_ex_options', 'bbppt_add_ex_options');
		//add to default options
	add_filter( 'bbppt_ex_options_default', 'bbppt_add_default_options');
		//add to discussion_defaults
	add_action ('bbppt_discussion_defaults' , 'bbppt_add_discussion_defaults', 10 , 2 ) ;
	add_action ('bbppt_discussion_apply' , 'bbppt_add_discussion_apply', 10 , 2 ) ;
	//}
}

function bbppt_add_post_types ($content) {
//see which exist in wp_option bbpress_discussion_defaults
$defaults = get_option ('bbpress_discussion_defaults') ;
$types = bbppt_get_cpt()  ;
foreach ($types as $type) {
	if (!empty ($defaults['post_type_'.$type]) ) array_push($content, $type); 
	}
return $content; 
}

function bbppt_add_ex_options ($ex_options) { 
	$cpts = bbppt_get_cpt() ;
	foreach ($cpts as $type) {
		$ex_options['post_type_'.$type] = false ;
	}
return $ex_options; 
}

function bbppt_add_default_options ($ex_options) { 
	$cpts = bbppt_get_cpt() ;
	foreach ($cpts as $type) {
	$ex_options['post_type_'.$type] = '' ;
	}
return $ex_options; 
}


function bbppt_add_discussion_defaults ($ex_options, $forum_select_string) {
	$defaults = get_option ('bbpress_discussion_defaults') ;
	$cpts = bbppt_get_cpt() ;
	foreach ($cpts as $type) {
		$bbppt_post_type_name = bbppt_get_custom_post_type_name ($type);
		$checked = (!empty($ex_options['post_type_'.$type]) ? $ex_options['post_type_'.$type] : 0);
		?>
		<input type="checkbox" name="bbpress_discussion_defaults[post_type_<?php echo esc_attr($type); ?>]" id="bbpress_discussion_defaults_post_type_<?php echo esc_attr($type); ?>" <?php checked($checked,'on') ?>>

			<label for="bbpress_discussion_defaults_post_type_<?php echo esc_attr($bbppt_post_type_name) ?>"><?php echo 'Do this for new '.esc_attr($bbppt_post_type_name); ?>  </label> 

				<br />	
	<?php
		} //end foreach
}
function bbppt_add_discussion_apply ($apply, $ex_options) {
	$cpts = bbppt_get_cpt() ;
	foreach ($cpts as $type) {
		$bbppt_post_type_name = bbppt_get_custom_post_type_name ($type) ;
		$display = (!empty($ex_options['post_type_'.$type]) ? $ex_options['post_type_'.$type] : 0);
		if ($display === 'on') $apply.=' and '.$bbppt_post_type_name ;
	}
	
return $apply ;
}

function bbppt_get_custom_post_type_name ($type) {
	global $wp_post_types;
	$pt = $wp_post_types[$type];
	if (!empty ($pt->labels->name)) $bbppt_post_type_name = $pt->labels->name ;
	else $bbppt_post_type_name = 'Custom Post Type' ;
return $bbppt_post_type_name ;
}


function bbppt_get_cpt()  {
	//get ALL custom post types
		$args = array(
       'public'   => true,
       '_builtin' => false,
    );
	$post_types = get_post_types( $args); 
	
	//remove the bbpress post types
	unset ($post_types['topic']) ;
	unset ($post_types['reply']) ;
	unset ($post_types['forum']) ;
	
return $post_types ;
}

