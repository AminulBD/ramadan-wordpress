<?php
/**
 * Render ramadan prayer times table.
 *
 * @package ramadan
 */

$city       = isset( $attributes['city'] ) ? $attributes['city'] : '';
$city       = empty( $city ) ? get_query_var( 'ramadan_city' ) : $city;
$dateformat = empty( $attributes['dateformat'] ) ? 'd -- l' : $attributes['dateformat'];
$timeformat = empty( $attributes['timeformat'] ) ? 'h:i A' : $attributes['timeformat'];
$date       = isset( $attributes['date'] ) ? $attributes['date'] : '';
$date       = empty( $date ) ? get_option( 'ramadan_start_date' ) : $date;
$year       = ( new \DateTime( $date ) )->format( 'Y' );
$today      = current_datetime()->format( 'Y-m-d' );
$calendar   = new \AminulBD\Ramadan\Prayer_Calendar( $city );
$schedules  = $calendar->ramadan( $date );
?>
<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<table class="prayer-times-table prayer-times-table-ramadan">
		<thead>
		<tr>
			<?php foreach ( \AminulBD\Ramadan\Helper::get_headings() as $heading ) : ?>
				<th><?php echo esc_html( $heading ); ?></th>
			<?php endforeach; ?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( $schedules as $day => $schedule ) : ?>
			<tr class="<?php echo esc_attr( $today === "$year-$day" ? 'today' : 'other-day' ) ?>">
				<td><?php echo date_i18n( $dateformat, strtotime( "$year-$day" ) ); ?> </td>
				<td><?php echo date_i18n( $timeformat, strtotime( "$year-$day {$schedule['sahri']}" ) ); ?> </td>
				<td><?php echo date_i18n( $timeformat, strtotime( "$year-$day {$schedule['fajr']}" ) ); ?> </td>
				<td><?php echo date_i18n( $timeformat, strtotime( "$year-$day {$schedule['sunrise']}" ) ); ?> </td>
				<td><?php echo date_i18n( $timeformat, strtotime( "$year-$day {$schedule['dhuhr']}" ) ); ?> </td>
				<td><?php echo date_i18n( $timeformat, strtotime( "$year-$day {$schedule['asr']}" ) ); ?> </td>
				<td><?php echo date_i18n( $timeformat, strtotime( "$year-$day {$schedule['maghrib']}" ) ); ?> </td>
				<td><?php echo date_i18n( $timeformat, strtotime( "$year-$day {$schedule['isha']}" ) ); ?> </td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
