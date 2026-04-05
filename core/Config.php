<?php
namespace Core;

class Config
{
    private static array $items = [];
    private static bool $loaded = false;

    /**
     * Loads the .env file and all config definitions exactly once
     */
    private static function load()
    {
        if (self::$loaded) return;

        // Load .env if it exists
        $envFile = __DIR__ . '/../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) continue; // Skip comments
                
                if (strpos($line, '=') !== false) {
                    list($name, $value) = explode('=', $line, 2);
                    $name = trim($name);
                    $value = trim($value);
                    
                    if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                        putenv(sprintf('%s=%s', $name, $value));
                        $_ENV[$name] = $value;
                        $_SERVER[$name] = $value;
                    }
                }
            }
        }

        // Cache all files in /config/ folder
        $configDir = __DIR__ . '/../config/';
        if (is_dir($configDir)) {
            $files = glob($configDir . '*.php');
            if ($files !== false) {
                foreach ($files as $file) {
                    $basename = basename($file, '.php');
                    self::$items[$basename] = require $file;
                }
            }
        }
        
        self::$loaded = true;
    }

    /**
     * Fetch a configuration value using dotted notation 
     * e.g. Config::get('app.name')
     * 
     * @param string $key 
     * @param mixed $default 
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        self::load();
        
        $parts = explode('.', $key);
        $array = self::$items;

        foreach ($parts as $part) {
            if (isset($array[$part])) {
                $array = $array[$part];
            } else {
                return $default;
            }
        }
        
        return $array;
    }
}
