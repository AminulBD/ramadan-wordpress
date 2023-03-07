<?php
/**
 * Render city selector.
 *
 * @package ramadan
 */

$city   = get_query_var( 'ramadan_city' );
$city   = empty( $city ) ? 'dhaka' : $city;
$cities = \AminulBD\Ramadan\Helper::get_cities();
?>

<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
	<label for="ramadan-city-selector"><?php echo esc_html__( 'Select City', 'ramadan' ); ?></label>
	<select class="ramadan-city-selector" onchange="document.location.href=this.value">
		<?php foreach ( $cities as $division ) : ?>
			<optgroup label="<?php esc_attr( $division['title'] ); ?>">
				<?php foreach ( $division['cities'] as $name => $title ) : ?>
					<option value="<?php echo esc_url( \AminulBD\Ramadan\Helper::get_permalink( [ 'ramadan_city' => $name ] ) ) ?>" <?php echo esc_attr( $city === $name ? ' selected' : '' ); ?>>
						<?php echo esc_html( $title ); ?>
					</option>
				<?php endforeach; ?>
			</optgroup>
		<?php endforeach; ?>
	</select>
</div>
