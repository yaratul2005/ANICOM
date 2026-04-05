<?php
namespace Admin\Controllers;

use Core\Controller;
use Core\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        Auth::requireAdmin();
        $this->renderAdmin('dashboard', [
            'title' => 'ANICOM | Dashboard'
        ]);
    }
}
