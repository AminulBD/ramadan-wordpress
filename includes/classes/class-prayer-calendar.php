<?php

namespace AminulBD\Ramadan;

class Prayer_Calendar {
	private $fist_ramadan;
	private $district;

	public function __construct( $district = 'dhaka', $fist_ramadan = null ) {
		$this->set_district( $district );
		$this->set_first_ramadan( $fist_ramadan );
	}

	private function adjust_time( $data ) {
		$sunrise      = abs( $this->district['sunrise'] );
		$sunset       = abs( $this->district['sunset'] );
		$riseModifier = $this->district['sunrise'] < 0 ? '-' : '+';
		$setModifier  = $this->district['sunset'] < 0 ? '-' : '+';

		return array_map( function ( $item ) use ( $sunrise, $sunset, $riseModifier, $setModifier ) {
			$item['sahri']   = date( 'H:i', strtotime( "{$item['sahri']} $riseModifier $sunrise minutes" ) );
			$item['fajr']    = date( 'H:i', strtotime( "{$item['fajr']} $riseModifier $sunrise minutes" ) );
			$item['sunrise'] = date( 'H:i', strtotime( "{$item['sunrise']} $riseModifier $sunrise minutes" ) );
			$item['dhuhr']   = date( 'H:i', strtotime( "{$item['dhuhr']} $riseModifier $sunrise minutes" ) );
			$item['asr']     = date( 'H:i', strtotime( "{$item['asr']} $riseModifier $sunrise minutes" ) );
			$item['sunset']  = date( 'H:i', strtotime( "{$item['sunset']} $riseModifier $sunset minutes" ) );
			$item['iftar']   = date( 'H:i', strtotime( "{$item['iftar']} $riseModifier $sunset minutes" ) );
			$item['maghrib'] = date( 'H:i', strtotime( "{$item['maghrib']} $setModifier $sunset minutes" ) );
			$item['isha']    = date( 'H:i', strtotime( "{$item['isha']} $setModifier $sunset minutes" ) );

			return $item;
		}, $data );
	}

	public function set_first_ramadan( $fist_ramadan ) {
		$this->fist_ramadan = $fist_ramadan;
	}

	public function set_district( $name ) {
		$districts = self::get_districts();

		$this->district = isset( $districts[ $name ] ) ? $districts[ $name ] : $districts['dhaka'];
	}

	public static function get_districts() {
		return [
			'netrokona'       => [ 'sunrise' => - 3, 'sunset' => - 3 ],
			'comilla'         => [ 'sunrise' => - 3, 'sunset' => - 3 ],
			'brahmanbaria'    => [ 'sunrise' => - 3, 'sunset' => - 3 ],
			'noakhali'        => [ 'sunrise' => - 4, 'sunset' => - 4 ],
			'feni'            => [ 'sunrise' => - 4, 'sunset' => - 4 ],
			'sunamganj'       => [ 'sunrise' => - 4, 'sunset' => - 4 ],
			'habiganj'        => [ 'sunrise' => - 4, 'sunset' => - 4 ],
			'chattogram'      => [ 'sunrise' => - 5, 'sunset' => - 5 ],
			'coxsbazar'       => [ 'sunrise' => - 6, 'sunset' => - 6 ],
			'sylhet'          => [ 'sunrise' => - 6, 'sunset' => - 6 ],
			'moulvibazar'     => [ 'sunrise' => - 6, 'sunset' => - 6 ],
			'khagrachhari'    => [ 'sunrise' => - 7, 'sunset' => - 7 ],
			'rangamati'       => [ 'sunrise' => - 7, 'sunset' => - 7 ],
			'bandarban'       => [ 'sunrise' => - 7, 'sunset' => - 7 ],
			'rajshahi'        => [ 'sunrise' => 7, 'sunset' => 7 ],
			'bogura'          => [ 'sunrise' => 7, 'sunset' => 7 ],
			'meherpur'        => [ 'sunrise' => 7, 'sunset' => 7 ],
			'lalmonirhat'     => [ 'sunrise' => 7, 'sunset' => 7 ],
			'joypurhat'       => [ 'sunrise' => 7, 'sunset' => 7 ],
			'chapainawabganj' => [ 'sunrise' => 8, 'sunset' => 8 ],
			'naogaon'         => [ 'sunrise' => 8, 'sunset' => 8 ],
			'natore'          => [ 'sunrise' => 8, 'sunset' => 8 ],
			'satkhira'        => [ 'sunrise' => 6, 'sunset' => 6 ],
			'kushtia'         => [ 'sunrise' => 6, 'sunset' => 6 ],
			'jashore'         => [ 'sunrise' => 6, 'sunset' => 6 ],
			'rangpur'         => [ 'sunrise' => 6, 'sunset' => 6 ],
			'jhenaidah'       => [ 'sunrise' => 6, 'sunset' => 6 ],
			'nilphamari'      => [ 'sunrise' => 6, 'sunset' => 6 ],
			'chuadanga'       => [ 'sunrise' => 6, 'sunset' => 6 ],
			'kurigram'        => [ 'sunrise' => 6, 'sunset' => 6 ],
			'gaibandha'       => [ 'sunrise' => 6, 'sunset' => 6 ],
			'magura'          => [ 'sunrise' => 4, 'sunset' => 4 ],
			'rajbari'         => [ 'sunrise' => 4, 'sunset' => 4 ],
			'pabna'           => [ 'sunrise' => 4, 'sunset' => 4 ],
			'narsingdi'       => [ 'sunrise' => - 1, 'sunset' => - 1 ],
			'narayanganj'     => [ 'sunrise' => - 1, 'sunset' => - 1 ],
			'munshiganj'      => [ 'sunrise' => - 1, 'sunset' => - 1 ],
			'chandpur'        => [ 'sunrise' => - 1, 'sunset' => - 1 ],
			'gazipur'         => [ 'sunrise' => 1, 'sunset' => 1 ],
			'shariatpur'      => [ 'sunrise' => 1, 'sunset' => 1 ],
			'madaripur'       => [ 'sunrise' => 1, 'sunset' => 1 ],
			'pirojpur'        => [ 'sunrise' => 1, 'sunset' => 1 ],
			'barishal'        => [ 'sunrise' => 1, 'sunset' => 1 ],
			'jhalakathi'      => [ 'sunrise' => 1, 'sunset' => 1 ],
			'barguna'         => [ 'sunrise' => 1, 'sunset' => 1 ],
			'kishoreganj'     => [ 'sunrise' => - 2, 'sunset' => - 2 ],
			'patuakhali'      => [ 'sunrise' => - 2, 'sunset' => - 2 ],
			'bhola'           => [ 'sunrise' => - 2, 'sunset' => - 2 ],
			'lakshmipur'      => [ 'sunrise' => - 2, 'sunset' => - 2 ],
			'dhaka'           => [ 'sunrise' => 0, 'sunset' => 0 ],
			'faridpur'        => [ 'sunrise' => 3, 'sunset' => 3 ],
			'gopalganj'       => [ 'sunrise' => 3, 'sunset' => 3 ],
			'sirajganj'       => [ 'sunrise' => 3, 'sunset' => 3 ],
			'narail'          => [ 'sunrise' => 3, 'sunset' => 3 ],
			'khulna'          => [ 'sunrise' => 3, 'sunset' => 3 ],
			'dinajpur'        => [ 'sunrise' => 6, 'sunset' => 11 ],
			'thakurgaon'      => [ 'sunrise' => 6, 'sunset' => 11 ],
			'panchagarh'      => [ 'sunrise' => 6, 'sunset' => 11 ],
			'mymensingh'      => [ 'sunrise' => 2, 'sunset' => 2 ],
			'tangail'         => [ 'sunrise' => 2, 'sunset' => 2 ],
			'bagerhat'        => [ 'sunrise' => 2, 'sunset' => 2 ],
			'jamalpur'        => [ 'sunrise' => 2, 'sunset' => 2 ],
			'sherpur'         => [ 'sunrise' => 2, 'sunset' => 2 ],
			'manikganj'       => [ 'sunrise' => 2, 'sunset' => 2 ],
		];
	}

	public function ramadan( $date = null ) {
		$start = empty( $date ) ? $this->fist_ramadan : $date;
		$end   = date( 'Y-m-d', strtotime( '+30 days', strtotime( empty( $start ) ? '00:00' : $start ) ) );

		return $this->get_range( $start, $end );
	}

	public function today( $date = null ) {
		if ( ! $date ) {
			$date = date( 'Y-m-d' );
		}

		$time  = strtotime( $date );
		$today = date( 'm-d', $time );

		try {
			return $this->year()[ $today ];
		} catch ( \Exception $e ) {
			return null;
		}
	}

	public function get_range( $start, $end ) {
		$range = [];

		try {
			$dates = new \DatePeriod(
				new \DateTime( $start ),
				new \DateInterval( 'P1D' ),
				new \DateTime( $end )
			);

			$year = $this->year();

			foreach ( $dates as $date ) {
				$key = $date->format( 'm-d' );

				$range[ $key ] = $year[ $key ];
			}

			return $range;
		} catch ( \Exception $e ) {
			return $range;
		}
	}

	public function january() {
		$data = [
			'01-01' => [ 'sahri' => '05:16', 'fajr' => '05:22', 'sunrise' => '06:41', 'dhuhr' => '12:06', 'asr' => '15:46', 'sunset' => '17:27', 'iftar' => '17:27', 'maghrib' => '17:27', 'isha' => '18:45' ],
			'01-02' => [ 'sahri' => '05:16', 'fajr' => '05:22', 'sunrise' => '06:41', 'dhuhr' => '12:06', 'asr' => '15:46', 'sunset' => '17:27', 'iftar' => '17:27', 'maghrib' => '17:27', 'isha' => '18:45' ],
			'01-03' => [ 'sahri' => '05:16', 'fajr' => '05:22', 'sunrise' => '06:41', 'dhuhr' => '12:06', 'asr' => '15:47', 'sunset' => '17:28', 'iftar' => '17:28', 'maghrib' => '17:28', 'isha' => '18:46' ],
			'01-04' => [ 'sahri' => '05:16', 'fajr' => '05:23', 'sunrise' => '06:41', 'dhuhr' => '12:07', 'asr' => '15:48', 'sunset' => '17:28', 'iftar' => '17:28', 'maghrib' => '17:28', 'isha' => '18:46' ],
			'01-05' => [ 'sahri' => '05:17', 'fajr' => '05:23', 'sunrise' => '06:41', 'dhuhr' => '12:07', 'asr' => '15:49', 'sunset' => '17:29', 'iftar' => '17:29', 'maghrib' => '17:29', 'isha' => '18:47' ],
			'01-06' => [ 'sahri' => '05:18', 'fajr' => '05:24', 'sunrise' => '06:42', 'dhuhr' => '12:08', 'asr' => '15:50', 'sunset' => '17:30', 'iftar' => '17:30', 'maghrib' => '17:30', 'isha' => '18:48' ],
			'01-07' => [ 'sahri' => '05:18', 'fajr' => '05:24', 'sunrise' => '06:42', 'dhuhr' => '12:08', 'asr' => '15:50', 'sunset' => '17:30', 'iftar' => '17:30', 'maghrib' => '17:30', 'isha' => '18:48' ],
			'01-08' => [ 'sahri' => '05:18', 'fajr' => '05:24', 'sunrise' => '06:42', 'dhuhr' => '12:08', 'asr' => '15:51', 'sunset' => '17:31', 'iftar' => '17:31', 'maghrib' => '17:31', 'isha' => '18:49' ],
			'01-09' => [ 'sahri' => '05:19', 'fajr' => '05:25', 'sunrise' => '06:42', 'dhuhr' => '12:09', 'asr' => '15:52', 'sunset' => '17:31', 'iftar' => '17:31', 'maghrib' => '17:31', 'isha' => '18:49' ],
			'01-10' => [ 'sahri' => '05:19', 'fajr' => '05:25', 'sunrise' => '06:42', 'dhuhr' => '12:09', 'asr' => '15:53', 'sunset' => '17:32', 'iftar' => '17:32', 'maghrib' => '17:32', 'isha' => '18:50' ],
			'01-11' => [ 'sahri' => '05:20', 'fajr' => '05:26', 'sunrise' => '06:43', 'dhuhr' => '12:10', 'asr' => '15:54', 'sunset' => '17:33', 'iftar' => '17:33', 'maghrib' => '17:33', 'isha' => '18:51' ],
			'01-12' => [ 'sahri' => '05:20', 'fajr' => '05:26', 'sunrise' => '06:43', 'dhuhr' => '12:10', 'asr' => '15:54', 'sunset' => '17:33', 'iftar' => '17:33', 'maghrib' => '17:33', 'isha' => '18:51' ],
			'01-13' => [ 'sahri' => '05:20', 'fajr' => '05:26', 'sunrise' => '06:43', 'dhuhr' => '12:10', 'asr' => '15:55', 'sunset' => '17:34', 'iftar' => '17:34', 'maghrib' => '17:34', 'isha' => '18:52' ],
			'01-14' => [ 'sahri' => '05:20', 'fajr' => '05:26', 'sunrise' => '06:43', 'dhuhr' => '12:11', 'asr' => '15:56', 'sunset' => '17:35', 'iftar' => '17:35', 'maghrib' => '17:35', 'isha' => '18:52' ],
			'01-15' => [ 'sahri' => '05:20', 'fajr' => '05:26', 'sunrise' => '06:43', 'dhuhr' => '12:11', 'asr' => '15:56', 'sunset' => '17:35', 'iftar' => '17:35', 'maghrib' => '17:35', 'isha' => '18:53' ],
			'01-16' => [ 'sahri' => '05:20', 'fajr' => '05:26', 'sunrise' => '06:43', 'dhuhr' => '12:12', 'asr' => '15:57', 'sunset' => '17:36', 'iftar' => '17:36', 'maghrib' => '17:36', 'isha' => '18:54' ],
			'01-17' => [ 'sahri' => '05:20', 'fajr' => '05:26', 'sunrise' => '06:43', 'dhuhr' => '12:13', 'asr' => '15:58', 'sunset' => '17:37', 'iftar' => '17:37', 'maghrib' => '17:37', 'isha' => '18:54' ],
			'01-18' => [ 'sahri' => '05:20', 'fajr' => '05:26', 'sunrise' => '06:43', 'dhuhr' => '12:13', 'asr' => '15:58', 'sunset' => '17:38', 'iftar' => '17:38', 'maghrib' => '17:38', 'isha' => '18:55' ],
			'01-19' => [ 'sahri' => '05:19', 'fajr' => '05:25', 'sunrise' => '06:42', 'dhuhr' => '12:13', 'asr' => '15:59', 'sunset' => '17:38', 'iftar' => '17:38', 'maghrib' => '17:38', 'isha' => '18:55' ],
			'01-20' => [ 'sahri' => '05:19', 'fajr' => '05:25', 'sunrise' => '06:42', 'dhuhr' => '12:13', 'asr' => '16:00', 'sunset' => '17:39', 'iftar' => '17:39', 'maghrib' => '17:39', 'isha' => '18:56' ],
			'01-21' => [ 'sahri' => '05:19', 'fajr' => '05:25', 'sunrise' => '06:42', 'dhuhr' => '12:13', 'asr' => '16:00', 'sunset' => '17:40', 'iftar' => '17:40', 'maghrib' => '17:40', 'isha' => '18:57' ],
			'01-22' => [ 'sahri' => '05:19', 'fajr' => '05:25', 'sunrise' => '06:41', 'dhuhr' => '12:13', 'asr' => '16:01', 'sunset' => '17:41', 'iftar' => '17:41', 'maghrib' => '17:41', 'isha' => '18:57' ],
			'01-23' => [ 'sahri' => '05:19', 'fajr' => '05:25', 'sunrise' => '06:41', 'dhuhr' => '12:13', 'asr' => '16:02', 'sunset' => '17:42', 'iftar' => '17:42', 'maghrib' => '17:42', 'isha' => '18:58' ],
			'01-24' => [ 'sahri' => '05:19', 'fajr' => '05:25', 'sunrise' => '06:41', 'dhuhr' => '12:14', 'asr' => '16:03', 'sunset' => '17:43', 'iftar' => '17:43', 'maghrib' => '17:43', 'isha' => '18:59' ],
			'01-25' => [ 'sahri' => '05:18', 'fajr' => '05:24', 'sunrise' => '06:40', 'dhuhr' => '12:14', 'asr' => '16:03', 'sunset' => '17:43', 'iftar' => '17:43', 'maghrib' => '17:43', 'isha' => '18:59' ],
			'01-26' => [ 'sahri' => '05:18', 'fajr' => '05:24', 'sunrise' => '06:40', 'dhuhr' => '12:14', 'asr' => '16:04', 'sunset' => '17:44', 'iftar' => '17:44', 'maghrib' => '17:44', 'isha' => '19:00' ],
			'01-27' => [ 'sahri' => '05:18', 'fajr' => '05:24', 'sunrise' => '06:40', 'dhuhr' => '12:15', 'asr' => '16:04', 'sunset' => '17:44', 'iftar' => '17:44', 'maghrib' => '17:44', 'isha' => '19:00' ],
			'01-28' => [ 'sahri' => '05:18', 'fajr' => '05:24', 'sunrise' => '06:40', 'dhuhr' => '12:15', 'asr' => '16:05', 'sunset' => '17:45', 'iftar' => '17:45', 'maghrib' => '17:45', 'isha' => '19:01' ],
			'01-29' => [ 'sahri' => '05:18', 'fajr' => '05:24', 'sunrise' => '06:40', 'dhuhr' => '12:15', 'asr' => '16:06', 'sunset' => '17:46', 'iftar' => '17:46', 'maghrib' => '17:46', 'isha' => '19:02' ],
			'01-30' => [ 'sahri' => '05:18', 'fajr' => '05:24', 'sunrise' => '06:40', 'dhuhr' => '12:15', 'asr' => '16:06', 'sunset' => '17:46', 'iftar' => '17:46', 'maghrib' => '17:46', 'isha' => '19:02' ],
			'01-31' => [ 'sahri' => '05:18', 'fajr' => '05:24', 'sunrise' => '06:40', 'dhuhr' => '12:16', 'asr' => '16:07', 'sunset' => '17:47', 'iftar' => '17:47', 'maghrib' => '17:47', 'isha' => '19:03' ],
		];

		return $this->adjust_time( $data );
	}

