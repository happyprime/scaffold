<?php
/**
 * Adjustments to default WordPress handling of styles.
 *
 * @package scaffold
 */

namespace Scaffold\WP\Styles;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\remove_duotone_svg_filters' );

/**
 * Remove the default duotone SVGs output by WordPress.
 */
function remove_duotone_svg_filters() {
	remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
	remove_action( 'wp_body_open', 'gutenberg_global_styles_render_svg_filters' );
	remove_action( 'in_admin_header', 'wp_global_styles_render_svg_filters' );
	remove_action( 'in_admin_header', 'gutenberg_global_styles_render_svg_filters' );
}
