<?php declare(strict_types=1);

namespace CustomizerFramework\Trait;

use stdClass;

defined('ABSPATH') || exit;

trait Has_Size
{
    /**
     * The size for the list
     *
     * @var array
     */
    public $size;

    /**
     * Validate $this->size and return its default value if empty.
     *
     * @since 1.0.0
     *
     * @param  string  $type  The return type choices "width" | "height".
     * @return string
     */
    private function get_size(string $type = 'width')
    {
        $type = (strtolower($type) === 'width') ? $type : 'height'; // Ensure the type is either width or height
        $size = (isset($this->size) && $this->size instanceof stdClass)
            ? $this->size
            : (object) ['width' => '100%', 'height' => 'auto'];


        return $size->{$type};
    }
}
