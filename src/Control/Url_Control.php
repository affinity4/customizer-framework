<?php declare(strict_types=1);

namespace CustomizerFramework\Control;

defined( 'ABSPATH' ) || exit;

/**
 * Url Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Url_Control extends \WP_Customize_Control
{
	/**
	 * Holds placeholder.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $placeholder;


	/**
	 * Render the url controller and display in frontend.
	 *
	 * @since 1.0.0
	 *
	 * @return html
	 */
	public function render_content() {
	?>
		<div class="customizer-framework--url-parent">
			<label>
				<?php if ( ! empty( $this->label ) ): ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $this->description ) ): ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif; ?>
			</label>

            <input  type="text"
                    id="customizer-framework--url-<?php echo esc_attr( $this->id ); ?>"
                    class="customizer-framework--url"
                    value="<?php echo esc_attr( $this->value() ); ?>"
                    name="<?php echo esc_attr( $this->id ); ?>"
                    placeholder="<?php echo esc_attr( $this->placeholder ); ?>"
                    <?php echo $this->link(); ?>>
		</div>
	<?php
	}
}
