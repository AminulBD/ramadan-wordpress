<?php
/**
 * Render ramadan prayer times table.
 *
 * @package ramadan
 */

$city       = isset( $attributes['city'] ) ? $attributes['city'] : '';
$city       = empty( $city ) ? get_query_var( 'ramadan_city' ) : $city;
$dateformat = empty( $attributes['dateformat'] ) ? 'd M' : $attributes['dateformat'];
$timeformat = empty( $attributes['timeformat'] ) ? 'h:i A' : $attributes['timeformat'];
$dayformat  = empty( $attributes['dayformat'] ) ? 'D' : $attributes['dayformat'];
$date       = isset( $attributes['date'] ) ? $attributes['date'] : '';
$date       = empty( $date ) ? get_option( 'ramadan_start_date' ) : $date;
$year       = ( new \DateTime( $date ) )->format( 'Y' );
$today      = current_datetime()->format( 'Y-m-d' );
$calendar   = new \AminulBD\Ramadan\Prayer_Calendar( $city );
$schedules  = $calendar->ramadan( $date );
$count      = 0;
?>
<div <?php echo wp_kses_data( get_block_wrapper_attributes( [ 'class' => 'ramadan-block-container' ] ) ); ?>>
	<table class="prayer-times-table prayer-times-table-ramadan">
		<thead>
		<tr>
			<th><?php echo esc_html( 'Ramadan' ); ?></th>
			<th><?php echo esc_html( 'Date' ); ?></th>
			<th><?php echo esc_html( 'Day' ); ?></th>
			<th><?php echo esc_html( 'Sahri' ); ?></th>
			<th><?php echo esc_html( 'Fajr' ); ?></th>
			<th><?php echo esc_html( 'Iftar' ); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( array_chunk( $schedules, 10, true ) as $stage => $tendays ) : ?>
			<tr class="group-caption">
				<td colspan="9">
					<?php
					switch ( $stage ) {
						case 0:
							echo esc_html__( '10 Days: Mercy of Allah', 'ramadan' );
							break;
						case 1:
							echo esc_html__( '10 Days: Forgiveness of Allah', 'ramadan' );
							break;
						case 2:
							echo esc_html__( '10 Days: Safety from the Hellfire', 'ramadan' );
							break;
					}
					?>
				</td>
			</tr>
			<?php foreach ( $tendays as $day => $schedule ) : ?>
				<tr class="<?php echo esc_attr( $today === "$year-$day" ? 'today' : 'other-day' ) ?>">
					<?php $count ++; ?>
					<td><?php echo number_format_i18n( $count ); ?></td>
					<td><?php echo date_i18n( $dateformat, strtotime( "$year-$day" ) ); ?></td>
					<td><?php echo date_i18n( $dayformat, strtotime( "$year-$day" ) ); ?></td>
					<td><?php echo date_i18n( $timeformat, strtotime( "$year-$day {$schedule['sahri']}" ) ); ?></td>
					<td><?php echo date_i18n( $timeformat, strtotime( "$year-$day {$schedule['fajr']}" ) ); ?></td>
					<td><?php echo date_i18n( $timeformat, strtotime( "$year-$day {$schedule['maghrib']}" ) ); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
