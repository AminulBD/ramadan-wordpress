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
$schedule   = $calendar->today( $date );
?>

<div <?php echo wp_kses_data( get_block_wrapper_attributes( [ 'class' => 'ramadan-block-container' ] ) ); ?>>
	<table class="prayer-times-table prayer-times-table-today">
		<thead>
		<tr>
			<?php foreach ( \AminulBD\Ramadan\Helper::get_headings() as $heading ) : ?>
				<th><?php echo esc_html( $heading ); ?></th>
			<?php endforeach; ?>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td><?php echo date_i18n( $dateformat, strtotime( "$date" ) ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedule['sahri']}" ) ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedule['fajr']}" ) ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedule['sunrise']}" ) ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedule['dhuhr']}" ) ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedule['asr']}" ) ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedule['maghrib']}" ) ); ?></td>
			<td><?php echo date_i18n( $timeformat, strtotime( "$date {$schedule['isha']}" ) ); ?></td>
		</tr>
		<tr>
		</tbody>
	</table>
</div>
