<?php declare(strict_types=1);

namespace CustomizerFramework\Field;

defined( 'ABSPATH' ) || exit;

use CustomizerFramework\Control\Markup_Control;
use CustomizerFramework\Field\Setting\Markup_Setting;
use WP_Customize_Manager;

/**
 * Field Markup.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Field_Markup extends Markup_Setting
{
	/**
	 * Rendering Markup.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager  $wp_customize  Object from WP_Customize_Manager.
	 * @param array   $args
	 */
	public function render(WP_Customize_Manager $wp_customize, array $args)
    {
        $id = $this->make($wp_customize, $args);
        $wp_customize->add_control(new Markup_Control($wp_customize, $id . '_field', $this->args));
    }
}
