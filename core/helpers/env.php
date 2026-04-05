<?php

if (!function_exists('env')) {
    /**
     * Get environment variable or default
     */
    function env($key, $default = null) {
        $value = getenv($key);
        
        if ($value === false) {
            return $_ENV[$key] ?? $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        // Handle quotes correctly if present
        if (preg_match('/\A([\'"])(.*)\1\z/', $value, $matches)) {
            return $matches[2];
        }

        return $value;
    }
}
