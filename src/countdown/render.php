<?php
/**
 * Render interactive salat time countdown.
 *
 * @package ramadan
 */

$city       = isset( $attributes['city'] ) ? $attributes['city'] : '';
$city       = empty( $city ) ? get_query_var( 'ramadan_city' ) : $city;
$city       = empty( $city ) ? 'dhaka' : $city;
$timeformat = empty( $attributes['timeformat'] ) ? 'h:i A' : $attributes['timeformat'];
$events     = empty( $attributes['events'] ) ? [] : $attributes['events'];
$sequence   = [ 'sahri', 'fajr', 'sunrise', 'dhuhr', 'asr', 'iftar', 'maghrib', 'isha' ];
$headings   = \AminulBD\Ramadan\Helper::get_headings();
$cities     = \AminulBD\Ramadan\Helper::get_cities_flatten();
$today      = current_datetime();
$date       = $today->format( 'Y-m-d' );
$calendar   = new \AminulBD\Ramadan\Prayer_Calendar( $city );
$schedule   = $calendar->today( $date );
$tomorrow   = $calendar->today( $today->modify( '+1 day' )->format( 'Y-m-d' ) );

if ( empty( $schedule ) ) {
	return;
}

/**
 * Build a countdown item for a given date, key and schedule row.
 *
 * @param string $item_date Date string Y-m-d.
 * @param string $key       Event key.
 * @param array  $row       Schedule row.
 *
 * @return array|null
 */
$build_item = function ( $item_date, $key, $row ) use ( $headings, $timeformat ) {
	if ( empty( $row[ $key ] ) ) {
		return null;
	}

	try {
		$datetime = new \DateTime( $item_date . ' ' . $row[ $key ], wp_timezone() );
	} catch ( \Exception $e ) {
		return null;
	}

	return [
		'key'   => $key,
		'label' => $headings[ $key ],
		'time'  => date_i18n( $timeformat, strtotime( "$item_date {$row[ $key ]}" ) ),
		'ts'    => $datetime->getTimestamp(),
	];
};

$items = [];
foreach ( $sequence as $key ) {
	$enabled = isset( $events[ $key ] ) && ( $events[ $key ] === true || $events[ $key ] === 'true' );

	if ( ! $enabled ) {
		continue;
	}

	$item = $build_item( $date, $key, $schedule );

	if ( $item ) {
		$items[] = $item;
	}
}

if ( empty( $items ) ) {
	return;
}

$now_ts   = $today->getTimestamp();
$next     = null;
$next_day = null;
$prev_ts  = null;

foreach ( $items as $item ) {
	if ( $item['ts'] > $now_ts ) {
		$next = $item;
		break;
	}
}

for ( $i = count( $items ) - 1; $i >= 0; $i -- ) {
	if ( $items[ $i ]['ts'] <= $now_ts ) {
		$prev_ts = $items[ $i ]['ts'];
		break;
	}
}

if ( ! $next && ! empty( $tomorrow ) ) {
	foreach ( $sequence as $key ) {
		$enabled = isset( $events[ $key ] ) && ( $events[ $key ] === true || $events[ $key ] === 'true' );

		if ( ! $enabled ) {
			continue;
		}

		$item = $build_item( $today->modify( '+1 day' )->format( 'Y-m-d' ), $key, $tomorrow );

		if ( $item ) {
			$next     = $item;
			$next_day = $item;
			$prev_ts  = $prev_ts ? $prev_ts : $items[0]['ts'];
			break;
		}
	}
}

$span    = $next && $prev_ts ? max( $next['ts'] - $prev_ts, 1 ) : 1;
$percent = $next && $prev_ts ? ( $now_ts - $prev_ts ) / $span * 100 : 0;
$percent = max( 0, min( 100, $percent ) );

$payload = [
	'now'     => $now_ts,
	'offset'  => (int) $today->getOffset(),
	'events'  => $items,
	'nextDay' => $next_day,
];

$city_label = isset( $cities[ $city ] ) ? $cities[ $city ] : __( 'Dhaka', 'ramadan' );
?>

