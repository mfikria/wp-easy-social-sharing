<?php
function wess_menu_item() {
	add_submenu_page("options-general.php", "WP Easy Social Sharing", "WP Easy Social Sharing", "manage_options", "wess", "wess_page");
}
add_action("admin_menu", "wess_menu_item");

function wess_page() {
	?>
	<div class="wrap">
		<h1>Social Sharing Options</h1>

		<form method="post" action="options.php">
			<?php
			settings_fields("wess_config_section");

			do_settings_sections("wess");

			submit_button();
			?>
		</form>
	</div>
	<?php
}

function wess_settings() {
	add_settings_section("wess_config_section", "", null, "wess");

	add_settings_field("wess_socmed_field", "Select the buttons to be activated", "wess_socmed_field", "wess", "wess_config_section");
	add_settings_field("wess_background_color_field", "Choose custom color for background", "wess_background_color_field", "wess", "wess_config_section");
	add_settings_field("wess_size_field", "Choose icons size", "wess_size_field", "wess", "wess_config_section");
	add_settings_field("wess_style_field", "Choose preference style", "wess_style_field", "wess", "wess_config_section");

	register_setting("wess_config_section", "wess_facebook");
	register_setting("wess_config_section", "wess_twitter");
	register_setting("wess_config_section", "wess_linkedin");
	register_setting("wess_config_section", "wess_background_color");
	register_setting("wess_config_section", "wess_background_color_activation");
	register_setting("wess_config_section", "wess_size");
	register_setting("wess_config_section", "wess_style");
}

function wess_socmed_field() {
	echo '<div style="display:inline-flex;flex-flow:column">';
	echo '<span><input type="checkbox" name="wess_facebook" value="1"' . checked(1, get_option('wess_facebook'), false) . '/> Facebook </span>';
	echo '<span><input type="checkbox" name="wess_twitter" value="1"' . checked(1, get_option('wess_twitter'), false) . '/> Twitter </span>';
	echo '<span><input type="checkbox" name="wess_linkedin" value="1"' . checked(1, get_option('wess_linkedin'), false) . '/> Linkedin </span>';
	echo '</div>';
}

function wess_background_color_field() {
	echo '<div style="display:inline-flex;flex-flow:column">';
	echo '<input class="my-color-field" name="wess_background_color" type="text" value="';
	echo get_option('wess_background_color');
	echo '" data-default-color="#effeff" />';
	echo '<span><input type="checkbox" name="wess_background_color_activation" value="1"' . checked(1, get_option('wess_background_color_activation'), false) . '/> Activated </span>';
	echo '</div>';
}

function wess_size_field() {
	echo '<select name="wess_size">
    <option value="small"' . selected(get_option('wess_size'), "small", false) . '>Small</option>
    <option value="medium"' . selected(get_option('wess_size'), "medium", false) . '>Medium</option>
    <option value="large"' . selected(get_option('wess_size'), "large", false) . '>Large</option>
  </select>';
}

function wess_style_field() {
	echo '<select name="wess_style">
    <option value="basic"' . selected(get_option('wess_style'), "basic", false) . '>Basic</option>
    <option value="slide"' . selected(get_option('wess_style'), "slide", false) . '>Slide</option>
    <option value="fade"' . selected(get_option('wess_style'), "fade", false) . '>fade</option>
  </select>';
}

add_action("admin_init", "wess_settings");

function mw_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugins_url('/assets/js/admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );

?>
