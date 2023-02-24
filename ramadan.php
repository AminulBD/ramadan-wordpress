<?php
/*
 * Plugin Name: Ramadan
 * Plugin URI: https://aminul.net/wordpress-plugins/ramadan
 * Description: Display Ramadan schedule.
 * Version: 1.0.0
 * Author: Aminul Islam
 * Author URI: https://aminul.net/
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ramadan
 * Domain Path: /languages
 * Requires at least: 5.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RAMADAN_VERSION', '1.0.0' );
define( 'RAMADAN_PATH', plugin_dir_path( __FILE__ ) );
define( 'RAMADAN_URL', plugin_dir_url( __FILE__ ) );

require_once RAMADAN_PATH . 'includes/autoloader.php';

function ramadan() {
	return \AminulBD\Ramadan\Plugin::init();
}

ramadan();

// if admin
if ( is_admin() ) {
	new \AminulBD\Ramadan\Admin();
}