	public function february() {
		$data = [
			'02-01' => [ 'sahri' => '05:18', 'fajr' => '05:24', 'sunrise' => '06:39', 'dhuhr' => '12:16', 'asr' => '16:08', 'sunset' => '17:48', 'iftar' => '17:48', 'maghrib' => '17:48', 'isha' => '19:04' ],
			'02-02' => [ 'sahri' => '05:17', 'fajr' => '05:23', 'sunrise' => '06:39', 'dhuhr' => '12:16', 'asr' => '16:08', 'sunset' => '17:48', 'iftar' => '17:48', 'maghrib' => '17:48', 'isha' => '19:04' ],
			'02-03' => [ 'sahri' => '05:17', 'fajr' => '05:23', 'sunrise' => '06:38', 'dhuhr' => '12:16', 'asr' => '16:09', 'sunset' => '17:49', 'iftar' => '17:49', 'maghrib' => '17:49', 'isha' => '19:05' ],
			'02-04' => [ 'sahri' => '05:17', 'fajr' => '05:22', 'sunrise' => '06:38', 'dhuhr' => '12:16', 'asr' => '16:09', 'sunset' => '17:50', 'iftar' => '17:50', 'maghrib' => '17:50', 'isha' => '19:05' ],
			'02-05' => [ 'sahri' => '05:16', 'fajr' => '05:22', 'sunrise' => '06:37', 'dhuhr' => '12:16', 'asr' => '16:10', 'sunset' => '17:51', 'iftar' => '17:51', 'maghrib' => '17:51', 'isha' => '19:06' ],
			'02-06' => [ 'sahri' => '05:16', 'fajr' => '05:22', 'sunrise' => '06:37', 'dhuhr' => '12:16', 'asr' => '16:11', 'sunset' => '17:52', 'iftar' => '17:52', 'maghrib' => '17:52', 'isha' => '19:07' ],
			'02-07' => [ 'sahri' => '05:15', 'fajr' => '05:21', 'sunrise' => '06:36', 'dhuhr' => '12:16', 'asr' => '16:11', 'sunset' => '17:52', 'iftar' => '17:52', 'maghrib' => '17:52', 'isha' => '19:07' ],
			'02-08' => [ 'sahri' => '05:15', 'fajr' => '05:21', 'sunrise' => '06:35', 'dhuhr' => '12:16', 'asr' => '16:12', 'sunset' => '17:53', 'iftar' => '17:53', 'maghrib' => '17:53', 'isha' => '19:08' ],
			'02-09' => [ 'sahri' => '05:14', 'fajr' => '05:20', 'sunrise' => '06:35', 'dhuhr' => '12:16', 'asr' => '16:13', 'sunset' => '17:53', 'iftar' => '17:53', 'maghrib' => '17:53', 'isha' => '19:08' ],
			'02-10' => [ 'sahri' => '05:14', 'fajr' => '05:20', 'sunrise' => '06:34', 'dhuhr' => '12:16', 'asr' => '16:13', 'sunset' => '17:54', 'iftar' => '17:54', 'maghrib' => '17:54', 'isha' => '19:09' ],
			'02-11' => [ 'sahri' => '05:13', 'fajr' => '05:20', 'sunrise' => '06:33', 'dhuhr' => '12:16', 'asr' => '16:14', 'sunset' => '17:55', 'iftar' => '17:55', 'maghrib' => '17:55', 'isha' => '19:10' ],
			'02-12' => [ 'sahri' => '05:13', 'fajr' => '05:19', 'sunrise' => '06:33', 'dhuhr' => '12:16', 'asr' => '16:15', 'sunset' => '17:55', 'iftar' => '17:55', 'maghrib' => '17:55', 'isha' => '19:10' ],
			'02-13' => [ 'sahri' => '05:12', 'fajr' => '05:18', 'sunrise' => '06:32', 'dhuhr' => '12:16', 'asr' => '16:15', 'sunset' => '17:56', 'iftar' => '17:56', 'maghrib' => '17:56', 'isha' => '19:11' ],
			'02-14' => [ 'sahri' => '05:11', 'fajr' => '05:18', 'sunrise' => '06:32', 'dhuhr' => '12:16', 'asr' => '16:16', 'sunset' => '17:56', 'iftar' => '17:56', 'maghrib' => '17:56', 'isha' => '19:11' ],
			'02-15' => [ 'sahri' => '05:11', 'fajr' => '05:17', 'sunrise' => '06:31', 'dhuhr' => '12:16', 'asr' => '16:16', 'sunset' => '17:57', 'iftar' => '17:57', 'maghrib' => '17:57', 'isha' => '19:12' ],
			'02-16' => [ 'sahri' => '05:10', 'fajr' => '05:17', 'sunrise' => '06:30', 'dhuhr' => '12:16', 'asr' => '16:17', 'sunset' => '17:58', 'iftar' => '17:58', 'maghrib' => '17:58', 'isha' => '19:12' ],
			'02-17' => [ 'sahri' => '05:09', 'fajr' => '05:16', 'sunrise' => '06:30', 'dhuhr' => '12:16', 'asr' => '16:17', 'sunset' => '17:58', 'iftar' => '17:58', 'maghrib' => '17:58', 'isha' => '19:13' ],
			'02-18' => [ 'sahri' => '05:09', 'fajr' => '05:16', 'sunrise' => '06:29', 'dhuhr' => '12:16', 'asr' => '16:18', 'sunset' => '17:59', 'iftar' => '17:59', 'maghrib' => '17:59', 'isha' => '19:13' ],
			'02-19' => [ 'sahri' => '05:08', 'fajr' => '05:15', 'sunrise' => '06:28', 'dhuhr' => '12:16', 'asr' => '16:18', 'sunset' => '17:59', 'iftar' => '17:59', 'maghrib' => '17:59', 'isha' => '19:14' ],
			'02-20' => [ 'sahri' => '05:07', 'fajr' => '05:14', 'sunrise' => '06:28', 'dhuhr' => '12:16', 'asr' => '16:18', 'sunset' => '18:00', 'iftar' => '18:00', 'maghrib' => '18:00', 'isha' => '19:14' ],
			'02-21' => [ 'sahri' => '05:07', 'fajr' => '05:13', 'sunrise' => '06:27', 'dhuhr' => '12:15', 'asr' => '16:19', 'sunset' => '18:01', 'iftar' => '18:01', 'maghrib' => '18:01', 'isha' => '19:15' ],
			'02-22' => [ 'sahri' => '05:06', 'fajr' => '05:12', 'sunrise' => '06:26', 'dhuhr' => '12:15', 'asr' => '16:19', 'sunset' => '18:01', 'iftar' => '18:01', 'maghrib' => '18:01', 'isha' => '19:15' ],
			'02-23' => [ 'sahri' => '05:06', 'fajr' => '05:12', 'sunrise' => '06:26', 'dhuhr' => '12:15', 'asr' => '16:20', 'sunset' => '18:02', 'iftar' => '18:02', 'maghrib' => '18:02', 'isha' => '19:15' ],
			'02-24' => [ 'sahri' => '05:05', 'fajr' => '05:11', 'sunrise' => '06:25', 'dhuhr' => '12:15', 'asr' => '16:20', 'sunset' => '18:02', 'iftar' => '18:02', 'maghrib' => '18:02', 'isha' => '19:16' ],
			'02-25' => [ 'sahri' => '05:04', 'fajr' => '05:10', 'sunrise' => '06:24', 'dhuhr' => '12:15', 'asr' => '16:21', 'sunset' => '18:03', 'iftar' => '18:03', 'maghrib' => '18:03', 'isha' => '19:16' ],
			'02-26' => [ 'sahri' => '05:04', 'fajr' => '05:09', 'sunrise' => '06:23', 'dhuhr' => '12:15', 'asr' => '16:21', 'sunset' => '18:03', 'iftar' => '18:03', 'maghrib' => '18:03', 'isha' => '19:16' ],
			'02-27' => [ 'sahri' => '05:03', 'fajr' => '05:09', 'sunrise' => '06:22', 'dhuhr' => '12:15', 'asr' => '16:21', 'sunset' => '18:03', 'iftar' => '18:03', 'maghrib' => '18:03', 'isha' => '19:16' ],
			'02-28' => [ 'sahri' => '05:02', 'fajr' => '05:08', 'sunrise' => '06:22', 'dhuhr' => '12:15', 'asr' => '16:22', 'sunset' => '18:04', 'iftar' => '18:04', 'maghrib' => '18:04', 'isha' => '19:16' ],
			'02-29' => [ 'sahri' => '05:02', 'fajr' => '05:08', 'sunrise' => '06:22', 'dhuhr' => '12:15', 'asr' => '16:22', 'sunset' => '18:04', 'iftar' => '18:04', 'maghrib' => '18:04', 'isha' => '19:16' ],
		];

		return $this->adjust_time( $data );
	}

