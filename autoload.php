<?php declare(strict_types=1);

$baseDir = dirname(__FILE__);

$classMap = [
    'CustomizerFramework\\' => $baseDir . '/src'
];

spl_autoload_register(function ($class) use ($classMap) {
    // Normalize the class name
    $class = ltrim($class, '\\');

    // Loop through the class map to find a matching namespace prefix
    foreach ($classMap as $prefix => $dir) {
        if (strpos($class, $prefix) === 0) {
            $relativeClass = substr($class, strlen($prefix));
            $filePath = $dir . '/' . str_replace('\\', '/', $relativeClass) . '.php';

            // Check if the file exists
            if (file_exists($filePath)) {
                require_once $filePath;
            }
        }
    }
});
