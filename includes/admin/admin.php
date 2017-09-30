<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class fp_forum_Options {
  
    /*--------------------------------------------*
     * Attributes
     *--------------------------------------------*/
  
    /** Refers to a single instance of this class. */
    private static $instance = null;
     
    /* Saved options */
    public $options;
  
    /*--------------------------------------------*
     * Constructor
     *--------------------------------------------*/
  
    /**
     * Creates or returns an instance of this class.
     *
     * @return  CPA_Theme_Options A single instance of this class.
     */
    public static function get_instance() {
  
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
  
        return self::$instance;
  
    } // end get_instance;
  
    /**
     * Initializes the plugin by setting localization, filters, and administration functions.
     */
    private function __construct() { 

    	// Add the page to the admin menu
	    add_action( 'admin_menu', array( &$this, 'add_page' ) );
	     
	    // Register page options
	    add_action( 'admin_init', array( &$this, 'register_page_options') );
	     
	    // Css rules for Color Picker
	    wp_enqueue_style( 'wp-color-picker' );
	     
	    // Register javascript
	    add_action('admin_enqueue_scripts', array( $this, 'enqueue_admin_js' ) );
	     
	    // Get registered option
	    $this->options = get_option( 'fp_forums_settings_options' );

    }
  
    /*--------------------------------------------*
     * Functions
     *--------------------------------------------*/
      
    /**
     * Function that will add the options page under Setting Menu.
     */
    public function add_page() { 

    	// $page_title, $menu_title, $capability, $menu_slug, $callback_function
    	add_options_page( 'Forums', 'Forums', 'manage_options', __FILE__, array( $this, 'display_page' ) );

    }
      
    /**
     * Function that will display the options page.
     */
    public function display_page() { 

    	?>
    <div class="wrap">
     
        <h2>Forum Settings</h2>
        <form method="post" action="options.php">     
        <?php 
            settings_fields(__FILE__);      
            do_settings_sections(__FILE__);
            submit_button();
        ?>
        </form>
    </div> <!-- /wrap -->
    <?php    

    }
       
    /**
     * Function that will register admin page options.
     */
    public function register_page_options() { 

    	// Add Section for option fields
	    add_settings_section( 'fp_colour_section', 'Forum Colour Settings', array( $this, 'display_section' ), __FILE__ ); // id, title, display cb, page
	     
	    // Add Background Color Field
	    add_settings_field( 'fp_bg_field', 'Forum Container Background Color', array( $this, 'fp_bg_settings_field' ), __FILE__, 'fp_section' ); // id, title, display cb, page, section

	    // Add Background Color Field
	    add_settings_field( 'fp_home_bg_field', 'Forum Home Button Background Color', array( $this, 'fp_home_bg_settings_field' ), __FILE__, 'fp_section' ); // id, title, display cb, page, section

	    // Add Background Color Field
	    add_settings_field( 'fp_breadcrumb_bg_field', 'Forum Breadcrumb Background Color', array( $this, 'fp_breadcrumb_bg_settings_field' ), __FILE__, 'fp_section' ); // id, title, display cb, page, section

	    // Add Background Color Field
	    add_settings_field( 'fp_category_bg_field', 'Forum category Background Color', array( $this, 'fp_category_bg_settings_field' ), __FILE__, 'fp_section' ); // id, title, display cb, page, section

	    // Add Background Color Field
	    add_settings_field( 'fp_category_bg_field', 'Forum category Background Color', array( $this, 'fp_category_bg_settings_field' ), __FILE__, 'fp_section' ); // id, title, display cb, page, section
	     
	    // Register Settings
	    register_setting( __FILE__, 'fp_settings_options', array( $this, 'validate_options' ) ); // option group, option name, sanitize cb 

    }
     
    /**
     * Function that will add javascript file for Color Piker.
     */
    public function enqueue_admin_js() { 

    	// Make sure to add the wp-color-picker dependecy to js file
    	wp_enqueue_script( 'cpa_custom_js', plugins_url( 'jquery.custom.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), '', true  );

    }
     
    /**
     * Function that will validate all fields.
     */
    public function validate_options( $fields ) { 

    	$valid_fields = array();
     
	    // Validate Title Field
	    $title = trim( $fields['title'] );
	    $valid_fields['title'] = strip_tags( stripslashes( $title ) );
	     
	    // Validate Background Color
	    $background = trim( $fields['background'] );
	    $background = strip_tags( stripslashes( $background ) );
	     
	    // Check if is a valid hex color
	    if( FALSE === $this->check_color( $background ) ) {
	     
	        // Set the error message
	        add_settings_error( 'cpa_settings_options', 'cpa_bg_error', 'Insert a valid color for Background', 'error' ); // $setting, $code, $message, $type
	         
	        // Get the previous valid value
	        $valid_fields['background'] = $this->options['background'];
	     
	    } else {
	     
	        $valid_fields['background'] = $background;  
	     
	    }
	     
	    return apply_filters( 'validate_options', $valid_fields, $fields);

    }
     
    /**
     * Function that will check if value is a valid HEX color.
     */
    public function check_color( $value ) { 

    	if ( preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) { // if user insert a HEX color with #     
	        return true;
	    }
	     
	    return false;

    }
     
    /**
     * Callback function for settings section
     */
    public function display_section() { /* Leave blank */ } 
     
    /**
     * Functions that display the fields.
     */
    public function title_settings_field() { 

    	$val = ( isset( $this->options['title'] ) ) ? $this->options['title'] : '';
    	echo '<input type="text" name="fp_settings_options[title]" value="' . $val . '" />';

    }   
     
    public function fp_bg_settings_field( ) { 

    	$val = ( isset( $this->options['title'] ) ) ? $this->options['background'] : '';
    	echo '<input type="text" name="fp_bg_settings_field[background]" value="' . $val . '" class="cpa-color-picker" data-default-color
="#ECF0F1" >';

    }

    public function fp_home_bg_settings_field( ) { 

    	$val = ( isset( $this->options['title'] ) ) ? $this->options['background'] : '';
    	echo '<input type="text" name="fp_home_bg_settings_field[background]" value="' . $val . '" class="cpa-color-picker" data-default-color
="#ECF0F1" >';

    }
         
} // end class
  
fp_forum_Options::get_instance();

?>