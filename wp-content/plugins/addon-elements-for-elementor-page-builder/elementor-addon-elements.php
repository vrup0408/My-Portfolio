<?php

/**
 * Plugin Name: Elementor Addon Elements
 * Description: Elementor Addon Elements comes with 25+ widgets and extensions to extend the power of Elementor Page Builder.
 * Plugin URI: https://www.elementoraddons.com/elements-addon-elements/
 * Author: WPVibes
 * Version: 1.11.15
 * Author URI: https://wpvibes.com/
 * Elementor tested up to: 3.6
 * Elementor Pro tested up to: 3.6.4
 * Text Domain: wts-eae
 * @package WTS_EAE
 */
define( 'EAE_FILE', __FILE__ );
define( 'EAE_URL', plugins_url( '/', __FILE__ ) );
define( 'EAE_PATH', plugin_dir_path( __FILE__ ) );
define( 'EAE_SCRIPT_SUFFIX', defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
define( 'EAE_VERSION', '1.11.15' );


if ( ! function_exists( '_is_elementor_installed' ) ) {

	function _is_elementor_installed() {
		$file_path         = 'elementor/elementor.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}
}

if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
}
if ( ! function_exists( 'wpv_eae' ) ) {
	// Create a helper function for easy SDK access.
	function wpv_eae() {
		global $wpv_eae;

		if ( ! isset( $wpv_eae ) ) {
			// Include Freemius SDK.
			require_once dirname( __FILE__ ) . '/freemius/start.php';
			$wpv_eae = fs_dynamic_init(
				[
					'id'             => '4599',
					'slug'           => 'addon-elements-for-elementor-page-builder',
					'type'           => 'plugin',
					'public_key'     => 'pk_086ef046431438c9a172bb55fde28',
					'is_premium'     => false,
					'has_addons'     => false,
					'has_paid_plans' => false,
					'menu'           => [
						'slug'    => 'eae-settings',
						'account' => false,
						'contact' => false,
					],
				]
			);
		}

		return $wpv_eae;
	}

	// Init Freemius.
	wpv_eae();
	// Signal that SDK was initiated.
	do_action( 'wpv_eae_loaded' );
}
/**
 * Handles plugin activation actions.
 *
 * @since 1.0
 */
function eae_activate() {
	if ( ! is_plugin_active( 'elementor/elementor.php' ) ) {
		return;
	}
	\Elementor\Plugin::$instance->files_manager->clear_cache();
}
register_activation_hook( __FILE__, 'eae_activate' );
require_once 'inc/bootstrap.php';
