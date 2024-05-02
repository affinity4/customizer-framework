<?php declare(strict_types=1);

namespace CustomizerFramework\Field\Setting;

use Exception;
use WP_Customize_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Base class for text fields
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Color_Set_Setting extends Setting
{
    protected string $type = 'color-set';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        if (!array_key_exists('colors', $args)) {
            throw new Exception('Property `colors` is required for ' . __CLASS__);
        }

        if (!is_array($args['colors'])) {
            throw new Exception('Property `colors` must be an array in ' . __CLASS__);
        }

        if (array_key_exists('shape', $args) && !in_array($args['shape'], $valid_values = ['square', 'circle'])) {
            throw new Exception(
                sprintf("Value of `shape` must be one of %s. '%s' given", implode(', ', $valid_values), $args['format'])
            );
        }

        $this->args['colors'] = $args['colors'];
        $this->args['shape'] = (array_key_exists('shape', $args) && is_string($args['shape']))
            ? $args['shape']
            : 'square';
        $this->args['size'] = (array_key_exists('size', $args) && is_int($args['size']))
            ? $args['size']
            : 10;

        return $id;
    }
}
