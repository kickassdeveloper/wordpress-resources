<?php
/*
Plugin Name: Specific JS injection
Plugin URI: https://veles.tech
Description: Adds JS code to the <footer> of a theme, by hooking to wp_footer.
Author: Miroslav Ostojic
Version: 1.0
 */

function inject_js() {
global $wp;
$current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
if($current_url == 'url zeljene stranice stranice'){
	echo '<script src="'. esc_url( plugins_url( __FILE__ ) ).'/imeJSfajlaGdeSeNalazi.js"></script>';
 	 }
}
add_action( 'wp_footer', 'inject_js', 10 );
