<?php
namespace Admin\Controllers;

use Core\Controller;
use Core\Auth;

class SettingsController extends Controller
{
    private string $storePath;

    public function __construct()
    {
        Auth::requireAdmin();
        $this->storePath = __DIR__ . '/../../anicom-data/settings/store.json';
    }

    private function readSettings(): array
    {
        if (!file_exists($this->storePath)) return [];
        return json_decode(file_get_contents($this->storePath), true) ?: [];
    }

    private function writeSettings(array $data): void
    {
        $dir = dirname($this->storePath);
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        file_put_contents($this->storePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    // GET /admin/settings
    public function index()
    {
        $settings = $this->readSettings();
        $themes   = $this->getAvailableThemes();
        $this->renderAdmin('settings', [
            'title'    => 'Settings',
            'settings' => $settings,
            'themes'   => $themes,
        ]);
    }

    // POST /admin/settings
    public function save()
    {
        $current = $this->readSettings();
        $updated = array_merge($current, [
            'store_name'   => trim($_POST['store_name'] ?? ''),
            'store_url'    => trim($_POST['store_url'] ?? ''),
            'store_email'  => trim($_POST['store_email'] ?? ''),
            'timezone'     => $_POST['timezone'] ?? 'UTC',
            'currency'     => $_POST['currency'] ?? 'USD',
            'active_theme' => $_POST['active_theme'] ?? 'default',
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);
        $this->writeSettings($updated);
        header('Location: /admin/settings?saved=1');
        exit;
    }

    private function getAvailableThemes(): array
    {
        $themesDir = __DIR__ . '/../../themes/';
        $themes = [];
        if (is_dir($themesDir)) {
            foreach (scandir($themesDir) as $entry) {
                if ($entry !== '.' && $entry !== '..' && is_dir($themesDir . $entry)) {
                    $themes[] = $entry;
                }
            }
        }
        return $themes;
    }
}
