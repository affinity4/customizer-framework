<?php declare(strict_types=1);

namespace CustomizerFramework\Field\Setting;

use Exception;
use WP_Customize_Manager;

use function CustomizerFramework\is_unsigned_integer;

defined( 'ABSPATH' ) || exit;

/**
 * Base class for text fields
 *
 * @since   1.0.0
 * @version 1.0.0
 */
class Range_Setting extends Text_Setting
{
    protected string $type = 'range';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        if (array_key_exists('options', $args)) {
            $errorMsg = 'Options must contain properties `min`, `max` and `step`. Actual: %s for $s';
            if (
                !isset($args['options']->min) ||
                !isset($args['options']->max) ||
                !isset($args['options']->step)
            ) {
                throw new Exception(
                    sprintf($errorMsg, esc_attr(json_encode($args['options'])), __CLASS__)
                );
            }

            if (!is_unsigned_integer($args['options']->min)) {
                throw new Exception(
                    sprintf('Value of `min` must be an unsigned integer. Actual: %s', gettype($args['options']->min))
                );
            }

            if (!is_unsigned_integer($args['options']->max)) {
                throw new Exception(
                    sprintf('Value of `max` must be an unsigned integer. Actual: %s', gettype($args['options']->max))
                );
            }

            if (!is_unsigned_integer($args['options']->step) || (is_unsigned_integer($args['options']->step) && $args['options']->step <= 0)) {
                throw new Exception(
                    sprintf('Value of `step` must be an unsigned integer greater than 0. Actual: %s', gettype($args['options']->step))
                );
            }

            $this->args['options'] = $args['options'];
        }

        return $id;
    }
}
