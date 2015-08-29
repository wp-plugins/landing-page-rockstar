<?php

// add the options page to the menu
add_action('admin_menu' , 'register_lp_options'); 
function register_lp_options() {
    add_submenu_page('edit.php?post_type=landingpage', 'Landing Page Options', 'Landing Page Options', 'edit_posts', basename(__FILE__), 'build_lprs_options');
}

// let's register and build these fields
add_action('admin_init', 'register_and_build_fields');
function register_and_build_fields() {   
    register_setting('plugin_options', 'plugin_options', 'validate_setting');
    add_settings_section('main_section', 'Universal Landing Page Settings', 'section_cb', __FILE__);
    add_settings_field('include_lprs', 'Include Landing Page Rockstar Link:', 'include_lprs', __FILE__, 'main_section');
    add_settings_field('privacy_statement', 'Privacy Statement:', 'privacy_statement', __FILE__, 'main_section');
    add_settings_field('header_code', 'Header Code:', 'header_code', __FILE__, 'main_section');
    add_settings_field('footer_code', 'Footer Code:', 'footer_code', __FILE__, 'main_section');
    //add_settings_field('logo', 'Logo:', 'logo_setting', __FILE__, 'main_section'); // LOGO
}

// settings callbacks
function include_lprs() {  
    $options = get_option('plugin_options');  
    if($options['include_lprs'] == True || !isset($options['include_lprs'])) {
      echo "<input name='plugin_options[include_lprs]' type='hidden' value='0' />";
      echo "<input name='plugin_options[include_lprs]' type='checkbox' checked='checked' />";
    } else {
      echo "<input name='plugin_options[include_lprs]' type='hidden' value='0' />";
      echo "<input name='plugin_options[include_lprs]' type='checkbox' />";
    }
}

function privacy_statement() {  
    $options = get_option('plugin_options');
    $thisoption = htmlspecialchars($options['privacy_statement'], ENT_QUOTES);
    echo "<input name='plugin_options[privacy_statement]' type='text' value='{$thisoption}' />";
}

function header_code() {  
    $options = get_option('plugin_options');
    $thisoption = htmlspecialchars($options['header_code'], ENT_QUOTES);
    echo "<p><em>Any extra code you want to appear in the <head> section of every landing page (This is a good place to put your analytics code).</em></p>";
    echo "<textarea name='plugin_options[header_code]'>{$thisoption}</textarea>";
}

function footer_code() {  
    $options = get_option('plugin_options');
    $thisoption = htmlspecialchars($options['footer_code'], ENT_QUOTES);
    echo "<p><em>Any extra code you want to appear below all of the content on every landing page (This is a good place to put any tracking pixels).</em></p>";
    echo "<textarea name='plugin_options[footer_code]'>{$thisoption}</textarea>";
}

function logo_setting() {  echo '<input type="file" name="logo" />';}

// core functions of options page
function validate_setting($plugin_options) {  
  $keys = array_keys($_FILES); 
  $i = 0; 
  foreach ( $_FILES as $image ) {   
    // if a files was upload   
    if ($image['size']) {     
      // if it is an image     
      if ( preg_match('/(jpg|jpeg|png|gif)$/', $image['type']) ) {       
          $override = array('test_form' => false);       
          // save the file, and store an array, containing its location in $file       
          $file = wp_handle_upload( $image, $override );       
          $plugin_options[$keys[$i]] = $file['url'];
      } else {       
          // Not an image.        
          $options = get_option('plugin_options');       
          $plugin_options[$keys[$i]] = $options[$logo];       
          // Die and let the user know that they made a mistake.       
          wp_die('No image was uploaded.');
      }
    } else {
      // Else, the user didn't upload a file.   
      // Retain the image that's already on file.   
      $options = get_option('plugin_options');     
      $plugin_options[$keys[$i]] = $options[$keys[$i]];   
    }   
    $i++; 
  } 
  return $plugin_options;
}
function section_cb() {} // remove a thrown error

// build the options page
function build_lprs_options() { ?>

    <div class="wrap">
    
        <style type="text/css">
        
          textarea {width: 500px; height: 200px;}
          #ct_options_form {max-width: 800px;}
        
        </style>

        <h2>Landing Page Rockstar Options</h2>     
        
        <p>Thank you for using Landing Page Rockstar. Below are the universal settings for the plugin.</p>

        <form id="ct_options_form" method="post" action="options.php" enctype="multipart/form-data">

            <?php settings_fields('plugin_options'); ?>
            <?php do_settings_sections(__FILE__); ?>
            <p class="submit">
                <input type="submit" class="button-primary" value="Save Changes" />
            </p>

        </form>

    </div>

<?php }