<?php declare(strict_types=1);

namespace CustomizerFramework\Control;

defined( 'ABSPATH' ) || exit;

/**
 * Size Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Size_Control extends \WP_Customize_Control
{
	/**
	 * List of format allowed.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public array $units = [];

	/**
	 * Render the size controller and display in frontend.
	 *
	 * @since 1.0.0
	 *
	 * @return html
	 */
	public function render_content()
    {
	?>
		<div class="customizer-framework--size-parent">
			<label for="<?php echo esc_attr($this->id); ?>">
				<?php if (!empty($this->label)) : ?>
					<span class="customize-control-title">
                        <?php echo esc_html($this->label); ?>
                    </span>
				<?php endif ?>
				<?php if (!empty($this->description)) : ?>
					<span class="description customize-control-description">
                        <?php echo wp_kses_post( $this->description ) ?>
                    </span>
				<?php endif ?>
			</label>
			<input
                type="hidden"
				id="<?php echo esc_attr($this->id) ?>_hidden"
				class="customizer-framework--size"
				value="<?php echo esc_attr($this->value()) ?>"
				<?php $this->link(); ?>
            >
			<input
                type="text"
				id="<?php echo esc_attr($this->id) ?>"
				class="customizer_framework__size_field customizer-framework--size-mirror"
				value="<?php echo esc_attr($this->value()) ?>"
				placeholder="<?php echo (isset($this->input_attrs['placeholder'])) ? esc_attr( $this->input_attrs['placeholder'] ) : '' ?>"
				data-units="<?php echo esc_attr(implode(',', $this->units)) ?>"
            >
            <label for="<?php echo esc_attr($this->id) ?>_units" style="margin-top: 1rem;"><em>Select Unit</em></label>
            <select
                class="customizer_framework__size_unit_select"
                name="<?php echo esc_attr($this->id) ?>_unit"
                id="<?php echo esc_attr($this->id) ?>_units"
            >
                <?php foreach ($this->units as $unit) : ?>
                    <option value="<?php echo $unit ?>"><?php echo $unit ?></option>
                <?php endforeach ?>
            </select>
		</div>
	<?php
	}
}
