<?php
if (preg_match('#^/admin/?(.*)$#', $_SERVER["REQUEST_URI"])) {
    require __DIR__ . '/admin/index.php';
} else {
    require __DIR__ . '/index.php';
}
