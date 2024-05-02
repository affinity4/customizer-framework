<?php declare(strict_types=1);

namespace CustomizerFramework\Control;

defined( 'ABSPATH' ) || exit;

use function CustomizerFramework\assets_url;

/**
 * Code Editor Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Code_Editor_Control extends \WP_Customize_Control
{
	/**
	 * Type of programming languge html, css,
	 * javascript and php are available.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $language;


	/**
	 * Adding third party libraries.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		// styles
		if ( wp_style_is( 'customizer-framework-codemirror-css', 'enqueued' ) == false ) {
			wp_enqueue_style( 'customizer-framework-codemirror-css', assets_url() . '/codemirror/lib/codemirror.css'  );
		}

		// js
		if ( wp_script_is( 'customizer-framework-codemirror-js', 'enqueued' ) == false ) {
			wp_enqueue_script( 'customizer-framework-codemirror-js', assets_url() . '/codemirror/lib/codemirror.js', array(), '1.0', true );
		}

		// modes
		if ( wp_script_is( 'customizer-framework-codemirror-htmlmixed-js', 'enqueued' ) == false ) {
			wp_enqueue_script( 'customizer-framework-codemirror-htmlmixed-js', assets_url() . '/codemirror/mode/htmlmixed/htmlmixed.js', array(), '1.0', true );
		}

		if ( wp_script_is( 'customizer-framework-codemirror-xml-js', 'enqueued' ) == false ) {
			wp_enqueue_script( 'customizer-framework-codemirror-xml-js', assets_url() . '/codemirror/mode/xml/xml.js', array(), '1.0', true );
		}

		if ( wp_script_is( 'customizer-framework-codemirror-javascript-js', 'enqueued' ) == false ) {
			wp_enqueue_script( 'customizer-framework-codemirror-javascript-js', assets_url() . '/codemirror/mode/javascript/javascript.js', array(), '1.0', true );
		}

		if ( wp_script_is( 'customizer-framework-codemirror-css-js', 'enqueued' ) == false ) {
			wp_enqueue_script( 'customizer-framework-codemirror-css-js', assets_url() . '/codemirror/mode/css/css.js', array(), '1.0', true );
		}

		if ( wp_script_is( 'customizer-framework-codemirror-clike-js', 'enqueued' ) == false ) {
			wp_enqueue_script( 'customizer-framework-codemirror-clike-js', assets_url() . '/codemirror/mode/clike/clike.js', array(), '1.0', true );
		}

		if ( wp_script_is( 'customizer-framework-codemirror-php-js', 'enqueued' ) == false ) {
			wp_enqueue_script( 'customizer-framework-codemirror-php-js', assets_url() . '/codemirror/mode/php/php.js', array(), '1.0', true );
		}
	}


	/**
	 * Render the code editor controller and display in frontend.
	 *
	 * @since 1.0.0
	 *
	 * @return html
	 */
	public function render_content() {
        echo '<pre>', var_dump([
            'label' => $this->label,
        ]), '</pre>';
	?>
		<div class="customizer-framework--code-editor-parent">
			<label>
				<?php if ( ! empty( $this->label ) ): ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $this->description ) ): ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif; ?>
			</label>

			<textarea id="customizer-framework--code-editor-input-<?php echo esc_attr( $this->id ); ?>" style="display: none"
					  name="<?php echo esc_attr( $this->id ); ?>"
					  <?php echo $this->link(); ?>><?php echo $this->value(); ?></textarea>

			<textarea id="customizer-framework--code-editor-textarea-<?php echo esc_attr( $this->id ); ?>"
					  class="customizer-framework--code-editor-textarea"
					  data-id="<?php echo esc_attr( $this->id ); ?>"
					  data-language="<?php echo esc_attr( $this->language ); ?>"></textarea>
		</div>
	<?php
	}
}
