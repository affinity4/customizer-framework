<?php declare(strict_types=1);

namespace CustomizerFramework\Field;

defined( 'ABSPATH' ) || exit;

use CustomizerFramework\Control\Video_Uploader_Control;
use CustomizerFramework\Field\Setting\Video_Uploader_Setting;
use WP_Customize_Manager;

final class Field_Video_Uploader extends Video_Uploader_Setting
{
	/**
	 * Render
     *
	 * @param WP_Customize_Manager  $wp_customize  Object from WP_Customize_Manager.
	 * @param array   $args
	 */
	public function render(WP_Customize_Manager $wp_customize, array $args)
    {
        $id = $this->make($wp_customize, $args);
        $wp_customize->add_control(new Video_Uploader_Control($wp_customize, $id . '_field', $this->args));
    }
}
