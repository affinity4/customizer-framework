<?php declare(strict_types=1);

namespace CustomizerFramework\Field;

use CustomizerFramework\Field\Setting\Choices_Setting;

defined('ABSPATH') || exit;

/**
 * Field Checkbox.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Field_Checkbox extends Choices_Setting
{
	/**
	 * Rendering Checkbox Field
	 *
	 * @access public
	 * @since 1.0.0
	 * @param object 	$wp_customize 	object from WP_Customize_Manager
	 * @param string 	$id 			slug or index id
	 * @param array  	$args
	 *
	 */
	public function render($wp_customize, $args ) {
		$id = $this->make($wp_customize, $args);
        $wp_customize->add_control($id . '_field', $this->args);
	}
}
