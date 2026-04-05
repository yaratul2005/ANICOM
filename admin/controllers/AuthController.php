<?php
namespace Admin\Controllers;

use Core\Controller;
use Core\Auth;
use Core\Config;
use Core\Database\FileDriver;
use Core\Database\MysqlDriver;

class AuthController extends Controller
{
    private $db;

    public function __construct()
    {
        Auth::startSession();
        
        $driverName = Config::get('database.default', 'file');
        if ($driverName === 'mysql') {
            $this->db = new MysqlDriver(
                Config::get('database.connections.mysql.host'),
                Config::get('database.connections.mysql.database'),
                Config::get('database.connections.mysql.username'),
                Config::get('database.connections.mysql.password')
            );
        } else {
            $this->db = new FileDriver();
        }
    }

    public function login()
    {
        // Redirect if already secure
        if (Auth::check()) {
            header('Location: /admin/');
            exit;
        }
        
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            
            if (!Auth::verifyCsrf($_POST['csrf_token'] ?? '')) {
                $error = 'Invalid security token, please try again.';
            } elseif (!Auth::checkRateLimit($ip)) {
                $error = 'Too many attempts. You are locked out for 15 minutes for safety.';
            } else {
                $email = $_POST['email'] ?? '';
                $password = $_POST['password'] ?? '';
                
                $user = $this->db->findOne('users', ['email' => $email]);
                
                if ($user && password_verify($password, $user['password'])) {
                    Auth::recordAttempt($ip, true);
                    Auth::login($user);
                    header('Location: /admin/');
                    exit;
                } else {
                    Auth::recordAttempt($ip, false);
                    $error = 'Invalid email or password.';
                }
            }
        }
        
        // Use a unique independent render scope bypassing the main layout entirely
        extract(['title' => 'Sign In - ANICOM', 'error' => $error, 'csrf_token' => Auth::csrfToken()]);
        require __DIR__ . '/../views/login.php';
    }
    
    public function logout()
    {
        Auth::logout();
        header('Location: /admin/login');
        exit;
    }
}
