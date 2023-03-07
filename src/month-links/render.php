<?php
/**
 * Render month links as list.
 *
 * @package ramadan
 */

$month = get_query_var( 'ramadan_month' );
if ( empty( $month ) ) {
	$month = strtolower( current_datetime()->format( 'F' ) );
}
?>

<div <?php echo wp_kses_data( get_block_wrapper_attributes( [ 'class' => 'ramadan-block-container' ] ) ); ?>>
	<ul class="prayer-times-month-links">
		<?php foreach ( \AminulBD\Ramadan\Helper::get_months() as $name => $label ) : ?>
			<li class="<?php echo esc_attr( $month === $name ? 'active' : 'inactive' ); ?>">
				<a href="<?php echo esc_url( \AminulBD\Ramadan\Helper::get_permalink( [ 'ramadan_month' => $name ] ) ); ?>"><?php echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>
