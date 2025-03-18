<?php
/**
 * Scaffold features.
 *
 * @package scaffold
 */

namespace Scaffold;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SCAFFOLD_MU_PLUGIN_DIR', __DIR__ );
define( 'SCAFFOLD_MU_PLUGIN_FILE', __FILE__ );

// Load non-CLI files in top level directories.
$scaffold_files = glob( __DIR__ . '/*[!cli]/*.php' );
foreach ( $scaffold_files as $scaffold_file ) {
	require_once $scaffold_file;
}

// Load non-CLI and non-block files in secondary level directories.
$scaffold_files = glob( __DIR__ . '/*[!cli|!blocks]/**/*.php' );
foreach ( $scaffold_files as $scaffold_file ) {
	require_once $scaffold_file;
}

// Load index.php files in individual block directories.
$scaffold_files = glob( __DIR__ . '/blocks/src/**/index.php' );
foreach ( $scaffold_files as $scaffold_file ) {
	require_once $scaffold_file;
}

if ( defined( 'WP_CLI' ) ) {
	// Load CLI command files.
	$scaffold_files = glob( __DIR__ . '/cli/*.php' );
	foreach ( $scaffold_files as $scaffold_file ) {
		require_once $scaffold_file;
	}
}
