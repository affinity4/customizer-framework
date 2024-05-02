<?php declare(strict_types=1);

namespace CustomizerFramework\Control;

defined( 'ABSPATH' ) || exit;

use function CustomizerFramework\assets_url;

/**
 * Toggle Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Toggle_Control extends \WP_Customize_Control
{
	/**
	 * Adding third party libraries.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		// css
		if ( wp_style_is( 'customizer-framework--checkbox-css', 'enqueued' ) == false ){
			wp_enqueue_style( 'customizer-framework--checkbox-css', assets_url() . '/checkbox/checkboxes.min.css' );
		}
	}


	/**
	 * Render the toggle controller and display in frontend.
	 *
	 * @since 1.0.0
	 *
	 * @return html
	 */
	public function render_content() {
	?>
		<div class="customizer-framework--toggle-parent">
			<div class="customizer-framework--toggle-container">

				<label class="customizer-framework--toggle-label">
					<?php if ( ! empty( $this->label ) ): ?>
						<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<?php endif; ?>

					<?php if ( ! empty( $this->description ) ): ?>
						<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
					<?php endif; ?>
				</label>

				<div class="ckbx-style-12 customizer-framework--toggle">
                    <input  type="checkbox"
                    		id="<?php echo esc_attr( $this->id ); ?>"
                    		value="<?php echo esc_attr( $this->value() ); ?>"
                    		name="<?php echo esc_attr( $this->id ); ?>"
                    		<?php echo $this->link(); ?>>
                    <label for="<?php echo esc_attr( $this->id ); ?>"></label>
                </div>

			</div>
		</div>
	<?php
	}
}
