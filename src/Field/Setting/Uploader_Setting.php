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
class Uploader_Setting extends Text_Setting
{
    protected string $type = 'file-uploader';

    protected array $valid_extensions = [
        'pdf',
        'doc',
        'docx',
        'ppt',
        'pptx',
        'pps',
        'ppsx',
        'odt',
        'xls',
        'xlsx',
        'psd'
    ];

    protected function validateExtensions(array $args)
    {
        foreach ($args['extensions'] as $extension) {
            if (!in_array($extension, $this->valid_extensions)) {
                throw new Exception(sprintf(
                    'Extension `%s` is not a valid extension for %s field. Valid extension: %s.',
                    $extension,
                    $args['id'],
                    implode(', ', $this->valid_extensions)
                ));
            }
        }
    }

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        if (!array_key_exists('extensions', $args)) {
            throw new Exception('Property `extensions` is required for' . __CLASS__);
        }

        if (!is_array($args['extensions'])) {
            throw new Exception('Expected `extensions` to be an array. ' . gettype($args['extensions']) . ' given in' . __CLASS__);
        }

        $this->validateExtensions($args);

        $this->args['extensions'] = $args['extensions'];

        return $id;
    }
}
