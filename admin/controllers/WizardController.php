<?php
namespace Admin\Controllers;

use Core\Controller;
use Core\Auth;
use Core\Config;
use Core\Database\FileDriver;
use Core\Database\MysqlDriver;

class WizardController extends Controller
{
    private function isInstalled()
    {
        return file_exists(__DIR__ . '/../../anicom-data/settings/installed.lock');
    }

    public function index()
    {
        if ($this->isInstalled()) {
            header('Location: /admin/');
            exit;
        }

        Auth::startSession();
        $step = (int)($_GET['step'] ?? 1);
        
        // Use a standalone minimalist wizard view outside the main layout
        extract(['title' => 'ANICOM Setup Wizard', 'step' => $step, 'data' => $_SESSION['wizard_data'] ?? []]);
        require __DIR__ . '/../views/wizard.php';
    }

    public function process()
    {
        if ($this->isInstalled()) exit;
        
        Auth::startSession();
        $step = (int)($_POST['step'] ?? 1);
        
        // Merge incoming post data sequentially into our pending session
        if (!isset($_SESSION['wizard_data'])) $_SESSION['wizard_data'] = [];
        $_SESSION['wizard_data'] = array_merge($_SESSION['wizard_data'], $_POST);

        if ($step < 10) {
            header('Location: /admin/setup?step=' . ($step + 1));
            exit;
        }

        // Final Step: Execute Installation
        $this->executeInstallation($_SESSION['wizard_data']);
        
        // Lock setup
        file_put_contents(__DIR__ . '/../../anicom-data/settings/installed.lock', date('Y-m-d H:i:s'));
        
        // Automatically log them in natively post-installation
        $db = ($this->getDbDriver($_SESSION['wizard_data']['db_engine'] ?? 'file'));
        $user = $db->findOne('users', ['email' => $_SESSION['wizard_data']['admin_email']]);
        Auth::login($user);

        header('Location: /admin/');
        exit;
    }

    private function getDbDriver($type)
    {
        if ($type === 'mysql') {
            return new MysqlDriver(
                $_SESSION['wizard_data']['db_host'] ?? '127.0.0.1',
                $_SESSION['wizard_data']['db_name'] ?? 'anicom_dev',
                $_SESSION['wizard_data']['db_user'] ?? 'root',
                $_SESSION['wizard_data']['db_pass'] ?? ''
            );
        }
        return new FileDriver();
    }

    private function executeInstallation($data)
    {
        $db = $this->getDbDriver($data['db_engine'] ?? 'file');

        // Create initial database structure for MySQL if necessary
        if ($data['db_engine'] === 'mysql') {
            $db->query("CREATE TABLE IF NOT EXISTS `users` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `email` VARCHAR(255) NOT NULL UNIQUE,
                `name` VARCHAR(255) NOT NULL,
                `password` VARCHAR(255) NOT NULL,
                `role` VARCHAR(50) DEFAULT 'admin'
            )");
        }

        // Create admin account
        $db->insert('users', [
            'email' => $data['admin_email'],
            'name'  => $data['admin_name'],
            'password' => password_hash($data['admin_password'], PASSWORD_DEFAULT),
            'role'  => 'admin'
        ]);

        // Save Store Configuration manually
        file_put_contents(__DIR__ . '/../../anicom-data/settings/store.json', json_encode([
            'name' => $data['store_name'],
            'currency' => $data['currency'],
            'timezone' => $data['timezone']
        ]));
    }
}
