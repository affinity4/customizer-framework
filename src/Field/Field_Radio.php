<?php declare(strict_types=1);

namespace CustomizerFramework\Field;

defined( 'ABSPATH' ) || exit;

use CustomizerFramework\Field\Setting\Radio_Setting;
use WP_Customize_Manager;

/**
 * Field Radio.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Field_Radio extends Radio_Setting
{
	/**
	 * Rendering Radio.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager  $wp_customize  Object from WP_Customize_Manager.
     * @param array   $args
     */
    public function render(WP_Customize_Manager $wp_customize, array $args)
    {
        $id = $this->make($wp_customize, $args);
        $wp_customize->add_control($id . '_field', $this->args);
    }
}
