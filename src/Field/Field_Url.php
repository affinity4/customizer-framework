<?php declare(strict_types=1);

namespace CustomizerFramework\Field;

defined( 'ABSPATH' ) || exit;

use CustomizerFramework\Control\Url_Control;
use CustomizerFramework\Field\Setting\Text_Setting;
use WP_Customize_Manager;

final class Field_Url extends Text_Setting
{
    protected string $type = 'url';

	/**
	 * Render field
	 *
	 * @param WP_Customize_Manager  $wp_customize   Object from WP_Customize_Manager.
	 * @param array                 $args           List of configuration.
	 */
	public function render(WP_Customize_Manager $wp_customize, array $args)
    {
        $id = $this->make($wp_customize, $args);
        $wp_customize->add_control(new Url_Control($wp_customize, $id . '_field', $this->args));
	}
}
