<?php

/**
* Include and setup custom metaboxes and fields.
*
* @category Landingpage Rockstar
* @package Metaboxes
* @license http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
* @link https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
*/

add_filter( 'cmb_meta_boxes', 'lprockstar_metaboxes' );
/**
* Define the metabox and field configurations.
*
* @param array $meta_boxes
* @return array
*/

function lprockstar_metaboxes( array $meta_boxes ) {

    // Include & setup custom metabox and fields
    $prefix = '_lprs_';
    $meta_boxes = array();

    $meta_boxes[] = array(
        'id' => 'theme_metabox',
        'title' => __( 'Landing Page Theme', 'cmb' ),
        'pages' => array('landingpage'), // post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name'       => __( 'Choose Your Theme', 'cmb' ),
                'desc'       => __( 'field description (optional)', 'cmb' ),
                'id' => $prefix . 'themeoption',
                'type' => 'theme_choice',
                'theme' => '0',
                'std' => 'landing-page-rockstar/landertemplates/template-1_1.php'
            )
        )
    );

    $meta_boxes[] = array(
        'id' => 'app_metabox',
        'title' => __( 'Landing Page Content', 'cmb' ),
        'pages' => array('landingpage'), // post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name'       => __( 'Warning', 'cmb' ),
                'desc'       => __( 'Top Warning Line (required)', 'cmb' ),
                'id' => $prefix . 'warning',
                'type' => 'text_medium',
                'theme' => '0',
                'showfor' => '1_3' // only show for 1_3
            ),
            array(
                'name'       => __( 'Main Headline', 'cmb' ),
                'desc'       => __( 'Your primary headline.', 'cmb' ),
                'id' => $prefix . 'headline',
                'type' => 'text_medium',
                'theme' => '0'
            ),
            array(
                'name'       => __( 'Headline Color', 'cmb' ),
                'desc'       => __( 'Your primary headline color.', 'cmb' ),
                'id' => $prefix . 'headline_color',
                'type' => 'colorpicker',
                'show_names' => 'no',
                'theme' => '0'
            ),
            array(
                'name'       => __( 'Sub-Headline', 'cmb' ),
                'desc'       => __( 'field description (optional)', 'cmb' ),
                'id' => $prefix . 'subhead',
                'type' => 'text_medium',
                'theme' => '0',
                'hidefor' => '1_7'
            ),
            array(
                'name'       => __( 'Sub headline Color', 'cmb' ),
                'desc'       => __( 'Your sub headline color.', 'cmb' ),
                'id' => $prefix . 'subhead_color',
                'type' => 'colorpicker',
                'show_names' => 'no',
                'theme' => '0',
                'hidefor' => '1_7'
            ),
            array(
                'name'       => __( 'Main Content Area', 'cmb' ),
                'desc'       => __( '', 'cmb' ),
                'id' => $prefix . 'wysiwyg',
                'type' => 'wysiwyg',
                'theme' => '0',
                'display' => 'toggle',
                'hidefor' => '1_2 1_3 3_1 3_2',
                'default' => '<p>This is the beginning of the main content. You should include 2 or 3 sentences to hook the reader, then use the bullet points to explain some of the benefits of your offer...</p><ul><li>Bullet List Of Features &amp; Benefits</li><li>Bullet List Of Features &amp; Benefits</li><li>Bullet List Of Features &amp; Benefits</li></ul><p>After the list, make sure you quickly mention a call to action such as "Fill out the form to get instant access!"'
            ),
            array(
                'name'       => __( 'Product Image', 'cmb' ),
                'desc'       => __( 'Your Main Product Image', 'cmb' ),
                'id' => $prefix . 'product_image',
                'type' => 'file',
                'theme' => '0',
                'display' => 'toggle',
                'showfor' => '4_1'
            ),
            array(
                'id'          => $prefix . 'testimonials',
                'type'        => 'group',
                'description' => __( 'Testimonials', 'cmb2' ),
                'options'     => array(
                    'group_title'   => __( 'Testimonial {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
                    'add_button'    => __( 'Add Another Testimonial', 'cmb2' ),
                    'remove_button' => __( 'Remove Testimonial', 'cmb2' ),
                    'sortable'      => true, // beta
                ),
                'fields'      => array(
                    array(
                        'name'       => 'Testimonial',
                        'id' => 'testimonial_text',
                        'type' => 'textarea_small'
                    ),
                    array(
                        'name'       => 'Testimonial Name',
                        'id' => 'testimonial_name',
                        'type' => 'text_medium'
                    ),
                    array(
                        'name'       => 'Testimonial Image',
                        'id' => 'testimonial_image',
                        'type' => 'file'
                    )
                )
            ),
            array(
                'id'          => $prefix . 'features',
                'type'        => 'group',
                'description' => __( 'Features', 'cmb2' ),
                'options'     => array(
                    'group_title'   => __( 'Feature {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
                    'add_button'    => __( 'Add Another Feature', 'cmb2' ),
                    'remove_button' => __( 'Remove Feature', 'cmb2' ),
                    'sortable'      => true, // beta
                ),
                'fields'      => array(
                    array(
                        'name'       => 'Feature Headline',
                        'id' => 'feature_headline',
                        'type' => 'text_medium'
                    ),
                    array(
                        'name'       => 'Feature Description',
                        'id' => 'feature_copy',
                        'type' => 'textarea_small'
                    )
                )
            ),
            array(
                'name'       => __( 'Social Proof Headline', 'cmb' ),
                'desc'       => __( 'Social Proof Headline (Optional)', 'cmb' ),
                'id' => $prefix . 'socialheadline',
                'type' => 'text_medium',
                'theme' => '0',
                'display' => 'toggle_start',
                'showfor' => '1_4 1_5 3_2 3_4'
            ),
            array(
                'id'          => $prefix . 'socialimages',
                'type'        => 'group',
                'description' => __( 'Social Proof Images (NOTE: transparent PNG files work best)', 'cmb2' ),
                'options'     => array(
                    'group_title'   => __( 'Social Image {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
                    'add_button'    => __( 'Add Another Image', 'cmb2' ),
                    'remove_button' => __( 'Remove Image', 'cmb2' ),
                    'sortable'      => true, // beta
                ),
                'fields'      => array(
                    array(
                        'name'       => 'Social Image',
                        'id' => 'image_image',
                        'type' => 'file'
                    )
                )
            ),
            array(
                'name'       => __( 'Below Content', 'cmb' ),
                'desc'       => __( 'Content below the main content and optin form (optional)', 'cmb' ),
                'id' => $prefix . 'below_content',
                'type' => 'wysiwyg',
                'theme' => '0',
                'display' => 'toggle',
                'hidefor' => '1_2 1_3 3_2 1_7'
            ),
            array(
                'name'       => __( 'Video Code', 'cmb' ),
                'desc'       => __( 'Copy/Paste your video embed code here.', 'cmb' ),
                'id' => $prefix . 'video',
                'type' => 'textarea_small',
                'theme' => '0',
                'display' => 'toggle',
                'showfor' => '3_1 3_2 3_4 3_3',
                'sanitization_cb' => false
            )
        )
    );
    
    $meta_boxes[] = array(
        'id' => 'optin_metabox',
        'title' => 'Web Form Options',
        'pages' => array('landingpage'),
        'context' => 'normal',
        'priority' => 'low',
        'show_names' => true,
        'fields' => array(
            array(
                'name'       => __( 'Webform Embed Code', 'cmb' ),
                'desc'       => __( 'Copy/Paste your optin form code here (from Aweber/Mailchimp etc.)', 'cmb' ),
                'id' => $prefix . 'optin',
                'type' => 'textarea_small',
                'theme' => '0',
                'display' => 'toggle',
                'sanitization_cb' => false
            ),
            array(
                'name'       => __( 'Web Form Headline', 'cmb' ),
                'desc'       => __( 'Primary Optin Headline (optional but highly recommended)', 'cmb' ),
                'id' => $prefix . 'optin_headline',
                'type' => 'text_medium',
                'theme' => '0',
                'display' => 'toggle',
                'std' => 'Get Instant Access!'
            ),
            array(
                'name'       => __( 'Web Form Subheadline', 'cmb' ),
                'desc'       => __( 'Secondary Optin Headline (optional).', 'cmb' ),
                'id' => $prefix . 'optin_subhead',
                'type' => 'text_medium',
                'theme' => '0',
                'display' => 'toggle',
                'std' => 'Fill Out The Form Below:',
                'hidefor' => '1_2 1_7'
            ),
            array(
                'name'       => __( 'Web Form Description', 'cmb' ),
                'desc'       => __( 'Web Form Description - Why should someone fill out this form?', 'cmb' ),
                'id' => $prefix . 'optin_description',
                'type' => 'textarea_small',
                'theme' => '0',
                'display' => 'toggle',
                'std' => 'You will join our weekly newsletter that is packed with great information. You can unsubscribe at any time with just one click.',
                'showfor' => '4_1'
            ),
            array(
                'name'       => __( 'Call To Action Button Text', 'cmb' ),
                'desc'       => __( 'What will your call to action say?', 'cmb' ),
                'id' => $prefix . 'optin_submit',
                'type' => 'text_medium',
                'theme' => '0',
                'display' => 'toggle',
                'std' => 'Give Me Access'
            ),
            array(
                'name'       => __( 'Call to action note (Privacy Statement)', 'cmb' ),
                'desc'       => __( 'Text directly below the submit button (optional).', 'cmb' ),
                'id' => $prefix . 'optin_submit_note',
                'type' => 'text_medium',
                'theme' => '0',
                'display' => 'toggle'
            )
         )
     );

    $meta_boxes[] = array(
        'id' => 'opp_metabox',
        'title' => 'Landing Page Advanced Options',
        'pages' => array('landingpage'), // post type
        'context' => 'normal',
        'priority' => 'low',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name'       => __( 'Logo', 'cmb' ),
                'desc'       => __( 'If you\'d like to have a logo on your landing page, upload it here.', 'cmb' ),
                'id' => $prefix . 'logo',
                'type' => 'file',
                'display' => 'toggle'
            ),
            array(
                'name'       => __( 'Background Colour', 'cmb' ),
                'desc'       => __( 'Choose a custom landing page background colour.', 'cmb' ),
                'id' => $prefix . 'bg_colour',
                'type' => 'colorpicker',
                'display' => 'toggle'
            ),
            array(
                'name'       => __( 'Font Choices', 'cmb' ),
                'desc'       => __( 'Choose your main landing page font.', 'cmb' ),
                'id' => $prefix . 'main_font',
                'type' => 'select',
                'options' => array(
                      'Roboto'            => __( 'Roboto', 'cmb'),
                      'Roboto Slab'       => __( 'Roboto Slab', 'cmb'),
                      'arial'             => __( 'Arial', 'cmb'),
                      'Roboto Condensed'  => __( 'Roboto Condensed', 'cmb'),
                      'Impact'            => __( 'Impact', 'cmb'),
                      'Verdana'           => __( 'Verdana', 'cmb'),
                      'Georgia'           => __( 'Georgia', 'cmb')
                      ),
                'display' => 'toggle_start'
            ),
            array(
                'name'       => __( 'Headline Fonts', 'cmb' ),
                'desc'       => __( 'Choose your main headline font.', 'cmb' ),
                'id' => $prefix . 'headline_font',
                'type' => 'select',
                'options' => array(
                      'Roboto'            => __( 'Roboto', 'cmb'),
                      'Roboto Slab'       => __( 'Roboto Slab', 'cmb'),
                      'arial'             => __( 'Arial', 'cmb'),
                      'Roboto Condensed'  => __( 'Roboto Condensed', 'cmb'),
                      'Impact'            => __( 'Impact', 'cmb'),
                      'Verdana'           => __( 'Verdana', 'cmb'),
                      'Georgia'           => __( 'Georgia', 'cmb')
                      ),
                'display' => 'toggle_middle',
                'show_names' => 'no'
            ),
            
            array(
                'name'       => __( 'Headline Fonts', 'cmb' ),
                'desc'       => __( 'Choose your sub headline font.', 'cmb' ),
                'id' => $prefix . 'sub_headline_font',
                'type' => 'select',
                'options' => array(
                      'Roboto'            => __( 'Roboto', 'cmb'),
                      'Roboto Slab'       => __( 'Roboto Slab', 'cmb'),
                      'arial'             => __( 'Arial', 'cmb'),
                      'Roboto Condensed'  => __( 'Roboto Condensed', 'cmb'),
                      'Impact'            => __( 'Impact', 'cmb'),
                      'Verdana'           => __( 'Verdana', 'cmb'),
                      'Georgia'           => __( 'Georgia', 'cmb')
                      ),
                'display' => 'toggle_end',
                'show_names' => 'no'
            ),
            array(
                'name'       => __( 'Custom Styles', 'cmb' ),
                'desc'       => __( 'If you would like to add additional CSS code, enter it here.', 'cmb' ),
                'id' => $prefix . 'cstyles',
                'type' => 'textarea',
                'display' => 'toggle'
            ),
            array(
                'name'       => __( 'Header Code', 'cmb' ),
                'desc'       => __( 'If you would like to add additional CSS code, enter it here.', 'cmb' ),
                'id' => $prefix . 'head_code',
                'type' => 'textarea',
                'display' => 'toggle'
            ),
            array(
                'name'       => __( 'Footer Code', 'cmb' ),
                'desc'       => __( 'If you would like to add additional CSS code, enter it here.', 'cmb' ),
                'id' => $prefix . 'foot_code',
                'type' => 'textarea',
                'display' => 'toggle'
            )
        )
    );
    
    return $meta_boxes;
    
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );

/**
* Initialize the metabox class.
*/
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'includes/init.php';

}