<?php declare(strict_types=1);

namespace CustomizerFramework\Control;

defined( 'ABSPATH' ) || exit;

use function CustomizerFramework\assets_url;

/**
 * Color Picker Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Color_Picker_Control extends \WP_Customize_Control
{
	/**
	 * The type of color format return [ HSVA, HSLA, RGBA, HEXA ].
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $format;


	/**
	 * The default value.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $default;


	/**
	 * Setting for opacity.
	 *
	 * @since 1.0.0
	 *
	 * @var boolean
	 */
	public $opacity;


	/**
	 * Get the default value.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	private function get_default() {
		return ( ! empty( $this->value() ) ? esc_attr( $this->value() ) : 'transparent'  );
	}


	/**
	 * Return the partial set color.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	private function get_partial_color() {
		return 'background: '. $this->get_default();
	}


	/**
	 * Get the opacity value with validation.
	 *
	 * @since 1.0.0
	 *
	 * @return number
	 */
	private function get_opacity() {
		$output = 0;
		if ( ! empty( $this->opacity ) ) {
			if ( $this->opacity == true ) {
				$output = 1;
			}
		}
		return $output;
	}


	/**
	 * Adding third party libraries.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		// css
		if ( wp_style_is( 'customizer-framework--pickr-css', 'enqueued' ) == false ){
			wp_enqueue_style( 'customizer-framework--pickr-css', assets_url() . '/pickr/pickr.min.css' );
		}

		// js
		if ( wp_script_is( 'customizer-framework--pickr-js', 'enqueued' ) == false ){
			wp_enqueue_script( 'customizer-framework--pickr-js', assets_url() . '/pickr/pickr.min.js', array(), '1.0', true );
		}
	}


	/**
	 * Render the color picker controller and display in frontend.
	 *
	 * @since 1.0.0
	 *
	 * @return html
	 */
	public function render_content() {
	?>
		<label>
			<?php if ( ! empty( $this->label ) ): ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ): ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>
		</label>

		<button class="customizer-framework--color-picker-selector" data-id="<?php echo esc_attr( $this->id ); ?>" >
			<div class="customizer-framework--color-picker-selector-color" style="background-image: url(' <?php echo \CustomizerFramework\resource_url(); ?>assets/img/transparent.jpg ');" >
				<div id="customizer-framework--color-picker-selector-color-<?php echo esc_attr( $this->id ); ?>" style="width: 100%; height: 100%; <?php echo $this->get_partial_color(); ?>;"></div>
			</div>
			<span>Select Color</span>
		</button>

		<div id="customizer-framework--color-picker-parent-<?php echo esc_attr( $this->id ); ?>" class="customizer-framework--color-picker-parent">
			<input type="hidden"
				   id="customizer-framework--color-picker-input-<?php echo esc_attr( $this->id ); ?>"
				   name="<?php echo esc_attr( $this->id ); ?>"
				   value="<?php echo esc_attr( $this->value() ); ?>"
				   <?php echo $this->link(); ?>>

			<div id="customizer-framework--color-picker-<?php echo esc_attr( $this->id ); ?>"
				 class="customizer-framework--color-picker"
				 data-id="<?php echo esc_attr( $this->id ); ?>"
				 data-format="<?php echo $this->format; ?>"
				 data-default="<?php echo $this->value(); ?>"
				 data-opacity="<?php echo $this->get_opacity(); ?>"></div>
		</div>

	<?php
	}
}
