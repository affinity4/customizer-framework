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
class Markup_Setting extends Text_Setting
{
    protected string $type = 'markup';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        $errorMsg = 'Property `html` must be set and it must be a string for ' . __CLASS__;
        if (!array_key_exists('html', $args)) {
            throw new Exception($errorMsg);
        }

        if (array_key_exists('html', $args) && !is_string($args['html'])) {
            throw new Exception($errorMsg);
        }

        $this->args['html'] = $args['html'];

        return $id;
    }
}
