<?php declare(strict_types=1);

namespace CustomizerFramework\Field;

use CustomizerFramework\Field\Setting\Text_Setting;
use WP_Customize_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Field Text.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Field_Text extends Text_Setting
{
    protected string $type = 'text';

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
