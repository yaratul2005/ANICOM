<?php
namespace Core;

class Router
{
    private $routes = [];

    public function add($method, $path, $handler)
    {
        // Convert route path with params like {slug} to regex
        // e.g. /product/{slug} -> /product/(?P<slug>[a-zA-Z0-9_-]+)
        $regex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_-]+)', $path);
        
        $this->routes[] = [
            'method' => strtoupper($method),
            'regex'  => '#^' . $regex . '$#',
            'handler'=> $handler
        ];
    }

    public function get($path, $handler) { $this->add('GET', $path, $handler); }
    public function post($path, $handler) { $this->add('POST', $path, $handler); }
    public function put($path, $handler) { $this->add('PUT', $path, $handler); }
    public function delete($path, $handler) { $this->add('DELETE', $path, $handler); }

    public function dispatch($uri, $method)
    {
        // Normalize URI
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // Strip off base folder if running in a subfolder like /anicom path
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptDir !== '/' && $scriptDir !== '\\' && strpos($uri, $scriptDir) === 0) {
            $uri = substr($uri, strlen($scriptDir));
        }
        
        // Ensure index.php isn't captured in evaluation
        $uri = str_replace('/index.php', '', $uri);

        if ($uri === '' || $uri === false) {
            $uri = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['regex'], $uri, $matches)) {
                // Filter named groups from Regex matches
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                if (is_callable($route['handler'])) {
                    return call_user_func_array($route['handler'], $params);
                }

                if (is_array($route['handler']) && count($route['handler']) === 2) {
                    [$class, $methodName] = $route['handler'];
                    if (class_exists($class)) {
                        $instance = new $class();
                        return call_user_func_array([$instance, $methodName], $params);
                    }
                }
            }
        }
        
        // 404 Handler
        http_response_code(404);
        echo "404 Not Found";
    }
}
