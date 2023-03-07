<?php
/**
 * Render yearly prayer times table.
 *
 * @package Ramadan
 */

$calendar = new \AminulBD\Ramadan\Prayer_Calendar();
$city     = isset( $attributes['city'] ) ? $attributes['city'] : '';
$city     = empty( $city ) ? get_query_var( 'ramadan_city' ) : $city;
$calendar->set_district( $city );

$year = isset( $attributes['year'] ) ? $attributes['year'] : '';
$year = empty( $year ) ? current_datetime()->format( 'Y' ) : $year;
?>

<div <?php echo wp_kses_data( get_block_wrapper_attributes() ) ?>>
	<table class="prayer-times-table prayer-times-table-yearly">
		<thead>
		<tr>
			<?php foreach ( \AminulBD\Ramadan\Helper::get_headings() as $heading ) : ?>
				<th><?php esc_html( $heading ); ?></th>
			<?php endforeach; ?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( \AminulBD\Ramadan\Helper::get_months() as $month => $monthName ) : ?>
			<tr>
				<th colspan="8"><?php echo esc_html( $monthName ); ?></th>
			</tr>
			<?php foreach ( $calendar->{$month}() as $day => $schedule ) : ?>
				<tr>
					<td><?php echo date_i18n( 'd -- l', strtotime( "$year-$day" ) ); ?> </td>
					<td><?php echo date_i18n( 'h:i A', strtotime( "$year-$day {$schedule['sahri']}" ) ); ?> </td>
					<td><?php echo date_i18n( 'h:i A', strtotime( "$year-$day {$schedule['fajr']}" ) ); ?> </td>
					<td><?php echo date_i18n( 'h:i A', strtotime( "$year-$day {$schedule['sunrise']}" ) ); ?> </td>
					<td><?php echo date_i18n( 'h:i A', strtotime( "$year-$day {$schedule['dhuhr']}" ) ); ?> </td>
					<td><?php echo date_i18n( 'h:i A', strtotime( "$year-$day {$schedule['asr']}" ) ); ?> </td>
					<td><?php echo date_i18n( 'h:i A', strtotime( "$year-$day {$schedule['maghrib']}" ) ); ?> </td>
					<td><?php echo date_i18n( 'h:i A', strtotime( "$year-$day {$schedule['isha']}" ) ); ?> </td>
				</tr>
			<?php endforeach; ?>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>