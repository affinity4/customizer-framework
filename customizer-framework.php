<?php
/**
 * Plugin Name:   	  Customizer Framework
 * Description:   	  The Cusomtizer Framework is a tool for WordPress Theme Developer to develop theme using WordPress Customizer API while writing clean and minimal code.
 * Author:        	  Luke Watts
 * Version:       	  1.0.0
 * Text Domain:   	  customizer-framework
 * Wordpress Version: >=6.5
 * PHP:               >=8.2
 *
 */

// Exist direct access.
defined( 'ABSPATH' ) || exit;

if (!file_exists(__DIR__ . '/autoload.php')) {
    throw new Exception("Could not find autoload.php in root of plugin");
}

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/src/helpers.php';

// Autoload Dependencies.
use CustomizerFramework\Core\Config;

// Instantiating Customizer Framework Config Class.
$customizerFrameworkConfig = new Config;

// Adding all third party libraries.
$customizerFrameworkConfig->register_enqueue();
