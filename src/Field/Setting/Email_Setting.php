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
class Email_Setting extends Text_Setting
{
    protected string $type = 'email';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        if (!empty($args['default']) && !filter_var($args['default'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid Email in " . __CLASS__);
        }

        $this->args['input_attrs'] = (array_key_exists('input_attrs', $args) && is_array($args['input_attrs']))
            ? $args['input_attrs']
            : [];

        return $id;
    }
}
