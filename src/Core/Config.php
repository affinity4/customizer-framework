<?php declare(strict_types=1);

namespace CustomizerFramework\Core;

defined( 'ABSPATH' ) || exit;

use function CustomizerFramework\assets_url;

/**
 * Config.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Config
{

	/**
	 * Register third party libraries.
	 *
	 * @since 1.0.0
	 */
	public function register_enqueue() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue' ] );
	}


	/**
	 * Equeue styles and scripts.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		// editor
		if (function_exists('wp_enqueue_editor')) {
			wp_enqueue_editor();
		}

		// media
		if (function_exists('wp_enqueue_media')) {
			wp_enqueue_media();
		}

		// CSS
		wp_enqueue_style('customizer-framework--control-ui-style', assets_url() . '/css/control-ui.css');

		// JS
		wp_enqueue_script('customizer-framework--helper', assets_url() . '/js/helper.js', array('jquery'), '1.0', true);
		wp_enqueue_script('customizer-framework--control', assets_url() . '/js/control.js', array('jquery'), '1.0', true);
	}
}
