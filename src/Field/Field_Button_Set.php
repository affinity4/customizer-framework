<?php declare(strict_types=1);

namespace CustomizerFramework\Field;

defined( 'ABSPATH' ) || exit;

use CustomizerFramework\Control\Button_Set_Control;
use CustomizerFramework\Field\Setting\Radio_Setting;
use WP_Customize_Manager;

/**
 * Field Button Set.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Field_Button_Set extends Radio_Setting
{
    protected string $type = 'button-set';

	/**
	 * Rendering Button Set.
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_Customize_Manager $wp_customize   Object from WP_Customize_Manager.
	 * @param array                 $config         List of configuration.
	 */
	public function render(WP_Customize_Manager $wp_customize, array $args)
    {
        $id = $this->make($wp_customize, $args);
        $wp_customize->add_control(new Button_Set_Control($wp_customize, $id . '_field', $this->args));
	}
}
