<?php
/**
 * Render daily prayer times table.
 *
 * @package ramadan
 */

$city       = isset( $attributes['city'] ) ? $attributes['city'] : '';
$city       = empty( $city ) ? get_query_var( 'ramadan_city' ) : $city;
$dateformat = empty( $attributes['dateformat'] ) ? 'd F, l' : $attributes['dateformat'];
$timeformat = empty( $attributes['timeformat'] ) ? 'h:i A' : $attributes['timeformat'];
$current    = current_datetime()->format( 'Y-m-d' );
$date       = isset( $attributes['date'] ) ? $attributes['date'] : $current;
$date       = empty( $date ) ? $current : $date;
$calendar   = new \AminulBD\Ramadan\Prayer_Calendar( $city );
$schedules  = $calendar->today( $date );
?>

<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<table class="prayer-times-table prayer-times-table-today">
		<thead>
		<tr>
			<th><?php echo date_i18n( $dateformat, strtotime( $date ) ); ?></th>
			<th><?php echo esc_html__( 'Time', 'ramadan' ); ?></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td><?php echo esc_html__( 'Sahri', 'ramadan' ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedules['sahri']}" ) ); ?></td>
		</tr>
		<tr>
			<td><?php echo esc_html__( 'Fajr', 'ramadan' ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedules['fajr']}" ) ); ?></td>
		</tr>
		<tr>
			<td><?php echo esc_html__( 'Sunrise', 'ramadan' ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedules['sunrise']}" ) ); ?></td>
		</tr>
		<tr>
			<td><?php echo esc_html__( 'Dhuhr', 'ramadan' ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedules['dhuhr']}" ) ); ?></td>
		</tr>
		<tr>
			<td><?php echo esc_html__( 'Asr', 'ramadan' ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedules['asr']}" ) ); ?></td>
		</tr>
		<tr>
			<td><?php echo esc_html__( 'Maghrib', 'ramadan' ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedules['maghrib']}" ) ); ?></td>
		</tr>
		<tr>
			<td><?php echo esc_html__( 'Isha', 'ramadan' ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedules['isha']}" ) ); ?></td>
		</tr>
		<tr>
		</tbody>
	</table>
</div>
