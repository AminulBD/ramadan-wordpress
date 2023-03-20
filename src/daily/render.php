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
$dayformat  = empty( $attributes['dayformat'] ) ? 'D' : $attributes['dayformat'];
$current    = current_datetime()->format( 'Y-m-d' );
$date       = isset( $attributes['date'] ) ? $attributes['date'] : $current;
$date       = empty( $date ) ? $current : $date;
$columns    = empty( $attributes['columns'] ) ? [] : $attributes['columns'];
$calendar   = new \AminulBD\Ramadan\Prayer_Calendar( $city );
$schedule   = $calendar->today( $date );
$headings   = \AminulBD\Ramadan\Helper::get_headings();
$headings   = array_filter( $headings, function ( $key ) use ( $columns ) {
	return isset( $columns[ $key ] ) && ( $columns[ $key ] === true || $columns[ $key ] === 'true' );
}, ARRAY_FILTER_USE_KEY );
?>

<div <?php echo wp_kses_data( get_block_wrapper_attributes( [ 'class' => 'ramadan-block-container' ] ) ); ?>>
	<table class="prayer-times-table ramadan-times-table-today">
		<thead>
		<tr>
			<?php foreach ( $headings as $heading ) : ?>
				<th><?php echo esc_html( $heading ); ?></th>
			<?php endforeach; ?>
		</tr>
		</thead>
		<tbody>
		<tr>
			<?php foreach ( $headings as $column => $heading ): ?>
				<?php if ( $column === 'date' ) : ?>
					<td><?php echo date_i18n( $dateformat, strtotime( $date ) ); ?></td>
				<?php elseif ( $column === 'day' ) : ?>
					<td><?php echo date_i18n( $dayformat, strtotime( $date ) ); ?></td>
				<?php else: ?>
					<td><?php echo date_i18n( $timeformat, strtotime( "$date $schedule[$column]" ) ); ?></td>
				<?php endif; ?>
			<?php endforeach; ?>
		</tr>
		<tr>
		</tbody>
	</table>
</div>
