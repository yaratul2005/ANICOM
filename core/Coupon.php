<?php
namespace Core;

use Core\Config;
use Core\Database\FileDriver;
use Core\Database\MysqlDriver;

class Coupon
{
    private static function db()
    {
        return Config::get('database.default') === 'mysql' ? new MysqlDriver() : new FileDriver();
    }

    /**
     * Validate and return a coupon record, or null if invalid
     */
    public static function validate(string $code): ?array
    {
        $db = self::db();
        $coupon = $db->findOne('coupons', ['code' => strtoupper(trim($code)), 'active' => 1]);

        if (!$coupon) {
            return null;
        }

        // Expiry check
        if (!empty($coupon['expires_at']) && strtotime($coupon['expires_at']) < time()) {
            return null;
        }

        // Usage limit check
        if (!empty($coupon['usage_limit']) && (int)($coupon['used_count'] ?? 0) >= (int)$coupon['usage_limit']) {
            return null;
        }

        return $coupon;
    }

    /**
     * Calculate discount amount from a coupon against a subtotal
     */
    public static function calculateDiscount(array $coupon, float $subtotal): float
    {
        if ($coupon['type'] === 'percent') {
            return round($subtotal * ((float)$coupon['value'] / 100), 2);
        }

        if ($coupon['type'] === 'fixed') {
            return min((float)$coupon['value'], $subtotal);
        }

        return 0.0;
    }

    /**
     * Increment used_count after a successful order
     */
    public static function redeem(string $code): void
    {
        $db = self::db();
        $coupon = $db->findOne('coupons', ['code' => strtoupper(trim($code))]);
        if ($coupon) {
            $used = (int)($coupon['used_count'] ?? 0) + 1;
            $db->update('coupons', $coupon['id'], ['used_count' => $used]);
        }
    }

    /**
     * Apply coupon to session cart state; returns [discount, error]
     */
    public static function applyToSession(string $code): array
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $coupon = self::validate($code);
        if (!$coupon) {
            return [0.0, 'Coupon code is invalid or has expired.'];
        }
        $_SESSION['coupon'] = $coupon;
        return [self::calculateDiscount($coupon, \Core\Cart::getTotal()), null];
    }

    /**
     * Remove coupon from session
     */
    public static function removeFromSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        unset($_SESSION['coupon']);
    }

    /**
     * Get currently applied session coupon (or null)
     */
    public static function getSessionCoupon(): ?array
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return $_SESSION['coupon'] ?? null;
    }
}
