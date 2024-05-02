<?php declare(strict_types=1);

namespace CustomizerFramework\Field\Setting;

use Exception;
use WP_Customize_Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Base Settings for fields with a size property
 */
class Size_Setting extends Text_Setting
{
    protected string $type = 'size';

    protected function make(WP_Customize_Manager $wp_customize, array $args): string
    {
        $id = parent::make($wp_customize, $args);

        $valid_values = ['px', 'em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', '%'];
        if (array_key_exists('units', $args)) {
            $errorMsg = 'Property `units` must be an array containing one or more of %s';
            if (!is_array($args['units'])) {
                throw new Exception(sprintf($errorMsg, json_encode($valid_values)));
            }

            foreach ($args['units'] as $unit) {
                if (!in_array($unit, $valid_values)) {
                    throw new Exception(sprintf($errorMsg, json_encode($valid_values)));
                }
            }
        }

        $this->args['units'] = (array_key_exists('units', $args)) ? $args['units'] : $valid_values;

        return $id;
    }
}
