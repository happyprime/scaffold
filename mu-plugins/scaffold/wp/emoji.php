<?php
/**
 * Filter default handling of emoji in WordPress.
 *
 * @package scaffold
 */

namespace Scaffold\WP\Emoji;

add_action( 'plugins_loaded', __NAMESPACE__ . '\remove_extra_emoji_handling' );
add_filter( 'wp_resource_hints', __NAMESPACE__ . '\remove_wp_org_cdn_prefetch' );

/**
 * Allow devices to display emoji rather than via JavaScript and image replacement.
 */
function remove_extra_emoji_handling() {

	// Don't output the inline JavaScript used to convert emoji characters
	// into Twemoji images.
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'embed_head', 'print_emoji_detection_script' );

	// Don't output the inline styles applied to Twemoji images by default.
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );

	// Do not replace emoji with images.
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}

/**
 * Remove unnecessary DNS prefetch for s.w.org.
 *
 * This prefetch is only used when emojis are loaded as images from wp.org.
 *
 * @param array $urls A list of URLs.
 * @return array Modified list of URLs.
 */
function remove_wp_org_cdn_prefetch( array $urls ): array {

	foreach ( $urls as $key => $url ) {

		// Look for the likely URL controlling emoji images.
		if ( mb_strpos( $url, 's.w.org/images/core/emoji' ) ) {
			unset( $urls[ $key ] );
		}
	}

	return $urls;
}
