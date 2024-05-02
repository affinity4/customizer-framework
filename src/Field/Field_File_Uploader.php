<?php

declare(strict_types=1);

namespace CustomizerFramework\Field;

defined('ABSPATH') || exit;

use CustomizerFramework\Control\File_Uploader_Control;
use CustomizerFramework\Field\Setting\Uploader_Setting;
use WP_Customize_Manager;

/**
 * Field File Uploader.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Field_File_Uploader extends Uploader_Setting
{
    /**
     * Rendering File Uploader.
     *
     * @since 1.0.0
     *
     * @param object  $wp_customize  Object from WP_Customize_Manager.
     * @param array   $args 		 List of configuration.
     */
    public function render(WP_Customize_Manager $wp_customize, $args)
    {
        $id = $this->make($wp_customize, $args);
        $wp_customize->add_control(new File_Uploader_Control($wp_customize, $id . '_field', $this->args));
    }
}