	public function march() {
		$data = [
			'03-01' => [ 'sahri' => '05:01', 'fajr' => '05:07', 'sunrise' => '06:20', 'dhuhr' => '12:14', 'asr' => '16:22', 'sunset' => '18:05', 'iftar' => '18:05', 'maghrib' => '18:05', 'isha' => '19:18' ],
			'03-02' => [ 'sahri' => '05:00', 'fajr' => '05:06', 'sunrise' => '06:19', 'dhuhr' => '12:13', 'asr' => '16:23', 'sunset' => '18:05', 'iftar' => '18:05', 'maghrib' => '18:05', 'isha' => '19:18' ],
			'03-03' => [ 'sahri' => '04:59', 'fajr' => '05:05', 'sunrise' => '06:18', 'dhuhr' => '12:13', 'asr' => '16:23', 'sunset' => '18:06', 'iftar' => '18:06', 'maghrib' => '18:06', 'isha' => '19:19' ],
			'03-04' => [ 'sahri' => '04:59', 'fajr' => '05:04', 'sunrise' => '06:18', 'dhuhr' => '12:13', 'asr' => '16:23', 'sunset' => '18:06', 'iftar' => '18:06', 'maghrib' => '18:06', 'isha' => '19:19' ],
			'03-05' => [ 'sahri' => '04:58', 'fajr' => '05:03', 'sunrise' => '06:17', 'dhuhr' => '12:13', 'asr' => '16:24', 'sunset' => '18:07', 'iftar' => '18:07', 'maghrib' => '18:07', 'isha' => '19:20' ],
			'03-06' => [ 'sahri' => '04:57', 'fajr' => '05:03', 'sunrise' => '06:16', 'dhuhr' => '12:13', 'asr' => '16:24', 'sunset' => '18:07', 'iftar' => '18:07', 'maghrib' => '18:07', 'isha' => '19:20' ],
			'03-07' => [ 'sahri' => '04:56', 'fajr' => '05:02', 'sunrise' => '06:15', 'dhuhr' => '12:13', 'asr' => '16:24', 'sunset' => '18:07', 'iftar' => '18:07', 'maghrib' => '18:07', 'isha' => '19:21' ],
			'03-08' => [ 'sahri' => '04:55', 'fajr' => '05:01', 'sunrise' => '06:14', 'dhuhr' => '12:13', 'asr' => '16:25', 'sunset' => '18:08', 'iftar' => '18:08', 'maghrib' => '18:08', 'isha' => '19:21' ],
			'03-09' => [ 'sahri' => '04:54', 'fajr' => '05:00', 'sunrise' => '06:13', 'dhuhr' => '12:12', 'asr' => '16:25', 'sunset' => '18:08', 'iftar' => '18:08', 'maghrib' => '18:08', 'isha' => '19:22' ],
			'03-10' => [ 'sahri' => '04:53', 'fajr' => '04:59', 'sunrise' => '06:12', 'dhuhr' => '12:12', 'asr' => '16:25', 'sunset' => '18:09', 'iftar' => '18:09', 'maghrib' => '18:09', 'isha' => '19:22' ],
			'03-11' => [ 'sahri' => '04:52', 'fajr' => '04:58', 'sunrise' => '06:11', 'dhuhr' => '12:12', 'asr' => '16:25', 'sunset' => '18:09', 'iftar' => '18:09', 'maghrib' => '18:09', 'isha' => '19:23' ],
			'03-12' => [ 'sahri' => '04:51', 'fajr' => '04:57', 'sunrise' => '06:10', 'dhuhr' => '12:12', 'asr' => '16:26', 'sunset' => '18:10', 'iftar' => '18:10', 'maghrib' => '18:10', 'isha' => '19:23' ],
			'03-13' => [ 'sahri' => '04:50', 'fajr' => '04:56', 'sunrise' => '06:09', 'dhuhr' => '12:12', 'asr' => '16:26', 'sunset' => '18:10', 'iftar' => '18:10', 'maghrib' => '18:10', 'isha' => '19:23' ],
			'03-14' => [ 'sahri' => '04:49', 'fajr' => '04:55', 'sunrise' => '06:08', 'dhuhr' => '12:11', 'asr' => '16:26', 'sunset' => '18:11', 'iftar' => '18:11', 'maghrib' => '18:11', 'isha' => '19:24' ],
			'03-15' => [ 'sahri' => '04:48', 'fajr' => '04:54', 'sunrise' => '06:07', 'dhuhr' => '12:11', 'asr' => '16:26', 'sunset' => '18:11', 'iftar' => '18:11', 'maghrib' => '18:11', 'isha' => '19:24' ],
			'03-16' => [ 'sahri' => '04:47', 'fajr' => '04:53', 'sunrise' => '06:06', 'dhuhr' => '12:11', 'asr' => '16:27', 'sunset' => '18:11', 'iftar' => '18:11', 'maghrib' => '18:11', 'isha' => '19:24' ],
			'03-17' => [ 'sahri' => '04:46', 'fajr' => '04:52', 'sunrise' => '06:05', 'dhuhr' => '12:10', 'asr' => '16:27', 'sunset' => '18:12', 'iftar' => '18:12', 'maghrib' => '18:12', 'isha' => '19:25' ],
			'03-18' => [ 'sahri' => '04:45', 'fajr' => '04:51', 'sunrise' => '06:04', 'dhuhr' => '12:10', 'asr' => '16:27', 'sunset' => '18:12', 'iftar' => '18:12', 'maghrib' => '18:12', 'isha' => '19:25' ],
			'03-19' => [ 'sahri' => '04:44', 'fajr' => '04:50', 'sunrise' => '06:03', 'dhuhr' => '12:10', 'asr' => '16:27', 'sunset' => '18:12', 'iftar' => '18:12', 'maghrib' => '18:12', 'isha' => '19:26' ],
			'03-20' => [ 'sahri' => '04:43', 'fajr' => '04:49', 'sunrise' => '06:02', 'dhuhr' => '12:09', 'asr' => '16:28', 'sunset' => '18:13', 'iftar' => '18:13', 'maghrib' => '18:13', 'isha' => '19:26' ],
			'03-21' => [ 'sahri' => '04:42', 'fajr' => '04:48', 'sunrise' => '06:01', 'dhuhr' => '12:09', 'asr' => '16:28', 'sunset' => '18:13', 'iftar' => '18:13', 'maghrib' => '18:13', 'isha' => '19:27' ],
			'03-22' => [ 'sahri' => '04:41', 'fajr' => '04:47', 'sunrise' => '06:00', 'dhuhr' => '12:09', 'asr' => '16:28', 'sunset' => '18:13', 'iftar' => '18:13', 'maghrib' => '18:13', 'isha' => '19:27' ],
			'03-23' => [ 'sahri' => '04:40', 'fajr' => '04:46', 'sunrise' => '05:59', 'dhuhr' => '12:09', 'asr' => '16:28', 'sunset' => '18:14', 'iftar' => '18:14', 'maghrib' => '18:14', 'isha' => '19:27' ],
			'03-24' => [ 'sahri' => '04:39', 'fajr' => '04:45', 'sunrise' => '05:58', 'dhuhr' => '12:08', 'asr' => '16:28', 'sunset' => '18:14', 'iftar' => '18:14', 'maghrib' => '18:14', 'isha' => '19:28' ],
			'03-25' => [ 'sahri' => '04:37', 'fajr' => '04:43', 'sunrise' => '05:57', 'dhuhr' => '12:08', 'asr' => '16:28', 'sunset' => '18:15', 'iftar' => '18:15', 'maghrib' => '18:15', 'isha' => '19:29' ],
			'03-26' => [ 'sahri' => '04:36', 'fajr' => '04:42', 'sunrise' => '05:56', 'dhuhr' => '12:08', 'asr' => '16:28', 'sunset' => '18:15', 'iftar' => '18:15', 'maghrib' => '18:15', 'isha' => '19:29' ],
			'03-27' => [ 'sahri' => '04:35', 'fajr' => '04:41', 'sunrise' => '05:55', 'dhuhr' => '12:07', 'asr' => '16:29', 'sunset' => '18:15', 'iftar' => '18:15', 'maghrib' => '18:15', 'isha' => '19:30' ],
			'03-28' => [ 'sahri' => '04:34', 'fajr' => '04:40', 'sunrise' => '05:54', 'dhuhr' => '12:07', 'asr' => '16:29', 'sunset' => '18:16', 'iftar' => '18:16', 'maghrib' => '18:16', 'isha' => '19:30' ],
			'03-29' => [ 'sahri' => '04:32', 'fajr' => '04:38', 'sunrise' => '05:53', 'dhuhr' => '12:07', 'asr' => '16:29', 'sunset' => '18:16', 'iftar' => '18:16', 'maghrib' => '18:16', 'isha' => '19:31' ],
			'03-30' => [ 'sahri' => '04:31', 'fajr' => '04:37', 'sunrise' => '05:52', 'dhuhr' => '12:06', 'asr' => '16:29', 'sunset' => '18:16', 'iftar' => '18:16', 'maghrib' => '18:16', 'isha' => '19:31' ],
			'03-31' => [ 'sahri' => '04:30', 'fajr' => '04:36', 'sunrise' => '05:51', 'dhuhr' => '12:06', 'asr' => '16:29', 'sunset' => '18:17', 'iftar' => '18:17', 'maghrib' => '18:17', 'isha' => '19:32' ],
		];

		return $this->adjust_time( $data );
	}

	public function april() {
		$data = [
			'04-01' => [ 'sahri' => '04:29', 'fajr' => '04:35', 'sunrise' => '05:50', 'dhuhr' => '12:06', 'asr' => '16:29', 'sunset' => '18:17', 'iftar' => '18:17', 'maghrib' => '18:17', 'isha' => '19:32' ],
			'04-02' => [ 'sahri' => '04:28', 'fajr' => '04:34', 'sunrise' => '05:49', 'dhuhr' => '12:06', 'asr' => '16:29', 'sunset' => '18:18', 'iftar' => '18:18', 'maghrib' => '18:18', 'isha' => '19:33' ],
			'04-03' => [ 'sahri' => '04:27', 'fajr' => '04:33', 'sunrise' => '05:48', 'dhuhr' => '12:05', 'asr' => '16:29', 'sunset' => '18:18', 'iftar' => '18:18', 'maghrib' => '18:18', 'isha' => '19:33' ],
			'04-04' => [ 'sahri' => '04:26', 'fajr' => '04:32', 'sunrise' => '05:47', 'dhuhr' => '12:05', 'asr' => '16:29', 'sunset' => '18:19', 'iftar' => '18:19', 'maghrib' => '18:19', 'isha' => '19:34' ],
			'04-05' => [ 'sahri' => '04:25', 'fajr' => '04:31', 'sunrise' => '05:46', 'dhuhr' => '12:05', 'asr' => '16:29', 'sunset' => '18:19', 'iftar' => '18:19', 'maghrib' => '18:19', 'isha' => '19:34' ],
			'04-06' => [ 'sahri' => '04:24', 'fajr' => '04:30', 'sunrise' => '05:45', 'dhuhr' => '12:05', 'asr' => '16:29', 'sunset' => '18:20', 'iftar' => '18:20', 'maghrib' => '18:20', 'isha' => '19:35' ],
			'04-07' => [ 'sahri' => '04:23', 'fajr' => '04:29', 'sunrise' => '05:44', 'dhuhr' => '12:04', 'asr' => '16:29', 'sunset' => '18:20', 'iftar' => '18:20', 'maghrib' => '18:20', 'isha' => '19:35' ],
			'04-08' => [ 'sahri' => '04:22', 'fajr' => '04:28', 'sunrise' => '05:43', 'dhuhr' => '12:04', 'asr' => '16:30', 'sunset' => '18:21', 'iftar' => '18:21', 'maghrib' => '18:21', 'isha' => '19:36' ],
			'04-09' => [ 'sahri' => '04:21', 'fajr' => '04:27', 'sunrise' => '05:42', 'dhuhr' => '12:04', 'asr' => '16:30', 'sunset' => '18:21', 'iftar' => '18:21', 'maghrib' => '18:21', 'isha' => '19:36' ],
			'04-10' => [ 'sahri' => '04:20', 'fajr' => '04:26', 'sunrise' => '05:41', 'dhuhr' => '12:04', 'asr' => '16:30', 'sunset' => '18:22', 'iftar' => '18:22', 'maghrib' => '18:22', 'isha' => '19:37' ],
			'04-11' => [ 'sahri' => '04:19', 'fajr' => '04:25', 'sunrise' => '05:40', 'dhuhr' => '12:03', 'asr' => '16:30', 'sunset' => '18:22', 'iftar' => '18:22', 'maghrib' => '18:22', 'isha' => '19:37' ],
			'04-12' => [ 'sahri' => '04:18', 'fajr' => '04:24', 'sunrise' => '05:39', 'dhuhr' => '12:03', 'asr' => '16:30', 'sunset' => '18:23', 'iftar' => '18:23', 'maghrib' => '18:23', 'isha' => '19:38' ],
			'04-13' => [ 'sahri' => '04:17', 'fajr' => '04:23', 'sunrise' => '05:38', 'dhuhr' => '12:03', 'asr' => '16:30', 'sunset' => '18:23', 'iftar' => '18:23', 'maghrib' => '18:23', 'isha' => '19:39' ],
			'04-14' => [ 'sahri' => '04:15', 'fajr' => '04:22', 'sunrise' => '05:37', 'dhuhr' => '12:02', 'asr' => '16:30', 'sunset' => '18:24', 'iftar' => '18:24', 'maghrib' => '18:24', 'isha' => '19:39' ],
			'04-15' => [ 'sahri' => '04:14', 'fajr' => '04:21', 'sunrise' => '05:36', 'dhuhr' => '12:02', 'asr' => '16:30', 'sunset' => '18:24', 'iftar' => '18:24', 'maghrib' => '18:24', 'isha' => '19:40' ],
			'04-16' => [ 'sahri' => '04:13', 'fajr' => '04:20', 'sunrise' => '05:36', 'dhuhr' => '12:02', 'asr' => '16:30', 'sunset' => '18:24', 'iftar' => '18:24', 'maghrib' => '18:24', 'isha' => '19:41' ],
			'04-17' => [ 'sahri' => '04:12', 'fajr' => '04:18', 'sunrise' => '05:35', 'dhuhr' => '12:01', 'asr' => '16:30', 'sunset' => '18:25', 'iftar' => '18:25', 'maghrib' => '18:25', 'isha' => '19:41' ],
			'04-18' => [ 'sahri' => '04:11', 'fajr' => '04:17', 'sunrise' => '05:34', 'dhuhr' => '12:01', 'asr' => '16:30', 'sunset' => '18:25', 'iftar' => '18:25', 'maghrib' => '18:25', 'isha' => '19:42' ],
			'04-19' => [ 'sahri' => '04:10', 'fajr' => '04:16', 'sunrise' => '05:33', 'dhuhr' => '12:01', 'asr' => '16:30', 'sunset' => '18:26', 'iftar' => '18:26', 'maghrib' => '18:26', 'isha' => '19:42' ],
			'04-20' => [ 'sahri' => '04:09', 'fajr' => '04:15', 'sunrise' => '05:32', 'dhuhr' => '12:01', 'asr' => '16:30', 'sunset' => '18:26', 'iftar' => '18:26', 'maghrib' => '18:26', 'isha' => '19:43' ],
			'04-21' => [ 'sahri' => '04:08', 'fajr' => '04:14', 'sunrise' => '05:31', 'dhuhr' => '12:00', 'asr' => '16:30', 'sunset' => '18:27', 'iftar' => '18:27', 'maghrib' => '18:27', 'isha' => '19:44' ],
			'04-22' => [ 'sahri' => '04:07', 'fajr' => '04:13', 'sunrise' => '05:30', 'dhuhr' => '12:00', 'asr' => '16:30', 'sunset' => '18:27', 'iftar' => '18:27', 'maghrib' => '18:27', 'isha' => '19:44' ],
			'04-23' => [ 'sahri' => '04:06', 'fajr' => '04:12', 'sunrise' => '05:29', 'dhuhr' => '12:00', 'asr' => '16:30', 'sunset' => '18:27', 'iftar' => '18:27', 'maghrib' => '18:27', 'isha' => '19:45' ],
			'04-24' => [ 'sahri' => '04:05', 'fajr' => '04:11', 'sunrise' => '05:29', 'dhuhr' => '12:00', 'asr' => '16:30', 'sunset' => '18:28', 'iftar' => '18:28', 'maghrib' => '18:28', 'isha' => '19:45' ],
			'04-25' => [ 'sahri' => '04:04', 'fajr' => '04:10', 'sunrise' => '05:28', 'dhuhr' => '11:59', 'asr' => '16:30', 'sunset' => '18:28', 'iftar' => '18:28', 'maghrib' => '18:28', 'isha' => '19:46' ],
			'04-26' => [ 'sahri' => '04:03', 'fajr' => '04:09', 'sunrise' => '05:27', 'dhuhr' => '11:59', 'asr' => '16:30', 'sunset' => '18:29', 'iftar' => '18:29', 'maghrib' => '18:29', 'isha' => '19:47' ],
			'04-27' => [ 'sahri' => '04:02', 'fajr' => '04:09', 'sunrise' => '05:26', 'dhuhr' => '11:59', 'asr' => '16:30', 'sunset' => '18:29', 'iftar' => '18:29', 'maghrib' => '18:29', 'isha' => '19:47' ],
			'04-28' => [ 'sahri' => '04:01', 'fajr' => '04:08', 'sunrise' => '05:25', 'dhuhr' => '11:59', 'asr' => '16:31', 'sunset' => '18:30', 'iftar' => '18:30', 'maghrib' => '18:30', 'isha' => '19:48' ],
			'04-29' => [ 'sahri' => '04:00', 'fajr' => '04:07', 'sunrise' => '05:24', 'dhuhr' => '11:59', 'asr' => '16:31', 'sunset' => '18:30', 'iftar' => '18:30', 'maghrib' => '18:30', 'isha' => '19:48' ],
			'04-30' => [ 'sahri' => '04:00', 'fajr' => '04:06', 'sunrise' => '05:24', 'dhuhr' => '11:59', 'asr' => '16:31', 'sunset' => '18:30', 'iftar' => '18:30', 'maghrib' => '18:30', 'isha' => '19:49' ],
		];

		return $this->adjust_time( $data );
	}

