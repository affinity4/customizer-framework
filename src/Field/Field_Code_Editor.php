<?php

declare(strict_types=1);

namespace CustomizerFramework\Field;

defined('ABSPATH') || exit;

use CustomizerFramework\Control\Code_Editor_Control;
use CustomizerFramework\Field\Setting\Code_Editor_Setting;
use WP_Customize_Manager;

/**
 * Field Code Editor.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Field_Code_Editor extends Code_Editor_Setting
{
    /**
     * Rendering Code Editor.
     *
     * @since 1.0.0
     *
     * @param object  $wp_customize  Object from WP_Customize_Manager.
     * @param array   $args 		 List of configuration.
     */
    public function render(WP_Customize_Manager $wp_customize, array $args)
    {
        $id = $this->make($wp_customize, $args);
        $wp_customize->add_control(new Code_Editor_Control($wp_customize, $id . '_field', $this->args));
    }
}
