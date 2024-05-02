<?php declare(strict_types=1);

namespace CustomizerFramework\Control;

defined( 'ABSPATH' ) || exit;

/**
 * Button Set Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Button_Set_Control extends \WP_Customize_Control {

	/**
	 * Set of choices.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $choices;


	/**
	 * Returns the value of choices with sanitize.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	private function choices_value() {
		if ( ! empty( $this->choices ) ) {
			return array_unique( $this->choices );
		}
	}


	/**
	 * Return checked if the value is equal to key.
	 *
	 * @since 1.0.0
	 *
	 * @param string  $value  The current value.
	 * @param string  $key 	  Index key in foreach.
	 * @return string
	 */
	private function is_checked( $value, $key ) {
		if ( $value == $key ) {
			return "checked";
		}
	}


	/**
	 * Render the button set controller and display in frontend.
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

		<div class="customizer-framework--button-set-parent">
			<?php foreach ( $this->choices_value() as $key => $value ): ?>

					<input type="radio"
						   class="customizer-framework--button-set-radio"
					       id="customizer-framework--button-set-radio-<?php echo esc_attr( $this->id ) . '-' . esc_attr( $key ) ?>"
					       name="<?php echo esc_attr( $this->id ) ?>"
					       value="<?php echo esc_attr( $key ) ?>"
					       <?php echo $this->link() ?>
					       <?php echo $this->is_checked( $this->value(), $key ) ?>>
					<label class="customizer-framework--button-set-radio-label"
							for="customizer-framework--button-set-radio-<?php echo esc_attr( $this->id ) . '-' . esc_attr( $key ) ?>">
						<?php echo esc_attr( $value ) ?>
					</label>

			<?php endforeach; ?>
		</div>
	<?php
	}
}