	public function may() {
		$data = [
			'05-01' => [ 'sahri' => '03:59', 'fajr' => '04:05', 'sunrise' => '05:24', 'dhuhr' => '11:59', 'asr' => '16:31', 'sunset' => '18:31', 'iftar' => '18:31', 'maghrib' => '18:31', 'isha' => '19:50' ],
			'05-02' => [ 'sahri' => '03:57', 'fajr' => '04:04', 'sunrise' => '05:23', 'dhuhr' => '11:59', 'asr' => '16:31', 'sunset' => '18:31', 'iftar' => '18:31', 'maghrib' => '18:31', 'isha' => '19:50' ],
			'05-03' => [ 'sahri' => '03:56', 'fajr' => '04:03', 'sunrise' => '05:22', 'dhuhr' => '11:59', 'asr' => '16:31', 'sunset' => '18:32', 'iftar' => '18:32', 'maghrib' => '18:32', 'isha' => '19:51' ],
			'05-04' => [ 'sahri' => '03:55', 'fajr' => '04:01', 'sunrise' => '05:22', 'dhuhr' => '11:59', 'asr' => '16:31', 'sunset' => '18:32', 'iftar' => '18:32', 'maghrib' => '18:32', 'isha' => '19:52' ],
			'05-05' => [ 'sahri' => '03:54', 'fajr' => '04:00', 'sunrise' => '05:21', 'dhuhr' => '11:59', 'asr' => '16:31', 'sunset' => '18:33', 'iftar' => '18:33', 'maghrib' => '18:33', 'isha' => '19:53' ],
			'05-06' => [ 'sahri' => '03:53', 'fajr' => '03:59', 'sunrise' => '05:20', 'dhuhr' => '11:59', 'asr' => '16:31', 'sunset' => '18:33', 'iftar' => '18:33', 'maghrib' => '18:33', 'isha' => '19:54' ],
			'05-07' => [ 'sahri' => '03:53', 'fajr' => '03:59', 'sunrise' => '05:20', 'dhuhr' => '11:59', 'asr' => '16:31', 'sunset' => '18:34', 'iftar' => '18:34', 'maghrib' => '18:34', 'isha' => '19:54' ],
			'05-08' => [ 'sahri' => '03:52', 'fajr' => '03:58', 'sunrise' => '05:19', 'dhuhr' => '11:58', 'asr' => '16:31', 'sunset' => '18:34', 'iftar' => '18:34', 'maghrib' => '18:34', 'isha' => '19:55' ],
			'05-09' => [ 'sahri' => '03:51', 'fajr' => '03:57', 'sunrise' => '05:19', 'dhuhr' => '11:58', 'asr' => '16:31', 'sunset' => '18:34', 'iftar' => '18:34', 'maghrib' => '18:34', 'isha' => '19:56' ],
			'05-10' => [ 'sahri' => '03:50', 'fajr' => '03:56', 'sunrise' => '05:18', 'dhuhr' => '11:58', 'asr' => '16:32', 'sunset' => '18:35', 'iftar' => '18:35', 'maghrib' => '18:35', 'isha' => '19:57' ],
			'05-11' => [ 'sahri' => '03:49', 'fajr' => '03:55', 'sunrise' => '05:17', 'dhuhr' => '11:58', 'asr' => '16:32', 'sunset' => '18:35', 'iftar' => '18:35', 'maghrib' => '18:35', 'isha' => '19:58' ],
			'05-12' => [ 'sahri' => '03:49', 'fajr' => '03:55', 'sunrise' => '05:17', 'dhuhr' => '11:58', 'asr' => '16:32', 'sunset' => '18:36', 'iftar' => '18:36', 'maghrib' => '18:36', 'isha' => '19:58' ],
			'05-13' => [ 'sahri' => '03:48', 'fajr' => '03:54', 'sunrise' => '05:16', 'dhuhr' => '11:58', 'asr' => '16:32', 'sunset' => '18:36', 'iftar' => '18:36', 'maghrib' => '18:36', 'isha' => '19:59' ],
			'05-14' => [ 'sahri' => '03:48', 'fajr' => '03:54', 'sunrise' => '05:16', 'dhuhr' => '11:58', 'asr' => '16:32', 'sunset' => '18:37', 'iftar' => '18:37', 'maghrib' => '18:37', 'isha' => '19:59' ],
			'05-15' => [ 'sahri' => '03:47', 'fajr' => '03:53', 'sunrise' => '05:15', 'dhuhr' => '11:58', 'asr' => '16:32', 'sunset' => '18:37', 'iftar' => '18:37', 'maghrib' => '18:37', 'isha' => '20:00' ],
			'05-16' => [ 'sahri' => '03:47', 'fajr' => '03:53', 'sunrise' => '05:15', 'dhuhr' => '11:58', 'asr' => '16:32', 'sunset' => '18:38', 'iftar' => '18:38', 'maghrib' => '18:38', 'isha' => '20:00' ],
			'05-17' => [ 'sahri' => '03:46', 'fajr' => '03:52', 'sunrise' => '05:14', 'dhuhr' => '11:58', 'asr' => '16:32', 'sunset' => '18:38', 'iftar' => '18:38', 'maghrib' => '18:38', 'isha' => '20:00' ],
			'05-18' => [ 'sahri' => '03:46', 'fajr' => '03:52', 'sunrise' => '05:14', 'dhuhr' => '11:58', 'asr' => '16:33', 'sunset' => '18:39', 'iftar' => '18:39', 'maghrib' => '18:39', 'isha' => '20:01' ],
			'05-19' => [ 'sahri' => '03:45', 'fajr' => '03:51', 'sunrise' => '05:14', 'dhuhr' => '11:58', 'asr' => '16:33', 'sunset' => '18:39', 'iftar' => '18:39', 'maghrib' => '18:39', 'isha' => '20:02' ],
			'05-20' => [ 'sahri' => '03:44', 'fajr' => '03:50', 'sunrise' => '05:13', 'dhuhr' => '11:58', 'asr' => '16:33', 'sunset' => '18:40', 'iftar' => '18:40', 'maghrib' => '18:40', 'isha' => '20:03' ],
			'05-21' => [ 'sahri' => '03:44', 'fajr' => '03:50', 'sunrise' => '05:13', 'dhuhr' => '11:58', 'asr' => '16:33', 'sunset' => '18:40', 'iftar' => '18:40', 'maghrib' => '18:40', 'isha' => '20:03' ],
			'05-22' => [ 'sahri' => '03:43', 'fajr' => '03:49', 'sunrise' => '05:13', 'dhuhr' => '11:59', 'asr' => '16:33', 'sunset' => '18:41', 'iftar' => '18:41', 'maghrib' => '18:41', 'isha' => '20:04' ],
			'05-23' => [ 'sahri' => '03:42', 'fajr' => '03:49', 'sunrise' => '05:12', 'dhuhr' => '11:59', 'asr' => '16:34', 'sunset' => '18:41', 'iftar' => '18:41', 'maghrib' => '18:41', 'isha' => '20:05' ],
			'05-24' => [ 'sahri' => '03:42', 'fajr' => '03:48', 'sunrise' => '05:12', 'dhuhr' => '11:59', 'asr' => '16:34', 'sunset' => '18:42', 'iftar' => '18:42', 'maghrib' => '18:42', 'isha' => '20:06' ],
			'05-25' => [ 'sahri' => '03:41', 'fajr' => '03:48', 'sunrise' => '05:12', 'dhuhr' => '11:59', 'asr' => '16:34', 'sunset' => '18:42', 'iftar' => '18:42', 'maghrib' => '18:42', 'isha' => '20:06' ],
			'05-26' => [ 'sahri' => '03:41', 'fajr' => '03:48', 'sunrise' => '05:11', 'dhuhr' => '11:59', 'asr' => '16:34', 'sunset' => '18:43', 'iftar' => '18:43', 'maghrib' => '18:43', 'isha' => '20:07' ],
			'05-27' => [ 'sahri' => '03:41', 'fajr' => '03:47', 'sunrise' => '05:11', 'dhuhr' => '11:59', 'asr' => '16:34', 'sunset' => '18:43', 'iftar' => '18:43', 'maghrib' => '18:43', 'isha' => '20:07' ],
			'05-28' => [ 'sahri' => '03:40', 'fajr' => '03:47', 'sunrise' => '05:11', 'dhuhr' => '11:59', 'asr' => '16:34', 'sunset' => '18:44', 'iftar' => '18:44', 'maghrib' => '18:44', 'isha' => '20:08' ],
			'05-29' => [ 'sahri' => '03:40', 'fajr' => '03:46', 'sunrise' => '05:10', 'dhuhr' => '11:59', 'asr' => '16:35', 'sunset' => '18:44', 'iftar' => '18:44', 'maghrib' => '18:44', 'isha' => '20:09' ],
			'05-30' => [ 'sahri' => '03:40', 'fajr' => '03:46', 'sunrise' => '05:10', 'dhuhr' => '11:59', 'asr' => '16:35', 'sunset' => '18:44', 'iftar' => '18:44', 'maghrib' => '18:44', 'isha' => '20:09' ],
			'05-31' => [ 'sahri' => '03:39', 'fajr' => '03:46', 'sunrise' => '05:10', 'dhuhr' => '11:59', 'asr' => '16:35', 'sunset' => '18:46', 'iftar' => '18:46', 'maghrib' => '18:46', 'isha' => '20:10' ],
		];

		return $this->adjust_time( $data );
	}

