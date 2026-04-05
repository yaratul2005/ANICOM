<?php

if (!function_exists('__')) {
    /**
     * Basic Translation Helper mapping JSON dictionaries per Theme
     */
    function __(string $string, array $replacements = []): string {
        static $dictionary = null;
        
        // Boot dictionary from the active theme ONCE per request lifecycle
        if ($dictionary === null) {
            $activeTheme = \Core\Config::get('app.active_theme', 'default');
            $langCode = env('APP_LANG', 'en');
            $dictPath = __DIR__ . '/../../themes/' . $activeTheme . '/lang/' . $langCode . '.json';
            
            if (file_exists($dictPath)) {
                $dictionary = json_decode(file_get_contents($dictPath), true) ?: [];
            } else {
                $dictionary = [];
            }
        }
        
        $translated = $dictionary[$string] ?? $string;
        
        if (!empty($replacements)) {
            foreach ($replacements as $key => $val) {
                $translated = str_replace(':' . $key, $val, $translated);
            }
        }
        
        return $translated;
    }
}
