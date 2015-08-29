<?php

/**
 * Add all of the additional functionality for the theme
 *
 * The first section adds the theme options page and includes the markup
 */

function ctheme_admin_enqueue_scripts ($hook_suffix) {
		wp_enqueue_script( 'jquery-ui-core' ); // Make sure and use elements form the 1.7.3 UI - not 1.8.9
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'thickbox' );
		wp_register_script( 'cmb-scripts', get_bloginfo('stylesheet_directory').'/metabox/jquery.cmbScripts.js', array('jquery','media-upload','thickbox'));
		wp_enqueue_script( 'cmb-scripts' );
		wp_enqueue_style( 'thickbox' );
		wp_enqueue_style( 'jquery-custom-ui' );
		add_action( 'admin_head', 'ctheme_styles_inline' );
}
add_action( 'admin_print_styles-appearance_page_theme_options', 'ctheme_admin_enqueue_scripts' );

function ctheme_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === ctheme_get_theme_options() )
		add_option( 'ctheme_theme_options', ctheme_get_default_theme_options() );

	register_setting(
		'ctheme_options',       // Options group, see settings_fields() call in theme_options_render_page()
		'ctheme_theme_options', // Database option, see ctheme_get_theme_options()
		'ctheme_theme_options_validate' // The sanitization callback, see ctheme_theme_options_validate()
	);
	
}
add_action( 'admin_init', 'ctheme_theme_options_init' );



function ctheme_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_ctheme_options', 'ctheme_option_page_capability' );

function ctheme_color_schemes() {
	$color_scheme_options = array(
		'light' => array(
			'value' => 'light',
			'label' => __( 'Light', 'ctheme' ),
			'thumbnail' => get_template_directory_uri() . '/inc/images/light.png',
			'default_link_color' => '#1b8be0',
		),
		'dark' => array(
			'value' => 'dark',
			'label' => __( 'Dark', 'ctheme' ),
			'thumbnail' => get_template_directory_uri() . '/inc/images/dark.png',
			'default_link_color' => '#e4741f',
		),
	);
	return apply_filters( 'ctheme_color_schemes', $color_scheme_options );
}


function ctheme_layouts() {
	$layout_options = array(
		'content-sidebar' => array(
			'value' => 'content-sidebar',
			'label' => __( 'Content on left', 'ctheme' ),
			'thumbnail' => get_template_directory_uri() . '/inc/images/content-sidebar.png',
		),
		'sidebar-content' => array(
			'value' => 'sidebar-content',
			'label' => __( 'Content on right', 'ctheme' ),
			'thumbnail' => get_template_directory_uri() . '/inc/images/sidebar-content.png',
		),
		'content' => array(
			'value' => 'content',
			'label' => __( 'One-column, no sidebar', 'ctheme' ),
			'thumbnail' => get_template_directory_uri() . '/inc/images/content.png',
		),
	);

	return apply_filters( 'ctheme_layouts', $layout_options );
}
	
	
function ctheme_get_default_link_color( $color_scheme = null ) {
	if ( null === $color_scheme ) {
		$options = ctheme_get_theme_options();
		$color_scheme = $options['color_scheme'];
	}

	$color_schemes = ctheme_color_schemes();
	if ( ! isset( $color_schemes[ $color_scheme ] ) )
		return false;

	return $color_schemes[ $color_scheme ]['default_link_color'];
}



/**
 * Returns the default options for LP Rockstar
 *
 */
function ctheme_get_default_theme_options() {
	$default_theme_options = array(
		'color_scheme' => 'light',
		'link_color'   => ctheme_get_default_link_color( 'light' ),
		'theme_layout' => 'content-sidebar',
	);

	if ( is_rtl() )
 		$default_theme_options['theme_layout'] = 'sidebar-content';

	return apply_filters( 'ctheme_default_theme_options', $default_theme_options );
}


function ctheme_get_theme_options() {
	return get_option( 'ctheme_theme_options', ctheme_get_default_theme_options() );
}


/*
 * BUILD THE FREAKING PAGE!
 */

//require_once('optionspage.php');


function ctheme_enqueue_color_scheme() {
	$options = ctheme_get_theme_options();
	$color_scheme = $options['color_scheme'];

	if ( 'dark' == $color_scheme )
		wp_enqueue_style( 'dark', get_template_directory_uri() . '/colors/dark.css', array(), null );

	do_action( 'ctheme_enqueue_color_scheme', $color_scheme );
}
add_action( 'wp_enqueue_scripts', 'ctheme_enqueue_color_scheme' );


/**
 * The below code adds all of the functionality for landing pages
 *
 */

add_action('init', 'codex_custom_init');
function codex_custom_init() 
{
  $labels = array(
    'name' => _x('Landing Pages', 'post type general name'),
    'singular_name' => _x('Landing Page', 'post type singular name'),
    'add_new' => _x('Add New', 'Landing Page'),
    'add_new_item' => __('Add New Landing Page'),
    'edit_item' => __('Edit Landing Page'),
    'new_item' => __('New Landing Page'),
    'all_items' => __('All Landing Pages'),
    'view_item' => __('View Landing Page'),
    'search_items' => __('Search Landing Pages'),
    'not_found' =>  __('No Landing Pages found'),
    'not_found_in_trash' => __('No Landing Pages found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Landing Pages'

  );
  
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array('slug'=>'lp','with_front'=>false),
    'capability_type' => 'page',
    'taxonomies' => array('category'),
    'has_archive' => true,
    'exclude_from_search' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','page-attributes','thumbnail')
  ); 
  register_post_type('landingpage',$args);
}

