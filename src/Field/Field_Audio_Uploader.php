<?php declare(strict_types=1);

namespace CustomizerFramework\Field;

defined( 'ABSPATH' ) || exit;

use CustomizerFramework\Control\Audio_Uploader_Control;
use CustomizerFramework\Field\Setting\Audio_Uploader_Setting;
use WP_Customize_Manager;

/**
 * Field Audio Uploader.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Field_Audio_Uploader extends Audio_Uploader_Setting
{
	/**
	 * Rendering Audio Uploader
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager  $wp_customize  Object from WP_Customize_Manager.
	 * @param array   $args
	 */
	public function render(WP_Customize_Manager $wp_customize, array $args)
    {
        $id = $this->make($wp_customize, $args);
        $wp_customize->add_control(new Audio_Uploader_Control($wp_customize, $id . '_field', $this->args));
	}
}
