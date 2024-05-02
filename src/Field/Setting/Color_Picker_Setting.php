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
class Color_Picker_Setting extends Setting
{
    protected string $type = 'color-picker';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        if (!array_key_exists('format', $args)) {
            throw new Exception('Property `format` is required for ' . __CLASS__);
        }

        if (!in_array($args['format'], $valid_values = ['hex', 'rgba'])) {
            throw new Exception(
                sprintf("Value of `format` must be one of %s. '%s' given", implode(', ', $valid_values), $args['format'])
            );
        }

        $this->args['format'] = $args['format'];
        $this->args['opacity'] = (array_key_exists('opacity', $args) && is_numeric($args['opacity']))
            ? $args['opacity']
            : 1;

        return $id;
    }
}
