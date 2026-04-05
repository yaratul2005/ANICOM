<?php

if (!function_exists('money_format_custom')) {
    /**
     * Format money gracefully based on application core settings
     */
    function money_format_custom(float $amount): string {
        // Read configuration implicitly or fallback
        $currencyCode = env('APP_CURRENCY', 'USD');
        
        switch (strtoupper($currencyCode)) {
            case 'EUR':
                return '€' . number_format($amount, 2, ',', '.');
            case 'GBP':
                return '£' . number_format($amount, 2);
            case 'JPY':
                return '¥' . number_format($amount, 0);
            case 'USD':
            default:
                return '$' . number_format($amount, 2);
        }
    }
}
