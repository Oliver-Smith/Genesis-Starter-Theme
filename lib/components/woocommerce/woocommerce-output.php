<?php
/**
 * Genesis Sample.
 *
 * This file adds the WooCommerce styles and the Customizer additions for WooCommerce to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

namespace RedThreadCreative\RedThreadChild\Customizer;

use RedThreadCreative\RedThreadChild\Customizer as customizer;

add_filter( 'woocommerce_enqueue_styles', __NAMESPACE__ . '\enqueue_woocommerce_styles' );
/**
 * Enqueue the theme's custom WooCommerce styles to the WooCommerce plugin.
 *
 * @since 2.3.0
 *
 * @param array $enqueue_styles An array of styles
 *
 * @return array Required values for the Genesis Sample Theme's WooCommerce stylesheet.
 */
function enqueue_woocommerce_styles( $enqueue_styles ) {
	$enqueue_styles[ get_woo_style_handle() ] = array(
		'src'     => CHILD_URL . '/lib/components/woocommerce/assets/css/woocommerce.css',
		'deps'    => '',
		'version' => CHILD_THEME_VERSION,
		'media'   => 'screen'
	);
	return $enqueue_styles;
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\build_incline_css_from_customizer_settings' );
/**
* Checks the settings for the link color, and accent color.
* If any of these value are set the appropriate CSS is output.
*
* @since 1.0.0
 *
 * @return void
*/
function build_incline_css_from_customizer_settings() {
	// If WooCommerce isn't active, exit early.
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}
	$prefix = customizer\get_settings_prefix();
	$color_link = get_theme_mod( $prefix . '_link_color', customizer\get_default_link_color() );
	$color_accent = get_theme_mod( $prefix . '_accent_color', customizer\get_default_accent_color() );
	$css = '';
	$css .= ( customizer\get_default_link_color() !== $color_link ) ? sprintf( '
		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover,
		.woocommerce div.product .woocommerce-tabs ul.tabs li a:focus,
		.woocommerce ul.products li.product h3:hover,
		.woocommerce ul.products li.product .price,
		.woocommerce .woocommerce-breadcrumb a:hover,
		.woocommerce .woocommerce-breadcrumb a:focus,
		.woocommerce .widget_layered_nav ul li.chosen a::before,
		.woocommerce .widget_layered_nav_filters ul li a::before,
		.woocommerce .widget_rating_filter ul li.chosen a::before {
			color: %s;
		', $color_link ) : '';
	$css .= ( customizer\get_default_accent_color() !== $color_accent ) ? sprintf( '
		.woocommerce a.button:hover,
		.woocommerce a.button:focus,
		.woocommerce a.button.alt:hover,
		.woocommerce a.button.alt:focus,
		.woocommerce button.button:hover,
		.woocommerce button.button:focus,
		.woocommerce button.button.alt:hover,
		.woocommerce button.button.alt:focus,
		.woocommerce input.button:hover,
		.woocommerce input.button:focus,
		.woocommerce input.button.alt:hover,
		.woocommerce input.button.alt:focus,
		.woocommerce input[type="submit"]:hover,
		.woocommerce input[type="submit"]:focus,
		.woocommerce span.onsale,
		.woocommerce #respond input#submit:hover,
		.woocommerce #respond input#submit:focus,
		.woocommerce #respond input#submit.alt:hover,
		.woocommerce #respond input#submit.alt:focus,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-handle,
		.woocommerce.widget_price_filter .ui-slider .ui-slider-range {
			background-color: %1$s;
			color: %2$s;
		}
		.woocommerce-error,
		.woocommerce-info,
		.woocommerce-message {
			border-top-color: %1$s;
		}
		.woocommerce-error::before,
		.woocommerce-info::before,
		.woocommerce-message::before {
			color: %1$s;
		}
		', $color_accent, customizer\calculate_color_contrast( $color_accent ) ) : '';
	if ( ! $css ) {
		return;
	}
	wp_add_inline_style( get_woo_style_handle(), $css );
}
/**
 * Get styles handle for the WooCommerce module.
 *
 * @since 1.0.0
 *
 * @return string
 */
function get_woo_style_handle() {
	if ( defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ) {
		return sanitize_title_with_dashes( CHILD_THEME_NAME )  . '-woocommerce-styles';
	}
	return 'child-theme-woocomerce-styles';
}