	public function june() {
		$data = [
			'06-01' => [ 'sahri' => '03:39', 'fajr' => '03:45', 'sunrise' => '05:10', 'dhuhr' => '12:00', 'asr' => '16:35', 'sunset' => '18:45', 'iftar' => '18:45', 'maghrib' => '18:45', 'isha' => '20:11' ],
			'06-02' => [ 'sahri' => '03:39', 'fajr' => '03:45', 'sunrise' => '05:10', 'dhuhr' => '12:00', 'asr' => '16:35', 'sunset' => '18:46', 'iftar' => '18:46', 'maghrib' => '18:46', 'isha' => '20:11' ],
			'06-03' => [ 'sahri' => '03:38', 'fajr' => '03:45', 'sunrise' => '05:10', 'dhuhr' => '12:00', 'asr' => '16:36', 'sunset' => '18:46', 'iftar' => '18:46', 'maghrib' => '18:46', 'isha' => '20:12' ],
			'06-04' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:10', 'dhuhr' => '12:00', 'asr' => '16:36', 'sunset' => '18:47', 'iftar' => '18:47', 'maghrib' => '18:47', 'isha' => '20:12' ],
			'06-05' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:10', 'dhuhr' => '12:01', 'asr' => '16:36', 'sunset' => '18:47', 'iftar' => '18:47', 'maghrib' => '18:47', 'isha' => '20:13' ],
			'06-06' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:10', 'dhuhr' => '12:01', 'asr' => '16:36', 'sunset' => '18:47', 'iftar' => '18:47', 'maghrib' => '18:47', 'isha' => '20:13' ],
			'06-07' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:10', 'dhuhr' => '12:01', 'asr' => '16:36', 'sunset' => '18:48', 'iftar' => '18:48', 'maghrib' => '18:48', 'isha' => '20:14' ],
			'06-08' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:10', 'dhuhr' => '12:01', 'asr' => '16:37', 'sunset' => '18:48', 'iftar' => '18:48', 'maghrib' => '18:48', 'isha' => '20:14' ],
			'06-09' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:10', 'dhuhr' => '12:01', 'asr' => '16:37', 'sunset' => '18:49', 'iftar' => '18:49', 'maghrib' => '18:49', 'isha' => '20:15' ],
			'06-10' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:10', 'dhuhr' => '12:02', 'asr' => '16:37', 'sunset' => '18:49', 'iftar' => '18:49', 'maghrib' => '18:49', 'isha' => '20:15' ],
			'06-11' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:10', 'dhuhr' => '12:02', 'asr' => '16:37', 'sunset' => '18:49', 'iftar' => '18:49', 'maghrib' => '18:49', 'isha' => '20:16' ],
			'06-12' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:10', 'dhuhr' => '12:02', 'asr' => '16:38', 'sunset' => '18:50', 'iftar' => '18:50', 'maghrib' => '18:50', 'isha' => '20:16' ],
			'06-13' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:10', 'dhuhr' => '12:02', 'asr' => '16:38', 'sunset' => '18:50', 'iftar' => '18:50', 'maghrib' => '18:50', 'isha' => '20:16' ],
			'06-14' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:10', 'dhuhr' => '12:02', 'asr' => '16:38', 'sunset' => '18:50', 'iftar' => '18:50', 'maghrib' => '18:50', 'isha' => '20:17' ],
			'06-15' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:10', 'dhuhr' => '12:03', 'asr' => '16:38', 'sunset' => '18:50', 'iftar' => '18:50', 'maghrib' => '18:50', 'isha' => '20:17' ],
			'06-16' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:10', 'dhuhr' => '12:03', 'asr' => '16:38', 'sunset' => '18:51', 'iftar' => '18:51', 'maghrib' => '18:51', 'isha' => '20:17' ],
			'06-17' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:11', 'dhuhr' => '12:03', 'asr' => '16:39', 'sunset' => '18:51', 'iftar' => '18:51', 'maghrib' => '18:51', 'isha' => '20:18' ],
			'06-18' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:11', 'dhuhr' => '12:03', 'asr' => '16:39', 'sunset' => '18:51', 'iftar' => '18:51', 'maghrib' => '18:51', 'isha' => '20:18' ],
			'06-19' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:11', 'dhuhr' => '12:03', 'asr' => '16:39', 'sunset' => '18:51', 'iftar' => '18:51', 'maghrib' => '18:51', 'isha' => '20:18' ],
			'06-20' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:11', 'dhuhr' => '12:04', 'asr' => '16:39', 'sunset' => '18:52', 'iftar' => '18:52', 'maghrib' => '18:52', 'isha' => '20:18' ],
			'06-21' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:11', 'dhuhr' => '12:04', 'asr' => '16:40', 'sunset' => '18:52', 'iftar' => '18:52', 'maghrib' => '18:52', 'isha' => '20:18' ],
			'06-22' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:11', 'dhuhr' => '12:04', 'asr' => '16:40', 'sunset' => '18:52', 'iftar' => '18:52', 'maghrib' => '18:52', 'isha' => '20:18' ],
			'06-23' => [ 'sahri' => '03:38', 'fajr' => '03:44', 'sunrise' => '05:11', 'dhuhr' => '12:04', 'asr' => '16:40', 'sunset' => '18:52', 'iftar' => '18:52', 'maghrib' => '18:52', 'isha' => '20:19' ],
			'06-24' => [ 'sahri' => '03:39', 'fajr' => '03:45', 'sunrise' => '05:11', 'dhuhr' => '12:04', 'asr' => '16:40', 'sunset' => '18:53', 'iftar' => '18:53', 'maghrib' => '18:53', 'isha' => '20:19' ],
			'06-25' => [ 'sahri' => '03:40', 'fajr' => '03:45', 'sunrise' => '05:12', 'dhuhr' => '12:05', 'asr' => '16:40', 'sunset' => '18:53', 'iftar' => '18:53', 'maghrib' => '18:53', 'isha' => '20:19' ],
			'06-26' => [ 'sahri' => '03:40', 'fajr' => '03:46', 'sunrise' => '05:12', 'dhuhr' => '12:05', 'asr' => '16:41', 'sunset' => '18:53', 'iftar' => '18:53', 'maghrib' => '18:53', 'isha' => '20:19' ],
			'06-27' => [ 'sahri' => '03:41', 'fajr' => '03:46', 'sunrise' => '05:12', 'dhuhr' => '12:05', 'asr' => '16:41', 'sunset' => '18:53', 'iftar' => '18:53', 'maghrib' => '18:53', 'isha' => '20:19' ],
			'06-28' => [ 'sahri' => '03:42', 'fajr' => '03:47', 'sunrise' => '05:13', 'dhuhr' => '12:05', 'asr' => '16:41', 'sunset' => '18:53', 'iftar' => '18:53', 'maghrib' => '18:53', 'isha' => '20:20' ],
			'06-29' => [ 'sahri' => '03:42', 'fajr' => '03:47', 'sunrise' => '05:13', 'dhuhr' => '12:05', 'asr' => '16:41', 'sunset' => '18:53', 'iftar' => '18:53', 'maghrib' => '18:53', 'isha' => '20:20' ],
			'06-30' => [ 'sahri' => '03:43', 'fajr' => '03:48', 'sunrise' => '05:14', 'dhuhr' => '12:06', 'asr' => '16:42', 'sunset' => '18:54', 'iftar' => '18:54', 'maghrib' => '18:54', 'isha' => '20:20' ],
		];

		return $this->adjust_time( $data );
	}

