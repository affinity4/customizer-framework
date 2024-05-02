<?php declare(strict_types=1);

namespace CustomizerFramework\Trait;

defined('ABSPATH') || exit;

trait Has_Direction
{
    /**
     * The direction display "row" | "column".
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $direction;

    /**
     * Validate the $this->style and get default value also.
     *
     * @since 1.0.0
     *
     * @return string
     */
    private function get_direction()
    {
        if (!empty($this->direction) && ($this->direction === 'row' || $this->direction === 'column')) {
            return $this->direction;
        }

        return 'row';
    }
}
