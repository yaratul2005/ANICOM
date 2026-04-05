<?php
namespace Core;

class Cart
{
    public static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public static function add($product, $quantity = 1)
    {
        self::init();
        $id = $product['id'];
        
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$id] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }
    }

    public static function getItems()
    {
        self::init();
        return $_SESSION['cart'];
    }

    public static function getTotal()
    {
        self::init();
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += ($item['product']['price'] * $item['quantity']);
        }
        return $total;
    }

    public static function clear()
    {
        self::init();
        $_SESSION['cart'] = [];
    }
}
