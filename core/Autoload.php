<?php
/**
 * Load global helpers
 */
require_once __DIR__ . '/helpers/env.php';
require_once __DIR__ . '/helpers/plugin.php';
require_once __DIR__ . '/helpers/formatting.php';
require_once __DIR__ . '/helpers/translate.php';
require_once __DIR__ . '/Hooks.php'; // Preload explicit Hooks class locally

/**
 * Custom PSR-4 Autoloader
 */
spl_autoload_register(function ($class) {
    // Top-level namespace mappings relative to the root directory
    $namespaceMap = [
        'Core\\'   => 'core/',
        'Admin\\'  => 'admin/',
    ];

    foreach ($namespaceMap as $prefix => $dir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        $relativeClass = substr($class, $len);
        $file = __DIR__ . '/../' . $dir . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require $file;
            return true;
        }
    }
    
    return false;
});

/**
 * Boot Active Plugins Framework
 */
$pluginsDir = __DIR__ . '/../plugins/';
if (is_dir($pluginsDir)) {
    foreach (glob($pluginsDir . '*', GLOB_ONLYDIR) as $pluginPath) {
        $pluginBootstrap = $pluginPath . '/plugin.php';
        if (file_exists($pluginBootstrap)) {
            require_once $pluginBootstrap;
        }
    }
}
