<?php
/*
Plugin Name: Landing Page Rockstar
Plugin URI: http://www.lprockstar.com
Description: Easily create Wordpress landing pages and optin pages for your website.
Version: 0.2
Author: Eric Sloan
Author URI: http://www.ericsestimate.com
License: GPL2

    Copyright 2013  Eric Sloan  (email : eric@ericsestimate.com)

    This software is released under GPL. Once purchased feel free to modify it as you see fit.
    If you end up using some of my code a quick mention of me is very appreciated :)
    
    Special thanks to:
    
    Wordpress.org
    The fine folks who wrote the meta box script:
    Andrew Norcross (@norcross / andrewnorcross.com)
    Jared Atchison (@jaredatch / jaredatchison.com)
    Bill Erickson (@billerickson / billerickson.net)
    Justin Sternberg (@jtsternberg / dsgnwrks.pro)

*/

// add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'audio', 'chat', 'video')); // Add 3.1 post format theme support.

include("includes/themeoptions.php");

//include("example-functions.php");

include("includes/metaboxes.php");

include("metabox/init.php");

//require_once('wp-updates-plugin.php');
//new WPUpdatesPluginUpdater_347( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__));

// Change landing page title text
add_action( 'gettext', 'crm_change_title_text' );
function crm_change_title_text( $translation ) {
	global $post;
	if( isset( $post ) ) {
		switch( $post->post_type ){
			case 'landingpage' :
				if( $translation == 'Enter title here' ) return 'Enter Landing Page Name Here';
			break;
		}
	}
	return $translation;
}
function dashboard_widget_function() {
	echo file_get_contents('http://www.lprockstar.com/includefiles/generalad.php');
}
function add_dashboard_widgets() {
	wp_add_dashboard_widget('dashboard_widget', 'Landing Page Rockstar', 'dashboard_widget_function');
}
add_action('wp_dashboard_setup', 'add_dashboard_widgets' );

// Add Default Content To Landing Page Editor

add_filter( 'default_content', 'my_editor_content', 10, 2 );

function my_editor_content( $content, $post ) {

    switch( $post->post_type ) {
        case 'landingpage':
            $content = '<p>This is the beginning of the main content. You should include 2 or 3 sentences to hook the reader, then use the bullet points to explain some of the benefits of your offer...</p><ul><li>Bullet List Of Features &amp; Benefits</li><li>Bullet List Of Features &amp; Benefits</li><li>Bullet List Of Features &amp; Benefits</li></ul><p>After the list, make sure you quickly mention a call to action such as "Fill out the form to get instant access!"';
        break;
    }

    return $content;
}

// Used to get the custom fields

/* Get Post Meta Shorthand */
function get_custom_field($field) {
	global $post;
	$value = get_post_meta($post->ID, $field, true);
	if ($value) {
    if (is_array($value)) return $value;
    else return esc_attr( $value );
	} else {
    return false;
  }
}

function get_landingpage_header($templateid,$headercode,$customstyles,$title) {

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
    
        <?php if($headercode) echo htmlspecialchars_decode (html_entity_decode ($headercode), ENT_QUOTES); ?>
        <?php $options = get_option('plugin_options'); ?>
        <?php if($options["header_code"]) echo htmlspecialchars_decode (html_entity_decode ($options["header_code"]), ENT_QUOTES); ?>
    
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo strip_tags($title); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        
        <?php wp_head(); ?>

        <link rel="stylesheet" href="<?php echo plugins_url(); ?>/landing-page-rockstar/landertemplates/css/normalize.css">
        <link rel="stylesheet" href="<?php echo plugins_url(); ?>/landing-page-rockstar/landertemplates/css/main.css">
        <link rel="stylesheet" href="<?php echo plugins_url(); ?>/<?php echo substr($templateid,0,strpos($templateid,"template-")); ?>css/<?php echo substr($templateid,strpos($templateid,"template-"),-4); ?>.css">
        
         <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
        
        
          <style type="text/css">
            <?php if($customstyles) echo $customstyles; ?>             
               
          </style>
        
    </head>
    <body>

<?php

}

