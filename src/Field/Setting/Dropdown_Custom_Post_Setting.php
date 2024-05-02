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
class Dropdown_Custom_Post_Setting extends Orderable_Setting
{
    protected string $type = 'dropdown-custom-post';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        if (!array_key_exists('post_type', $args)) {
            throw new Exception('Property `post_type` is required for ' . __CLASS__);
        }

        if (empty($args['post_type'])) {
            throw new Exception('Property `post_type` cannot be empty for ' . __CLASS__);
        }

        $this->args['post_type'] = $args['post_type'];

        return $id;
    }
}
