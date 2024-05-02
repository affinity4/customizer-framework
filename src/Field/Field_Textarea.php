<?php declare(strict_types=1);

namespace CustomizerFramework\Field;

defined( 'ABSPATH' ) || exit;

use CustomizerFramework\Field\Setting\Setting;
use WP_Customize_Manager;

final class Field_Textarea extends Setting
{
	protected string $type = 'textarea';

	/**
	 * Rendering Text.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager  $wp_customize   Object from WP_Customize_Manager.
	 * @param array                 $args           List of configuration.
	 */
	public function render(WP_Customize_Manager $wp_customize, array $args)
    {
        $id = $this->make($wp_customize, $args);
        $wp_customize->add_control($id . '_field', $this->args);
	}
}
