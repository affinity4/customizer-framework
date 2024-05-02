<?php declare(strict_types=1);

namespace CustomizerFramework\Control;

defined( 'ABSPATH' ) || exit;

/**
 * Checkbox Multiple Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Checkbox_Multiple_Control extends \WP_Customize_Control
{
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
	private function choices_value(): array
    {
		return (!empty($this->choices)) ? array_unique($this->choices) : [];
	}

	/**
	 * Render the checkbox multiple controller and display in frontend.
	 *
	 * @since 1.0.0
	 *
	 * @return html
	 */
	public function render_content()
    {
	?>
		<label>
			<?php if (!empty($this->label)) : ?>
				<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
			<?php endif; ?>
			<?php if (!empty($this->description)) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post($this->description); ?></span>
			<?php endif; ?>
		</label>
		<div class="customizer-framework--checkbox-multiple-parent-<?php echo esc_attr($this->id) ?>">
			<input type="hidden"
				   class="customizer-framework--checkbox-multiple-input"
				   id="<?php echo esc_attr($this->id); ?>"
				   name="<?php echo esc_attr($this->id); ?>"
				   value="<?php echo esc_attr(json_decode($this->value())); ?>"
				   <?php $this->link(); ?>>

			<?php foreach ($this->choices_value() as $key => $value) : ?>
					<label class="customizer-framework--checkbox-multiple-label">
						<input type="checkbox"
						   	   class="customizer-framework--checkbox-multiple"
						   	   name="<?php echo esc_attr($this->id) ?>"
						   	   value="<?php echo esc_attr($key) ?>"
						   	   <?php checked(in_array(esc_attr($key), json_decode($this->value()))) ?>>
						<?php echo esc_attr($value) ?>
					</label>
			<?php endforeach; ?>
		</div>
	<?php
	}
}
