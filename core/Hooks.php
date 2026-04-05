<?php
namespace Core;

class Hooks
{
    private static array $actions = [];
    private static array $filters = [];

    /**
     * Actions
     */
    public static function addAction($tag, $callback, $priority = 10)
    {
        if (!isset(self::$actions[$tag])) {
            self::$actions[$tag] = [];
        }
        self::$actions[$tag][$priority][] = $callback;
    }

    public static function doAction($tag, ...$args)
    {
        if (!isset(self::$actions[$tag])) {
            return;
        }

        ksort(self::$actions[$tag]);

        foreach (self::$actions[$tag] as $priority => $callbacks) {
            foreach ($callbacks as $callback) {
                if (is_callable($callback)) {
                    call_user_func_array($callback, $args);
                }
            }
        }
    }

    /**
     * Filters
     */
    public static function addFilter($tag, $callback, $priority = 10)
    {
        if (!isset(self::$filters[$tag])) {
            self::$filters[$tag] = [];
        }
        self::$filters[$tag][$priority][] = $callback;
    }

    public static function applyFilters($tag, $value, ...$args)
    {
        if (!isset(self::$filters[$tag])) {
            return $value;
        }

        ksort(self::$filters[$tag]);

        foreach (self::$filters[$tag] as $priority => $callbacks) {
            foreach ($callbacks as $callback) {
                if (is_callable($callback)) {
                    // Prepend the value to args before calling
                    $mergedArgs = array_merge([$value], $args);
                    $value = call_user_func_array($callback, $mergedArgs);
                }
            }
        }

        return $value;
    }
}
