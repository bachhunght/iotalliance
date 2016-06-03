<?php
/*
 *  Author: Framework | @Framework
 *  URL: wordfly.com | @wordfly
 *  Custom functions, support, custom post types and more.
 */

// Theme setting
require_once('init/theme-init.php');
require_once('init/options/option.php');

// Custom for theme

function wf_conditional_scripts() {
  wp_register_script('script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0.0');
  wp_enqueue_script('script');
}
add_action('wp_print_scripts', 'wf_conditional_scripts');

function wf_styles() {
  wp_register_style('custom-style', get_template_directory_uri() . '/stylesheet/css/customs.css', array(), '1.0', 'all');
  wp_enqueue_style('custom-style');
}
add_action('wp_enqueue_scripts', 'wf_styles');

/* Enable Function */
// Theme support navigation
function wf_menu() {
  register_nav_menus();
}
add_action('init', 'wf_menu');

// Theme support custom logo
function wf_setup() {
  add_theme_support( 'custom-logo', array(
    'flex-width' => true,
  ) );
}
add_action( 'after_setup_theme', 'wf_setup' );

// Theme support post thumbnail
add_theme_support( 'post-thumbnails' );

/* Add Dynamic Siderbar */
if (function_exists('register_sidebar')) {
  // Define Sidebar Widget Area 1
  register_sidebar(array(
    'name' => __('Sidebar one'),
    'description' => __('Description for this widget-area...'),
    'id' => 'sidebar-1',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
}

/* Add custom post type */
/*function create_my_post_types() {
  register_post_type( 'movies', 
    array(
      'labels' => array(
        'name' => __( 'Movie' ),
        'singular_name' => __( 'Movie' )
      ),
      'supports' => array(
        'title',
        'editor',
        'thumbnail',
        'comments',
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
add_action( 'init', 'create_my_post_types' );

function create_custom_taxonomy() {
  $labels = array(
    'name' => 'Category Movie',
    'singular' => 'Category Movie',
    'menu_name' => 'Category Movie'
  );
  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => false,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );
  register_taxonomy('catmovie', 'movies', $args);
}
add_action( 'init', 'create_custom_taxonomy', 0 );*/
?>
