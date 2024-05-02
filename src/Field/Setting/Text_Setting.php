<?php declare(strict_types=1);

namespace CustomizerFramework\Field\Setting;

use WP_Customize_Manager;

defined( 'ABSPATH' ) || exit;

class Text_Setting extends Setting
{
    protected string $type = 'text';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        $this->args['input_attrs'] = (array_key_exists('input_attrs', $args) && is_array($args['input_attrs']))
            ? $args['input_attrs']
            : [];

        return $id;
    }
}
