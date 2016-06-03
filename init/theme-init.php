<?php
// load the theme's framework
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'wf_plugin_activation' );
function wf_plugin_activation() {
  $plugins = array(
    array(
      'name'               => 'Beaver Builder',
      'slug'               => 'bb-plugin',
      'source'             => dirname( __FILE__ ) . '/plugins/bb-plugin.zip',
      'required'           => true,
      'external_url'       => '',
    ),
    array(
        'name'      => 'Timber',
        'slug'      => 'timber-library',
        'required'  => true,
    ),
    array(
      'name'               => 'Advanced Custom Fields Pro',
      'slug'               => 'advanced-custom-fields-pro',
      'source'             => dirname( __FILE__ ) . '/plugins/advanced-custom-fields-pro.zip',
      'required'           => true,
      'external_url'       => '',
    ),
  );

  $config = array(
    'default_path' => '',
    'menu'         => 'tgmpa-install-plugins',
    'has_notices'  => true,
    'dismissable'  => false,
    'dismiss_msg'  => '',
    'is_automatic' => true,
    'message'      => '',
    'strings'      => array(
      'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
      'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
      'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ),
      'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
      'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ),
      'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ),
      'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ),
      'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ),
      'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ),
      'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ),
      'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ),
      'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ),
      'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
      'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
      'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
      'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
      'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ),
      'nag_type'                        => 'updated'
    )
  );
  tgmpa( $plugins, $config );
}

// Theme support widget ID
function spice_get_widget_id($widget_instance) { 
  if ($widget_instance->number=="__i__"){
    echo "<p><strong>Widget ID is</strong>: Pls save the widget first!</p>";
  } else {
    echo "<p><strong>Widget ID is: </strong>" .$widget_instance->id. "</p>";
  }
}
add_action('in_widget_form', 'spice_get_widget_id');

/* Add custom new widget arena */
add_action( 'widgets_init', 'create_wf_Widget' );
function create_wf_Widget() {
  register_widget('wf_Widget');
}

class wf_Widget extends WP_Widget {
  /**
   * Setting widget: name, base ID
   */
  public function __construct() {
    $widget_ops = array(
      'classname' => 'wf_widget',
      'description' => __( 'Custom widget.' ),
      'customize_selective_refresh' => true,
    );
    $control_ops = array( 'width' => 400, 'height' => 350 );
    parent::__construct( 'wf_widget', __( 'WF Widget' ), $widget_ops, $control_ops );
  }
  /**
   * Show widget
   */
  public function widget( $args, $instance ) {
    $title    = apply_filters( 'widget_title', $instance['title'] );
    $message  = $instance['message'];
    echo $args['before_widget'];
    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
    echo $message;
    echo $args['after_widget'];
  }
  /**
   * save widget form
   */
  function update( $new_instance, $old_instance ) {
    // parent::update( $new_instance, $old_instance );
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['message'] = strip_tags( $new_instance['message'] );
    return $instance;
  }
  /**
   * Create form option for widget
   */
  function form( $instance ) {
    $title      = esc_attr( $instance['title'] );
    $message    = esc_attr( $instance['message'] );
    ?>
     
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id('message'); ?>"><?php _e('Simple Message'); ?></label> 
      <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>"><?php echo $message; ?></textarea>
    </p>
    <?php 
  }
}

// Set per page on each page
add_action( 'pre_get_posts',  'set_posts_per_page'  );
function set_posts_per_page( $query ) {

  global $wp_the_query;

  if ( (!is_admin()) && ( $query === $wp_the_query ) && ( $query->is_archive() ) ) {
    $query->set( 'posts_per_page', 1 );
  }

  return $query;
}

if ( ! class_exists( 'Timber' ) ) {
  add_action( 'admin_notices', function() {
    echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
  });
  return;
}

// Get custom function template with Timber
Timber::$dirname = array('templates', 'templates/pages', 'templates/layouts', 'templates/views');

function related($custom_cat) {
  global $post;
  $argss = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'ids');
  $terms = wp_get_post_terms( $post->ID, $custom_cat, $argss );
  $myposts = array(
    'showposts' => -1,
    'post_type' => 'any',
    'post__not_in' => array($post->ID),
    'tax_query' => array(
      array(
      'taxonomy' => $custom_cat,
      'field' => 'term_id',
      'terms' => $terms
      )
    )
  );  
  $loop_custom = Timber::get_posts($myposts);
  return $loop_custom;
}

function sidebar($name) {
  dynamic_sidebar($name);
  return;
}

function shortcode($name, $value) {
  echo do_shortcode('['.$name.' '.$value.']');
  return;
}

function acfwidget($name, $widgetid) {
  if (get_field($name, 'widget_'.$widgetid)) {
    echo get_field($name, 'widget_'.$widgetid);
  }
  return;
}

add_filter('timber_context', 'wf_twig_data');
function wf_twig_data($data){
  // Theme setting
  $logo = get_template_directory_uri().'/images/logo.png';
  $favicon = get_template_directory_uri().'/images/favicon.ico';

  $data['site_logo'] = new TimberImage($logo);
  $data['site_favicon'] = new TimberImage($favicon);
  $data['menu'] = new TimberMenu();
  $data['acf'] = get_field('test_acf', 'text-2');

  $data['related'] = TimberHelper::function_wrapper( 'related' );
  $data['sidebar'] = TimberHelper::function_wrapper( 'sidebar' );
  $data['shortcode'] = TimberHelper::function_wrapper( 'shortcode' );
  $data['acfwidget'] = TimberHelper::function_wrapper( 'acfwidget' );

  return $data;
}
?>