<?php declare(strict_types=1);

namespace CustomizerFramework\Field\Setting;

use Exception;
use WP_Customize_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * customizer-framework- Settings.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Setting
{
    protected string $type = 'text';

	protected array $args = [];

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {

        if (!array_key_exists('id', $args)) {
            throw new Exception('No `id` set for field' . __CLASS__);
        }

        if (!array_key_exists('section', $args)) {
            throw new Exception('No `section` set for field' . __CLASS__);
        }

        $this->args['type'] = $this->type;
        $this->args['settings'] = $args['id'];
        $this->args['section'] = $args['section'];
        $this->args['label'] = (array_key_exists('label', $args))
            ? esc_html($args['label'])
            : '';
        $this->args['description'] = (array_key_exists('description', $args))
            ? esc_html($args['description'])
            : '';
        $this->args['priority'] = (array_key_exists('priority', $args))
            ? $args['priority']
            : 0;
        $this->args['active_callback'] = (array_key_exists('active_callback', $args))
            ? $args['active_callback']
            : fn() => true;

        $this->init_settings($wp_customize, $args);

        return $args['id'];
    }

	/**
	 * Initialize for creating settings.
	 *
	 * @since 1.0.0
	 *
	 * @param  object  $wp_customize  Class for WP_CUSTOMIZE_MANAGER.
	 * @param  array   $args 		  Set of arguments for rendering settings.
	 * @return boolean
	 */
	public function init_settings( WP_Customize_Manager $wp_customize, array $args) {
        if (array_key_exists('default', $args)) {
            $wp_customize->add_setting($args['id'], [
                'default' => $args['default']
            ]);
        } else {
            $wp_customize->add_setting($args['id']);
        }
    }
}
