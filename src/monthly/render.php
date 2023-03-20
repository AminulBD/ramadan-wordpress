<?php
/**
 * Render monthly prayer times table.
 *
 * @package ramadan
 */

$city       = isset( $attributes['city'] ) ? $attributes['city'] : '';
$city       = empty( $city ) ? get_query_var( 'ramadan_city' ) : $city;
$dateformat = empty( $attributes['dateformat'] ) ? 'd F, l' : $attributes['dateformat'];
$timeformat = empty( $attributes['timeformat'] ) ? 'h:i A' : $attributes['timeformat'];
$dayformat  = empty( $attributes['dayformat'] ) ? 'D' : $attributes['dayformat'];
$year       = isset( $attributes['year'] ) ? $attributes['year'] : '';
$year       = empty( $year ) ? current_datetime()->format( 'Y' ) : $year;
$month      = isset( $attributes['month'] ) ? $attributes['month'] : get_query_var( 'ramadan_month' );
$month      = empty( $month ) ? current_datetime()->format( 'F' ) : $month;
$columns    = empty( $attributes['columns'] ) ? [] : $attributes['columns'];
$calendar   = new \AminulBD\Ramadan\Prayer_Calendar( $city );
$schedules  = $calendar->{strtolower( $month )}();
$today      = current_datetime()->format( 'Y-m-d' );
$headings   = \AminulBD\Ramadan\Helper::get_headings();
$headings   = array_filter( $headings, function ( $key ) use ( $columns ) {
	return isset( $columns[ $key ] ) && ( $columns[ $key ] === true || $columns[ $key ] === 'true' );
}, ARRAY_FILTER_USE_KEY );
?>

<div <?php echo wp_kses_data( get_block_wrapper_attributes( [ 'class' => 'ramadan-block-container' ] ) ); ?>>
	<table class="prayer-times-table prayer-times-table-monthly">
		<thead>
		<tr>
			<?php foreach ( $headings as $heading ) : ?>
				<th><?php echo esc_html( $heading ); ?></th>
			<?php endforeach; ?>
		</tr>
		</thead>
		<tbody>
		<?php foreach ( $schedules as $day => $schedule ) : ?>
			<tr class="<?php echo esc_attr( $today === "$year-$day" ? 'today' : 'other-day' ) ?>">
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
		</tbody>
	</table>
</div>
