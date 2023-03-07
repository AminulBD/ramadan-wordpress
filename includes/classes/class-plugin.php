<?php

namespace AminulBD\Ramadan;

class Plugin {
	private static $instance = null;

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );
		add_action( 'init', [ $this, 'ramadan_rewrite_rule' ] );
		add_action( 'init', [ $this, 'namaz_rewrite_rule' ] );
		add_action( 'pre_get_posts', [ $this, 'set_current_city_page' ] );
		add_action( 'template_include', [ $this, 'template_include' ] );
		add_filter( 'query_vars', [ $this, 'query_vars_filters' ] );

		Assets::init();
		Blocks::init();
	}

	public static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function load_textdomain() {
		load_plugin_textdomain( 'ramadan', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	public function query_vars_filters( $query_vars ) {
		$query_vars[] = 'ramadan_city';
		$query_vars[] = 'ramadan_type';
		$query_vars[] = 'ramadan_month';

		return $query_vars;
	}

	public function ramadan_rewrite_rule() {
		$id = get_option( 'ramadan_page_id' );
		if ( ! $id ) {
			return;
		}

		$page = get_post( $id );
		if ( ! is_object( $page ) ) {
			return;
		}

		add_rewrite_rule(
			$page->post_name . '/([^/]+)/?$',
			'index.php?pagename=' . $page->post_name . '&ramadan_type=ramadan&ramadan_city=$matches[1]',
			'top'
		);
	}


	public function namaz_rewrite_rule() {
		$id = get_option( 'ramadan_namaz_page_id' );
		if ( ! $id ) {
			return;
		}

		$page = get_post( $id );
		if ( ! is_object( $page ) ) {
			return;
		}

		add_rewrite_rule(
			$page->post_name . '/([^/]+)/?$',
			'index.php?pagename=' . $page->post_name . '&ramadan_type=namaz&ramadan_city=$matches[1]',
			'top'
		);
	}

	public function set_current_city_page( $query ) {
		if ( ! $query->is_main_query() ) {
			return;
		}

		$cities = array_keys( Prayer_Calendar::get_districts() );
		$type   = get_query_var( 'ramadan_type' );
		$city   = get_query_var( 'ramadan_city' );

		if ( ! in_array( $type, [ 'ramadan', 'namaz' ] ) || ! in_array( $city, $cities ) ) {
			return;
		}

		$id = get_option( $type === 'ramadan' ? 'ramadan_city_page_id' : 'ramadan_namaz_city_page_id' );
		if ( ! $id ) {
			return;
		}

		$query->set( 'page_id', $id );
	}

	public function template_include( $template ) {
		$cities = array_keys( Prayer_Calendar::get_districts() );
		$type   = get_query_var( 'ramadan_type' );
		$city   = get_query_var( 'ramadan_city' );

		if ( ! in_array( $type, [ 'ramadan', 'namaz' ] ) ) {
			return $template;
		}

		if ( ! in_array( $city, $cities ) ) {
			return $this->render_error();
		}

		$id = get_option( $type === 'ramadan' ? 'ramadan_city_page_id' : 'ramadan_namaz_city_page_id' );
		if ( ! $id ) {
			return $this->render_error();
		}

		return $template;
	}

	private function render_error() {
		global $wp_query;
		$wp_query->set_404();

		status_header( 404 );

		return locate_template( '404.php' );
	}
}
