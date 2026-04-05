<?php
namespace Core\Controllers;

use Core\Controller;
use Core\Customer;

class AccountController extends Controller
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    // GET /account/login
    public function loginForm()
    {
        if (Customer::check()) {
            header('Location: /account');
            exit;
        }
        $this->render('account/login', ['title' => 'Login | My Account']);
    }

    // POST /account/login
    public function loginSubmit()
    {
        [$ok, $err] = Customer::login($_POST);
        if ($ok) {
            header('Location: ' . ($_SESSION['intended'] ?? '/account'));
            unset($_SESSION['intended']);
            exit;
        }
        $this->render('account/login', [
            'title' => 'Login | My Account',
            'error' => $err,
        ]);
    }

    // GET /account/register
    public function registerForm()
    {
        if (Customer::check()) {
            header('Location: /account');
            exit;
        }
        $this->render('account/register', ['title' => 'Create Account']);
    }

    // POST /account/register
    public function registerSubmit()
    {
        [$ok, $err] = Customer::register($_POST);
        if ($ok) {
            header('Location: /account');
            exit;
        }
        $this->render('account/register', [
            'title' => 'Create Account',
            'error' => $err,
            'old'   => $_POST,
        ]);
    }

    // GET /account
    public function dashboard()
    {
        Customer::requireLogin();
        $customer = Customer::current();
        $orders   = Customer::orders();
        $this->render('account/dashboard', [
            'title'    => 'My Account | ' . $customer['name'],
            'customer' => $customer,
            'orders'   => $orders,
        ]);
    }

    // GET /account/logout
    public function logout()
    {
        Customer::logout();
        header('Location: /');
        exit;
    }
}
