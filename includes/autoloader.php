<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Autoload classes.
spl_autoload_register( function ( $class_name ) {
	$parent_namespace  = 'AminulBD\Ramadan';
	$classes_subfolder = 'classes';

	if ( false !== strpos( $class_name, $parent_namespace ) ) {
		$classes_dir       = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . $classes_subfolder . DIRECTORY_SEPARATOR;
		$project_namespace = $parent_namespace . '\\';
		$length            = strlen( $project_namespace );
		$class_file        = substr( $class_name, $length );
		$class_file        = str_replace( '_', '-', strtolower( $class_file ) );
		$class_parts       = explode( '\\', $class_file );

		$last_index                 = count( $class_parts ) - 1;
		$class_parts[ $last_index ] = 'class-' . $class_parts[ $last_index ];

		$class_file     = implode( DIRECTORY_SEPARATOR, $class_parts ) . '.php';
		$class_location = $classes_dir . $class_file;

		if ( is_file( $class_location ) ) {
			require_once $class_location;
		}
	}
} );
