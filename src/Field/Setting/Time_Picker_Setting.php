<?php declare(strict_types=1);

namespace CustomizerFramework\Field\Setting;

use Exception;
use WP_Customize_Manager;

defined( 'ABSPATH' ) || exit;

class Time_Picker_Setting extends Text_Setting
{
    protected string $type = 'time-picker';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        if (array_key_exists('default', $args) && !\CustomizerFramework\is_valid_date($args['default'], 'H:i')) {
            throw new Exception('Value of `default` must be a a valid date in format `H:i` (hours:minutes)');
        }

        $this->args['military_format'] = (array_key_exists('military_format', $args) && is_bool($args['military_format']))
            ? $args['military_format']
            : false;

        return $id;
    }
}
