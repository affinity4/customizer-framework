<?php declare(strict_types=1);

namespace CustomizerFramework;

defined( 'ABSPATH' ) || exit;

// WP global functions
use function get_template_directory_uri;
use function get_theme_mod;
use function is_customize_preview;
use function plugin_dir_url;
use function trailingslashit;
use function wp_normalize_path;

// PHP global functions
use function array_keys;
use function array_key_exists;
use function array_push;
use function array_unique;
use function count;
use function explode;
use function filter_var;
use function gettype;
use function implode;
use function is_array;
use function is_numeric;
use function is_string;
use function json_decode;
use function sprintf;
use function strlen;
use function strpos;
use function substr;

/**
 * Return the plugin url.
 *
 * @since 1.0.0
 *
 * @return string
 */
function resource_url(): string
{
    if (strpos(wp_normalize_path(__DIR__), wp_normalize_path(WP_PLUGIN_DIR)) === 0) {
        return plugin_dir_url(__DIR__);
    }

    return trailingslashit(get_stylesheet_directory_uri());
}

/**
 * Return the URL to the Customizer Framework assets directory.
 *
 * @since 1.0.0
 *
 * @return string
 */
function assets_url(string $directory = 'customizer-framework'): string
{
    if (strpos(wp_normalize_path(__DIR__), wp_normalize_path(WP_PLUGIN_DIR)) === 0) {
        return plugin_dir_url(__DIR__) . "$directory/assets";
    }

    return get_stylesheet_directory_uri() . "/$directory/assets";
}

/**
 * Sanitize the aguments in panel, section and control.
 *
 * @since 1.0.0
 *
 * @param  string  $field    The field type.
 * @param  array   $configs  List of configurations.
 * @param  array   $rules    List of rules.
 * @return array
 */