<div <?php echo wp_kses_data( get_block_wrapper_attributes( [ 'class' => 'ramadan-block-container' ] ) ); ?>>
	<div class="ramadan-countdown" data-schedule="<?php echo esc_attr( wp_json_encode( $payload ) ); ?>">
		<div class="ramadan-countdown__scene">
			<svg class="ramadan-countdown__astro" viewBox="0 0 800 420" preserveAspectRatio="xMidYMid slice" aria-hidden="true" focusable="false">
				<g fill="#f0c75e">
					<polygon points="0,-7 1.6,-1.6 7,0 1.6,1.6 0,7 -1.6,1.6 -7,0 -1.6,-1.6" transform="translate(96,74) scale(.9)" opacity=".85"/>
					<polygon points="0,-7 1.6,-1.6 7,0 1.6,1.6 0,7 -1.6,1.6 -7,0 -1.6,-1.6" transform="translate(212,44) scale(.55)" opacity=".6"/>
					<polygon points="0,-7 1.6,-1.6 7,0 1.6,1.6 0,7 -1.6,1.6 -7,0 -1.6,-1.6" transform="translate(318,110) scale(.7)" opacity=".75"/>
					<polygon points="0,-7 1.6,-1.6 7,0 1.6,1.6 0,7 -1.6,1.6 -7,0 -1.6,-1.6" transform="translate(132,168) scale(.5)" opacity=".5"/>
					<polygon points="0,-7 1.6,-1.6 7,0 1.6,1.6 0,7 -1.6,1.6 -7,0 -1.6,-1.6" transform="translate(428,58) scale(.8)" opacity=".8"/>
					<polygon points="0,-7 1.6,-1.6 7,0 1.6,1.6 0,7 -1.6,1.6 -7,0 -1.6,-1.6" transform="translate(520,132) scale(.5)" opacity=".55"/>
					<polygon points="0,-7 1.6,-1.6 7,0 1.6,1.6 0,7 -1.6,1.6 -7,0 -1.6,-1.6" transform="translate(700,190) scale(.65)" opacity=".7"/>
					<circle cx="170" cy="110" r="1.6" opacity=".7"/>
					<circle cx="264" cy="86" r="1.4" opacity=".6"/>
					<circle cx="382" cy="40" r="1.6" opacity=".75"/>
					<circle cx="470" cy="96" r="1.3" opacity=".5"/>
					<circle cx="586" cy="70" r="1.6" opacity=".7"/>
					<circle cx="640" cy="212" r="1.4" opacity=".5"/>
					<circle cx="748" cy="120" r="1.6" opacity=".65"/>
					<circle cx="60" cy="180" r="1.4" opacity=".55"/>
				</g>
				<circle cx="648" cy="96" r="66" fill="#f0c75e" opacity=".06"/>
				<circle cx="648" cy="96" r="46" fill="#f0c75e" opacity=".08"/>
				<path d="M0,-30 A30,30 0 1,0 0,30 A31.5,31.5 0 0,1 0,-30 Z" transform="translate(648,96) rotate(-28)" fill="#f6d67c"/>
			</svg>

			<div class="ramadan-countdown__header">
				<span class="ramadan-countdown__city">
					<svg viewBox="0 0 20 20" aria-hidden="true" focusable="false"><polygon points="10,0 11.6,6.1 17.1,2.9 13.9,8.4 20,10 13.9,11.6 17.1,17.1 11.6,13.9 10,20 8.4,13.9 2.9,17.1 6.1,11.6 0,10 6.1,8.4 2.9,2.9 8.4,6.1" fill="#d4af37"/></svg>
					<?php
					/* translators: %s: city name. */
					printf( esc_html__( 'City: %s', 'ramadan' ), esc_html( $city_label ) );
					?>
				</span>
				<span class="ramadan-countdown__clock" data-clock>
					<?php echo esc_html( date_i18n( $timeformat, $now_ts + (int) $today->getOffset() ) ); ?>
				</span>
			</div>

			<?php if ( $next ) : ?>
				<div class="ramadan-countdown__main">
					<p class="ramadan-countdown__label" data-label>
						<?php printf( esc_html__( 'Time left until %s', 'ramadan' ), esc_html( $next['label'] ) ); ?>
					</p>
					<p class="ramadan-countdown__timer" data-timer role="timer">
						<?php echo esc_html( $next['time'] ); ?>
					</p>
					<div class="ramadan-countdown__progress">
						<span data-progress style="width: <?php echo esc_attr( round( $percent, 1 ) ); ?>%"></span>
					</div>
				</div>
			<?php endif; ?>

			<svg class="ramadan-countdown__skyline" viewBox="0 0 1200 280" preserveAspectRatio="xMidYMax meet" aria-hidden="true" focusable="false">
				<g fill="#0a1b30" stroke="#f0c75e" stroke-opacity=".25" stroke-width="1.5">
					<rect x="0" y="252" width="1200" height="28" stroke="none"/>
					<g>
						<rect x="156" y="88" width="28" height="164"/>
						<rect x="147" y="132" width="46" height="9" rx="2"/>
						<rect x="147" y="176" width="46" height="9" rx="2"/>
						<path d="M156,88 Q170,52 184,88 Z"/>
						<rect x="168.5" y="40" width="3" height="16"/>
					</g>
					<g transform="translate(860,0)">
						<rect x="156" y="88" width="28" height="164"/>
						<rect x="147" y="132" width="46" height="9" rx="2"/>
						<rect x="147" y="176" width="46" height="9" rx="2"/>
						<path d="M156,88 Q170,52 184,88 Z"/>
						<rect x="168.5" y="40" width="3" height="16"/>
					</g>
					<rect x="310" y="192" width="580" height="60"/>
					<g>
						<rect x="372" y="180" width="56" height="12"/>
						<path d="M372,180 Q400,124 428,180 Z"/>
						<rect x="398.5" y="104" width="3" height="18"/>
					</g>
					<g transform="translate(400,0)">
						<rect x="372" y="180" width="56" height="12"/>
						<path d="M372,180 Q400,124 428,180 Z"/>
						<rect x="398.5" y="104" width="3" height="18"/>
					</g>
					<rect x="540" y="172" width="120" height="20"/>
					<path d="M540,172 C540,104 562,72 600,64 C638,72 660,104 660,172 Z"/>
					<rect x="598.5" y="30" width="3" height="38"/>
				</g>
				<g fill="#f0c75e">
					<path d="M0,-9 A9,9 0 1,0 0,9 A9.6,9.6 0 0,1 0,-9 Z" transform="translate(600,22) rotate(-25) scale(1.1)"/>
					<path d="M0,-9 A9,9 0 1,0 0,9 A9.6,9.6 0 0,1 0,-9 Z" transform="translate(170,34) rotate(-25) scale(.7)"/>
					<path d="M0,-9 A9,9 0 1,0 0,9 A9.6,9.6 0 0,1 0,-9 Z" transform="translate(1030,34) rotate(-25) scale(.7)"/>
					<path d="M0,-9 A9,9 0 1,0 0,9 A9.6,9.6 0 0,1 0,-9 Z" transform="translate(400,96) rotate(-25) scale(.55)"/>
					<path d="M0,-9 A9,9 0 1,0 0,9 A9.6,9.6 0 0,1 0,-9 Z" transform="translate(800,96) rotate(-25) scale(.55)"/>
				</g>
				<g fill="#ffcf6e">
					<path d="M560,252 L560,212 Q600,168 640,212 L640,252 Z" opacity=".92"/>
					<path d="M448,252 L448,228 Q476,196 504,228 L504,252 Z" opacity=".5"/>
					<path d="M696,252 L696,228 Q724,196 752,228 L752,252 Z" opacity=".5"/>
				</g>
			</svg>
		</div>

		<div class="ramadan-countdown__panel">
			<svg class="ramadan-countdown__ornament" viewBox="0 0 240 24" aria-hidden="true" focusable="false">
				<g stroke="#d4af37" stroke-width="1" opacity=".65">
					<line x1="0" y1="12" x2="96" y2="12"/>
					<line x1="144" y1="12" x2="240" y2="12"/>
				</g>
				<rect x="-2.2" y="-2.2" width="4.4" height="4.4" transform="translate(106,12) rotate(45)" fill="#d4af37" opacity=".8"/>
				<rect x="-2.2" y="-2.2" width="4.4" height="4.4" transform="translate(134,12) rotate(45)" fill="#d4af37" opacity=".8"/>
				<polygon points="0,-10 1.6,-3.9 7.1,-7.1 3.9,-1.6 10,0 3.9,1.6 7.1,7.1 1.6,3.9 0,10 -1.6,3.9 -7.1,7.1 -3.9,1.6 -10,0 -3.9,-1.6 -7.1,-7.1 -1.6,-3.9" transform="translate(120,12)" fill="#d4af37"/>
			</svg>

			<ul class="ramadan-countdown__events">
				<?php foreach ( $items as $item ) : ?>
					<li class="ramadan-countdown__event<?php echo esc_attr( $item['ts'] <= $now_ts ? ' is-past' : '' ); ?><?php echo esc_attr( $next && $item['key'] === $next['key'] && $item['ts'] === $next['ts'] ? ' is-next' : '' ); ?>" data-key="<?php echo esc_attr( $item['key'] ); ?>">
						<span class="ramadan-countdown__event-name"><?php echo esc_html( $item['label'] ); ?></span>
						<span class="ramadan-countdown__event-time"><?php echo esc_html( $item['time'] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
