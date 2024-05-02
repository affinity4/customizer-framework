<?php declare(strict_types=1);

namespace CustomizerFramework\Field;

defined( 'ABSPATH' ) || exit;

use CustomizerFramework\Control\Email_Control;
use CustomizerFramework\Field\Setting\Email_Setting;
use WP_Customize_Manager;

/**
 * Field Email.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Field_Email extends Email_Setting
{
	/**
	 * Rendering Email.
	 *
	 * @since 1.0.0
	 *
	 * @param object  $wp_customize  Object from WP_Customize_Manager.
	 * @param array   $args 		 List of configuration.
	 */
	public function render(WP_Customize_Manager $wp_customize, array $args)
    {
		$id = $this->make($wp_customize, $args);
        $wp_customize->add_control(new Email_Control($wp_customize, $id . '_field', $this->args));
	}
}
