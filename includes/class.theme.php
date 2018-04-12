<?php if ( !class_exists('theme') ) {
  class theme {
    function __construct( &$menus, &$post_types, &$resources, &$sidebars, &$supports, &$taxonomies, &$custom ) {
      $menus = array(
        'main'   => 'Main',
      );
      
      $post_types = array(
        'report' => array(
          'menu_icon' => 'dashicons-portfolio',
          'query' => array(
            'posts_per_page' => '-1',
            'meta_key' => 'date',
            'orderby' => 'meta_value',
            'order' => 'DESC',
          ),
        )
      );
      
      $resources = array(
        'min' => false,
        'css' => array(
          'main'   => true,
          'gf-fix' => array('deps' => array('gforms_ready_class_css','gforms_formsmain_css')),
        ),
        'js'  => array(
          'fontawesome-all.min' => array('defer' => 'true'),
          'site' => array('deps' => array('jquery')),
        )
      );
    }
    
    // Hooks : Actions
      public function actions() {
        add_action('init', array($this, 'action_init'));
        // add_action('acf/init', array($this, 'action_acf_init'));
        add_action('wp_head', array($this, 'action_wp_head'), 100);
        
        add_action('wp_login_failed', array($this, 'action_wp_login_failed'), 10, 1);
        add_action('after_password_reset', array($this, 'action_after_password_reset'), 10, 1);
        
        add_action ('wp_loaded', array($this, 'update_sponsor_profile'));
        
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
      }
      public function action_init() {
        if ( !is_admin() ) {}
      }
      public function action_acf_init() {
        acf_update_setting('google_api_key', $this->filter_google_maps_key());
      }
      public function action_wp_head() {}
      
    // Hooks : Filters
      public function filters() {
        add_filter('gform_ajax_spinner_url', array($this, 'filter_gf_spinner_replace'), 10, 2 );
        add_filter('gform_enable_field_label_visibility_settings', '__return_true');
      }
      public function filter_gf_spinner_replace( $image_src, $form ) {
        return  'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'; // relative to you theme images folder
      }
			public function action_wp_login_failed( $username ) {
				$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
			   // if there's a valid referrer, and it's not the default log-in screen
			   if ( !empty($referrer) && !strstr($referrer, 'wp-login') && !strstr($referrer, 'wp-admin') ) {
			      wp_redirect( $referrer . '?login=failed' );
			      exit;
			   }
			}
      public function update_sponsor_profile() {
        if( is_user_logged_in() ) {
          require_once(THEME.'/includes/update-profile.php');
        }
      }
			public function action_after_password_reset() {
				// Redirects the user back to the My Account page once they have set a new password.
				wp_redirect(home_url('/'));
				exit;
			}
      

      
    // Functions : Theme
      public static function filter_google_maps_key() {
        return 'AIzaSyCu3jVAEVx9LcgCJ9vt4Ux1Q0LuHJH0Dfg'; // Parapxl Clients Key for Small Sites Only
      }
      public static function humanize_number($value) {
        $abbreviations = array(12 => 'T', 9 => 'B', 6 => 'M', 3 => 'k', 0 => '');
        foreach($abbreviations as $exponent => $abbreviation) {
          if($value >= pow(10, $exponent)) {
            $abbrnum = floatval($value / pow(10, $exponent));
            if($abbrnum > 99){
              return round($abbrnum).$abbreviation;
            } elseif ($abbrnum > 9){
              // return it with one decimal
              return (round($abbrnum*10)/10).$abbreviation;
            } else {
              // return it with two decimal
              return (round($abbrnum*100)/100).$abbreviation;
            }
            
          }
        }
      }
  }
  
  // Hide admin bar for non admins
  if ( ! current_user_can( 'manage_options' ) ) {
      show_admin_bar( false );
  }
  
  include(THEME.'/includes/email_data.php');
  
  // ACF Options
  if( function_exists('acf_add_options_page') ) {
    acf_add_options_sub_page();
  }
  
}
