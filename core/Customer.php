<?php
namespace Core;

use Core\Config;
use Core\Database\FileDriver;
use Core\Database\MysqlDriver;

class Customer
{
    private static function db()
    {
        return Config::get('database.default') === 'mysql' ? new MysqlDriver() : new FileDriver();
    }

    private static function boot(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    /**
     * Register a new customer account
     * Returns [true, null] on success or [false, $errorMessage]
     */
    public static function register(array $data): array
    {
        self::boot();
        $db  = self::db();
        $email = strtolower(trim($data['email'] ?? ''));
        $name  = trim($data['name'] ?? '');
        $pass  = $data['password'] ?? '';

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [false, 'A valid email address is required.'];
        }
        if (strlen($name) < 2) {
            return [false, 'Please enter your full name.'];
        }
        if (strlen($pass) < 6) {
            return [false, 'Password must be at least 6 characters.'];
        }

        // Duplicate check
        if ($db->findOne('customers', ['email' => $email])) {
            return [false, 'An account with this email already exists.'];
        }

        $customer = [
            'id'         => uniqid('cust_'),
            'name'       => $name,
            'email'      => $email,
            'password'   => password_hash($pass, PASSWORD_BCRYPT),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $db->insert('customers', $customer);
        self::login(['email' => $email, 'password' => $pass]);

        return [true, null];
    }

    /**
     * Attempt login. Returns [true, null] or [false, $errorMessage]
     */
    public static function login(array $credentials): array
    {
        self::boot();
        $db    = self::db();
        $email = strtolower(trim($credentials['email'] ?? ''));
        $pass  = $credentials['password'] ?? '';

        $customer = $db->findOne('customers', ['email' => $email]);
        if (!$customer || !password_verify($pass, $customer['password'])) {
            return [false, 'Incorrect email or password.'];
        }

        $_SESSION['customer_id']    = $customer['id'];
        $_SESSION['customer_name']  = $customer['name'];
        $_SESSION['customer_email'] = $customer['email'];

        return [true, null];
    }

    /**
     * Destroy the customer session
     */
    public static function logout(): void
    {
        self::boot();
        unset($_SESSION['customer_id'], $_SESSION['customer_name'], $_SESSION['customer_email']);
    }

    /**
     * Return current logged-in customer data, or null
     */
    public static function current(): ?array
    {
        self::boot();
        if (empty($_SESSION['customer_id'])) return null;

        return [
            'id'    => $_SESSION['customer_id'],
            'name'  => $_SESSION['customer_name'],
            'email' => $_SESSION['customer_email'],
        ];
    }

    /**
     * Alias: is a customer logged in?
     */
    public static function check(): bool
    {
        self::boot();
        return !empty($_SESSION['customer_id']);
    }

    /**
     * Fetch all orders belonging to logged-in customer
     */
    public static function orders(): array
    {
        $customer = self::current();
        if (!$customer) return [];

        $db = self::db();
        return $db->find('orders', ['customer_email' => $customer['email']]) ?: [];
    }

    /**
     * Require the customer to be logged in; redirect if not
     */
    public static function requireLogin(string $redirect = '/account/login'): void
    {
        if (!self::check()) {
            header('Location: ' . $redirect);
            exit;
        }
    }
}
