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
class Orderable_Setting extends Text_Setting
{
    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        if (array_key_exists('order', $args) && !in_array($args['order'], $valid_values = ['asc', 'desc'])) {
            throw new Exception(
                sprintf('Value for `order` must be one of %s. %s given', $valid_values, $args['order'])
            );
        }

        $this->args['order'] = (array_key_exists('order', $args)) ? $args['order'] : 'asc';

        return $id;
    }
}
