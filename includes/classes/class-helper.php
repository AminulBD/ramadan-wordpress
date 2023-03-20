<?php

namespace AminulBD\Ramadan;

class Helper {
	public static function get_cities() {
		return [
			'chattogram' => [
				'title'  => __( 'Chattogram', 'ramadan' ),
				'cities' => [
					'comilla'      => __( 'Comilla', 'ramadan' ),
					'feni'         => __( 'Feni', 'ramadan' ),
					'brahmanbaria' => __( 'Brahmanbaria', 'ramadan' ),
					'rangamati'    => __( 'Rangamati', 'ramadan' ),
					'noakhali'     => __( 'Noakhali', 'ramadan' ),
					'chandpur'     => __( 'Chandpur', 'ramadan' ),
					'lakshmipur'   => __( 'Lakshmipur', 'ramadan' ),
					'chattogram'   => __( 'Chattogram', 'ramadan' ),
					'coxsbazar'    => __( 'Coxsbazar', 'ramadan' ),
					'khagrachhari' => __( 'Khagrachhari', 'ramadan' ),
					'bandarban'    => __( 'Bandarban', 'ramadan' ),
				]
			],
			'rajshahi'   => [
				'title'  => __( 'Rajshahi', 'ramadan' ),
				'cities' => [
					'sirajganj'       => __( 'Sirajganj', 'ramadan' ),
					'pabna'           => __( 'Pabna', 'ramadan' ),
					'bogura'          => __( 'Bogura', 'ramadan' ),
					'rajshahi'        => __( 'Rajshahi', 'ramadan' ),
					'natore'          => __( 'Natore', 'ramadan' ),
					'joypurhat'       => __( 'Joypurhat', 'ramadan' ),
					'chapainawabganj' => __( 'Chapainawabganj', 'ramadan' ),
					'naogaon'         => __( 'Naogaon', 'ramadan' ),
				]
			],
			'khulna'     => [
				'title'  => __( 'Khulna', 'ramadan' ),
				'cities' => [
					'jashore'   => __( 'Jashore', 'ramadan' ),
					'satkhira'  => __( 'Satkhira', 'ramadan' ),
					'meherpur'  => __( 'Meherpur', 'ramadan' ),
					'narail'    => __( 'Narail', 'ramadan' ),
					'chuadanga' => __( 'Chuadanga', 'ramadan' ),
					'kushtia'   => __( 'Kushtia', 'ramadan' ),
					'magura'    => __( 'Magura', 'ramadan' ),
					'khulna'    => __( 'Khulna', 'ramadan' ),
					'bagerhat'  => __( 'Bagerhat', 'ramadan' ),
					'jhenaidah' => __( 'Jhenaidah', 'ramadan' ),
				]
			],
			'barishal'   => [
				'title'  => __( 'Barishal', 'ramadan' ),
				'cities' => [
					'jhalakathi' => __( 'Jhalakathi', 'ramadan' ),
					'patuakhali' => __( 'Patuakhali', 'ramadan' ),
					'pirojpur'   => __( 'Pirojpur', 'ramadan' ),
					'barishal'   => __( 'Barishal', 'ramadan' ),
					'bhola'      => __( 'Bhola', 'ramadan' ),
					'barguna'    => __( 'Barguna', 'ramadan' ),
				]
			],
			'sylhet'     => [
				'title'  => __( 'Sylhet', 'ramadan' ),
				'cities' => [
					'sylhet'      => __( 'Sylhet', 'ramadan' ),
					'moulvibazar' => __( 'Moulvibazar', 'ramadan' ),
					'habiganj'    => __( 'Habiganj', 'ramadan' ),
					'sunamganj'   => __( 'Sunamganj', 'ramadan' ),
				]
			],
			'dhaka'      => [
				'title'  => __( 'Dhaka', 'ramadan' ),
				'cities' => [
					'narsingdi'   => __( 'Narsingdi', 'ramadan' ),
					'gazipur'     => __( 'Gazipur', 'ramadan' ),
					'shariatpur'  => __( 'Shariatpur', 'ramadan' ),
					'narayanganj' => __( 'Narayanganj', 'ramadan' ),
					'tangail'     => __( 'Tangail', 'ramadan' ),
					'kishoreganj' => __( 'Kishoreganj', 'ramadan' ),
					'manikganj'   => __( 'Manikganj', 'ramadan' ),
					'dhaka'       => __( 'Dhaka', 'ramadan' ),
					'munshiganj'  => __( 'Munshiganj', 'ramadan' ),
					'rajbari'     => __( 'Rajbari', 'ramadan' ),
					'madaripur'   => __( 'Madaripur', 'ramadan' ),
					'gopalganj'   => __( 'Gopalganj', 'ramadan' ),
					'faridpur'    => __( 'Faridpur', 'ramadan' ),
				]
			],
			'rangpur'    => [
				'title'  => __( 'Rangpur', 'ramadan' ),
				'cities' => [
					'panchagarh'  => __( 'Panchagarh', 'ramadan' ),
					'dinajpur'    => __( 'Dinajpur', 'ramadan' ),
					'lalmonirhat' => __( 'Lalmonirhat', 'ramadan' ),
					'nilphamari'  => __( 'Nilphamari', 'ramadan' ),
					'gaibandha'   => __( 'Gaibandha', 'ramadan' ),
					'thakurgaon'  => __( 'Thakurgaon', 'ramadan' ),
					'rangpur'     => __( 'Rangpur', 'ramadan' ),
					'kurigram'    => __( 'Kurigram', 'ramadan' ),
				]
			],
			'mymensingh' => [
				'title'  => __( 'Mymensingh', 'ramadan' ),
				'cities' => [
					'sherpur'    => __( 'Sherpur', 'ramadan' ),
					'mymensingh' => __( 'Mymensingh', 'ramadan' ),
					'jamalpur'   => __( 'Jamalpur', 'ramadan' ),
					'netrokona'  => __( 'Netrokona', 'ramadan' ),
				]
			],
		];
	}

