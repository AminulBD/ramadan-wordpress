<?php

namespace AminulBD\Ramadan;

class Admin {
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
	}

	public function add_settings_page() {
		add_options_page(
				__( 'Ramadan Settings', 'ramadan' ),
				__( 'Ramadan', 'ramadan' ),
				'manage_options',
				'ramadan',
				[ $this, 'render_settings_page' ]
		);
	}

	public function render_settings_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Ramadan Settings', 'ramadan' ); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'ramadan' );
				do_settings_sections( 'ramadan' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	public function register_settings() {
		register_setting( 'ramadan', 'ramadan_page_id' );
		register_setting( 'ramadan', 'ramadan_start_date' );
		register_setting( 'ramadan', 'ramadan_city_page_id' );
		register_setting( 'ramadan', 'ramadan_namaz_page_id' );
		register_setting( 'ramadan', 'ramadan_namaz_city_page_id' );
		register_setting( 'ramadan', 'ramadan_date_formats' );
		add_settings_section( 'ramadan', __( 'Ramadan Settings', 'ramadan' ), [ $this, 'render_settings_section' ], 'ramadan' );
		add_settings_field( 'ramadan_start_date', __( 'Ramadan Start Date', 'ramadan' ), [ $this, 'render_ramadan_start_date' ], 'ramadan', 'ramadan' );
		add_settings_field( 'ramadan_page_id', __( 'Ramadan Page', 'ramadan' ), [ $this, 'render_ramadan_page_dropdown' ], 'ramadan', 'ramadan' );
		add_settings_field( 'ramadan_city_page_id', __( 'Ramadan City Page', 'ramadan' ), [ $this, 'render_ramadan_city_page_dropdown' ], 'ramadan', 'ramadan' );
		add_settings_field( 'ramadan_namaz_page_id', __( 'Namaz Page', 'ramadan' ), [ $this, 'render_namaz_page_dropdown' ], 'ramadan', 'ramadan' );
		add_settings_field( 'ramadan_namaz_city_page_id', __( 'Namaz City Page', 'ramadan' ), [ $this, 'render_namaz_city_page_dropdown' ], 'ramadan', 'ramadan' );
		add_settings_field( 'ramadan_date_formats', __( 'Date Formats', 'ramadan' ), [ $this, 'render_date_formats' ], 'ramadan', 'ramadan' );
	}

	public function render_settings_section() {
		?>
		<p><?php esc_html_e( 'Settings for Ramadan plugin.', 'ramadan' ); ?></p>
		<?php
	}

	public function render_ramadan_page_dropdown() {
		?>
		<select name="ramadan_page_id">
			<option value=""><?php esc_html_e( '- Select -', 'ramadan' ); ?></option>
			<?php foreach ( get_pages() as $page ) : ?>
				<option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $page->ID, get_option( 'ramadan_page_id' ) ); ?>>
					<?php echo esc_html( $page->post_title ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?php
	}

	public function render_ramadan_start_date() {
		?>
		<input type="date" name="ramadan_start_date" value="<?php echo esc_attr( get_option( 'ramadan_start_date' ) ); ?>">
		<?php
	}

	public function render_ramadan_city_page_dropdown() {
		?>
		<select name="ramadan_city_page_id">
			<option value=""><?php esc_html_e( '- Select -', 'ramadan' ); ?></option>
			<?php foreach ( get_pages() as $page ) : ?>
				<option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $page->ID, get_option( 'ramadan_city_page_id' ) ); ?>>
					<?php echo esc_html( $page->post_title ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?php
	}

	public function render_namaz_page_dropdown() {
		?>
		<select name="ramadan_namaz_page_id">
			<option value=""><?php esc_html_e( '- Select -', 'ramadan' ); ?></option>
			<?php foreach ( get_pages() as $page ) : ?>
				<option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $page->ID, get_option( 'ramadan_namaz_page_id' ) ); ?>>
					<?php echo esc_html( $page->post_title ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?php
	}

	public function render_namaz_city_page_dropdown() {
		?>
		<select name="ramadan_namaz_city_page_id">
			<option value=""><?php esc_html_e( '- Select -', 'ramadan' ); ?></option>
			<?php foreach ( get_pages() as $page ) : ?>
				<option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $page->ID, get_option( 'ramadan_namaz_city_page_id' ) ); ?>>
					<?php echo esc_html( $page->post_title ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?php
	}

	public function render_date_formats() {
		$formats = get_option( 'ramadan_date_formats' ) ?: [];
		$today   = isset( $formats['today'] ) ? $formats['today'] : 'd F, l';
		$date    = isset( $formats['date'] ) ? $formats['date'] : 'd F, l';
		$day     = isset( $formats['day'] ) ? $formats['day'] : 'l';
		$month   = isset( $formats['month'] ) ? $formats['month'] : 'F';
		$year    = isset( $formats['year'] ) ? $formats['year'] : 'Y';
		$time    = isset( $formats['time'] ) ? $formats['time'] : 'h:i A';
		?>
		<table>
		<tr>
			<td><?php esc_html_e( 'Day Format', 'ramadan' ); ?></td>
			<td><input type="text" name="ramadan_date_formats[today]" value="<?php echo esc_attr( $today ); ?>"></td>
		</tr>
		<tr>
			<td><?php esc_html_e( 'Date Format', 'ramadan' ); ?></td>
			<td><input type="text" name="ramadan_date_formats[date]" value="<?php echo esc_attr( $date ); ?>"></td>
		</tr>
		<tr>
			<td><?php esc_html_e( 'Day Format', 'ramadan' ); ?></td>
			<td><input type="text" name="ramadan_date_formats[day]" value="<?php echo esc_attr( $day ); ?>"></td>
		</tr>
		<tr>
			<td><?php esc_html_e( 'Month Format', 'ramadan' ); ?></td>
			<td><input type="text" name="ramadan_date_formats[month]" value="<?php echo esc_attr( $month ); ?>"></td>
		</tr>
		<tr>
			<td><?php esc_html_e( 'Year Format', 'ramadan' ); ?></td>
			<td><input type="text" name="ramadan_date_formats[year]" value="<?php echo esc_attr( $year ); ?>"></td>
		</tr>
		<tr>
			<td><?php esc_html_e( 'Time Format', 'ramadan' ); ?></td>
			<td><input type="text" name="ramadan_date_formats[time]" value="<?php echo esc_attr( $time ); ?>"></td>
		</tr>
		<?php
	}
}
