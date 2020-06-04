<?php
/**
 * Theme functions file
 *
 * This loads Church Theme Framework and includes files having functions, classes and other code used by the theme.
 *
 * If you want to edit code, it is best to use a child theme so changes are not lost after an update (see guides).
 *
 * @package   Maranatha
 * @copyright Copyright (c) 2015, ChurchThemes.com
 * @link      https://churchthemes.com/themes/maranatha
 * @license   GPLv2 or later
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Load framework
 */
require_once get_template_directory() . '/framework/framework.php'; // do this before anything

/**
 * Includes to load
 */
$maranatha_includes = array(

	// Frontend or Admin
	'always' => array(

		// Functions
		CTFW_THEME_INC_DIR . '/banner.php',
		CTFW_THEME_INC_DIR . '/content.php',
		CTFW_THEME_INC_DIR . '/customize.php',
		CTFW_THEME_INC_DIR . '/customize-defaults.php',
		CTFW_THEME_INC_DIR . '/content-types.php',
		CTFW_THEME_INC_DIR . '/events.php',
		CTFW_THEME_INC_DIR . '/fonts.php',
		CTFW_THEME_INC_DIR . '/gallery.php',
		CTFW_THEME_INC_DIR . '/head.php', // Customizer needs it
		CTFW_THEME_INC_DIR . '/icons.php',
		CTFW_THEME_INC_DIR . '/images.php',
		CTFW_THEME_INC_DIR . '/loop-after-content.php',
		CTFW_THEME_INC_DIR . '/navigation.php',
		CTFW_THEME_INC_DIR . '/sidebars.php',
		CTFW_THEME_INC_DIR . '/support-ctc.php',
		CTFW_THEME_INC_DIR . '/support-framework.php',
		CTFW_THEME_INC_DIR . '/support-wp.php',
		CTFW_THEME_INC_DIR . '/template-tags.php',

	),

	// Admin Only
	'admin' => array(

		// Functions
		CTFW_THEME_ADMIN_DIR . '/meta-boxes.php',
		CTFW_THEME_ADMIN_DIR . '/admin-enqueue-styles.php',

	),

	// Frontend Only
	'frontend' => array (

		// Functions
		CTFW_THEME_INC_DIR . '/body.php',
		CTFW_THEME_INC_DIR . '/enqueue-styles.php',
		CTFW_THEME_INC_DIR . '/enqueue-scripts.php',

	),

);

/**
 * Filter includes
 */
$maranatha_includes = apply_filters( 'maranatha_includes', $maranatha_includes ); // make filterable

/**
 * Load includes
 */
ctfw_load_includes( $maranatha_includes );


/**
 * Custom functions
 */

// Shortcode: [latest-sermon-series]
function latest_sermon_series_func( $atts ){
	// Post filters
	$args = array(
		'post_type'       	=> 'ctc_sermon',
		'orderby'         	=> 'date',
		'order'           	=> 'DESC',
		'numberposts'     	=> 1,
		'suppress_filters'	=> false
	);
	// Get posts with filters from WP
	$post = get_posts( $args );
	// Determine latest sermon series from series in last post
	$series = get_the_term_list( $post[0]->ID, 'ctc_sermon_series', '', __( ', ', 'maranatha' ) );
	// Restore post context
	wp_reset_postdata();
	return $series;
}
add_shortcode( 'latest-sermon-series', 'latest_sermon_series_func' );
