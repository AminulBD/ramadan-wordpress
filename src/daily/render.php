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
$schedule  = $calendar->today( $date );
?>

<div <?php echo wp_kses_data( get_block_wrapper_attributes( [ 'class' => 'ramadan-block-container' ] ) ); ?>>
	<table class="prayer-times-table ramadan-times-table-today">
		<thead>
		<tr>
			<th><?php echo esc_html__( 'Date', 'ramadan' ); ?></th>
			<th><?php echo esc_html__( 'Sahri', 'ramadan' ); ?></th>
			<th><?php echo esc_html__( 'Iftar', 'ramadan' ); ?></th>
			<th><?php echo esc_html__( 'Sunrise', 'ramadan' ); ?></th>
			<th><?php echo esc_html__( 'Sunset', 'ramadan' ); ?></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td><?php echo date_i18n( $dateformat, strtotime( $date ) ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedule['sahri']}" ) ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedule['maghrib']}" ) ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedule['sunrise']}" ) ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedule['maghrib']}" ) ); ?></td>
		</tr>
		<tr>
		</tbody>
	</table>
</div>
