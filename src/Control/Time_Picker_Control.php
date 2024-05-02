<?php declare(strict_types=1);

namespace CustomizerFramework\Control;

defined( 'ABSPATH' ) || exit;

use function CustomizerFramework\assets_url;

/**
 * Time Picker Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Time_Picker_Control extends \WP_Customize_Control
{
	/**
	 * Time format in military.
	 *
	 * @since 1.0.0
	 *
	 * @var boolean
	 */
	public $military_format;

	/**
	 * Adding third party libraries.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		// css
		if ( wp_style_is( 'customizer-framework--flatpickr-css', 'enqueued' ) == false ){
			wp_enqueue_style( 'customizer-framework--flatpickr-css', assets_url() . '/flatpickr/flatpickr.min.css' );
		}

		// js
		if ( wp_script_is( 'customizer-framework--flatpickr-js', 'enqueued' ) == false ){
			wp_enqueue_script( 'customizer-framework--flatpickr-js', assets_url() . '/flatpickr/flatpickr.min.js', array('jquery'), '1.0', true );
		}
	}


	/**
	 * Render the time picker controller and display in frontend.
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

		<div class="customizer-framework--time-picker-parent">
			<div class="customizer-framework--time-picker-parent-container">
				<input type="hidden"
				 		id="customizer-framework--time-picker-input-main-<?php echo esc_attr( $this->id ); ?>"
				 		name="<?php echo esc_attr( $this->id ); ?>"
				 		value="<?php echo esc_attr( $this->value() ); ?>"
				 		<?php echo $this->link(); ?>>

				<input type="text"
					   id="customizer-framework--time-picker-input-<?php echo esc_attr( $this->id ); ?>"
					   class="customizer-framework--time-picker-input"
					   data-id="<?php echo esc_attr( $this->id ); ?>"
					   data-military_format="<?php echo esc_attr( $this->military_format ); ?>"
					   data-value="<?php echo esc_attr( $this->value() ); ?>"
					   placeholder="<?php echo (isset($this->input_attrs['placeholder'])) ? esc_attr($this->input_attrs['placeholder']) : '' ?>">

				<button class="customizer-framework--time-picker-btn customizer-framework--time-picker-btn-open" data-id="<?php echo esc_attr( $this->id ); ?>">
					<i class="dashicons dashicons-clock"></i>
				</button>

				<button class="customizer-framework--time-picker-btn customizer-framework--time-picker-btn-clear" data-id="<?php echo esc_attr( $this->id ); ?>">
					<i class="dashicons dashicons-no-alt"></i>
				</button>
			</div>
		</div>
	<?php
	}
}
