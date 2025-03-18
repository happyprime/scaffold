<?php
/**
 * Customize information output in header by WordPress.
 *
 * @package scaffold
 */

namespace Scaffold\WP\Header;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\remove_default_actions' );

/**
 * Remove other default actions that output unnecessary elements or do
 * unnecessary things.
 */
function remove_default_actions() {

	// Remove EditURL link for XML-RPC hinting.
	remove_action( 'wp_head', 'rsd_link' );

	// Remove the generator tag.
	remove_action( 'wp_head', 'wp_generator' );

	// Remove pseudo-shortlink handling.
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'template_redirect', 'wp_shortlink_header', 11 );

	// Image previews in search is not a concern on this site.
	remove_filter( 'wp_robots', 'wp_robots_max_image_preview_large' );

	// No need to advertise the REST API, it's still there.
	remove_action( 'wp_head', 'rest_output_link_wp_head' );

	// Remove embed information on single views.
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
}
