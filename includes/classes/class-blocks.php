<?php

namespace AminulBD\Ramadan;

class Blocks {
	private static $instance = null;

	public function __construct() {
		add_action( 'init', [ $this, 'register_blocks' ] );
		add_filter( 'block_categories_all', [ $this, 'block_categories' ], 10, 2 );
	}

	public static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function register_blocks() {
		$blocks = glob( RAMADAN_PATH . 'build/*', GLOB_ONLYDIR );
		foreach ( $blocks as $block ) {
			register_block_type( $block );
		}

		wp_localize_script( 'wp-blocks', 'ramadan', [
			'cities'   => Helper::get_cities(),
			'months'   => Helper::get_months(),
			'headings' => Helper::get_headings(),
		] );
	}

	public function block_categories( $categories ) {
		return array_merge( $categories, [
			[
				'slug'  => 'ramadan',
				'title' => __( 'Ramadan', 'ramadan' ),
			],
		] );
	}
}