	public function july() {
		$data = [
			'07-01' => [ 'sahri' => '03:42', 'fajr' => '03:48', 'sunrise' => '05:14', 'dhuhr' => '12:06', 'asr' => '16:42', 'sunset' => '18:54', 'iftar' => '18:54', 'maghrib' => '18:54', 'isha' => '20:20' ],
			'07-02' => [ 'sahri' => '03:42', 'fajr' => '03:48', 'sunrise' => '05:15', 'dhuhr' => '12:06', 'asr' => '16:42', 'sunset' => '18:54', 'iftar' => '18:54', 'maghrib' => '18:54', 'isha' => '20:20' ],
			'07-03' => [ 'sahri' => '03:43', 'fajr' => '03:49', 'sunrise' => '05:15', 'dhuhr' => '12:06', 'asr' => '16:42', 'sunset' => '18:54', 'iftar' => '18:54', 'maghrib' => '18:54', 'isha' => '20:20' ],
			'07-04' => [ 'sahri' => '03:43', 'fajr' => '03:49', 'sunrise' => '05:15', 'dhuhr' => '12:06', 'asr' => '16:42', 'sunset' => '18:54', 'iftar' => '18:54', 'maghrib' => '18:54', 'isha' => '20:20' ],
			'07-05' => [ 'sahri' => '03:43', 'fajr' => '03:49', 'sunrise' => '05:16', 'dhuhr' => '12:06', 'asr' => '16:43', 'sunset' => '18:54', 'iftar' => '18:54', 'maghrib' => '18:54', 'isha' => '20:20' ],
			'07-06' => [ 'sahri' => '03:44', 'fajr' => '03:50', 'sunrise' => '05:16', 'dhuhr' => '12:07', 'asr' => '16:43', 'sunset' => '18:54', 'iftar' => '18:54', 'maghrib' => '18:54', 'isha' => '20:20' ],
			'07-07' => [ 'sahri' => '03:45', 'fajr' => '03:51', 'sunrise' => '05:16', 'dhuhr' => '12:07', 'asr' => '16:43', 'sunset' => '18:54', 'iftar' => '18:54', 'maghrib' => '18:54', 'isha' => '20:19' ],
			'07-08' => [ 'sahri' => '03:45', 'fajr' => '03:51', 'sunrise' => '05:17', 'dhuhr' => '12:07', 'asr' => '16:43', 'sunset' => '18:54', 'iftar' => '18:54', 'maghrib' => '18:54', 'isha' => '20:19' ],
			'07-09' => [ 'sahri' => '03:46', 'fajr' => '03:52', 'sunrise' => '05:17', 'dhuhr' => '12:07', 'asr' => '16:43', 'sunset' => '18:54', 'iftar' => '18:54', 'maghrib' => '18:54', 'isha' => '20:19' ],
			'07-10' => [ 'sahri' => '03:47', 'fajr' => '03:52', 'sunrise' => '05:17', 'dhuhr' => '12:07', 'asr' => '16:43', 'sunset' => '18:53', 'iftar' => '18:53', 'maghrib' => '18:53', 'isha' => '20:18' ],
			'07-11' => [ 'sahri' => '03:47', 'fajr' => '03:53', 'sunrise' => '05:18', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:53', 'iftar' => '18:53', 'maghrib' => '18:53', 'isha' => '20:18' ],
			'07-12' => [ 'sahri' => '03:48', 'fajr' => '03:54', 'sunrise' => '05:18', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:53', 'iftar' => '18:53', 'maghrib' => '18:53', 'isha' => '20:18' ],
			'07-13' => [ 'sahri' => '03:48', 'fajr' => '03:54', 'sunrise' => '05:18', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:53', 'iftar' => '18:53', 'maghrib' => '18:53', 'isha' => '20:17' ],
			'07-14' => [ 'sahri' => '03:49', 'fajr' => '03:55', 'sunrise' => '05:19', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:53', 'iftar' => '18:53', 'maghrib' => '18:53', 'isha' => '20:17' ],
			'07-15' => [ 'sahri' => '03:50', 'fajr' => '03:55', 'sunrise' => '05:19', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:53', 'iftar' => '18:53', 'maghrib' => '18:53', 'isha' => '20:16' ],
			'07-16' => [ 'sahri' => '03:50', 'fajr' => '03:56', 'sunrise' => '05:20', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:52', 'iftar' => '18:52', 'maghrib' => '18:52', 'isha' => '20:16' ],
			'07-17' => [ 'sahri' => '03:51', 'fajr' => '03:57', 'sunrise' => '05:20', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:52', 'iftar' => '18:52', 'maghrib' => '18:52', 'isha' => '20:16' ],
			'07-18' => [ 'sahri' => '03:51', 'fajr' => '03:57', 'sunrise' => '05:21', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:52', 'iftar' => '18:52', 'maghrib' => '18:52', 'isha' => '20:15' ],
			'07-19' => [ 'sahri' => '03:52', 'fajr' => '03:58', 'sunrise' => '05:21', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:51', 'iftar' => '18:51', 'maghrib' => '18:51', 'isha' => '20:15' ],
			'07-20' => [ 'sahri' => '03:53', 'fajr' => '03:58', 'sunrise' => '05:22', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:51', 'iftar' => '18:51', 'maghrib' => '18:51', 'isha' => '20:14' ],
			'07-21' => [ 'sahri' => '03:53', 'fajr' => '03:59', 'sunrise' => '05:22', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:51', 'iftar' => '18:51', 'maghrib' => '18:51', 'isha' => '20:14' ],
			'07-22' => [ 'sahri' => '03:54', 'fajr' => '04:00', 'sunrise' => '05:23', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:50', 'iftar' => '18:50', 'maghrib' => '18:50', 'isha' => '20:13' ],
			'07-23' => [ 'sahri' => '03:54', 'fajr' => '04:00', 'sunrise' => '05:23', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:50', 'iftar' => '18:50', 'maghrib' => '18:50', 'isha' => '20:13' ],
			'07-24' => [ 'sahri' => '03:55', 'fajr' => '04:01', 'sunrise' => '05:24', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:49', 'iftar' => '18:49', 'maghrib' => '18:49', 'isha' => '20:12' ],
			'07-25' => [ 'sahri' => '03:56', 'fajr' => '04:01', 'sunrise' => '05:24', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:49', 'iftar' => '18:49', 'maghrib' => '18:49', 'isha' => '20:11' ],
			'07-26' => [ 'sahri' => '03:56', 'fajr' => '04:02', 'sunrise' => '05:24', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:48', 'iftar' => '18:48', 'maghrib' => '18:48', 'isha' => '20:11' ],
			'07-27' => [ 'sahri' => '03:57', 'fajr' => '04:03', 'sunrise' => '05:25', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:48', 'iftar' => '18:48', 'maghrib' => '18:48', 'isha' => '20:10' ],
			'07-28' => [ 'sahri' => '03:57', 'fajr' => '04:03', 'sunrise' => '05:25', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:48', 'iftar' => '18:48', 'maghrib' => '18:48', 'isha' => '20:09' ],
			'07-29' => [ 'sahri' => '03:58', 'fajr' => '04:04', 'sunrise' => '05:26', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:47', 'iftar' => '18:47', 'maghrib' => '18:47', 'isha' => '20:09' ],
			'07-30' => [ 'sahri' => '03:59', 'fajr' => '04:04', 'sunrise' => '05:26', 'dhuhr' => '12:08', 'asr' => '16:43', 'sunset' => '18:47', 'iftar' => '18:47', 'maghrib' => '18:47', 'isha' => '20:07' ],
			'07-31' => [ 'sahri' => '03:59', 'fajr' => '04:05', 'sunrise' => '05:26', 'dhuhr' => '12:08', 'asr' => '16:42', 'sunset' => '18:46', 'iftar' => '18:46', 'maghrib' => '18:46', 'isha' => '20:06' ],
		];

		return $this->adjust_time( $data );
	}

	public function august() {
		$data = [
			'08-01' => [ 'sahri' => '04:00', 'fajr' => '04:06', 'sunrise' => '05:27', 'dhuhr' => '12:08', 'asr' => '16:42', 'sunset' => '18:45', 'iftar' => '18:45', 'maghrib' => '18:45', 'isha' => '20:05' ],
			'08-02' => [ 'sahri' => '04:01', 'fajr' => '04:07', 'sunrise' => '05:27', 'dhuhr' => '12:08', 'asr' => '16:42', 'sunset' => '18:45', 'iftar' => '18:45', 'maghrib' => '18:45', 'isha' => '20:05' ],
			'08-03' => [ 'sahri' => '04:01', 'fajr' => '04:07', 'sunrise' => '05:28', 'dhuhr' => '12:08', 'asr' => '16:42', 'sunset' => '18:44', 'iftar' => '18:44', 'maghrib' => '18:44', 'isha' => '20:04' ],
			'08-04' => [ 'sahri' => '04:02', 'fajr' => '04:08', 'sunrise' => '05:28', 'dhuhr' => '12:08', 'asr' => '16:42', 'sunset' => '18:43', 'iftar' => '18:43', 'maghrib' => '18:43', 'isha' => '20:03' ],
			'08-05' => [ 'sahri' => '04:03', 'fajr' => '04:09', 'sunrise' => '05:28', 'dhuhr' => '12:08', 'asr' => '16:41', 'sunset' => '18:43', 'iftar' => '18:43', 'maghrib' => '18:43', 'isha' => '20:02' ],
			'08-06' => [ 'sahri' => '04:04', 'fajr' => '04:10', 'sunrise' => '05:29', 'dhuhr' => '12:08', 'asr' => '16:41', 'sunset' => '18:42', 'iftar' => '18:42', 'maghrib' => '18:42', 'isha' => '20:01' ],
			'08-07' => [ 'sahri' => '04:05', 'fajr' => '04:10', 'sunrise' => '05:29', 'dhuhr' => '12:08', 'asr' => '16:41', 'sunset' => '18:41', 'iftar' => '18:41', 'maghrib' => '18:41', 'isha' => '20:00' ],
			'08-08' => [ 'sahri' => '04:05', 'fajr' => '04:11', 'sunrise' => '05:30', 'dhuhr' => '12:08', 'asr' => '16:40', 'sunset' => '18:41', 'iftar' => '18:41', 'maghrib' => '18:41', 'isha' => '19:59' ],
			'08-09' => [ 'sahri' => '04:06', 'fajr' => '04:11', 'sunrise' => '05:30', 'dhuhr' => '12:08', 'asr' => '16:40', 'sunset' => '18:40', 'iftar' => '18:40', 'maghrib' => '18:40', 'isha' => '19:58' ],
			'08-10' => [ 'sahri' => '04:06', 'fajr' => '04:12', 'sunrise' => '05:31', 'dhuhr' => '12:08', 'asr' => '16:40', 'sunset' => '18:39', 'iftar' => '18:39', 'maghrib' => '18:39', 'isha' => '19:57' ],
			'08-11' => [ 'sahri' => '04:07', 'fajr' => '04:13', 'sunrise' => '05:31', 'dhuhr' => '12:07', 'asr' => '16:39', 'sunset' => '18:39', 'iftar' => '18:39', 'maghrib' => '18:39', 'isha' => '19:56' ],
			'08-12' => [ 'sahri' => '04:07', 'fajr' => '04:13', 'sunrise' => '05:32', 'dhuhr' => '12:07', 'asr' => '16:39', 'sunset' => '18:38', 'iftar' => '18:38', 'maghrib' => '18:38', 'isha' => '19:56' ],
			'08-13' => [ 'sahri' => '04:08', 'fajr' => '04:14', 'sunrise' => '05:32', 'dhuhr' => '12:07', 'asr' => '16:39', 'sunset' => '18:37', 'iftar' => '18:37', 'maghrib' => '18:37', 'isha' => '19:55' ],
			'08-14' => [ 'sahri' => '04:09', 'fajr' => '04:15', 'sunrise' => '05:33', 'dhuhr' => '12:06', 'asr' => '16:38', 'sunset' => '18:36', 'iftar' => '18:36', 'maghrib' => '18:36', 'isha' => '19:54' ],
			'08-15' => [ 'sahri' => '04:09', 'fajr' => '04:15', 'sunrise' => '05:33', 'dhuhr' => '12:06', 'asr' => '16:38', 'sunset' => '18:36', 'iftar' => '18:36', 'maghrib' => '18:36', 'isha' => '19:53' ],
			'08-16' => [ 'sahri' => '04:10', 'fajr' => '04:16', 'sunrise' => '05:33', 'dhuhr' => '12:05', 'asr' => '16:38', 'sunset' => '18:35', 'iftar' => '18:35', 'maghrib' => '18:35', 'isha' => '19:52' ],
			'08-17' => [ 'sahri' => '04:10', 'fajr' => '04:16', 'sunrise' => '05:34', 'dhuhr' => '12:05', 'asr' => '16:37', 'sunset' => '18:34', 'iftar' => '18:34', 'maghrib' => '18:34', 'isha' => '19:51' ],
			'08-18' => [ 'sahri' => '04:11', 'fajr' => '04:17', 'sunrise' => '05:34', 'dhuhr' => '12:05', 'asr' => '16:37', 'sunset' => '18:33', 'iftar' => '18:33', 'maghrib' => '18:33', 'isha' => '19:50' ],
			'08-19' => [ 'sahri' => '04:12', 'fajr' => '04:18', 'sunrise' => '05:34', 'dhuhr' => '12:05', 'asr' => '16:37', 'sunset' => '18:32', 'iftar' => '18:32', 'maghrib' => '18:32', 'isha' => '19:49' ],
			'08-20' => [ 'sahri' => '04:12', 'fajr' => '04:18', 'sunrise' => '05:35', 'dhuhr' => '12:05', 'asr' => '16:36', 'sunset' => '18:32', 'iftar' => '18:32', 'maghrib' => '18:32', 'isha' => '19:48' ],
			'08-21' => [ 'sahri' => '04:13', 'fajr' => '04:19', 'sunrise' => '05:35', 'dhuhr' => '12:05', 'asr' => '16:36', 'sunset' => '18:31', 'iftar' => '18:31', 'maghrib' => '18:31', 'isha' => '19:47' ],
			'08-22' => [ 'sahri' => '04:13', 'fajr' => '04:19', 'sunrise' => '05:35', 'dhuhr' => '12:05', 'asr' => '16:35', 'sunset' => '18:30', 'iftar' => '18:30', 'maghrib' => '18:30', 'isha' => '19:46' ],
			'08-23' => [ 'sahri' => '04:14', 'fajr' => '04:20', 'sunrise' => '05:36', 'dhuhr' => '12:04', 'asr' => '16:35', 'sunset' => '18:29', 'iftar' => '18:29', 'maghrib' => '18:29', 'isha' => '19:45' ],
			'08-24' => [ 'sahri' => '04:14', 'fajr' => '04:20', 'sunrise' => '05:36', 'dhuhr' => '12:04', 'asr' => '16:34', 'sunset' => '18:28', 'iftar' => '18:28', 'maghrib' => '18:28', 'isha' => '19:44' ],
			'08-25' => [ 'sahri' => '04:15', 'fajr' => '04:21', 'sunrise' => '05:37', 'dhuhr' => '12:04', 'asr' => '16:33', 'sunset' => '18:27', 'iftar' => '18:27', 'maghrib' => '18:27', 'isha' => '19:43' ],
			'08-26' => [ 'sahri' => '04:15', 'fajr' => '04:21', 'sunrise' => '05:37', 'dhuhr' => '12:03', 'asr' => '16:33', 'sunset' => '18:26', 'iftar' => '18:26', 'maghrib' => '18:26', 'isha' => '19:42' ],
			'08-27' => [ 'sahri' => '04:16', 'fajr' => '04:22', 'sunrise' => '05:37', 'dhuhr' => '12:03', 'asr' => '16:32', 'sunset' => '18:25', 'iftar' => '18:25', 'maghrib' => '18:25', 'isha' => '19:41' ],
			'08-28' => [ 'sahri' => '04:16', 'fajr' => '04:22', 'sunrise' => '05:38', 'dhuhr' => '12:03', 'asr' => '16:32', 'sunset' => '18:24', 'iftar' => '18:24', 'maghrib' => '18:24', 'isha' => '19:40' ],
			'08-29' => [ 'sahri' => '04:16', 'fajr' => '04:22', 'sunrise' => '05:38', 'dhuhr' => '12:03', 'asr' => '16:31', 'sunset' => '18:23', 'iftar' => '18:23', 'maghrib' => '18:23', 'isha' => '19:39' ],
			'08-30' => [ 'sahri' => '04:17', 'fajr' => '04:23', 'sunrise' => '05:39', 'dhuhr' => '12:02', 'asr' => '16:31', 'sunset' => '18:22', 'iftar' => '18:22', 'maghrib' => '18:22', 'isha' => '19:38' ],
			'08-31' => [ 'sahri' => '04:17', 'fajr' => '04:23', 'sunrise' => '05:39', 'dhuhr' => '12:02', 'asr' => '16:30', 'sunset' => '18:21', 'iftar' => '18:21', 'maghrib' => '18:21', 'isha' => '19:37' ],
		];

		return $this->adjust_time( $data );
	}

	public function september() {
		$data = [
			'09-01' => [ 'sahri' => '04:18', 'fajr' => '04:24', 'sunrise' => '05:39', 'dhuhr' => '12:02', 'asr' => '16:29', 'sunset' => '18:20', 'iftar' => '18:20', 'maghrib' => '18:20', 'isha' => '19:36' ],
			'09-02' => [ 'sahri' => '04:19', 'fajr' => '04:24', 'sunrise' => '05:40', 'dhuhr' => '12:01', 'asr' => '16:28', 'sunset' => '18:19', 'iftar' => '18:19', 'maghrib' => '18:19', 'isha' => '19:35' ],
			'09-03' => [ 'sahri' => '04:19', 'fajr' => '04:25', 'sunrise' => '05:40', 'dhuhr' => '12:01', 'asr' => '16:28', 'sunset' => '18:18', 'iftar' => '18:18', 'maghrib' => '18:18', 'isha' => '19:33' ],
			'09-04' => [ 'sahri' => '04:20', 'fajr' => '04:25', 'sunrise' => '05:40', 'dhuhr' => '12:01', 'asr' => '16:27', 'sunset' => '18:17', 'iftar' => '18:17', 'maghrib' => '18:17', 'isha' => '19:32' ],
			'09-05' => [ 'sahri' => '04:20', 'fajr' => '04:26', 'sunrise' => '05:41', 'dhuhr' => '12:00', 'asr' => '16:26', 'sunset' => '18:16', 'iftar' => '18:16', 'maghrib' => '18:16', 'isha' => '19:31' ],
			'09-06' => [ 'sahri' => '04:21', 'fajr' => '04:27', 'sunrise' => '05:41', 'dhuhr' => '12:00', 'asr' => '16:25', 'sunset' => '18:15', 'iftar' => '18:15', 'maghrib' => '18:15', 'isha' => '19:30' ],
			'09-07' => [ 'sahri' => '04:21', 'fajr' => '04:27', 'sunrise' => '05:41', 'dhuhr' => '12:00', 'asr' => '16:25', 'sunset' => '18:14', 'iftar' => '18:14', 'maghrib' => '18:14', 'isha' => '19:29' ],
			'09-08' => [ 'sahri' => '04:22', 'fajr' => '04:27', 'sunrise' => '05:42', 'dhuhr' => '12:00', 'asr' => '16:24', 'sunset' => '18:13', 'iftar' => '18:13', 'maghrib' => '18:13', 'isha' => '19:28' ],
			'09-09' => [ 'sahri' => '04:22', 'fajr' => '04:28', 'sunrise' => '05:42', 'dhuhr' => '11:59', 'asr' => '16:23', 'sunset' => '18:12', 'iftar' => '18:12', 'maghrib' => '18:12', 'isha' => '19:26' ],
			'09-10' => [ 'sahri' => '04:22', 'fajr' => '04:28', 'sunrise' => '05:42', 'dhuhr' => '11:59', 'asr' => '16:22', 'sunset' => '18:11', 'iftar' => '18:11', 'maghrib' => '18:11', 'isha' => '19:25' ],
			'09-11' => [ 'sahri' => '04:23', 'fajr' => '04:29', 'sunrise' => '05:43', 'dhuhr' => '11:59', 'asr' => '16:22', 'sunset' => '18:10', 'iftar' => '18:10', 'maghrib' => '18:10', 'isha' => '19:24' ],
			'09-12' => [ 'sahri' => '04:23', 'fajr' => '04:29', 'sunrise' => '05:43', 'dhuhr' => '11:58', 'asr' => '16:21', 'sunset' => '18:09', 'iftar' => '18:09', 'maghrib' => '18:09', 'isha' => '19:23' ],
			'09-13' => [ 'sahri' => '04:24', 'fajr' => '04:30', 'sunrise' => '05:44', 'dhuhr' => '11:58', 'asr' => '16:20', 'sunset' => '18:08', 'iftar' => '18:08', 'maghrib' => '18:08', 'isha' => '19:22' ],
			'09-14' => [ 'sahri' => '04:24', 'fajr' => '04:30', 'sunrise' => '05:44', 'dhuhr' => '11:58', 'asr' => '16:19', 'sunset' => '18:07', 'iftar' => '18:07', 'maghrib' => '18:07', 'isha' => '19:20' ],
			'09-15' => [ 'sahri' => '04:24', 'fajr' => '04:31', 'sunrise' => '05:45', 'dhuhr' => '11:57', 'asr' => '16:19', 'sunset' => '18:06', 'iftar' => '18:06', 'maghrib' => '18:06', 'isha' => '19:19' ],
			'09-16' => [ 'sahri' => '04:25', 'fajr' => '04:31', 'sunrise' => '05:45', 'dhuhr' => '11:57', 'asr' => '16:18', 'sunset' => '18:05', 'iftar' => '18:05', 'maghrib' => '18:05', 'isha' => '19:18' ],
			'09-17' => [ 'sahri' => '04:25', 'fajr' => '04:32', 'sunrise' => '05:46', 'dhuhr' => '11:57', 'asr' => '16:17', 'sunset' => '18:04', 'iftar' => '18:04', 'maghrib' => '18:04', 'isha' => '19:17' ],
			'09-18' => [ 'sahri' => '04:26', 'fajr' => '04:32', 'sunrise' => '05:46', 'dhuhr' => '11:56', 'asr' => '16:17', 'sunset' => '18:03', 'iftar' => '18:03', 'maghrib' => '18:03', 'isha' => '19:16' ],
			'09-19' => [ 'sahri' => '04:26', 'fajr' => '04:33', 'sunrise' => '05:46', 'dhuhr' => '11:56', 'asr' => '16:16', 'sunset' => '18:02', 'iftar' => '18:02', 'maghrib' => '18:02', 'isha' => '19:15' ],
			'09-20' => [ 'sahri' => '04:27', 'fajr' => '04:33', 'sunrise' => '05:46', 'dhuhr' => '11:56', 'asr' => '16:15', 'sunset' => '18:01', 'iftar' => '18:01', 'maghrib' => '18:01', 'isha' => '19:14' ],
			'09-21' => [ 'sahri' => '04:27', 'fajr' => '04:33', 'sunrise' => '05:47', 'dhuhr' => '11:55', 'asr' => '16:15', 'sunset' => '18:00', 'iftar' => '18:00', 'maghrib' => '18:00', 'isha' => '19:13' ],
			'09-22' => [ 'sahri' => '04:27', 'fajr' => '04:34', 'sunrise' => '05:47', 'dhuhr' => '11:55', 'asr' => '16:14', 'sunset' => '17:59', 'iftar' => '17:59', 'maghrib' => '17:59', 'isha' => '19:12' ],
			'09-23' => [ 'sahri' => '04:28', 'fajr' => '04:34', 'sunrise' => '05:47', 'dhuhr' => '11:54', 'asr' => '16:13', 'sunset' => '17:58', 'iftar' => '17:58', 'maghrib' => '17:58', 'isha' => '19:11' ],
			'09-24' => [ 'sahri' => '04:28', 'fajr' => '04:34', 'sunrise' => '05:47', 'dhuhr' => '11:54', 'asr' => '16:12', 'sunset' => '17:57', 'iftar' => '17:57', 'maghrib' => '17:57', 'isha' => '19:10' ],
			'09-25' => [ 'sahri' => '04:28', 'fajr' => '04:35', 'sunrise' => '05:48', 'dhuhr' => '11:54', 'asr' => '16:11', 'sunset' => '17:56', 'iftar' => '17:56', 'maghrib' => '17:56', 'isha' => '19:09' ],
			'09-26' => [ 'sahri' => '04:29', 'fajr' => '04:35', 'sunrise' => '05:48', 'dhuhr' => '11:53', 'asr' => '16:11', 'sunset' => '17:55', 'iftar' => '17:55', 'maghrib' => '17:55', 'isha' => '19:08' ],
			'09-27' => [ 'sahri' => '04:29', 'fajr' => '04:35', 'sunrise' => '05:48', 'dhuhr' => '11:53', 'asr' => '16:10', 'sunset' => '17:53', 'iftar' => '17:53', 'maghrib' => '17:53', 'isha' => '19:06' ],
			'09-28' => [ 'sahri' => '04:29', 'fajr' => '04:36', 'sunrise' => '05:49', 'dhuhr' => '11:53', 'asr' => '16:09', 'sunset' => '17:52', 'iftar' => '17:52', 'maghrib' => '17:52', 'isha' => '19:05' ],
			'09-29' => [ 'sahri' => '04:30', 'fajr' => '04:36', 'sunrise' => '05:49', 'dhuhr' => '11:52', 'asr' => '16:08', 'sunset' => '17:51', 'iftar' => '17:51', 'maghrib' => '17:51', 'isha' => '19:04' ],
			'09-30' => [ 'sahri' => '04:30', 'fajr' => '04:36', 'sunrise' => '05:49', 'dhuhr' => '11:52', 'asr' => '16:07', 'sunset' => '17:50', 'iftar' => '17:50', 'maghrib' => '17:50', 'isha' => '19:03' ],
		];

		return $this->adjust_time( $data );
	}

	public function october() {
		$data = [
			'10-01' => [ 'sahri' => '04:31', 'fajr' => '04:37', 'sunrise' => '05:49', 'dhuhr' => '11:51', 'asr' => '16:06', 'sunset' => '17:49', 'iftar' => '17:49', 'maghrib' => '17:49', 'isha' => '19:02' ],
			'10-02' => [ 'sahri' => '04:31', 'fajr' => '04:37', 'sunrise' => '05:50', 'dhuhr' => '11:51', 'asr' => '16:05', 'sunset' => '17:48', 'iftar' => '17:48', 'maghrib' => '17:48', 'isha' => '19:01' ],
			'10-03' => [ 'sahri' => '04:32', 'fajr' => '04:38', 'sunrise' => '05:50', 'dhuhr' => '11:51', 'asr' => '16:04', 'sunset' => '17:47', 'iftar' => '17:47', 'maghrib' => '17:47', 'isha' => '19:00' ],
			'10-04' => [ 'sahri' => '04:32', 'fajr' => '04:38', 'sunrise' => '05:50', 'dhuhr' => '11:50', 'asr' => '16:04', 'sunset' => '17:46', 'iftar' => '17:46', 'maghrib' => '17:46', 'isha' => '18:59' ],
			'10-05' => [ 'sahri' => '04:33', 'fajr' => '04:38', 'sunrise' => '05:50', 'dhuhr' => '11:50', 'asr' => '16:03', 'sunset' => '17:45', 'iftar' => '17:45', 'maghrib' => '17:45', 'isha' => '18:58' ],
			'10-06' => [ 'sahri' => '04:33', 'fajr' => '04:39', 'sunrise' => '05:51', 'dhuhr' => '11:50', 'asr' => '16:02', 'sunset' => '17:44', 'iftar' => '17:44', 'maghrib' => '17:44', 'isha' => '18:57' ],
			'10-07' => [ 'sahri' => '04:33', 'fajr' => '04:39', 'sunrise' => '05:51', 'dhuhr' => '11:50', 'asr' => '16:01', 'sunset' => '17:43', 'iftar' => '17:43', 'maghrib' => '17:43', 'isha' => '18:56' ],
			'10-08' => [ 'sahri' => '04:34', 'fajr' => '04:40', 'sunrise' => '05:52', 'dhuhr' => '11:49', 'asr' => '16:00', 'sunset' => '17:42', 'iftar' => '17:42', 'maghrib' => '17:42', 'isha' => '18:55' ],
			'10-09' => [ 'sahri' => '04:34', 'fajr' => '04:40', 'sunrise' => '05:52', 'dhuhr' => '11:49', 'asr' => '15:59', 'sunset' => '17:41', 'iftar' => '17:41', 'maghrib' => '17:41', 'isha' => '18:54' ],
			'10-10' => [ 'sahri' => '04:34', 'fajr' => '04:40', 'sunrise' => '05:53', 'dhuhr' => '11:49', 'asr' => '15:58', 'sunset' => '17:40', 'iftar' => '17:40', 'maghrib' => '17:40', 'isha' => '18:54' ],
			'10-11' => [ 'sahri' => '04:35', 'fajr' => '04:41', 'sunrise' => '05:53', 'dhuhr' => '11:49', 'asr' => '15:58', 'sunset' => '17:40', 'iftar' => '17:40', 'maghrib' => '17:40', 'isha' => '18:53' ],
			'10-12' => [ 'sahri' => '04:35', 'fajr' => '04:41', 'sunrise' => '05:54', 'dhuhr' => '11:49', 'asr' => '15:57', 'sunset' => '17:39', 'iftar' => '17:39', 'maghrib' => '17:39', 'isha' => '18:52' ],
			'10-13' => [ 'sahri' => '04:35', 'fajr' => '04:42', 'sunrise' => '05:54', 'dhuhr' => '11:48', 'asr' => '15:56', 'sunset' => '17:38', 'iftar' => '17:38', 'maghrib' => '17:38', 'isha' => '18:51' ],
			'10-14' => [ 'sahri' => '04:36', 'fajr' => '04:42', 'sunrise' => '05:54', 'dhuhr' => '11:48', 'asr' => '15:55', 'sunset' => '17:37', 'iftar' => '17:37', 'maghrib' => '17:37', 'isha' => '18:50' ],
			'10-15' => [ 'sahri' => '04:36', 'fajr' => '04:42', 'sunrise' => '05:55', 'dhuhr' => '11:48', 'asr' => '15:55', 'sunset' => '17:36', 'iftar' => '17:36', 'maghrib' => '17:36', 'isha' => '18:49' ],
			'10-16' => [ 'sahri' => '04:36', 'fajr' => '04:43', 'sunrise' => '05:55', 'dhuhr' => '11:48', 'asr' => '15:54', 'sunset' => '17:35', 'iftar' => '17:35', 'maghrib' => '17:35', 'isha' => '18:49' ],
			'10-17' => [ 'sahri' => '04:37', 'fajr' => '04:43', 'sunrise' => '05:55', 'dhuhr' => '11:47', 'asr' => '15:53', 'sunset' => '17:34', 'iftar' => '17:34', 'maghrib' => '17:34', 'isha' => '18:48' ],
			'10-18' => [ 'sahri' => '04:37', 'fajr' => '04:43', 'sunrise' => '05:56', 'dhuhr' => '11:47', 'asr' => '15:53', 'sunset' => '17:33', 'iftar' => '17:33', 'maghrib' => '17:33', 'isha' => '18:47' ],
			'10-19' => [ 'sahri' => '04:38', 'fajr' => '04:44', 'sunrise' => '05:57', 'dhuhr' => '11:47', 'asr' => '15:52', 'sunset' => '17:32', 'iftar' => '17:32', 'maghrib' => '17:32', 'isha' => '18:46' ],
			'10-20' => [ 'sahri' => '04:38', 'fajr' => '04:44', 'sunrise' => '05:57', 'dhuhr' => '11:47', 'asr' => '15:51', 'sunset' => '17:31', 'iftar' => '17:31', 'maghrib' => '17:31', 'isha' => '18:46' ],
			'10-21' => [ 'sahri' => '04:38', 'fajr' => '04:45', 'sunrise' => '05:58', 'dhuhr' => '11:46', 'asr' => '15:50', 'sunset' => '17:30', 'iftar' => '17:30', 'maghrib' => '17:30', 'isha' => '18:45' ],
			'10-22' => [ 'sahri' => '04:39', 'fajr' => '04:45', 'sunrise' => '05:58', 'dhuhr' => '11:46', 'asr' => '15:49', 'sunset' => '17:29', 'iftar' => '17:29', 'maghrib' => '17:29', 'isha' => '18:44' ],
			'10-23' => [ 'sahri' => '04:39', 'fajr' => '04:45', 'sunrise' => '05:59', 'dhuhr' => '11:46', 'asr' => '15:49', 'sunset' => '17:29', 'iftar' => '17:29', 'maghrib' => '17:29', 'isha' => '18:43' ],
			'10-24' => [ 'sahri' => '04:40', 'fajr' => '04:46', 'sunrise' => '06:00', 'dhuhr' => '11:46', 'asr' => '15:48', 'sunset' => '17:28', 'iftar' => '17:28', 'maghrib' => '17:28', 'isha' => '18:42' ],
			'10-25' => [ 'sahri' => '04:40', 'fajr' => '04:46', 'sunrise' => '06:00', 'dhuhr' => '11:46', 'asr' => '15:47', 'sunset' => '17:27', 'iftar' => '17:27', 'maghrib' => '17:27', 'isha' => '18:42' ],
			'10-26' => [ 'sahri' => '04:40', 'fajr' => '04:47', 'sunrise' => '06:01', 'dhuhr' => '11:46', 'asr' => '15:47', 'sunset' => '17:27', 'iftar' => '17:27', 'maghrib' => '17:27', 'isha' => '18:41' ],
			'10-27' => [ 'sahri' => '04:41', 'fajr' => '04:47', 'sunrise' => '06:01', 'dhuhr' => '11:45', 'asr' => '15:46', 'sunset' => '17:26', 'iftar' => '17:26', 'maghrib' => '17:26', 'isha' => '18:41' ],
			'10-28' => [ 'sahri' => '04:41', 'fajr' => '04:47', 'sunrise' => '06:02', 'dhuhr' => '11:45', 'asr' => '15:46', 'sunset' => '17:26', 'iftar' => '17:26', 'maghrib' => '17:26', 'isha' => '18:40' ],
			'10-29' => [ 'sahri' => '04:42', 'fajr' => '04:48', 'sunrise' => '06:03', 'dhuhr' => '11:45', 'asr' => '15:45', 'sunset' => '17:25', 'iftar' => '17:25', 'maghrib' => '17:25', 'isha' => '18:39' ],
			'10-30' => [ 'sahri' => '04:42', 'fajr' => '04:48', 'sunrise' => '06:03', 'dhuhr' => '11:45', 'asr' => '15:44', 'sunset' => '17:24', 'iftar' => '17:24', 'maghrib' => '17:24', 'isha' => '18:39' ],
			'10-31' => [ 'sahri' => '04:42', 'fajr' => '04:49', 'sunrise' => '06:04', 'dhuhr' => '11:45', 'asr' => '15:44', 'sunset' => '17:24', 'iftar' => '17:24', 'maghrib' => '17:24', 'isha' => '18:38' ],
		];

		return $this->adjust_time( $data );
	}

	public function november() {
		$data = [
			'11-01' => [ 'sahri' => '04:43', 'fajr' => '04:49', 'sunrise' => '06:04', 'dhuhr' => '11:45', 'asr' => '15:43', 'sunset' => '17:23', 'iftar' => '17:23', 'maghrib' => '17:23', 'isha' => '18:38' ],
			'11-02' => [ 'sahri' => '04:43', 'fajr' => '04:50', 'sunrise' => '06:05', 'dhuhr' => '11:45', 'asr' => '15:43', 'sunset' => '17:23', 'iftar' => '17:23', 'maghrib' => '17:23', 'isha' => '18:37' ],
			'11-03' => [ 'sahri' => '04:44', 'fajr' => '04:50', 'sunrise' => '06:05', 'dhuhr' => '11:45', 'asr' => '15:42', 'sunset' => '17:22', 'iftar' => '17:22', 'maghrib' => '17:22', 'isha' => '18:36' ],
			'11-04' => [ 'sahri' => '04:45', 'fajr' => '04:51', 'sunrise' => '06:06', 'dhuhr' => '11:45', 'asr' => '15:42', 'sunset' => '17:21', 'iftar' => '17:21', 'maghrib' => '17:21', 'isha' => '18:36' ],
			'11-05' => [ 'sahri' => '04:45', 'fajr' => '04:51', 'sunrise' => '06:07', 'dhuhr' => '11:45', 'asr' => '15:41', 'sunset' => '17:21', 'iftar' => '17:21', 'maghrib' => '17:21', 'isha' => '18:35' ],
			'11-06' => [ 'sahri' => '04:46', 'fajr' => '04:52', 'sunrise' => '06:07', 'dhuhr' => '11:45', 'asr' => '15:41', 'sunset' => '17:20', 'iftar' => '17:20', 'maghrib' => '17:20', 'isha' => '18:34' ],
			'11-07' => [ 'sahri' => '04:46', 'fajr' => '04:52', 'sunrise' => '06:08', 'dhuhr' => '11:45', 'asr' => '15:40', 'sunset' => '17:20', 'iftar' => '17:20', 'maghrib' => '17:20', 'isha' => '18:34' ],
			'11-08' => [ 'sahri' => '04:47', 'fajr' => '04:53', 'sunrise' => '06:08', 'dhuhr' => '11:45', 'asr' => '15:40', 'sunset' => '17:19', 'iftar' => '17:19', 'maghrib' => '17:19', 'isha' => '18:34' ],
			'11-09' => [ 'sahri' => '04:47', 'fajr' => '04:53', 'sunrise' => '06:09', 'dhuhr' => '11:45', 'asr' => '15:39', 'sunset' => '17:18', 'iftar' => '17:18', 'maghrib' => '17:18', 'isha' => '18:33' ],
			'11-10' => [ 'sahri' => '04:48', 'fajr' => '04:54', 'sunrise' => '06:10', 'dhuhr' => '11:46', 'asr' => '15:39', 'sunset' => '17:18', 'iftar' => '17:18', 'maghrib' => '17:18', 'isha' => '18:33' ],
			'11-11' => [ 'sahri' => '04:49', 'fajr' => '04:54', 'sunrise' => '06:10', 'dhuhr' => '11:46', 'asr' => '15:38', 'sunset' => '17:17', 'iftar' => '17:17', 'maghrib' => '17:17', 'isha' => '18:33' ],
			'11-12' => [ 'sahri' => '04:49', 'fajr' => '04:55', 'sunrise' => '06:11', 'dhuhr' => '11:46', 'asr' => '15:38', 'sunset' => '17:17', 'iftar' => '17:17', 'maghrib' => '17:17', 'isha' => '18:33' ],
			'11-13' => [ 'sahri' => '04:50', 'fajr' => '04:55', 'sunrise' => '06:11', 'dhuhr' => '11:46', 'asr' => '15:38', 'sunset' => '17:16', 'iftar' => '17:16', 'maghrib' => '17:16', 'isha' => '18:33' ],
			'11-14' => [ 'sahri' => '04:50', 'fajr' => '04:56', 'sunrise' => '06:12', 'dhuhr' => '11:46', 'asr' => '15:37', 'sunset' => '17:16', 'iftar' => '17:16', 'maghrib' => '17:16', 'isha' => '18:32' ],
			'11-15' => [ 'sahri' => '04:51', 'fajr' => '04:56', 'sunrise' => '06:13', 'dhuhr' => '11:46', 'asr' => '15:37', 'sunset' => '17:16', 'iftar' => '17:16', 'maghrib' => '17:16', 'isha' => '18:32' ],
			'11-16' => [ 'sahri' => '04:51', 'fajr' => '04:57', 'sunrise' => '06:13', 'dhuhr' => '11:46', 'asr' => '15:36', 'sunset' => '17:15', 'iftar' => '17:15', 'maghrib' => '17:15', 'isha' => '18:32' ],
			'11-17' => [ 'sahri' => '04:52', 'fajr' => '04:57', 'sunrise' => '06:14', 'dhuhr' => '11:47', 'asr' => '15:36', 'sunset' => '17:15', 'iftar' => '17:15', 'maghrib' => '17:15', 'isha' => '18:32' ],
			'11-18' => [ 'sahri' => '04:52', 'fajr' => '04:58', 'sunrise' => '06:15', 'dhuhr' => '11:47', 'asr' => '15:36', 'sunset' => '17:15', 'iftar' => '17:15', 'maghrib' => '17:15', 'isha' => '18:32' ],
			'11-19' => [ 'sahri' => '04:53', 'fajr' => '04:58', 'sunrise' => '06:15', 'dhuhr' => '11:47', 'asr' => '15:35', 'sunset' => '17:15', 'iftar' => '17:15', 'maghrib' => '17:15', 'isha' => '18:31' ],
			'11-20' => [ 'sahri' => '04:53', 'fajr' => '04:59', 'sunrise' => '06:16', 'dhuhr' => '11:48', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:31' ],
			'11-21' => [ 'sahri' => '04:54', 'fajr' => '04:59', 'sunrise' => '06:17', 'dhuhr' => '11:48', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:31' ],
			'11-22' => [ 'sahri' => '04:54', 'fajr' => '04:59', 'sunrise' => '06:17', 'dhuhr' => '11:48', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:31' ],
			'11-23' => [ 'sahri' => '04:55', 'fajr' => '05:00', 'sunrise' => '06:18', 'dhuhr' => '11:49', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:31' ],
			'11-24' => [ 'sahri' => '04:56', 'fajr' => '05:00', 'sunrise' => '06:19', 'dhuhr' => '11:49', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:31' ],
			'11-25' => [ 'sahri' => '04:56', 'fajr' => '05:01', 'sunrise' => '06:19', 'dhuhr' => '11:49', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:31' ],
			'11-26' => [ 'sahri' => '04:57', 'fajr' => '05:02', 'sunrise' => '06:20', 'dhuhr' => '11:50', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:31' ],
			'11-27' => [ 'sahri' => '04:57', 'fajr' => '05:03', 'sunrise' => '06:21', 'dhuhr' => '11:50', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:31' ],
			'11-28' => [ 'sahri' => '04:58', 'fajr' => '05:03', 'sunrise' => '06:21', 'dhuhr' => '11:50', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:32' ],
			'11-29' => [ 'sahri' => '04:59', 'fajr' => '05:04', 'sunrise' => '06:22', 'dhuhr' => '11:51', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:32' ],
			'11-30' => [ 'sahri' => '04:59', 'fajr' => '05:05', 'sunrise' => '06:23', 'dhuhr' => '11:51', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:32' ],
		];

		return $this->adjust_time( $data );
	}

	public function december() {
		$data = [
			'12-01' => [ 'sahri' => '05:00', 'fajr' => '05:06', 'sunrise' => '06:24', 'dhuhr' => '11:51', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:32' ],
			'12-02' => [ 'sahri' => '05:00', 'fajr' => '05:06', 'sunrise' => '06:24', 'dhuhr' => '11:52', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:32' ],
			'12-03' => [ 'sahri' => '05:01', 'fajr' => '05:07', 'sunrise' => '06:25', 'dhuhr' => '11:52', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:32' ],
			'12-04' => [ 'sahri' => '05:01', 'fajr' => '05:08', 'sunrise' => '06:26', 'dhuhr' => '11:52', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:32' ],
			'12-05' => [ 'sahri' => '05:02', 'fajr' => '05:08', 'sunrise' => '06:27', 'dhuhr' => '11:53', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:33' ],
			'12-06' => [ 'sahri' => '05:03', 'fajr' => '05:09', 'sunrise' => '06:28', 'dhuhr' => '11:53', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:33' ],
			'12-07' => [ 'sahri' => '05:03', 'fajr' => '05:10', 'sunrise' => '06:28', 'dhuhr' => '11:53', 'asr' => '15:35', 'sunset' => '17:14', 'iftar' => '17:14', 'maghrib' => '17:14', 'isha' => '18:33' ],
			'12-08' => [ 'sahri' => '05:04', 'fajr' => '05:11', 'sunrise' => '06:29', 'dhuhr' => '11:54', 'asr' => '15:36', 'sunset' => '17:15', 'iftar' => '17:15', 'maghrib' => '17:15', 'isha' => '18:34' ],
			'12-09' => [ 'sahri' => '05:05', 'fajr' => '05:11', 'sunrise' => '06:29', 'dhuhr' => '11:54', 'asr' => '15:36', 'sunset' => '17:15', 'iftar' => '17:15', 'maghrib' => '17:15', 'isha' => '18:34' ],
			'12-10' => [ 'sahri' => '05:05', 'fajr' => '05:12', 'sunrise' => '06:30', 'dhuhr' => '11:55', 'asr' => '15:36', 'sunset' => '17:15', 'iftar' => '17:15', 'maghrib' => '17:15', 'isha' => '18:34' ],
			'12-11' => [ 'sahri' => '05:06', 'fajr' => '05:13', 'sunrise' => '06:30', 'dhuhr' => '11:55', 'asr' => '15:37', 'sunset' => '17:15', 'iftar' => '17:15', 'maghrib' => '17:15', 'isha' => '18:34' ],
			'12-12' => [ 'sahri' => '05:07', 'fajr' => '05:13', 'sunrise' => '06:31', 'dhuhr' => '11:56', 'asr' => '15:37', 'sunset' => '17:16', 'iftar' => '17:16', 'maghrib' => '17:16', 'isha' => '18:35' ],
			'12-13' => [ 'sahri' => '05:07', 'fajr' => '05:14', 'sunrise' => '06:32', 'dhuhr' => '11:56', 'asr' => '15:37', 'sunset' => '17:16', 'iftar' => '17:16', 'maghrib' => '17:16', 'isha' => '18:35' ],
			'12-14' => [ 'sahri' => '05:08', 'fajr' => '05:14', 'sunrise' => '06:32', 'dhuhr' => '11:56', 'asr' => '15:38', 'sunset' => '17:16', 'iftar' => '17:16', 'maghrib' => '17:16', 'isha' => '18:35' ],
			'12-15' => [ 'sahri' => '05:08', 'fajr' => '05:14', 'sunrise' => '06:33', 'dhuhr' => '11:57', 'asr' => '15:38', 'sunset' => '17:17', 'iftar' => '17:17', 'maghrib' => '17:17', 'isha' => '18:36' ],
			'12-16' => [ 'sahri' => '05:09', 'fajr' => '05:15', 'sunrise' => '06:33', 'dhuhr' => '11:57', 'asr' => '15:38', 'sunset' => '17:17', 'iftar' => '17:17', 'maghrib' => '17:17', 'isha' => '18:36' ],
			'12-17' => [ 'sahri' => '05:09', 'fajr' => '05:15', 'sunrise' => '06:34', 'dhuhr' => '11:58', 'asr' => '15:39', 'sunset' => '17:17', 'iftar' => '17:17', 'maghrib' => '17:17', 'isha' => '18:36' ],
			'12-18' => [ 'sahri' => '05:10', 'fajr' => '05:16', 'sunrise' => '06:35', 'dhuhr' => '11:58', 'asr' => '15:39', 'sunset' => '17:18', 'iftar' => '17:18', 'maghrib' => '17:18', 'isha' => '18:37' ],
			'12-19' => [ 'sahri' => '05:11', 'fajr' => '05:16', 'sunrise' => '06:35', 'dhuhr' => '11:59', 'asr' => '15:40', 'sunset' => '17:18', 'iftar' => '17:18', 'maghrib' => '17:18', 'isha' => '18:37' ],
			'12-20' => [ 'sahri' => '05:11', 'fajr' => '05:17', 'sunrise' => '06:36', 'dhuhr' => '12:00', 'asr' => '15:40', 'sunset' => '17:19', 'iftar' => '17:19', 'maghrib' => '17:19', 'isha' => '18:38' ],
			'12-21' => [ 'sahri' => '05:12', 'fajr' => '05:17', 'sunrise' => '06:36', 'dhuhr' => '12:00', 'asr' => '15:41', 'sunset' => '17:19', 'iftar' => '17:19', 'maghrib' => '17:19', 'isha' => '18:38' ],
			'12-22' => [ 'sahri' => '05:12', 'fajr' => '05:18', 'sunrise' => '06:37', 'dhuhr' => '12:01', 'asr' => '15:41', 'sunset' => '17:20', 'iftar' => '17:20', 'maghrib' => '17:20', 'isha' => '18:39' ],
			'12-23' => [ 'sahri' => '05:13', 'fajr' => '05:19', 'sunrise' => '06:37', 'dhuhr' => '12:01', 'asr' => '15:42', 'sunset' => '17:20', 'iftar' => '17:20', 'maghrib' => '17:20', 'isha' => '18:39' ],
			'12-24' => [ 'sahri' => '05:13', 'fajr' => '05:19', 'sunrise' => '06:38', 'dhuhr' => '12:02', 'asr' => '15:42', 'sunset' => '17:21', 'iftar' => '17:21', 'maghrib' => '17:21', 'isha' => '18:40' ],
			'12-25' => [ 'sahri' => '05:13', 'fajr' => '05:19', 'sunrise' => '06:38', 'dhuhr' => '12:02', 'asr' => '15:42', 'sunset' => '17:21', 'iftar' => '17:21', 'maghrib' => '17:21', 'isha' => '18:40' ],
			'12-26' => [ 'sahri' => '05:14', 'fajr' => '05:19', 'sunrise' => '06:38', 'dhuhr' => '12:02', 'asr' => '15:43', 'sunset' => '17:22', 'iftar' => '17:22', 'maghrib' => '17:22', 'isha' => '18:41' ],
			'12-27' => [ 'sahri' => '05:14', 'fajr' => '05:20', 'sunrise' => '06:39', 'dhuhr' => '12:03', 'asr' => '15:43', 'sunset' => '17:23', 'iftar' => '17:23', 'maghrib' => '17:23', 'isha' => '18:42' ],
			'12-28' => [ 'sahri' => '05:14', 'fajr' => '05:20', 'sunrise' => '06:39', 'dhuhr' => '12:03', 'asr' => '15:44', 'sunset' => '17:23', 'iftar' => '17:23', 'maghrib' => '17:23', 'isha' => '18:42' ],
			'12-29' => [ 'sahri' => '05:15', 'fajr' => '05:20', 'sunrise' => '06:39', 'dhuhr' => '12:03', 'asr' => '15:44', 'sunset' => '17:24', 'iftar' => '17:24', 'maghrib' => '17:24', 'isha' => '18:43' ],
			'12-30' => [ 'sahri' => '05:15', 'fajr' => '05:21', 'sunrise' => '06:40', 'dhuhr' => '12:03', 'asr' => '15:44', 'sunset' => '17:25', 'iftar' => '17:25', 'maghrib' => '17:25', 'isha' => '18:44' ],
			'12-31' => [ 'sahri' => '05:15', 'fajr' => '05:21', 'sunrise' => '06:40', 'dhuhr' => '12:04', 'asr' => '15:45', 'sunset' => '17:25', 'iftar' => '17:25', 'maghrib' => '17:25', 'isha' => '18:44' ],
		];

		return $this->adjust_time( $data );
	}

	public function year() {
		return array_merge(
			$this->january(), $this->february(), $this->march(), $this->april(), $this->may(), $this->june(),
			$this->july(), $this->august(), $this->september(), $this->october(), $this->november(), $this->december()
		);
	}
}
