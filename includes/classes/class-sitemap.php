<?php

namespace AminulBD\Ramadan;

class Sitemap {
	private static $instance = null;

	public function __construct() {
		add_filter( 'wpseo_sitemaps_providers', [ $this, 'add_sitemap_providers' ] );

		// TODO: add support for more seo plugins (like RankMath, All in One SEO, etc.)
	}

	public static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function add_sitemap_providers( $providers ) {
		$providers['ramadan'] = new WPSEO_XML_Sitemap();

		return $providers;
	}
}
