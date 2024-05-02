<?php

declare(strict_types=1);

namespace CustomizerFramework\Field;

defined('ABSPATH') || exit;

use CustomizerFramework\Control\Color_Set_Control;
use CustomizerFramework\Field\Setting\Color_Set_Setting;
use WP_Customize_Manager;

/**
 * Field Color Set.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Field_Color_Set extends Color_Set_Setting
{
    /**
     * Rendering Color Set.
     *
     * @since 1.0.0
     *
     * @param object  $wp_customize  Object from WP_Customize_Manager.
     * @param array   $args 		 List of configuration.
     */
    public function render(WP_Customize_Manager $wp_customize, $args)
    {
        $id = $this->make($wp_customize, $args);
        $wp_customize->add_control(new Color_Set_Control($wp_customize, $id . '_field', $this->args));
    }
}
