=== Ramadan ===
Contributors:      AminulBD
Tags:              block
Tested up to:      6.2
Stable tag:        1.0.3
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

Ramadan schedules block for WordPress.

== Description ==

The plugin adds a block to the WordPress editor that displays the Ramadan schedules for the current year.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/ramadan` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Ramadan block to add the Ramadan schedules to your post or page.
4. Please see the FAQ section for more information.

== Frequently Asked Questions ==

= What timezone currently are you supporting? =

Currently, we only support the Bangladesh timezone.

= Classic editor can use this? =

No. Only the block editor can use this.

= Whats is content variables? =

Content variables are the variables that can be used anywhere in the post title and content. Currently, we have three content variables:

- {{city}}:  Display the city name current active city name. Example: Dhaka, Chittagong, etc.
- {{today}}:  Display the current date. Example: 20 March, Monday
- {{date}}: Display the current date. Example: 20 March, Monday
- {{day}}: Display the current day. Example: Monday
- {{month}}: Display the current month. Example: March
- {{year}}: Display the current year. Example: 2020
- {{sahri_time}}: Display the current sahri time. Example: 04:40 AM
- {{fajr_time}}: Display the current fajr time. Example: 04:50 AM
- {{sunrise_time}}: Display the current sunrise time. Example: 05:30 AM
- {{dhuhr_time}}: Display the current dhuhr time. Example: 12:30 PM
- {{asr_time}}: Display the current asr time. Example: 03:30 PM
- {{maghrib_time}}: Display the current maghrib time. Example: 05:30 PM
- {{iftar_time}}: Display the current iftar time. Example: 05:30 PM
- {{sunset_time}}: Display the current sunset time. Example: 06:10 PM
- {{isha_time}}: Display the current isha time. Example: 07:50 PM

== Changelog ==

= 1.0.0 =
* Release

= 1.0.1 =
* Update block in native way

= 1.0.2 =
* Added style css file for the plugins

= 1.0.3 =
* Added: Support for the latest WordPress version
* Added: Ability control columns of any table
* Added: Content variables for `wp_title`, `the_content`, and `the_title`
