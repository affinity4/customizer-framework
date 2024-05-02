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
class Code_Editor_Setting extends Text_Setting
{
    protected string $type = 'code-editor';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        if (!array_key_exists('language', $args)) {
            throw new Exception('Property `language` is required for ' . __CLASS__);
        }

        if (empty($args['language'])) {
            throw new Exception('Property `language` cannot be empty for ' . __CLASS__);
        }

        if (!in_array($args['language'], $valid_values = ['html', 'css', 'javascript', 'php'])) {
            throw new Exception(
                sprintf('Value for `language` must be one of %s. %s given', $valid_values, $args['language'])
            );
        }

        $this->args['language'] = $args['language'];

        return $id;
    }
}
