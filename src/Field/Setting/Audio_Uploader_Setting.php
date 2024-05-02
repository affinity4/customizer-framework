<?php declare(strict_types=1);

namespace CustomizerFramework\Field\Setting;

defined( 'ABSPATH' ) || exit;

/**
 * Base class for text fields
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Audio_Uploader_Setting extends Uploader_Setting
{
    protected string $type = 'audio-uploader';

    protected array $valid_extensions = ['aac', 'aiff', 'alac', 'flac', 'mp3', 'ogg', 'wav', 'wma'];
}