function sanitize_argument(string $field, array $configs, array $rules): array
{
    $new_config  = $configs;
    $config_keys = array_keys( $configs );
    foreach( $rules as $key => $value ) {
        if ( ! array_key_exists( $key , $configs ) ) {
            if ( $value['rule'] == 'required' ) {
                \CustomizerFramework\alert_warning( 'Error 100: '. \CustomizerFramework\code( 'info', $key ) .' is required in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                if (!array_key_exists('choices', $configs)) {
                    $configs['choices'] = [];
                }

                if (!array_key_exists('default', $configs)) {
                    $configs['default'] = '';
                }

                if (!array_key_exists('active_callback', $configs)) {
                    $configs['active_callback'] = fn () => true;
                }

                return $configs;
            } elseif ( $value['rule'] == 'empty' ) {
                $new_config[$key] = $value['default'];
            }
        } else {
            if ( $value['type'] == 'string' ) {
                if ( empty( $configs[ $key ] ) && $value['rule'] == 'required' ) {
                    \CustomizerFramework\alert_warning( 'Error 100: '. \CustomizerFramework\code( 'info', $key ) .' is required in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                    return $configs;
                } else {
                    if ( is_string( $configs[ $key ] ) == false ) {
                        \CustomizerFramework\alert_warning( 'Error 103: '. \CustomizerFramework\code( 'info', $key ) .' must be supplied string in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                        return $configs;
                    }
                }
            } elseif ( $value['type'] == 'number' ) {
                if ( ! isset( $configs[ $key ] )  && $value['rule'] == 'required' ) {
                    \CustomizerFramework\alert_warning( 'Error 100: '. \CustomizerFramework\code( 'info', $key ) .' is required in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                    return $configs;
                } else {
                    if ( is_numeric( $configs[ $key ] ) == false ) {
                        \CustomizerFramework\alert_warning( 'Error 102: '. \CustomizerFramework\code( 'info', $key ) .' must be supplied numeric in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                        return $configs;
                    }
                }
            } elseif ( $value['type'] == 'array' ) {
                if ( empty( $configs[ $key ] ) && $value['rule'] == 'required' ) {
                    \CustomizerFramework\alert_warning( 'Error 100: '. \CustomizerFramework\code( 'info', $key ) .' is required in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                    return $configs;
                } else  {
                    if ( ! is_array( $configs[ $key ] ) ) {
                        \CustomizerFramework\alert_warning( 'Error 101: '. \CustomizerFramework\code( 'info', $key ) .' must be supplied array in '. \CustomizerFramework\code( 'success', $field ) .'.' );
                        return $configs;
                    }
                }
            } elseif ( $value['type'] == 'boolean' ) {
                if ( empty( $configs[ $key ] ) && $value['rule'] == 'required' ) {
                    \CustomizerFramework\alert_warning( 'Error 100: '. \CustomizerFramework\code( 'info', $key ) .' is required in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                    return $configs;
                } else  {
                    if ( ! is_bool( $configs[ $key ] ) ) {
                        \CustomizerFramework\alert_warning('Error 115: '. \CustomizerFramework\code( 'info', $key ) .' must be supplied boolean in '. \CustomizerFramework\code( 'success', $field ) .'.' );
                        return $configs;
                    }
                }
            }
        }
    }

    return $new_config;
}


/**
 * Checks the arguments.
 *
 * @since 1.0.0
 *
 * @param  array   $rules  List of rules.
 * @param  array   $data   Containing the data to be check.
 * @param  string  $field  The name of the field.
 * @return boolean
 */
function check_arguments(array $rules, array $data, string $field): bool
{
    if ( ! empty( $data ) ) {
        $keys = array_keys( $data );
        foreach ( $rules as $key => $value ) {
            if ( ! array_key_exists( $key, $data ) ) {
                if ( $value['rule'] == 'required' ) {
                    \CustomizerFramework\alert_warning( 'Error 100: '. \CustomizerFramework\code( 'info', $key ) .' is required in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                    return false;
                    break;
                }
            } else {
                if ( $value['type'] == 'string' ) {
                    if ( empty( $data[ $key ] ) && $value['rule'] == 'required' ) {
                        \CustomizerFramework\alert_warning( 'Error 100: '. \CustomizerFramework\code( 'info', $key ) .' is required in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                        return false;
                        break;
                    } else {
                        if ( is_string( $data[ $key ] ) == false ) {
                            \CustomizerFramework\alert_warning( 'Error 103: '. \CustomizerFramework\code( 'info', $key ) .' must be supplied string in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                            return false;
                            break;
                        }
                    }
                } elseif ( $value['type'] == 'number' ) {
                    if ( ! isset( $data[ $key ] )  && $value['rule'] == 'required' ) {
                        \CustomizerFramework\alert_warning( 'Error 100: '. \CustomizerFramework\code( 'info', $key ) .' is required in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                        return false;
                        break;
                    } else {
                        if ( is_numeric( $data[ $key ] ) == false ) {
                            \CustomizerFramework\alert_warning( 'Error 102: '. \CustomizerFramework\code( 'info', $key ) .' must be supplied numeric in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                            return false;
                            break;
                        }
                    }
                } elseif ( $value['type'] == 'array' ) {
                    if ( empty( $data[ $key ] ) && $value['rule'] == 'required' ) {
                        \CustomizerFramework\alert_warning( 'Error 100: '. \CustomizerFramework\code( 'info', $key ) .' is required in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                        return false;
                        break;
                    } else  {
                        if ( ! is_array( $data[ $key ] ) ) {
                            \CustomizerFramework\alert_warning( 'Error 101: '. \CustomizerFramework\code( 'info', $key ) .' must be supplied array in '. \CustomizerFramework\code( 'success', $field ) .'.' );
                            return false;
                            break;
                        }
                    }
                }
            }
        }

        return true;
    }
}


/**
 * Check data type errors and print a warning.
 *
 * @since 1.0.0
 *
 * @param  array   $rule  		Set of rules.
 * @param  array   $data_value  Set of data to be check.
 * @param  string  $key 		Key of the rules.
 * @param  string  $field 		Name of the field.
 * @return boolean
 */
function data_type_message_error(array $rule_value, array $data_value, string $key, string $field): bool
{
    if ( $rule_value['type'] == 'string' ) {
        if ( empty( $data_value[ $key ] ) && $rule_value['rule'] == 'required' ) {
            \CustomizerFramework\alert_warning( 'Error 100: '. \CustomizerFramework\code( 'info', $key ) .' is required in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
            return false;
        } else {
            if ( is_string( $data_value[ $key ] ) == false ) {
                \CustomizerFramework\alert_warning( 'Error 103: '. \CustomizerFramework\code( 'info', $key ) .' must be supplied string in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                return false;
            }
        }
    } elseif ( $rule_value['type'] == 'number' ) {
        if ( ! isset( $data_value[ $key ] )  && $rule_value['rule'] == 'required' ) {
            \CustomizerFramework\alert_warning( 'Error 100: '. \CustomizerFramework\code( 'info', $key ) .' is required in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
            return false;
        } else {
            if ( is_numeric( $data_value[ $key ] ) == false ) {
                \CustomizerFramework\alert_warning( 'Error 102: '. \CustomizerFramework\code( 'info', $key ) .' must be supplied numeric in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
                return false;
            }
        }
    } elseif ( $rule_value['type'] == 'array' ) {
        if ( empty( $data_value[ $key ] ) && $rule_value['rule'] == 'required' ) {
            \CustomizerFramework\alert_warning( 'Error 100: '. \CustomizerFramework\code( 'info', $key ) .' is required in field '. \CustomizerFramework\code( 'success', $field ) .'.' );
            return false;
        } else  {
            if ( ! is_array( $data_value[ $key ] ) ) {
                \CustomizerFramework\alert_warning( 'Error 101: '. \CustomizerFramework\code( 'info', $key ) .' must be supplied array in '. \CustomizerFramework\code( 'success', $field ) .'.' );
                return false;
            }
        }
    }
}


/**
 * Sanitize the arguments of settings.
 *
 * @since 1.0.0
 *
 * @param  array  $configs  Set of configuration.
 * @return boolean|array
 */
function sanitize_settings_argument(array $configs): mixed
{
    // rules for settings
    $rules = array(
        'settings'	=> array(
            'rule'		=> 'required',
            'default'	=> ''
        ),
        'default'	=> array(
            'rule'	  	=> 'optional',
            'default' 	=> ''
        ),
        'validations' => array(
            'rule'	  	=> 'optional',
            'default' 	=> ''
        )
    );
    $args = array();
    $config_keys = array_keys( $configs );
    foreach ( $rules as $key => $value ) {
        if ( ! array_key_exists( $key,  $configs ) ) {
            if ( $value['rule'] == 'required' ) {
                $error_msg = 'Error! '. $key . ' is required in creating settings.';
                return false;
            } elseif ( $value['rule'] == 'optional' ) {
                $args[ $key ] = $value['default'];
            }
        } else {
            $args[ $key ] = $configs[ $key ];
        }
    }
    return $args;
}

/**
 * Return the complete name of the field with setting.
 *
 * @since 1.0.0
 *
 * @param  string  $field    Name of the field.
 * @param  string  $setting  The setting of the field.
 * @return string
 */
function error_field_name(string $field, string $setting): string
{
    $output = $field;
    if (!empty($setting)) {
        $output = $field . ': ' . $setting;
    }

    return $output;
}

/**
 * Prints an alert message for error or warning.
 * NOTE: this will only display in customizer preview state.
 *
 * @since 1.0.0
 *
 * @param  string  $message  The error or warning message to be printed.
 */
function alert_warning(string $message): void
{
    if (is_customize_preview() ) {
        echo '<div class="customizer-framework--alert-msg" style="padding: 5px 5px; margin-bottom: 1rem; border-radius: 0.25em; color: #721c24; background: #f8d7da; border: 1px solid #f5c6cb; font-family: monospace;"><p style="font-size: 14px; margin: 0;"> <strong>[Customizer Framework] </strong> '. $message .'</p></div>';
    }
}

/**
 * Split string in to array via "|".
 *
 * @since 1.0.0
 *
 * @param  string  $string  The string to be exploded.
 * @return array
 */
function split_arr(string $string): array
{
    return explode("|", $string);
}

/**
 * Checks if the string ends with the $end_string.
 *
 * @since 1.0.0
 *
 * @param  string  $string      String to be check.
 * @param  string  $end_string  The keyword to be find in string.
 * @return boolean
 */
function ends_with(string $string, string $end_string): bool
{
    $length = strlen($end_string);
    if ($length == 0) {
        return true;
    }

    return (substr($string, -$length) === $end_string);
}

/**
 * Truncate the string without breaking words if the string is
 * longer than the set limit
 *
 * @since 1.0.0
 *
 * @param string  $string  value to check
 * @param integer  $limit   the limit character of string
 * @return string
 */
function wordwrap(string $string, int $limit): string
{
    if (!empty($string)) {
        $output = $string;
        if (strlen($string) > $limit) {
            $output = explode("\n", \CustomizerFramework\wordwrap($string, $limit));
            $output = $output[0] . '...';
        }

        return $output;
    }
}

/**
 * Inserting string inside <p> tag.
 *
 * @since 1.0.0
 *
 * @param string  $string  The string to be inserted in <p> tag.
 * @return html
 */
function p(string $string): string
{
    return '<p>'. $string .'</p>';
}

/**
 * Checking if the unit size is in valid
 *
 * @since 1.0.0
 *
 * @param array   $units  list of units provided by user
 * @param string  $field  the name of field
 * @return boolean
 */
function is_valid_unit(array $units, string $field): bool
{
    $allowed = ['px', 'em', 'ex', 'ch', 'rem', 'vw', 'vh', 'vmin', 'vmax', '%'];
    if (!empty($units) && is_array($units)) {
        $unique_units = array_unique($units);
        foreach ($unique_units as $key => $value) {
            if (!in_array($value, $allowed)) {
                \CustomizerFramework\alert_warning( 'Error 114: '. \CustomizerFramework\code( 'error', $value ) .' is invalid unit in field '. \CustomizerFramework\code( 'success', $field ) .'.' );

                return false;
                break;
            }
        }

        return true;
    }

    return false;
}

/**
 * Validate if the default value is exi in given choices.
 *
 * @since 1.0.0
 *
 * @param string|array 	$default  The default value.
 * @param array  		$chocies  The list of choices.
 * @param string  		$field 	  The target field name.
 * @return  boolean
 */
function is_valid_default(string|array $default, array $choices, string $field): bool
{
    if (!empty($default)) {
        if (gettype($default) === 'array') {
            foreach ($default as $key => $value) {
                if (!array_key_exists($value, $choices)) {
                    \CustomizerFramework\alert_warning('Error 305: default value '. \CustomizerFramework\code( 'error', $value ) .' does not exists in choices in field '. \CustomizerFramework\code( 'success', $field ) .'.');

                    return false;
                }
            }
        } else {
            if (!array_key_exists($default, $choices)) {
                \CustomizerFramework\alert_warning('Error 305: default value '. \CustomizerFramework\code( 'error', $default ) .' does not exists in choices in field '. \CustomizerFramework\code( 'success', $field ) .'.');

                return false;
            }
        }
    }
    return true;
}

/**
 * Validate the value of an arguments and display error message.
 *
 * @since 1.0.0
 *
 * @param  string 		 $args['argument'] 	the name of the argument 			| required
 * @param  string|array  $args['value']		the value of the arguments 			| required
 * @param  string|array  $args['valid']   	the valid or list of valid value 	| required
 * @param  string 		 $args['allowed']	the allowed values for argument  	| optional
 */
function is_valid_argument_value(array $args): bool
{
    if (empty($args['type'])) {
        $args['type'] = '';
    }

    if (!empty($args['value'])) {
        if (is_array( $args['value'])) {
            foreach ($args['value'] as $key => $value) {
                if ($args['type'] == 'key') {
                    // checking in array key
                    if (!array_key_exists($value, $args['valid'])) {
                        if (empty( $args['allowed'])) {
                            \CustomizerFramework\alert_warning( 'Error 305: '. $args['argument'] .' value '. \CustomizerFramework\code( 'error', $value ) .' is invalid in field '. \CustomizerFramework\code( 'success', $args['field'] ) .'.' );
                        } else {
                            \CustomizerFramework\alert_warning( 'Error 305: '. $args['argument'] .' value '. \CustomizerFramework\code( 'error', $value ) .' is invalid in field '. \CustomizerFramework\code( 'success', $args['field'] ) .'. Here are the list of valid '. \CustomizerFramework\code( 'info', $args['allowed'] ) .'.' );
                        }

                        return false;
                    }
                } else {
                    // checking in array value
                    if (!in_array($value,  $args['valid'])) {
                        if (empty($args['allowed'])) {
                            \CustomizerFramework\alert_warning( 'Error 305: '. $args['argument'] .' value '. \CustomizerFramework\code( 'error', $value ) .' is invalid in field '. \CustomizerFramework\code( 'success', $args['field'] ) .'.' );
                        } else {
                            \CustomizerFramework\alert_warning( 'Error 305: '. $args['argument'] .' value '. \CustomizerFramework\code( 'error', $value ) .' is invalid in field '. \CustomizerFramework\code( 'success', $args['field'] ) .'. Here are the list of valid '. \CustomizerFramework\code( 'info', $args['allowed'] ) .'.' );
                        }

                        return false;
                    }
                }
            }
        } else {
            if ($args['type'] === 'key') {
                // checking in array key
                if (!array_key_exists($args['value'], $args['valid'])) {
                    if (empty($args['allowed'])) {
                        \CustomizerFramework\alert_warning( 'Error 305: '. $args['argument'] .' value '. \CustomizerFramework\code( 'error', $args['value'] ) .' is invalid in field '. \CustomizerFramework\code( 'success', $args['field'] ) .'.' );
                    } else {
                        \CustomizerFramework\alert_warning( 'Error 305: '. $args['argument'] .' value '. \CustomizerFramework\code( 'error', $args['value'] ) .' is invalid in field '. \CustomizerFramework\code( 'success', $args['field'] ) .'. Here are the list of valid '. \CustomizerFramework\code( 'info', $args['allowed'] ) .'.' );
                    }

                    return false;
                }
            } else {
                // checking in array value
                if (!in_array($args['value'], $args['valid'])) {
                    if (empty( $args['allowed'])) {
                        \CustomizerFramework\alert_warning( 'Error 305: '. $args['argument'] .' value '. \CustomizerFramework\code( 'error', $args['value'] ) .' is invalid in field '. \CustomizerFramework\code( 'success', $args['field'] ) .'.' );
                    } else {
                        \CustomizerFramework\alert_warning( 'Error 305: '. $args['argument'] .' value '. \CustomizerFramework\code( 'error', $args['value'] ) .' is invalid in field '. \CustomizerFramework\code( 'success', $args['field'] ) .'. Here are the list of valid '. \CustomizerFramework\code( 'info', $args['allowed'] ) .'.' );
                    }

                    return false;
                }
            }

        }
    }

    return true;
}

/**
 * Set value with default if value is empty .
 *
 * @since 1.0.0
 *
 * @param any  $value 	 The data value.
 * @param any  $default  The default value.
 * @return any
 **/
function set_default(mixed $value, mixed $default): mixed
{
    return (empty($value) ? $default : $value);
}

/**
 * Return array key into a single imploded string.
 *
 * @since 1.0.0
 *
 * @param array  $array  Containing the key to be imploded.
 * @return string
 */
function get_keys_imploded(array $array): string
{
    $output = '';
    if (!empty($array)) {
        if (is_array($array)) {
            $output = implode(', ', array_keys($array));
        }
    }

    return $output;
}

/**
 * Validate if the date given is valid by custom format.
 *
 * @since 1.0.0
 *
 * @param string  $date    The date given.
 * @param string  $format  The format to check.
 * @return boolean
 */
function is_valid_date(string $date, string $format): bool
{
    if (!empty($date)) {
        $date_obj = \DateTime::createFromFormat( $format, $date );

        return $date_obj && $date_obj->format( $format ) == $date;
    }

    return false;
}

/**
 * Checks if the array has a duplicate value.
 *
 * @since 1.0.0
 *
 * @param array  $array  The array value to be checked.
 * @return boolean
 */
function array_has_dupes(array $array): bool
{
    return count($array) !== count(array_unique($array));
}


/**
 * Return the value for special values | SPECIAL VALUES MEANS string to be
 * exploded as array using explode().
 *
 * @since 1.0.0
 *
 * @param string  $setting  The target setting index in db.
 * @return array
 */
function get_special_values(string $setting): array
{
    $output = [];
    if (!empty($setting) && !empty($value = get_theme_mod($setting))) {
        $output = (!is_array($value))
            ? explode(',', $value)
            : $value;
    }

    return $output;
}

/**
 * Return value in array from json_encoded.
 *
 * @since 1.0.0
 *
 * @param string  $setting 	The setting index in db.
 * @return array
 */
function get_decoded_values(string $setting): array
{
    $output = [];
    if (!empty($setting) && !empty($value = get_theme_mod($setting))) {
        $output = (is_array($value))
            ? $value
            : json_decode(get_theme_mod($setting));
    }

    return $output;
}

/**
 * Push a default validation in settings.
 *
 * @since 1.0.0
 *
 * @param array  $config 			   The set of configuration.
 * @param array  $default_validations  The default validations to be pushed in configuration.
 *
 * @return array
 */
function push_default_validation(array $config, array $default_validations): array
{
    $config['validations'] = $default_validations;
    if (array_key_exists('validations', $config)) {
        foreach ($default_validations as $_ => $validation) {
            array_push($config['validations'], $validation);
        }
    }

    return $config;
}

/**
 * Return code with inline style.
 *
 * @since 1.0.0
 *
 * @param string  $type  	The type of alert or color.
 * @param string  $message  The message to be printed inside code.
 *
 * @return string
 */
function code(string $type = 'default', string $message = ''): string
{
    switch ($type) {
        case 'default':
            $background = '#d4d4d4';
            $border_color = '#9c9b9b';

            break;
        case 'info':
            $background = '#2989ec';
            $border_color = '#196dc3';

            break;
        case 'error':
            $background = '#f32b0a';
            $border_color = '#bb1f06';

            break;
        case 'success':
            $background = '#26d04b';
            $border_color = '#0c962a';

            break;
        default:
            $background = '#000000';
            $border_color = '#000000';
            break;
    }

    $template = '<code style="background: '. $background .'; padding: 4px; border-radius: 3px; color: black;border: 1px solid #'. $border_color .';" >'. $message .'</code>';

    return $template;
}

/**
 * Validating argument "choices" and displaying error message
 * Used at: "Image-Radio" and "Image-Checkbox".
 *
 * @since 1.0.0
 *
 * @param  array   $choices  The list of choices.
 * @param  string  $field 	 The target field name.
 * @return boolean
 */
function image_select_valid_choices(array $choices, string $field): bool
{
    if (empty($choices)) {
        return true;
    }

    foreach ($choices as $choice_key => $choice_value ) {
        // checking if the choice key index must supplied an array
        if (!is_array($choice_value)) {
            \CustomizerFramework\alert_warning(
                sprintf(
                    'Error %d: choices values must be supplied an array in index %s at field %s.',
                    316,
                    \CustomizerFramework\code('error', 'KEY: '. $choice_key),
                    \CustomizerFramework\code('success', $field)
                )
            );

            return false;
            break;
        } else {
            // checking if the "image" and "title" key exists in $choice_value array
            $allowed_keys = [ 'image', 'title' ];
            foreach ($allowed_keys as $key => $value) {
                if (!array_key_exists( $value, $choice_value )) {
                    \CustomizerFramework\alert_warning(sprintf(
                        'Error %d: choices value at index %s has missing %s at field %s.',
                        317,
                        \CustomizerFramework\code('error', 'KEY: '. $choice_key),
                        \CustomizerFramework\code('info', $value),
                        \CustomizerFramework\code('success', $field)
                    ));

                    return false;
                } else {
                    foreach ($choice_value as $child_key => $child_value) {
                        // checking if $child_value is empty
                        if (empty($child_value)) {
                            \CustomizerFramework\alert_warning(sprintf(
                                'Error 319: choices value at %s is required at field %s.',
                                319,
                                \CustomizerFramework\code('error', $choice_key .' > '. $child_key),
                                \CustomizerFramework\code('success', $field)

                            ));

                            return false;
                        } else {
                            // checking $child_value if not string
                            if (gettype($child_value) !== 'string') {
                                \CustomizerFramework\alert_warning(sprintf(
                                    'Error %d: choices value at %s must be supplied %s at field %s.',
                                    318,
                                    \CustomizerFramework\code('error', $choice_key .' > '. $child_key),
                                    \CustomizerFramework\code('info', 'string'),
                                    \CustomizerFramework\code('success', $field)
                                ));

                                return false;
                            }
                        }
                    }
                }
            }
        }
    }

    return true;
}

/**
 * Validating argument "size" and displaying error messages
 * Used at: "Image-Radio" and "Image-Checkbox".
 *
 * @since 1.0.0
 *
 * @param  array   $size   The set size.
 * @param  string  $field  The target field name.
 * @return boolean
 */
function image_select_valid_size(array $size, string $field): bool
{
    if (empty($size)) {
        return true;
    }

    $errorMsg = 'Error 321: size value has missing index %s at field %s.';
    $allowed_keys = ['width', 'height'];
    foreach ($allowed_keys as $key => $value ) {
        if (array_key_exists($value, $size) === false) {
            \CustomizerFramework\alert_warning(
                sprintf(
                    $errorMsg,
                    \CustomizerFramework\code('info', $value),
                    \CustomizerFramework\code('success', $field)
                )
            );

            return false;
        } else {
            foreach ($size as $key => $value) {
                if (gettype($value) !== 'string') {
                    $errorMsg = 'Error 322: size value at %s must be supplied %s at field %s.';
                    \CustomizerFramework\alert_warning(
                        sprintf(
                            $errorMsg,
                            \CustomizerFramework\code('error', $key),
                            \CustomizerFramework\code('info', 'string'),
                            \CustomizerFramework\code('success', $field)
                        )
                    );

                    return false;
                }
            }
        }
    }

    return true;
}

/**
 * Validating the attachment and displaying error message.
 *
 * @since 1.0.0
 *
 * @param string  $args['attachment']  The attachment value is either 'url' or 'attachment id'.
 * @param string  $args['field'] 	   The complete field name.
 * @param string  $args['type'] 	   The type of media 'image, video, text and others'.
 * @return boolean
 */
function is_valid_attachment(array $args): bool
{
    $errorMsg = 'Error 330: %s attachment not found or invalid %s in field %s.';
    if (!empty($args['attachment'])) {
        if (!is_array($args['attachment'])) {
            if (!filter_var( $args['attachment'], FILTER_VALIDATE_URL)) {
                if (!wp_get_attachment_url($args['attachment'])) {
                    \CustomizerFramework\alert_warning(
                        sprintf(
                            $errorMsg,
                            \CustomizerFramework\code('info', $args['type']),
                            \CustomizerFramework\code('error', 'attachment id: ' . $args['attachment']),
                            \CustomizerFramework\code('success', $args['field'])
                        )
                    );

                    return false;
                }
            }

            return true;
        }

        foreach ($args['attachment'] as $_ => $value) {
            if (! filter_var( $value, FILTER_VALIDATE_URL)) {
                if (wp_get_attachment_url($value) == false) {
                    \CustomizerFramework\alert_warning(
                        sprintf(
                            $errorMsg,
                            \CustomizerFramework\code('info', $args['type']),
                            \CustomizerFramework\code('error', 'attachment id: '. $value),
                            \CustomizerFramework\code('success', $args['field'])
                        )
                    );

                    return false;
                }
            }

            return true;
        }
    }

    return true;
}

/**
 * Returning unique array and fallback to default if array is empty.
 *
 * @since 1.0.0
 *
 * @param array  $array 	The array value.
 * @param any 	 $default  	The default fallback value.
 * @return any
 */
function unique(array $array, mixed $default): mixed
{
    $output = $default;
    if (!empty($array)) {
        $output = array_unique($array);
    }

    return $output;
}

/**
 * Check if a value is an unsigned integer.
 *
 * @param mixed $value The value to check.
 *
 * @return bool True if the value is an unsigned integer, false otherwise.
 */
function is_unsigned_integer(mixed $value): bool
{
    if (is_bool($value)) {
        return false;
    }

    if ((is_int($value) && $value >= 0)) {
        return true;
    } elseif (is_string($value) && ctype_digit($value)) {
        return true;
    }

    return false;
}
