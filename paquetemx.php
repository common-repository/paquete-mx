<?php
/**
 * @package Paquete_MX
 * @version 4.2.2
 */
/*
Plugin Name: Paquete.MX
Description: Este plugin permite integrar los servicios de Paquete.mx en Woocommerce para Wordpress
Version: 4.2.2
Author: PAQUETE.MX
Author URI: https://paquete.mx
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/************************/
/*						*/
/*		PMX SHIPPING	*/
/*		FUNCTIONS		*/
/*						*/
/************************/
require_once(dirname(__FILE__) . '/PMX_Shipping_Functions.php');

/************************/
/*						*/
/*		ACTIONS			*/
/*						*/
/************************/
require_once(dirname(__FILE__) . '/admin/admin_actions.php');


/************************/
/*						*/
/*	SETTINGS CALLBACKS	*/
/*						*/
/************************/
require_once(dirname(__FILE__) . '/admin/settings_cb.php');


/************************/
/*						*/
/*	NEW SHIPPING METHOD	*/
/*						*/
/************************/
require_once(dirname(__FILE__) . '/admin/shipping_method.php');

/************************/
/*						*/
/*	CUSTOM PRODUCT		*/
/*		SETTINGS		*/
/*						*/
/************************/
require_once(dirname(__FILE__) . '/admin/products_shipping_settings.php');

/************************/
/*						*/
/*	  INSTALL PLUGIN	*/
/*						*/
/************************/
require_once(dirname(__FILE__) . '/install.php');

/**
 * 	Adds additional links to plugins page
 */
function paquetemx_links( $links ) {
	$plugin_links = array();

	$plugin_links[] = '<a href="' . esc_url('admin.php?page=paquetemx') . '">' . esc_html( 'Ajustes' ) . '</a>';
	$plugin_links[] = '<a href="' . esc_url('https://paquete.mx/docs/plugin/wordpress/DocumentacionPluginWordpress.pdf') . '">' . esc_html( 'Documentación' ) . '</a>';

	return array_merge( $plugin_links, $links );
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'paquetemx_links' );

register_activation_hook( __FILE__, 'paquetemx_activate' );