	public static function get_cities_flatten() {
		$cities = [];

		foreach ( self::get_cities() as $division ) {
			$cities = array_merge( $cities, $division['cities'] );
		}

		return $cities;
	}

	public static function get_months() {
		return [
			'january'   => date_i18n( 'F', strtotime( '2000-01-01' ) ),
			'february'  => date_i18n( 'F', strtotime( '2000-02-01' ) ),
			'march'     => date_i18n( 'F', strtotime( '2000-03-01' ) ),
			'april'     => date_i18n( 'F', strtotime( '2000-04-01' ) ),
			'may'       => date_i18n( 'F', strtotime( '2000-05-01' ) ),
			'june'      => date_i18n( 'F', strtotime( '2000-06-01' ) ),
			'july'      => date_i18n( 'F', strtotime( '2000-07-01' ) ),
			'august'    => date_i18n( 'F', strtotime( '2000-08-01' ) ),
			'september' => date_i18n( 'F', strtotime( '2000-09-01' ) ),
			'october'   => date_i18n( 'F', strtotime( '2000-10-01' ) ),
			'november'  => date_i18n( 'F', strtotime( '2000-11-01' ) ),
			'december'  => date_i18n( 'F', strtotime( '2000-12-01' ) ),
		];
	}

	public static function get_headings() {
		return [
			'date'    => esc_html__( 'Date', 'ramadan' ),
			'day'     => esc_html__( 'Day', 'ramadan' ),
			'sahri'   => esc_html__( 'Sahri', 'ramadan' ),
			'fajr'    => esc_html__( 'Fajr', 'ramadan' ),
			'sunrise' => esc_html__( 'Sunrise', 'ramadan' ),
			'dhuhr'   => esc_html__( 'Dhuhr', 'ramadan' ),
			'asr'     => esc_html__( 'Asr', 'ramadan' ),
			'maghrib' => esc_html__( 'Maghrib', 'ramadan' ),
			'iftar'   => esc_html__( 'Iftar', 'ramadan' ),
			'sunset'  => esc_html__( 'Sunset', 'ramadan' ),
			'isha'    => esc_html__( 'Isha', 'ramadan' ),
		];
	}

	public static function get_permalink( $args = [] ) {
		global $post;

		$ramadan_id      = (int) get_option( 'ramadan_page_id' );
		$ramadan_city_id = (int) get_option( 'ramadan_city_page_id' );
		$namaz_id        = (int) get_option( 'ramadan_namaz_page_id' );
		$namaz_city_id   = (int) get_option( 'ramadan_namaz_city_page_id' );
		$is_ramadan      = is_object( $post ) && in_array( $post->ID, [ $ramadan_id, $ramadan_city_id ] );

		$city = isset( $args['ramadan_city'] ) ? $args['ramadan_city'] : get_query_var( 'ramadan_city' );
		$type = isset( $args['ramadan_type'] ) ? $args['ramadan_type'] : get_query_var( 'ramadan_type' );
		$type = empty( $type ) ? ( $is_ramadan ? 'ramadan' : 'namaz' ) : $type;
		$base = get_permalink( $type === 'ramadan' ? $ramadan_id : $namaz_id );

		unset( $args['ramadan_type'] );

		if ( ! empty( get_option( 'permalink_structure' ) ) ) {
			unset( $args['ramadan_city'] );

			$base = $base . ( empty( $city ) ? null : $city . '/' );

			return add_query_arg( $args, $base );
		}

		$base = get_permalink( $type === 'ramadan' ? $ramadan_city_id : $namaz_city_id );

		if ( ! empty( $city ) ) {
			$args['ramadan_city'] = $city;
		}

		return add_query_arg( $args, $base );
	}
}
