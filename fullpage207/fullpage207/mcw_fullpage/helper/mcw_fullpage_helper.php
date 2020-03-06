<?php
/*
Plugin Name: FullPage for WPBakery Page Builder Helper
Plugin URI: https://www.meceware.com/fp/
Author: Mehmet Celik
Author URI: https://www.meceware.com/
Version: 1.0.1
Description: FullPage for WPBakery Page Builder helper functionality template
Text Domain: mcw_fullpage_helper
*/

/* Copyright 2017-2019 Mehmet Celik */

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}

function mcw_fullpage_helper_check() {
  // Check should be done here
  return false; // true
}

// Add script files before fullpage
add_filter('mcw_fp_enqueue', 'mcw_fullpage_helper_on_fp_enqueue', 10, 2);
function mcw_fullpage_helper_on_fp_enqueue($dep, $isFooter) {
  wp_enqueue_script( 'mcw_your_js_file_id', plugins_url('/js/your_js_file.js', __FILE__), array('jquery'), '1.0.0', $isFooter );
  $dep[] = 'mcw_your_js_file_id';

  return $dep;
}

// Change parameters filter
add_filter('mcw_fp_parameters', 'mcw_fullpage_helper_on_fp_parameters');
function mcw_fullpage_helper_on_fp_parameters($parameters) {
  if (mcw_fullpage_helper_check() && isset($parameters)) {
    // Change $parameters
  }

  return $parameters;
}

// Change templates filter
add_filter('mcw_fp_template', 'mcw_fullpage_helper_on_fp_template');
function mcw_fullpage_helper_on_fp_template($path) {
  if (mcw_fullpage_helper_check()) {
    // Add this if template is used. Otherwise, this hook can be removed.
    $path = plugin_dir_path(__FILE__).'template/mcw_fullpage_template.php';
  }
  return $path;
}

// Add post types filter
add_filter('mcw_fp_post_types', 'mcw_fullpage_helper_on_fp_post_types');
function mcw_fullpage_helper_on_fp_post_types($post_types) {
  $post_types[] = 'post';
  return array_unique($post_types);
}

// Change any parameter filter
add_filter('mcw_fp_field_mcw_fp_enable', 'mcw_fullpage_helper_on_fp_field_mcw_fp_enable');
function mcw_fullpage_helper_on_fp_field_mcw_fp_enable($val) {
  if (isset($val) && ($val == 'on')) {
    if (!mcw_fullpage_helper_check()) {
      $val = 'off';
    }
  }

  return $val;
}
