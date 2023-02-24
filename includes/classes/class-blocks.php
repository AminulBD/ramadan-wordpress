<?php

namespace AminulBD\Ramadan;

class Blocks {
	private $calendar;

	public function __construct() {
		$this->calendar = new Prayer_Calendar();

		add_action( 'init', [ $this, 'register_blocks' ] );
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_assets' ] );

		if ( version_compare( $GLOBALS['wp_version'], '5.8', '<' ) ) {
			add_filter( 'block_categories', [ $this, 'block_categories' ], 10, 2 );
		} else {
			add_filter( 'block_categories_all', [ $this, 'block_categories' ], 10, 2 );
		}
	}

	private function get_cities() {
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

	private function get_months() {
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

	private function get_headings() {
		return [
			'date'    => esc_html__( 'Date', 'ramadan' ),
			'sahri'   => esc_html__( 'Sahri', 'ramadan' ),
			'fajr'    => esc_html__( 'Fajr', 'ramadan' ),
			'sunrise' => esc_html__( 'Sunrise', 'ramadan' ),
			'dhuhr'   => esc_html__( 'Dhuhr', 'ramadan' ),
			'asr'     => esc_html__( 'Asr', 'ramadan' ),
			'maghrib' => esc_html__( 'Maghrib', 'ramadan' ),
			'isha'    => esc_html__( 'Isha', 'ramadan' ),
		];
	}

	private function render_headings() {
		$headings = $this->get_headings();
		$html     = '<thead><tr>';
		foreach ( $headings as $heading ) {
			$html .= '<th>' . $heading . '</th>';
		}
		$html .= '</tr></thead>';

		return $html;
	}

	private function render_rows( $schedules, $year ) {
		$html = '';

		foreach ( $schedules as $day => $schedule ) {
			$today = "$year-$day";

			$html .= '<tr>';
			$html .= '<td>' . date_i18n( 'd -- l', strtotime( $today ) ) . '</td>';
			$html .= '<td>' . date_i18n( 'h:i A', strtotime( "$today {$schedule['sahri']}" ) ) . '</td>';
			$html .= '<td>' . date_i18n( 'h:i A', strtotime( "$today {$schedule['fajr']}" ) ) . '</td>';
			$html .= '<td>' . date_i18n( 'h:i A', strtotime( "$today {$schedule['sunrise']}" ) ) . '</td>';
			$html .= '<td>' . date_i18n( 'h:i A', strtotime( "$today {$schedule['dhuhr']}" ) ) . '</td>';
			$html .= '<td>' . date_i18n( 'h:i A', strtotime( "$today {$schedule['asr']}" ) ) . '</td>';
			$html .= '<td>' . date_i18n( 'h:i A', strtotime( "$today {$schedule['maghrib']}" ) ) . '</td>';
			$html .= '<td>' . date_i18n( 'h:i A', strtotime( "$today {$schedule['isha']}" ) ) . '</td>';
			$html .= '</tr>';
		}

		return $html;
	}

	private function get_permalink( $args = [] ) {
		global $post;
		$city    = isset( $args['ramadan_city'] ) ? $args['ramadan_city'] : get_query_var( 'ramadan_city' );
		$ramadan = in_array( $post->ID, [ (int) get_option( 'ramadan_page_id' ), (int) get_option( 'ramadan_city_page_id' ) ] );
		$type    = isset( $args['ramadan_type'] ) ? $args['ramadan_type'] : get_query_var( 'ramadan_type' );
		$type    = $type ?: ( $ramadan ? 'ramadan' : 'namaz' );
		$page    = get_option( $type === 'ramadan' ? 'ramadan_page_id' : 'ramadan_namaz_page_id' );
		$base    = get_permalink( $page );

		unset( $args['ramadan_type'] );

		if ( ! empty( get_option( 'permalink_structure' ) ) ) {
			unset( $args['ramadan_city'] );

			$base = $base . ( empty( $city ) ?: $city . '/' );

			return add_query_arg( $args, $base );
		}

		$page = get_option( $type === 'ramadan' ? 'ramadan_city_page_id' : 'ramadan_namaz_city_page_id' );
		$base = get_permalink( $page );

		if ( ! empty( $city ) ) {
			$args['ramadan_city'] = $city;
		}

		return add_query_arg( $args, $base );
	}

	public function block_categories( $categories ) {
		return array_merge( $categories, [
			[
				'slug'  => 'ramadan',
				'title' => __( 'Ramadan', 'ramadan' ),
			],
		] );
	}

	public function register_blocks() {
		// register blocks
		register_block_type( 'ramadan/city-selector', [
			'render_callback' => [ $this, 'render_city_selector' ]
		] );
		register_block_type( 'ramadan/daily', [
			'attributes'      => [
				'date' => [
					'type' => 'string',
				],
				'city' => [
					'type' => 'string',
				],
			],
			'render_callback' => [ $this, 'render_daily' ]
		] );
		register_block_type( 'ramadan/monthly', [
			'attributes'      => [
				'year'  => [
					'type' => 'string',
				],
				'month' => [
					'type' => 'string',
				],
				'city'  => [
					'type' => 'string',
				],
			],
			'render_callback' => [ $this, 'render_monthly' ]
		] );
		register_block_type( 'ramadan/month-links', [
			'render_callback' => [ $this, 'render_month_links' ]
		] );
		register_block_type( 'ramadan/ramadan', [
			'attributes'      => [
				'date' => [
					'type' => 'string',
				],
				'city' => [
					'type' => 'string',
				],
			],
			'render_callback' => [ $this, 'render_ramadan' ]
		] );
		register_block_type( 'ramadan/yearly', [
			'attributes'      => [
				'year' => [
					'type' => 'string',
				],
				'city' => [
					'type' => 'string',
				],
			],
			'render_callback' => [ $this, 'render_yearly' ]
		] );

		// register assets
		wp_register_script( 'ramadan-blocks', RAMADAN_URL . 'build/index.js', [
			'wp-block-editor',
			'wp-blocks',
			'wp-components',
			'wp-element',
			'wp-i18n',
			'wp-server-side-render'
		], RAMADAN_VERSION );
		wp_localize_script( 'ramadan-blocks', 'ramadan', [
			'cities' => $this->get_cities(),
			'months' => $this->get_months(),
		] );
		wp_register_style( 'ramadan-blocks', RAMADAN_URL . 'build/index.css', [], RAMADAN_VERSION );
	}

	public function enqueue_assets() {
		wp_enqueue_script( 'ramadan-blocks' );
		wp_enqueue_style( 'ramadan-blocks' );
	}

	public function render_city_selector() {
		$city   = get_query_var( 'ramadan_city' );
		$city   = empty( $city ) ? 'dhaka' : $city;
		$cities = $this->get_cities();
		$html   = '<select class="ramadan-city-selector" onchange="document.location.href=this.value">';

		foreach ( $cities as $division ) {
			$html .= '<optgroup label="' . $division['title'] . '">';
			foreach ( $division['cities'] as $name => $title ) {
				$html .= '<option value="' . esc_url( $this->get_permalink( [ 'ramadan_city' => $name ] ) ) . '"' . ( $city === $name ? ' selected' : '' ) . '>' . $title . '</option>';
			}
			$html .= '</optgroup>';
		}

		$html .= '</select>';

		return $html;
	}

	public function render_daily( $attributes ) {
		$city = isset( $attributes['city'] ) ? $attributes['city'] : '';
		$city = empty( $city ) ? get_query_var( 'ramadan_city' ) : $city;
		$this->calendar->set_district( $city );

		$current = current_datetime()->format( 'Y-m-d' );

		$date      = isset( $attributes['date'] ) ? $attributes['date'] : $current;
		$date      = empty( $date ) ? $current : $date;
		$schedules = $this->calendar->today( $date );

		$table = '<table class="prayer-times-table prayer-times-table-today">';
		$table .= '<thead>';
		$table .= '<tr>';
		$table .= '<th>' . date_i18n( 'd F, l', strtotime( $date ) ) . '</th>';
		$table .= '<th>' . esc_html__( 'Time', 'ramadan' ) . '</th>';
		$table .= '</tr>';
		$table .= '</thead>';
		$table .= '<tbody>';
		$table .= '<tr>';
		$table .= '<td>' . esc_html__( 'Sahri', 'ramadan' ) . '</td>';
		$table .= '<td>' . date_i18n( 'h:i A', strtotime( "$date {$schedules['sahri']}" ) ) . '</td>';
		$table .= '</tr>';
		$table .= '<tr>';
		$table .= '<td>' . esc_html__( 'Fajr', 'ramadan' ) . '</td>';
		$table .= '<td>' . date_i18n( 'h:i A', strtotime( "$date {$schedules['fajr']}" ) ) . '</td>';
		$table .= '</tr>';
		$table .= '<tr>';
		$table .= '<td>' . esc_html__( 'Sunrise', 'ramadan' ) . '</td>';
		$table .= '<td>' . date_i18n( 'h:i A', strtotime( "$date {$schedules['sunrise']}" ) ) . '</td>';
		$table .= '</tr>';
		$table .= '<tr>';
		$table .= '<td>' . esc_html__( 'Dhuhr', 'ramadan' ) . '</td>';
		$table .= '<td>' . date_i18n( 'h:i A', strtotime( "$date {$schedules['dhuhr']}" ) ) . '</td>';
		$table .= '</tr>';
		$table .= '<tr>';
		$table .= '<td>' . esc_html__( 'Asr', 'ramadan' ) . '</td>';
		$table .= '<td>' . date_i18n( 'h:i A', strtotime( "$date {$schedules['asr']}" ) ) . '</td>';
		$table .= '</tr>';
		$table .= '<tr>';
		$table .= '<td>' . esc_html__( 'Maghrib', 'ramadan' ) . '</td>';
		$table .= '<td>' . date_i18n( 'h:i A', strtotime( "$date {$schedules['maghrib']}" ) ) . '</td>';
		$table .= '</tr>';
		$table .= '<tr>';
		$table .= '<td>' . esc_html__( 'Isha', 'ramadan' ) . '</td>';
		$table .= '<td>' . date_i18n( 'h:i A', strtotime( "$date {$schedules['isha']}" ) ) . '</td>';
		$table .= '</tr>';
		$table .= '<tr>';
		$table .= '</tbody>';
		$table .= '</table>';

		return $table;
	}

	public function render_monthly( $attributes ) {
		$city = isset( $attributes['city'] ) ? $attributes['city'] : '';
		$city = empty( $city ) ? get_query_var( 'ramadan_city' ) : $city;
		$this->calendar->set_district( $city );

		$year  = isset( $attributes['year'] ) ? $attributes['year'] : '';
		$year  = empty( $year ) ? current_datetime()->format( 'Y' ) : $year;
		$month = isset( $attributes['month'] ) ? $attributes['month'] : get_query_var( 'ramadan_month' );
		$month = empty( $month ) ? current_datetime()->format( 'F' ) : $month;

		$monthFn   = strtolower( $month );
		$schedules = $this->calendar->{$monthFn}();

		$table = '<table class="prayer-times-table prayer-times-table-monthly">';
		$table .= $this->render_headings();
		$table .= '<tbody>';
		$table .= $this->render_rows( $schedules, $year );
		$table .= '</tbody>';
		$table .= '</table>';

		return $table;
	}

	public function render_month_links() {
		$month = get_query_var( 'ramadan_month' );
		if ( empty( $month ) ) {
			$month = 'january';
		}
		$links = '<ul class="prayer-times-month-links">';

		foreach ( $this->get_months() as $name => $label ) {
			$links .= '<li class="' . ( $month === $name ? 'active' : 'inactive' ) . '">';
			$links .= sprintf(
				'<a href="%s">%s</a>',
				esc_url( $this->get_permalink( [ 'ramadan_month' => $name ] ) ),
				esc_html( $label )
			);
			$links .= '</li>';
		}

		$links .= '</ul>';

		return $links;
	}

	public function render_ramadan( $attributes ) {
		$city = isset( $attributes['city'] ) ? $attributes['city'] : '';
		$city = empty( $city ) ? get_query_var( 'ramadan_city' ) : $city;
		$this->calendar->set_district( $city );

		$date = isset( $attributes['date'] ) ? $attributes['date'] : '';
		$date = empty( $date ) ? get_option( 'ramadan_start_date' ) : $date;

		$currentYear = ( new \DateTime( $date ) )->format( 'Y' );
		$schedules   = $this->calendar->ramadan( $date );

		$table = '<table class="prayer-times-table prayer-times-table-ramadan">';
		$table .= $this->render_headings();
		$table .= '<tbody>';
		$table .= $this->render_rows( $schedules, $currentYear );
		$table .= '</tbody>';
		$table .= '</table>';

		return $table;
	}

	public function render_yearly( $attributes ) {
		$city = isset( $attributes['city'] ) ? $attributes['city'] : '';
		$city = empty( $city ) ? get_query_var( 'ramadan_city' ) : $city;
		$this->calendar->set_district( $city );

		$year = isset( $attributes['year'] ) ? $attributes['year'] : '';
		$year = empty( $year ) ? current_datetime()->format( 'Y' ) : $year;

		$table = '<table class="prayer-times-table prayer-times-table-yearly">';
		$table .= $this->render_headings();
		$table .= '<tbody>';

		foreach ( $this->get_months() as $month => $monthName ) {
			$table .= '<tr>';
			$table .= '<th colspan="8">' . $monthName . '</th>';
			$table .= '</tr>';
			$table .= $this->render_rows( $this->calendar->{$month}(), $year );
		}

		$table .= '</tbody>';
		$table .= '</table>';

		return $table;
	}
}
