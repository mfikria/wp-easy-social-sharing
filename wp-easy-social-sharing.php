<?php
/**
* Plugin Name: WP Easy Social Sharing
* Plugin URI: https://github.com/mfikria/wp-easy-social-sharing
* Description: A plugin for easy sharing your content to social media.
* Author: Muhamad Fikri Alhawarizmi
* Author URI: https://mfikria.com
* Version: 0.1
* License: GPLv2
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
require("admin.php");

function wess_add_icons() {
	if(!is_home() && !is_singular()) {
		return;
	}

	$facebook_share_count = wess_get_share_count_facebook($url);
	$linkedin_share_count = wess_get_share_count_linkedin($url);
	$total_share_count = $facebook_share_count + $linkedin_share_count;

	$html = "
		<div class='wess-container wess-container--" . get_option("wess_size") ." wess-container--" . get_option("wess_style") ."'>
			<div class='wess-container__total-count'>
				<span> " . $total_share_count . "</span>
				<span class='wess-container__total-count-label'> Shares</span>
			</div>
			<div class='wess-buttons'>
	";

	$html_mobile = "
		<div class='wess-container-mobile wess-container-mobile--minimized' id='wess-container-mobile'>
			<a class='wess-container-mobile__header' onclick='wessToggle()'>
				<span>Share This</span>
					<span class='wess-container-mobile__toggle oi oi-chevron-bottom'></span>
			</a>
			<div class='wess-buttons-mobile'>
				<ul class='wess-buttons-mobile__inner'>
	";

	global $wp;
	$url = home_url(add_query_arg(array(),$wp->request));
	$fb_share_url = 'http://www.facebook.com/sharer.php?u=' . $url;
	$twitter_share_url = 'https://twitter.com/share?url=' . $url;
	$linkedin_share_url = 'http://www.linkedin.com/shareArticle?url=' . $url;

	if(get_option("wess_facebook") == 1) {
		$html = $html . "
		<li class='wess-buttons__facebook'>
			<a
				target='popup'
				onclick=\"window.open('" . $fb_share_url . "','name','width=600,height=400')\"
			>
				<i class='socicon-facebook'>
				</i>
				<span class='wess-buttons__count'>
					" . $facebook_share_count . "
				</span>
			</a>
		</li>
		";

		$html_mobile = $html_mobile . "
			<li class='wess-buttons-mobile__facebook'>
				<a href='". $fb_share_url ."' rel='nofollow'>
					<i class='socicon-facebook'>
					</i>
					<span class='wess-buttons-mobile__title'>
						Facebook
					</span>
					<span class='wess-buttons-mobile__count'>
						" . $facebook_share_count . "
					</span>
				</a>
			</li>
		";
	}

	if(get_option("wess_twitter") == 1) {
		$html = $html . "
		<li class='wess-buttons__twitter'>
			<a
				target='popup'
				onclick=\"window.open('" . $twitter_share_url . "','name','width=600,height=400')\"
			>
				<i class='socicon-twitter'>
				</i>

				<span class='wess-buttons__count'>
					~
				</span>
			</a>
		</li>
		";

		$html_mobile = $html_mobile . "
			<li class='wess-buttons-mobile__twitter'>
				<a href='". $twitter_share_url ."' rel='nofollow'>
					<i class='socicon-twitter'>
					</i>
					<span class='wess-buttons-mobile__title'>
						Twitter
					</span>
					<span class='wess-buttons-mobile__count'>
						~
					</span>
				</a>
			</li>
		";
	}

	if(get_option("wess_linkedin") == 1){
		$html = $html . "
		<li class='wess-buttons__linkedin'>
			<a
				target='popup'
				onclick=\"window.open('" . $linkedin_share_url . "','name','width=600,height=400')\"
			>
				<i class='socicon-linkedin'>
				</i>
				<span class='wess-buttons__count'>
					" . $linkedin_share_count . "
				</span>
			</a>
		</li>
		";

		$html_mobile = $html_mobile . "
			<li class='wess-buttons-mobile__linkedin'>
				<a href='" . $linkedin_share_url . "' rel='nofollow'>
					<i class='socicon-linkedin'>
					</i>
					<span class='wess-buttons-mobile__title'>
						LinkedIn
					</span>
					<span class='wess-buttons-mobile__count'>
						" . $linkedin_share_count . "
					</span>
				</a>
			</li>
		";
	}

	$html = $html . "</div></div>";
	$html_mobile = $html_mobile . "</ul></div><div class='wess-container-mobile__overlay'></div></div>";

	echo $html;
	echo $html_mobile;
}

add_action('wp_footer','wess_add_icons', 100);

function wess_get_share_count_facebook($url) {
	$req_url = 'https://graph.facebook.com?id=' . $url . '&fields=og_object{engagement}';
	$contents = file_get_contents($req_url);
	if($contents !== false){
		$data = json_decode($contents, true);
		return $data['og_object']['engagement']['count'];
	} else {
		return 0;
	}
}

function wess_get_share_count_linkedin($url) {
	$req_url = 'https://www.linkedin.com/countserv/count/share?url=' . $url . '&format=json';
	$contents = file_get_contents($req_url);
	if($contents !== false){
		$data = json_decode($contents, true);
		return $data['count'];
	} else {
		return 0;
	}
}

// style
function wess_style() {
	wp_register_style("wess_style-file", plugin_dir_url(__FILE__) . "style.css");
	wp_enqueue_style("wess_style-file");
}

add_action("wp_enqueue_scripts", "wess_style");

function wess_add_vendor_style() {
	echo '<link rel="stylesheet" href="https://d1azc1qln24ryf.cloudfront.net/114779/Socicon/style-cf.css?rd5re8">';
	echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css">';
}
add_action('wp_footer', wess_add_vendor_style);

function wess_inject_style() {
	if(get_option("wess_background_color_activation") == 1){
		echo '
			<style type="text/css">
				.wess-buttons li, .wess-buttons-mobile li {
					background: ' . get_option(wess_background_color) . ' !important;
				}
			</style>
		';
	}
}
add_action('wp_footer', wess_inject_style);

function wess_scripts_basic() {
    wp_register_script( 'wess_script', plugins_url( '/assets/js/script.js', __FILE__ ) );
    wp_enqueue_script( 'wess_script' );
}
add_action( 'wp_enqueue_scripts', 'wess_scripts_basic' );
?>
