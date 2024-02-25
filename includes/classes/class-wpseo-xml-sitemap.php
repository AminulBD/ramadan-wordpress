<?php

namespace AminulBD\Ramadan;

use WPSEO_Sitemap_Provider;
use WPSEO_Sitemaps_Router;

class WPSEO_XML_Sitemap implements WPSEO_Sitemap_Provider {
	public function get_start_of_current_hour() {
		$date = new \DateTime();
		$date->setTime( $date->format( 'G' ), 0 );

		return $date->format( \DateTime::W3C );
	}

	public function handles_type( $type ) {
		return $type === 'ramadan' || $type === 'namaz';
	}

	public function get_index_links( $max_entries ) {
		$links = [];

		$ramadan_id = (int) get_option( 'ramadan_page_id' );
		if ( $ramadan_id && get_post( $ramadan_id ) ) {
			$links[] = [
				'loc'     => WPSEO_Sitemaps_Router::get_base_url( 'ramadan-sitemap.xml' ),
				'lastmod' => $this->get_start_of_current_hour(),
			];
		}

		$namaz_id = (int) get_option( 'ramadan_namaz_page_id' );
		if ( $namaz_id && get_post( $namaz_id ) ) {
			$links[] = [
				'loc'     => WPSEO_Sitemaps_Router::get_base_url( 'namaz-sitemap.xml' ),
				'lastmod' => $this->get_start_of_current_hour(),
			];
		}

		return $links;
	}

	public function get_sitemap_links( $type, $max_entries, $current_page ) {
		$urls   = [];
		$cities = Helper::get_cities_flatten();
		$now    = $this->get_start_of_current_hour();

		if ( $type === 'ramadan' ) {
			$ramadan_id   = (int) get_option( 'ramadan_page_id' );
			$ramadan_link = get_permalink( $ramadan_id );
			if ( $ramadan_link ) {
				foreach ( $cities as $slug => $city ) {
					$urls[] = [
						'loc' => trailingslashit( $ramadan_link ) . $slug,
						'mod' => $now,
					];
				}
			}
		}

		if ( $type === 'namaz' ) {
			$namaz_id   = (int) get_option( 'ramadan_namaz_page_id' );
			$namaz_link = get_permalink( $namaz_id );
			if ( $namaz_link ) {
				foreach ( $cities as $slug => $city ) {
					$urls[] = [
						'loc' => trailingslashit( $namaz_link ) . $slug,
						'mod' => $now,
					];
				}
			}
		}

		return $urls;
	}
}
