<?php declare(strict_types=1);

namespace CustomizerFramework\Control;

defined( 'ABSPATH' ) || exit;

/**
 * Markup Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Markup_Control extends \WP_Customize_Control
{
	/**
	 * HTML code to be displayed in front-end.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $html;


	/**
	 * Render the markup controller and display in frontend.
	 *
	 * @since 1.0.0
	 *
	 * @return html
	 */
	public function render_content() {
	?>
		<div class="customizer-framework--markup-parent">
			<?php echo $this->html; ?>
		</div>
	<?php
	}
}
