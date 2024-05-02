<?php declare(strict_types=1);

namespace CustomizerFramework\Field\Setting;

defined( 'ABSPATH' ) || exit;

/**
 * Base class for text fields
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Video_Uploader_Setting extends Uploader_Setting
{
    protected string $type = 'video-uploader';

    protected array $valid_extensions = ['mp4', 'm4v',  'mov', 'wmv', 'avi', 'mpg', 'ogv', '3gp', '3g2', 'webm', 'mkv'];
}
