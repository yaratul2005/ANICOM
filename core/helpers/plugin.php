<?php
// Global Plugin API Helpers directly mapped to Core\Hooks Engine

if (!function_exists('add_action')) {
    function add_action($tag, $callback, $priority = 10) {
        \Core\Hooks::addAction($tag, $callback, $priority);
    }
}

if (!function_exists('do_action')) {
    function do_action($tag, ...$args) {
        \Core\Hooks::doAction($tag, ...$args);
    }
}

if (!function_exists('add_filter')) {
    function add_filter($tag, $callback, $priority = 10) {
        \Core\Hooks::addFilter($tag, $callback, $priority);
    }
}

if (!function_exists('apply_filters')) {
    function apply_filters($tag, $value, ...$args) {
        return \Core\Hooks::applyFilters($tag, $value, ...$args);
    }
}
