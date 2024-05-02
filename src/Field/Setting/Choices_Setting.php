<?php declare(strict_types=1);

namespace CustomizerFramework\Field\Setting;

use WP_Customize_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Base class for text fields
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Choices_Setting extends Setting
{
    protected string $type = 'checkbox';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        $this->args['choices'] = (array_key_exists('choices', $args) && is_array($args['choices']))
            ? $args['choices']
            : [];

        return $id;
    }
}
