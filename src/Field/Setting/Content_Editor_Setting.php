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
class Content_Editor_Setting extends Text_Setting
{
    protected string $type = 'content-editor';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        $this->args['uploader'] = (array_key_exists('uploader', $args)) ? (bool) $args['uploader'] : false;

        if (array_key_exists('toolbars', $args)) {
            $valid_values = [
                'bold', 'italic', 'strikethrough', 'bullist', 'numlist', 'blockquote', 'hr', 'alignleft',
                'aligncenter', 'alignright', 'link', 'unlink', 'wp_more', 'spellchecker', 'fullscreen',
                'wp_adv', 'formatselect', 'underline', 'alignjustify', 'forecolor', 'pastetext', 'removeformat',
                'charmap', 'outdent', 'indent', 'undo', 'redo', 'wp_help'];
            $toolbars = array_unique((array) $args['toolbars']);
            foreach ($toolbars as $toolbar) {
                if (!in_array($toolbar, $valid_values)) {
                    throw new Exception(
                        sprintf("Value of `toolbars` must be one of %s. '%s' given", implode(', ', $valid_values), $toolbar)
                    );
                }
            }
            $this->args['toolbars'] = $toolbars;
        }

        return $id;
    }
}
