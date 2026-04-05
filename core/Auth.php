<?php
namespace Core;

class Auth
{
    private static string $rateLimitFile = __DIR__ . '/../anicom-data/settings/rate_limit.json';

    public static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'domain' => '',
                'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            session_name('ANICOM_SESSION');
            session_start();
        }
    }

    public static function checkRateLimit(string $ip): bool
    {
        if (!file_exists(self::$rateLimitFile)) {
            return true;
        }

        $limits = json_decode(file_get_contents(self::$rateLimitFile), true) ?: [];
        
        if (isset($limits[$ip])) {
            $data = $limits[$ip];
            if ($data['attempts'] >= 5 && (time() - $data['time']) < 900) {
                return false; // Lock out for 15 minutes
            }
        }
        
        return true;
    }

    public static function recordAttempt(string $ip, bool $success)
    {
        $dir = dirname(self::$rateLimitFile);
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $limits = file_exists(self::$rateLimitFile) ? json_decode(file_get_contents(self::$rateLimitFile), true) : [];
        if (!is_array($limits)) $limits = [];

        if ($success) {
            unset($limits[$ip]);
        } else {
            if (!isset($limits[$ip]) || (time() - $limits[$ip]['time']) >= 900) {
                $limits[$ip] = ['attempts' => 1, 'time' => time()];
            } else {
                $limits[$ip]['attempts']++;
                $limits[$ip]['time'] = time();
            }
        }

        file_put_contents(self::$rateLimitFile, json_encode($limits, JSON_PRETTY_PRINT));
    }

    public static function check(): bool
    {
        self::startSession();
        return isset($_SESSION['admin_user_id']);
    }

    public static function user()
    {
        self::startSession();
        return $_SESSION['admin_user'] ?? null;
    }

    public static function login(array $user)
    {
        self::startSession();
        session_regenerate_id(true); // Stop Session Fixation mapping attacks
        $_SESSION['admin_user_id'] = $user['id'];
        $_SESSION['admin_user'] = $user;
    }

    public static function logout()
    {
        self::startSession();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    public static function csrfToken(): string
    {
        self::startSession();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrf(string $token): bool
    {
        self::startSession();
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    public static function requireAdmin()
    {
        if (!self::check()) {
            header('Location: /admin/login');
            exit;
        }
    }
}
