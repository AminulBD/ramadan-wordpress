<?php

namespace AminulBD\Ramadan;

class Content {
	private static $instance = null;

	public function __construct() {
		add_filter( 'the_content', [ $this, 'content' ] );
		add_filter( 'the_title', [ $this, 'content' ] );
		add_filter( 'document_title', [ $this, 'content' ] );
	}

	public static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function content( $content ) {
		$cities       = Helper::get_cities_flatten();
		$city         = get_query_var( 'ramadan_city', 'dhaka' );
		$today        = current_datetime()->format( 'Y-m-d' );
		$city         = isset( $cities[ $city ] ) ? $cities[ $city ] : 'dhaka';
		$calendar     = new \AminulBD\Ramadan\Prayer_Calendar( $city );
		$schedule     = $calendar->today( $today );
		$formats      = get_option( 'ramadan_date_formats' ) ?: [];
		$today_format = isset( $formats['today'] ) ? $formats['today'] : 'd F, l';
		$date_format  = isset( $formats['date'] ) ? $formats['date'] : 'd F, l';
		$day_format   = isset( $formats['day'] ) ? $formats['day'] : 'l';
		$month_format = isset( $formats['month'] ) ? $formats['month'] : 'F';
		$year_format  = isset( $formats['year'] ) ? $formats['year'] : 'Y';
		$time_format  = isset( $formats['time'] ) ? $formats['time'] : 'h:i A';

		$text = [
			'{{city}}'  => esc_attr( $city ),
			'{{today}}' => date_i18n( $today_format, strtotime( $today ) ),
			'{{date}}'  => date_i18n( $date_format, strtotime( $today ) ),
			'{{day}}'   => date_i18n( $day_format, strtotime( $today ) ),
			'{{month}}' => date_i18n( $month_format, strtotime( $today ) ),
			'{{year}}'  => date_i18n( $year_format, strtotime( $today ) ),
		];

		$times = [ 'sahri', 'fajr', 'sunrise', 'dhuhr', 'asr', 'maghrib', 'iftar', 'sunset', 'isha' ];
		foreach ( $times as $name ) {
			$text["{{{$name}_time}}"] = date_i18n( $time_format, strtotime( "$today $schedule[$name]" ) );
		}

		return str_ireplace( array_keys( $text ), $text, $content );
	}
}
