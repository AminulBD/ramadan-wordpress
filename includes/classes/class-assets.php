<?php

namespace AminulBD\Ramadan;

class Assets {
	private static $instance = null;

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	public static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function register_scripts() {
		wp_register_style( 'ramadan-style', RAMADAN_URL . 'public/css/ramadan.css', [], RAMADAN_VERSION );
	}

	public function enqueue_scripts() {
		wp_enqueue_style( 'ramadan-style' );
	}
}
