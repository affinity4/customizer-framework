<?php declare(strict_types=1);

namespace CustomizerFramework\Control;

defined( 'ABSPATH' ) || exit;

use function CustomizerFramework\assets_url;

/**
 * Date Picker Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Date_Picker_Control extends \WP_Customize_Control
{
	/**
	 * Mode is to indentiy the mode settings whether its 'none' or 'range'.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $mode;


	/**
	 * enable_time is boolean set if time format is added.
	 *
	 * @since 1.0.0
	 *
	 * @var boolean
	 */
	public $enable_time;


	/**
	 * The placeholder in input.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $placeholder;


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
	 * Get the value of the mode.
	 *
	 * @return string    mode final value
	 */
	private function get_mode() {
		$output = 'single';
		if ( in_array( $this->mode, ['single', 'range'] ) ) {
			$output = $this->mode;
		}
		return $output;
	}

	/**
	 * Validate and Sanitize value
	 * @return string
	 */
	private function get_value() {
		$output = 'today';
		if ( ! empty( $this->value() ) ) {
			$output = $this->value();
			if ( is_array( $this->value() ) ) {
				$output = implode(',', $this->value());
			}
		}
		return $output;
	}


	/**
	 * Returns the imploded value whether in "array" or string format.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	private function imploded_value() {
		$output = $this->value();
		if ( is_array( $this->value() ) ) {
			$output = implode( ',', $this->value() );
		}
		return $output;
	}


	/**
	 * Render the date picker controller and display in frontend.
	 *
	 * @since 1.0.0
	 *
	 * @return html
	 */
	public function render_content() {
	?>
		<!-- Label and description -->
		<label>
			<?php if ( ! empty( $this->label ) ): ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ): ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>
		</label>

		<!-- Date Picker Control -->
		<div class="customizer-framework--date-picker-parent <?php echo ( $this->enable_time == true ? 'has-time' : '' ); ?>">
			<div class="customizer-framework--date-picker-parent-container">
				<input type="hidden"
				 		id="customizer-framework--date-picker-input-main-<?php echo esc_attr( $this->id ); ?>"
				 		name="<?php echo esc_attr( $this->id ); ?>"
				 		value="<?php echo esc_attr( $this->imploded_value() ); ?>"
				 		<?php echo $this->link(); ?>>

				<input type="text"
					   id="customizer-framework--date-picker-input-<?php echo esc_attr( $this->id ); ?>"
					   class="customizer-framework--date-picker-input"
					   data-id="<?php echo esc_attr( $this->id ); ?>"
					   data-mode="<?php echo esc_attr( $this->get_mode() ); ?>"
					   data-value="<?php echo esc_attr( $this->get_value() ); ?>"
					   data-enable_time="<?php echo esc_attr( $this->enable_time ); ?>"
					   placeholder="<?php echo esc_attr( $this->placeholder ); ?>">

				<button class="customizer-framework--date-picker-btn customizer-framework--date-picker-btn-open" data-id="<?php echo esc_attr( $this->id ); ?>">
					<i class="dashicons dashicons-calendar-alt"></i>
				</button>

				<button class="customizer-framework--date-picker-btn customizer-framework--date-picker-btn-clear" data-id="<?php echo esc_attr( $this->id ); ?>">
					<i class="dashicons dashicons-no-alt"></i>
				</button>
			</div>
		</div>

	<?php
	}
}
