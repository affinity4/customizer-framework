<?php

declare(strict_types=1);

namespace CustomizerFramework\Field;

defined('ABSPATH') || exit;

use CustomizerFramework\Control\Checkbox_Pill_Control;
use CustomizerFramework\Field\Setting\Checkbox_Pill_Setting;
use CustomizerFramework\Field\Setting\Choices_Setting;
use CustomizerFramework\Field\Settings;

/**
 * Field Checkbox Pill.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Field_Checkbox_Pill extends Checkbox_Pill_Setting
{
    /**
     * Rendering Checkbox Pill.
     *
     * @since 1.0.0
     *
     * @param object  $wp_customize  Object from WP_Customize_Manager.
     * @param array   $args 		 List of configuration.
     */
    public function render($wp_customize, $args)
    {
        $id = $this->make($wp_customize, $args);
        $wp_customize->add_control(new Checkbox_Pill_Control($wp_customize, $id . '_field', $this->args));
    }
}
