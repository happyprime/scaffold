<?php
/**
 * Manages block customizations.
 *
 * @package scaffold
 */

namespace Scaffold\Base\Blocks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_block_editor_assets' );

/**
 * Enqueue block editor assets.
 *
 * @return void
 */
function enqueue_block_editor_assets(): void {
	$name       = 'block-styles';
	$path       = "/js/build/$name";
	$asset_meta = require_once SCAFFOLD_MU_PLUGIN_DIR . "$path.asset.php";

	wp_enqueue_script(
		"scaffold-$name",
		plugins_url( "$path.js", SCAFFOLD_MU_PLUGIN_FILE ),
		$asset_meta['dependencies'],
		$asset_meta['version'],
		true
	);
}
