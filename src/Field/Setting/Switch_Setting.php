<?php declare(strict_types=1);

namespace CustomizerFramework\Field\Setting;

use Exception;
use WP_Customize_Manager;

defined( 'ABSPATH' ) || exit;

class Switch_Setting extends Text_Setting
{
    protected string $type = 'switch';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        if (array_key_exists('default', $args) && !is_bool($args['default'])) {
            throw new Exception('Value of `default` must be a `boolean`. Actual: ' . gettype($args['default']));
        }

        return $id;
    }
}