function get_landingpage_footer($footercode) {

?>

  <?php echo htmlspecialchars_decode (html_entity_decode ($footercode), ENT_QUOTES); ?>
  <?php $options = get_option('plugin_options'); ?>
  <?php if($options['include_lprs'] == True || !isset($options['include_lprs'])) : ?><div id="ct_poweredby">Powered by <a href="http://www.lprockstar.com" rel="nofollow" target="_blank">Landing Page Rockstar</a></div><?php endif; ?>
  <?php wp_footer(); ?>
  <?php if($options["footer_code"]) echo htmlspecialchars_decode (html_entity_decode ($options["footer_code"]), ENT_QUOTES); ?>
  </body>
  </html>
  
<?php

}

// Styling for the custom post type icon

add_action( 'admin_head', 'wpt_lprs_icons' );

function wpt_lprs_icons() {
    ?>
    <style type="text/css" media="screen">
      #menu-posts-landingpage .wp-menu-image {background: url(<?php echo plugins_url(); ?>/landing-page-rockstar/lprs-icon.png) no-repeat 0px 0px !important;}
          #menu-posts-landingpage .wp-menu-image:before {content: normal!important;}
    </style>
<?php }

// Let's flush this bitch (permalinks)

function flush_this_bitch() {
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'flush_this_bitch' );

$testvar = 'test';

// Add custom post types to homepage options

add_filter( 'get_pages',  'add_cpt' );

function add_cpt( $pages )
{
     $cpt_pages = new WP_Query( array( 'post_type' => 'landingpage' ) );
     if ( $cpt_pages->post_count > 0 )
     {
         $pages = array_merge( $pages, $cpt_pages->posts );
     }
     return $pages;
}


/*
 * Function creates post duplicate as a draft and redirects then to the edit post screen
 */
function rd_duplicate_post_as_draft(){
	global $wpdb;
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die('No post to duplicate has been supplied!');
	}
 
	/*
	 * get the original post id
	 */
	$post_id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );
 
	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;
 
	/*
	 * if post data exists, create the post duplicate
	 */
	if (isset( $post ) && $post != null) {
 
		/*
		 * new post data array
		 */
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);
 
		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );
 
		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ($taxonomies as $taxonomy) {
			$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
			wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
		}
 
		/*
		 * duplicate all post meta
		 */
		$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
		if (count($post_meta_infos)!=0) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ($post_meta_infos as $meta_info) {
				$meta_key = $meta_info->meta_key;
				$meta_value = addslashes($meta_info->meta_value);
				$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query.= implode(" UNION ALL ", $sql_query_sel);
			$wpdb->query($sql_query);
		}
 
 
		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die('Post creation failed, could not find original post: ' . $post_id);
	}
}
add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
 
/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {
  if($post->post_type == "landingpage") {
    if (current_user_can('edit_posts')) {
      $actions['duplicate'] = '<a href="admin.php?action=rd_duplicate_post_as_draft&amp;post=' . $post->ID . '" title="Duplicate this item" rel="permalink">Copy</a>';
    }
    return $actions;
  }
}
 
add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );

function lprs_beta_notice() {

  if($_GET['post_type'] == "landingpage") {
  
  print_r($post);
  
    $class = "error";
    $message = "Error in saving";
          echo"<div class=\"$class\">" .
               "<p><strong>Please Note:</strong> This is a beta testing version of this plugin. Therefore there may be some bugs that you come across. Please report any bugs through my <a href='http://www.ericsestimate.com/contact-eric/'>contact form here</a>.</p>" . 
               "<p>Your feedback will help me to improve the plugin in future releases!</p>" . 
               "</div>"; 
               
   }
   
}
add_action( 'admin_notices', 'lprs_beta_notice' );