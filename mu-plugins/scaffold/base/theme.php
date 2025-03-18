<?php
/**
 * Theme feature configuration.
 *
 * @package scaffold
 */

namespace Scaffold\Base\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\configure_theme_support' );

/**
 * Add theme support for various built-in features.
 */
function configure_theme_support() {
	add_theme_support( 'align-wide' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'block-template-parts' );
	add_theme_support( 'editor-styles' );

	add_theme_support(
		'html5',
		[
			'search-form',
			'gallery',
			'caption',
			'style',
			'script',
		]
	);

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );

	add_editor_style();
}
