<?php
/* Do not access this file directly */
if ( ! defined( 'WPINC' ) ) { die; }

// Create Settings Page
class WESS_Settings {

  public $page = 'wess_page';
  public $section = 'wess_section';
  public $options_group = 'wess_section';
  public $title = 'WP Easy Social Sharing';


  public function __construct() {
    // Load the Script needed for the settings screen.
		add_action( 'admin_enqueue_scripts', array($this, 'settings_scripts'));

    // Add submenu setting page
    add_action('admin_menu', array($this, 'menu_settings'));

		// Register Settings and Fields
		add_action( 'admin_init', array($this, 'register_settings'));
  }

  public function settings_scripts( $hook_suffix ) {
      wp_enqueue_style( 'wp-color-picker' );
      wp_enqueue_script( 'my-script-handle', WESS_URI . '/assets/js/admin.js', array( 'wp-color-picker' ), false, true );
  }

  public function register_settings() {
    add_settings_section(
      $this->section,
      $this->title,
      null,
      $this->page
    );

  	add_settings_field(
      'wess_socmed_field',
      'Select the buttons to be activated',
      array($this, 'wess_socmed_field'),
      $this->page,
      $this->section
    );
  	add_settings_field(
      'wess_background_color_field',
      'Choose custom color for background',
      array($this, 'wess_background_color_field'),
      $this->page,
      $this->section
    );
  	add_settings_field(
      'wess_size_field',
      'Choose icons size',
      array($this, 'wess_size_field'),
      $this->page,
      $this->section
    );
  	add_settings_field(
      'wess_style_field',
      'Choose preference style',
      array($this, 'wess_style_field'),
      $this->page,
      $this->section
    );

  	register_setting($this->options_group, 'wess_facebook');
  	register_setting($this->options_group, 'wess_twitter');
  	register_setting($this->options_group, 'wess_linkedin');
  	register_setting($this->options_group, 'wess_background_color');
  	register_setting($this->options_group, 'wess_background_color_activation');
  	register_setting($this->options_group, 'wess_size');
  	register_setting($this->options_group, 'wess_style');
  }

  public function menu_settings() {
    add_submenu_page(
      "options-general.php",
      $this->title,
      $this->title,
      "manage_options",
      $this->page,
      array($this, "wess_settings_page")
    );
  }

  public function wess_settings_page() {
    echo '
    <div class="wrap">
      <h1>Social Sharing Options</h1>
      <form method="post" action="options.php">';

        settings_fields($this->section);
        do_settings_sections($this->page);
        submit_button();

    echo '
      </form>
    </div>';
  }

  public function wess_socmed_field() {
  	echo '
    <div style="display:inline-flex;flex-flow:column">
      <span>
        <input type="checkbox" name="wess_facebook" value="1"' . checked(1, get_option('wess_facebook'), false) . '/> Facebook
      </span>
      <span>
        <input type="checkbox" name="wess_twitter" value="1"' . checked(1, get_option('wess_twitter'), false) . '/> Twitter
      </span>
      <span>
        <input type="checkbox" name="wess_linkedin" value="1"' . checked(1, get_option('wess_linkedin'), false) . '/> Linkedin
      </span>
    </div>';
  }

  public function wess_background_color_field() {
  	echo '
    <div style="display:inline-flex;flex-flow:column">
      <input class="my-color-field" name="wess_background_color" type="text" value="' . get_option('wess_background_color') . '" data-default-color="#effeff" />
      <span>
        <input type="checkbox" name="wess_background_color_activation" value="1"' . checked(1, get_option('wess_background_color_activation'), false) . '/> Activated
      </span>
    </div>';
  }

  public function wess_size_field() {
  	echo '
    <select name="wess_size">
      <option value="small"' . selected(get_option('wess_size'), "small", false) . '>Small</option>
      <option value="medium"' . selected(get_option('wess_size'), "medium", false) . '>Medium</option>
      <option value="large"' . selected(get_option('wess_size'), "large", false) . '>Large</option>
    </select>';
  }

  public function wess_style_field() {
  	echo '
    <select name="wess_style">
      <option value="basic"' . selected(get_option('wess_style'), "basic", false) . '>Basic</option>
      <option value="slide"' . selected(get_option('wess_style'), "slide", false) . '>Slide</option>
      <option value="fade"' . selected(get_option('wess_style'), "fade", false) . '>fade</option>
    </select>';
  }
}
?>