// remove meta boxes for landing pages

add_action( 'admin_menu' , 'crm_remove_page_fields' );
function crm_remove_page_fields() {
	remove_meta_box( 'commentstatusdiv' , 'landingpage' , 'normal' ); //removes comments status
	remove_meta_box( 'commentsdiv' , 'landingpage' , 'normal' ); //removes comments
	remove_meta_box( 'postexcerpt' , 'landingpage' , 'normal' );
	remove_meta_box( 'trackbacksdiv' , 'landingpage' , 'normal' );
	remove_meta_box( 'authordiv' , 'landingpage' , 'normal' );
	remove_meta_box( 'postcustom' , 'landingpage' , 'normal' );
	remove_meta_box( 'revisionsdiv'	, 'landingpage' , 'normal' );
	remove_meta_box( 'tagsdiv-post_tag', 'landingpage', 'normal' );
}


//add filter to ensure the text Landing Page, or Landing Page, is displayed when user updates a Landing Page 
add_filter('post_updated_messages', 'lander_updated_messages');
function lander_updated_messages( $messages ) {
  global $post, $post_ID;

  $messages['landingpage'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Landing Page updated. <a href="%s">View landing page</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Landing Page updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Landing page restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Landing Page published. <a href="%s">View Landing Page</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Landing Page saved.'),
    8 => sprintf( __('Landing Page submitted. <a target="_blank" href="%s">Preview Landing Page</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Landing Page scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Landing Page</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Landing Page draft updated. <a target="_blank" href="%s">Preview Landing Page</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

//display contextual help for Landing Pages
add_action( 'contextual_help', 'ctheme_add_help_text', 10, 3 );

function ctheme_add_help_text($contextual_help, $screen_id, $screen) { 
  //$contextual_help .= var_dump($screen); // use this to help determine $screen->id
  if ('landingpage' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a Landing Page:') . '</p>' .
      '<ul>' .
      '<li>' . __('Specify a category and a group if you intend on split testing the campaign.') . '</li>' .
      '<li>' . __('Make sure to preview your landing pages before publishing') . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to schedule the Landing Page review to be published in the future:') . '</p>' .
      '<ul>' .
      '<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
      '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.') . '</li>' .
      '</ul>' .
      '<p><strong>' . __('For more information:') . '</strong></p>' .
      '<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>') . '</p>' .
      '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>' ;
  } elseif ( 'edit-landingpage' == $screen->id ) {
    $contextual_help = 
      '<p>' . __('This is the help screen displaying the table of landing pages blah blah blah.') . '</p>' ;
  }
  return $contextual_help;
}


// Create landing page taxonomies
add_action( 'init', 'create_lp_taxonomies', 0 );

// create new taxonomy for split test grouping
function create_lp_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Groups', 'taxonomy general name' ),
		'singular_name'     => _x( 'Group', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Groups' ),
		'all_items'         => __( 'All Groups' ),
		'parent_item'       => __( 'Parent Group' ),
		'parent_item_colon' => __( 'Parent Group:' ),
		'edit_item'         => __( 'Edit Group' ),
		'update_item'       => __( 'Update Group' ),
		'add_new_item'      => __( 'Add New Group' ),
		'new_item_name'     => __( 'New Group Name' ),
		'menu_name'         => __( 'Group' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => false,
	);
	
	register_taxonomy( 'group', 'landingpage', $args );
	
}


// REDIRECT TEMPLATE FILE FOR CUSTOM LANDING PAGE TEMPLATES

add_action("template_redirect", 'my_theme_redirect');

function my_theme_redirect() {
    global $wp;
    $plugindir = dirname(dirname( __FILE__ ));

    //A Specific Custom Post Type
    if ($wp->query_vars["post_type"] == 'landingpage') {
        $templatefilename = 'single-landingpage.php';
        if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
            $return_template = TEMPLATEPATH . '/' . $templatefilename;
        } else {
            $return_template = $plugindir . '/' . $templatefilename;
        }
        do_theme_redirect($return_template);
    }
        
}

function do_theme_redirect($url) {
    global $post, $wp_query;
    if (have_posts()) {
        include($url);
        die();
    } else {
        $wp_query->is_404 = true;
    }
}

// Remove all of the plugin filters from the_content()
function landingpage_remove_plugin_filters() {
    global $wp_filter;
    global $wp;
    if ($wp->query_vars["post_type"] == 'landingpage') {
        remove_all_filters('the_content', 'plugin_filters');
        add_filter('the_content', 'do_shortcode');
    }
}   

// Remove all filters added to wp_head
add_action('wp','landingpage_remove_head_filters');
function landingpage_remove_head_filters() {
  global $wp;
  if ($wp->query_vars["post_type"] == 'landingpage') {
      //remove_filter('wp_head','twentytwelve_header_style');
      remove_all_filters('wp_head');
  }
}

// Remove all filters added to wp_footer
add_action('wp','landingpage_remove_footer_filters');
function landingpage_remove_footer_filters() {
  global $wp;
  if ($wp->query_vars["post_type"] == 'landingpage') {
      //remove_filter('wp_head','twentytwelve_header_style');
      remove_all_filters('wp_footer');
  }
}

require_once("optionspage.php");