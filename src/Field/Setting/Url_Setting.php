<?php declare(strict_types=1);

namespace CustomizerFramework\Field\Setting;

use Exception;
use WP_Customize_Manager;

defined( 'ABSPATH' ) || exit;

class Url_Setting extends Text_Setting
{
    protected string $type = 'url';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        if (array_key_exists('default', $args) && !filter_var($args['default'], FILTER_VALIDATE_URL)) {
            throw new Exception('Value of `default` must be a a valid URL!');
        }

        return $id;
    }
}
