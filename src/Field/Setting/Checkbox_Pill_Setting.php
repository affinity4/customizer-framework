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
class Checkbox_Pill_Setting extends Choices_Setting
{
    protected string $type = 'checkbox-pill';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        $this->args['style'] = (
            array_key_exists('style', $args) &&
            is_string($args['style']) &&
            in_array($args['style'], ['inline', 'list'])
        )
            ? $args['style']
            : 'list';

        return $id;
    }
}
