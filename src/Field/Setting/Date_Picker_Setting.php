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
class Date_Picker_Setting extends Text_Setting
{
    protected string $type = 'date-picker';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        if (array_key_exists('mode', $args) && !in_array($args['mode'], $valid_values = ['single', 'range'])) {
            throw new Exception(
                sprintf("Value of `mode` must be one of %s. '%s' given", implode(', ', $valid_values), $args['mode'])
            );
        }

        if (array_key_exists('enable_time', $args) && !is_bool($args['enable_time'])) {
            throw new Exception('Expected `enable_time` to be an `boolean`. ' . gettype($args['enable_time']) . ' given in' . __CLASS__);
        }

        if ($args['mode'] === 'single' && array_key_exists('default', $args) && gettype($args['default']) !== 'string') {
            throw new Exception(
                sprintf('When `mode` is set to "single" `default` must be a `string`. Type `%s` given in %s', gettype($args['default']), __CLASS__)
            );
        }

        $this->args['mode'] = (array_key_exists('mode', $args))
            ? $args['mode']
            : 'single';


        $this->args['enable_time'] = (array_key_exists('enable_time', $args))
            ? $args['enable_time']
            : false;

        return $id;
    }
}
