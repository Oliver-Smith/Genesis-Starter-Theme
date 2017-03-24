<?php
/**
 * Asset loader handler.
 *
 * @package     RedThreadCreative\RedThreadChild
 * @since       1.0.2
 * @author      redthreadollie
 * @link        https://www.redthreadcreative.co.uk
 * @license     GNU General Public License 2.0+
 */
namespace RedThreadCreative\RedThreadChild;

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );
/**
 * Enqueue Scripts and Styles.
 *
 * @since 2.3.0
 *
 * @return void
 */
function enqueue_assets() {

	wp_enqueue_style( CHILD_TEXT_DOMAIN . '-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	// suffix added by StudioPress in version 2.3.0
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 
		CHILD_TEXT_DOMAIN . '-responsive-menu', 
		CHILD_URL . "/assets/js/responsive-menu{$suffix}.js", 
		array( 'jquery' ), 
		CHILD_THEME_VERSION, 
		true 
	);

	// changed for new Sample theme v.2.3.0
	wp_localize_script( 
		CHILD_TEXT_DOMAIN . '-responsive-menu', 
		'developersL10n', 
		get_sample_responsive_menu_settings() 
	);
}

/**
 * Get the sample theme's responsive menu settings
 *
 * @since 2.3.0
 *
 * @return array
 */
function get_sample_responsive_menu_settings() {
	$settings = array(
		'mainMenu'          => __( 'Menu', CHILD_TEXT_DOMAIN ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', CHILD_TEXT_DOMAIN ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);
	return $settings;
}
