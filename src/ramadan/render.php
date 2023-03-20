<?php
/**
 * Render ramadan prayer times table.
 *
 * @package ramadan
 */

$city               = isset( $attributes['city'] ) ? $attributes['city'] : '';
$city               = empty( $city ) ? get_query_var( 'ramadan_city' ) : $city;
$first_phase_title  = empty( $attributes['first_phase_title'] ) ? __( '10 Days: Mercy of Allah', 'ramadan' ) : $attributes['first_phase_title'];
$second_phase_title = empty( $attributes['second_phase_title'] ) ? __( '10 Days: Forgiveness of Allah', 'ramadan' ) : $attributes['second_phase_title'];
$third_phase_title  = empty( $attributes['third_phase_title'] ) ? __( '10 Days: Safety from the Hellfire', 'ramadan' ) : $attributes['third_phase_title'];
$dateformat         = empty( $attributes['dateformat'] ) ? 'd M' : $attributes['dateformat'];
$timeformat         = empty( $attributes['timeformat'] ) ? 'h:i A' : $attributes['timeformat'];
$dayformat          = empty( $attributes['dayformat'] ) ? 'D' : $attributes['dayformat'];
$columns            = empty( $attributes['columns'] ) ? [] : $attributes['columns'];
$date               = isset( $attributes['date'] ) ? $attributes['date'] : '';
$date               = empty( $date ) ? get_option( 'ramadan_start_date' ) : $date;
$year               = ( new \DateTime( $date ) )->format( 'Y' );
$today              = current_datetime()->format( 'Y-m-d' );
$calendar           = new \AminulBD\Ramadan\Prayer_Calendar( $city );
$schedules          = $calendar->ramadan( $date );
$count              = 0;
$headings           = \AminulBD\Ramadan\Helper::get_headings();
$headings           = array_filter( $headings, function ( $key ) use ( $columns ) {
	return isset( $columns[ $key ] ) && ( $columns[ $key ] === true || $columns[ $key ] === 'true' );
}, ARRAY_FILTER_USE_KEY );
?>
<div <?php echo wp_kses_data( get_block_wrapper_attributes( [ 'class' => 'ramadan-block-container' ] ) ); ?>>
	<table class="prayer-times-table prayer-times-table-ramadan">
		<thead>
		<tr>
			<th><?php echo esc_html( 'Ramadan' ); ?></th>
			<?php foreach ( $headings as $heading ) : ?>
				<th><?php echo esc_html( $heading ); ?></th>
			<?php endforeach; ?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( array_chunk( $schedules, 10, true ) as $stage => $tendays ) : ?>
			<tr class="group-caption">
				<td colspan="<?php echo esc_attr( count( $headings ) + 1 ); ?>">
					<?php
					switch ( $stage ) {
						case 0:
							echo esc_html( $first_phase_title );
							break;
						case 1:
							echo esc_html( $second_phase_title );
							break;
						case 2:
							echo esc_html( $third_phase_title );
							break;
					}
					?>
				</td>
			</tr>
			<?php foreach ( $tendays as $day => $schedule ) : ?>
				<tr class="<?php echo esc_attr( $today === "$year-$day" ? 'today' : 'other-day' ) ?>">
					<?php $count ++; ?>
					<td><?php echo number_format_i18n( $count ); ?></td>
					<?php foreach ( $headings as $column => $heading ): ?>
						<?php if ( $column === 'date' ) : ?>
							<td><?php echo date_i18n( $dateformat, strtotime( "$year-$day" ) ); ?></td>
						<?php elseif ( $column === 'day' ) : ?>
							<td><?php echo date_i18n( $dayformat, strtotime( "$year-$day" ) ); ?></td>
						<?php elseif ( isset( $schedule[ $column ] ) ): ?>
							<td><?php echo date_i18n( $timeformat, strtotime( "$year-$day $schedule[$column]" ) ); ?></td>
						<?php else: ?>
							<td>-</td>
						<?php endif; ?>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
