<?php
namespace Core;

class Controller
{
    /**
     * Render a view from the active theme mapped into a single layout wrapper dynamically
     */
    protected function render(string $view, array $data = [])
    {
        extract($data);
        
        $activeTheme = \Core\Config::get('app.active_theme', 'default');
        
        // Dynamic Resolution mapping exactly the specific view internally requested
        $themeViewPath = __DIR__ . '/../themes/' . $activeTheme . '/' . $view . '.php';
        $defaultViewPath = __DIR__ . '/../themes/default/' . $view . '.php';

        if (file_exists($themeViewPath)) {
            $viewPath = $themeViewPath;
        } elseif (file_exists($defaultViewPath)) {
            $viewPath = $defaultViewPath;
        } else {
            die("View {$view} not found in active or default themes.");
        }

        // Layout handling allows seamless structure wrapping
        $themeLayoutPath = __DIR__ . '/../themes/' . $activeTheme . '/layout.php';
        $defaultLayoutPath = __DIR__ . '/../themes/default/layout.php';
        
        $layoutPath = file_exists($themeLayoutPath) ? $themeLayoutPath : $defaultLayoutPath;

        ob_start();
        if (function_exists('do_action')) do_action('before_render_view', $view);
        require $viewPath;
        if (function_exists('do_action')) do_action('after_render_view', $view);
        $content = ob_get_clean();

        if (function_exists('apply_filters')) {
            $content = apply_filters('the_content', $content);
        }

        require $layoutPath;
    }
    
    /**
     * Render an Admin view
     */
    protected function renderAdmin($view, $data = [])
    {
        extract($data, EXTR_SKIP);
        $layoutFile = __DIR__ . '/../admin/views/layout.php';
        $viewFile = __DIR__ . '/../admin/views/' . $view . '.php';
        
        if (file_exists($layoutFile)) {
            ob_start();
            if (file_exists($viewFile)) {
                require $viewFile;
            } else {
                echo "Admin view '$view' not found.";
            }
            $content = ob_get_clean();

            require $layoutFile;
        } else {
            if (file_exists($viewFile)) {
                require $viewFile;
            } else {
                echo "Admin view '$view' not found.";
            }
        }
    }
}
